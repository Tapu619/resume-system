<?php
require_once '../config/db.php';

// 1. Get All Users (for the "Manage Users" section)
function getAllUsers($conn) {
    $sql = "SELECT * FROM users ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}



?>