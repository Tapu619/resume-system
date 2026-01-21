<?php
session_start();
require_once '../config/db.php';
require_once '../models/userModel.php';

// AUTO-LOGIN (Check Cookies)
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_user'])) {
    $cookie_id = $_COOKIE['remember_user'];

    // Security check to ensure ID is a number
    if (is_numeric($cookie_id)) {
        
        $user_cookie = getUserById($conn, $cookie_id);

        if ($user_cookie) {
            // Set Session Variables
            $_SESSION['user_id'] = $user_cookie['id'];
            $_SESSION['full_name'] = $user_cookie['full_name'];
            $_SESSION['role'] = $user_cookie['role'];
        }
    }
}

// If user is already logged in (via Session OR Cookie), redirect them
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') header("Location: admin_dashboard.php");
    elseif ($_SESSION['role'] == 'reviewer') header("Location: reviewer_dashboard.php");
    else header("Location: seeker_dashboard.php");
    exit;
}

$error_msg = "";

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_btn'])) {
    
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // VALIDATION: Check for Empty Fields 
    if (empty($email) || empty($password)) {
        $error_msg = "Please enter both your email address and password.";
    } 
    else {
        // Attempt to Login
        $user = loginUser($conn, $email, $password);

        if ($user) {
            // Success: Set Session Variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            // SET COOKIE
            if (isset($_POST['remember_me'])) {
            
                setcookie('remember_user', $user['id'], time() + 3600, "/");
            }

            //  Redirect based on Role
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($user['role'] == 'reviewer') {
                header("Location: reviewer_dashboard.php");
            } else {
                header("Location: seeker_dashboard.php"); 
            }
            exit;
        } else {
            $error_msg = "Invalid email or password.";
        }
    }
}

// 5. Load the View
include '../views/auth/login_view.php';
?>