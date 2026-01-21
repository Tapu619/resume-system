<?php
session_start();       // 1. Access the current session

// 2. Remove all session variables
session_unset();       

// 3. Destroy the session completely
session_destroy();     

// DELETE THE COOKIE ---
if (isset($_COOKIE['remember_user'])) {
    // Empty the value and set expiration time to 1 hour in the past
    setcookie('remember_user', '', time() - 3600, "/");
    
    unset($_COOKIE['remember_user']);
}

// 4. Redirect to Login Page
header("Location: login.php");
exit;
?>