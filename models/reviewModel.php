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

// 3. Submit the Review (Score + Comment)
function submitReview($conn, $resume_id, $reviewer_id, $score, $comments) {
    // Sanitize
    $comments = mysqli_real_escape_string($conn, $comments);
    $score = (int)$score;

    // A. Insert into 'reviews' table
    $sql_insert = "INSERT INTO reviews (resume_id, reviewer_id, score, feedback_comments) 
                   VALUES ('$resume_id', '$reviewer_id', '$score', '$comments')";
    
    if (mysqli_query($conn, $sql_insert)) {
        // B. Update 'resumes' table status to 'reviewed'
        $sql_update = "UPDATE resumes SET status = 'reviewed' WHERE id = '$resume_id'";
        mysqli_query($conn, $sql_update);
        return true;
    } else {
        return false;
    }
}
?>