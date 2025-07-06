<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

include '../backend/db.php';

// Delete user
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage_users.php");
    exit();
}

// Fetch all users (except admins)
$stmt = $conn->prepare("SELECT * FROM users WHERE role != 'admin'");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users | Admin - JayaClicks</title>
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
        <h1>Manage <span>Users</span></h1>
        <div class="gallery">
            <?php foreach ($users as $user): ?>
                <div style="margin:10px; padding:10px; background:black; border:1px solid #ff7200; border-radius:8px;">
                    <strong style="color:#ff7200;"><?php echo $user['name']; ?></strong><br>
                    <span><?php echo $user['email']; ?></span><br>
                    <span>Role: <?php echo $user['role']; ?></span><br>
                    <a href="?delete=<?php echo $user['id']; ?>"><button class="btn">Delete</button></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

</body>
</html>
