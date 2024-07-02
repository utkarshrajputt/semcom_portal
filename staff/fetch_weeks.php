<?php
require '../config/mysqli_db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['month'])) {
    $month = $_POST['month'];
    $weeks_sql = "SELECT DISTINCT start_date, end_date FROM stud_attendance WHERE DATE_FORMAT(start_date, '%Y-%m') = '$month' ORDER BY start_date";
    $weeks_result = $conn->query($weeks_sql);

    if ($weeks_result->num_rows > 0) {
        echo "<option value=''>--Select--</option>";
        $week_counter = 1;
        while ($row = $weeks_result->fetch_assoc()) {

            $start_date_formatted = date('j M Y', strtotime($row['start_date']));
            $end_date_formatted = date('j M Y', strtotime($row['end_date']));
            echo "<option value='{$row['start_date']}_{$row['end_date']}'>Week $week_counter: {$start_date_formatted} to {$end_date_formatted}</option>";
            $week_counter++;
        }
    }
}

$conn->close();
