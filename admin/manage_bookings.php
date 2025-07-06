<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

include '../backend/db.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage_bookings.php");
    exit();
}

$stmt = $conn->prepare("SELECT bookings.*, 
    u1.name AS user_name, 
    u2.name AS photographer_name 
    FROM bookings 
    JOIN users u1 ON bookings.user_id = u1.id 
    JOIN users u2 ON bookings.photographer_id = u2.id");
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Bookings | Admin - JayaClicks</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="main signup-page">
    <div class="navbar">
        <div class="icon"><h2 class="logo">JayaClicks</h2></div>
        <div class="menu">
            <ul>
                <li><a href="manage_users.php">Users</a></li>
                <li><a href="manage_photos.php">Photos</a></li>
                <li><a href="manage_bookings.php">Bookings</a></li>
                <li><a href="../backend/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="content">
        <h1>Manage <span>Bookings</span></h1>
        <div class="gallery">
            <?php foreach ($bookings as $b): ?>
                <div style="margin:10px; padding:10px; background:black; border:1px solid #ff7200; border-radius:8px;">
                    <strong style="color:#ff7200;">User: <?php echo $b['user_name']; ?></strong><br>
                    <span>Booked: <?php echo $b['photographer_name']; ?></span><br>
                    <span>Date: <?php echo $b['date_booked']; ?></span><br>
                    <a href="?delete=<?php echo $b['id']; ?>"><button class="btn">Delete</button></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

</body>
</html>
