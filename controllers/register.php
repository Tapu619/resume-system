<?php
// 1. Include the Model
require_once '../models/userModel.php';

// 2. Initialize variables
$error_msg = "";
$success_msg = "";

// 3. Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_btn'])) {
    
    // 1. Get all inputs
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];              
    $dob = $_POST['dob'];                  
    $password = $_POST['password'];
    $question = $_POST['security_question']; 
    $answer = $_POST['security_answer'];     
    $role = $_POST['role'];

    // 2. Validation
    if (empty($full_name) || empty($email) || empty($password) || empty($answer)) {
        $error_msg = "All fields are required.";
    } 
    elseif (isEmailTaken($conn, $email)) {
        $error_msg = "This email is already registered.";
    } 
    else {
        // 3. Register with ALL new variables
        $status = registerUser($conn, $full_name, $email, $phone, $dob, $password, $question, $answer, $role);
        
        if ($status) {
            $success_msg = "Registration successful! You can now login.";
        } else {
            $error_msg = "Database Error: " . mysqli_error($conn);
        }
    }
}

// 4. Load the View (pass the variables to it)
include '../views/auth/register_view.php';
?>