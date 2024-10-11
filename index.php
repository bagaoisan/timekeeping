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

$login_date = date('Y-m-d'); 
$login_time = date('H:i:s');  
$action_msg = "";

// Morning Time In
if (isset($_POST['morning_time_in'])) {
    $sql = "SELECT * FROM attedance WHERE fullname='$fullname' AND login_date='$login_date'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // If a row exists for the day, update the morning time in
        $sql = "UPDATE attedance SET morning_time_in='$login_time' 
                WHERE fullname='$fullname' AND login_date='$login_date'";
    } else {
        // Otherwise, insert a new row
        $sql = "INSERT INTO attedance (fullname, login_date, morning_time_in) 
                VALUES ('$fullname', '$login_date', '$login_time')";
    }

    if ($conn->query($sql) === TRUE) {
        $action_msg = "<font color='green'>You have successfully timed in at $login_time (AM) on $login_date.</font>";
    } else {
        $action_msg = "<font color='red'>Error recording time in: " . $conn->error . "</font>";
    }
}

// Morning Time Out
if (isset($_POST['morning_time_out'])) {
    $sql = "UPDATE attedance SET morning_time_out='$login_time' 
            WHERE fullname='$fullname' AND login_date='$login_date' AND morning_time_out IS NULL";
    if ($conn->query($sql) === TRUE) {
        $action_msg = "<font color='green'>You have successfully timed out at $login_time (AM).</font>";
    } else {
        $action_msg = "<font color='red'>Error recording time out: " . $conn->error . "</font>";
    }
}

// Afternoon Time In
if (isset($_POST['afternoon_time_in'])) {
    $sql = "SELECT * FROM attedance WHERE fullname='$fullname' AND login_date='$login_date'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Update the afternoon time in if row exists
        $sql = "UPDATE attedance SET afternoon_time_in='$login_time' 
                WHERE fullname='$fullname' AND login_date='$login_date'";
    } else {
        // Insert a new row (this case should rarely happen, but just in case)
        $sql = "INSERT INTO attedance (fullname, login_date, afternoon_time_in) 
                VALUES ('$fullname', '$login_date', '$login_time')";
    }

    if ($conn->query($sql) === TRUE) {
        $action_msg = "<font color='green'>You have successfully timed in at $login_time (PM) on $login_date.</font>";
    } else {
        $action_msg = "<font color='red'>Error recording time in: " . $conn->error . "</font>";
    }
}

// Afternoon Time Out
if (isset($_POST['afternoon_time_out'])) {
    $sql = "UPDATE attedance SET afternoon_time_out='$login_time' 
            WHERE fullname='$fullname' AND login_date='$login_date' AND afternoon_time_out IS NULL";
    if ($conn->query($sql) === TRUE) {
        $action_msg = "<font color='green'>You have successfully timed out at $login_time (PM).</font>";
    } else {
        $action_msg = "<font color='red'>Error recording time out: " . $conn->error . "</font>";
    }
}
// Calculate the total hours worked (assuming morning and afternoon time in/out are properly recorded)
function calculate_hours($time_in, $time_out) {
    $time_in = new DateTime($time_in);
    $time_out = new DateTime($time_out);
    $interval = $time_in->diff($time_out);
    return $interval->h + ($interval->i / 60);  // return hours + minutes as fraction
}

$morning_total = 0;
$afternoon_total = 0;
$daily_total = 0;

$sql = "SELECT morning_time_in, morning_time_out, afternoon_time_in, afternoon_time_out FROM attedance 
        WHERE fullname='$fullname' AND login_date='$login_date'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if ($row['morning_time_in'] && $row['morning_time_out']) {
        $morning_total = calculate_hours($row['morning_time_in'], $row['morning_time_out']);
    }

    if ($row['afternoon_time_in'] && $row['afternoon_time_out']) {
        $afternoon_total = calculate_hours($row['afternoon_time_in'], $row['afternoon_time_out']);
    }

    // Sum the total hours for the day
    $daily_total = $morning_total + $afternoon_total;

    // You can update the database to store the total if you like
    $sql_update_total = "UPDATE attedance SET calculate_hours = '$daily_total' 
                         WHERE fullname='$fullname' AND login_date='$login_date'";
    $conn->query($sql_update_total);
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
        #clock {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
        .message {
            text-align: center;
            margin-top: 20px;
        }
        .message font {
            font-size: 18px;
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
                                        <h4><?php echo $msg; ?></h4>
                                        <?php if (!empty($action_msg)) echo $action_msg; ?>
                                    </div>


                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="time-in-tab" data-toggle="tab" href="#time-in" role="tab" aria-controls="time-in" aria-selected="true">Time In</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="time-out-tab" data-toggle="tab" href="#time-out" role="tab" aria-controls="time-out" aria-selected="false">Time Out</a>
                                        </li>
                                       
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <!-- Time In -->
                                        <div class="tab-pane fade show active" id="time-in" role="tabpanel" aria-labelledby="time-in-tab">
                                            <form method="POST" action="">
                                                <button type="submit" name="morning_time_in" class="btn btn-success btn-block mt-4">Time In (AM)</button>
                                                <button type="submit" name="afternoon_time_in" class="btn btn-success btn-block mt-4">Time In (PM)</button>
                                            </form>
                                        </div>

                                    <!-- Time Out -->
                                    <div class="tab-pane fade" id="time-out" role="tabpanel" aria-labelledby="time-out-tab">
                                            <form method="POST" action="">
                                                <button type="submit" name="morning_time_out" class="btn btn-danger btn-block mt-4">Time Out (AM)</button>
                                                <button type="submit" name="afternoon_time_out" class="btn btn-danger btn-block mt-4">Time Out (PM)</button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <a href="travel.php" class="btn btn-info">Travel Order</a>
                                    </div>

                                    <div class="text-center mt-4">
                                        <a href="logout.php" class="btn btn-secondary">Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>

    <script>
        var serverTime = new Date('<?php echo date('Y-m-d H:i:s'); ?>'); 

        function startTime() {
            updateClock();
            setInterval(updateClock, 1000);
        }

        function updateClock() {
            serverTime.setSeconds(serverTime.getSeconds() + 1);

            var hours = serverTime.getHours();
            var minutes = serverTime.getMinutes();
            var seconds = serverTime.getSeconds();
            var ampm = hours >= 12 ? 'PM' : 'AM';
            var displayHours = hours % 12;
            displayHours = displayHours ? displayHours : 12; 
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            var timeString = displayHours + ':' + minutes + ':' + seconds + ' ' + ampm;

            var day = serverTime.getDate();
            var month = serverTime.getMonth() + 1; 
            var year = serverTime.getFullYear();
            month = month < 10 ? '0' + month : month;
            day = day < 10 ? '0' + day : day;
            var dateString = month + '/' + day + '/' + year;

            document.getElementById('clock').innerHTML = dateString + ' ' + timeString;
        }

        startTime();
    </script>
</body>

</html>
