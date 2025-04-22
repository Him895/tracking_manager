<?php
session_start();
include '../db.php';

if(!isset($_SESSION['user_id'])) exit();

$task_id = intval($_POST['task_id']);
$user_id = $_SESSION['user_id'];

// Get current status
$stmt = $conn->prepare("SELECT is_completed FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$current = $row['is_completed'];

// Toggle it
$new_status = $current ? 0 : 1;

$stmt = $conn->prepare("UPDATE tasks SET is_completed = ? WHERE id = ? AND user_id = ?");
$stmt->bind_param("iii", $new_status, $task_id, $user_id);
$stmt->execute();
echo "toggled";
?>