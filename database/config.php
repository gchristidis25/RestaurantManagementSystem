<?php
$databaseHost = "localhost";
$databaseUsername = "root";
$databasePassword = "";
$databaseName = "restaurant_management_system";

$restaurant_db = new mysqli($databaseHost, $databaseUsername, $databasePassword);

$create_database_sql = "CREATE DATABASE IF NOT EXISTS $databaseName";
$restaurant_db->query($create_database_sql);

$restaurant_db->select_db($databaseName);