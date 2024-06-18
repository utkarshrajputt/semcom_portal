<?php
require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require('../includes/fetchTableData.php');
function displayAddedNumbers($numbers) {
    echo '<div class="alert alert-success mt-3" role="alert">';
    echo 'Enrollment numbers added successfully: ';
    foreach ($numbers as $number) {
        echo "<span class='badge badge-light'>$number</span> ";
    }
    echo '</div>';
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a79beb4099.js" crossorigin="anonymous"></script>

    <!-- BOXICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- MAIN STUDENT CSS -->
    <link rel="stylesheet" href="../assets/css/student.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>

<body id="body-pd">
    <?php
        require '../includes/sidebar-admin.php';
    ?>
    <?php
    if (isset($_POST['submit'])) {
        // print_r($_POST);
        $choice = $_POST['entryTypeStudent'];
        if ($choice == 'file') {
            //check whether file is uploaded or not
            if (isset($_FILES["studentFile"]) && $_FILES["studentFile"]["error"] == UPLOAD_ERR_OK) {
                // Database connection details
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "check";

                // Create connection
                $conn = mysqli_connect($servername, $username, $password, $dbname);

                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Ensure the file is an Excel file
                $allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
                if (!in_array($_FILES['studentFile']['type'], $allowedTypes)) {
                    die("Only Excel files are allowed.");
                }

                // Load the Excel file
                $filePath = $_FILES["studentFile"]["tmp_name"];
                $spreadsheet = IOFactory::load($filePath);
                $worksheet = $spreadsheet->getActiveSheet();

                // Iterate over each row in the worksheet, starting from the second row
                $rowIterator = $worksheet->getRowIterator(2);
                $sql = "INSERT INTO excel (enroll) VALUES (?)";
                $stmt = mysqli_prepare($conn, $sql);

                foreach ($rowIterator as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    foreach ($cellIterator as $cell) {
                        $enrollmentNumber = $cell->getValue();
                        mysqli_stmt_bind_param($stmt, "s", $enrollmentNumber);
                        mysqli_stmt_execute($stmt);
                        $enrollmentNumbers[] = $enrollmentNumber;
                    }
                }

                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                echo "Data imported successfully!";
                displayAddedNumbers($enrollmentNumbers);
            }
        }
    }
    ?>
<body id="body-pd">
    <!-- Sidebar -->
    <?php require '../includes/sidebar-admin.php'; ?>

    <!-- Content -->
    <div id="dashboard" class="container mt-5 pt-5 text-dark">
        <div id="personalDetails" class="content active text-dark">
            <div class="container">
                <h2 class="text-center">Add Student Credential</h2>

                <!-- Form -->
                <div id="studentForm" class="form-section">
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <!-- Radio buttons for entry type -->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="entryTypeStudent" id="fileRadio" value="file" checked
                                        onclick="toggleEntry('student', 'file')">
                                    <label class="form-check-label" for="fileRadio">Import from Excel</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="entryTypeStudent" id="singleRadio" value="single"
                                        onclick="toggleEntry('student', 'single')">
                                    <label class="form-check-label" for="singleRadio">Single Entry</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="entryTypeStudent" id="rangeRadio" value="range"
                                        onclick="toggleEntry('student', 'range')">
                                    <label class="form-check-label" for="rangeRadio">Range Entry</label>
                                </div>
                            </div>
                        </div>

                        <!-- File entry section -->
                        <div class="form-group file-input-group" id="studentFileEntry">
                            <div>
                                <label for="studentFile">Import from Excel</label>
                                <input type="file" class="form-control-file" id="studentFile" name="studentFile"
                                    accept=".xls,.xlsx">
                            </div>
                            <div>
                                <img class="file-demo"
                                    src="../assets/images/excel-icon.png" alt="Excel Demo">
                            </div>
                        </div>

                        <!-- Single entry section -->
                        <div class="form-group" id="studentSingleEntry" style="display: none;">
                            <label for="studentSingle">Single Entry</label>
                            <input type="text" class="form-control" id="studentSingle" placeholder="Enter student credential">
                        </div>

                        <!-- Range entry section -->
                        <div class="form-group" id="studentRangeEntry" style="display: none;">
                            <label for="studentRangeStart">Range Entry</label>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="number" class="form-control" id="studentRangeStart" placeholder="Start ID">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="number" class="form-control" id="studentRangeEnd" placeholder="End ID">
                                </div>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="text-end">
                            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- End Form -->
            </div>
        </div>
    </div>
    

        <!-- MAIN STUDENT JS -->
        <script src="../assets/js/main.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
        // Function to toggle entry sections based on radio button selection
        function toggleEntry(role, entryType) {
            var fileEntry = document.getElementById(role + 'FileEntry');
            var singleEntry = document.getElementById(role + 'SingleEntry');
            var rangeEntry = document.getElementById(role + 'RangeEntry');

            fileEntry.style.display = (entryType === 'file') ? 'block' : 'none';
            singleEntry.style.display = (entryType === 'single') ? 'block' : 'none';
            rangeEntry.style.display = (entryType === 'range') ? 'block' : 'none';
        }
    </script>

</body>

</html>