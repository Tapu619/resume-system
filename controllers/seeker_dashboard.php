<?php
session_start();
require_once '../config/db.php';
require_once '../models/resumeModel.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'job_seeker') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";
$error = "";

// 1. Handle File Upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['resume_pdf'])) {
    
    // Fetch the current resume from the database
    $current_resume = getResumeByUserId($conn, $user_id);

    // If a resume exists AND the status is 'pending', STOP the upload
    if ($current_resume && $current_resume['status'] == 'pending') {
        $error = "Error: You cannot upload a new file while your current resume is pending review.";
    }
    else {
        // --- PROCEED WITH STANDARD UPLOAD LOGIC ---
        
        // Check if a file was selected
        if (empty($_FILES['resume_pdf']['name'])) {
            $error = "Error: Please select a PDF file to upload.";
        } 
        else {
            $file = $_FILES['resume_pdf'];
            $file_type = mime_content_type($file['tmp_name']);
            
            // Validation
            if ($file_type !== 'application/pdf') {
                $error = "Error: Only PDF files are allowed.";
            } 
            elseif ($file['size'] > 5000000) { // 5MB limit
                $error = "Error: File size is too large (Max 5MB).";
            } 
            else {
                // 1. Create the Uploads Folder if it doesn't exist
                $target_dir = "../assets/uploads/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                // 2. Generate a unique name
                $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $new_file_name = "resume_" . $user_id . "_" . time() . "." . $file_ext;
                $target_file_path = $target_dir . $new_file_name;

                // 3. Move the file
                if (move_uploaded_file($file['tmp_name'], $target_file_path)) {
                    
                    // 4. Save path to database
                    if (uploadResume($conn, $user_id, $target_file_path)) {
                        $message = "Resume uploaded successfully!";
                    } else {
                        $error = "Database Error: Could not save resume info.";
                    }

                } else {
                    $error = "Error: Failed to move uploaded file. Check folder permissions.";
                }
            }
        }
    }
}

// 2. Handle Resume Deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_resume_btn'])) {
    if (deleteResume($conn, $user_id)) {
        $message = "Resume deleted successfully.";
    } else {
        $error = "Error: Could not delete resume.";
    }
}

// 3. Fetch Data (For the View)
$resume = getResumeByUserId($conn, $user_id);

$feedback = null;
if ($resume && $resume['status'] == 'reviewed') {
    $feedback = getFeedbackByResumeId($conn, $resume['id']);
}

include '../views/seeker/dashboard_view.php';
?>