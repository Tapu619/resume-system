<?php
session_start();
require_once '../config/db.php';
require_once '../models/adminModel.php';

// 1. Security Check: Only Admins can enter this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$message = "";
$error = "";

// 2. Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_admin_btn'])) {
    // Collect Inputs (using trim to remove extra spaces)
    $name = trim($_POST['new_name']);
    $email = trim($_POST['new_email']);
    $pass = $_POST['new_pass'];
    $phone = trim($_POST['new_phone']);
    $dob = $_POST['new_dob'];
    $ans = trim($_POST['new_answer']);
   
}

    // Handle Dropdown safely (if nothing selected, default to empty string)
    $ques = $_POST['new_question'] ?? '';



// 3. Load the View
include '../views/admin/create_admin_view.php';

?>