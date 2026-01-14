<?php
session_start();
require_once '../config/db.php';
require_once '../models/userModel.php';

// 1. If user is already logged in, redirect them to their dashboard
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') header("Location: admin_dashboard.php");
    elseif ($_SESSION['role'] == 'reviewer') header("Location: reviewer_dashboard.php");
    else header("Location: seeker_dashboard.php");
    exit;
}

$error_msg = "";

// 2. Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_btn'])) {
    
    // Sanitize inputs
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // --- VALIDATION: Check for Empty Fields ---
    if (empty($email) || empty($password)) {
        $error_msg = "Please enter both your email address and password.";
    } 
    else {
        // 3. Attempt to Login
        $user = loginUser($conn, $email, $password);

        if ($user) {
            // Success: Set Session Variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            // 4. Redirect based on Role
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($user['role'] == 'reviewer') {
                header("Location: reviewer_dashboard.php");
            } else {
                header("Location: seeker_dashboard.php"); // Default: Job Seeker
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