<?php

require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require '../assets/libraries/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$staff_email = $_SESSION['staff_email'];

if (!isset($staff_email)) {
    header('location:staff_login.php');
}

?>
<?php


if (isset($_POST['at_submit'])) {
    $fileName = $_FILES['file']['tmp_name'];
    $spreadsheet = IOFactory::load($fileName);
    $worksheet = $spreadsheet->getActiveSheet();
    $rowIterator = $worksheet->getRowIterator(2);
    $data = $worksheet->toArray();

    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $division = $_POST['division'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    foreach ($data as $row) {
        $enroll_no = $row[0];
        $attendance_percentage = $row[1];

        $sql = "INSERT INTO stud_attendance (enroll_no, course, semester, division, start_date, end_date, at_percentage) VALUES ('$enroll_no', '$course', '$semester', '$division', '$start_date', '$end_date', '$attendance_percentage') ON DUPLICATE KEY UPDATE at_percentage='$attendance_percentage'";
        $conn->query($sql);
    }

    $conn->close();
    echo "<script>alert('File uploaded and data inserted successfully!')</script>";
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

</head>

<body id="body-pd">
    <?php
    require '../includes/sidebar-staff.php';

    ?>

    <h2 class="text-center" style="font-weight:bolder;">Counseling Summary</h2>

    <form method="post" action="" enctype="multipart/form-data">
        <div class="row mt-5 px-5">
            <div class="col-md-4 mb-4 pb-2">
                <!-- COURSE -->
                <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="course">Course</label>
                    <input type="text" name="course" class="form-control form-control-lg" required />
                    <div class="invalid-feedback">Please enter the course!</div>
                </div>
            </div>
            <div class="col-md-4 mb-4 pb-2">
                <!-- SEMESTER -->
                <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="semester">Semester</label>
                    <input type="text" name="semester" class="form-control form-control-lg" required />
                    <div class="invalid-feedback">Please enter the semester!</div>
                </div>
            </div>
            <div class="col-md-4 mb-4 pb-2">
                <!-- DIVISION -->
                <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="division">Division</label>
                    <input type="text" name="division" class="form-control form-control-lg" required />
                    <div class="invalid-feedback">Please enter the division!</div>
                </div>
            </div>
        </div>
        <div class="row px-5">

            <div class="col-md-6 mb-4 pb-2">
                <!-- START DATE -->
                <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="start_date">Start Date</label>
                    <input type="date" name="start_date" class="form-control form-control-lg" required />
                    <div class="invalid-feedback">Please select the start date!</div>
                </div>
            </div>
            <div class="col-md-6 mb-4 pb-2">
                <!-- END DATE -->
                <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="end_date">End Date</label>
                    <input type="date" name="end_date" class="form-control form-control-lg" required />
                    <div class="invalid-feedback">Please select the end date!</div>
                </div>
            </div>
        </div>
        <div class="row px-5">

            <div class="col-md-12 mb-4 pb-2">
                <!-- EXCEL FILE UPLOAD -->
                <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="file">Choose Excel File</label>
                    <input type="file" name="file" class="form-control form-control-lg" accept=".xls,.xlsx" required />
                    <div class="invalid-feedback">Please choose an Excel file!</div>
                </div>
            </div>

        </div>
        <div class="row px-5">

            <div class="col-md-12 mb-4 pb-2"></div>
        <!-- Submit button -->
        <div class="text-end">
            <button name="at_submit" type="submit" class="btn btn-primary">Submit</button>
        </div>
        </div>
            </div>

    </form>

    <script src="../assets/js/main.js"></script>

</body>

</html>