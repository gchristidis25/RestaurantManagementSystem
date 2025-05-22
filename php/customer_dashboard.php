<?php
session_start();

if (!$_SESSION["customer_logged_in"])
{
    echo "Unauthorized access";
    exit;
}

$name = $_SESSION["name"];
$id = $_SESSION["id"];
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Customer Dashboard</title>
        <link rel="stylesheet" href="../css/customer_dashboard.css">
        <script src="../javascript/customer_dashboard.js"></script>
    </head>
    <body>
        <header>
            <h2 class="customer-info" id="<?php echo $id ?>">
            <?php echo "Welcome, " . $name ?>
            </h2>
            <div class="button-group">
                <button id="reservation-button">Make Reservation</button>
                <button id="logout-button">Logout</button>
            </div>
        </header>
        <main>
            <div class="content">
                <section>
                    <h2>About Us</h2>
                    <p>Welcome to <b>The Bear</b>, where chaos meets precision and love is in every plate.
                    Born from the spirit of community and a relentless pursuit of excellence, our kitchen is a family—messy, loud, passionate.
                    </p>
                </section>
                <section>
                    <h2>Our Philosophy</h2>
                    <p>We believe in food that tells a story. Simple ingredients, executed with care.
                    No pretense, just dedication to the craft and the people who walk through our door.
                    Every dish has a purpose.
                    </p>
                </section>
                <section>
                    <h2>Chef's Note</h2>
                    <p>“Every second counts. Every detail matters. This isn’t just a restaurant — it’s a chance to make something real.
                        Welcome to The Bear.” – Chef Carmy</p>
                </section>
            </div>
        </main>
    </body>
</html>