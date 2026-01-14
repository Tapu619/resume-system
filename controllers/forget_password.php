<?php
session_start();
require_once '../config/db.php';
require_once '../models/userModel.php';

$step = 1;
$error = "";
$message = "";

// STEP 1: VERIFY EMAIL
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify_email_btn'])) {
    $email = trim($_POST['email']);
    
    // Validation
    if (empty($email)) {
        $error = "Please enter your email address.";
    } else {
        // Check if email exists
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            $_SESSION['reset_user_id'] = $user['id'];
            $_SESSION['security_question'] = $user['security_question'];
            $step = 2; // Move to next step
        } else {
            $error = "Email not found in our records.";
        }
    }
}

// STEP 2: VERIFY ANSWER
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify_answer_btn'])) {
    $step = 2; // Stay on step 2 if there's an error
    $answer = trim($_POST['security_answer']);
    $user_id = $_SESSION['reset_user_id'];

    // Validation
    if (empty($answer)) {
        $error = "Please enter your security answer.";
    } else {
        // Get the real answer from DB
        $sql = "SELECT security_answer FROM users WHERE id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);

        // Simple check (case-insensitive)
        if (strtolower($answer) == strtolower($data['security_answer'])) {
            $step = 3; // Move to next step
        } else {
            $error = "Incorrect answer. Please try again.";
        }
    }
}

// STEP 3: RESET PASSWORD
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_pass_btn'])) {
    $step = 3; // Stay on step 3 if there's an error
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    $user_id = $_SESSION['reset_user_id'];

    // Validation
    if (empty($new_pass) || empty($confirm_pass)) {
        $error = "Please enter and confirm your new password.";
    } 
    elseif ($new_pass !== $confirm_pass) {
        $error = "Passwords do not match.";
    } 
    else {
        // Update Password in DB
        // (Assuming you have this function in userModel, or we run query directly here)
        $new_pass = mysqli_real_escape_string($conn, $new_pass);
        $sql = "UPDATE users SET password = '$new_pass' WHERE id = '$user_id'";
        
        if (mysqli_query($conn, $sql)) {
            $message = "Password reset successfully! <a href='login.php'>Login Now</a>";
            $step = 4; // Done
            
            // Clean up session
            unset($_SESSION['reset_user_id']);
            unset($_SESSION['security_question']);
        } else {
            $error = "Database error. Could not reset password.";
        }
    }
}

// Load the View
include '../views/auth/forget_password_view.php';
?>