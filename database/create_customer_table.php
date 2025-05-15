<?php
include_once("config.php");

$create_customer_table_sql = "CREATE TABLE IF NOT EXISTS Customer (
    AccountID INT PRIMARY KEY AUTO_INCREMENT ,
    Customer_name VARCHAR(255) NOT NULL,
    Customer_surname VARCHAR(255) NOT NULL,
    Customer_email VARCHAR(255) NOT NULL,
    Customer_telephone VARCHAR(255),
    Customer_password VARCHAR(255) NOT NULL
)";

$restaurant_db->query($create_customer_table_sql);

$populate_customer_table_sql = "INSERT INTO Customer (Customer_name, Customer_surname, Customer_email, Customer_telephone, Customer_password) VALUES
('John', 'Doe', 'john.doe@example.com', '1234567890', '" . password_hash('password123', PASSWORD_DEFAULT) . "'),
('Jane', 'Smith', 'jane.smith@example.com', '0987654321', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
('Alice', 'Johnson', 'alice.j@example.com', '1112223333', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
('Bob', 'Brown', 'bob.brown@example.com', '4445556666', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
('Charlie', 'Davis', 'charlie.d@example.com', '7778889999', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
('Diana', 'Miller', 'diana.m@example.com', '1122334455', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
('Ethan', 'Moore', 'ethan.m@example.com', '2233445566', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
('Fiona', 'Taylor', 'fiona.t@example.com', '3344556677', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
('George', 'Wilson', 'george.w@example.com', '4455667788', '" . password_hash('1234', PASSWORD_DEFAULT) . "'),
('Hannah', 'Anderson', 'hannah.a@example.com', '5566778899', '" . password_hash('1234', PASSWORD_DEFAULT) . "');
";

$restaurant_db->query($populate_customer_table_sql);