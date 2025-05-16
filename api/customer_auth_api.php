<?php
require_once("../database/config.php");
header("Content-Type: application/json");
$method = $_SERVER["REQUEST_METHOD"];

function get_registered_emails($db)
{
    $stmt = $db->prepare("SELECT Customer_email FROM Customer");
    $stmt->execute();
    $result = $stmt->get_result();
    $registered_emails = [];

    while ($row = $result->fetch_assoc()) {
        $registered_emails[] = $row['Customer_email'];
    }

    return $registered_emails;
}

function get_correct_password($db, $email)
{

    $stmt = $db->prepare("SELECT Customer_password FROM Customer WHERE Customer_email = ?");
    $stmt->bind_param("s", $email); 
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $correct_password = $row["Customer_password"];
    return $correct_password;
}

function get_customer_name($db, $email)
{
    $stmt = $db->prepare("SELECT Customer_name FROM Customer WHERE Customer_email = ?");
    $stmt->bind_param("s", $email); 
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $name = $row["Customer_name"];
    return $name;
}

function insert_new_customer($db, $name, $surname, $email, $telephone, $password)
{
    $stmt = $db->prepare("INSERT INTO Customer (Customer_name, Customer_surname, Customer_email, Customer_telephone, Customer_password) 
                          VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $surname, $email, $telephone, $password);
    $stmt->execute();
}

function get_customer_id($db, $email)
{
    $stmt = $db->prepare("SELECT AccountID FROM Customer WHERE Customer_email = ?");
    $stmt->bind_param("s", $email); 
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $id = $row["AccountID"];
    return $id;
}

switch ($method)
{
    case "POST":
        $action = $_POST['action'] ?? '';
        $opts = array("http" => array("header" => "User-Agent:MyAgent/1.0\r\n"));
        $context = stream_context_create($opts);
        $data = $_POST;

        $email = $data["email"];
        $password = $data["password"];
        $registered_emails = get_registered_emails($restaurant_db);
        if ($action === "REGISTER")
        {
            if (!in_array($email, $registered_emails))
            {
                $name = $data["name"];
                $surname = $data["surname"];
                $telephone = $data["telephone"];
                $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
                insert_new_customer($restaurant_db, $name, $surname, $email, $telephone, $encrypted_password);
                echo json_encode(["message" => true]);
            }
            else
            {
                echo json_encode(["message" => false]);
            }
        }
        else //login
        {
            if (in_array($email, $registered_emails))
            {
                $correct_password = get_correct_password($restaurant_db, $email);

                if (password_verify($password, $correct_password))
                {   
                    $name = get_customer_name($restaurant_db, $email);
                    $id = get_customer_id($restaurant_db, $email);
                    echo json_encode(["message" => true, "name" => $name, "id" => $id]);
                    exit;
                }
            }
            echo json_encode(["message" => false]);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;
}