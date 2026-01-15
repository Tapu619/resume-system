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

?>