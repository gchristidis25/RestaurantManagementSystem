<?php
include_once("config.php");

$create_staff_table_sql = "CREATE TABLE Staff (
    StaffID INT PRIMARY KEY AUTO_INCREMENT,
    Staff_name VARCHAR(255),
    Staff_surname VARCHAR(255),
    Staff_email VARCHAR(255),
    Staff_telephone VARCHAR(255),
    Workhours INT,
    Work_experience INT,
    Staff_role VARCHAR(255),
    Staff_password VARCHAR(255)
);";

$restaurant_db->query($create_staff_table_sql);

$populate_staff_table_sql = "INSERT INTO Staff (Staff_name, Staff_surname, Staff_email, Staff_telephone, Workhours, Work_experience, Staff_role, Staff_password) VALUES
    ('Carmen', 'Berzatto', 'carmen@thebear.com', '555-0100', 50, 12, 'Chef', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
    ('Sydney', 'Adamu', 'sydney@thebear.com', '555-0101', 48, 5, 'Chef', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
    ('Richard', 'Jerimovich', 'richie@thebear.com', '555-0102', 45, 7, 'Waiter', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
    ('Tina', 'Mora', 'tina@thebear.com', '555-0103', 42, 15, 'Chef', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
    ('Marcus', 'Brooks', 'marcus@thebear.com', '555-0104', 40, 3, 'Chef', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
    ('Ebraheim', 'Abadi', 'ebraheim@thebear.com', '555-0105', 38, 10, 'Chef', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
    ('Natalie', 'Berzatto', 'sugar@thebear.com', '555-0106', 35, 8, 'Administrator', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
    ('Gary', 'Smith', 'gary@thebear.com', '555-0107', 44, 6, 'Dishwasher', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
    ('Neil', 'Fak', 'fak@thebear.com', '555-0108', 40, 9, 'Waiter', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
    ('Luca', 'Moretti', 'luca@thebear.com', '555-0109', 50, 20, 'Chef', '" . password_hash('1234', PASSWORD_DEFAULT) . "');";

$restaurant_db->query($populate_staff_table_sql);