<!DOCTYPE html>
<html>
    <head>
        <title>The Bear Restaurant</title>
        <link rel="stylesheet" href="../css/customer_main_page.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.core.min.css">
        <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
        <script src="../javascript/customer_main_page.js"></script>
    </head>
    <body>
        <div class="modal-backdrop" id="loginModal">
            <div class="modal">
                <h2>Please select a profile</h2>
                <button class="staff-btn" id="staff-login-btn">Staff</button>
                <button class="customer-btn" id="customer-login-btn">Customer</button>
            </div>
        </div>
        <header>
            <div id="logo-container">
                <a href="https://en.wikipedia.org/wiki/The_Bear_(TV_series)"><img id="logo" src="../images/bear_logo.png" alt="Bear logo"></a>
            </div>
            <nav>
                <button id="login-button">Login</button>
                <button id="register-button">Register</button>
            </nav>
        </header>
        <main>
            <h2>Chicago, IL</h2>
            <h2>Family. Fire. Food.</h2>
            <h1>Welcome to The Bear.</h1>
            <p class="introduction">
                A neighborhood spot built on chaos, love, and the relentless pursuit of excellence.
                We’re not perfect — not even close — but every plate we serve carries heart, hustle, and heritage.
                Born from tradition, forged in pressure.
            </p>
            <p class="introduction">We’re here to cook. To care. To feed.</p>
            <div class="glide">
                <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left" data-glide-dir="<">«</button>
                    <button class="glide__arrow glide__arrow--right" data-glide-dir=">">»</button>
                </div>

                <div class="glide__bullets" data-glide-el="controls[nav]">
                    <button class="glide__bullet" data-glide-dir="=0"></button>
                    <button class="glide__bullet" data-glide-dir="=1"></button>
                    <button class="glide__bullet" data-glide-dir="=2"></button>
                </div>

                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        <li class="glide__slide"><img src="../images/slider_1.jpg" alt="Slider Photo" /></li>
                        <li class="glide__slide"><img src="../images/slider_2.jpg" alt="Slider Photo" /></li>
                        <li class="glide__slide"><img src="../images/slider_3.jpg" alt="Slider Photo" /></li>
                    </ul>
                </div>
            </div>
        </main>
    </body>
</html>