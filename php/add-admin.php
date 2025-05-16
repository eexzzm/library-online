<?php
require_once '../db_conn.php'; // adjust path as needed
session_start();

if (isset($_POST['full_name'], $_POST['email'], $_POST['password'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($full_name) || empty($email) || empty($password)) {
        $_SESSION['message'] = "All fields are required.";
        header("Location: ../register.php");
        exit;
    }

    // Hash the password using bcrypt
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO admin (full_name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute([$full_name, $email, $hashedPassword]);
        $_SESSION['message'] = "Admin registered successfully!";
        header("Location: ../login.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
        header("Location: ../register.php");
        exit;
    }
} else {
    $_SESSION['message'] = "Invalid form submission.";
    header("Location: ../register.php");
    exit;
}
