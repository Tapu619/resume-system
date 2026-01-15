<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; display: flex; gap: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); width: 100%; }
        h2 { border-bottom: 1px solid #eee; padding-bottom: 10px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        input[readonly] { background: #e9ecef; color: #666; cursor: not-allowed; }
        button { margin-top: 15px; padding: 10px; width: 100%; cursor: pointer; border: none; border-radius: 4px; color: white; }
        .btn-update { background: #007bff; }
        .btn-pass { background: #dc3545; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .back-link { display: block; margin-bottom: 20px; text-decoration: none; color: #333; font-weight: bold; }
    </style>
</head>