<div class="container-fluid pt-3">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7 w-100">
            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">
                    <!-- FORM START -->
                    <form class="personal-details-form" novalidate>
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <!-- ADMISSION STATUS -->
                                <h6 class="mb-2 pb-1">Admission Status:</h6>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="radio-stacked" id="regular" required />
                                        <label class="form-check-label" for="regular">Regular</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="radio-stacked" id="prov_admission" required />
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
                                    <input type="Date" id="ad_date" class="form-control form-control-lg" required />
                                    <div class="invalid-feedback">Please select the date !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <!-- SPID -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="spid">SPID</label>
                                    <input type="text" id="spid" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please fill SPID !</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- CVM ENROLLMENT ID -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="enrol_id">CVM Enrollment ID</label>
                                    <input type="text" id="enrol_id" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please fill Enrollment ID !</div>

                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <!-- ROLL NUMBER -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="roll">Roll Number</label>
                                    <input type="text" id="roll" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please fill roll number !</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- FIRST NAME -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="firstName">First Name</label>
                                    <input type="text" id="firstName" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                    <div class="invalid-feedback">Please fill first name !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <!-- LAST NAME -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="lastName">Last Name</label>
                                    <input type="text" id="lastName" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                    <div class="invalid-feedback">Please fill last name !</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- GENDER -->
                                <h6 class="mb-2 pb-1">Gender:</h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="femaleGender" value="femaleGender" required />
                                    <label class="form-check-label" for="femaleGender">Female</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="maleGender" value="maleGender" required />
                                    <label class="form-check-label" for="maleGender">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="otherGender" value="otherGender" required />
                                    <label class="form-check-label" for="otherGender">Other</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4 pb-2">
                                <!-- EMAIL -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="emailAddress">Email</label>
                                    <input type="email" id="emailAddress" class="form-control form-control-lg" required />
                                    <div class="invalid-feedback">Please fill email !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 pb-2">
                                <!-- PHONE NUMBER -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="phoneNumber">Phone Number</label>
                                    <input type="tel" id="phoneNumber" class="form-control form-control-lg" pattern="\d{10}" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please fill phone number !</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4 pb-2">
                                <!-- AADHAR CARD NUMBER -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="aadhar">Aadhar Number Number</label>
                                    <input type="text" id="aadhar" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please choose aadhar card !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 pb-2">
                                <!-- ABC ID -->
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="abc_id">ABC ID</label>
                                    <input type="text" id="abc_id" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                    <div class="invalid-feedback">Please fill ABC ID !</div>
                                </div>
                            </div>
                        </div>
                        <!-- SUBMIT & NEXT -->
                        <div class="mt-4 pt-2">
                            <input data-mdb-ripple-init class="btn btn-primary btn-lg" name="submit" type="submit" value="Save & Next" />
                        </div>
                    </form>
                    <!-- FORM END -->
                </div>
            </div>
        </div>
    </div>
</div>