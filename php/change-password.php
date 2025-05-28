<?php  
session_start();

if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	include "../db_conn.php";

	$user_id = $_SESSION['user_id'];
	$current = $_POST['current_password'] ?? '';
	$new     = $_POST['new_password'] ?? '';
	$confirm = $_POST['confirm_password'] ?? '';

	if (empty($current) || empty($new) || empty($confirm)) {
		$em = "All fields are required!";
		header("Location: ../change-password.php?error=$em");
		exit;
	}

	if ($new !== $confirm) {
		$em = "New passwords do not match!";
		header("Location: ../change-password.php?error=$em");
		exit;
	}

	$table = ($_SESSION['role'] == 'admin') ? 'admin' : 'users';

	$sql = "SELECT password FROM $table WHERE id=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$user_id]);

	if ($stmt->rowCount() === 1) {
		$row = $stmt->fetch();
		$storedPassword = $row['password'];

		if (password_verify($current, $storedPassword)) {
			$hashed = password_hash($new, PASSWORD_DEFAULT);

			$sql = "UPDATE $table SET password=? WHERE id=?";
			$stmt = $conn->prepare($sql);
			$updated = $stmt->execute([$hashed, $user_id]);

			if ($updated) {
				$sm = "Password changed successfully!";
				header("Location: ../change-password.php?success=$sm");
				exit;
			} else {
				$em = "Something went wrong!";
				header("Location: ../change-password.php?error=$em");
				exit;
			}
		} else {
			$em = "Current password is incorrect!";
			header("Location: ../change-password.php?error=$em");
			exit;
		}
	} else {
		$em = "User not found!";
		header("Location: ../change-password.php?error=$em");
		exit;
	}

} else {
	header("Location: ../login.php");
	exit;
}
    