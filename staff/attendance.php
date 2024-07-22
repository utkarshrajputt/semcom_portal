<?php

require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require '../assets/libraries/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$staff_email = "";

if (!isset($_SESSION['staff_email'])) {
    header('location:index.php');
    exit();
}else{
    $staff_email = $_SESSION['staff_email'];
    $select = mysqli_query($conn, "select * from staff_class_assign where staff_email='$staff_email'");
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

?>
<?php
if (isset($_POST['at_submit'])) {
    try {
        $course = $_POST['course'];
        $semester = $_POST['semester'];
        $division = $_POST['division'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        // Check if file is uploaded and is a valid Excel file
        if (isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] !== '') {
            $fileName = $_FILES['file']['tmp_name'];
            $spreadsheet = IOFactory::load($fileName);
            $worksheet = $spreadsheet->getActiveSheet();

            // Iterate over each row in the worksheet, starting from the second row
            $rowIterator = $worksheet->getRowIterator(2);
            $sql = "INSERT INTO stud_attendance (enroll_no, course, semester, division, start_date, end_date, at_percentage) VALUES (?,?,?,?,?,?,?)";
            $stmt = mysqli_prepare($conn, $sql);

            foreach ($rowIterator as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                // Assuming each row contains enrollment number and attendance percentage
                $cellData = [];
                foreach ($cellIterator as $cell) {
                    $cellData[] = $cell->getValue();
                }

                if (count($cellData) >= 2) {
                    $enrollmentNumber = $cellData[0];
                    $attendance = $cellData[1];

                    mysqli_stmt_bind_param($stmt, "sssssss", $enrollmentNumber, $course, $semester, $division, $start_date, $end_date, $attendance);
                    mysqli_stmt_execute($stmt);
                }
            }

            mysqli_stmt_close($stmt);
            echo "<script>alert('File uploaded and data inserted successfully!')</script>";
        } else {
            throw new Exception('No file uploaded or invalid file.');
        }
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "')</script>";
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

</head>

<body id="body-pd">
    <?php
    require '../includes/sidebar-staff.php';

    ?>

    <h2 class="text-center" style="font-weight:bolder;">Attendance</h2>
    <?php
    if ($course == "") {
    ?>
        <p style="color:red;font-size:1.3rem;">*Class Not Assigned</p>
    <?php
    }
    ?>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="row mt-5 px-5">
            <div class="col-md-4 mb-4 pb-2">
                <!-- COURSE -->
                <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="course">Course</label>
                    <input type="text" name="course" class="form-control form-control-lg" value="<?php echo $course ?>" required readonly />
                    <div class="invalid-feedback">Please enter the course!</div>
                </div>
            </div>
            <div class="col-md-4 mb-4 pb-2">
                <!-- SEMESTER -->
                <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="semester">Semester</label>
                    <input type="text" name="semester" class="form-control form-control-lg" value="<?php echo $semester ?>" readonly required />
                    <div class="invalid-feedback">Please enter the semester!</div>
                </div>
            </div>
            <div class="col-md-4 mb-4 pb-2">
                <!-- DIVISION -->
                <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="division">Division</label>
                    <input type="text" name="division" class="form-control form-control-lg" value="<?php echo $div ?>" readonly required />
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
            <div class="col-md-6">
                <div>
                    <p style="color:red">*format for excel file should be like this only</p>
                    <img class="file-demo" src="../assets/images/excel-at.png" alt="Excel Demo">
                </div>
            </div>
            <div class="col-md-6 mb-4 pb-2">
                <div class="text-center mt-2">
                    <button name="at_submit" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
        </div>

    </form>

    <script src="../assets/js/main.js"></script>

</body>

</html>