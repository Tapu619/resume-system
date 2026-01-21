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

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_admin_btn'])) {
    
    // Collect Inputs
    $name = trim($_POST['new_name']);
    $email = trim($_POST['new_email']);
    $pass = $_POST['new_pass'];
    $phone = trim($_POST['new_phone']);
    $dob = $_POST['new_dob'];
    $ans = trim($_POST['new_answer']);
    $ques = $_POST['new_question'] ?? '';

    // VALIDATION LOGIC

    // Calculate Age 
    $dob_year = date('Y', strtotime($dob));
    $current_year = date('Y');
    $age = $current_year - $dob_year;


    if (empty($name) || empty($email) || empty($pass) || empty($phone) || empty($dob) || empty($ques) || empty($ans)) {
        $error = "Error: All fields are required to create a new admin.";
    } 

    elseif (strlen($phone) !== 11 || !is_numeric($phone)) {
        $error = "Error: Phone number must be exactly 11 digits.";
    }
    
    elseif ($age <= 30) {
        $error = "Error: Admin must be older than 30 years (by year).";
    }
    else {
        // Call Model Function
        $result = createAdminUser($conn, $name, $email, $pass, $phone, $dob, $ques, $ans);

        if ($result === true) {
            $message = "Success! New Admin account created.";
        } else {
            $error = $result; 
        }
    }
}

// 3. Load the View
include '../views/admin/create_admin_view.php';
?>