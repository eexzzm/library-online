<?php

// role based verification
function tryLogin($conn, $table, $email, $password) {
    $sql  = "SELECT * FROM `$table` WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    if ($stmt->rowCount() !== 1) return false;
    $user = $stmt->fetch();
    if (password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}