<?php
session_start();
require_once '../config/db.php';
require_once '../models/adminModel.php'; 

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Access Denied']);
    exit;
}

// Handle the AJAX Request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    
    header('Content-Type: application/json');
    
    $user_id_to_delete = $_POST['user_id'];

    // Prevent deleting yourself 
    if ($user_id_to_delete == $_SESSION['user_id']) {
        echo json_encode(['status' => 'error', 'message' => 'You cannot delete yourself.']);
        exit;
    }

    // Call the Model to delete
    if (deleteUser($conn, $user_id_to_delete)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    }
    exit;
}
?>