<?php
require '../config/mysqli_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['month'])) {
    $selectedMonth = $_POST['month'];

    // Query to fetch weeks for the selected month
    $weeks_sql = "SELECT DISTINCT DATE_FORMAT(start_date, '%Y-%m-%d') AS start_date, DATE_FORMAT(end_date, '%Y-%m-%d') AS end_date 
                  FROM stud_attendance 
                  WHERE DATE_FORMAT(start_date, '%Y-%m') = '$selectedMonth'
                  ORDER BY start_date";

    $weeks_result = $conn->query($weeks_sql);

    if ($weeks_result->num_rows > 0) {
        echo "<option value='' selected disabled hidden>--Select--</option>";
        while ($row = $weeks_result->fetch_assoc()) {
            $start_date_formatted = date('j M Y', strtotime($row['start_date']));
            $end_date_formatted = date('j M Y', strtotime($row['end_date']));
            echo "<option value='{$row['start_date']}_{$row['end_date']}'>Week: {$start_date_formatted} to {$end_date_formatted}</option>";
        }
    } else {
        echo "<option value='' disabled>No weeks found</option>";
    }
} else {
    // Handle invalid request
    echo "<option value='' disabled>No weeks found</option>";
}
?>
