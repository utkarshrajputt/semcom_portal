<?php
require '../../config/mysqli_db.php';

if (isset($_POST['enroll_no']) && isset($_POST['semester']) && isset($_POST['month'])) {
    $month = $_POST['month'];
    $enroll_no = $_POST['enroll_no'];
    $semester = $_POST['semester'];

    $sql = "SELECT start_date, end_date, at_percentage FROM stud_attendance WHERE enroll_no = '$enroll_no' AND semester = '$semester' AND DATE_FORMAT(start_date, '%Y-%m') = '$month' ORDER BY start_date";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='table table-bordered table-hover text-center'>";
        echo "<thead class='table-light'><tr><th>Start Date</th><th>End Date</th><th>Attendance Percentage</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            $start_date_formatted = date('j M Y', strtotime($row['start_date']));
            $end_date_formatted = date('j M Y', strtotime($row['end_date']));

            echo "<tr>
                <td>{$start_date_formatted}</td>
                <td>{$end_date_formatted}</td>
                <td><b>{$row['at_percentage']}%</b></td>
            </tr>";
        }
        echo "</tbody></table>";
    } else{
        echo "<table class='table table-bordered table-hover text-center'>";
        echo "<thead class='table-light'><tr><th>Start Date</th><th>End Date</th><th>Attendance Percentage</th></tr></thead>";
        echo "<tbody>";
        echo "<tr><td colspan='3' class='alert alert-warning'>No attendance data found for the selected month.</td></tr>";
        echo "</tbody></table>";
    }
    exit;
}
