<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

include '../backend/db.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("SELECT filename FROM photos WHERE id = ?");
    $stmt->execute([$id]);
    $photo = $stmt->fetch();
    if ($photo) {
        unlink("../uploads/" . $photo['filename']);
        $stmt = $conn->prepare("DELETE FROM photos WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: manage_photos.php");
    exit();
}

$stmt = $conn->prepare("SELECT photos.*, users.name AS photographer FROM photos JOIN users ON photos.user_id = users.id");
$stmt->execute();
$photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Photos | Admin - JayaClicks</title>
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
        <h1>Manage <span>Photos</span></h1>
        <div class="gallery">
            <?php foreach ($photos as $photo): ?>
                <div style="margin:10px; padding:10px; background:black; border:1px solid #ff7200; border-radius:8px;">
                    <img src="../uploads/<?php echo $photo['filename']; ?>" width="200" style="border-radius:8px;"><br>
                    <strong style="color:#ff7200;"><?php echo $photo['title']; ?></strong><br>
                    <span>By: <?php echo $photo['photographer']; ?></span><br>
                    <span>Price: $<?php echo $photo['price']; ?></span><br>
                    <a href="?delete=<?php echo $photo['id']; ?>"><button class="btn">Delete</button></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

</body>
</html>
