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
        <header>
        <a href="https://en.wikipedia.org/wiki/The_Bear_(TV_series)"><img id="logo" src="../img/bear_logo.png" alt="Bear logo"></a>
        <nav>
            <button id="login-button">Login</button>
            <button id="register-button">Register</button>
        </nav>
    <main>
        <h2>Chicago, IL</h2>
        <h2>Family. Fire. Food.</h2>
        <p id="introduction">
            Welcome to The Bear.
            A neighborhood spot built on chaos, love, and the relentless pursuit of excellence.
            We’re not perfect — not even close — but every plate we serve carries heart, hustle, and heritage.
            Born from tradition, forged in pressure. We’re here to cook. To care. To feed.
        </p>
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
                    <li class="glide__slide"><img src="../img/med_1.jpg" alt="Mediterranean location" /></li>
                    <li class="glide__slide"><img src="../img/med_2.jpg" alt="Mediterranean location" /></li>
                    <li class="glide__slide"><img src="../img/alumni_1.jpg" alt="Alumni photo" /></li>
                </ul>
            </div>
        </div>
    </main>
    </header>
    </body>
</html>