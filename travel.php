<?php
session_start();

$conn = new mysqli("localhost", "root", "", "empattendance");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Manila');

$fullname = "";
$msg = "";
if (isset($_SESSION['username'])) {
    $fullname = $_SESSION['username'];
    $msg = "Welcome, $fullname!";
} else {
    // If user is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

$travel_msg = "";

// Handle travel order submission
if (isset($_POST['submit_travel_order'])) {
    $travel_date = $_POST['travel_date'];
    $destination = $_POST['destination'];
    $purpose = $_POST['purpose'];

    $sql = "INSERT INTO attedance (fullname, travel_date, destination, purpose) 
            VALUES ('$fullname', '$travel_date', '$destination', '$purpose')";

    if ($conn->query($sql) === TRUE) {
        $travel_msg = "<font color='green'>Travel order submitted successfully!</font>";
    } else {
        $travel_msg = "<font color='red'>Error submitting travel order: " . $conn->error . "</font>";
    }
}

// Fetch travel orders for the logged-in user
$travel_orders = [];
$sql = "SELECT * FROM attedance WHERE fullname='$fullname' ORDER BY travel_date DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $travel_orders[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/DICT-Logo-icon_only.png" rel="icon">
    <title>ATTENDANCE</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <style>
        .message {
            text-align: center;
            margin-top: 20px;
        }
        .message font {
            font-size: 18px;
        }
        .travel-orders {
            margin-top: 20px;
        }
        .travel-orders table {
            width: 100%;
            border-collapse: collapse;
        }
        .travel-orders th, .travel-orders td {
            border: 1px solid #ddd;
            padding: 8px;
        }
    </style>
</head>

<body class="bg-gradient-login" style="background-image: url('img/logo/loral1.jpg');">
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <img src="img/logo/DICT-Logo-icon_only.png" style="width:100px;height:100px">
                                        <br><br>
                                        <h1 class="h4 text-gray-900 mb-4">Department of Information and Communications Technology</h1>
                                        <div id="clock"></div>
                                        <div class="message"><?php echo $msg; ?></div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <?php if (!empty($action_msg)) echo $action_msg; ?>
                                    </div>

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="travel-order-tab" data-toggle="tab" href="#travel-order" role="tab" aria-controls="travel-order" aria-selected="true">Travel Order</a> 
                                        </li> 
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <!-- Travel Order -->
                                        <div class="tab-pane fade show active" id="travel-order" role="tabpanel" aria-labelledby="travel-order-tab">
                                            <h5 class="mt-4">Submit Travel Order</h5>
                                            <?php echo $travel_msg; ?>
                                            <form method="POST" action="">
                                                <div class="form-group">
                                                    <label for="travel_date">Travel Date:</label>
                                                    <input type="date" class="form-control" name="travel_date" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="destination">Destination:</label>
                                                    <input type="text" class="form-control" name="destination" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="purpose">Purpose:</label>
                                                    <textarea class="form-control" name="purpose" rows="3" required></textarea>
                                                </div>
                                                <div class="text-center mt-4">
                                        <button type="submit" name="submit_travel_order" class="btn btn-primary">Submit</button>
                                    </div>

                                    <div class="text-center mt-4">
                                        <div class="text-center mt-4">
                                            <a href="logout.php" class="btn btn-danger">Logout</a>
                                        </div>
                                            </form>

                                           
                                            </div>
                                        </div>
                                    </div>
                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
