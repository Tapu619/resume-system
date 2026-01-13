<?php
// 1. Start Session (Crucial for login!)
session_start();

// 2. Include Model
require_once '../models/userModel.php';

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_btn'])) {
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Call the loginUser function from userModel.php
    $user = loginUser($conn, $email, $password);

    if ($user) {
        // Login Success!
        
        // Save user info in Session so we can use it on other pages
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];

        // ROLE-BASED REDIRECTION
        // We check the 'role' column from the database and redirect accordingly
        if ($user['role'] == 'job_seeker') {
            header("Location: seeker_dashboard.php");
        } 
        elseif ($user['role'] == 'reviewer') {
            header("Location: reviewer_dashboard.php");
        } 
        elseif ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        }
        exit; // Stop script after redirecting

    } else {
        // Login Failed
        $error_msg = "Invalid email or password.";
    }
}

// Load the view
include '../views/auth/login_view.php';
?>