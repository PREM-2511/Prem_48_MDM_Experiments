<?php
// edit.php
require 'db.php';

// Check if an ID was passed
if (!isset($_GET['id'])) {
    header("Location: display.php");
    exit();
}

$id = $_GET['id'];
$message = '';

// Handle the form submission (Update)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    if (empty($username) || empty($email)) {
        $message = "Username and Email are required.";
    } else {
        $stmt = $conn->prepare("UPDATE users SET username=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $username, $email, $id);

        if ($stmt->execute()) {
            header("Location: display.php"); // Go back to display on success
            exit();
        } else {
            $message = "Error updating record: " . $conn->error;
        }
        $stmt->close();
    }
}

// Fetch current user data to pre-fill the form
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { max-width: 400px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        input[type="text"], input[type="email"] { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
        button { background-color: #ffc107; color: black; padding: 10px 15px; border: none; cursor: pointer; width: 100%; }
        .message { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit User</h2>
        <?php if($message != '') echo "<div class='message'>$message</div>"; ?>
        
        <form action="" method="POST">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            
            <button type="submit">Update User</button>
        </form>
        <br>
        <a href="display.php">Cancel</a>
    </div>
</body>
</html>