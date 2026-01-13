<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Resume Review System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 400px;
        }
        h2 { text-align: center; color: #333; margin-top: 0; }
        
        label { display: block; margin-top: 10px; font-weight: bold; font-size: 0.9em; }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; /* Ensures padding doesn't widen the box */
        }
        
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover { background-color: #0056b3; }
        
        .error { color: red; background: #ffe6e6; padding: 10px; border-radius: 4px; text-align: center; }
        .success { color: green; background: #e6ffe6; padding: 10px; border-radius: 4px; text-align: center; }
        
        .login-link { text-align: center; margin-top: 15px; font-size: 0.9em; }
        .login-link a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Create Account</h2>

        <?php if(isset($error_msg) && !empty($error_msg)) { echo "<p class='error'>$error_msg</p>"; } ?>
        <?php if(isset($success_msg) && !empty($success_msg)) { echo "<p class='success'>$success_msg</p>"; } ?>

        <form action="" method="POST">
            
            <label>Full Name</label>
            <input type="text" name="full_name" placeholder="Enter full name" required>

            <label>Email Address</label>
            <input type="email" name="email" placeholder="example@email.com" required>

            <label>Phone Number</label>
            <input type="tel" name="phone" placeholder="017xxxxxxxx" required>

            <label>Date of Birth</label>
            <input type="date" name="dob" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Create a password" required>

            <label>Security Question (for recovery)</label>
            <select name="security_question" required>
                <option value="" disabled selected>Select a question...</option>
                <option value="What is your pet's name?">What is your pet's name?</option>
                <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                <option value="What city were you born in?">What city were you born in?</option>
                <option value="What is your favorite color?">What is your favorite color?</option>
            </select>

            <label>Security Answer</label>
            <input type="text" name="security_answer" placeholder="Type your answer" required>

            <label>I want to register as:</label>
            <select name="role">
                <option value="job_seeker">Job Seeker (I want a review)</option>
                <option value="reviewer">Reviewer (I will review resumes)</option>
            </select>

            <button type="submit" name="register_btn">Register</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>

</body>
</html>