<?php  
session_start();

# If the user is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# Database Connection File
	include "../db_conn.php";


    /** 
	  check if author 
	  name is submitted
	**/
	if (isset($_POST['user_name']) &&
        isset($_POST['user_id'])) {
		/** 
		Get data from POST request 
		and store them in var
		**/
		$name = $_POST['user_name'];
		$id = $_POST['user_id'];

		#simple form Validation
		if (empty($name)) {
			$em = "The username is required";
			header("Location: ../admin-edit-user.php?error=$em&id=$id");
            exit;
		}else {
			# UPDATE the Database
			$sql  = "UPDATE users 
			         SET full_name=?
			         WHERE id=?";
			$stmt = $conn->prepare($sql);
			$res  = $stmt->execute([$name, $id]);

			/**
		      If there is no error while 
		      inserting the data
		    **/
		     if ($res) {
		     	# success message
		     	$sm = "Successfully updated!";
				header("Location: ../admin-edit-user.php?success=$sm&id=$id");
	            exit;
		     }else{
		     	# Error message
		     	$em = "Unknown Error Occurred!";
				header("Location: ../admin-edit-user.php?error=$em&id=$id");
	            exit;
		     }
		}
	}else {
      header("Location: ../admin.php");
      exit;
	}

}else{
  header("Location: ../login.php");
  exit;
}