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
    
    // 1. Sanitize the inputs
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



// Function 3: Login User
// Explanation: We look for a user who matches BOTH the email AND the password.
function loginUser($conn, $email, $password) {
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // If we find exactly 1 user, login is successful
    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result); // Return the user's data array
    } else {
        return false; // Login failed
    }
}

//Forgetting password
// 1. Get the security question for a specific email
function getUserQuestion($conn, $email) {
    $sql = "SELECT security_question FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['security_question'];
    } else {
        return false; // Email not found
    }
}

// 2. Check if the provided answer is correct
function checkSecurityAnswer($conn, $email, $answer) {
    // We check if a user exists with THIS email AND THIS answer
    $sql = "SELECT id FROM users WHERE email = '$email' AND security_answer = '$answer'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        return true; // Match found
    } else {
        return false; // Wrong answer
    }
}

// 3. Update the password
function updatePassword($conn, $email, $new_password) {
    $sql = "UPDATE users SET password = '$new_password' WHERE email = '$email'";
    return mysqli_query($conn, $sql);
}


//view Profile & update

// 1. Fetch all user details by ID (for View Profile)
function getUserById($conn, $id) {
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}


?>