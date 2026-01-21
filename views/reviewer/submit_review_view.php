<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grade Resume</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* Hide JS error box initially */
        #js-error-box { display: none; }
    </style>
</head>
<body>

<div class="container" style="max-width: 800px;">
    
    <a href="reviewer_dashboard.php" class="btn-link">← Back to Dashboard</a>
    
    <div class="header">
        <h2>Grade Resume: <?php echo $resume_data['seeker_name']; ?></h2>
    </div>

    <div id="js-error-box" class="msg error"></div>

    <?php if ($message): ?>
        <div id="php-msg" class="msg success">
            <?php echo $message; ?> <br> <a href='reviewer_dashboard.php'>Return to List</a>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div id="php-err" class="msg error"><?php echo $error; ?></div>
    <?php endif; ?>

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

            <form id="gradeForm" action="" method="POST" novalidate>
                
                <label style="font-weight: bold; display: block; margin-top: 20px;">Score (0 - 100):</label>
                <input type="number" name="score" id="score" min="0" max="100" 
                       style="width: 100px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1.1em;">

                <label style="font-weight: bold; display: block; margin-top: 20px;">Feedback Comments:</label>
                <textarea name="comments" id="comments" rows="6" 
                          style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: sans-serif;"
                          placeholder="Write your feedback here..."></textarea>

                <button type="submit" name="submit_review_btn" 
                        style="margin-top: 20px; width: 100%; padding: 12px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1.1em;">
                    Submit Final Review
                </button>

            </form>
        </div>

    <?php endif; ?>

</div>

<script>
    document.getElementById('gradeForm').addEventListener('submit', function(e) {
        
        // Clear previous errors
        hideError();

       
        const score = document.getElementById('score').value;
        const comments = document.getElementById('comments').value;

        
        if (empty(score)) {
            e.preventDefault();
            showError("Error: Please enter a score.");
            return;
        }

      
        if (score < 0 || score > 100) {
            e.preventDefault();
            showError("Error: Score must be between 0 and 100.");
            return;
        }

       
        if (empty(comments)) {
            e.preventDefault();
            showError("Error: Feedback comments cannot be empty.");
            return;
        }
    });


    // custom functions

    function showError(msg) {
        const box = document.getElementById('js-error-box');
        box.innerText = msg;
        box.style.display = 'block';
        window.scrollTo(0, 0); 
    }

    function hideError() {
        const jsBox = document.getElementById('js-error-box');
        jsBox.style.display = 'none';

       
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