<?php

// Connection to the database
$conn = mysqli_connect("localhost", "root", "", "empattendance");

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch employee attendance data
$query = "SELECT * FROM attedance ORDER BY login_date DESC";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Error in query: " . mysqli_error($conn));
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
    <title>Dashboard</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centered Table Header</title>
    <style>
        table {
            width: 100%; /* Adjust table width as needed */
            border-collapse: collapse; /* Optional: for cleaner borders */
            margin: 0 auto; /* Center the table */
        }

        th, td {
            border: 1px solid #ddd; /* Optional: add borders to cells */
            padding: 8px; /* Space inside cells */
            text-align: center; /* Center text in header and cells */
        }

        th {
            background-color: #f2f2f2; /* Optional: background color for header */
        }

        .center {
            text-align: center; /* Center text */
        }
    </style>
</head>

    <div id="wrapper">

        <div id="sidebar">
            
    <div class="sidebar-brand-icon">
        <img src="img/logo/DICT-Logo-icon_only.png" alt="Logo" style="width: 100px; height: auto;">
    </div>
    <div class="sidebar-brand-text mx-3">DICT</div>
</a>

               
            </ul>
        </div>
        <!-- Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Employees Attendance</h1>
                        <button class="btn btn-primary" onclick="window.print()">Print / Save as PDF</button>
                    </div>

                    <!-- Search Bar -->
                    <input type="text" id="searchInput" class="form-control mb-4" placeholder="Search by name or date">

                    <!-- Attendance Table -->
                    <table id="attendanceTable" class="table table-bordered">
                        <thead>
    
                            <tr>
                                <td colspan="3" class="center"></td>
                                <td colspan="2" style="text-align: center;">MORNING</td>
                                <td colspan="2" style="text-align: center;">AFTERNOON</td>
                
                                <td colspan="1" class="center"></td>
                                <td colspan="3" style="text-align: center;">TRAVEL ORDER</td>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>DATE</th>
                                <th>NAME</th>

                                <th>TIME IN</th>
                                <th>TIME OUT</th>

                                <th>TIME IN </th>
                                <th>TIME OUT </th>

                                <th>DAILY TOTAL HOURS</th>
                                <th>DATE</th>
                                <th>DESTINATION</th>
                                <th>PURPOSE</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php
    // Display the fetched data
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Convert times to DateTime objects
            $morning_in = new DateTime($row['morning_time_in']);
            $morning_out = new DateTime($row['morning_time_out']);
            $afternoon_in = new DateTime($row['afternoon_time_in']);
            $afternoon_out = new DateTime($row['afternoon_time_out']);
            
            // Calculate the intervals
            $morning_diff = $morning_in->diff($morning_out);
            $afternoon_diff = $afternoon_in->diff($afternoon_out);
            
            // Sum up total hours (in decimal)
            $total_morning_hours = $morning_diff->h + ($morning_diff->i / 60); // Hours + Minutes
            $total_afternoon_hours = $afternoon_diff->h + ($afternoon_diff->i / 60);
            
            // Total daily hours
            $daily_total_hours = $total_morning_hours + $total_afternoon_hours;
            
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['login_date']}</td>
                <td>{$row['fullname']}</td>
                <td>{$row['morning_time_in']}</td>
                <td>{$row['morning_time_out']}</td>
                <td>{$row['afternoon_time_in']}</td>
                <td>{$row['afternoon_time_out']}</td>
                <td>" . number_format($daily_total_hours, 2) . "</td> <!-- Display the total hours -->
                <td>{$row['travel_date']}</td>
                <td>{$row['destination']}</td>
                <td>{$row['purpose']}</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='11'>No records found</td></tr>";
    }
    ?>
</tbody>

                    </table>
              
                    <div class="text-center mt-4">
                                        <a href="login.php" class="btn btn-secondary">Logout</a>
                    </div>

                </div>
            </div>
            <!-- Footer -->
            <footer class="sticky-footer bg-white footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright © Your Website 2024</span>
                    </div>
                </div>
            </footer>
            <!-- Footer -->
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#attendanceTable').DataTable({
                "order": [[2, "desc"]] // Sort by login_time (column index 2) by default
            });

            // Search functionality
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
</body>
</html>