<?php
require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require('../includes/fetchTableData.php');

require_once('../assets/libraries/pdf/tcpdf.php');
// Start output buffering
ob_start();

// Your existing PHP code here
$staff_email = "";

if (!isset($_SESSION['staff_email'])) {
    header('location:index.php');
    exit();
}else{
    $staff_email = $_SESSION['staff_email'];
}

if (isset($_POST['pdf_submit'])) {
    $choice = $_POST['entryTypeStudent'];

    $selectQuery = "select course,semester,division from staff_class_assign where staff_email='$staff_email'";
    $selectResult = $conn->query($selectQuery);

    // IF class is assigned then fetch enrollment no start and end range to get student data
    if ($selectResult->num_rows > 0) {
        $row = $selectResult->fetch_assoc();
        $dataResult = mysqli_query($conn, "select class_enroll_start,class_enroll_end from course_class where course_name='" . $row['course'] . "' and class_semester='" . $row['semester'] . "' and class_div='" . $row['division'] . "'");
        $data = mysqli_fetch_assoc($dataResult);

        $start = $data["class_enroll_start"];
        $end = $data["class_enroll_end"];
    } else {
        $start = "";
        $end = "";
    }

    if ($start != "" && $end != "") {
        if ($choice == 'all') {
            
            header('location:../includes/all_pdf.php?start='.$start.'&end='.$end.'');           
            header('Content-Type: application/pdf');
            // Output the PDF
            
            ob_end_flush(); // Flush output buffer and send PDF
            exit; // Exit script after sending PDF

        } else if ($choice == 'single') {
            // Handle single entry case

            $enrollPDF=$_POST['studentSingle'];
            header('location:../includes/pdf.php?enroll='.$enrollPDF.'');           
            header('Content-Type: application/pdf');
            // Output the PDF
            
            ob_end_flush(); // Flush output buffer and send PDF
            exit; // Exit script after sending PDF

        } else if ($choice == 'range') {
            // Handle range entry case
            $startVal=$_POST['studentRangeStart'];
            $endVal=$_POST['studentRangeEnd'];

            header('location:../includes/pdf.php?start='.$startVal.'&end='.$endVal.'');           
            header('Content-Type: application/pdf');
            // Output the PDF
            
            ob_end_flush(); // Flush output buffer and send PDF
            exit; // Exit script after sending PDF
        }
    } else {
        echo "<script>alert('Contact admin!')</script>";
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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a79beb4099.js" crossorigin="anonymous"></script>

    <!-- Boxicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- Main Student CSS -->
    <link rel="stylesheet" href="../assets/css/student.css">
</head>

<body id="body-pd">
    <?php require '../includes/sidebar-staff.php'; ?>
    <h2 class="text-center" style="font-weight:bolder;">Student Report</h2>

    <div class="container pt-5">
        <div class="mb-4">
            <button id="pdfBtn" class="btn btn-primary me-2">PDF</button>
            <button id="excelBtn" class="btn btn-secondary">EXCEL</button>
        </div>
        <div id="pdfDiv">
            <form method="post" action="" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="mb-3">
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="entryTypeStudent" id="singleRadio" value="single" checked onclick="toggleEntry('student', 'single')">
                            <label class="form-check-label" for="singleRadio">Single Entry</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="entryTypeStudent" id="rangeRadio" value="range" onclick="toggleEntry('student', 'range')">
                            <label class="form-check-label" for="rangeRadio">Range Entry</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="entryTypeStudent" id="allRadio" value="all" onclick="toggleEntry('student', 'all')">
                            <label class="form-check-label" for="allRadio">All</label>
                        </div>
                    </div>
                </div>

                <!-- Single entry section -->
                <div class="form-group col-md-6" id="studentSingleEntry">
                    <label for="studentSingle">Single Entry</label>
                    <!-- <input type="text" class="form-control" id="studentSingle" name="studentSingle" placeholder="Enter student credential"> -->
                    <select class="form-control" id="studentSingle" name="studentSingle">
                        <?php

                        //Individual Staff Assigned Enrollment nos
                        $selectQuery = "select course,semester,division from staff_class_assign where staff_email='$staff_email'";
                        $selectResult = $conn->query($selectQuery);

                        //IF class is assigned then fetch enrollment no start and end range to get student data
                        if ($selectResult->num_rows > 0) {
                                $row = $selectResult->fetch_assoc();
                                $dataResult = mysqli_query($conn, "select class_enroll_start,class_enroll_end from course_class where course_name='" . $row['course'] . "' and class_semester='" . $row['semester'] . "' and class_div='" . $row['division'] . "'");
                                try {
                                $data = $dataResult->fetch_assoc();
                                echo "<option value='' disabled hidden selected>--Select--</option>";
                                for ($i = $data['class_enroll_start']; $i <= $data['class_enroll_end']; $i++) {
                                    $enrollDtlResult = mysqli_query($conn, "select roll_no,concat(f_name,' ',m_name,' ',l_name) as full_name from stud_personal_details where enroll_no='$i'");
                                    if ($enrollDtlResult->num_rows > 0) {
                                        $enrollDtl = $enrollDtlResult->fetch_assoc();
                                        echo "<option value='" . $i . "'>" . $enrollDtl['roll_no'] . "-" . $enrollDtl['full_name'] . "</option>";
                                    }
                                }
                            } catch (mysqli_sql_exception $e) {
                                echo "" . $e->getMessage() . "";
                            }
                        } else {
                            echo "<option value='' disabled hidden selected>Class Not Assigned</option>";
                        }

                        ?>
                    </select>
                </div>

                <!-- Range entry section -->
                <div class="form-group col-md-6" id="studentRangeEntry" style="display: none;">
                    <label for="studentRangeStart">Range Entry</label>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- <input type="number" class="form-control mb-2" id="studentRangeStart" name="studentRangeStart" placeholder="Start ID"> -->
                            <select class="form-control mb-2" id="studentRangeStart" name="studentRangeStart">
                                <?php

                                //Individual Staff Assigned Enrollment nos
                                $selectQuery = "select course,semester,division from staff_class_assign where staff_email='$staff_email'";
                                $selectResult = $conn->query($selectQuery);

                                //IF class is assigned then fetch enrollment no start and end range to get student data
                                if ($selectResult->num_rows > 0) {
                                    $row = $selectResult->fetch_assoc();
                                    $dataResult = mysqli_query($conn, "select class_enroll_start,class_enroll_end from course_class where course_name='" . $row['course'] . "' and class_semester='" . $row['semester'] . "' and class_div='" . $row['division'] . "'");
                                    try {
                                        $data = $dataResult->fetch_assoc();
                                        echo "<option value='' disabled hidden selected>--Select--</option>";
                                        for ($i = $data['class_enroll_start']; $i <= $data['class_enroll_end']; $i++) {
                                            $enrollDtlResult = mysqli_query($conn, "select roll_no,concat(f_name,' ',m_name,' ',l_name) as full_name from stud_personal_details where enroll_no='$i'");
                                            if ($enrollDtlResult->num_rows > 0) {
                                                $enrollDtl = $enrollDtlResult->fetch_assoc();
                                                echo "<option value='" . $i . "'>" . $enrollDtl['roll_no'] . "-" . $enrollDtl['full_name'] . "</option>";
                                            }
                                        }
                                    } catch (mysqli_sql_exception $e) {
                                        echo "" . $e->getMessage() . "";
                                    }
                                } else {
                                    echo "<option value='' disabled hidden selected>Class Not Assigned</option>";
                                }

                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <!-- <input type="number" class="form-control" id="studentRangeEnd" name="studentRangeEnd" placeholder="End ID"> -->
                            <select class="form-control" id="studentRangeEnd" name="studentRangeEnd">
                                <?php

                                //Individual Staff Assigned Enrollment nos
                                $selectQuery = "select course,semester,division from staff_class_assign where staff_email='$staff_email'";
                                $selectResult = $conn->query($selectQuery);

                                //IF class is assigned then fetch enrollment no start and end range to get student data
                                if ($selectResult->num_rows > 0) {
                                    $row = $selectResult->fetch_assoc();
                                    $dataResult = mysqli_query($conn, "select class_enroll_start,class_enroll_end from course_class where course_name='" . $row['course'] . "' and class_semester='" . $row['semester'] . "' and class_div='" . $row['division'] . "'");
                                    try {
                                        $data = $dataResult->fetch_assoc();
                                        echo "<option value='' disabled hidden selected>--Select--</option>";
                                        for ($i = $data['class_enroll_start']; $i <= $data['class_enroll_end']; $i++) {
                                            $enrollDtlResult = mysqli_query($conn, "select roll_no,concat(f_name,' ',m_name,' ',l_name) as full_name from stud_personal_details where enroll_no='$i'");
                                            if ($enrollDtlResult->num_rows > 0) {
                                                $enrollDtl = $enrollDtlResult->fetch_assoc();
                                                echo "<option value='" . $i . "'>" . $enrollDtl['roll_no'] . "-" . $enrollDtl['full_name'] . "</option>";
                                            }
                                        }
                                    } catch (mysqli_sql_exception $e) {
                                        echo "" . $e->getMessage() . "";
                                    }
                                } else {
                                    echo "<option value='' disabled hidden selected>Class Not Assigned</option>";
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- All section -->
                <div class="form-group col-md-6" id="studentAllEntry" style="display: none;">
                    <label for="studentAll">*All Students data get printed in pdf</label>
                </div>

                <!-- Submit button -->
                <div class="col-md-6 d-flex justify-content-end mt-2">
                    <button name="pdf_submit" type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
        <div id="excelDiv" class="d-none">
            <?php require('excel_report.php'); ?>
        </div>
    </div>


    <!-- Your custom scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Select the form and input elements
            const form = document.querySelector('form');
            const startInput = document.getElementById('studentRangeStart');
            const endInput = document.getElementById('studentRangeEnd');

            // Function to handle form submission
            form.addEventListener('submit', function(event) {
                // Prevent form submission if validation fails
                if (!validateRange()) {
                    event.preventDefault();
                }
            });

            // Function to validate range
            function validateRange() {
                // Get the values from input fields
                const start = parseInt(startInput.value, 10);
                const end = parseInt(endInput.value, 10);

                // Check if end is greater than start
                if (end <= start) {
                    // Display error message (you can customize this part)
                    alert('End value must be greater than Start value.');
                    return false; // Validation fails
                }

                return true; // Validation passes
            }

        });
        // Validate the form based on the selected radio button
        function validateForm() {
            var entryType = document.querySelector('input[name="entryTypeStudent"]:checked');
            if (!entryType) {
                alert('Please select an entry type.');
                return false;
            }

            if (entryType.value === 'single') {
                var singleInput = document.getElementById('studentSingle');
                if (!singleInput.value.trim()) {
                    alert('Please enter student credential.');
                    return false;
                }
            } else if (entryType.value === 'range') {
                var startInput = document.getElementById('studentRangeStart');
                var endInput = document.getElementById('studentRangeEnd');

                if (!startInput.value.trim() || !endInput.value.trim()) {
                    alert('Please enter both start and end IDs.');
                    return false;
                }
            }

            return true; // Form is valid
        }

        // Toggle form sections based on radio button selection
        function toggleEntry(role, entryType) {
            var allEntry = document.getElementById(role + 'AllEntry');
            var singleEntry = document.getElementById(role + 'SingleEntry');
            var rangeEntry = document.getElementById(role + 'RangeEntry');

            allEntry.style.display = (entryType === 'all') ? 'block' : 'none';
            singleEntry.style.display = (entryType === 'single') ? 'block' : 'none';
            if (rangeEntry) {
                rangeEntry.style.display = (entryType === 'range') ? 'block' : 'none';
            }
        }

        // PDF and Excel button click events
        document.getElementById('pdfBtn').addEventListener('click', function() {
            document.getElementById('excelDiv').classList.add('d-none');
            document.getElementById('pdfDiv').classList.remove('d-none');
        });

        document.getElementById('excelBtn').addEventListener('click', function() {
            document.getElementById('pdfDiv').classList.add('d-none');
            document.getElementById('excelDiv').classList.remove('d-none');
        });
    </script>
</body>

</html>