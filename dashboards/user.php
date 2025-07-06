<?php if (isset($_GET['success'])): ?>
    <script>alert("Successfully Booked!");</script>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <script>alert("Booking failed. Please try again.");</script>
<?php endif; ?>



<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit();
}

include '../backend/db.php';

$name = $_SESSION['name'];

$stmt = $conn->prepare("SELECT photos.*, users.name AS photographer FROM photos JOIN users ON photos.user_id = users.id WHERE users.role = 'photographer'");
$stmt->execute();
$photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Dashboard | JayaClicks</title>
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
            <h1>Explore <span>Photographers</span></h1>
            <p class="par">Browse through stunning works uploaded by talented photographers.</p>

            <div class="gallery">
                <?php foreach ($photos as $photo): ?>
                    <div style="margin:10px; border:1px solid #ff7200; padding:10px; border-radius:8px; background:black;">
    <img src="../uploads/<?php echo $photo['filename']; ?>" width="200" style="border-radius:8px;"><br>
    <strong style="color:#ff7200;"><?php echo $photo['title']; ?></strong><br>
    <span>By: <?php echo $photo['photographer']; ?></span><br>
    <span>Price: $<?php echo $photo['price']; ?></span>

    <!-- ✅ Booking Form Starts -->
    <!-- <form action="../backend/bookings.php" method="POST" style="margin-top:10px;">
        <input type="hidden" name="photo_id" value="<?php echo $photo['id']; ?>">
        <button class="btnn" type="submit">Book Now</button>
    </form> -->
    <form action="../backend/book.php" method="POST">
    <input type="hidden" name="photo_id" value="<?php echo $photo['id']; ?>">
    <input type="hidden" name="photographer_id" value="<?php echo $photo['user_id']; ?>">
    <button type="submit" class="btnn">Book Now</button>
</form>

    <!-- ✅ Booking Form Ends -->
</div>

                    <!-- <div style="margin:10px; border:1px solid #ff7200; padding:10px; border-radius:8px; background:black;">
                        <img src="../uploads/<?php echo $photo['filename']; ?>" width="200" style="border-radius:8px;"><br>
                        <strong style="color:#ff7200;"><?php echo $photo['title']; ?></strong><br>
                        <span>By: <?php echo $photo['photographer']; ?></span><br>
                        <span>Price: $<?php echo $photo['price']; ?></span>
                    </div> -->
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
