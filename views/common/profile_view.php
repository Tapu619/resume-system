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
        
        #js-error-box { display: none; }
    </style>
</head>
<body>

    <?php 
        $dashboard_link = "../controllers/login.php"; 
        if(isset($_SESSION['role'])) {
            if($_SESSION['role'] == 'job_seeker') $dashboard_link = "seeker_dashboard.php";
            if($_SESSION['role'] == 'reviewer') $dashboard_link = "reviewer_dashboard.php";
            if($_SESSION['role'] == 'admin') $dashboard_link = "admin_dashboard.php";
        }
    ?>
    <a href="<?php echo $dashboard_link; ?>" class="back-link">← Back to Dashboard</a>

    <div id="js-error-box" class="alert error"></div>

    <?php if($success_msg) echo "<div id='php-success' class='alert success'>$success_msg</div>"; ?>
    <?php if($error_msg) echo "<div id='php-error' class='alert error'>$error_msg</div>"; ?>

    <div class="container">
        
        <div class="card">
            <h2>Update Profile</h2>
            <form id="profileForm" action="" method="POST" novalidate>
                <label>Full Name</label>
                <input type="text" name="full_name" id="full_name" value="<?php echo $user['full_name']; ?>" required>

                <label>Email (Cannot Change)</label>
                <input type="email" value="<?php echo $user['email']; ?>" readonly>

                <label>Phone Number</label>
                <input type="text" name="phone" id="phone" value="<?php echo $user['phone']; ?>" required>

                <label>Date of Birth</label>
                <input type="date" name="dob" id="dob" value="<?php echo $user['dob']; ?>" required>

                <button type="submit" name="update_profile_btn" class="btn-update">Save Changes</button>
            </form>
        </div>

        <div class="card">
            <h2>Change Password</h2>
            <form id="passForm" action="" method="POST" novalidate>
                <label>New Password</label>
                <input type="password" name="new_password" id="new_password" required>

                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>

                <button type="submit" name="change_pass_btn" class="btn-pass">Update Password</button>
            </form>
        </div>

    </div>

    <script>
        // 1. Validate Profile Info
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            
            // Clean up old messages first
            hideError();

            const name = document.getElementById('full_name').value;
            const phone = document.getElementById('phone').value;
            const dob = document.getElementById('dob').value;
            
            // A. Check Empty
            if (empty(name) || empty(phone) || empty(dob)) {
                e.preventDefault();
                showError("Error: All profile fields are required.");
                return;
            }

            // B. Check Phone
            const phoneRegex = /^01[0-9]{9}$/; 
            if (!phoneRegex.test(phone)) {
                e.preventDefault();
                showError("Error: Phone number must be exactly 11 digits (e.g. 017xxxxxxxx).");
                return;
            }

            // C. Check Age
            const birthDate = new Date(dob);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            if (age <= 16) {
                e.preventDefault();
                showError("Error: You must be older than 16 years old.");
                return;
            }
        });

        // 2. Validate Password Change
        document.getElementById('passForm').addEventListener('submit', function(e) {
            
            // Clean up old messages first
            hideError();

            const p1 = document.getElementById('new_password').value;
            const p2 = document.getElementById('confirm_password').value;

            if (empty(p1) || empty(p2)) {
                e.preventDefault();
                showError("Error: Please fill in both password fields.");
                return;
            }

            if (p1 !== p2) {
                e.preventDefault();
                showError("Error: New passwords do not match.");
                return;
            }
        });

        // --- HELPER FUNCTIONS ---

        function showError(msg) {
            const box = document.getElementById('js-error-box');
            box.innerText = msg;
            box.style.display = 'block';
            window.scrollTo(0, 0); 
        }

        // --- THE UPDATED FUNCTION ---
        // This now hides JS errors AND the old PHP messages
        function hideError() {
            // 1. Hide JS Error Box
            const jsBox = document.getElementById('js-error-box');
            jsBox.style.display = 'none';

            // 2. Hide PHP Success Message (if it exists)
            const phpSuccess = document.getElementById('php-success');
            if (phpSuccess) {
                phpSuccess.style.display = 'none';
            }

            // 3. Hide PHP Error Message (if it exists)
            const phpError = document.getElementById('php-error');
            if (phpError) {
                phpError.style.display = 'none';
            }
        }

        function empty(val) {
            if (val === undefined || val === null || val.trim() === "") {
                return true;
            }
            return false;
        }

    </script>

</body>
</html>