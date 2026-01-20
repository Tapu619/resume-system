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
    
    // Collect Inputs
    $name = trim($_POST['new_name']);
    $email = trim($_POST['new_email']);
    $pass = $_POST['new_pass'];
    $phone = trim($_POST['new_phone']);
    $dob = $_POST['new_dob'];
    $ans = trim($_POST['new_answer']);
    $ques = $_POST['new_question'] ?? '';

    // --- VALIDATION LOGIC ---

    // 1. Calculate Age (Year Difference Only)
    // We get the year from DOB and compare it to Current Year
    $dob_year = date('Y', strtotime($dob));
    $current_year = date('Y');
    $age = $current_year - $dob_year;

    // 2. Check Empty Fields
    if (empty($name) || empty($email) || empty($pass) || empty($phone) || empty($dob) || empty($ques) || empty($ans)) {
        $error = "Error: All fields are required to create a new admin.";
    } 
    // 3. Check Phone (Must be 11 digits and numeric)
    elseif (strlen($phone) !== 11 || !is_numeric($phone)) {
        $error = "Error: Phone number must be exactly 11 digits.";
    }
    // 4. Check Age (Must be > 30 based on year)
    elseif ($age <= 30) {
        $error = "Error: Admin must be older than 30 years (by year).";
    }
    else {
        // Validation Passed -> Call Model Function
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