<?php
require_once '../config/db.php';


// 1. Get all resumes assigned to THIS specific reviewer
function getAssignedResumes($conn, $reviewer_id) {
    
    // Step 1: Get the list of resumes assigned to this reviewer
    $sql = "SELECT * FROM resumes 
            WHERE assigned_to = '$reviewer_id' 
            ORDER BY upload_date DESC";
            
    $result = mysqli_query($conn, $sql);
    $resumes = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Step 2: Loop through each resume to find the Seeker's Name
    foreach ($resumes as &$resume) {
        
        $seeker_id = $resume['user_id'];
        
        // simple query to find the user's name
        $sql_user = "SELECT full_name FROM users WHERE id = '$seeker_id'";
        $result_user = mysqli_query($conn, $sql_user);
        $user_data = mysqli_fetch_assoc($result_user);
        
        // Add the name to the resume data
        $resume['seeker_name'] = $user_data['full_name'];
    }

    return $resumes;
}

// 2. Get details of ONE specific resume for reviewing
function getResumeDetails($conn, $resume_id) {
    
    // Step 1: Get the resume data from the 'resumes' table
    $sql = "SELECT * FROM resumes WHERE id = '$resume_id'";
    $result = mysqli_query($conn, $sql);
    $resume = mysqli_fetch_assoc($result);

    // Step 2: If the resume exists, find the owner's name
    if ($resume) {
        $seeker_id = $resume['user_id'];
        
        // Simple query to get the name
        $sql_user = "SELECT full_name FROM users WHERE id = '$seeker_id'";
        $result_user = mysqli_query($conn, $sql_user);
        $user_data = mysqli_fetch_assoc($result_user);

        // Add the name to our resume array
        $resume['seeker_name'] = $user_data['full_name'];
    }

    return $resume;
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