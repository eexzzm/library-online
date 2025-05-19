<?php 

# Get all User function
function get_all_user($con){
   $sql  = "SELECT * FROM users";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	  $users = $stmt->fetchAll();
   }else {
      $users = 0;
   }

   return $users;
}


# Get user by ID function
function get_user($con, $id){
   $sql  = "SELECT * FROM users WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $user = $stmt->fetch();
   }else {
      $user = 0;
   }

   return $user;
}