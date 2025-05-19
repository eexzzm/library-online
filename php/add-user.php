<?php
require_once '../db_conn.php';
# Validation helper function
include "func-validation.php";

session_start();

if (isset($_POST['full_name'], $_POST['email'], $_POST['password'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // validation empty form 
	$text = "Full Name";
	$location = "../register.php";
	$ms = "error";
    is_empty($full_name, $text, $location, $ms, "");

	$text = "Email";
	$location = "../register.php";
	$ms = "error";
    is_empty($email, $text, $location, $ms, "");

    $text = "Password";
	$location = "../register.php";
	$ms = "error";
    is_empty($password, $text, $location, $ms, "");

    // Check if email already exists
    $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $emailExists = $stmt->fetchColumn();

    if ($emailExists > 0) {
        $em = "Email is already registered!";
        header("Location: ../register.php?error=$em");
        exit;
    }

    // Hash the password using bcrypt
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute([$full_name, $email, $hashedPassword]);
		$sm = "Successfully registered!";
		header("Location: ../login.php?success=$sm");
        // $em = "Incorrect User name or password";
    	// header("Location: ../login.php?error=$em");
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
