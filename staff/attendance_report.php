<?php
require '../config/mysqli_db.php';
require '../includes/session.php';

$staff_email = $_SESSION['staff_email'];

if (!isset($staff_email)) {
    header('location: staff_login.php');
    exit(); // Ensure script stops executing after redirection
} else {
    $select = mysqli_query($conn, "SELECT * FROM staff_class_assign WHERE staff_email='$staff_email'");
    if ($select->num_rows > 0) {
        $staffData = mysqli_fetch_assoc($select);
        $course = $staffData['course'];
        $semester = $staffData['semester'];
        $div = $staffData['division'];
    } else {
        $course = "";
        $semester = "";
        $div = "";
    }
}

// Fetch unique months for the selected course, semester, division
$months_sql = "SELECT DISTINCT DATE_FORMAT(start_date, '%Y-%m') AS month FROM stud_attendance 
               WHERE course = '$course' AND semester = '$semester' AND division = '$div'
               ORDER BY month DESC";
$months_result = $conn->query($months_sql);

// Initialize variables for latest month and weeks data
$latest_weeks_result = null;
$first_week_data_result = null;

// Fetch weeks for the latest month (if course, semester, and division are valid)
if (!empty($course) && !empty($semester) && !empty($div)) {
    $latest_month_sql = "SELECT DISTINCT start_date, end_date FROM stud_attendance 
                         WHERE DATE_FORMAT(start_date, '%Y-%m') = (SELECT MAX(DATE_FORMAT(start_date, '%Y-%m')) FROM stud_attendance) 
                         AND course = '$course' AND semester = '$semester' AND division = '$div' 
                         ORDER BY start_date";

    $latest_weeks_result = $conn->query($latest_month_sql);

    // Fetch data for the first week of the latest month (if available)
    if ($latest_weeks_result->num_rows > 0) {
        $first_week = $latest_weeks_result->fetch_assoc();
        $first_week_start_date = $first_week['start_date'];
        $first_week_end_date = $first_week['end_date'];

        $first_week_data_sql = "SELECT enroll_no, course, semester, division, start_date, end_date, at_percentage FROM stud_attendance 
                                WHERE start_date = '$first_week_start_date' AND end_date = '$first_week_end_date' 
                                ORDER BY enroll_no";

        $first_week_data_result = $conn->query($first_week_data_sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">
    <title>SEMCOM</title>

    <!-- BOOTSTRAP & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a79beb4099.js" crossorigin="anonymous"></script>

    <!-- BOXICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- MAIN STUDENT CSS -->
    <link rel="stylesheet" href="../assets/css/student.css">
    <link rel="stylesheet" href="../assets/css/staff.css">

    <style>
        .table img {
            max-width: 80px;
            max-height: 80px;
        }
    </style>

    <script>
        $(document).ready(function () {
            // Populate weeks dropdown based on selected month
            $('#monthDropdown').change(function () {
                var selectedMonth = $(this).val();
                if (selectedMonth) {
                    $.ajax({
                        url: 'fetch_weeks.php',
                        type: 'POST',
                        data: {
                            month: selectedMonth
                        },
                        success: function (response) {
                            $('#weekDropdown').html(response);
                            // Automatically trigger change event for weeks dropdown
                            $('#weekDropdown').trigger('change');
                        }
                    });
                }
            });

            // Display table data based on selected week
            $('#weekDropdown').change(function () {
                var selectedWeek = $(this).val();
                if (selectedWeek) {
                    $.ajax({
                        url: 'fetch_data.php',
                        type: 'POST',
                        data: {
                            week: selectedWeek
                        },
                        success: function (response) {
                            $('#dataTable').html(response);
                        }
                    });
                }
            });

            // Trigger change event on page load to load the latest week data
            $('#monthDropdown').trigger('change');
        });
    </script>

</head>

<body id="body-pd">
    <?php require '../includes/sidebar-staff.php'; ?>

    <h2 class="text-center" style="font-weight: bold;">Attendance Report</h2>
    <div class="container mt-5">
        <h3 class="mt-4 mb-4">Month and Week Selector</h3>

        <div class="form-group">
            <label for="monthDropdown">Select Month:</label>
            <select id="monthDropdown" class="form-control">
                <option value="" selected disabled hidden>--Select--</option>
                <?php
                if ($months_result->num_rows > 0) {
                    while ($row = $months_result->fetch_assoc()) {
                        echo "<option value='{$row['month']}'>{$row['month']}</option>";
                    }
                } else {
                    echo "<option value='' disabled>No months found</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="weekDropdown">Select Week:</label>
            <select id="weekDropdown" class="form-control">
                <option value="" selected disabled hidden>--Select--</option>
                <?php
                if ($latest_weeks_result && $latest_weeks_result->num_rows > 0) {
                    $week_counter = 1;
                    $latest_weeks_result->data_seek(0); // Reset result pointer to the beginning
                    while ($row = $latest_weeks_result->fetch_assoc()) {
                        $start_date_formatted = date('j M Y', strtotime($row['start_date']));
                        $end_date_formatted = date('j M Y', strtotime($row['end_date']));
                        echo "<option value='{$row['start_date']}_{$row['end_date']}'>Week $week_counter: {$start_date_formatted} to {$end_date_formatted}</option>";
                        $week_counter++;
                    }
                } else {
                    echo "<option value='' disabled>No weeks found</option>";
                }
                ?>
            </select>
        </div>

        <div id="dataTable" class="table-responsive mt-4">
            <?php
            if ($first_week_data_result && $first_week_data_result->num_rows > 0) {
                echo "<table class='table table-bordered table-hover text-center'>";
                echo "<thead class='table-light'><tr><th>Enroll No</th><th>Name</th><th>Image</th><th>Semester</th><th>Division</th><th>Start Date</th><th>End Date</th><th>Attendance Percentage</th></tr></thead>";
                echo "<tbody>";
                while ($row = $first_week_data_result->fetch_assoc()) {
                    $start_date_formatted = date('j M Y', strtotime($row['start_date']));
                    $end_date_formatted = date('j M Y', strtotime($row['end_date']));

                    $enroll = $row['enroll_no'];
                    $result = mysqli_query($conn, "SELECT CONCAT(f_name, ' ', m_name, ' ', l_name) AS full_name, pro_pic FROM stud_personal_details WHERE enroll_no = '$enroll'");
                    if ($result && $result->num_rows > 0) {
                        $enrollDtl = mysqli_fetch_assoc($result);
                        $fullname = $enrollDtl['full_name'];
                        $pro_pic = "../assets/images/uploaded_images/" . $enrollDtl['pro_pic'];
                    } else {
                        $fullname = "<b>Registration Incomplete</b>";
                        $pro_pic = "";
                    }

                    echo "<tr>
                        <td>{$row['enroll_no']}</td>
                        <td>{$fullname}</td>";
                    if ($pro_pic == '') {
                        echo "<td></td>";
                    } else {
                        echo "<td><img src='{$pro_pic}' class='img-fluid' style='max-width: 80px; max-height: 80px;'></td>";
                    }
                    echo "<td>{$row['semester']}</td>
                        <td>{$row['division']}</td>
                        <td>{$start_date_formatted}</td>
                        <td>{$end_date_formatted}</td>
                        <td><b>{$row['at_percentage']}%</b></td>
                      </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>No attendance data available for the selected criteria.</p>";
            }
            ?>
        </div>
    </div>

    <script src="../assets/js/main.js"></script>
</body>

</html>
