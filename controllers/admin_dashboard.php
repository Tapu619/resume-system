<?php
session_start();
require_once '../config/db.php';
require_once '../models/adminModel.php';

// 1. Security Check: Only Admins Allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$message = "";
$error = "";

// 2. Handle Form: Assign Reviewer (We keep this because it's not AJAX yet)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_btn'])) {
    $resume_id = $_POST['resume_id'];
    
    // Check if a reviewer was actually selected
    if (!isset($_POST['reviewer_id']) || empty($_POST['reviewer_id'])) {
        $error = "Error: You must select a reviewer from the list.";
    } 
    else {
        $reviewer_id = $_POST['reviewer_id'];
        
        if (assignReviewer($conn, $resume_id, $reviewer_id)) {
            $message = "Reviewer assigned successfully!";
        } else {
            $error = "Failed to assign reviewer.";
        }
    }
}


// 4. Fetch Data for the View
$all_users = getAllUsers($conn);
$all_resumes = getAllResumes($conn);
$reviewers_list = getAllReviewers($conn);

// Get Stats
$system_stats = getSystemStats($conn);

// 5. Load View
// Make sure this filename matches your actual view file (admin_dashboard_view.php)
include '../views/admin/dashboard_view.php'; 
?>