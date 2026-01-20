<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f0f2f5; margin: 0; }
        .container { width: 100%; max-width: 400px; padding: 40px; background: white; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 10px; }
        .btn-submit:hover { background-color: #0056b3; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #666; text-decoration: none; }
        
        /* Hidden JS Error Box */
        #js-error-box { display: none; }
    </style>
</head>
<body>

<div class="container">
    
    <h2 style="text-align: center; margin-top: 0;">Reset Password</h2>

    <div id="js-error-box" class="msg error"></div>

    <?php if ($error): ?>
        <div id="php-err" class="msg error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($message): ?>
        <div id="php-msg" class="msg success"><?php echo $message; ?></div>
    <?php endif; ?>


    <?php if ($step == 1): ?>
        <p>Enter your registered email address to find your account.</p>
        
        <form id="emailForm" action="" method="POST" novalidate>
            <input type="email" name="email" id="email" placeholder="Enter Email Address">
            <button type="submit" name="verify_email_btn" class="btn-submit">Next</button>
        </form>
    <?php endif; ?>


    <?php if ($step == 2): ?>
        <p>Security Check:</p>
        <div style="background: #f9f9f9; padding: 10px; border-left: 4px solid #007bff; margin-bottom: 15px;">
            <strong><?php echo $_SESSION['security_question']; ?></strong>
        </div>
        
        <form id="answerForm" action="" method="POST" novalidate>
            <input type="text" name="security_answer" id="security_answer" placeholder="Your Answer">
            <button type="submit" name="verify_answer_btn" class="btn-submit">Verify Answer</button>
        </form>
    <?php endif; ?>


    <?php if ($step == 3): ?>
        <p>Set your new password.</p>
        
        <form id="passForm" action="" method="POST" novalidate>
            <input type="password" name="new_password" id="new_password" placeholder="New Password">
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm New Password">
            <button type="submit" name="reset_pass_btn" class="btn-submit">Reset Password</button>
        </form>
    <?php endif; ?>

    <?php if($step < 4): ?>
        <a href="login.php" class="back-link">← Back to Login</a>
    <?php endif; ?>

</div>

<script>
    // Since the forms appear conditionally, we check if they exist before attaching listeners

    // --- VALIDATION FOR STEP 1 (EMAIL) ---
    const emailForm = document.getElementById('emailForm');
    if (emailForm) {
        emailForm.addEventListener('submit', function(e) {
            hideError();
            const email = document.getElementById('email').value;

            if (empty(email)) {
                e.preventDefault();
                showError("Error: Please enter your email address.");
            }
        });
    }

    // --- VALIDATION FOR STEP 2 (ANSWER) ---
    const answerForm = document.getElementById('answerForm');
    if (answerForm) {
        answerForm.addEventListener('submit', function(e) {
            hideError();
            const answer = document.getElementById('security_answer').value;

            if (empty(answer)) {
                e.preventDefault();
                showError("Error: Please enter your security answer.");
            }
        });
    }

    // --- VALIDATION FOR STEP 3 (PASSWORD RESET) ---
    const passForm = document.getElementById('passForm');
    if (passForm) {
        passForm.addEventListener('submit', function(e) {
            hideError();
            const p1 = document.getElementById('new_password').value;
            const p2 = document.getElementById('confirm_password').value;

            // A. Check Empty
            if (empty(p1) || empty(p2)) {
                e.preventDefault();
                showError("Error: Please fill in both password fields.");
                return;
            }

            // B. Check Matching
            if (p1 !== p2) {
                e.preventDefault();
                showError("Error: Passwords do not match.");
                return;
            }
        });
    }


    // --- HELPER FUNCTIONS ---

    function showError(msg) {
        const box = document.getElementById('js-error-box');
        box.innerText = msg;
        box.style.display = 'block';
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

    function empty(val) {
        if (val === undefined || val === null || val.trim() === "") {
            return true;
        }
        return false;
    }
</script>

</body>
</html>