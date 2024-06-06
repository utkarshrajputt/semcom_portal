<?php
require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require('../includes/fetchTableData.php');
$enroll = $_SESSION['enroll'];

if (!isset($enroll)) {
    header('location:student_login.php');
} else {
    $row=mysqli_fetch_row(mysqli_query($conn,"select complete_register from stud_login where enroll_no=$enroll"));
    $bool=$row[0];
    if($bool=='no')
    {
        header("location:profile_dashboard.php");
    }    
    $personalDetails = fetchData('stud_personal_details', $enroll, $conn);
    $address = fetchData('stud_address', $enroll, $conn);
    $basic_dtl = fetchData('stud_other_details', $enroll, $conn);
    $parent_dtl = fetchData('stud_parents_details', $enroll, $conn);
    $academic_dtl = fetchData('stud_academic_details', $enroll, $conn);
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
</head>
<body id="body-pd">
    <?php
        require '../includes/sidebar-admin.php';
    ?>

    <div id="dashboard" class="text-dark">
        <!-- <div class="mb-3 py-3">
            <input type="checkbox" id="showAll" /> Show All Forms
        </div> -->
        <!-- Button NavBar At Profile Display -->
        <div class="row text-center mb-3 d-flex justify-content-center align-items-center">
            <div class="col-4  mt-3  col-md-2 btn-wrapper d-flex justify-content-center align-items-center flex-column">
                <button type="button" class="btn btn-primary icon-btn" data-target="#personalDetails">
                    <i class="fas fa-user"></i>
                </button>
                <div class="icon-label">Personal Details</div>
            </div>
            <div class="col-4  mt-3 col-md-2 btn-wrapper d-flex justify-content-center align-items-center flex-column">
                <button type="button" class="btn btn-primary icon-btn" data-target="#addressDetails">
                    <i class="fas fa-home"></i>
                </button>
                <div class="icon-label">Address Details</div>
            </div>
            <div class="col-4  mt-3 col-md-2 btn-wrapper d-flex justify-content-center align-items-center flex-column">
                <button type="button" class="btn btn-primary icon-btn" data-target="#basicDetails">
                    <i class="fas fa-info-circle"></i>
                </button>
                <div class="icon-label">Basic Details</div>
            </div>
            <div class="col-4  mt-3 col-md-2 btn-wrapper d-flex justify-content-center align-items-center flex-column">
                <button type="button" class="btn btn-primary icon-btn" data-target="#parentsDetails">
                    <i class="fas fa-users"></i>
                </button>
                <div class="icon-label">Parents Details</div>
            </div>
            <div class="col-4  mt-3 col-md-2 btn-wrapper d-flex justify-content-center align-items-center flex-column">
                <button type="button" class="btn btn-primary icon-btn" data-target="#emergDetails">
                <i class="fa-regular fa-id-card"></i>
                </button>
                <div class="icon-label">Emergency Details</div>
            </div>
            <div class="col-4  mt-3 col-md-2 btn-wrapper d-flex justify-content-center align-items-center flex-column">
                <button type="button" class="btn btn-primary icon-btn" data-target="#academicDetails">
                    <i class="fas fa-graduation-cap"></i>
                </button>
                <div class="icon-label">Academic Details</div>
            </div>
        </div><!-- Button NavBar At Profile Display end -->


        <!-- PERSONAL DETIALS -->
        <div id="personalDetails" class="content active text-dark mt-5">
            <div class="col-md-10 mb-5">
                <h4>Personal Details</h4>
            </div>

            <div class="container-fluid">
                <div class="main-body">
                    <div class="row gutters-sm">
                    <!-- Profile Card -->
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                                    <div class="mt-3">
                                        <h4>John Doe</h4>
                                        <p class="text-secondary mb-3">Class</p>
                                        <p class="text-muted font-size-sm">ER number</p>
                                        <p class="text-muted font-size-sm mb-4">Admission Date</p>
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

</body>

</html>