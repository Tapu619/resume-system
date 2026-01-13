<?php
require_once '../models/userModel.php';

$step = 1; // Default: Show Step 1 (Enter Email)
$error_msg = "";
$success_msg = "";
$fetched_question = "";
$email = "";

// Handle Form Submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // STEP 1: User submitted Email
    if (isset($_POST['check_email_btn'])) {
        $email = trim($_POST['email']);
        $fetched_question = getUserQuestion($conn, $email);
        
        if ($fetched_question) {
            // Email found! Move to Step 2
            $step = 2;
        } else {
            $error_msg = "Email not found in our records.";
        }
    }

    // STEP 2: User submitted Security Answer
    elseif (isset($_POST['check_answer_btn'])) {
        $email = $_POST['email']; // Retrieved from hidden input
        $answer = trim($_POST['security_answer']);
        
        if (checkSecurityAnswer($conn, $email, $answer)) {
            // Answer correct! Move to Step 3
            $step = 3;
        } else {
            // Wrong answer, stay on Step 2
            $step = 2;
            $fetched_question = getUserQuestion($conn, $email); // Need to show question again
            $error_msg = "Incorrect security answer.";
        }
    }

    // STEP 3: User submitted New Password
    elseif (isset($_POST['reset_pass_btn'])) {
        $email = $_POST['email']; // Retrieved from hidden input
        $new_pass = $_POST['new_password'];
        
        if (updatePassword($conn, $email, $new_pass)) {
            $success_msg = "Password updated successfully!";
            $step = 4; // Step 4 is just the success message
        } else {
            $error_msg = "Failed to update password.";
        }
    }
}

// Load the view
include '../views/auth/forget_password_view.php';
?>