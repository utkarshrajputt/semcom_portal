<?php
    try{

    $sql = "SELECT * FROM stud_other_details WHERE enroll_no = '$enroll'";
    $stmt = mysqli_query($conn, $sql);

    if (mysqli_num_rows($stmt) == 0) {
        if (isset($_POST["basic_submit"])) {
            $date = $_POST["birthdate"];
            $bld_grp = $_POST["bloodgroup"];
            $height = $_POST["height"];
            $weight = $_POST["weight"];
            $hobby = $_POST["hobbies"];
            $category = $_POST["category"];
            $religion = $_POST["religion"];
            $eng = "";
            if (!empty($_POST['eng'])) {
                foreach ($_POST['eng'] as $eng_check) {
                    $eng = $eng . "," . $eng_check;
                }
            }
            $eng = substr($eng, 1);

            $hindi = "";
            if (!empty($_POST['hindi'])) {
                foreach ($_POST['hindi'] as $hindi_check) {
                    $hindi = $hindi . "," . $hindi_check;
                }
            }
            $hindi = substr($hindi, 1);

            $guj = "";
            if (!empty($_POST['guj'])) {
                foreach ($_POST['guj'] as $guj_check) {
                    $guj = $guj . "," . $guj_check;
                }
            }
            $guj = substr($guj, 1);

            $other = $_POST["other"];


            $insert = mysqli_query($conn, "insert into stud_other_details(enroll_no,dob, blood_grp, stud_height, stud_weight, stud_hobbies, stud_category, stud_religion, eng_know, hindi_know, guj_know, other_know) values('$enroll','$date', '$bld_grp', '$height','$weight', '$hobby', '$category', '$religion', '$eng','$hindi','$guj','$other')");
            echo "<script>alert('Data Saved Successfully Go to next module!!');</script>";
            echo "<script>location.reload(true);</script>";
        }
    }
}
catch(Exception $e){
    echo "Failed Input! Please Refresh or Contact College!";
}
?>

<div class="container-fluid pt-3">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7 w-100">
            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">
                    <!-- FORM START -->
                    <form class="basic-details-form <?php echo isset($basic_dtl['other_id'])?'disable-form':''; ?>" novalidate method="post">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- Birth Date -->
                                <div class="form-outline">
                                    <label class="form-label" for="birthDate">Birth Date</label>
                                    <input type="date" name="birthdate" class="form-control form-control-lg" value="<?php echo isset($basic_dtl['dob']) ? $basic_dtl['dob'] : ''; ?>" required />
                                </div>

                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="category">Blood Group :</label>
                                    <br><span style='font-size:1.3rem;font-weight:bold'><?php echo isset($basic_dtl['blood_grp']) ? $basic_dtl['blood_grp'] : ''; ?></span>
                                    <?php
                                            if(!(isset($basic_dtl['blood_grp'])))
                                            {
                                            
                                        ?>
                                            <select name="bloodgroup" class="form-control form-control-lg" required>
                                                <option value="" disabled selected hidden>-- Select Blood Group --</option>
                                                <option value="O-">O-</option>
                                                <option value="O+">O+</option>
                                                <option value="A-">A-</option>
                                                <option value="A+">A+</option>
                                                <option value="B-">B-</option>
                                                <option value="B+">B+</option>
                                                <option value="AB-">AB-</option>
                                                <option value="AB+">AB+</option>
                                            </select>
                                            <div class="invalid-feedback">Please select blood group!</div>
                                        <?php
                                            }
                                        ?>
                                </div>
                            </div>
                        </div>

                        <!-- Height, Weight, Hobbies -->
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="height">Height (cm)</label>
                                    <input type="text" name="height" class="form-control form-control-lg" maxlength="7" pattern="[0-9.]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\./g, '$1');" required value="<?php echo isset($basic_dtl['stud_height']) ? $basic_dtl['stud_height'] : ''; ?>" />
                                    <div class="invalid-feedback">Please fill height !</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="weight">Weight (kg)</label>
                                    <input type="text" name="weight" class="form-control form-control-lg" maxlength="7" pattern="[0-9.]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\./g, '$1');" required value="<?php echo isset($basic_dtl['stud_weight']) ? $basic_dtl['stud_weight'] : ''; ?>"" />
                                    <div class="invalid-feedback">Please fill weight !</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="hobbies">Hobbies</label>
                                    <input type="text" name="hobbies" class="form-control form-control-lg" required value="<?php echo isset($basic_dtl['stud_hobbies']) ? $basic_dtl['stud_hobbies'] : ''; ?>" />
                                    <div class="invalid-feedback">Please fill hobbies with comma ( , ) !</div>
                                </div>
                            </div>
                        </div>

                        <!-- Category, Religion, Caste -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="category">Category  : </label>
                                    <br><span style='font-size:1.3rem;font-weight:bold'><?php echo isset($basic_dtl['stud_category']) ? $basic_dtl['stud_category'] : ''; ?></span>
                                    <?php
                                            if(!(isset($basic_dtl['blood_grp'])))
                                            {
                                            
                                    ?>
                                                <select name="category" class="form-control form-control-lg" required>
                                                    <option value="" disabled selected hidden>-- Select Category --</option>
                                                    <option value="general">General</option>
                                                    <option value="sc">SC</option>
                                                    <option value="st">ST</option>
                                                    <option value="obc">OBC</option>
                                                </select>
                                                <div class="invalid-feedback">Please select category !</div>
                                    <?php
                                            }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="religion">Religion  :</label><br>
                                    <span style='font-size:1.3rem;font-weight:bold'><?php echo isset($basic_dtl['stud_religion']) ? $basic_dtl['stud_religion'] : ''; ?></span>
                                    <?php
                                            if(!(isset($basic_dtl['stud_religion'])))
                                            {
                                            
                                        ?>
                                            <select name="religion" class="form-control form-control-lg" required>
                                                <option value="" disabled selected hidden>-- Select Category --</option>
                                                <option value="Hinduism">Hindu</option>
                                                <option value="Christianity">Christianity</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Jainism">Jainism</option>
                                                <option value="Secular">Secular</option>
                                                <option value="Sikhism">Sikhism</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <div class="invalid-feedback">Please select religion !</div>
                                    <?php
                                            }
                                        ?>
                                </div>
                            </div>
                            <!-- <div class="col-md-4 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="caste">Caste</label>
                                    <select name="caste" class="form-control form-control-lg" required>
                                        <option value="" disabled selected hidden>-- Select Category --</option>
                                        <option value="Brahmin">Brahmin</option>
                                        <option value="Kshatriya">Kshatriya</option>
                                        <option value="Vaishya">Vasihya</option>
                                        <option value="Jainism">Shudra</option>
                                        <option value="Secular">Secular</option>
                                        <option value="Sikhism">Sikhism</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <div class="invalid-feedback">Please fill caste !</div>
                                </div>
                            </div> -->
                        </div>

                        <!-- Language You Know -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6>Language You Know</h6><br>
                                <div class="col mb-4 d-flex gap-5">
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="lastName">English</label> : <span style='font-size:1.3rem;font-weight:bold'><?php echo isset($basic_dtl['eng_know']) ? $basic_dtl['eng_know'] : ''; ?></span>
                                        <?php
                                            if(!(isset($basic_dtl['eng_know'])))
                                            {
                                            
                                        ?>
                                                <br>
                                                <input type="checkbox" name="eng[]" value="Read" class="form-check-input">
                                                <label class="form-label" for="emailAddress">Read</label><br>
                                                <input type="checkbox" name="eng[]" value="Write" class="form-check-input">
                                                <label class="form-label" for="emailAddress">Write</label><br>
                                                <input type="checkbox" name="eng[]" value="Speak" class="form-check-input">
                                                <label class="form-label" for="emailAddress">Speak</label>
                                        <?php
                                            }
                                            ?>
                                    </div>

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="lastName">Hindi</label> : <span style='font-size:1.3rem;font-weight:bold'><?php echo isset($basic_dtl['hindi_know']) ? $basic_dtl['hindi_know'] : ''; ?></span>
                                        <?php
                                            if(!(isset($basic_dtl['hindi_know'])))
                                            {
                                            
                                        ?>
                                                <br>
                                                <input type="checkbox" name="hindi[]" value="Read" class="form-check-input">
                                                <label class="form-label" for="emailAddress">Read</label><br>
                                                <input type="checkbox" name="hindi[]" value="Write" class="form-check-input">
                                                <label class="form-label" for="emailAddress">Write</label><br>
                                                <input type="checkbox" name="hindi[]" value="Speak" class="form-check-input">
                                                <label class="form-label" for="emailAddress">Speak</label>
                                        <?php
                                            }
                                        ?>
                                    </div>

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="lastName">Gujarati</label> : <span style='font-size:1.3rem;font-weight:bold'><?php echo isset($basic_dtl['guj_know']) ? $basic_dtl['guj_know'] : ''; ?></span>
                                        <?php
                                            if(!(isset($basic_dtl['hindi_know'])))
                                            {
                                            
                                        ?>
                                                <br>
                                                <input type="checkbox" name="guj[]" value="Read" class="form-check-input">
                                                <label class="form-label" for="emailAddress">Read</label><br>
                                                <input type="checkbox" name="guj[]" value="Write" class="form-check-input">
                                                <label class="form-label" for="emailAddress">Write</label><br>
                                                <input type="checkbox" name="guj[]" value="Speak" class="form-check-input">
                                                <label class="form-label" for="emailAddress">Speak</label>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Other Languages -->
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="otherLanguage">Other Language</label>
                                    <input type="text" name="other" class="form-control form-control-lg" required value="<?php echo isset($basic_dtl['other_know']) ? $basic_dtl['other_know'] : ''; ?>" />
                                    <div class="invalid-feedback">Write NA if not !</div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mt-4 pt-1">
                            <div class="col">
                                <input class="btn btn-primary btn-lg" name="basic_submit" type="submit" value="Save" />
                            </div>
                        </div>

                    </form>
                    <!-- FORM END -->
                </div>
            </div>
        </div>
    </div>
</div>