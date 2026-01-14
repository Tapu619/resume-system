<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <style>
        /* 1. Layout Styles (Matches Login Page) */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px; /* Prevents edges touching on small screens */
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            width: 100%;
            max-width: 500px; /* Slightly wider than login for the extra fields */
            padding: 40px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        /* 2. Input & Form Styles */
        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0; /* Consistent spacing */
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        /* 3. Button Styles */
        .btn-register {
            width: 100%;
            padding: 12px;
            background-color: #28a745; /* Green for Register */
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

        /* 4. AJAX Message Box (Hidden by default) */
        #msgBox { 
            display: none; 
            margin-bottom: 20px; 
            text-align: center; 
            padding: 10px;
            border-radius: 4px;
        }
        
        /* Helper for the radio buttons layout */
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
        <input type="email" name="email" placeholder="Email Address" id="email">
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

        <button type="submit" name="register_btn" class="btn-register">Register Now</button>
    </form>
    
    <p style="text-align: center; margin-top: 20px; font-size: 0.9em;">
        Already have an account? <a href="login.php" style="color: #007bff; text-decoration: none;">Login here</a>
    </p>

</div>

<script>
    function submitForm(e) {
        // 1. Stop the page from reloading
        e.preventDefault();

        // 2. Get the form data automatically
        const form = document.getElementById('regForm');
        const formData = new FormData(form);
        formData.append('register_btn', true); // Add the button trigger manually

        // 3. Create the Request
        const xhttp = new XMLHttpRequest();

        // Define what happens when the data loads
        xhttp.onload = function() {
            // A. Parse the JSON response from PHP
            const data = JSON.parse(xhttp.responseText);
            
            // B. Find the message box
            const msgBox = document.getElementById("msgBox");
            msgBox.style.display = "block";
            msgBox.innerHTML = data.message;

            // C. Check status (success or error)
            if (data.status === 'success') {
                msgBox.className = 'msg success'; // Uses style.css green box
                
                // Redirect to login after 1.5 seconds
                setTimeout(function() {
                    window.location.href = 'login.php';
                }, 1500);
            } else {
                msgBox.className = 'msg error'; // Uses style.css red box
            }
        }

        // 4. Send the request
        xhttp.open("POST", "../controllers/register.php", true);
        xhttp.send(formData);
    }
</script>

</body>
</html>