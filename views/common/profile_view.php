<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; display: flex; gap: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); width: 100%; }
        h2 { border-bottom: 1px solid #eee; padding-bottom: 10px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        input[readonly] { background: #e9ecef; color: #666; cursor: not-allowed; }
        button { margin-top: 15px; padding: 10px; width: 100%; cursor: pointer; border: none; border-radius: 4px; color: white; }
        .btn-update { background: #007bff; }
        .btn-pass { background: #dc3545; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .back-link { display: block; margin-bottom: 20px; text-decoration: none; color: #333; font-weight: bold; }
    </style>
</head>
<body>

    <?php 
        $dashboard_link = "../controllers/login.php"; // Default fallback
        if($_SESSION['role'] == 'job_seeker') $dashboard_link = "seeker_dashboard.php";
        if($_SESSION['role'] == 'reviewer') $dashboard_link = "reviewer_dashboard.php";
        if($_SESSION['role'] == 'admin') $dashboard_link = "admin_dashboard.php";
    ?>
    <a href="<?php echo $dashboard_link; ?>" class="back-link">← Back to Dashboard</a>

    <?php if($success_msg) echo "<div class='alert success'>$success_msg</div>"; ?>
    <?php if($error_msg) echo "<div class='alert error'>$error_msg</div>"; ?>

    <div class="container">
        
        <div class="card">
            <h2>Update Profile</h2>
            <form action="" method="POST" novalidate>
                <label>Full Name</label>
                <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" required>

                <label>Email (Cannot Change)</label>
                <input type="email" value="<?php echo $user['email']; ?>" readonly>

                <label>Phone Number</label>
                <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>

                <label>Date of Birth</label>
                <input type="date" name="dob" value="<?php echo $user['dob']; ?>" required>

                <button type="submit" name="update_profile_btn" class="btn-update">Save Changes</button>
            </form>
        </div>

        <div class="card">
            <h2>Change Password</h2>
            <form action="" method="POST" novalidate>
                <label>New Password</label>
                <input type="password" name="new_password" required>

                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" required>

                <button type="submit" name="change_pass_btn" class="btn-pass">Update Password</button>
            </form>
        </div>

    </div>

</body>
</html>