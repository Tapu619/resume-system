<?php
require_once '../config/db.php';

// Function 1: Check if a user already exists
// Explanation: We run a query to count how many users have this specific email.
function isEmailTaken($conn, $email) {
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    // If the number of rows found is greater than 0, the email is taken.
    if (mysqli_num_rows($result) > 0) {
        return true; 
    } else {
        return false; 
    }
}

// Function 2: Register a new user
// Explanation: We take the form data and insert it directly into the database.
function registerUser($conn, $fullname, $email, $phone, $dob, $password, $question, $answer, $role) {
    
    // 1. Sanitize the inputs (Fixes the "pet's name" error)
    // This adds a backslash in front of quotes so SQL reads them as text, not code.
    $fullname = mysqli_real_escape_string($conn, $fullname);
    $email = mysqli_real_escape_string($conn, $email);
    $phone = mysqli_real_escape_string($conn, $phone);
    $password = mysqli_real_escape_string($conn, $password);
    $question = mysqli_real_escape_string($conn, $question); // <--- Vital for "Pet's Name"
    $answer = mysqli_real_escape_string($conn, $answer);
    $role = mysqli_real_escape_string($conn, $role);

    // 2. The SQL Query
    $sql = "INSERT INTO users (full_name, email, phone, dob, password, security_question, security_answer, role) 
            VALUES ('$fullname', '$email', '$phone', '$dob', '$password', '$question', '$answer', '$role')";

    // 3. Execute
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

?>