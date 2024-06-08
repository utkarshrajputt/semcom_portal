
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-section {
            display: none;
            margin-top: 20px;
        }
        #studentForm {
            display: block;
        }
        .form-section{
            margin-top: 100px;
        }
    </style>

    <!-- BOXICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- MAIN STUDENT CSS -->
    <link rel="stylesheet" href="../assets/css/student.css">
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
        
        <!-- Button NavBar At Profile Display -->
        
        <!-- PERSONAL DETIALS -->
        <div id="personalDetails" class="content active text-dark mt-5">
            <div class="col-md-10 mb-5">
                <h4>Student Form</h4>
            </div>

            <div class="container-fluid">
                <div class="main-body">
                    <div class="row gutters-sm">
                    <!-- Profile Card -->
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    
                                    <div id="studentCred" class="form-section">
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
                    </div>
                    <div class="col-md-9 mb-3">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-male-female'></i>
                                        <h6 class="mb-0">Gender</h6>
                                    </div>
                                    <span class="text-secondary">Gender</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-phone'></i>
                                        <h6 class="mb-0">Phone Number</h6>
                                    </div>
                                    <span class="text-secondary">123456789</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-envelope' ></i>
                                        <h6 class="mb-0">Email ID</h6>
                                    </div>
                                    <span class="text-secondary">abc@gmail.com</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-id-card' ></i>
                                        <h6 class="mb-0">Aadhar Number</h6>
                                    </div>
                                    <span class="text-secondary">1231 1231 1231</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-credit-card-front' ></i>
                                        <h6 class="mb-0">ABC ID</h6>
                                    </div>
                                    <span class="text-secondary">123 123 123</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>

            
        <!-- PERSONAL DETAILS END -->



        <div id="addressDetails" class="content text-dark mt-5">
            <!-- Address Details Form Content Here -->
            <div class="col-md-10 mb-5">
                <h4>Address Details</h4>
            </div>

            <div class="container-fluid">
                <div class="main-body">
                    <div class="row gutters-sm">
                    <!-- address Card -->
                    <div class="col-md-12">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-home'></i>
                                        <h6 class="mb-0">Address Line 1</h6>
                                    </div>
                                    <span class="text-secondary">address</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-home'></i>
                                        <h6 class="mb-0">Address Line 2</h6>
                                    </div>
                                    <span class="text-secondary">address</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bxs-city' ></i>
                                        <h6 class="mb-0">City</h6>
                                    </div>
                                    <span class="text-secondary">city</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-code' ></i>
                                        <h6 class="mb-0">Pincode</h6>
                                    </div>
                                    <span class="text-secondary">1231123</span>
                                </li>
                            </ul>
                        </div>
                    </div><!-- permenant close -->
                </div>
            </div>
        </div>
        </div>
        <div id="basicDetails" class="content text-dark mt-5">
            <div class="col-md-10 mb-5">    
                <h4>Basic Details</h4>
            </div>
            <!-- Basic Details Form Content Here -->
            <div class="container-fluid">
                <div class="main-body">
                    <div class="row gutters-sm">
                    <div class="col-md-6">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-calendar' ></i>
                                        <h6 class="mb-0">Birth Date</h6>
                                    </div>
                                    <span class="text-secondary">date</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-donate-blood' ></i>
                                        <h6 class="mb-0">Blood Group</h6>
                                    </div>
                                    <span class="text-secondary">blood</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-ruler' ></i>
                                        <h6 class="mb-0">Height</h6>
                                    </div>
                                    <span class="text-secondary">height</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-food-menu'></i>
                                        <h6 class="mb-0">Weight</h6>
                                    </div>
                                    <span class="text-secondary">weight</span>
                                </li>
                            </ul>
                        </div>
                    </div><!-- permenant close -->
                    <div class="col-md-6">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-detail' ></i>
                                        <h6 class="mb-0">hobbies</h6>
                                    </div>
                                    <span class="text-secondary">hobby</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-category' ></i>
                                        <h6 class="mb-0">Category</h6>
                                    </div>
                                    <span class="text-secondary">cate</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-detail' ></i>
                                        <h6 class="mb-0">Religion</h6>
                                    </div>
                                    <span class="text-secondary">region</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-detail' ></i>
                                        <h6 class="mb-0">Caste</h6>
                                    </div>
                                    <span class="text-secondary">cast</span>
                                </li>
                            </ul>
                        </div>
                    </div><!-- permenant close -->
                    </div>
                </div>
            </div>

        </div>
        <div id="parentsDetails" class="content text-dark mt-5">
            <div class="col-md-10 mb-5">    
                <h4>Parents Details</h4>
            </div>
            <!-- parents Details Form Content Here -->
            <div class="container-fluid">
                <div class="main-body">
                    <div class="row gutters-sm">
                    <div class="col-md-6">
                    <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Father Details</i></h6>
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-user'></i>
                                        <h6 class="mb-0">Father's Name</h6>
                                    </div>
                                    <span class="text-secondary">date</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-phone' ></i>
                                        <h6 class="mb-0">Mobile Number</h6>
                                    </div>
                                    <span class="text-secondary">blood</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-envelope' ></i>
                                        <h6 class="mb-0">Email Id</h6>
                                    </div>
                                    <span class="text-secondary">height</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bxs-business' ></i>
                                        <h6 class="mb-0">Occupation</h6>
                                    </div>
                                    <span class="text-secondary">weight</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-briefcase' ></i>
                                        <h6 class="mb-0">Company Name</h6>
                                    </div>
                                    <span class="text-secondary">weight</span>
                                </li>
                            </ul>
                        </div>
                    </div><!-- permenant close -->
                    <div class="col-md-6 mt-3">
                    <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Mother Details</i></h6>
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-user'></i>
                                        <h6 class="mb-0">Mother's Name</h6>
                                    </div>
                                    <span class="text-secondary">hobby</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-phone' ></i>
                                        <h6 class="mb-0">Mobile Number</h6>
                                    </div>
                                    <span class="text-secondary">cate</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-envelope' ></i>
                                        <h6 class="mb-0">Email Id</h6>
                                    </div>
                                    <span class="text-secondary">region</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bxs-business' ></i>
                                        <h6 class="mb-0">Occupation</h6>
                                    </div>
                                    <span class="text-secondary">cast</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-briefcase' ></i>
                                        <h6 class="mb-0">Company Name</h6>
                                    </div>
                                    <span class="text-secondary">weight</span>
                                </li>
                            </ul>
                        </div>
                    </div><!-- permenant close -->  
                    </div>
                </div>
            </div>
        </div>
        <div id="academicDetails" class="content text-dark mt-5">
        <div class="col-md-10 mb-5">    
                <h4>Academic Details</h4>
            </div>
            <!-- academic Details Form Content Here -->
            <div class="container-fluid">
                <div class="main-body">
                    <div class="row gutters-sm">
                    <div class="col-md-4">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <h6 class="mb-0">Course / Year</h6>
                                    </div>
                                    <span class="text-secondary">date</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <h6 class="mb-0">Course Duration</h6>
                                    </div>
                                    <span class="text-secondary">blood</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <h6 class="mb-0">SSC Percentile</h6>
                                    </div>
                                    <span class="text-secondary">height</span>
                                </li>
                            </ul>
                        </div>
                    </div><!-- permenant close -->
                    <div class="col-md-4">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <h6 class="mb-0">HSC Percentile</h6>
                                    </div>
                                    <span class="text-secondary">hobby</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <h6 class="mb-0">Diploma Percentile</h6>
                                    </div>
                                    <span class="text-secondary">cate</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <h6 class="mb-0">CET Score</h6>
                                    </div>
                                    <span class="text-secondary">region</span>
                                </li>
                            </ul>
                        </div>
                    </div><!-- permenant close -->
                    <div class="col-md-4">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <h6 class="mb-0">CET Percentile</h6>
                                    </div>
                                    <span class="text-secondary">date</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <h6 class="mb-0">JEE Percentile</h6>
                                    </div>
                                    <span class="text-secondary">blood</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <h6 class="mb-0">Previous Semester Percentile</h6>
                                    </div>
                                    <span class="text-secondary">height</span>
                                </li>
                            </ul>
                        </div>
                    </div><!-- permenant close -->
                    </div>
                </div>
            </div>
        </div>
        <div id="emergDetails" class="content text-dark mt-5">
            <div class="col-md-10 mb-5">    
                <h4>Emergency Details</h4>
            </div>
            <!-- parents Details Form Content Here -->
            <div class="container-fluid">
                <div class="main-body">
                    <div class="row gutters-sm">
                    <div class="col-md-12">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-user'></i>
                                        <h6 class="mb-0">Father's Name</h6>
                                    </div>
                                    <span class="text-secondary">date</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-phone' ></i>
                                        <h6 class="mb-0">Mobile Number</h6>
                                    </div>
                                    <span class="text-secondary">blood</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-envelope' ></i>
                                        <h6 class="mb-0">Email Id</h6>
                                    </div>
                                    <span class="text-secondary">height</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bxs-business' ></i>
                                        <h6 class="mb-0">Occupation</h6>
                                    </div>
                                    <span class="text-secondary">weight</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-briefcase' ></i>
                                        <h6 class="mb-0">Company Name</h6>
                                    </div>
                                    <span class="text-secondary">weight</span>
                                </li>
                            </ul>
                        </div>
                    </div><!-- permenant close -->
                    </div>
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