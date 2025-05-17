<?php 
session_start();

if (!isset($_POST['email'], $_POST['password'])) {
    header("Location: ../login.php");
    exit;
}
    
# Database Connection File
include "../db_conn.php";
# Validation helper function
include "func-validation.php";
# Validation helper function
include "func-auth.php";

$email = trim($_POST['email']);
$password = $_POST['password'];

# simple form validation
is_empty($email, "Email", "../login.php", "error", "");
is_empty($password, "Password", "../login.php", "error", "");

// 1. Try admin
if ($user = tryLogin($conn, 'admin', $email, $password)) {
    $_SESSION['user_id']    = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['role']       = 'admin';
    header("Location: ../admin.php");
    exit;
}

// 2. Try regular user
if ($user = tryLogin($conn, 'users', $email, $password)) {
    $_SESSION['user_id']    = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['role']       = 'user';
    header("Location: ../store.php");
    exit;
}	

// 3. Failed all checks
$em = "Incorrect email or password";
header("Location: ../login.php?error=" . urlencode($em));
exit;

	//---


    // # search for the email
    // $sql = "SELECT * FROM admin 
    //         WHERE email=?";
    // $stmt = $conn->prepare($sql);
    // $stmt->execute([$email]);

    // # if the email is exist
    // if ($stmt->rowCount() === 1) {
    // 	$user = $stmt->fetch();

    // 	$user_id = $user['id'];
    // 	$user_email = $user['email'];
    // 	$user_password = $user['password'];
    // 	if ($email === $user_email) {
    // 		if (password_verify($password, $user_password)) {
    // 			$_SESSION['user_id'] = $user_id;
    // 			$_SESSION['user_email'] = $user_email;
    // 			header("Location: ../admin.php");
    // 		}else {
    // 			# Error message
    // 	        $em = "Incorrect User name or password";
    // 	        header("Location: ../login.php?error=$em");
    // 		}
    // 	}else {
    // 		# Error message
    // 	    $em = "Incorrect User name or password";
    // 	    header("Location: ../login.php?error=$em");
    // 	}
    // }else{
    // 	# Error message
    // 	$em = "Incorrect User name or password";
    // 	header("Location: ../login.php?error=$em");
    // }