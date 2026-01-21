<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        label { font-weight: bold; color: #555; }
        .btn-create {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-create:hover { background-color: #218838; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #007bff; text-decoration: none; font-weight: bold; }
        
        /* Hide JS error box initially */
        #js-error-box { display: none; }
    </style>
</head>
<body>

<div class="container">
    
    <a href="admin_dashboard.php" class="back-link">← Back to Dashboard</a>

    <div class="header">
        <h2>Add New System Administrator</h2>
    </div>

    <div id="js-error-box" class="msg error"></div>

    <?php if ($message) echo "<div id='php-msg' class='msg success'>$message</div>"; ?>
    <?php if ($error) echo "<div id='php-err' class='msg error'>$error</div>"; ?>

    <div class="form-card">
        <p style="margin-top: 0; color: #666; font-size: 0.9em; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
            <strong>Warning:</strong> The user created here will have full access to manage users and assign resumes.
        </p>

        <form id="adminForm" action="" method="POST" novalidate>
            
            <label>Full Name</label>
            <input type="text" name="new_name" id="new_name">

            <label>Email Address</label>
            <input type="email" name="new_email" id="new_email">

            <label>Password</label>
            <input type="password" name="new_pass" id="new_pass">

            <div style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label>Phone Number</label>
                    <input type="text" name="new_phone" id="new_phone">
                </div>
                <div style="flex: 1;">
                    <label>Date of Birth</label>
                    <input type="date" name="new_dob" id="new_dob">
                </div>
            </div>

            <label>Security Question</label>
            <select name="new_question" id="new_question">
                <option value="What is your pet's name?">What is your pet's name?</option>
                <option value="What city were you born in?">What city were you born in?</option>
                <option value="What is your favorite color?">What is your favorite color?</option>
            </select>

            <label>Security Answer</label>
            <input type="text" name="new_answer" id="new_answer" placeholder="Answer for password recovery">

            <button type="submit" name="create_admin_btn" class="btn-create">
                Create Admin Account
            </button>
            
        </form>
    </div>

</div>

<script>
    document.getElementById('adminForm').addEventListener('submit', function(e) {
        
        // Clear previous errors
        hideError();

        // Get Values
        const name = document.getElementById('new_name').value;
        const email = document.getElementById('new_email').value;
        const pass = document.getElementById('new_pass').value;
        const phone = document.getElementById('new_phone').value;
        const dob = document.getElementById('new_dob').value;
        const answer = document.getElementById('new_answer').value;

       
        if (empty(name) || empty(email) || empty(pass) || empty(phone) || empty(dob) || empty(answer)) {
            e.preventDefault();
            showError("Error: All fields are required.");
            return;
        }

        
        const phoneRegex = /^01[0-9]{9}$/; 
        if (!phoneRegex.test(phone)) {
            e.preventDefault();
            showError("Error: Phone number must be exactly 11 digits (e.g. 017xxxxxxxx).");
            return;
        }

        
        const birthDate = new Date(dob);
        const today = new Date();
        
       
        const age = today.getFullYear() - birthDate.getFullYear();

        if (age <= 30) {
            e.preventDefault();
            showError("Error: Admin must be older than 30 years.");
            return;
        }
    });



    function showError(msg) {
        const box = document.getElementById('js-error-box');
        box.innerText = msg;
        box.style.display = 'block';
        window.scrollTo(0, 0); 
    }

    function hideError() {
        // Hide JS Error
        const jsBox = document.getElementById('js-error-box');
        jsBox.style.display = 'none';

        // Hide PHP Messages
        const phpMsg = document.getElementById('php-msg');
        if (phpMsg) phpMsg.style.display = 'none';

        const phpErr = document.getElementById('php-err');
        if (phpErr) phpErr.style.display = 'none';
    }

    // Custom empty() function 
    function empty(val) {
        if (val === undefined || val === null || val.trim() === "") {
            return true;
        }
        return false;
    }
</script>

</body>
</html>