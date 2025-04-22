<?php
$host = "localhost";
$username = "root";
$password = ""; // default for XAMPP/WAMP
$dbname = "task_manager";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
