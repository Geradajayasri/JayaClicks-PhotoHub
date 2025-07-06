<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['photo_id']) && isset($_SESSION['user_id'])) {
    $photo_id = $_POST['photo_id'];
    $user_id = $_SESSION['user_id'];

    // Prevent duplicate bookings
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = ? AND photo_id = ?");
    $stmt->execute([$user_id, $photo_id]);

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('You have already booked this photo.'); window.location.href='../dashboards/user.php';</script>";
        exit();
    }

    // Insert booking
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, photo_id) VALUES (?, ?)");
    if ($stmt->execute([$user_id, $photo_id])) {
        echo "<script>alert('Booking successful!'); window.location.href='../dashboards/user.php';</script>";
    } else {
        echo "<script>alert('Booking failed.'); window.location.href='../dashboards/user.php';</script>";
    }
} else {
    echo "<script>alert('Unauthorized access.'); window.location.href='../index.php';</script>";
}
?>
