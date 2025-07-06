<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $portfolio_title = $_POST['portfolio_title'] ?? null;

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Email already exists!'); window.location.href='../html/signup.html';</script>";
        exit();
    }

    $sql = "INSERT INTO users (role, name, email, password, portfolio_title) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$role, $name, $email, $password, $portfolio_title]);

    echo "<script>alert('Registration Successful! Login Now'); window.location.href='../index.php';</script>";
    exit();
}
?>
