<?php
require_once '../config/db.php';

// 1. Get All Users (for the "Manage Users" section)
function getAllUsers($conn) {
    $sql = "SELECT * FROM users ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// 2. Get All Resumes
function getAllResumes($conn) {
    
    // Step 1: Just get all the raw resume data first
    $sql = "SELECT * FROM resumes ORDER BY upload_date DESC";
    $result = mysqli_query($conn, $sql);
    
    // Fetch all rows into an array
    $resumes = mysqli_fetch_all($result, MYSQLI_ASSOC);


    // Step 2: Loop through the list and find names manually
    foreach ($resumes as &$resume) {

        // --- A. Get the Job Seeker's Name ---
        $seeker_id = $resume['user_id'];
        $sql1 = "SELECT full_name FROM users WHERE id = '$seeker_id'";
        $res1 = mysqli_query($conn, $sql1);
        $seeker_data = mysqli_fetch_assoc($res1);
        
        // Add the name to our list
        $resume['seeker_name'] = $seeker_data['full_name'];


        // --- B. Get the Reviewer's Name (If one is assigned) ---
        if (!empty($resume['assigned_to'])) {
            $reviewer_id = $resume['assigned_to'];
            $sql2 = "SELECT full_name FROM users WHERE id = '$reviewer_id'";
            $res2 = mysqli_query($conn, $sql2);
            $reviewer_data = mysqli_fetch_assoc($res2);
            
            $resume['reviewer_name'] = $reviewer_data['full_name'];
        } 
        else {
            $resume['reviewer_name'] = "Not Assigned";
        }
    }

    return $resumes;
}

// 3. Get list of ONLY Reviewers (for the dropdown menu)
function getAllReviewers($conn) {
    $sql = "SELECT * FROM users WHERE role = 'reviewer'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Get just the status of a resume
function getResumeStatus($conn, $resume_id) {
    $resume_id = mysqli_real_escape_string($conn, $resume_id);
    
    $sql = "SELECT status FROM resumes WHERE id = '$resume_id'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);
    
    return $data ? $data['status'] : null;
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
    $password = mysqli_real_escape_string($conn, $password);
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


// 7. Get System Statistics 
function getSystemStats($conn) {
    $stats = [];

    // Query 1: Get TOTAL number of resumes
    // "Count everything in the resumes table"
    $sql1 = "SELECT COUNT(*) as count FROM resumes";
    $result1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_assoc($result1);
    $stats['total'] = $row1['count'];


    // Query 2: Get REVIEWED resumes
    // "Count resumes WHERE the status is 'reviewed'"
    $sql2 = "SELECT COUNT(*) as count FROM resumes WHERE status = 'reviewed'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $stats['reviewed'] = $row2['count'];


    // Query 3: Get PENDING resumes
    // "Count resumes WHERE the status is 'pending'"
    $sql3 = "SELECT COUNT(*) as count FROM resumes WHERE status = 'pending'";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_assoc($result3);
    $stats['pending'] = $row3['count'];


    // Query 4: Get AVERAGE Score
    // "Calculate the average of the 'score' column from reviews table"
    $sql4 = "SELECT AVG(score) as avg_score FROM reviews";
    $result4 = mysqli_query($conn, $sql4);
    $row4 = mysqli_fetch_assoc($result4);
    
    //rounding the avg score
    if ($row4['avg_score']) {
        $stats['avg_score'] = round($row4['avg_score'], 1);
    } else {
        $stats['avg_score'] = 0;
    }

    return $stats;
}



?>