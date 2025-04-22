<?php 
session_start();
include '../db.php';

if(!isset($_SESSION['user_id'])) exit();

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT id, title, description, is_completed, created_at FROM tasks WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param('i',$user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<div class='card mb-2'>
            <div class='card-body'>
                <h5>" . htmlspecialchars($row['title']) . "</h5>
                <p>" . nl2br(htmlspecialchars($row['description'])) . "</p>
                <small class='text-muted'>Added on: " . $row['created_at'] . "</small>
            </div>
        </div>";
}

?>