<?php
    $API_URL = "http://localhost:80/RestaurantManagementSystem/api/customer_auth_api.php";
    $data = $_POST;
    $data["action"] = "REGISTER";
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
    $register_succeed = $result["message"];

    if ($register_succeed)
    {
        header("Location: customer_register_succeed.php");
        exit;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Registration Form</title>
    <link rel="stylesheet" href="../css/customer_register_page.css">
    <script src="../javascript/customer_register_page.js"></script>
</head>
<body>
    <div id="container">
        <form action="customer_register_page_submitted.php" method="POST">

            <h2>User Registration Form</h2>
            <h2 id="warning">Account already exists!</h2>
            <div class="form-item">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-item">
                <label for="surname">Surname</label>
                <input type="text" id="surname" name="surname" required>
            </div> 
            <div class="form-item">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-item">
                <label for="telephone">Telephone</label>
                <input type="text" id="telephone" name="telephone" required>
            </div>
            <div class="form-item">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <button id="return-button"><img src="../images/return_icon.svg"></button>
    </div>
</body>
</html>