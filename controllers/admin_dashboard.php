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


// 2. Handle Form: Assign Reviewer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_btn'])) {
    $resume_id = $_POST['resume_id'];

     // --- VALIDATION FIX ---
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

// 3. Handle Form: Delete User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user_btn'])) {
    $user_id_to_delete = $_POST['user_id'];
    
    if (deleteUser($conn, $user_id_to_delete)) {
        $message = "User deleted successfully.";
    } else {
        $error = "Failed to delete user.";
    }
}

// 4. Fetch Data for the View
$all_users = getAllUsers($conn);
$all_resumes = getAllResumes($conn);
$reviewers_list = getAllReviewers($conn);



// Get Stats
$system_stats = getSystemStats($conn);

// 5. Load View
include '../views/admin/dashboard_view.php';
?>