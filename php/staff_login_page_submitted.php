<?php
    session_start();
    $API_URL = "http://localhost:80/RestaurantManagementSystem/api/staff_auth_api.php";
    $data = $_POST;
    $options = [
        "http" => [
            "header" => "Content-type: application/x-www-form-urlencoded",
            "method" => "POST",
            "content" => http_build_query($data)
        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($API_URL, false, $context);
    $result = json_decode($result, true);

    $login_succeed = $result["message"];
    if ($login_succeed)
    {
        $name = $result["name"];
        $id = $result["id"];

        $_SESSION["staff_logged_in"] = true;
        $_SESSION["name"] = $name;
        $_SESSION["id"] = $id;

        $role = $result["role"];

        switch ($role)
        {
            case "Waiter":
                header("Location: reservation_management.php");
                break;
            default:
                header("Location: not_implemented.php");
        }
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="../css/staff_login_page.css">
        <script src="../javascript/staff_login_page.js"></script>
        <title>Login</title>
    </head>
    <body>
        <main>
            <div id="container">
                <h2>Login</h2>
                <form action="staff_login_page_submitted.php" method="POST">
                    <p id="warning">Wrong ID or Password!</p>
                    <div class="form-item">
                        <label for="id">Work ID</label>
                        <input type="text" id="id" name="id" placeholder="Enter your work id" required>
                    </div>
                    <div class="form-item">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit">Login</button>
                </form>
                <button id="return-button"><img src="../images/return_icon.svg"></button>
            </div>
        </main>
</body>
</html>