<?php
require_once '../config/db.php';

// 1. Save file path to database
function uploadResume($conn, $user_id, $file_path) {
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
    
    // Step 1: Get the review details from the 'reviews' table
    $sql = "SELECT * FROM reviews WHERE resume_id = '$resume_id'";
    $result = mysqli_query($conn, $sql);
    $review = mysqli_fetch_assoc($result);

    // Step 2: If a review exists, find the Reviewer's Name
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


// 4. Delete Resume
function deleteResume($conn, $user_id) {
    $sql = "DELETE FROM resumes WHERE user_id = '$user_id'";
    return mysqli_query($conn, $sql);
}

?>