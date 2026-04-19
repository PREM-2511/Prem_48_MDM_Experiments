<?php
session_start(); // Always start the session at the very top!
require 'db.php'; // Reuse your working database connection

$message = '';

// Check if user is already logged in via Session or Cookie
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
} elseif (isset($_COOKIE['remember_user'])) {
    // Auto-login using the cookie
    $_SESSION['user_id'] = $_COOKIE['remember_user'];
    $_SESSION['username'] = $_COOKIE['remember_username'];
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    // Fetch user from database
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify the hashed password from Experiment 6
        if (password_verify($password, $user['password'])) {
            
            // 1. Set Session Variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // 2. Set Cookies if "Remember Me" is checked (expires in 30 days)
            if ($remember) {
                setcookie("remember_user", $user['id'], time() + (86400 * 30), "/"); 
                setcookie("remember_username", $user['username'], time() + (86400 * 30), "/");
            }
            
            header("Location: dashboard.php"); // Redirect to protected page
            exit();
        } else {
            $message = "Incorrect password!";
        }
    } else {
        $message = "No account found with that email!";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { max-width: 400px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        input[type="email"], input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
        button { background-color: #007bff; color: white; padding: 10px 15px; border: none; cursor: pointer; width: 100%; }
        .message { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Login</h2>
        <?php if($message != '') echo "<div class='message'>$message</div>"; ?>
        
        <form action="" method="POST">
            <label>Email</label>
            <input type="email" name="email" required>
            
            <label>Password</label>
            <input type="password" name="password" required>
            
            <div>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember Me (Set Cookie)</label>
            </div>
            <br>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>