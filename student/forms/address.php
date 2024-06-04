<?php
try {
    $sql = "SELECT * FROM stud_address WHERE enroll_no = '$enroll'";
    $stmt = mysqli_query($conn, $sql);

    if (mysqli_num_rows($stmt) == 0) {
        if (isset($_POST["add_submit"])) {
            $liv_status = $_POST["liv_status"];
            $perm_add1 = $_POST["perm_add1"];
            $perm_add2 = $_POST["perm_add2"];
            $perm_city = $_POST["permanentcity"];
            $perm_pin = $_POST["permanentpincode"];
            $pres_add1 = $_POST["pres_add1"];
            $pres_add2 = $_POST["pres_add2"];
            $pres_city = $_POST["presentcity"];
            $pres_pin = $_POST["presentpincode"];
            
            $insert = mysqli_query($conn, "insert into stud_address(enroll_no,resident_type, permanent_add, permanent_add2, permanent_city, permanent_pincode, present_add, present_add2, present_city, present_pincode) values('$enroll','$liv_status', '$perm_add1', '$perm_add2','$perm_city', '$perm_pin', '$pres_add1', '$pres_add2', '$pres_city', '$pres_pin')");
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
                    <form class="address-form <?php echo isset($address['add_id'])?'disable-form':''; ?>" novalidate method="post">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <!-- LIVING STATUS -->
                                <h6 class="mb-2 pb-1">Living Status:</h6>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="liv_status" value="localite" required <?php if(isset($address['resident_type'])){if($address['resident_type']=="localite"){echo "checked";}} ?> />
                                        <label class="form-check-label" for="localite">Localite</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="liv_status" value="hostalite" required <?php if(isset($address['resident_type'])){if($address['resident_type']=="hostalite"){echo "checked";}} ?> />
                                        <label class="form-check-label" for="hostalite">Hostalite</label>
                                    </div>
                                    <div class="invalid-feedback">Please select any of them!</div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-12">
                                <br>
                                <h4 style="letter-spacing: 0.2em;" class="lh-lg"> <span class="span-lines">-----</span> PERMENANT ADDRESS <span class="span-lines">-----</span> </h4><br>
                            </div>
                        </div>

                        <!-- Permanent Address -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="add1">Address Line 1</label>
                                    <input type="text" name="perm_add1" class="form-control form-control-lg" maxlength="60" oninput="this.value = this.value.replace(/^\s+/g, '');" value="<?php echo isset($address['permanent_add']) ? $address['permanent_add'] : ''; ?>" required />
                                    <div class="invalid-feedback">Please fill address line !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="add2">Address Line 2</label>
                                    <input type="text" name="perm_add2" class="form-control form-control-lg" maxlength="60" oninput="this.value = this.value.replace(/^\s+/g, '');" required value="<?php echo isset($address['permanent_add2']) ? $address['permanent_add2'] : ''; ?>" />
                                    <div class="invalid-feedback">Please fill address line !</div>
                                </div>
                            </div>
                        </div>

                        <!-- Permanent City and Pincode -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="permanentCity">Permanent City</label>
                                    <input type="text" name="permanentcity" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required value="<?php echo isset($address['permanent_city']) ? $address['permanent_city'] : ''; ?>" />
                                    <div class="invalid-feedback">Please fill city !</div>
                                </div>
                            </div>
                            <!-- pincode -->
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="permanentPincode">Permanent Pincode</label>
                                    <input type="text" name="permanentpincode" class="form-control form-control-lg" pattern="\d{6}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="6" required value="<?php echo isset($address['permanent_pincode']) ? $address['permanent_pincode'] : ''; ?>" />
                                    <div class="invalid-feedback">Please fill pincode !</div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-12">
                                <br>
                                <h4 style="letter-spacing: 0.2em;" class="lh-lg"> <span class="span-lines">-----</span> PRESENT ADDRESS <span class="span-lines">-----</span> </h4><br>
                            </div>
                        </div>

                        <!-- Present Address -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="add1">Address Line 1</label>
                                    <input type="text" name="pres_add1" class="form-control form-control-lg" maxlength="60" oninput="this.value = this.value.replace(/^\s+/g, '');" required value="<?php echo isset($address['present_add']) ? $address['present_add'] : ''; ?>" />
                                    <div class="invalid-feedback">Please fill address line !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="add2">Address Line 2</label>
                                    <input type="text" name="pres_add2" class="form-control form-control-lg" maxlength="60" oninput="this.value = this.value.replace(/^\s+/g, '');" required value="<?php echo isset($address['present_add2']) ? $address['present_add2'] : ''; ?>" />
                                    <div class="invalid-feedback">Please fill address line !</div>
                                </div>
                            </div>
                        </div>

                        <!-- Present City and Pincode -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="presentCity">Present City</label>
                                    <input type="text" name="presentcity" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required value="<?php echo isset($address['present_city']) ? $address['present_city'] : ''; ?>" />
                                    <div class="invalid-feedback">Please fill city !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="presentPincode">Present Pincode</label>
                                    <input type="tel" name="presentpincode" class="form-control form-control-lg" pattern="\d{6}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="6" required value="<?php echo isset($address['present_pincode']) ? $address['present_pincode'] : ''; ?>" />
                                    <div class="invalid-feedback">Please fill pincode !</div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4 pt-2">
                            <input data-mdb-ripple-init class="btn btn-primary btn-lg" name="add_submit" type="submit" value="Save" />
                        </div>
                    </form>
                    <!-- FORM END -->
                </div>
            </div>
        </div>
    </div>
</div>