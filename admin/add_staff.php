<?php
require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require('../includes/fetchTableData.php');
$admin_email = $_SESSION['admin_email'];

if (!isset($admin_email)) {
    header('location:admin_login.php');
}

if (isset($_POST["pers_submit"])) {
    try{
    $prefix = $_POST["prefix"];
    $full_name = $_POST["name"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob_date"];
    $doj = $_POST["join_date"];
    $mob = $_POST["phone"];
    $h_qual = $_POST["hi_qualify"];
    $exp = $_POST["exp"];
    $skills = $_POST["skills"];
    $qual = $_POST["qualify"];
    $staff_email = $_POST["clg_email"];
    $pass = $_POST["clg_pass"];

    if (isset($_FILES['pfp'])) {
        $uploads_dir = '../assets/images/staff_images/';
        $tmp_name = $_FILES["pfp"]["tmp_name"];
        $name = basename($_FILES["pfp"]["name"]);
        $file = $uploads_dir . $name;

        if ($file == '../assets/images/staff_images/') {
            echo "<script>alert('Upload Image Again')</script>";
        } else {
            $temp = explode(".", $_FILES["pfp"]["name"]);
            $extension = end($temp);
            $filename = substr($_POST['name'], 0, strpos($_POST['name'], ' ')) . date('YmdHis') . "." . $extension;
            $move = move_uploaded_file($tmp_name, "$uploads_dir/$filename");

            if ($move == true) {
                $insert = mysqli_query($conn, "insert into staff_dtl(prefix, full_name, gender, dob, doj, mob_no, hi_qualification, exp, skills, qualifications, clg_email, password, staff_img) values('$prefix', '$full_name', '$gender','$dob','$doj', '$mob', '$h_qual', '$exp', '$skills', '$qual', '$staff_email', '$pass', '$filename')");


                echo "<script>alert('Data Saved Successfully!!');</script>";
                // echo "<script>location.reload(true);</script>";
            }
        }
        }
    }
    catch (mysqli_sql_exception $e) {
        echo '' . $e->getMessage() . '';
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a79beb4099.js" crossorigin="anonymous"></script>

    <!-- BOXICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- MAIN STUDENT CSS -->
    <link rel="stylesheet" href="../assets/css/student.css">
    <style>
        .form-container {
            margin-left: 35%;
            margin-top: 150px;
            max-width: 400px;
            background-color: #fff;
            padding: 32px 24px;
            font-size: 14px;
            font-family: inherit;
            color: #212121;
            display: flex;
            flex-direction: column;
            gap: 20px;
            box-sizing: border-box;
            border-radius: 10px;
            box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.084), 0px 2px 3px rgba(0, 0, 0, 0.168);
        }

        .form-container button:active {
            scale: 0.95;
        }

        .form-container .logo-container {
            text-align: center;
            font-weight: 600;
            font-size: 18px;
        }

        .form-container .form {
            display: flex;
            flex-direction: column;
        }

        .form-container .form-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .form-container .form-group label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .form-container .form-group input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 6px;
            font-family: inherit;
            border: 1px solid #ccc;
        }

        .form-container .form-group input::placeholder {
            opacity: 0.5;
        }

        .form-container .form-group input:focus {
            outline: none;
            border-color: #1778f2;
        }

        .form-container .form-submit-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: inherit;
            color: #fff;
            background-color: blue;
            border: none;
            width: 100%;
            padding: 12px 16px;
            font-size: inherit;
            gap: 8px;
            margin: 12px 0;
            cursor: pointer;
            border-radius: 6px;
            box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.084), 0px 2px 3px rgba(0, 0, 0, 0.168);
        }

        .form-container .form-submit-btn:hover {
            background-color: #313131;
        }

        .error-message {
            color: red;
            display: none;
        }

        @media (max-width: 768px) {
            .form-container {
                margin-left: 0;
            }
        }
        .nav_link {
            margin-bottom: 20px;
        }

        .dropdown {
            margin-top: 25px;
            padding-top: 15px;
        }
    </style>
</head>

<body id="body-pd">
    <?php
    require '../includes/sidebar-admin.php';
    ?>

   

    <div id="dashboard" class="container mt-5 pt-5 text-dark">
            <div id="personalDetails" class="content active text-dark">
                <div class="container">
                    <h2 class="text-center" style="font-weight:bolder;">Add Staff Details</h2>

        <!-- PERSONAL DETIALS -->


            <div class="container-fluid">
                <div class="main-body">
                    <div class="row gutters-sm">
                        <!-- Profile Card -->
                        <form class="personal-details-form" method="post" enctype="multipart/form-data" novalidate>

                            <div class="row">
                                <div class="col-md-2 mb-4">
                                    <!-- ROLL NUMBER -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="roll">Prefix</label>
                                        <select name="prefix" class="form-control form-control-lg" required>
                                            <option value="" disabled selected hidden>- Prefix -</option>
                                            <option>Mrs.</option>
                                            <option>Ms.</option>
                                            <option>Mr.</option>
                                            <option>Dr.</option>
                                            <option>Er.</option>
                                        </select>
                                        <div class="invalid-feedback">Please Select Prefix !</div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <!-- SPID -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="spid">Full Name</label>
                                        <input type="text" name="name" class="form-control form-control-lg" required />
                                        <div class="invalid-feedback">Please fill full name !</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <!-- GENDER -->
                                    <h6 class="mb-2 pb-1">Gender:</h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="male" required />
                                        <label class="form-check-label" for="maleGender">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="female" required />
                                        <label class="form-check-label" for="femaleGender">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="other" required />
                                        <label class="form-check-label" for="otherGender">Other</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="ad_date">Date of Birth</label>
                                        <input type="Date" name="dob_date" class="form-control form-control-lg" required />
                                        <div class="invalid-feedback">Please select the date !</div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="ad_date">Date of Joining</label>
                                        <input type="Date" name="join_date" class="form-control form-control-lg" required />
                                        <div class="invalid-feedback">Please select the date !</div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6 mb-4 pb-2">
                                    <!-- PHONE NUMBER -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="phoneNumber">Phone Number</label>
                                        <input type="text" name="phone" class="form-control form-control-lg" pattern="\d{10}" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                        <div class="invalid-feedback">Please fill phone number !</div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4 pb-2">
                                    <!-- EMAIL -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="emailAddress">Highest Qualifaction</label>
                                        <select name="hi_qualify" class="form-control form-control-lg" required>
                                            <option value="" disabled selected hidden>- Select -</option>
                                            <option>Graduate</option>
                                            <option>Post Graduate</option>
                                            <option>Ph.D</option>
                                            <option>Diploma</option>
                                        </select>
                                        <div class="invalid-feedback">Please Select Highest Qualifaction !</div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-4 pb-2">
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="emailAddress">Experience</label>
                                        <input type="text" name="exp" pattern="[A-Za-z0.9\ ]*" oninput="this.value=this.value.replace(/[^A-Za-z0-9\ ]/g,'');" class="form-control form-control-lg" required />
                                        <div class="invalid-feedback">Please fill Experience !</div>
                                    </div>

                                </div>
                                <div class="col-md-4 mb-4 pb-2">
                                    <!-- EMAIL -->
                                    <div data-mdb-input-init class="form-outline">

                                        <label class="form-label" for="phoneNumber">Skills</label>
                                        <input type="text" name="skills" pattern="[A-Za-z0-9\ \-]*" oninput="this.value=this.value.replace(/[^A-Za-z0-9\ \-]/g,'');" class="form-control form-control-lg" required />
                                        <div class="invalid-feedback">Please fill Skills !</div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4 pb-2">
                                    <!-- EMAIL -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="emailAddress">Qualifaction</label>
                                        <input type="text" name="qualify" pattern="[A-Za-z\ ]*" oninput="this.value=this.value.replace(/[^A-Za-z\ ]/g,'');" class="form-control form-control-lg" required />
                                        <div class="invalid-feedback">Please fill Qualifaction !</div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <center><label class="form-label" for="">
                                        <h4>-- Login Credential --</h4>
                                    </label></center>
                                <div class="col-md-6 mb-4 pb-2">
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="aadhar">Email</label>
                                        <input type="email" name="clg_email" class="form-control form-control-lg" required />
                                        <div class="invalid-feedback">Please Enter Valid Email !</div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4 pb-2">
                                    <!-- ABC ID -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="abc_id">Password</label>
                                        <input type="password" name="clg_pass" class="form-control form-control-lg" pattern=".{8,}" required />
                                        <div class="invalid-feedback">Password Must Be Minimum 8 Characters !</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-1 pt-2">
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="filelbl">Upload Your Profile Picture <span style="color:red;">(Image size must be less than 100kb)</span></label>
                                    <input type="file" name="pfp" class="form-control" accept=".jpg, .jpeg" id="inputGroupFile02" required>
                                </div>
                            </div>
                            <!-- SUBMIT & NEXT -->
                            <div class="mt-4 pt-2">
                                <input data-mdb-ripple-init class="btn btn-primary btn-lg" name="pers_submit" type="submit" value="Save" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MAIN STUDENT JS -->
    <script src="../assets/js/main.js"></script>
    <script>
        function applyValidation(forms) {
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {

            var personalDetailsForms = document.querySelectorAll('.personal-details-form');
            applyValidation(personalDetailsForms);

        });
    </script>
</body>

</html>