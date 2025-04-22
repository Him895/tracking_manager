<!-- register.php -->
<?php include 'db.php'; 

$success = "";
$error = "";

if(isset($_POST['register'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = ($_POST['password']);
    $cpassword = ($_POST['cpassword']);

    //basic validation

    if($password !== $cpassword){
         $error = "Passwords do not match!";
    }else{
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM users Where email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $error = "Email already exists!";
        }else{
            // insert new user
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
            $stmt->bind_param('sss', $name, $email, $hash);

            if($stmt->execute()){
                $success = "Registration successful! <a href='login.php'>Login now</a>";
            }else{
                $error = "Error registering user!";
            }
        }

    }
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="col-md-6 offset-md-3">
        <h2 class="mb-4">Create an Account</h2>

        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" required class="form-control">
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" required class="form-control">
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" required class="form-control">
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="cpassword" required class="form-control">
            </div>
            <button type="submit" name="register" class="btn btn-primary">Register</button>
            <a href="login.php" class="btn btn-link">Already have an account?</a>
        </form>
    </div>
</div>

</body>
</html>
