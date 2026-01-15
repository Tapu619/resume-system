!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grade Resume</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container" style="max-width: 800px;">
    
    <a href="reviewer_dashboard.php" class="btn-link">← Back to Dashboard</a>
    
    <div class="header">
        <h2>Grade Resume: <?php echo $resume_data['seeker_name']; ?></h2>
    </div>

    <?php if ($message) echo "<div class='msg success'>$message <br> <a href='reviewer_dashboard.php'>Return to List</a></div>"; ?>
    <?php if ($error) echo "<div class='msg error'>$error</div>"; ?>

    <?php if ($resume_data['status'] == 'reviewed' && empty($message)): ?>
        <div class="msg success">This resume has already been reviewed.</div>
    <?php elseif(empty($message)): ?>

        <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            
            <p style="margin-top: 0;">
                <strong>Resume File:</strong> 
                <a href="<?php echo $resume_data['file_path']; ?>" target="_blank" style="color: #007bff; font-weight: bold;">
                    Open PDF in New Tab
                </a>
            </p>
            <hr>