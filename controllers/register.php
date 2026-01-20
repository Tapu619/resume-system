<?php
session_start();
require_once '../config/db.php';
require_once '../models/userModel.php';

// Check if it is a Form Submission (POST via AJAX)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_btn'])) {
    
    // Set Header for AJAX JSON response
    header('Content-Type: application/json');

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $dob = $_POST['dob'];
    $password = $_POST['password'];
    $answer = trim($_POST['security_answer']);
    $question = $_POST['security_question'] ?? ''; 
    $role = $_POST['role'] ?? ''; 

    // --- VALIDATION STEPS ---

    // 1. CHECK EMPTY FIELDS FIRST (Critical to prevent crashes)
    if (empty($full_name) || empty($email) || empty($phone) || empty($dob) || empty($password) || empty($question) || empty($answer) || empty($role)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    } 

    try {
        $dob_date = new DateTime($dob);
        $today = new DateTime();
        $age = $today->diff($dob_date)->y;
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Date format.']);
        exit;
    }

    // 3. Check Phone (Must be 11 digits and numeric)
    if (strlen($phone) !== 11 || !is_numeric($phone)) {
        echo json_encode(['status' => 'error', 'message' => 'Phone number must be exactly 11 digits (e.g. 017xxxxxxxx).']);
        exit;
    }
    // 4. Check Age (> 16)
    elseif ($age <= 16) {
        echo json_encode(['status' => 'error', 'message' => 'You must be older than 16 to register.']);
        exit;
    }
    // 5. Check Duplicate Email
    elseif (isEmailTaken($conn, $email)) {
        echo json_encode(['status' => 'error', 'message' => 'This email is already registered.']);
        exit;
    } 
    else {
        // Proceed to Register
        if (registerUser($conn, $full_name, $email, $phone, $dob, $password, $question, $answer, $role)) {
            echo json_encode(['status' => 'success', 'message' => 'Registration successful! Redirecting...']);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error. Please try again.']);
            exit;
        }
    }
}

include '../views/auth/register_view.php';
?>