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
    </style>
</head>
<body id="body-pd">
    <?php
        require '../includes/sidebar-admin.php';
    ?>

    <div id="dashboard" class="text-dark">
        
        <!-- PERSONAL DETIALS -->
        <div id="personalDetails" class="content active text-dark mt-5">
            <div class="pd col-md-10 mb-5 mt-4">
                <h4>Staff Details</h4>
            </div>

            <div class="container-fluid">
                <div class="main-body">
                    <div class="row gutters-sm">
                    <!-- Profile Card -->
                    <form class="personal-details-form <?php echo isset($personalDetails['adm_status']) ? 'disable-form' : ''; ?>" method="post" enctype="multipart/form-data" novalidate>
                        
                        <div class="row">
                        <div class="col-md-1 mb-4">
                                <!-- ROLL NUMBER -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="roll">Prefix</label>
                                    <br><span style='font-size:1.3rem;font-weight:bold'><?php echo isset($personalDetails['stud_course']) ? $personalDetails['stud_course'] : ''; ?></span>
                                    <?php
                                    if (!(isset($personalDetails['stud_course']))) {

                                    ?>
                                        <select name="course" class="form-control form-control-lg" required>
                                            <option value="" disabled selected hidden>- Prefix -</option>
                                            <option value="BCA">Mrs.</option>
                                            <option value="BCOM">Ms.</option>
                                            <option value="BBA">Mr.</option>
                                            <option value="BBA-ITM">Dr.</option>
                                            <option value="MCOM">Er.</option>
                                        </select>
                                        <div class="invalid-feedback">Please fill roll number !</div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <!-- SPID -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="spid">Full Name</label>
                                    <input type="text" name="spid" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo isset($personalDetails['spid']) ? $personalDetails['spid'] : ''; ?>" required />
                                    <div class="invalid-feedback">Please fill SPID !</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- GENDER -->
                                <h6 class="mb-2 pb-1">Gender:</h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="male" <?php if (isset($personalDetails['gender'])) {
                                                                                                                if ($personalDetails['gender'] == "male") {
                                                                                                                    echo "checked";
                                                                                                                }
                                                                                                            } ?> required />
                                    <label class="form-check-label" for="maleGender">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="female" <?php if (isset($personalDetails['gender'])) {
                                                                                                                    if ($personalDetails['gender'] == "female") {
                                                                                                                        echo "checked";
                                                                                                                    }
                                                                                                                } ?> required />
                                    <label class="form-check-label" for="femaleGender">Female</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="other" <?php if (isset($personalDetails['gender'])) {
                                                                                                                    if ($personalDetails['gender'] == "other") {
                                                                                                                        echo "checked";
                                                                                                                    }
                                                                                                                } ?> required />
                                    <label class="form-check-label" for="otherGender">Other</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- ADMISSION DATE -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="ad_date">Date of Birth</label>
                                    <input type="Date" name="ad_date" class="form-control form-control-lg" value="<?php echo isset($personalDetails['adm_date']) ? $personalDetails['adm_date'] : ''; ?>" required />
                                    <div class="invalid-feedback">Please select the date !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <!-- ADMISSION DATE -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="ad_date">Date of Joining</label>
                                    <input type="Date" name="ad_date" class="form-control form-control-lg" value="<?php echo isset($personalDetails['adm_date']) ? $personalDetails['adm_date'] : ''; ?>" required />
                                    <div class="invalid-feedback">Please select the date !</div>
                                </div>
                            </div>
                                                                                                            </div>
                            
                        
                        <div class="row">
                            <div class="col-md-6 mb-4 pb-2">
                                <!-- PHONE NUMBER -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="phoneNumber">Phone Number</label>
                                    <input type="text" name="phone" class="form-control form-control-lg" value="<?php echo isset($personalDetails['mob_no']) ? $personalDetails['mob_no'] : ''; ?>" pattern="\d{10}" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please fill phone number !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 pb-2">
                                <!-- EMAIL -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="emailAddress">Qualifaction</label>
                                    <input type="email" name="email" value="<?php echo isset($personalDetails['email_id']) ? $personalDetails['email_id'] : ''; ?>" class="form-control form-control-lg" required />
                                    <div class="invalid-feedback">Please fill email !</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <center><label class="form-label" for="aadhar"><h4>-- Login Credential --</h4></label></center>
                            <div class="col-md-6 mb-4 pb-2">
                                <!-- AADHAR CARD NUMBER -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="aadhar">Email</label>
                                    <input type="text" name="aadhar" value="<?php echo isset($personalDetails['aadhar_no']) ? $personalDetails['aadhar_no'] : ''; ?>" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please choose aadhar card !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 pb-2">
                                <!-- ABC ID -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="abc_id">Password</label>
                                    <input type="text" name="abcid" class="form-control form-control-lg" value="<?php echo isset($personalDetails['abc_id']) ? $personalDetails['abc_id'] : ''; ?>" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please fill ABC ID !</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-1 pt-2">
                            <div data-mdb-input-init class="form-outline">
                                <label class="form-label" for="filelbl">Upload Your Profile Picture</label>
                                <?php
                                if (isset($personalDetails['pro_pic'])) {
                                    $src = "../assets/images/uploaded_images/" . $personalDetails['pro_pic'];
                                ?>
                                    <div><img src="<?php echo $src; ?>" height="120" width="120"></div>
                                <?php
                                } else {

                                ?>
                                    <input type="file" name="pfp" class="form-control" accept=".jpg, .jpeg" id="inputGroupFile02" required>
                                <?php
                                }
                                ?>
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

</body>

</html>