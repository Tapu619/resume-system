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
    </style>
</head>
<body>

<div class="container">
    
    <a href="admin_dashboard.php" class="back-link">← Back to Dashboard</a>

    <div class="header">
        <h2>Add New System Administrator</h2>
    </div>

    <?php if ($message) echo "<div class='msg success'>$message</div>"; ?>
    <?php if ($error) echo "<div class='msg error'>$error</div>"; ?>

    <div class="form-card">
        <p style="margin-top: 0; color: #666; font-size: 0.9em; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
            <strong>Warning:</strong> The user created here will have full access to manage users and assign resumes.
        </p>