<?php
require_once '../config/db.php';

// 1. Save file path to database
function uploadResume($conn, $user_id, $file_path) {
    // Check if user already uploaded one (Optional: delete old one or block upload)
    // For simplicity, we just insert a new one.
    $sql = "INSERT INTO resumes (user_id, file_path, status) VALUES ('$user_id', '$file_path', 'pending')";
    return mysqli_query($conn, $sql);
}

// 2. Get Resume Details (Status, Date)
function getResumeByUserId($conn, $user_id) {
    // We order by ID DESC to get the *latest* resume uploaded
    $sql = "SELECT * FROM resumes WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// 3. Get Feedback (Reviewer Comments & Score)
function getFeedbackByResumeId($conn, $resume_id) {
    // We Join with 'users' table to get the Reviewer's Name
    $sql = "SELECT reviews.*, users.full_name as reviewer_name 
            FROM reviews 
            JOIN users ON reviews.reviewer_id = users.id 
            WHERE reviews.resume_id = '$resume_id'";
            
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// ... existing functions ...

// 4. Delete Resume
function deleteResume($conn, $user_id) {
    $sql = "DELETE FROM resumes WHERE user_id = '$user_id'";
    return mysqli_query($conn, $sql);
}

?>