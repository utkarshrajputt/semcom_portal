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
    <style>
        .icon-btn {
            width: 125px;
            height: 125px;
            border-radius: 50%;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 5px auto;
        }

        .icon-label {
            font-size: 12px;
            text-align: center;
            margin-top: 5px;
        }

        .student-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            float: right;
        }
        @media (max-width: 768px) {
            .form-outline {
                width: 100%;
            }

            .icon-btn {
                margin: 15px auto;
            }

            .icon-label {
                font-size: 10px;
            }

            .btn-wrapper {
                display: flex;
                justify-content: center;
                flex-direction: column;
                align-items: center;
            }
        }

    </style>
</head>
<body id="body-pd">
    <?php
        require '../includes/sidebar-student.php';
    ?>

    <div id="dashboard" class="text-dark">
        <div class="mb-3">
            <input type="checkbox" id="showAll" /> Show All Forms
        </div>
        <!-- Button NavBar At Profile Display -->
        <div class="row text-center mb-3 justify-content-center">
            <div class="col-4 col-md-2 btn-wrapper">
                <button type="button" class="btn btn-primary icon-btn" data-target="#personalDetails">
                    <i class="fas fa-user"></i>
                </button>
                <div class="icon-label">Personal Details</div>
            </div>
            <div class="col-4 col-md-2 btn-wrapper">
                <button type="button" class="btn btn-primary icon-btn" data-target="#addressDetails">
                    <i class="fas fa-home"></i>
                </button>
                <div class="icon-label">Address Details</div>
            </div>
            <div class="col-4 col-md-2 btn-wrapper">
                <button type="button" class="btn btn-primary icon-btn" data-target="#basicDetails">
                    <i class="fas fa-info-circle"></i>
                </button>
                <div class="icon-label">Basic Details</div>
            </div>
            <div class="col-6 col-md-2 btn-wrapper">
                <button type="button" class="btn btn-primary icon-btn" data-target="#parentsDetails">
                    <i class="fas fa-users"></i>
                </button>
                <div class="icon-label">Parents Details</div>
            </div>
            <div class="col-6 col-md-2 btn-wrapper">
                <button type="button" class="btn btn-primary icon-btn" data-target="#academicDetails">
                    <i class="fas fa-graduation-cap"></i>
                </button>
                <div class="icon-label">Academic Details</div>
            </div>
        </div>

        <div id="personalDetails" class="content active text-dark">
            <div class="col-md-10">
                <h4>Personal Details</h4>
            </div>
            <div class="col-md-12 text-md-end text-center">
                <img src="../assets/images/uploaded_images/12101150801011.jpg" alt="Student Image" class="student-img mb-3 mb-md-0">
            </div>
            <div id="personalDetails">
                <form class="personal-details-form">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h6 class="mb-2">Admission Status:</h6>
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="adm_status" value="regular" required disabled checked />
                                    <label class="form-check-label" for="regular">Regular</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="adm_status" value="prov_admission" required disabled />
                                    <label class="form-check-label" for="prov_admission">Provisional Admission</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="ad_date">Admission Date</label>
                            <input type="date" name="ad_date" class="form-control" value="2021-08-15" required readonly />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="spid">SPID</label>
                            <input type="text" name="spid" class="form-control" pattern="\d*" value="12345678" required readonly />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="enrol_id">CVM Enrollment ID</label>
                            <input type="text" name="enroll_id" value="CVM12345" class="form-control" required readonly />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="roll">Roll Number</label>
                            <input type="text" name="roll" class="form-control" pattern="\d*" value="42" required readonly />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label" for="fname">First Name</label>
                            <input type="text" name="fname" class="form-control" pattern="[A-Za-z]+" value="John" required readonly />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="mname">Middle Name</label>
                            <input type="text" name="mname" class="form-control" pattern="[A-Za-z]+" value="Doe" required readonly />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="lname">Last Name</label>
                            <input type="text" name="lname" class="form-control" pattern="[A-Za-z]+" value="Smith" required readonly />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="mb-2">Gender:</h6>
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="male" required disabled checked />
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="female" required disabled />
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="other" required disabled />
                                    <label class="form-check-label" for="other">Other</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="phone">Mobile Number</label>
                            <input type="text" name="phone" class="form-control" pattern="\d*" value="9876543210" required readonly />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="email">Email ID</label>
                            <input type="email" name="email" class="form-control" value="john.doe@example.com" required readonly />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="aadhar">Aadhar Number</label>
                            <input type="text" name="aadhar" class="form-control" pattern="\d*" value="123456789012" required readonly />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="abcid">ABC ID</label>
                            <input type="text" name="abcid" class="form-control" value="ABC1234567" required readonly />
                        </div>
                    </div>
                </form>

            </div>

        </div>
        <div id="addressDetails" class="content text-dark">
            <h4>Address Details</h4>
            <!-- Address Details Form Content Here -->
        </div>
        <div id="basicDetails" class="content text-dark">
            <h4>Basic Details</h4>
            <!-- Basic Details Form Content Here -->
        </div>
        <div id="parentsDetails" class="content text-dark">
            <h4>Parents Details</h4>
            <!-- Parents Details Form Content Here -->
        </div>
        <div id="academicDetails" class="content text-dark">
            <h4>Academic Details</h4>
            <!-- Academic Details Form Content Here -->
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