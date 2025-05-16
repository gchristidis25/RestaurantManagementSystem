<?php
require_once("../database/config.php");
header("Content-Type: application/json");
$method = $_SERVER["REQUEST_METHOD"];

function get_correct_password($db, $id)
{
    $stmt = $db->prepare("SELECT Staff_password FROM Staff WHERE StaffID = ?");
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $correct_password = $row["Staff_password"];
    return $correct_password;
}

function get_registered_ids($db)
{
    $stmt = $db->prepare("SELECT StaffID FROM Staff");
    $stmt->execute();
    $result = $stmt->get_result();
    $registered_ids = [];

    while ($row = $result->fetch_assoc()) {
        $registered_ids[] = $row['StaffID'];
    }

    return $registered_ids;
}

function get_staff_name($db, $id)
{
    $stmt = $db->prepare("SELECT Staff_name FROM Staff WHERE StaffID = ?");
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $name = $row["Staff_name"];
    return $name;
}

function get_staff_role($db, $id)
{
    $stmt = $db->prepare("SELECT Staff_role FROM Staff WHERE StaffID = ?");
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $role = $row["Staff_role"];
    return $role;
}

switch ($method)
{
    case "POST":
        $opts = array("http" => array("header" => "User-Agent:MyAgent/1.0\r\n"));
        $context = stream_context_create($opts);
        $data = $_POST;
        $id = trim($data["id"]);
        $password = trim($data["password"]);
        $registered_ids = get_registered_ids($restaurant_db);

        if (in_array($id, $registered_ids))
            {  
                $correct_password = get_correct_password($restaurant_db, $id);
                if (password_verify($password, $correct_password))
                {   
                    $name = get_staff_name($restaurant_db, $id);
                    $role = get_staff_role($restaurant_db, $id);
                    echo json_encode(["message" => true, "name" => $name, "role" => $role, "id" => $id]);
                    exit;
                }
            }
        echo json_encode(["message" => false, "id" => $id, "password" => $password]);
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;
}