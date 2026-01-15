<?php
require_once '../config/db.php';

// 1. Get all resumes assigned to THIS specific reviewer
function getAssignedResumes($conn, $reviewer_id) {
    // We join with the 'users' table to get the Job Seeker's name
    $sql = "SELECT resumes.*, users.full_name AS seeker_name 
            FROM resumes 
            JOIN users ON resumes.user_id = users.id 
            WHERE resumes.assigned_to = '$reviewer_id' 
            ORDER BY resumes.upload_date DESC";
            
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// 2. Get details of ONE specific resume (for the grading page)
function getResumeDetails($conn, $resume_id) {
    $sql = "SELECT resumes.*, users.full_name AS seeker_name 
            FROM resumes 
            JOIN users ON resumes.user_id = users.id 
            WHERE resumes.id = '$resume_id'";
            
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}
?>