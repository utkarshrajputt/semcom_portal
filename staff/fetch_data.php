<?php
require '../config/mysqli_db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['week'])) {
    list($start_date, $end_date) = explode('_', $_POST['week']);
    $data_sql = "SELECT enroll_no, course, semester, division, start_date, end_date, at_percentage FROM stud_attendance WHERE start_date = '$start_date' AND end_date = '$end_date' ORDER BY enroll_no";
    $data_result = $conn->query($data_sql);

    if ($data_result->num_rows > 0) {
        echo "<table class='table table-bordered table-hover text-center'>";
        echo "<thead class='table-light'><tr><th>Enroll No</th><th>Name</th><th>Image</th><th>Semester</th><th>Division</th><th>Start Date</th><th>End Date</th><th>Attendance Percentage</th></tr></thead>";
        echo "<tbody>";
        while ($row = $data_result->fetch_assoc()) {
            $enroll = $row['enroll_no'];
            $result = mysqli_query($conn, "SELECT CONCAT(f_name, ' ', m_name, ' ', l_name) AS full_name, pro_pic FROM stud_personal_details WHERE enroll_no = '$enroll'");
            if ($result->num_rows > 0) {
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
                echo "<td><img src='{$pro_pic}' class='img-fluid'></td>";
            }
            echo "<td>{$row['semester']}</td>
                    <td>{$row['division']}</td>
                    <td>{$row['start_date']}</td>
                    <td>{$row['end_date']}</td>
                    <td><b>{$row['at_percentage']}%</b></td>
                  </tr>";
        }
        echo "</tbody></table>";
    }
}

$conn->close();
