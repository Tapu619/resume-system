<?php
require_once '../config/db.php';

// 1. Get All Users (for the "Manage Users" section)
function getAllUsers($conn) {
    $sql = "SELECT * FROM users ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// 2. Get All Resumes (Joined with User Info so we know WHO uploaded it)
function getAllResumes($conn) {
    // We join 'resumes' with 'users' to get the Job Seeker's Name
    // We also join with 'users' AGAIN (as 'reviewer') to see who is currently assigned
    $sql = "SELECT resumes.*, 
                   seeker.full_name AS seeker_name, 
                   reviewer.full_name AS reviewer_name 
            FROM resumes 
            JOIN users AS seeker ON resumes.user_id = seeker.id
            LEFT JOIN users AS reviewer ON resumes.assigned_to = reviewer.id
            ORDER BY resumes.upload_date DESC";
            
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// 3. Get list of ONLY Reviewers (for the dropdown menu)
function getAllReviewers($conn) {
    $sql = "SELECT * FROM users WHERE role = 'reviewer'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// 4. Assign a Resume to a Reviewer
function assignReviewer($conn, $resume_id, $reviewer_id) {
    $sql = "UPDATE resumes SET assigned_to = '$reviewer_id' WHERE id = '$resume_id'";
    return mysqli_query($conn, $sql);
}

// 5. Delete a User 
function deleteUser($conn, $user_id) {
    $sql = "DELETE FROM users WHERE id = '$user_id'";
    return mysqli_query($conn, $sql);
}

// 6. Create a New Admin Account
function createAdminUser($conn, $full_name, $email, $password, $phone, $dob, $question, $answer) {
    
    // Check if email already exists
    $check_sql = "SELECT id FROM users WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_sql);
    if(mysqli_num_rows($check_result) > 0) {
        return "Email already exists.";
    }

    // Sanitize inputs
    $full_name = mysqli_real_escape_string($conn, $full_name);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password); // Plain text as requested
    $phone = mysqli_real_escape_string($conn, $phone);
    $dob = mysqli_real_escape_string($conn, $dob);
    $question = mysqli_real_escape_string($conn, $question);
    $answer = mysqli_real_escape_string($conn, $answer);

    // Insert with role = 'admin'
    $sql = "INSERT INTO users (full_name, email, password, phone, dob, security_question, security_answer, role) 
            VALUES ('$full_name', '$email', '$password', '$phone', '$dob', '$question', '$answer', 'admin')";

    if (mysqli_query($conn, $sql)) {
        return true; // Success
    } else {
        return "Database Error: " . mysqli_error($conn);
    }
}


// 7. Get System Statistics (Total, Pending, Reviewed, Average Score)
function getSystemStats($conn) {
    $stats = [];

    // Query 1: Counts from Resumes table
    $sql_counts = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'reviewed' THEN 1 ELSE 0 END) as reviewed,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending
                   FROM resumes";
    $result_counts = mysqli_query($conn, $sql_counts);
    $row_counts = mysqli_fetch_assoc($result_counts);
    
    $stats['total'] = $row_counts['total'];
    $stats['reviewed'] = $row_counts['reviewed'];
    $stats['pending'] = $row_counts['pending'];

    // Query 2: Average Score from Reviews table
    $sql_avg = "SELECT AVG(score) as average FROM reviews";
    $result_avg = mysqli_query($conn, $sql_avg);
    $row_avg = mysqli_fetch_assoc($result_avg);

    // Round to 1 decimal place (e.g., 85.5), default to 0 if no reviews yet
    $stats['avg_score'] = $row_avg['average'] ? round($row_avg['average'], 1) : 0;

    return $stats;
}



?>