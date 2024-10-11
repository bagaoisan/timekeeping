<?php
session_start();

$conn = new mysqli("localhost", "root", "", "empattendance"); // Update with your database credentials

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = "";
if (isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        $msg = "<font color='red'>Passwords do not match!</font>";
    } else {
        // Check if the username already exists
        $checkUsernameQuery = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($checkUsernameQuery);
        
        if ($result->num_rows > 0) {
            $msg = "<font color='red'>Username is already taken!</font>";
        } else {
            $hashed_password = md5($password);
            $hashed_confirm_password = md5($confirm_password);
            $sql = "INSERT INTO users (username, fullname, position, password, confirm_password) VALUES ('$username', '$fullname', '$position', '$hashed_password','$hashed_confirm_password')";
            
            if ($conn->query($sql) === TRUE) {
                $msg = "<font color='green'>Signup successful! You can now login.</font>";
            } else {
                $msg = "<font color='red'>Error: " . $conn->error . "</font>";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Signup</title>
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
                        <h5 class="card-title text-center">Signup</h5>
                        <form method="POST" action="">
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" required placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="fullname" required placeholder="Full Name">
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="position" required>
                                    <option value="" disabled selected>Select Position</option>
                                    <option value="Employee">Employee</option>
                                    <option value="CEO">CEO</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" required placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="confirm_password" required placeholder="Confirm Password">
                            </div>
                            <button type="submit" class="btn btn-success btn-block" name="signup">Sign Up</button>
                        </form>
                        <div class="message">
                            <?php if (!empty($msg)) echo $msg; ?>
                        </div>
                        <div class="text-center">
                            <a href="login.php">Already have an account? Login here</a>
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
