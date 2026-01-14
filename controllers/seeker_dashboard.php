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
            // --- THE FIX STARTS HERE ---
            
            // 1. Create the Uploads Folder if it doesn't exist
            $target_dir = "../assets/uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            // 2. Generate a unique name (e.g., "resume_5_1720055.pdf") to prevent overwriting
            $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $new_file_name = "resume_" . $user_id . "_" . time() . "." . $file_ext;
            $target_file_path = $target_dir . $new_file_name;

            // 3. Move the file from temp storage to your folder
            if (move_uploaded_file($file['tmp_name'], $target_file_path)) {
                
                // 4. Save ONLY the path string to the database
                if (uploadResume($conn, $user_id, $target_file_path)) {
                    $message = "Resume uploaded successfully!";
                } else {
                    $error = "Database Error: Could not save resume info.";
                }

            } else {
                $error = "Error: Failed to move uploaded file. Check folder permissions.";
            }
            // --- THE FIX ENDS HERE ---
        }
    }
}

// 2. Handle Resume Deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_resume_btn'])) {
    // Optional: You could unlink() (delete) the actual file here too
    if (deleteResume($conn, $user_id)) {
        $message = "Resume deleted successfully.";
    } else {
        $error = "Error: Could not delete resume.";
    }
}

// 3. Fetch Data
$resume = getResumeByUserId($conn, $user_id);

$feedback = null;
if ($resume && $resume['status'] == 'reviewed') {
    $feedback = getFeedbackByResumeId($conn, $resume['id']);
}

include '../views/seeker/dashboard_view.php';
?>