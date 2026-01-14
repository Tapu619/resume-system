<?php
session_start();       // 1. Access the current session
session_unset();       // 2. Remove all session variables (ID, Name, Role)
session_destroy();     // 3. Destroy the session completely

// 4. Redirect to Login Page
header("Location: login.php");
exit;
?>