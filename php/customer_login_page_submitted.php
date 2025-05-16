<?php
    session_start();
    $API_URL = "http://localhost:80/RestaurantManagementSystem/api/customer_auth_api.php";
    $data = $_POST;
    $data["action"] = "LOGIN";
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


    $name = $result["name"];
    $id = $result["id"];
    $login_succeed = $result["message"];
    if ($login_succeed)
    {
        $_SESSION["user_logged_in"] = true;
        $_SESSION["name"] = $name;
        header("Location: customer_dashboard.php");
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="../css/customer_login_page.css">
        <script src="../javascript/customer_login_page.js"></script>
        <title>Login</title>
    </head>
    <body>
        <main>
            <div id="container">
                <h2>Login</h2>
                <p id="warning">Wrong Email or Password!</p>
                <form action="customer_login_page_submitted.php" method="POST">
                    <div class="form-item">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
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