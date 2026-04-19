<?php
session_start();

// 1. Clear all session variables
$_SESSION = array();

// 2. Destroy the session on the server
session_destroy();

// 3. Delete the "Remember Me" cookies by setting their expiration date to the past (1 hour ago)
if (isset($_COOKIE['remember_user'])) {
    setcookie("remember_user", "", time() - 3600, "/");
    setcookie("remember_username", "", time() - 3600, "/");
}

// 4. Redirect back to login page
header("Location: login.php");
exit();
?>