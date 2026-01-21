<?php
require_once '../config/db.php';

// Check if a user already exists
function isEmailTaken($conn, $email) {
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        return true; 
    } else {
        return false; 
    }
}

// Register a new user
function registerUser($conn, $fullname, $email, $phone, $dob, $password, $question, $answer, $role) {
    
    $fullname = mysqli_real_escape_string($conn, $fullname);
    $email = mysqli_real_escape_string($conn, $email);
    $phone = mysqli_real_escape_string($conn, $phone);
    $password = mysqli_real_escape_string($conn, $password);
    $question = mysqli_real_escape_string($conn, $question); 
    $answer = mysqli_real_escape_string($conn, $answer);
    $role = mysqli_real_escape_string($conn, $role);

    $sql = "INSERT INTO users (full_name, email, phone, dob, password, security_question, security_answer, role) 
            VALUES ('$fullname', '$email', '$phone', '$dob', '$password', '$question', '$answer', '$role')";

    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

// Login User
function loginUser($conn, $email, $password) {
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result); 
    } else {
        return false; 
    }
}

// FORGOT PASSWORD FUNCTIONS 

// Get the security question
function getUserQuestion($conn, $email) {
    $sql = "SELECT security_question FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['security_question'];
    } else {
        return false; 
    }
}

// Check if the provided answer is correct
function checkSecurityAnswer($conn, $email, $answer) {
    $sql = "SELECT id FROM users WHERE email = '$email' AND security_answer = '$answer'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        return true; 
    } else {
        return false; 
    }
}

// UPDATED: Update password using ID 
function updatePassword($conn, $id, $new_password) {
    // Sanitize inputs
    $new_password = mysqli_real_escape_string($conn, $new_password);
    $id = mysqli_real_escape_string($conn, $id);
    
    $sql = "UPDATE users SET password = '$new_password' WHERE id = '$id'";
    return mysqli_query($conn, $sql);
}

// PROFILE FUNCTIONS

// Fetch all user details by ID
function getUserById($conn, $id) {
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// Update Profile Details
function updateUserProfile($conn, $id, $full_name, $phone, $dob) {
    $full_name = mysqli_real_escape_string($conn, $full_name);
    $phone = mysqli_real_escape_string($conn, $phone);
    $dob = mysqli_real_escape_string($conn, $dob);
    
    $sql = "UPDATE users SET full_name='$full_name', phone='$phone', dob='$dob' WHERE id='$id'";
    return mysqli_query($conn, $sql);
}

// Change Password for logged-in user
function changeUserPassword($conn, $id, $new_password) {
    $new_password = mysqli_real_escape_string($conn, $new_password);
    $sql = "UPDATE users SET password='$new_password' WHERE id='$id'";
    return mysqli_query($conn, $sql);
}
?>