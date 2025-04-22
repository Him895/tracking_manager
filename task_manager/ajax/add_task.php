<?php 
session_start();

include '../db.php';

if(!isset($_SESSION['user_id'])) exit();

$user_id = $_SESSION['user_id'];
$title = trim($_POST['title']);
$description = trim($_POST['description']);

$stmt = $conn->prepare("INSERT INTO tasks(user_id, title, description) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $title, $description);
$stmt->execute();


?>