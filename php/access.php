<?php

/**
 * Call at the top of every protected page.
 * @param array $allowedRoles e.g. ['admin'], ['user'], or ['admin','user']
 */
function requireRole(array $allowedRoles) {
    if (!isset($_SESSION['role'])) {
        header("Location: login.php");
        exit;
    }
    if (!in_array($_SESSION['role'], $allowedRoles)) {
        header("Location: access_denied.php");
        exit;
    }
}

/**
 * Optional: convenience wrappers
 */
function requireAdmin() {
    requireRole(['admin']);
}

function requireUser() {
    requireRole(['user']);
}
