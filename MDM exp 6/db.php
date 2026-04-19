<?php
// db.php
$host = '127.0.0.1';
$user = 'root'; 
$pass = '';     
$dbname = 'mdm_exp6';
$port = 3306; 

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>