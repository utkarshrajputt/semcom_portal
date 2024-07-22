<?php
require '../includes/session.php';
require '../config/mysqli_db.php';

$enroll = "";

if (!isset($_SESSION['enroll'])) {
    header('location:index.php');
    exit();
} else {
    $enroll = $_SESSION['enroll'];
    $row = mysqli_fetch_row(mysqli_query($conn, "select complete_register from stud_login where enroll_no=$enroll"));
    $bool = $row[0];
    if ($bool == 'no') {
        header("location:profile_dashboard.php");
    }
}

// Fetch the latest semester and month data on page load
$latest_semester_sql = "SELECT semester FROM stud_attendance WHERE enroll_no = '$enroll' ORDER BY semester DESC LIMIT 1";
$latest_semester_result = $conn->query($latest_semester_sql);
$latest_semester = $latest_semester_result->num_rows > 0 ? $latest_semester_result->fetch_assoc()['semester'] : null;

$latest_month_sql = "SELECT DATE_FORMAT(start_date, '%Y-%m') AS month FROM stud_attendance WHERE enroll_no = '$enroll' AND semester = '$latest_semester' ORDER BY start_date DESC LIMIT 1";
$latest_month_result = $conn->query($latest_month_sql);
$latest_month = $latest_month_result->num_rows > 0 ? $latest_month_result->fetch_assoc()['month'] : null;

$latest_data_sql = "SELECT start_date, end_date, at_percentage FROM stud_attendance WHERE enroll_no = '$enroll' AND semester = '$latest_semester' AND DATE_FORMAT(start_date, '%Y-%m') = '$latest_month' ORDER BY start_date DESC";
$latest_data_result = $conn->query($latest_data_sql);

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
    <script>
        $(document).ready(function() {
            // Load semesters on page load
            $.ajax({
                url: 'forms/fetchDropdown.php',
                type: 'POST',
                data: {
                    action: 'fetch_semesters',
                    enroll_no: '<?php echo $enroll; ?>'
                },
                success: function(response) {
                    $('#semesterTabs').html(response);

                    // Load the latest month's data for the latest semester
                    var latestSemester = $('#semesterTabs').find('.semester-tab').first().data('semester');
                    $('#selectedSemester').val(latestSemester);

                    $.ajax({
                        url: 'forms/fetchDropdown.php',
                        type: 'POST',
                        data: {
                            action: 'fetch_months',
                            enroll_no: '<?php echo $enroll; ?>',
                            semester: latestSemester
                        },
                        success: function(response) {
                            $('#monthDropdown').html(response).prop('disabled', false);
                            $('#monthDropdown').val('<?php echo $latest_month; ?>').trigger('change');
                        }
                    });
                }
            });

            // Handle semester tab click
            $(document).on('click', '.semester-tab', function() {
                var semester = $(this).data('semester');
                $('#selectedSemester').val(semester);

                // Load months for the selected semester
                $.ajax({
                    url: 'forms/fetchDropdown.php',
                    type: 'POST',
                    data: {
                        action: 'fetch_months',
                        enroll_no: '<?php echo $enroll; ?>',
                        semester: semester
                    },
                    success: function(response) {
                        $('#monthDropdown').html(response).prop('disabled', false);
                        $('#dataTable').html(''); // Clear data table
                    }
                });
            });

            // Handle month dropdown change
            $('#monthDropdown').change(function() {
                var selectedMonth = $(this).val();
                var semester = $('#selectedSemester').val();
                if (selectedMonth) {
                    $.ajax({
                        url: 'forms/fetch_data.php',
                        type: 'POST',
                        data: {
                            action: 'fetch_data',
                            enroll_no: '<?php echo $enroll; ?>',
                            semester: semester,
                            month: selectedMonth
                        },
                        success: function(response) {
                            $('#dataTable').html(response); // Update only the dataTable div with the response
                        }
                    });
                }
            });

        });
    </script>
</head>

<body id="body-pd">
    <?php
    require '../includes/sidebar-student.php';
    ?>
    <div class="container mt-5">
        <h2 class="mb-4" align="center">Attendance Report</h2>

        <div id="semesterTabs" class="mb-3">
            <!-- Semester tabs will be loaded here -->
        </div>

        <input type="hidden" id="selectedSemester" value="">

        <div class="form-group">
            <label for="monthDropdown">Select Month:</label>
            <select id="monthDropdown" class="form-control" disabled>
                <option value="" selected disabled hidden>--Select--</option>
                <!-- Months will be loaded here -->
            </select>
        </div>

        <div id="dataTable" class="table-responsive mt-4">
            <?php
            if ($latest_data_result->num_rows > 0) {
                echo "<table class='table table-bordered table-hover text-center'>";
                echo "<thead class='table-light'><tr><th>Start Date</th><th>End Date</th><th>Attendance Percentage</th></tr></thead>";
                echo "<tbody>";
                while ($row = $latest_data_result->fetch_assoc()) {
                    $start_date_formatted = date('j M Y', strtotime($row['start_date']));
                    $end_date_formatted = date('j M Y', strtotime($row['end_date']));

                    echo "<tr>
                        <td>{$start_date_formatted}</td>
                        <td>{$end_date_formatted}</td>
                        <td><b>{$row['at_percentage']}%</b></td>
                    </tr>";
                }
                echo "</tbody></table>";
            }
            else{
                echo "<table class='table table-bordered table-hover text-center'>";
                echo "<thead class='table-light'><tr><th>Start Date</th><th>End Date</th><th>Attendance Percentage</th></tr></thead>";
                echo "<tbody>";
                echo "<tr><td colspan='3' class='alert alert-warning'>No Data Found!</td></tr>";
                echo "</tbody></table>";
            }
            ?>
        </div>

    </div>
    <script src="../assets/js/main.js"></script>

</body>

</html>