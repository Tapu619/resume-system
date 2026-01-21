<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <style>
        /* 1. Layout Styles */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            width: 100%;
            max-width: 500px;
            padding: 40px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        /* 2. Input & Form Styles */
        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        /* 3. Button Styles */
        .btn-register {
            width: 100%;
            padding: 12px;
            background-color: #28a745; 
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
            transition: 0.3s;
        }
        .btn-register:hover {
            background-color: #218838;
        }

        /* 4. AJAX Message Box */
        #msgBox { 
            display: none; 
            margin-bottom: 20px; 
            text-align: center; 
            padding: 10px;
            border-radius: 4px;
        }
        
        .role-group {
            display: flex;
            gap: 20px;
            margin-bottom: 10px;
            margin-top: 5px;
        }
        .role-group label {
            font-weight: normal;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /*  FOR EMAIL CHECK --- */
        .status-available {
            color: green;
            font-size: 0.85em;
            font-weight: bold;
            display: block;
            margin-top: -5px;
            margin-bottom: 10px;
        }
        .status-taken {
            color: red;
            font-size: 0.85em;
            font-weight: bold;
            display: block;
            margin-top: -5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 style="margin-top: 0; text-align: center; color: #333;">Create Account</h2>
    
    <div id="msgBox"></div>

    <form id="regForm" action="" method="POST" onsubmit="submitForm(event)" novalidate>
        
        <label style="font-weight: bold; color: #555;">I want to be a:</label>
        <div class="role-group">
            <label><input type="radio" name="role" value="job_seeker" style="width: auto; margin: 0;"> Job Seeker</label>
            <label><input type="radio" name="role" value="reviewer" style="width: auto; margin: 0;"> Reviewer</label>
        </div>

        <input type="text" name="full_name" placeholder="Full Name" id="full_name">
        
        <input type="email" name="email" placeholder="Email Address" id="email" onblur="checkEmail()">
        
        <span id="email_status"></span>

        <input type="text" name="phone" placeholder="Phone Number" id="phone">
        
        <label style="display:block; margin-top:10px; font-size:0.9em; font-weight: bold; color: #555;">Date of Birth:</label>
        <input type="date" name="dob" id="dob">
        
        <input type="password" name="password" placeholder="Password" id="password">

        <label style="display:block; margin-top:10px; font-size:0.9em; font-weight: bold; color: #555;">Security Question:</label>
        <select name="security_question" id="security_question">
            <option value="" disabled selected>Select a question...</option>
            <option value="What is your pet's name?">What is your pet's name?</option>
            <option value="What city were you born in?">What city were you born in?</option>
            <option value="What is your favorite color?">What is your favorite color?</option>
        </select>

        <input type="text" name="security_answer" placeholder="Your Answer" id="security_answer">

        <button type="submit" name="register_btn" class="btn-register" id="regBtn">Register Now</button>
    </form>
    
    <p style="text-align: center; margin-top: 20px; font-size: 0.9em;">
        Already have an account? <a href="login.php" style="color: #007bff; text-decoration: none;">Login here</a>
    </p>

</div>

<script>
    // CHECK EMAIL VIA AJAX 
    function checkEmail() {
        const email = document.getElementById('email').value;
        const statusSpan = document.getElementById('email_status');
        const regBtn = document.getElementById('regBtn');

        // Don't check if empty
        if(email.trim() === "") {
            statusSpan.innerHTML = "";
            return;
        }

        const formData = new FormData();
        formData.append('email', email);

        const xhttp = new XMLHttpRequest();
        xhttp.open("POST", "../controllers/check_email.php", true);
        
        xhttp.onload = function() {
            const data = JSON.parse(xhttp.responseText);
            
            if (data.status === 'available') {
                statusSpan.innerHTML = data.message;
                statusSpan.className = "status-available";
                regBtn.disabled = false; // Enable button
                regBtn.style.opacity = "1";
            } else {
                statusSpan.innerHTML = data.message;
                statusSpan.className = "status-taken";
                regBtn.disabled = true; // Disable button to prevent registration
                regBtn.style.opacity = "0.6";
            }
        }
        xhttp.send(formData);
    }

    // --- 2. EXISTING FORM SUBMIT FUNCTION ---
    function submitForm(e) {
        e.preventDefault();

        const form = document.getElementById('regForm');
        const formData = new FormData(form);
        
        const full_name = document.getElementById('full_name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const dob = document.getElementById('dob').value;
        const password = document.getElementById('password').value;
        const security_q = document.getElementById('security_question').value;
        const security_a = document.getElementById('security_answer').value;
        
        // JS Validation
        if (empty(full_name) || empty(email) || empty(phone) || empty(dob) || empty(password) || empty(security_q) || empty(security_a)) {
             showError("All fields are required.");
             return; 
        }

        if (phone.length !== 11 || isNaN(phone)) {
            showError("Phone number must be exactly 11 digits.");
            return;
        }

        const birthDate = new Date(dob);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        if (age <= 16) {
            showError("You must be older than 16 to register.");
            return;
        }
        
        // AJAX Registration Request
        formData.append('register_btn', true); 
        const xhttp = new XMLHttpRequest();
        
        xhttp.onload = function() {
            const data = JSON.parse(xhttp.responseText);
            const msgBox = document.getElementById("msgBox");
            msgBox.style.display = "block";
            msgBox.innerHTML = data.message;

            if (data.status === 'success') {
                msgBox.className = 'msg success';
                setTimeout(function() { window.location.href = 'login.php'; }, 1500);
            } else {
                msgBox.className = 'msg error';
            }
        }
        
        xhttp.open("POST", "../controllers/register.php", true);
        xhttp.send(formData);
    }

    function showError(msg) {
        const msgBox = document.getElementById("msgBox");
        msgBox.style.display = "block";
        msgBox.className = "msg error";
        msgBox.innerHTML = msg;
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