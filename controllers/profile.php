<?php
session_start();
require_once '../config/db.php';
require_once '../models/userModel.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success_msg = "";
$error_msg = "";

// Get current data first to populate the form
$user = getUserById($conn, $user_id);

// - UPDATE PROFILE 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile_btn'])) {
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $dob = $_POST['dob'];
    
    // Check Empty Fields FIRST
    if (empty($full_name) || empty($phone) || empty($dob)) {
        $error_msg = "Error: All profile fields are required.";
    } 
    // Check Phone (Must be 11 digits and numeric)
    elseif (strlen($phone) !== 11 || !is_numeric($phone)) {
        $error_msg = "Error: Phone number must be exactly 11 digits (e.g. 017xxxxxxxx).";
    }
    else {
        //  Calculate Age
        $dob_date = new DateTime($dob);
        $today = new DateTime();
        $age = $today->diff($dob_date)->y;

        if ($age <= 16) {
            $error_msg = "Error: You must be older than 16 years old.";
        }
        // Check if No Changes Made
        elseif ($full_name == $user['full_name'] && $phone == $user['phone'] && $dob == $user['dob']) {
            $error_msg = "No changes were made to your profile.";
        }
        else {
            //  Update Database
            if (updateUserProfile($conn, $user_id, $full_name, $phone, $dob)) {
                $success_msg = "Profile updated successfully!";
                $_SESSION['full_name'] = $full_name;
                
                // Refresh data so the form shows new info immediately
                $user['full_name'] = $full_name;
                $user['phone'] = $phone;
                $user['dob'] = $dob;
            } else {
                $error_msg = "Database Error: Failed to update profile.";
            }
        }
    }
}

// CHANGE PASSWORD 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_pass_btn'])) {
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    
    if (empty($new_pass) || empty($confirm_pass)) {
        $error_msg = "Error: Please fill in both password fields.";
    }
    elseif ($new_pass !== $confirm_pass) {
        $error_msg = "Error: New passwords do not match.";
    } 
    else {
        if (changeUserPassword($conn, $user_id, $new_pass)) {
            $success_msg = "Password changed successfully!";
        } else {
            $error_msg = "Database Error: Could not change password.";
        }
    }
}

include '../views/common/profile_view.php';
?>