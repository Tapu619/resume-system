<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ResumeCheck</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <style>
        /* RESET & LAYOUT */
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #333;
        }

        /* NAVBAR */
        .navbar {
            background-color: white;
            padding: 18px 50px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar .logo {
            font-size: 1.4em;
            font-weight: 700;
            color: #007bff;
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .nav-links a {
            margin-left: 25px;
            text-decoration: none;
            color: #555;
            font-size: 0.95em;
            font-weight: 500;
            transition: color 0.2s;
        }
        .nav-links a:hover { color: #007bff; }

        /* HERO SECTION */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
            gap: 60px;
        }

        /* ANIMATION */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero-text {
            flex: 1;
            animation: fadeInUp 0.6s ease-out;
        }
        .hero-text h1 {
            font-size: 3.2em;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 20px;
            line-height: 1.1;
            letter-spacing: -1px;
        }
        .hero-text p {
            font-size: 1.15em;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
            max-width: 90%;
        }

        /* LOGIN CARD */
        .login-wrapper {
            flex: 0 0 400px;
            animation: fadeInUp 0.8s ease-out;
        }
        .login-card {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.02);
        }

        /* FORM ELEMENTS */
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 600;
            font-size: 0.9em;
        }
        .form-group input {
            width: 100%;
            padding: 14px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
            transition: all 0.2s;
            background-color: #f9fafb;
        }
        .form-group input:focus {
            background-color: white;
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 4px rgba(0,123,255,0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            font-family: 'Inter', sans-serif;
        }
        .btn-login:hover { background-color: #0069d9; }
        .btn-login:active { transform: scale(0.98); }

        /* LINKS */
        .auth-links {
            text-align: center;
            margin-top: 25px;
            font-size: 0.9em;
            color: #6b7280;
        }
        .auth-links a { color: #007bff; text-decoration: none; font-weight: 500; margin: 0 8px; }
        .auth-links a:hover { text-decoration: underline; }
        
        .footer {
            text-align: center;
            padding: 25px;
            color: #9ca3af;
            font-size: 0.85em;
        }

        /* Error Banner */
        .error-banner {
            background-color: #fef2f2;
            color: #dc2626;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 0.9em;
            border: 1px solid #fee2e2;
        }

        @media (max-width: 900px) {
            .main-content { flex-direction: column; padding: 20px; text-align: center; }
            .hero-text { margin-bottom: 40px; padding-right: 0; }
            .hero-text p { margin: 0 auto 30px auto; }
            .login-wrapper { width: 100%; max-width: 400px; }
            .navbar { padding: 15px 20px; }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="#" class="logo">ResumeCheck ✔</a>
        <div class="nav-links">
            <a href="#">About</a>
            <a href="register.php" style="color: #007bff; font-weight: 600;">Sign Up</a>
        </div>
    </nav>

    <div class="main-content">
        
        <div class="hero-text">
            <h1>Expert Feedback <br>for your Resume.</h1>
            <p>
                Get detailed grading and professional feedback to land your dream job. 
                Upload your CV today and let our experts handle the rest.
            </p>
        </div>

        <div class="login-wrapper">
            <div class="login-card">
                
                <h2 style="margin: 0 0 8px 0; color: #111;">Welcome Back</h2>
                <p style="margin: 0 0 25px 0; color: #6b7280; font-size: 0.95em;">
                    Please enter your details to sign in.
                </p>

                <div id="js-error-banner" class="error-banner" style="display: none;"></div>

                <?php if(isset($error_msg) && $error_msg): ?>
                    <div class="error-banner"><?php echo $error_msg; ?></div>
                <?php endif; ?>

                <form id="loginForm" action="" method="POST" novalidate>
                    
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" id="email" placeholder="name@company.com" 
                               value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" required>
                    </div>

                    <button type="submit" name="login_btn" class="btn-login">Sign In</button>
                    
                </form>

                <div class="auth-links">
                    <a href="forget_password.php">Forgot Password?</a>
                    <span style="color: #e5e7eb;">|</span>
                    <a href="register.php">Create an Account</a>
                </div>
            </div>
        </div>

    </div>

    <div class="footer">
        &copy; <?php echo date("Y"); ?> Resume Review System. All rights reserved.
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            
            // Get values
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorBox = document.getElementById('js-error-banner');

            // Hide box initially
            errorBox.style.display = 'none';

            // Check if empty (Using our helper function)
            if (empty(email) || empty(password)) {
                // Stop the form from sending to PHP
                e.preventDefault(); 
                
                // Show Error in the custom box
                errorBox.innerText = "Error: Please enter both email and password.";
                errorBox.style.display = 'block';
            }
        });

        // Helper: Custom empty() function (Like PHP)
        function empty(val) {
            if (val === undefined || val === null || val.trim() === "") {
                return true;
            }
            return false;
        }
    </script>

</body>
</html>