<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Seeker Dashboard</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">
    
    <div class="header">
        <h2>Job Seeker Dashboard</h2>
        <div class="user-info">
            <span>Welcome, <strong><?php echo $_SESSION['full_name']; ?></strong></span>
            
            <a href="profile.php" class="btn-link">My Profile</a>
            
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="msg success"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="msg error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div style="margin-bottom: 40px;">
        <h3>Upload New Resume</h3>
        <p style="color: #666;">Select a PDF file to submit for review. Uploading a new file will replace your previous submission.</p>
        
        <form action="" method="POST" enctype="multipart/form-data" novalidate>
            <input type="file" name="resume_pdf" accept="application/pdf" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            <button type="submit" class="btn-upload">Upload PDF</button>
        </form>
    </div>

    <h3>Your Resume Status</h3>
    
    <?php if ($resume): ?>
        <div class="status-box">
            
            <div class="file-row">
                <div>
                    <strong>Current File:</strong> 
                    <a href="<?php echo $resume['file_path']; ?>" target="_blank" style="color: #007bff;">View PDF</a>
                </div>

                <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this resume? This action cannot be undone.');" novalidate>
                    <button type="submit" name="delete_resume_btn" style="background-color: #dc3545; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer; font-size: 0.9em;">
                        Delete Resume
                    </button>
                </form>
            </div>
            
            <p>
                <strong>Upload Date:</strong> <?php echo date("F j, Y, g:i a", strtotime($resume['upload_date'])); ?>
            </p>
            
            <p>
                <strong>Status:</strong> 
                <span class="badge <?php echo $resume['status']; ?>">
                    <?php echo ucfirst($resume['status']); ?>
                </span>
            </p>

             <?php if ($resume['status'] == 'reviewed' && $feedback): ?>
                <div class="feedback-container">
                    <h4>Review Results</h4>
                    
                    <div class="score-display">
                        <div class="score-circle"><?php echo $feedback['score']; ?></div>
                        <div>
                            <div style="font-size: 1.2em; font-weight: bold;">Final Score / 100</div>
                            <div style="color: #666; font-size: 0.9em;">Reviewed by: <?php echo $feedback['reviewer_name']; ?></div>
                            <div style="color: #666; font-size: 0.9em;">Date: <?php echo date("M j, Y", strtotime($feedback['review_date'])); ?></div>
                        </div>
                    </div>

                    <strong>Reviewer Comments:</strong>
                    <div class="comment-box">
                        "<?php echo nl2br($feedback['feedback_comments']); ?>"
                    </div>
                </div>
            <?php elseif ($resume['status'] == 'pending'): ?>
                <p style="color: #856404; font-style: italic; margin-top: 15px;">
                    Your resume is currently in the queue. Please check back later for your score and feedback.
                </p>
            <?php endif; ?>
            
        </div>
    <?php else: ?>
        <p style="color: #777;">You have not uploaded a resume yet.</p>
    <?php endif; ?>

</div>

</body>
</html>