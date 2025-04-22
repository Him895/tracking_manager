<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Welcome, <?php echo $_SESSION['user_name']; ?> 👋</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- Add Task Form -->
    <div class="card mb-4">
        <div class="card-header">Add New Task</div>
        <div class="card-body">
            <form id="taskForm">
                <div class="mb-3">
                    <input type="text" name="title" id="title" class="form-control" placeholder="Task Title" required>
                </div>
                <div class="mb-3">
                    <textarea name="description" id="description" class="form-control" placeholder="Task Description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Task</button>
            </form>
        </div>
    </div>

    <!-- Task List -->
    <div id="taskList">
        <!-- Tasks will load here via AJAX -->
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){

        loadtask();

        $('#taskForm').on('submit', function(e){
            e.preventDefault();
            $.post('ajax/add_task.php', {
                title: $('#title').val(),
                description: $('#description').val()
            }, function(){
                $('#taskForm')[0].reset();
                loadtask();
            });
        });

        // 🧠 Re-bind delete/toggle buttons after tasks load
        function bindButtons() {
            $('.delete-btn').click(function(){
                let id = $(this).data('id');
                $.post('ajax/delete_task.php', {task_id: id}, function(){
                    loadtask();
                });
            });

            $('.toggle-btn').click(function(){
                let id = $(this).data('id');
                $.post('ajax/toggle_complete.php', {task_id: id}, function(){
                    loadtask();
                });
            });
        }

        function loadtask(){
            $('#taskList').load('ajax/load_task.php', function(){
                bindButtons(); // Bind buttons after content loads
            });
        }
    });


</script>
    
</body>
</html>
