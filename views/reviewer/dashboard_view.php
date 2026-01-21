<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reviewer Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* Specific styles for status badges */
        .status-badge { padding: 5px 10px; border-radius: 12px; font-size: 0.8em; font-weight: bold; }
        .pending { background: #fff3cd; color: #856404; }
        .reviewed { background: #d4edda; color: #155724; }
        
        /* Action Button */
        .btn-grade { 
            background-color: #007bff; color: white; text-decoration: none; 
            padding: 8px 15px; border-radius: 4px; font-size: 0.9em; display: inline-block;
        }
        .btn-grade:hover { background-color: #0056b3; }
        
        /* Disabled button for already reviewed items */
        .btn-disabled {
            background-color: #ccc; color: #666; pointer-events: none; text-decoration: none;
            padding: 8px 15px; border-radius: 4px; font-size: 0.9em;
        }
    </style>
</head>
<body>

<div class="container" style="max-width: 1000px;">
    
    <div class="header">
        <h2>Reviewer Portal</h2>
        <div class="user-info">
            <span>Welcome, <strong><?php echo $_SESSION['full_name']; ?></strong></span>
            <a href="profile.php" class="btn-link">My Profile</a>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </div>

    <h3>Assigned Resumes</h3>
    
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #ddd;">
                    <th style="padding: 15px; text-align: left;">Job Seeker</th>
                    <th style="padding: 15px; text-align: left;">Upload Date</th>
                    <th style="padding: 15px; text-align: left;">Resume File</th>
                    <th style="padding: 15px; text-align: left;">Status</th>
                    <th style="padding: 15px; text-align: left;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($my_resumes as $resume): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px;"><strong><?php echo $resume['seeker_name']; ?></strong></td>
                    <td style="padding: 15px;"><?php echo date("M d, Y", strtotime($resume['upload_date'])); ?></td>
                    
                    <td style="padding: 15px;">
                        <a href="<?php echo $resume['file_path']; ?>" target="_blank" style="color: #007bff; text-decoration: none;">
                            View PDF
                        </a>
                    </td>
                    
                    <td style="padding: 15px;">
                        <span class="status-badge <?php echo $resume['status']; ?>">
                            <?php echo ucfirst($resume['status']); ?>
                        </span>
                    </td>
                    
                    <td style="padding: 15px;">
                        <?php if($resume['status'] == 'pending'): ?>
                            <a href="submit_review.php?id=<?php echo $resume['id']; ?>" class="btn-grade">
                                Grade This
                            </a>
                        <?php else: ?>
                            <span class="btn-disabled">Completed</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if(empty($my_resumes)): ?>
                    <tr><td colspan="5" style="padding: 30px; text-align: center; color: #888;">No resumes assigned to you yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>