<?php
require_once("../database/config.php");
header("Content-Type: application/json");
$method = $_SERVER["REQUEST_METHOD"];

// this information should come from the Table Management API
$GUEST_MAX_CAPACITY = 20;

function get_current_capacity($db, $date)
{
    $stmt = $db->prepare("SELECT NumberOfGuests FROM Reservation WHERE Reservation_date = ?");
    $stmt->bind_param("s", $date); 
    $stmt->execute();
    $result = $stmt->get_result();
    $guests = [];

    while ($row = $result->fetch_assoc()) {
        $guests[] = $row['NumberOfGuests'];
    }

    return array_sum($guests) ?? 0;
}

function create_new_reservation(
    $db, $id, $num_of_guests, $date, $start_time, $end_time, $reservation_details
) 
{
    $status = "Pending";
    $stmt = $db->prepare("INSERT INTO Reservation 
        (AccountID, NumberOfGuests, Reservation_date, Start_time, End_time, Reservation_notes, Status) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("iisssss", $id, $num_of_guests, $date, $start_time, $end_time, $reservation_details, $status);
    $stmt->execute();
}

function get_guest_max_capacity()
{
    global $GUEST_MAX_CAPACITY;
    return $GUEST_MAX_CAPACITY;
}

// start time must be HH:MM:SS format
function get_capacity_in_timeslot($db, $date, $start_time)
{
    $stmt = $db->prepare("SELECT SUM(NumberOfGuests) AS Capacity FROM Reservation 
        WHERE Reservation_date = ? 
        AND Start_time = ?;");
        $stmt->bind_param("ss", $date, $start_time); 
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row["Capacity"] ?? 0;
}

function get_reservations_by_customer($db, $customer_id, $status)
{
    $stmt = $db->prepare("SELECT * FROM Reservation WHERE AccountID = ? AND Status = ? ORDER BY Reservation_date ASC");
    $stmt->bind_param("is", $customer_id, $status);
    $stmt->execute();
    $result = $stmt->get_result();
    $confirmed_reservations = [];

    while ($row = $result->fetch_assoc()) {
        $confirmed_reservations[] = $row;
    }
    
    return $confirmed_reservations;
}

function get_waiter_reservations($db, $date, $timeslot, $status)
{
    $stmt = $db->prepare("SELECT Reservation.ReservationID, Customer.Customer_name, Customer.Customer_surname, NumberOfGuests, Reservation_notes
    FROM Reservation
    JOIN Customer ON Reservation.AccountID = Customer.AccountID
    WHERE Reservation_date = ? AND Start_time = ? AND Status = ?");
    $stmt->bind_param("sss", $date, $timeslot, $status);
    $stmt->execute();
    $result = $stmt->get_result();
    $reservations = [];

    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }

    return $reservations;
}

function update_status($db, $reservation_id, $new_status) {
    $stmt = $db->prepare("UPDATE Reservation SET Status = ? WHERE ReservationID = ?");
    $stmt->bind_param("si", $new_status, $reservation_id);
    $stmt->execute();
}

switch ($method)
{
    case "POST":
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        if (isset($data["method"]) && $data["method"] === "PATCH") // Updating the status od a reservation
        {
        $reservation_id = $data["id"];
        $new_status = $data["status"];
        update_status($restaurant_db, $reservation_id, $new_status);
        echo json_encode(["message" => "Reservation status updated."]);
        }
        else // Creating a new reservation
        {
            $customer_id = $data["customerID"];
            $number_of_guests = $data["numberGuests"];
            $date = $data["date"];
            $start_time = $data["startTime"];
            $end_time = $data["endTime"];
            $reservation_details = $data["reservationDetails"];

            create_new_reservation(
                $restaurant_db, $customer_id, $number_of_guests, $date,
                $start_time, $end_time, $reservation_details
            );
        }
        break;
    case "GET": 
        $action = $_GET['action'];
        if ($action === "MAX_CAPACITY") // get the max capacity of the floor in a specific timeslot
        {
            $guest_max_capacity = get_guest_max_capacity();
            echo json_encode(["max_capacity" => $guest_max_capacity]);
        }
        else if ($action === "CUSTOMER_RESERVATIONS") // Get the reservations of a customer
        {
            $customer_id = $_GET["customerID"];
            $pending_reservations = get_reservations_by_customer($restaurant_db, $customer_id, "Pending");
            $confirmed_reservations = get_reservations_by_customer($restaurant_db, $customer_id, "Confirmed");
            echo json_encode(["pending" => $pending_reservations, "confirmed" => $confirmed_reservations]);
        }
        else if ($action === "WAITER_RESERVATIONS") // Get the reservations of a specific day, timeslot, status for the Reservation Management System
        {
            $date = $_GET["date"];
            $timeslot = $_GET["timeslot"];
            $status = $_GET["status"];

            $reservations = get_waiter_reservations($restaurant_db, $date, $timeslot, $status);
            echo json_encode(["reservations" => $reservations]);
        }
        else 
        {
            $date = $_GET['date'];
            $capacity_timeslot_930 = get_capacity_in_timeslot($restaurant_db, $date, "09:30:00");
            $capacity_timeslot_13 = get_capacity_in_timeslot($restaurant_db, $date, "13:00:00");
            $capacity_timeslot_16 = get_capacity_in_timeslot($restaurant_db, $date, "16:00:00");
            $capacity_timeslot_20 = get_capacity_in_timeslot($restaurant_db, $date, "20:00:00");
            echo json_encode(
                ["09:30" => $capacity_timeslot_930,
                 "13:00" => $capacity_timeslot_13,
                 "16:00" => $capacity_timeslot_16,
                 "20:00" => $capacity_timeslot_20
            ]);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "gdfg not allowed"]);
        break;
}