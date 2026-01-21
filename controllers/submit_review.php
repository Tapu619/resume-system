<?php
session_start();
require_once '../config/db.php';
require_once '../models/reviewModel.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'reviewer') {
    header("Location: login.php");
    exit;
}

$reviewer_id = $_SESSION['user_id'];
$message = "";
$error = "";

// 1. Get Resume ID from URL
if (isset($_GET['id'])) {
    $resume_id = $_GET['id'];
    $resume_data = getResumeDetails($conn, $resume_id);

    // Basic Validation: Ensure this resume exists and is assigned to THIS reviewer
    if (!$resume_data || $resume_data['assigned_to'] != $reviewer_id) {
        die("Access Denied: You are not assigned to this resume.");
    }
} else {
    header("Location: reviewer_dashboard.php");
    exit;
}

// 2. Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review_btn'])) {
    
    // Collect inputs
    $score = $_POST['score'];
    $comments = trim($_POST['comments']);

    
    // Check if score is empty (Must check explicitly for empty string, because "0" is a valid score)
    if ($score === "") {
        $error = "Error: Please enter a score.";
    }
    // Check if comments are empty
    elseif (empty($comments)) {
        $error = "Error: Feedback comments cannot be empty.";
    }
    // Check range logic
    elseif ($score < 0 || $score > 100) {
        $error = "Error: Score must be between 0 and 100.";
    } 
    else {
        // Validation Passed -> Submit Review
        if (submitReview($conn, $resume_id, $reviewer_id, $score, $comments)) {
            $message = "Review submitted successfully!";
            // Refresh data to show updated status immediately
            $resume_data['status'] = 'reviewed'; 
        } else {
            $error = "Database Error: Could not save review.";
        }
    }
}

// Load View
include '../views/reviewer/submit_review_view.php';
?>