<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $photoId = $_POST['photo_id'];
    $photographerId = $_POST['photographer_id'];

    // Optional: check for duplicate bookings if needed
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, photo_id, photographer_id, date_booked) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$userId, $photoId, $photographerId]);
       header("Location: ../dashboards/user.php?success=1");
    exit();
} else {
    header("Location: ../dashboards/user.php?error=1");
    exit();

//     header("Location: ../dashboards/user.php");
//     exit();
// } else {
//     echo "Invalid request.";
}
?>
