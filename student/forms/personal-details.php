<?php
try {
    $sql = "SELECT * FROM stud_personal_details WHERE enroll_no = '$enroll'";
    $stmt = mysqli_query($conn, $sql);

    if (mysqli_num_rows($stmt) == 0) {
        if (isset($_POST["pers_submit"])) {
            $adm_status = $_POST["adm_status"];
            $adm_date = $_POST["ad_date"];
            $spid = $_POST["spid"];
            $course = $_POST["course"];
            $sem = $_POST["semester"];
            $div = $_POST["division"];
            $roll = $_POST["roll"];
            $f_name = $_POST["fname"];
            $m_name = $_POST["mname"];
            $l_name = $_POST["lname"];
            $gender = $_POST["gender"];
            $phone = $_POST["phone"];
            $email = $_POST["email"];
            $aadhar = $_POST["aadhar"];
            $abcid = $_POST["abcid"];


            if (isset($_FILES['pfp'])) {
                $uploads_dir = '../assets/images/uploaded_images/';
                $tmp_name = $_FILES["pfp"]["tmp_name"];
                $name = basename($_FILES["pfp"]["name"]);
                $file = $uploads_dir . $name;

                if ($file == '../assets/images/uploaded_images/') {
                    echo "<script>alert('Upload Image Again')</script>";
                } else {
                    $temp = explode(".", $_FILES["pfp"]["name"]);
                    $extension = end($temp);
                    $filename = $enroll . "." . $extension;
                    $move = move_uploaded_file($tmp_name, "$uploads_dir/$filename");

                    if ($move == true) {

                        $insert = mysqli_query($conn, "insert into stud_personal_details(adm_status, adm_date, spid, enroll_no,stud_course,stud_semester,stud_division, roll_no, f_name, m_name, l_name, gender, mob_no, email_id, aadhar_no, abc_id, pro_pic) values('$adm_status', '$adm_date', '$spid','$enroll','$course','$sem','$div', '$roll', '$f_name', '$m_name', '$l_name', '$gender', '$phone', '$email', '$aadhar', '$abcid', '$filename')");


                        echo "<script>alert('Data Saved Successfully Go to next module!!');</script>";
                        echo "<script>location.reload(true);</script>";
                    }
                }
            }
        }
    }
} catch (Exception $e) {
    echo "Failed Input! Please Refresh or Contact College!";
}
?>
<div class="container-fluid pt-3">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7 w-100">
            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">
                    <!-- FORM START -->
                    <form class="personal-details-form <?php echo isset($personalDetails['adm_status']) ? 'disable-form' : ''; ?>" method="post" enctype="multipart/form-data" novalidate>
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <!-- ADMISSION STATUS -->
                                <h6 class="mb-2 pb-1">Admission Status:</h6>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="adm_status" value="regular" required <?php if (isset($personalDetails['adm_status'])) {
                                                                                                                                    if ($personalDetails['adm_status'] == "regular") {
                                                                                                                                        echo "checked";
                                                                                                                                    }
                                                                                                                                } ?> />
                                        <label class="form-check-label" for="regular">Regular</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="adm_status" value="prov_admission" <?php if (isset($personalDetails['adm_status'])) {
                                                                                                                                    if ($personalDetails['adm_status'] == "prov_admission") {
                                                                                                                                        echo "checked";
                                                                                                                                    }
                                                                                                                                } ?> required />
                                        <label class="form-check-label" for="prov_admission">Provisional Admission</label>
                                    </div>
                                    <div class="invalid-feedback">Please select any of them!</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- ADMISSION DATE -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="ad_date">Admission Date</label>
                                    <input type="Date" name="ad_date" class="form-control form-control-lg" value="<?php echo isset($personalDetails['adm_date']) ? $personalDetails['adm_date'] : ''; ?>" required />
                                    <div class="    invalid-feedback">Please select the date !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <!-- SPID -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="spid">SPID</label>
                                    <input type="text" name="spid" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo isset($personalDetails['spid']) ? $personalDetails['spid'] : ''; ?>" required />
                                    <div class="invalid-feedback">Please fill SPID !</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- CVM ENROLLMENT ID -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="enrol_id">CVM Enrollment ID</label>
                                    <input type="text" name="enroll_id" value="<?php echo $enroll; ?>" readonly class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please fill Enrollment ID !</div>
                                </div>

                            </div>
                            
                            <div class="col-md-4 mb-4">
                                <!-- ROLL NUMBER -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="roll">Roll Number</label>
                                    <input type="text" name="roll" class="form-control form-control-lg" pattern="\d*" value="<?php echo isset($personalDetails['roll_no']) ? $personalDetails['roll_no'] : ''; ?>" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please fill roll number !</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-4 mb-4">
                                <!-- ROLL NUMBER -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="roll">Course</label>
                                    <br><span style='font-size:1.3rem;font-weight:bold'><?php echo isset($personalDetails['stud_course']) ? $personalDetails['stud_course'] : ''; ?></span>
                                    <?php
                                    if (!(isset($personalDetails['stud_course']))) {

                                    ?>
                                        <select name="course" class="form-control form-control-lg" required>
                                            <option value="" disabled selected hidden>-- Select Course --</option>
                                            <option value="BCA">BCA</option>
                                            <option value="BCOM">BCOM</option>
                                            <option value="BBA">BBA</option>
                                            <option value="BBA-ITM">BBA-ITM</option>
                                            <option value="MCOM">MCOM</option>
                                        </select>
                                        <div class="invalid-feedback">Please fill roll number !</div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <!-- ROLL NUMBER -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="roll">Semester</label>
                                    <br><span style='font-size:1.3rem;font-weight:bold'><?php echo isset($personalDetails['stud_semester']) ? $personalDetails['stud_semester'] : ''; ?></span>
                                    <?php
                                    if (!(isset($personalDetails['stud_semester']))) {

                                    ?>
                                        <select name="semester" class="form-control form-control-lg" required>
                                            <option value="" disabled selected hidden>-- Select Semester --</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                        </select>
                                        <div class="invalid-feedback">Please Select Semester !</div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <!-- ROLL NUMBER -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="roll">Division</label>
                                    <br><span style='font-size:1.3rem;font-weight:bold'><?php echo isset($personalDetails['stud_division']) ? $personalDetails['stud_division'] : ''; ?></span>
                                    <?php
                                    if (!(isset($personalDetails['stud_division']))) {

                                    ?>
                                        <select name="division" class="form-control form-control-lg" required>
                                            <option value="" disabled selected hidden>-- Select Division --</option>
                                            <option>-</option>
                                            <option>A</option>
                                            <option>B</option>
                                        </select>
                                        <div class="invalid-feedback">Please Select Division !</div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <!-- FIRST NAME -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="firstName">First Name</label>
                                    <input type="text" name="fname" class="form-control form-control-lg" pattern="[A-Za-z]*" value="<?php echo isset($personalDetails['f_name']) ? $personalDetails['f_name'] : ''; ?>" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                    <div class="invalid-feedback">Please fill first name !</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <!-- MIDDLE NAME -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="firstName">Middle Name</label>
                                    <input type="text" name="mname" class="form-control form-control-lg" pattern="[A-Za-z]*" value="<?php echo isset($personalDetails['m_name']) ? $personalDetails['m_name'] : ''; ?>" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                    <div class="invalid-feedback">Please fill first name !</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <!-- LAST NAME -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="lastName">Last Name</label>
                                    <input type="text" name="lname" class="form-control form-control-lg" pattern="[A-Za-z]*" value="<?php echo isset($personalDetails['l_name']) ? $personalDetails['l_name'] : ''; ?>" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                    <div class="invalid-feedback">Please fill last name !</div>
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
                                    <label class="form-label" for="emailAddress">Email</label>
                                    <input type="email" name="email" value="<?php echo isset($personalDetails['email_id']) ? $personalDetails['email_id'] : ''; ?>" class="form-control form-control-lg" required />
                                    <div class="invalid-feedback">Please fill email !</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4 pb-2">
                                <!-- AADHAR CARD NUMBER -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="aadhar">Aadhar Number Number</label>
                                    <input type="text" name="aadhar" value="<?php echo isset($personalDetails['aadhar_no']) ? $personalDetails['aadhar_no'] : ''; ?>" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please choose aadhar card !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 pb-2">
                                <!-- ABC ID -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="abc_id">ABC ID</label>
                                    <input type="text" name="abcid" class="form-control form-control-lg" value="<?php echo isset($personalDetails['abc_id']) ? $personalDetails['abc_id'] : ''; ?>" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please fill ABC ID !</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-2">
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
                    <!-- FORM END -->
                </div>
            </div>
        </div>
    </div>
</div>