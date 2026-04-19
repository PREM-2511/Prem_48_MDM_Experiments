<?php
// search.php
require 'db.php';

$query = isset($_GET['q']) ? $_GET['q'] : '';

// Search both username and email using LIKE
$sql = "SELECT id, username, email, created_at FROM users WHERE username LIKE ? OR email LIKE ?";
$stmt = $conn->prepare($sql);

$searchTerm = "%" . $query . "%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>" . htmlspecialchars($row['username']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>{$row['created_at']}</td>
                <td>
                    <a href='edit.php?id={$row['id']}' class='btn-edit'>Edit</a>
                    <a href='delete.php?id={$row['id']}' class='btn-delete' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No matching users found.</td></tr>";
}

$stmt->close();
$conn->close();
?>