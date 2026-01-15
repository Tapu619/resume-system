<?php
session_start();
require_once '../config/db.php';
require_once '../models/userModel.php';

// Security Check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success_msg = "";
$error_msg = "";

// --- 1. FETCH CURRENT USER DATA FIRST ---
// We move this to the top so we can compare "New Input" vs "Old Database Data"
$user = getUserById($conn, $user_id);


// --- HANDLE FORM 1: UPDATE PROFILE ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile_btn'])) {
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $dob = $_POST['dob'];
    
    // Validation 1: Check for empty fields
    if (empty($full_name) || empty($phone) || empty($dob)) {
        $error_msg = "Error: Name, Phone, and Date of Birth cannot be empty.";
    } 
    // Validation 2: Check if data is actually different
    elseif ($full_name == $user['full_name'] && $phone == $user['phone'] && $dob == $user['dob']) {
        $error_msg = "No changes were made to your profile."; 
    }
    else {
        // 3. Update Database
        if (updateUserProfile($conn, $user_id, $full_name, $phone, $dob)) {
            $success_msg = "Profile updated successfully!";
            $_SESSION['full_name'] = $full_name; 
            
            // Refresh the $user variable so the form shows the NEW data immediately
            $user['full_name'] = $full_name;
            $user['phone'] = $phone;
            $user['dob'] = $dob;
        } else {
            $error_msg = "Database Error: Failed to update profile.";
        }
    }
}

// --- HANDLE FORM 2: CHANGE PASSWORD ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_pass_btn'])) {
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    
    if (empty($new_pass) || empty($confirm_pass)) {
        $error_msg = "Error: Password fields cannot be empty.";
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

// Load the View
include '../views/common/profile_view.php';
?>