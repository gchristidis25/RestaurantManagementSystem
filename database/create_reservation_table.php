<?php
include_once("config.php");

$create_reservation_table_sql = "CREATE TABLE Reservation (
    ReservationID INT PRIMARY KEY AUTO_INCREMENT,
    AccountID INT,
    NumberOfGuests INT,
    Reservation_date DATE,
    Start_time TIME,
    End_time TIME,
    Reservation_notes TEXT,
    Status VARCHAR(255),
    FOREIGN KEY (AccountID) REFERENCES Customer(AccountID)
);";

$restaurant_db->query($create_reservation_table_sql);

$populate_reservation_table_sql = "INSERT INTO Reservations (AccountID, NumberOfGuests, Reservation_date, Start_time, End_time, Reservation_notes, Status) VALUES
(1, 3, '2025-06-01', '09:30:00', '12:30:00', 'Birthday party for Alice', 'Confirmed'),
(2, 5, '2025-06-01', '09:30:00', '12:30:00', 'Team building event', 'Pending'),
(3, 7, '2025-06-01', '09:30:00', '12:30:00', 'Yoga class reservation', 'Denied'),
(4, 4, '2025-06-02', '13:00:00', '15:00:00', 'Birthday lunch reservation', 'Confirmed'),
(5, 6, '2025-06-03', '10:00:00', '11:30:00', 'Conference room booking for project review', 'Pending'),
(6, 5, '2025-06-04', '16:00:00', '18:00:00', 'Community meetup event', 'Confirmed'),
(7, 4, '2025-06-05', '08:00:00', '10:00:00', 'Early morning strategy session', 'Denied'),
(8, 8, '2025-06-06', '17:00:00', '19:00:00', 'Birthday celebration for John', 'Confirmed'),
(1, 3, '2025-06-07', '11:00:00', '13:00:00', 'Reservation for workshop', 'Pending'),
(2, 1, '2025-06-07', '11:00:00', '13:00:00', 'Birthday surprise setup', 'Confirmed');";

$restaurant_db->query($populate_reservation_table_sql);

