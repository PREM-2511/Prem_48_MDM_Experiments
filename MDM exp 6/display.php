<?php
// display.php
require 'db.php';

$sql = "SELECT id, username, email, created_at FROM users ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registered Users</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .controls { display: flex; justify-content: space-between; margin-bottom: 20px; }
        input[type="text"] { padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 4px;}
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f4f4f4; }
        .nav-link { text-decoration: none; color: #007bff; }
        .btn-edit { color: white; background-color: #ffc107; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .btn-delete { color: white; background-color: #dc3545; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
    </style>
</head>
<body>
    <h2>Registered Users Dashboard</h2>
    
    <div class="controls">
        <a href="register.php" class="nav-link">&larr; Add New User</a>
        <input type="text" id="searchBox" placeholder="Search by username or email...">
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Registration Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="userData">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>" . htmlspecialchars($row['username']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td>{$row['created_at']}</td>
                            <td>
                                <a href='edit.php?id={$row['id']}' class='btn-edit'>Edit</a>
                                <a href='delete.php?id={$row['id']}' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        document.getElementById('searchBox').addEventListener('keyup', function() {
            let query = this.value;

            // Use the Fetch API to send data to our search backend
            fetch(`search.php?q=${encodeURIComponent(query)}`)
                .then(response => response.text())
                .then(data => {
                    // Update the table body with the results
                    document.getElementById('userData').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>