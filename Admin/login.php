<?php
session_start();

// Include the database connection
$servername = "localhost"; // Change this if you're using a different server
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "empattendance"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if (isset($_POST['login'])) {
    // Sanitize input using mysqli_real_escape_string
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Sanitize password as well

    // Query for the admin
    $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Admin exists, start session
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: index.php"); // Redirect to dashboard
        exit();
    } else {
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form_container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .input_box {
            position: relative;
            margin-bottom: 20px;
            width: 100%;
        }

        .input_box input {
            width: 100%;
            padding: 12px;
            border: 1.5px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: all 0.2s ease;
        }

        .input_box input:focus {
            border-color: #7d2ae8;
        }

        .button {
            width: 100%;
            padding: 12px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: darkgreen;
        }

        .error_message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="form_container">
        <h2>Admin Login</h2>

        <!-- Error message display -->
        <?php if (isset($error)) { echo "<p class='error_message'>$error</p>"; } ?>

        <form method="POST" action="">
            <div class="input_box">
                <label for="username">Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="input_box">
                <label for="password">Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login" class="button">Login</button>
        </form>
    </div>
</body>
</html>