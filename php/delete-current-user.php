<?php  
session_start();

# If the user is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# Database Connection File
	include "../db_conn.php";

		$id = $_SESSION['user_id'];

		
            # DELETE the category from Database
            if ($_SESSION['role'] == 'admin') {
                $sql  = "DELETE FROM admin
                         WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res  = $stmt->execute([$id]);
            } else {
                $sql  = "DELETE FROM users
                         WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res  = $stmt->execute([$id]);
            }


			/**
		      If there is no error while 
		      Deleting the data
		    **/
		     if ($res) {
                session_unset();
                session_destroy();
                
                header("Location: ../login.php");
	            exit;
			 }else {
			 	$em = "Error Occurred!";
			    header("Location: ../index.php?error=$em");
                exit;
			 }
             
		
	

}else{
  header("Location: ../login.php");
  exit;
}