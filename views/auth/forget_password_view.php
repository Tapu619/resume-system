<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; padding-top: 50px; background: #f4f4f4; }
        .container { background: white; padding: 30px; border-radius: 8px; width: 350px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; }
        .success { color: green; }
        h3 { margin-top: 0; }
    </style>
</head>
<body>

<div class="container">
    <h2>Reset Password</h2>
    
    <?php if(!empty($error_msg)) echo "<p class='error'>$error_msg</p>"; ?>
    <?php if(!empty($success_msg)) echo "<p class='success'>$success_msg</p>"; ?>

    <?php if ($step == 1): ?>
        <form method="POST" action="">
            <label>Enter your Registered Email:</label>
            <input type="email" name="email" required>
            <button type="submit" name="check_email_btn">Next</button>
        </form>

    <?php elseif ($step == 2): ?>
        <form method="POST" action="">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            
            <p><strong>Security Question:</strong><br> <?php echo $fetched_question; ?></p>
            
            <label>Your Answer:</label>
            <input type="text" name="security_answer" required>
            <button type="submit" name="check_answer_btn">Verify Answer</button>
        </form>

    <?php elseif ($step == 3): ?>
        <form method="POST" action="">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            
            <label>Enter New Password:</label>
            <input type="password" name="new_password" required>
            <button type="submit" name="reset_pass_btn">Update Password</button>
        </form>
    
    <?php endif; ?>

    <br>
    <a href="login.php">Back to Login</a>
</div>

</body>
</html>