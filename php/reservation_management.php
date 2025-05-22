<?php
session_start();

if (!$_SESSION["staff_logged_in"])
{
    echo "Unauthorized access";
    exit;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Reservation Management System</title>
        <link rel="stylesheet" href="../css/reservation_management.css">
        <script src="../javascript/reservation_management.js"></script>
    </head>
    <body>
        <header>
            <h2>Reservations</h2>
            <input type="date" id="date">
            <select id="timeslot">
                <option value="">Select timeslot</option>
                <option value="09:30:00">09:30</option>
                <option value="13:00:00">13:00</option>
                <option value="16:00:00">16:00</option>
                <option value="20:00:00">20:00</option>
            </select>
            <select id="status">
                <option value="">Select status</option>
                <option value="Pending">Pending</option>
                <option value="Confirmed">Confirmed</option>
                <option value="Denied">Denied</option>
            </select>
            <button id="query-button"><img src="../images/query_icon.svg"></button>
            <button id="logout-button"><img src="../images/logout_icon.svg"></button>
            </header>
        <main>
            <h3 id=capacity></h3>
        </main>
    </body>
