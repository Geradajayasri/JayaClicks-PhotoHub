<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'photographer') header("Location: dashboards/photographer.php");
    elseif ($_SESSION['role'] == 'user') header("Location: dashboards/user.php");
    elseif ($_SESSION['role'] == 'admin') header("Location: dashboards/admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | JayaClicks</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
        <div class="navbar">
            <div class="icon">
                <h2 class="logo">JayaClicks</h2>
            </div>
            <div class="menu">
                <ul>
                    
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="about.html">ABOUT</a></li>
                    <li><a href="service.html">SERVICE</a></li>
                    <li><a href="design.html">DESIGN</a></li>
                    <li><a href="contact.html">CONTACT</a></li>
                </ul>
                
            </div>
            <div class="search">
                <input class="srch" type="search" placeholder="Type To Text">
                <a href="#"><button class="btn">Search</button></a>
            </div>
        </div>

        <div class="content">
            <h1>Discover & <br><span>Showcase</span> <br>Stunning Photography</h1>
            <p class="par">Join a community where photographers share their finest shots 
            <br>and art lovers explore captivating visuals from around the world.</p>

            <button class="cn"><a href="signup.html">EXPLORE NOW</a></button>

            <div class="form">
                <h2>Login Here</h2>
                <form action="backend/login.php" method="POST">
                    <input type="email" name="email" placeholder="Enter Email Here" required>
                    <input type="password" name="password" placeholder="Enter Password Here" required>
                    <button class="btnn" type="submit">Login</button>
                </form>

                <p class="link">Don't have an account?<br>
                <a href="signup.html">Sign up here</a></p>
                <p class="liw">Log in with</p>

                <div class="icons">
                    <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-google"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-skype"></ion-icon></a>
                </div>
            </div>
        </div>
    </div>

<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
</body>
</html>
