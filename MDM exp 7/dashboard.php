<?php
session_start();

// THE BOUNCER: If the user doesn't have a session VIP wristband, kick them out!
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; background-color: #f4f4f9;}
        .card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); max-width: 600px; margin: auto; text-align: center; }
        .btn-logout { background-color: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px;}
    </style>
</head>
<body>
    <div class="card">
        <h2>Welcome to your Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        
        <p>You have successfully authenticated using PHP Sessions.</p>
        <p>Try refreshing the page, or opening a new tab. You will stay logged in because your Session state is being maintained!</p>
        
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</body>
</html>