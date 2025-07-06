<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard | JayaClicks</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="main signup-page">
        <div class="navbar">
            <div class="icon">
                <h2 class="logo">JayaClicks</h2>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="#">Hello, <?php echo $name; ?></a></li>
                    <li><a href="../backend/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>

        <div class="content">
            <h1>Admin <span>Dashboard</span></h1>
            <p class="par">Manage users, bookings, uploads, and more!</p>

            <div class="gallery">
                <a href="../admin/manage_users.php"><button class="btn">Manage Users</button></a>
                <a href="../admin/manage_photos.php"><button class="btn">Manage Photos</button></a>
                <a href="../admin/manage_bookings.php"><button class="btn">Manage Bookings</button></a>
            </div>
        </div>
    </div>
</body>
</html>
