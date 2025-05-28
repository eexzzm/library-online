<?php  
session_start();
require_once "php/access.php";
requireRole(['admin','user']);

if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Change Password</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="index.php">Online Book Store</a>
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
      			        <li><a class="dropdown-item" href="edit-current-user.php">Edit Profile</a></li>
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


	<form action="php/change-password.php" method="post" 
		  class="shadow p-4 rounded mt-5"
		  style="width: 90%; max-width: 500px;">

		<h1 class="text-center pb-3 fs-4">Change Password</h1>

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
			<label class="form-label">Current Password</label>
			<input type="password" class="form-control" name="current_password" required>
		</div>

		<div class="mb-3">
			<label class="form-label">New Password</label>
			<input type="password" class="form-control" name="new_password" required>
		</div>

		<div class="mb-3">
			<label class="form-label">Confirm New Password</label>
			<input type="password" class="form-control" name="confirm_password" required>
		</div>

		<button type="submit" class="btn btn-primary w-100">Update Password</button>
	</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php } else {
	header("Location: login.php");
	exit;
} ?>
