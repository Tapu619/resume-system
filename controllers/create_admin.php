<?php
session_start();
require_once '../config/db.php';
require_once '../models/adminModel.php';

// 1. Security Check: Only Admins can enter this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$message = "";
$error = "";



// 3. Load the View
include '../views/admin/create_admin_view.php';

?>