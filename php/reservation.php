<?php
session_start();

if (!$_SESSION["customer_logged_in"])
{
    echo "Unauthorized access";
    exit;
}

$id = $_SESSION["id"];
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Reservation Page</title>
        <link rel="stylesheet" href="../css/reservation.css">
        <script src="../javascript/reservation.js"></script>
    </head>
    <body>
        <main>
            <div class="container" id="<?php echo $id ?>">
                <form id="reservation-form">
                    <div class="form-item">
                        <label for="date">Reservation Date</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <div class="form-item">
                        <label for="num-guests">Number of Guests</label>
                        <input type="number" id="num-guests" name="num-guests" min="0" max="9" required>
                    </div>
                    <button id="submit">Search for available timeslots</button>
                </form>
                <button id="return-button"><img src="../images/return_icon.svg"></button>
            </div>
        </main>
    </body>
</html>
