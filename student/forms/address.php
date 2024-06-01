<div class="container-fluid pt-3">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7 w-100">
            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">
                    <!-- FORM START -->
                    <form class="address-form" novalidate>
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <!-- LIVING STATUS -->
                                <h6 class="mb-2 pb-1">Living Status:</h6>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="radio-stacked" id="localite" required />
                                        <label class="form-check-label" for="localite">Localite</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="radio-stacked" id="hostalite" required />
                                        <label class="form-check-label" for="hostalite">Hostalite</label>
                                    </div>
                                    <div class="invalid-feedback">Please select any of them!</div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-12">
                                <br><h4 style="letter-spacing: 0.2em;" class="lh-lg"> <span class="span-lines">-----</span> PERMENANT ADDRESS <span class="span-lines">-----</span> </h4><br>
                            </div>
                        </div>

                        <!-- Permanent Address -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="add1">Address Line 1</label>
                                    <input type="text" id="add1" class="form-control form-control-lg" maxlength="60" oninput="this.value = this.value.replace(/^\s+/g, '');" required />
                                    <div class="invalid-feedback">Please fill address line !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="add2">Address Line 2</label>
                                    <input type="text" id="add2" class="form-control form-control-lg" maxlength="60" oninput="this.value = this.value.replace(/^\s+/g, '');" required />
                                    <div class="invalid-feedback">Please fill address line !</div>
                                </div>
                            </div>
                        </div>

                        <!-- Permanent City and Pincode -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="permanentCity">Permanent City</label>
                                    <input type="text" id="permanentCity" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                    <div class="invalid-feedback">Please fill city !</div>
                                </div>
                            </div>
                            <!-- pincode -->
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="permanentPincode">Permanent Pincode</label>
                                    <input type="text" id="permanentPincode" class="form-control form-control-lg" pattern="\d{7}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="7" required />
                                    <div class="invalid-feedback">Please fill pincode !</div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-12">
                                <br><h4 style="letter-spacing: 0.2em;" class="lh-lg"> <span class="span-lines">-----</span> PRESENT ADDRESS <span class="span-lines">-----</span> </h4><br>
                            </div>
                        </div>

                        <!-- Present Address -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="add1">Address Line 1</label>
                                    <input type="text" id="add1" class="form-control form-control-lg" maxlength="60" oninput="this.value = this.value.replace(/^\s+/g, '');" required />
                                    <div class="invalid-feedback">Please fill address line !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="add2">Address Line 2</label>
                                    <input type="text" id="add2" class="form-control form-control-lg" maxlength="60" oninput="this.value = this.value.replace(/^\s+/g, '');" required />
                                    <div class="invalid-feedback">Please fill address line !</div>
                                </div>
                            </div>
                        </div>

                        <!-- Present City and Pincode -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="presentCity">Present City</label>
                                    <input type="text" id="presentCity" class="form-control form-control-lg"  pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                    <div class="invalid-feedback">Please fill city !</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="presentPincode">Present Pincode</label>
                                    <input type="tel" id="presentPincode" class="form-control form-control-lg" pattern="\d{7}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="7" required />
                                    <div class="invalid-feedback">Please fill pincode !</div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4 pt-2">
                            <input class="btn btn-primary btn-lg" name="submit" type="submit" value="Save & Next">
                        </div>

                    </form>
                    <!-- FORM END -->
                </div>
            </div>
        </div>
    </div>
</div>
