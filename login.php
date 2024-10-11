<?php
session_start();

$conn = new mysqli("localhost", "root", "", "empattendance"); // Update with your database credentials

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = "";
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = md5($password);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$hashed_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch user data
        $_SESSION['username'] = $username; // Store username in session
        $_SESSION['fullname'] = $row['fullname']; // Store fullname in session
        header("Location: index.php"); // Redirect to index.php
        exit();
    } else {
        $msg = "<font color='red'>Invalid username or password!</font>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 100px;
        }
        .message {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Login</h5>
                        <form method="POST" action="">
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" required placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" required placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-success btn-block" name="login">Login</button>
                        </form>
                        <div class="message">
                            <?php if (!empty($msg)) echo $msg; ?>
                        </div>
                        <div class="text-center">
                            <a href="signup.php">Don't have an account? Sign up here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
