<?php
require_once '../config/db.php';

// Save file path to database
function uploadResume($conn, $user_id, $file_path) {
    $sql = "INSERT INTO resumes (user_id, file_path, status) VALUES ('$user_id', '$file_path', 'pending')";
    return mysqli_query($conn, $sql);
}

// Get Resume Details (Status, Date)
function getResumeByUserId($conn, $user_id) {
    $sql = "SELECT * FROM resumes WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// Get Feedback (Reviewer Comments & Score)
function getFeedbackByResumeId($conn, $resume_id) {
    

    $sql = "SELECT * FROM reviews WHERE resume_id = '$resume_id'";
    $result = mysqli_query($conn, $sql);
    $review = mysqli_fetch_assoc($result);

    if ($review) {
        $reviewer_id = $review['reviewer_id'];
        
        // Simple query to find the reviewer's name
        $sql_user = "SELECT full_name FROM users WHERE id = '$reviewer_id'";
        $result_user = mysqli_query($conn, $sql_user);
        $user_data = mysqli_fetch_assoc($result_user);
        
        // Add the name to our review array
        $review['reviewer_name'] = $user_data['full_name'];
    }

    return $review;
}


//Delete Resume
function deleteResume($conn, $user_id) {
    $sql = "DELETE FROM resumes WHERE user_id = '$user_id'";
    return mysqli_query($conn, $sql);
}

?>