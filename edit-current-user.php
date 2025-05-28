<?php  
session_start();
require_once "php/access.php";
requireRole(['admin','user']);

# If the user is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	$id = $_SESSION['user_id'];

	# Database Connection File
	include "db_conn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Profile</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="index.php">Online Library</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" 
		         id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link active" 
		             aria-current="page" 
		             href="index.php">Store</a>
		        </li>
		        <li class="nav-item">
		          <?php if ($_SESSION['role'] == 'admin') {?>
		          	<a class="nav-link" 
		             href="admin.php">Admin</a>
		          <?php }else{ ?>
		          <?php } ?>	
		      </ul>

			  <!-- Right-aligned user dropdown -->
      			<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      			  <?php if (isset($_SESSION['user_name'])) { ?>
      			    <li class="nav-item dropdown">
      			      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      			        <?php echo htmlspecialchars($_SESSION['user_name']); ?>
      			      </a>
      			      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
      			        <li><a class="dropdown-item" href="edit-profile.php">Edit Profile</a></li>
      			        <li><hr class="dropdown-divider"></li>
      			        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
      			      </ul>
      			    </li>
      			  <?php } ?>
      			</ul>
				
    		  </ul>
		    </div>
		  </div>
		</nav>
     <form action="php/edit-current-user.php"
           method="post" 
           class="shadow p-4 rounded mt-5"
           style="width: 90%; max-width: 50rem;">

     	<h1 class="text-center pb-5 display-4 fs-3">
     		Profile
     	</h1>
     	<?php if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger" role="alert">
			  <?=htmlspecialchars($_GET['error']); ?>
		  </div>
		<?php } ?>
		<?php if (isset($_GET['success'])) { ?>
          <div class="alert alert-success" role="alert">
			  <?=htmlspecialchars($_GET['success']); ?>
		  </div>
		<?php } ?>
     	<div class="mb-3">
		    <label class="form-label">
		           	Username
		           </label>

		     <input type="text" 
		            value="<?=$_SESSION['user_id'] ?>" 
		            hidden
		            name="user_id">


		    <input type="text" 
		           class="form-control"
		           value="<?=$_SESSION['user_name'] ?>" 
		           name="user_name">
		</div>

		<div class="d-flex justify-content-between">
			<button type="submit" 
					class="btn btn-primary">
					Update</button>
				
					<div>
						

						<a href="change-password.php" class="text-decoration-none">Change Password</a>
						|
						<a href="php/delete-current-user.php" class="text-decoration-none text-danger" data-bs-toggle="modal" data-bs-target="#confirmation">Delete Account</a>

						<!-- Modal -->
						<div class="modal fade" id="confirmation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								This will permanently remove your account 
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
								<a href="php/delete-current-user.php" class="btn btn-primary">Delete</a>
							</div>
							</div>
						</div>
						</div>

						
						<!-- |
						<a href="php/delete-current-user.php" class="text-decoration-none">Store</a> -->
					</div>
			</div>
		</div>
     </form>
	</div>
	    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</body>
</html>

<?php }else{
  header("Location: login.php");
  exit;
} ?>