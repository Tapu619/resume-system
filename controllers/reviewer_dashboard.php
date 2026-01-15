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

// Fetch Resumes Assigned to ME
$my_resumes = getAssignedResumes($conn, $reviewer_id);

// Load View
include '../views/reviewer/dashboard_view.php';
?>