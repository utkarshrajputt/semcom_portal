<?php
require('loader.php');
require('../../includes/session.php');
require('../../config/mysqli_db.php');
$staff_email = "";

if (!isset($_SESSION['staff_email'])) {
    header('location:index.php');
    exit();
}else{
    $staff_email = $_SESSION['staff_email'];
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
    <link rel="stylesheet" href="../../assets/css/student.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .blur-background {
            filter: blur(5px);
            opacity: 0.6;
        }

        .modal-form {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 80%;
            max-height: 90%;
            /* Set a maximum height for the modal */
            overflow-y: auto;
        }

        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
        }

        .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            font-size: 35px;
            border: none;
            background: transparent;
        }

        .form-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .modal-form::-webkit-scrollbar {
            width: 10px;
        }

        .modal-form::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .modal-form::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .modal-form::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>

<body id="body-pd">
    <?php require 'navbar.php'; ?>
    <?php
    if (isset($_POST['parent_submit'])) {
        $id = $_POST['id'];
        $enroll = $_POST["enroll_no"];
        $fa_name = $_POST["fatherName"];

        $fa_lang = "";
        if (!empty($_POST['fatherLanguage'])) {
            foreach ($_POST['fatherLanguage'] as $fa_lang_check) {
                $fa_lang = $fa_lang . "," . $fa_lang_check;
            }
        }
        $fa_lang = substr($fa_lang, 1);

        $fa_mob = $_POST["fatherMobile"];
        $fa_wp = $_POST["fatherWhatsApp"];
        $fa_email = $_POST["fatherEmail"];
        $fa_occu = $_POST["fatherOccupation"];
        $fa_co = $_POST["fatherCompany"];
        $fa_desig = $_POST["fatherDesignation"];
        $fa_inc = $_POST["fatherAnnualIncome"];

        // Mother
        $ma_name = $_POST["motherName"];
        $ma_lang = "";
        if (!empty($_POST['motherLanguage'])) {
            foreach ($_POST['motherLanguage'] as $ma_lang_check) {
                $ma_lang = $ma_lang . "," . $ma_lang_check;
            }
        }
        $ma_lang = substr($ma_lang, 1);

        $ma_mob = $_POST["motherMobile"];
        $ma_wp = $_POST["motherWhatsApp"];
        $ma_email = $_POST["motherEmail"];
        $ma_occu = $_POST["motherOccupation"];
        $ma_co = $_POST["motherCompany"];
        $ma_desig = $_POST["motherDesignation"];
        $ma_inc = $_POST["motherAnnualIncome"];

        // Emerrgency

        $em_mob = $_POST["emergencyContactPhone"];
        $em_name = $_POST["emergencyContactName"];
        $em_relation = $_POST["emergencyContactRelation"];
        $em_add = $_POST["emergencyContactAddress"];
        $em_city = $_POST["emergencyContactCity"];
        $em_pin = $_POST["emergencyContactPin"];

        try {
            $sql = "
            UPDATE stud_parents_details 
            SET 
                enroll_no = '$enroll', 
                fathers_name = '$fa_name', 
                lang_father = '$fa_lang', 
                fathers_mob = '$fa_mob', 
                father_wp = '$fa_wp', 
                fathers_email = '$fa_email', 
                fathers_occup = '$fa_occu', 
                fathers_co = '$fa_co', 
                fathers_desig = '$fa_desig', 
                fathers_annual_income = '$fa_inc', 
                mothers_name = '$ma_name', 
                lang_mother = '$ma_lang', 
                mothers_mob = '$ma_mob', 
                mother_wp = '$ma_wp', 
                mothers_email = '$ma_email', 
                mothers_occup = '$ma_occu', 
                mothers_co = '$ma_co', 
                mothers_desig = '$ma_desig', 
                mothers_annual_income = '$ma_inc', 
                emergency_mob = '$em_mob', 
                emergency_name = '$em_name', 
                emergency_relationship = '$em_relation', 
                emergency_add = '$em_add', 
                emergency_city = '$em_city', 
                emergency_pincode = '$em_pin'
            WHERE 
                p_id = '$id'
        ";

            // Execute the query
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Data Updated Successfully!!');</script>";
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        } catch (mysqli_sql_exception $e) {
            echo "" . $e->getMessage() . "";
        }
    }
    ?>
    <div id="searchBox" class="mt -2 mb-3 d-flex justify-content-end">
        <input type="text" class="form-control w-50 me-2" id="searchInput" placeholder="Search...">
        <button class="btn btn-info" onclick="searchTable('result_body','searchInput')">Search</button>
    </div>
    <div class="container mt-5">
        <h3 class="mb-4">Edit Student Parents Details</h3>
        <div id="displayTable" class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-light">
                    <tr valign="top">
                        <th></th>
                        <th>ID</th>
                        <th>Enroll No</th>
                        <th>Student Full Name</th>
                        <th>Roll No</th>
                        <th>Father's Name</th>
                        <th>Language Known By Father</th>
                        <th>Father's Mobile</th>
                        <th>Father's WhatsApp</th>
                        <th>Father's Email</th>
                        <th>Father's Occupation</th>
                        <th>Father's Company</th>
                        <th>Father's Designation</th>
                        <th>Father's Annual Income</th>
                        <th>Mother's Name</th>
                        <th>Language Known By Mother</th>
                        <th>Mother's Mobile</th>
                        <th>Mother's WhatsApp</th>
                        <th>Mother's Email</th>
                        <th>Mother's Occupation</th>
                        <th>Mother's Company</th>
                        <th>Mother's Designation</th>
                        <th>Mother's Annual Income</th>
                        <th>Emergency Mobile</th>
                        <th>Emergency Name</th>
                        <th>Emergency Relationship</th>
                        <th>Emergency Address</th>
                        <th>Emergency City</th>
                        <th>Emergency Pincode</th>
                    </tr>
                </thead>
                <tbody id="result_body">
                    <?php
                    $selectQuery = "select course,semester,division from staff_class_assign where staff_email='$staff_email'";
                    $selectResult = $conn->query($selectQuery);
                    if ($selectResult->num_rows > 0) {
                        $row = $selectResult->fetch_assoc();
                        $dataResult = mysqli_query($conn, "select class_enroll_start,class_enroll_end from course_class where course_name='" . $row['course'] . "' and class_semester='" . $row['semester'] . "' and class_div='" . $row['division'] . "'");
                        try {
                            $data = $dataResult->fetch_assoc();

                            $resultDataResult = mysqli_query($conn, "select * from stud_parents_details order by enroll_no");
                            if ($resultDataResult->num_rows > 0) {
                                while ($resultData = $resultDataResult->fetch_assoc()) {
                                    if ($resultData['enroll_no'] >= $data['class_enroll_start'] && $resultData['enroll_no'] <= $data['class_enroll_end']) {
                                        $enroll = $resultData['enroll_no'];
                                        $enrollDtlResult = mysqli_query($conn, "select concat(f_name,' ',m_name,' ',l_name) as full_name,roll_no from stud_personal_details where enroll_no='$enroll'");
                                        $enrollDtl = $enrollDtlResult->fetch_assoc();
                    ?>
                                        <td><button class="btn btn-warning btn-sm" onclick="editRecord(this)">Edit</button></td>
                                        <td><?php echo $resultData['p_id']; ?></td>
                                        <td><?php echo $resultData['enroll_no']; ?></td>
                                        <td><?php echo $enrollDtl['full_name']; ?></td>
                                        <td><?php echo $enrollDtl['roll_no']; ?></td>
                                        <td><?php echo $resultData['fathers_name']; ?></td>
                                        <td><?php echo $resultData['lang_father']; ?></td>
                                        <td><?php echo $resultData['fathers_mob']; ?></td>
                                        <td><?php echo $resultData['father_wp']; ?></td>
                                        <td><?php echo $resultData['fathers_email']; ?></td>
                                        <td><?php echo $resultData['fathers_occup']; ?></td>
                                        <td><?php echo $resultData['fathers_co']; ?></td>
                                        <td><?php echo $resultData['fathers_desig']; ?></td>
                                        <td><?php echo $resultData['fathers_annual_income']; ?></td>
                                        <td><?php echo $resultData['mothers_name']; ?></td>
                                        <td><?php echo $resultData['lang_mother']; ?></td>
                                        <td><?php echo $resultData['mothers_mob']; ?></td>
                                        <td><?php echo $resultData['mother_wp']; ?></td>
                                        <td><?php echo $resultData['mothers_email']; ?></td>
                                        <td><?php echo $resultData['mothers_occup']; ?></td>
                                        <td><?php echo $resultData['mothers_co']; ?></td>
                                        <td><?php echo $resultData['mothers_desig']; ?></td>
                                        <td><?php echo $resultData['mothers_annual_income']; ?></td>
                                        <td><?php echo $resultData['emergency_mob']; ?></td>
                                        <td><?php echo $resultData['emergency_name']; ?></td>
                                        <td><?php echo $resultData['emergency_relationship']; ?></td>
                                        <td><?php echo $resultData['emergency_add']; ?></td>
                                        <td><?php echo $resultData['emergency_city']; ?></td>
                                        <td><?php echo $resultData['emergency_pincode']; ?></td>
                                        </tr>
                    <?php
                                    }
                                }
                            } else {
                                echo "<tr class='text-center'><td colspan='2'>No Data Found in Table</td></tr>";
                            }
                        } catch (mysqli_sql_exception $e) {
                            echo "<tr class='text-center'><td colspan='2'>Enrollment Not Assigned</td></tr>";
                        }
                    } else {
                        echo "<tr class='text-center'><td colspan='2'>Class Not Assigned</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="editForm" class="modal-form d-none">
        <div class="container-fluid pt-3">
            <button type="button" class="close-btn" onclick="closeForm('editForm')">&times;</button>
            <div class="row mt-2 justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7 w-100">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <!-- FORM START -->
                            <form id="editForm" class="parents-details-form" novalidate method="post">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <!-- ID -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label">ID</label>
                                            <input type="text" id="id" name="id" class="form-control form-control-md" required readonly />
                                            <div class="invalid-feedback">Fetch ID!</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <!-- CVM ENROLLMENT ID -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="enrol_id">Enrollment ID</label>
                                            <input type="text" id="enroll_no" name="enroll_no" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                            <div class="invalid-feedback">Please fill Enrollment ID !</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <br>
                                        <h4 style="letter-spacing: 0.2em;" class="lh-lg"> <span class="span-lines">-----</span> FATHER'S DETAILS <span class="span-lines">-----</span> </h4><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="fatherName">Father's Name</label>
                                            <input type="text" name="fatherName" class="form-control form-control-lg" pattern="[A-Za-z]*" id="fatherName" required />
                                            <div class="invalid-feedback">Please fill name !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4 pb-5">
                                        <div data-mdb-input-init class="form-outline">
                                            <div class="form-group">
                                                <label class="form-label">Language Known By Father</label><br>
                                                <span style='font-size:1.3rem;font-weight:bold' id="langFatherDisplay"></span>
                                                <br>
                                                <input type="checkbox" name="fatherLanguage[]" value="English" class="form-check-input">
                                                <label class="form-label">English</label>
                                                <input type="checkbox" name="fatherLanguage[]" value="Gujarati" class="form-check-input">
                                                <label class="form-label">Gujarati</label>
                                                <input type="checkbox" name="fatherLanguage[]" value="Hindi" class="form-check-input">
                                                <label class="form-label">Hindi</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="fatherMobile">Father's Mobile Number</label>
                                            <input type="text" name="fatherMobile" class="form-control form-control-lg" pattern="\d{10}" maxlength="10" id="fatherMobile" required />
                                            <div class="invalid-feedback">Please fill phone number !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <h6 class="form-label mb-2 pb-1">Whether Father is using WhatsApp?</h6>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="fatherWhatsApp" id="fatherWhatsAppYes" value="yes" required />
                                            <label class="form-check-label" for="fatherWhatsAppYes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="fatherWhatsApp" id="fatherWhatsAppNo" value="no" required />
                                            <label class="form-check-label" for="fatherWhatsAppNo">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="fatherEmail">Father's Email</label>
                                            <input type="email" name="fatherEmail" class="form-control form-control-lg" id="fatherEmail" required />
                                            <div class="invalid-feedback">Please fill correct email !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="fatherOccupation">Father's Occupation</label>
                                            <input type="text" name="fatherOccupation" class="form-control form-control-lg" pattern="[A-Za-z]*" id="fatherOccupation" required />
                                            <div class="invalid-feedback">Please fill occupation !</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="fatherCompany">Father's Company Name</label>
                                            <input type="text" name="fatherCompany" class="form-control form-control-lg" id="fatherCompany" required />
                                            <div class="invalid-feedback">Please fill company name !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="fatherDesignation">Father's Designation</label>
                                            <input type="text" name="fatherDesignation" class="form-control form-control-lg" pattern="[A-Za-z]*" id="fatherDesignation" required />
                                            <div class="invalid-feedback">Please fill designation !</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="fatherAnnualIncome">Father's Annual Income</label>
                                            <input type="number" name="fatherAnnualIncome" class="form-control form-control-lg" id="fatherAnnualIncome" required />
                                            <div class="invalid-feedback">Please fill annual income !</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <br>
                                        <h4 style="letter-spacing: 0.2em;" class="lh-lg"> <span class="span-lines">-----</span> FATHER'S DETAILS <span class="span-lines">-----</span> </h4><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="motherName">Mother's Name</label>
                                            <input type="text" name="motherName" class="form-control form-control-lg" pattern="[A-Za-z]*" id="motherName" required />
                                            <div class="invalid-feedback">Please fill name !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4 pb-5">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="langMother">Language Known By Mother</label><br>
                                            <span style='font-size:1.3rem;font-weight:bold' id="langMotherDisplay"></span>
                                            <br>
                                            <input type="checkbox" name="motherLanguage[]" value="English" class="form-check-input">
                                            <label class="form-label">English</label>
                                            <input type="checkbox" name="motherLanguage[]" value="Gujarati" class="form-check-input">
                                            <label class="form-label">Gujarati</label>
                                            <input type="checkbox" name="motherLanguage[]" value="Hindi" class="form-check-input">
                                            <label class="form-label">Hindi</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="motherMobile">Mother's Mobile Number</label>
                                            <input type="text" name="motherMobile" class="form-control form-control-lg" pattern="\d{10}" maxlength="10" id="motherMobile" required />
                                            <div class="invalid-feedback">Please fill phone number !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <h6 class="form-label mb-2 pb-1">Whether Mother is using WhatsApp?</h6>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="motherWhatsApp" id="motherWhatsAppYes" value="yes" required />
                                            <label class="form-check-label" for="motherWhatsAppYes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="motherWhatsApp" id="motherWhatsAppNo" value="no" required />
                                            <label class="form-check-label" for="motherWhatsAppNo">No</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="motherEmail">Mother's Email</label>
                                            <input type="email" name="motherEmail" class="form-control form-control-lg" id="motherEmail" required />
                                            <div class="invalid-feedback">Please fill correct email !</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="motherOccupation">Mother's Occupation</label>
                                            <input type="text" name="motherOccupation" class="form-control form-control-lg" pattern="[A-Za-z]*" id="motherOccupation" required />
                                            <div class="invalid-feedback">Please fill occupation !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="motherCompany">Mother's Company Name</label>
                                            <input type="text" name="motherCompany" class="form-control form-control-lg" id="motherCompany" required />
                                            <div class="invalid-feedback">Please fill company name !</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="motherDesignation">Mother's Designation</label>
                                            <input type="text" name="motherDesignation" class="form-control form-control-lg" pattern="[A-Za-z]*" id="motherDesignation" required />
                                            <div class="invalid-feedback">Please fill designation !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="motherAnnualIncome">Mother's Annual Income</label>
                                            <input type="number" name="motherAnnualIncome" class="form-control form-control-lg" id="motherAnnualIncome" required />
                                            <div class="invalid-feedback">Please fill annual income !</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Emergency Contact Details -->
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <br>
                                        <h4 style="letter-spacing: 0.2em;" class="lh-lg"> <span class="span-lines">-----</span> EMERGENCY CONTACT DETAILS <span class="span-lines">-----</span> </h4><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="emergencyContactName">Emergency Contact Name</label>
                                            <input type="text" name="emergencyContactName" class="form-control form-control-lg" pattern="[A-Za-z]*" id="emergencyContactName" required />
                                            <div class="invalid-feedback">Please fill name !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="emergencyContactRelation">Relation with Emergency Contact</label>
                                            <input type="text" name="emergencyContactRelation" class="form-control form-control-lg" pattern="[A-Za-z]*" id="emergencyContactRelation" required />
                                            <div class="invalid-feedback">Please fill relation !</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="emergencyContactPhone">Emergency Contact Phone Number</label>
                                            <input type="text" name="emergencyContactPhone" class="form-control form-control-lg" pattern="\d{10}" maxlength="10" id="emergencyContactPhone" required />
                                            <div class="invalid-feedback">Please fill phone number !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="emergencyContactAddress">Emergency Contact Person Address</label>
                                            <input type="text" name="emergencyContactAddress" class="form-control form-control-lg" id="emergencyContactAddress" required />
                                            <div class="invalid-feedback">Please fill address !</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="emergencyContactCity">Emergency Contact Person City</label>
                                            <input type="text" name="emergencyContactCity" class="form-control form-control-lg" id="emergencyContactCity" required />
                                            <div class="invalid-feedback">Please fill City !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="emergencyContactPin">Emergency Contact Person Pincode</label>
                                            <input type="text" name="emergencyContactPin" class="form-control form-control-lg" id="emergencyContactPin" required />
                                            <div class="invalid-feedback">Please fill Pincode !</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-4 text-center">
                                        <button type="submit" name="parent_submit" class="btn btn-primary btn-lg" id="updateBtn">Update</button>
                                    </div>
                                </div>
                            </form>

                            <!-- FORM END -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalBackdrop" class="modal-backdrop d-none"></div>

    <script>
        function editRecord(button) {
            document.getElementById('displayTable').classList.add('blur-background');
            document.getElementById('editForm').classList.remove('d-none');

            const row = button.closest('tr');

            document.getElementById('id').value = row.cells[1].innerText;
            document.getElementById('enroll_no').value = row.cells[2].innerText;
            document.getElementById('fatherName').value = row.cells[5].innerText;
            const fatherLanguages = row.cells[6].innerText.split(', ');
            document.querySelectorAll('input[name="fatherLanguage[]"]').forEach(checkbox => {
                checkbox.checked = fatherLanguages.includes(checkbox.value);
            });
            document.getElementById('fatherMobile').value = row.cells[7].innerText;
            document.querySelector(`input[name="fatherWhatsApp"][value="${row.cells[8].innerText.toLowerCase()}"]`).checked = true;
            document.getElementById('fatherEmail').value = row.cells[9].innerText;
            document.getElementById('fatherOccupation').value = row.cells[10].innerText;
            document.getElementById('fatherCompany').value = row.cells[11].innerText;
            document.getElementById('fatherDesignation').value = row.cells[12].innerText;
            document.getElementById('fatherAnnualIncome').value = row.cells[13].innerText;

            // Mother's Details
            document.getElementById('motherName').value = row.cells[14].innerText;
            const motherLanguages = row.cells[15].innerText.split(', ');
            document.querySelectorAll('input[name="motherLanguage[]"]').forEach(checkbox => {
                checkbox.checked = motherLanguages.includes(checkbox.value);
            });
            document.getElementById('motherMobile').value = row.cells[16].innerText;
            document.querySelector(`input[name="motherWhatsApp"][value="${row.cells[17].innerText.toLowerCase()}"]`).checked = true;
            document.getElementById('motherEmail').value = row.cells[18].innerText;
            document.getElementById('motherOccupation').value = row.cells[19].innerText;
            document.getElementById('motherCompany').value = row.cells[20].innerText;
            document.getElementById('motherDesignation').value = row.cells[21].innerText;
            document.getElementById('motherAnnualIncome').value = row.cells[22].innerText;

            // Emergency Contact Details
            document.getElementById('emergencyContactName').value = row.cells[24].innerText;
            document.getElementById('emergencyContactRelation').value = row.cells[25].innerText;
            document.getElementById('emergencyContactPhone').value = row.cells[23].innerText;
            document.getElementById('emergencyContactAddress').value = row.cells[26].innerText;
            document.getElementById('emergencyContactCity').value = row.cells[27].innerText;
            document.getElementById('emergencyContactPin').value = row.cells[28].innerText;

        }

        function closeForm(formId) {
            document.getElementById('displayTable').classList.remove('blur-background');
            document.getElementById(formId).classList.add('d-none');
            document.getElementById('modalBackdrop').classList.add('d-none');
        }

        document.addEventListener('DOMContentLoaded', function() {
            var forms = document.querySelectorAll('.parents-details-form');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });

        function searchTable(tableBody, searchtxt) {
            const searchInput = document.getElementById(searchtxt).value.toLowerCase();
            const rows = document.getElementById(tableBody).getElementsByTagName('tr');
            for (const row of rows) {
                row.style.display = 'none';
                const cells = row.getElementsByTagName('td');
                for (const cell of cells) {
                    if (cell.innerText.toLowerCase().includes(searchInput)) {
                        row.style.display = '';
                        break;
                    }
                }
            }
        }
    </script>
    <script src="../../assets/js/main.js"></script>
</body>

</html>