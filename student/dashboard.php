<?php
require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require('../includes/fetchTableData.php');
$enroll = "";

if (!isset($_SESSION['enroll'])) {
    header('location:student_login.php');
    exit();
} else {
    $enroll = $_SESSION['enroll'];
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
    <style>
        .icon-btn{
            background-color:#1865A1;
        }
        .icon-btn:hover{
            background-color:#1D83C4;
        }
    </style>
</head>
<body id="body-pd">
    <?php
        require '../includes/sidebar-student.php';
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
                                    <img src="../assets/images/uploaded_images/<?php echo $personalDetails['pro_pic'] ?>" alt="Admin" class="rounded-circle" width="150">
                                    <div class="mt-3">
                                        <h4><?php echo $personalDetails['f_name']." ".$personalDetails['l_name'] ?></h4>
                                        <p class="text-secondary mb-3"><b>Course :</b> <?php echo $personalDetails['stud_course'] ?></p>
                                        <p class="text-secondary mb-3"><b>Semester-Class:</b> <?php echo $personalDetails['stud_sem'] ?>-<?php echo $personalDetails['stud_div'] ?></p>
                                        <p class="text-muted font-size-sm"><b>SPID. :</b> <?php echo $personalDetails['spid'] ?></p>
                                        <p class="text-muted font-size-sm"><b>Enroll No. :</b> <?php echo $personalDetails['enroll_no'] ?></p>
                                        <p class="text-muted font-size-sm mb-4"><b>Admission Date : </b><?php echo $personalDetails['adm_date'] ?></p>
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
                                        <i class="fa-solid fa-list-ol"></i>
                                        <h6 class="mb-0">Rol No</h6>
                                    </div>
                                    <span class="text-secondary" style="text-transform:capitalize;"><?php echo $personalDetails['roll_no'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-male-female'></i>
                                        <h6 class="mb-0">Gender</h6>
                                    </div>
                                    <span class="text-secondary" style="text-transform:capitalize;"><?php echo $personalDetails['gender'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-phone'></i>
                                        <h6 class="mb-0">Phone Number</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $personalDetails['mob_no'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-envelope' ></i>
                                        <h6 class="mb-0">Email ID</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $personalDetails['email_id'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-id-card' ></i>
                                        <h6 class="mb-0">Aadhar Number</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $personalDetails['aadhar_no'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-credit-card-front' ></i>
                                        <h6 class="mb-0">ABC ID</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $personalDetails['abc_id'] ?></span>
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
                    
                    <div class="col-md-6 mt-3">
                    <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Current Address</i></h6>
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-home'></i>
                                        <h6 class="mb-0">Address Line 1</h6>
                                    </div>
                                    <br><br><span class="text-secondary"><?php echo $address['present_add'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-home'></i>
                                        <h6 class="mb-0">Address Line 2</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $address['present_add2'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class="fa-solid fa-tree-city"></i>
                                        <h6 class="mb-0">City</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $address['present_city'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-code' ></i>
                                        <h6 class="mb-0">Pincode</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $address['present_pincode'] ?></span>
                                </li>
                            </ul>
                        </div>
                    </div><!-- permenant close -->
                    
                    <div class="col-md-6 mt-3">
                    <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Permanent Address</i></h6>
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-home'></i>
                                        <h6 class="mb-0">Address Line 1</h6>
                                    </div>
                                    <br><br><span class="text-secondary"><?php echo $address['permanent_add'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-home'></i>
                                        <h6 class="mb-0">Address Line 2</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $address['permanent_add2'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class="fa-solid fa-tree-city"></i>
                                        <h6 class="mb-0">City</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $address['permanent_city'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-code' ></i>
                                        <h6 class="mb-0">Pincode</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $address['permanent_pincode'] ?></span>
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
                                    <span class="text-secondary"><?php echo $basic_dtl['dob'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-donate-blood' ></i>
                                        <h6 class="mb-0">Blood Group</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $basic_dtl['blood_grp'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-ruler' ></i>
                                        <h6 class="mb-0">Height</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $basic_dtl['stud_height'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-food-menu'></i>
                                        <h6 class="mb-0">Weight</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $basic_dtl['stud_weight'] ?></span>
                                </li>
                                
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-detail' ></i>
                                        <h6 class="mb-0">Hobbies</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $basic_dtl['stud_hobbies'] ?></span>
                                </li>
                                
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-category' ></i>
                                        <h6 class="mb-0">Category</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $basic_dtl['stud_category'] ?></span>
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
                                        <h6 class="mb-0">Religion</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $basic_dtl['stud_religion'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class="fa-solid fa-language"></i>
                                        <h6 class="mb-0">English Knowledge</h6>
                                    </div>
                                    <br><br><span class="text-secondary"><?php echo $basic_dtl['eng_know'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class="fa-solid fa-language"></i>
                                        <h6 class="mb-0">Hindi Knowledge</h6>
                                    </div>
                                    <br><br><span class="text-secondary"><?php echo $basic_dtl['hindi_know'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class="fa-solid fa-language"></i>
                                        <h6 class="mb-0">Gujarati Knowledge</h6>
                                    </div>
                                    <br><br><span class="text-secondary"><?php echo $basic_dtl['guj_know'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class="fa-solid fa-language"></i>
                                        <h6 class="mb-0">Other Languages</h6>
                                    </div>
                                    <br><br><span class="text-secondary"><?php echo $basic_dtl['other_know'] ?></span>
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
                    <div class="col-md-6 mt-3">
                    <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Father Details</i></h6>
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-user'></i>
                                        <h6 class="mb-0">Father's Name</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['fathers_name'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <i class="fa-solid fa-language"></i>
                                        <h6 class="mb-0">Languages Known By Father</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['lang_father'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-phone' ></i>
                                        <h6 class="mb-0">Mobile Number</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['fathers_mob'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-phone' ></i>
                                        <h6 class="mb-0">Is Father Using whatsapp?</h6>
                                    </div>
                                    <br><br><span class="text-secondary"><?php if($parent_dtl['father_wp']=='yes'){echo "<i class='fa-solid fa-check'></i>";}else{echo "<i class='fa-solid fa-xmark'></i>";}  ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-envelope' ></i>
                                        <h6 class="mb-0">Email Id</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['fathers_email'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bxs-business' ></i>
                                        <h6 class="mb-0">Occupation</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['fathers_occup'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-briefcase' ></i>
                                        <h6 class="mb-0">Company Name</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['fathers_co'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-briefcase' ></i>
                                        <h6 class="mb-0">Designation</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['fathers_desig'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-briefcase' ></i>
                                        <h6 class="mb-0">Father's Annual Income</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['fathers_co'] ?></span>
                                </li>
                            </ul>
                        </div>
                    </div><!-- father close -->
                    <div class="col-md-6 mt-3">
                    <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Mother Details</i></h6>
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-user'></i>
                                        <h6 class="mb-0">Mother's Name</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['mothers_name'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <i class="fa-solid fa-language"></i>
                                        <h6 class="mb-0">Languages Known By Mother</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['lang_mother'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-phone' ></i>
                                        <h6 class="mb-0">Mobile Number</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['mothers_mob'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-phone' ></i>
                                        <h6 class="mb-0">Is Mother Using whatsapp?</h6>
                                    </div>
                                    <br><br><span class="text-secondary"><?php if($parent_dtl['mother_wp']=='yes'){echo "<i class='fa-solid fa-check'></i>";}else{echo "<i class='fa-solid fa-xmark'></i>";}  ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-envelope' ></i>
                                        <h6 class="mb-0">Email Id</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['mothers_email'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bxs-business' ></i>
                                        <h6 class="mb-0">Occupation</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['mothers_occup'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-briefcase' ></i>
                                        <h6 class="mb-0">Company Name</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['mothers_co'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-briefcase' ></i>
                                        <h6 class="mb-0">Designation</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['mothers_desig'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-briefcase' ></i>
                                        <h6 class="mb-0">Mother's Annual Income</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $parent_dtl['mothers_co'] ?></span>
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
                    <div class="row justify-content-center gutters-sm">
                    <div class="col-md-6">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-phone' ></i>
                                        <h6 class="mb-0">Emergency Contact No. </h6>
                                    </div>
                                    <br><br><span class="text-secondary"><?php echo $parent_dtl['emergency_mob'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <i class='bx bx-user'></i>
                                        <h6 class="mb-0">Emergency Person Name </h6>
                                    </div>
                                    <br><br><span class="text-secondary"><?php echo $parent_dtl['emergency_name'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-envelope' ></i>
                                        <h6 class="mb-0">Emergency Person Relationship </h6>
                                    </div>
                                    <br><br><span class="text-secondary"><?php echo $parent_dtl['emergency_relationship'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bxs-business' ></i>
                                        <h6 class="mb-0">Emergency Person Address </h6>
                                    </div>
                                    <br><br><span class="text-secondary"><?php echo $parent_dtl['emergency_add'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <i class="fa-solid fa-tree-city"></i>
                                        <h6 class="mb-0">Emergency Person City </h6>
                                    </div>
                                    <br><br><span class="text-secondary"><?php echo $parent_dtl['emergency_city'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <i class='bx bx-briefcase' ></i>
                                        <h6 class="mb-0">Emergency Person Pincode </h6>
                                    </div>
                                    <br><br><span class="text-secondary"><?php echo $parent_dtl['emergency_pincode'] ?></span>
                                </li>
                            </ul>
                        </div>
                    </div><!-- permenant close -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Academic Details -->
     <div id="academicDetails" class="content text-dark mt-5">
        <div class="col-md-10 mb-5">    
                <h4>Academic Details</h4>
            </div>
            <!-- academic Details Form Content Here -->
            <div class="container-fluid">
                <div class="main-body">
                    <div class="row gutters-sm">
                    <div class="col-md-6">
                    <h5 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">SSC Details</i></h5>
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                        <h6 class="mb-0">SSC Board Name</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $academic_dtl['ssc_board']; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <i class="fa-regular fa-calendar-days"></i>
                                        <h6 class="mb-0">SSC month & year</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $academic_dtl['ssc_month_year']; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <i class="fa-solid fa-percent"></i>
                                        <h6 class="mb-0">SSC Percentage</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $academic_dtl['ssc_percentage']; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <i class="fa-solid fa-school-flag"></i>
                                        <h6 class="mb-0">SSC School</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $academic_dtl['ssc_school']; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <i class="fa-brands fa-medium"></i>
                                        <h6 class="mb-0">SSC Medium</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $academic_dtl['ssc_medium']; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div><!-- permenant close -->
                  
                    <div class="col-md-6">
                    <h5 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">HSC Details</i></h5>
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                        <h6 class="mb-0">HSC Board Name</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $academic_dtl['hsc_board']; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <i class="fa-regular fa-calendar-days"></i>
                                        <h6 class="mb-0">HSC month & year</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $academic_dtl['hsc_month_year']; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <i class="fa-solid fa-percent"></i>
                                        <h6 class="mb-0">HSC Percentage</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $academic_dtl['hsc_percentage']; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <i class="fa-solid fa-school-flag"></i>
                                        <h6 class="mb-0">HSC School</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $academic_dtl['hsc_school']; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap py-4 mx-3">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                    <i class="fa-brands fa-medium"></i>
                                        <h6 class="mb-0">HSC Medium</h6>
                                    </div>
                                    <span class="text-secondary"><?php echo $academic_dtl['hsc_medium']; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

          
        </div>

        </div>
    
    <!-- MAIN STUDENT JS -->
    <script src="../assets/js/main.js"></script>        
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const buttons = document.querySelectorAll(".icon-btn");
            const contents = document.querySelectorAll(".content");
            const showAllCheckbox = document.getElementById("showAll");

            buttons.forEach(button => {
                button.addEventListener("click", function() {
                    const target = document.querySelector(this.getAttribute("data-target"));
                    contents.forEach(content => content.classList.remove("active"));
                    if (target) target.classList.add("active");
                });
            });

            showAllCheckbox.addEventListener("change", function() {
                if (this.checked) {
                    contents.forEach(content => content.classList.add("active"));
                    buttons.forEach(button => button.setAttribute("disabled", true));
                } else {
                    contents.forEach(content => content.classList.remove("active"));
                    buttons.forEach(button => button.removeAttribute("disabled"));
                }
            });
        });
    </script>
</body>

</html>