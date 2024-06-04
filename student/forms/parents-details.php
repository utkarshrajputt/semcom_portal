<?php

try {
    $sql = "SELECT * FROM stud_parents_details WHERE enroll_no = '$enroll'";
    $stmt = mysqli_query($conn, $sql);

    if (mysqli_num_rows($stmt) == 0) {
        if (isset($_POST["parents_submit"])) {
            // father
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
            $fa_inc = $_POST["fatherIncome"];

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
            $ma_inc = $_POST["motherIncome"];

            // Emerrgency

            $em_mob = $_POST["emergencyMobile"];
            $em_name = $_POST["emergencyPersonName"];
            $em_relation = $_POST["relationshipWithStudent"];
            $em_add = $_POST["personAddress"];
            $em_city = $_POST["personCity"];
            $em_pin = $_POST["personPincode"];


            $insert = mysqli_query($conn, "insert into stud_parents_details(enroll_no, fathers_name, lang_father, fathers_mob, father_wp, fathers_email, fathers_occup, fathers_co, fathers_desig, fathers_annual_income, mothers_name, lang_mother, mothers_mob, mother_wp, mothers_email, mothers_occup, mothers_co, mothers_desig, mothers_annual_income, emergency_mob, emergency_name, emergency_relationship, emergency_add, emergency_city, emergency_pincode) values('$enroll','$fa_name', '$fa_lang', '$fa_mob','$fa_wp', '$fa_email', '$fa_occu', '$fa_co', '$fa_desig','$fa_inc','$ma_name', '$ma_lang', '$ma_mob','$ma_wp', '$ma_email', '$ma_occu', '$ma_co', '$ma_desig','$ma_inc','$em_mob','$em_name','$em_relation','$em_add','$em_city','$em_pin')");
            echo "<script>alert('Data Saved Successfully Go to next module!!');</script>";
            echo "<script>location.reload(true);</script>";
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
                    <form class="parents-details-form" novalidate method="post">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <br>
                                <h4 style="letter-spacing: 0.2em;" class="lh-lg"> <span class="span-lines">-----</span> FATHER'S DETAILS <span class="span-lines">-----</span> </h4><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- Father's name -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="fatherName">Father's Name</label>
                                    <input type="text" name="fatherName" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                    <div class="invalid-feedback">Please fill name !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 pb-5">
                                <!-- language ( f ) -->

                                <div data-mdb-input-init class="form-outline">
                                    <div class="form-group">
                                        <label class="form-label">Language Known By Father</label><br>
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
                                <!-- father mobile no -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="fatherMobile">Father's Mobile Number</label>
                                    <input type="text" name="fatherMobile" class="form-control form-control-lg" pattern="\d{10}" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please fill phone number !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <!-- father whats app no ? -->
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
                                <!-- Father email -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="fatherEmail">Father's Email</label>
                                    <input type="email" name="fatherEmail" class="form-control form-control-lg" required />
                                    <div class="invalid-feedback">Please fill correct email !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <!-- Father occupation -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="fatherOccupation">Father's Occupation</label>
                                    <input type="text" name="fatherOccupation" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                    <div class="invalid-feedback">Please fill occupation !</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- Father company -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="fatherCompany">Father's Company Name</label>
                                    <input type="text" name="fatherCompany" class="form-control form-control-lg" oninput="this.value = this.value.replace(/^\s+/g, '');" required />
                                    <div class="invalid-feedback">Please fill company name !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <!-- Father desig -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="fatherDesignation">Father's Designation</label>
                                    <input type="text" name="fatherDesignation" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                    <div class="invalid-feedback">Please fill designation !</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4 pb-2">
                                <!-- Father income -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="fatherIncome">Father's Annual Income</label>
                                    <input type="text" name="fatherIncome" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please fill income !</div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-12">
                                <br>
                                <h4 style="letter-spacing: 0.2em;" class="lh-lg"> <span class="span-lines">-----</span> MOTHER'S DETAILS <span class="span-lines">-----</span> </h4><br>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- Mother name -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="motherName">Mother's Name</label>
                                    <input type="text" name="motherName" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                    <div class="invalid-feedback">Please fill name !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 pb-5">
                                <!-- Motther language -->
                                <div data-mdb-input-init class="form-outline gap-3">
                                    <label class="form-label">Language Known By Mother</label><br>
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
                                <!-- Mother number -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="motherMobile">Mother's Mobile Number</label>
                                    <input type="text" name="motherMobile" class="form-control form-control-lg" pattern="\d{10}" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <!-- Mother whats app ? -->
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
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- Mother email -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="motherEmail">Mother's Email</label>
                                    <input type="email" name="motherEmail" class="form-control form-control-lg" required />
                                    <div class="invalid-feedback">Please fill email !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <!-- Mother occupation -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="motherOccupation">Mother's Occupation</label>
                                    <input type="text" name="motherOccupation" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                    <div class="invalid-feedback">Please fill mother occupation !</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- Mother company -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="motherCompany">Mother's Company Name</label>
                                    <input type="text" name="motherCompany" class="form-control form-control-lg" oninput="this.value = this.value.replace(/^\s+/g, '');" required />
                                    <div class="invalid-feedback">Please fill mother company !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <!-- Mother desig -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="motherDesignation">Mother's Designation</label>
                                    <input type="text" name="motherDesignation" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                    <div class="invalid-feedback">Please fill desgnation !</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4 pb-2">
                                <!-- Mother income -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="motherIncome">Mother's Annual Income</label>
                                    <input type="text" name="motherIncome" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please fill income !</div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-12">
                                <br>
                                <h4 style="letter-spacing: 0.2em;" class="lh-lg"> <span class="span-lines">-----</span> EMERGENCY'S DETAILS <span class="span-lines">-----</span> </h4><br>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- Emergency number -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="emergencyMobile">Emergency Mobile Number</label>
                                    <input type="text" name="emergencyMobile" class="form-control form-control-lg" pattern="\d{10}" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please fill number !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <!-- Emergency person -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="emergencyPersonName">Person's Name (other than Father & Mother)</label>
                                    <input type="text" name="emergencyPersonName" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                    <div class="invalid-feedback">Please fill name !</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- Relation -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="relationshipWithStudent">Relationship with Student</label>
                                    <input type="text" name="relationshipWithStudent" class="form-control form-control-lg" oninput="this.value = this.value.replace(/^\s+/g, '');" required />
                                    <div class="invalid-feedback">Please fill relation !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <!-- Emergency address -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="personAddress">Address of Person</label>
                                    <input type="text" name="personAddress" class="form-control form-control-lg" oninput="this.value = this.value.replace(/^\s+/g, '');" required />
                                    <div class="invalid-feedback">Please fill address !</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- Emergency person city -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="personCity">City of Person</label>
                                    <input type="text" name="personCity" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                    <div class="invalid-feedback">Please fill city !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <!-- Emergency pincode -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="personPincode">Pincode of Person</label>
                                    <input type="text" name="personPincode" class="form-control form-control-lg" pattern="\d{6}" maxlength="6" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please fill pincode !</div>
                                </div>
                            </div>
                        </div>

                        <!-- SUBMIT -->
                        <div class="mt-4 pt-2">
                            <input data-mdb-ripple-init class="btn btn-primary btn-lg" name="parents_submit" type="submit" value="Save" />
                        </div>
                    </form>
                    <!-- FORM END -->
                </div>
            </div>
        </div>
    </div>
</div>