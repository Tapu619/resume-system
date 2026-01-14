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
    </style>
</head>
<body>

<div class="container">
    
    <h2 style="text-align: center; margin-top: 0;">Reset Password</h2>

    <?php if ($error): ?>
        <div class="msg error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($message): ?>
        <div class="msg success"><?php echo $message; ?></div>
    <?php endif; ?>


    <?php if ($step == 1): ?>
        <p>Enter your registered email address to find your account.</p>
        <form action="" method="POST" novalidate>
            <input type="email" name="email" placeholder="Enter Email Address">
            <button type="submit" name="verify_email_btn" class="btn-submit">Next</button>
        </form>
    <?php endif; ?>


    <?php if ($step == 2): ?>
        <p>Security Check:</p>
        <div style="background: #f9f9f9; padding: 10px; border-left: 4px solid #007bff; margin-bottom: 15px;">
            <strong><?php echo $_SESSION['security_question']; ?></strong>
        </div>
        
        <form action="" method="POST" novalidate>
            <input type="text" name="security_answer" placeholder="Your Answer">
            <button type="submit" name="verify_answer_btn" class="btn-submit">Verify Answer</button>
        </form>
    <?php endif; ?>


    <?php if ($step == 3): ?>
        <p>Set your new password.</p>
        <form action="" method="POST" novalidate>
            <input type="password" name="new_password" placeholder="New Password">
            <input type="password" name="confirm_password" placeholder="Confirm New Password">
            <button type="submit" name="reset_pass_btn" class="btn-submit">Reset Password</button>
        </form>
    <?php endif; ?>

    <?php if($step < 4): ?>
        <a href="login.php" class="back-link">← Back to Login</a>
    <?php endif; ?>

</div>

</body>
</html>