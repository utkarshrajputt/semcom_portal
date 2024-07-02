<?php
require '../config/mysqli_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['week'])) {
    $selectedWeek = $_POST['week'];

    // Extract start_date and end_date from selected week
    list($start_date, $end_date) = explode('_', $selectedWeek);

    // Query to fetch attendance data for the selected week
    $attendance_sql = "SELECT enroll_no, course, semester, division, start_date, end_date, at_percentage 
                       FROM stud_attendance 
                       WHERE start_date = '$start_date' AND end_date = '$end_date'
                       ORDER BY enroll_no";

    $attendance_result = $conn->query($attendance_sql);

    if ($attendance_result->num_rows > 0) {
        echo "<table class='table table-bordered table-hover text-center'>";
        echo "<thead class='table-light'><tr><th>Enroll No</th><th>Name</th><th>Image</th><th>Semester</th><th>Division</th><th>Start Date</th><th>End Date</th><th>Attendance Percentage</th></tr></thead>";
        echo "<tbody>";
        while ($row = $attendance_result->fetch_assoc()) {
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
    } else {
        echo "<tr><td colspan='7'>No attendance data available for the selected week.</td></tr>";
    }
} else {
    // Handle invalid request
    echo "<tr><td colspan='7'>No attendance data available for the selected week.</td></tr>";
}
