<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <style>
        /* Admin-Specific Table Styles */
        .section-title { 
            margin-top: 40px; 
            margin-bottom: 15px; 
            font-size: 1.2em; 
            color: #333; 
            border-left: 5px solid #007bff; 
            padding-left: 10px; 
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            background: white;
            border: 1px solid #eee;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            min-width: 600px;
        }

        th { 
            background-color: #f8f9fa; 
            color: #555; 
            font-weight: bold; 
            text-transform: uppercase; 
            font-size: 0.85em; 
            padding: 15px; 
            text-align: left;
            border-bottom: 2px solid #ddd;
        }

        td { 
            padding: 15px; 
            border-bottom: 1px solid #eee; 
            color: #444; 
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }
        tr:hover { background-color: #fafafa; }

        select { 
            padding: 8px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            width: 100%; 
            max-width: 200px;
        }

        /* Action Buttons */
        .btn-assign { 
            background-color: #007bff; color: white; border: none; 
            padding: 8px 12px; border-radius: 4px; cursor: pointer; font-size: 0.9em; 
        }
        .btn-assign:hover { background-color: #0056b3; }

        .btn-delete { 
            background-color: #fff; color: #dc3545; border: 1px solid #dc3545; 
            padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 0.9em; 
        }
        .btn-delete:hover { background-color: #dc3545; color: white; }
        
        .role-badge {
            display: inline-block; padding: 4px 8px; border-radius: 4px;
            font-size: 0.8em; font-weight: bold; background: #e9ecef; color: #495057;
        }
    </style>
</head>
<body>

<div class="container" style="max-width: 1100px;">
    
    <div class="header">
        <h2>Admin Panel</h2>
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


    <div style="display: flex; gap: 20px; margin-bottom: 40px; flex-wrap: wrap;">
        
        <div style="flex: 1; min-width: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 0.9em; opacity: 0.9;">Average Resume Score</div>
            <div style="font-size: 2.5em; font-weight: bold; margin-top: 10px;">
                <?php echo $system_stats['avg_score']; ?>
            </div>
            <div style="font-size: 0.8em; opacity: 0.8;">Out of 100</div>
        </div>

        <div style="flex: 1; min-width: 200px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #007bff;">
            <div style="color: #666; font-size: 0.9em; font-weight: bold;">TOTAL UPLOADS</div>
            <div style="font-size: 2em; font-weight: bold; color: #333; margin-top: 5px;">
                <?php echo $system_stats['total']; ?>
            </div>
        </div>

        <div style="flex: 1; min-width: 200px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #28a745;">
            <div style="color: #666; font-size: 0.9em; font-weight: bold;">REVIEWED</div>
            <div style="font-size: 2em; font-weight: bold; color: #28a745; margin-top: 5px;">
                <?php echo $system_stats['reviewed']; ?>
            </div>
        </div>

        <div style="flex: 1; min-width: 200px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #ffc107;">
            <div style="color: #666; font-size: 0.9em; font-weight: bold;">PENDING</div>
            <div style="font-size: 2em; font-weight: bold; color: #ffc107; margin-top: 5px;">
                <?php echo $system_stats['pending']; ?>
            </div>
        </div>

    </div>


    <h3 class="section-title">Resume Management</h3>
    
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width: 20%;">Job Seeker</th>
                    <th style="width: 15%;">Resume File</th>
                    <th style="width: 15%;">Status</th>
                    <th style="width: 35%;">Assigned Reviewer</th>
                    <th style="width: 15%;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_resumes as $resume): ?>
                <tr>
                    <td>
                        <strong><?php echo $resume['seeker_name']; ?></strong><br>
                        <span style="font-size: 0.85em; color: #888;">
                            <?php echo date("M d, Y", strtotime($resume['upload_date'])); ?>
                        </span>
                    </td>
                    
                    <td>
                        <a href="<?php echo $resume['file_path']; ?>" target="_blank" style="color: #007bff; text-decoration: none;">
                            📄 View PDF
                        </a>
                    </td>
                    
                    <td>
                        <span class="badge <?php echo $resume['status']; ?>">
                            <?php echo ucfirst($resume['status']); ?>
                        </span>
                    </td>
