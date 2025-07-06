<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['photo']) && $_SESSION['role'] == 'photographer') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];

    $fileName = basename($_FILES["photo"]["name"]);
    $targetDir = "../uploads/";
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    $allowedTypes = array('jpg','png','jpeg','gif');

    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
            $stmt = $conn->prepare("INSERT INTO photos (user_id, title, filename, price) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user_id, $title, $fileName, $price]);

            echo "<script>alert('Photo uploaded successfully!'); window.location.href='../dashboards/photographer.php';</script>";
        } else {
            echo "<script>alert('Upload failed. Try again.'); window.location.href='../dashboards/photographer.php';</script>";
        }
    } else {
        echo "<script>alert('Only JPG, PNG, JPEG, GIF files allowed.'); window.location.href='../dashboards/photographer.php';</script>";
    }
} else {
    echo "<script>alert('Unauthorized or invalid request.'); window.location.href='../index.php';</script>";
}
?>
