<?php
session_start();
require_once '../config/db.php';
require_once '../models/userModel.php';

// Handle AJAX Request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_btn'])) {
    
    // 1. Prepare JSON Header
    header('Content-Type: application/json');

    // 2. Collect & Validate Data
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $dob = $_POST['dob'];
    $password = $_POST['password'];
    $answer = trim($_POST['security_answer']);
    $question = $_POST['security_question'] ?? ''; 
    $role = $_POST['role'] ?? ''; 

    if (empty($full_name) || empty($email) || empty($phone) || empty($dob) || empty($password) || empty($question) || empty($answer) || empty($role)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    } 
    elseif (isEmailTaken($conn, $email)) {
        echo json_encode(['status' => 'error', 'message' => 'This email is already registered.']);
        exit;
    } 
    else {
        if (registerUser($conn, $full_name, $email, $phone, $dob, $password, $question, $answer, $role)) {
            echo json_encode(['status' => 'success', 'message' => 'Registration successful! Redirecting...']);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error.']);
            exit;
        }
    }
}

include '../views/auth/register_view.php';
?>