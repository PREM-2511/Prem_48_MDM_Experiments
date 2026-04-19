<?php
// delete.php
require 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare statement to prevent SQL Injection
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Successfully deleted, go back to display page
        header("Location: display.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
?>