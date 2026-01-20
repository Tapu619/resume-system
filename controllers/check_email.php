<?php
require_once '../config/db.php';

// Check if email is sent via POST
if (isset($_POST['email'])) {
    
    $email = trim($_POST['email']);
    
    // Query to check if email exists
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    // Return JSON response
    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['status' => 'taken', 'message' => 'Email already registered']);
    } else {
        echo json_encode(['status' => 'available', 'message' => 'Email available']);
    }
}
?>