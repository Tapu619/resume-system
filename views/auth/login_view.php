<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Resume System</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; padding-top: 50px; background: #f4f4f4; }
        .container { background: white; padding: 30px; border-radius: 8px; width: 350px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; cursor: pointer; }
        button:hover { background: #218838; }
        .error { color: red; text-align: center; }
        .links { text-align: center; margin-top: 15px; font-size: 0.9em; }
        .links a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<div class="container">
    <h2 style="text-align: center;">Login</h2>

    <?php if(isset($error_msg)) echo "<p class='error'>$error_msg</p>"; ?>

    <form action="" method="POST">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="login_btn">Login</button>
    </form>

    <div class="links">
        <a href="forget_password.php">Forgot Password?</a><br><br>
        <a href="register.php">Don't have an account? Register</a>
    </div>
</div>

</body>
</html>