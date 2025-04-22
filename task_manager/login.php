<?php 
session_start();
include 'db.php';

$error = "";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    //get user from database with the same email and password

    $stmt = $conn->prepare("SELECT id,name,password FROM users where email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows === 1){
        $stmt->bind_result($id,$name,$hashed_password);
        $stmt->fetch();

        //verify password
        if(password_verify($password, $hashed_password)){
            //password is correct, set session variables
            
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;

            header("Location: index.php");
            exit();
        }else{
            $error = "Invalid email or password!";

        }
    }else{
        $error = "no user found on this email!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="col-md-6 offset-md-3">
        <h2 class="mb-4">Login</h2>

        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" required class="form-control">
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" required class="form-control">
            </div>
            <button type="submit" name="login" class="btn btn-success">Login</button>
            <a href="register.php" class="btn btn-link">Create an account</a>
        </form>
    </div>
</div>

</body>
</html>
