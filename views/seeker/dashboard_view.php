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