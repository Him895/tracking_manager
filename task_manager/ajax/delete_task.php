<?php
session_start();
include '../db.php';

if(!isset($_SESSION['user_id'])) exit();

$task_id = intval($_POST['task_id']);
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();
echo "deleted";
?>