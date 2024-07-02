<?php
require '../../config/mysqli_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'fetch_semesters':
                $enroll_no = $_POST['enroll_no'];
                $sql = "SELECT DISTINCT semester FROM stud_attendance WHERE enroll_no = '$enroll_no' ORDER BY semester";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<button type='button' class='btn btn-primary semester-tab' data-semester='{$row['semester']}'>Semester {$row['semester']}</button> ";
                    }
                }
                break;

            case 'fetch_months':
                $enroll_no = $_POST['enroll_no'];
                $semester = $_POST['semester'];
                $sql = "SELECT DISTINCT DATE_FORMAT(start_date, '%Y-%m') AS month FROM stud_attendance WHERE enroll_no = '$enroll_no' AND semester = '$semester' ORDER BY month DESC";
                $result = $conn->query($sql);

                echo "<option value='' selected disabled hidden>--Select--</option>";
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['month']}'>{$row['month']}</option>";
                    }
                }
                break;
        }
    }
}
?>
