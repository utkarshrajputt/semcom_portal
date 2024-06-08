<?php
require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require('../includes/fetchTableData.php');
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
    <style>
        .form-section {
            display: none;
            margin-top: 20px;
        }
        #studentForm {
            display: block;
        }
    </style>
   
</head>
<body id="body-pd">
    <?php
        require '../includes/sidebar-admin.php';
    ?>
    <?php
        if(isset($_POST['submit']))
        {
            // print_r($_POST);
            $choice=$_POST['entryTypeStudent'];
            if($choice=='file')
            {
                //check whether file is uploaded or not
                if (isset($_FILES["studentFile"]) && $_FILES["studentFile"]["error"] == UPLOAD_ERR_OK)
                {
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
                        }
                    }
                
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                
                    echo "Data imported successfully!";
                }
            }
            
           
        }
    ?>

    <div id="dashboard" class="text-dark">
        
        <!-- PERSONAL DETIALS -->
        <div id="personalDetails" class="content active text-dark mt-5">
                <div class="container mt-5">
        <h2 class="text-center">Credential Entry Form</h2>
        <!-- <div class="text-center mb-4">
            <label class="mr-3">
                <input type="radio" name="role" value="student" onclick="showForm('student')" checked> Student
            </label>
            <label>
                <input type="radio" name="role" value="staff" onclick="showForm('staff')"> Staff
            </label>
        </div> -->

        <div id="studentForm" class="form-section">
            <h3>Student Form</h3>
            
            <form method="post" action="" enctype="multipart/form-data">
             <div class="form-group">
                <label>
                    <input type="radio" name="entryTypeStudent" value="file" checked onclick="toggleEntry('student', 'file')"> Import from Excel
                </label>
                <label class="ml-3">
                    <input type="radio" name="entryTypeStudent" value="single" onclick="toggleEntry('student', 'single')"> Single Entry
                </label>
                <label class="ml-3">
                    <input type="radio" name="entryTypeStudent" value="range" onclick="toggleEntry('student', 'range')"> Range Entry
                </label>
             </div>
                <div class="form-group" id="studentFileEntry">
                    <label for="studentFile">Import from Excel</label>
                    <input type="file" class="form-control-file" id="studentFile" name="studentFile" accept=".xls,.xlsx">
                </div>
                <div class="form-group" id="studentSingleEntry" style="display: none;">
                    <label for="studentSingle">Single Entry</label>
                    <input type="text" class="form-control" id="studentSingle" placeholder="Enter student credential">
                </div>
                <div class="form-group" id="studentRangeEntry" style="display: none;">
                    <label for="studentRangeStart">Range Entry</label>
                    <div class="form-inline">
                        <input type="number" class="form-control mb-2 mr-sm-2" id="studentRangeStart" placeholder="Start ID">
                        <input type="number" class="form-control mb-2 mr-sm-2" id="studentRangeEnd" placeholder="End ID">
                    </div>
                </div>
                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

            </div>
        </div>
    </div>
    
    
    <!-- MAIN STUDENT JS -->
    <script src="../assets/js/main.js"></script>   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function showForm(role) {
            document.getElementById('studentForm').style.display = (role === 'student') ? 'block' : 'none';
            document.getElementById('staffForm').style.display = (role === 'staff') ? 'block' : 'none';
            clearEntryFields('student');
            clearEntryFields('staff');
        }

        function toggleEntry(role, entryType) {
            var fileEntry = document.getElementById(role + 'FileEntry');
            var singleEntry = document.getElementById(role + 'SingleEntry');
            var rangeEntry = document.getElementById(role + 'RangeEntry');

            fileEntry.style.display = (entryType === 'file') ? 'block' : 'none';
            singleEntry.style.display = (entryType === 'single') ? 'block' : 'none';
            if (rangeEntry) {
                rangeEntry.style.display = (entryType === 'range') ? 'block' : 'none';
            }
        }

        function clearEntryFields(role) {
            document.getElementById(role + 'FileEntry').style.display = 'none';
            document.getElementById(role + 'SingleEntry').style.display = 'none';
            if (document.getElementById(role + 'RangeEntry')) {
                document.getElementById(role + 'RangeEntry').style.display = 'none';
            }
        }
    </script>     

</body>

</html>