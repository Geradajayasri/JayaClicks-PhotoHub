<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'photographer') {
    header("Location: ../index.php");
    exit();
}

include '../backend/db.php';

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

$stmt = $conn->prepare("SELECT * FROM photos WHERE user_id = ?");
$stmt->execute([$user_id]);
$photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Photographer Dashboard | JayaClicks</title>
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
                    <li><a href="#">Welcome, <?php echo $name; ?></a></li>
                    <li><a href="../backend/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>

        <div class="content">
            <h1>Your <span>Gallery</span></h1>

            <div class="form" style="height: 400px;">
                <h2>Upload Photo</h2>
                <form action="../backend/upload_photo.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="title" placeholder="Photo Title" required>
                    <input type="number" name="price" placeholder="Price ($)" required>
                    <input type="file" name="photo" accept="image/*" required>
                    <button class="btnn" type="submit">Upload</button>
                </form>
            </div>

            <h2 style="margin-top: 30px;">Uploaded Photos:</h2>
            <div class="gallery">
                <?php foreach ($photos as $photo): ?>
                    <div style="margin:10px; border:1px solid #ff7200; padding:10px; border-radius:8px; background:black;">
                        <img src="../uploads/<?php echo $photo['filename']; ?>" width="200" style="border-radius:8px;"><br>
                        <strong style="color:#ff7200;"><?php echo $photo['title']; ?></strong><br>
                        <span>$<?php echo $photo['price']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
