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



?>