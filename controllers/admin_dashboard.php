<?php
session_start();
require_once '../config/db.php';
require_once '../models/adminModel.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$message = "";
$error = "";

// Assign Reviewer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_btn'])) {
    $resume_id = $_POST['resume_id'];

    // Check if the resume is already reviewed
    $current_status = getResumeStatus($conn, $resume_id);

    if ($current_status == 'reviewed') {
        $error = "Error: This resume has already been reviewed. You cannot reassign it.";
    }
    // Check if Reviewer Selected
    elseif (!isset($_POST['reviewer_id']) || empty($_POST['reviewer_id'])) {
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


// Fetch Data for the View
$all_users = getAllUsers($conn);
$all_resumes = getAllResumes($conn);
$reviewers_list = getAllReviewers($conn);

// Get Stats
$system_stats = getSystemStats($conn);

// Load View
include '../views/admin/dashboard_view.php'; 
?>