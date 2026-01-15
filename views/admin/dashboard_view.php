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