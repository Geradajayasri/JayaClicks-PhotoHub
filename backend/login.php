<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['role'] = $user['role'];

    // ✅ Add this line here to debug role
    error_log("Logged in as: " . $user['role']);

    // // Redirect based on role
    // if ($user['role'] == 'admin') {
    //     header("Location: ../dashboards/admin.php");
    //     exit();
    // } elseif ($user['role'] == 'photographer') {
    //     header("Location: ../dashboards/photographer.php");
    //     exit();
    // } elseif ($user['role'] == 'user') {
    //     header("Location: ../dashboards/user.php");
    //     exit();
    // }
}


    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];

        if ($user['role'] == 'photographer') {
            header("Location: ../dashboards/photographer.php");
        } elseif ($user['role'] == 'user') {
            header("Location: ../dashboards/user.php");
        } elseif ($user['role'] == 'admin') {
            header("Location: ../dashboards/admin.php");
        }
        exit();
    } else {
        echo "<script>alert('Invalid Email or Password!'); window.location.href='../index.php';</script>";
    }
}
?>
