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

function get_reservations($db, $customer_id, $status)
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

switch ($method)
{
    case "POST":
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

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
        break;
    case "GET":
        $action = $_GET['action'];
        if ($action === "MAX_CAPACITY")
        {
            $guest_max_capacity = get_guest_max_capacity();
            echo json_encode(["max_capacity" => $guest_max_capacity]);
        }
        else if ($action === "RESERVATIONS")
        {
            $customer_id = $_GET["customerID"];
            $pending_reservations = get_reservations($restaurant_db, $customer_id, "Pending");
            $confirmed_reservations = get_reservations($restaurant_db, $customer_id, "Confirmed");
            echo json_encode(["pending" => $pending_reservations, "confirmed" => $confirmed_reservations]);
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
        echo json_encode(["error" => "Method not allowed"]);
        break;
}