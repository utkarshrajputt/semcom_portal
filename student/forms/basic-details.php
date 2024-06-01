<div class="container-fluid pt-3">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7 w-100">
            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">
                    <!-- FORM START -->
                    <form class="basic-details-form" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- Birth Date -->
                                <div class="form-outline">
                                    <label class="form-label" for="birthDate">Birth Date</label>
                                    <input type="date" id="birthDate" class="form-control form-control-lg" required />
                                </div>
                            </div>
                        </div>

                        <!-- Height, Weight, Hobbies -->
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="height">Height (cm)</label>
                                    <input type="text" id="height" class="form-control form-control-lg" maxlength="7" pattern="[0-9.]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\./g, '$1');" required />
                                    <div class="invalid-feedback">Please fill height !</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="weight">Weight (kg)</label>
                                    <input type="text" id="weight" class="form-control form-control-lg" maxlength="7" pattern="[0-9.]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\./g, '$1');" required />
                                    <div class="invalid-feedback">Please fill weight !</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="hobbies">Hobbies</label>
                                    <input type="text" id="hobbies" class="form-control form-control-lg" required />
                                    <div class="invalid-feedback">Please fill hobbies with comma ( , ) !</div>
                                </div>
                            </div>
                        </div>

                        <!-- Category, Religion, Caste -->
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="category">Category</label>
                                    <select id="category" class="form-control form-control-lg" required>
                                        <option value="" disabled selected hidden>-- Select Category --</option>
                                        <option value="general">General</option>
                                        <option value="sc">SC</option>
                                        <option value="st">ST</option>
                                        <option value="obc">OBC</option>
                                    </select>
                                    <div class="invalid-feedback">Please select category !</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="religion">Religion</label>
                                    <select id="religion" class="form-control form-control-lg" required>
                                        <option value="" disabled selected hidden>-- Select Category --</option>
                                        <option value="Hinduism">Hindu</option>
                                        <option value="Christianity">Christianity</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Jainism">Jainism</option>
                                        <option value="Juche">Juche</option>
                                        <option value="Judaism">Judaism</option>
                                        <option value="Neo-Paganism">Neo-Paganism</option>
                                        <option value="Nonreligious">Nonreligious</option>
                                        <option value="Rastafarianism">Rastafarianism</option>
                                        <option value="Secular">Secular</option>
                                        <option value="Shinto">Shinto</option>
                                        <option value="Sikhism">Sikhism</option>
                                        <option value="Spiritism">Spiritism</option>
                                        <option value="Tenrikyo">Tenrikyo</option>
                                        <option value="Unitarian-Universalism">Unitarian-Universalism</option>
                                        <option value="Zoroastrianism">Zoroastrianism</option>
                                        <option value="primal-indigenous">primal-indigenous</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <div class="invalid-feedback">Please select religion !</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="caste">Caste</label>
                                    <input type="text" id="caste" class="form-control form-control-lg" required />
                                    <div class="invalid-feedback">Please fill caste !</div>
                                </div>
                            </div>
                        </div>

                        <!-- Language You Know -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6>Language You Know</h6><br>
                                <div class="col mb-4 d-flex gap-5">
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="lastName" >English</label><br>
                                        <input type="checkbox" id="paddp" name="padd" value="add" class="form-check-input">
                                        <label class="form-label" style="" for="emailAddress" >Read</label><br>
                                        <input type="checkbox" id="paddp" name="padd" value="add" class="form-check-input">
                                        <label class="form-label" for="emailAddress">Write</label><br>
                                        <input type="checkbox" id="paddp" name="padd" value="add" class="form-check-input">
                                        <label class="form-label" for="emailAddress">Speak</label>
                                    </div>
                                    
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="lastName" >Gujarati</label><br>
                                        <input type="checkbox" id="paddp" name="padd" value="add" class="form-check-input">
                                        <label class="form-label" for="emailAddress" >Read</label><br>
                                        <input type="checkbox" id="paddp" name="padd" value="add" class="form-check-input">
                                        <label class="form-label" for="emailAddress">Write</label><br>
                                        <input type="checkbox" id="paddp" name="padd" value="add" class="form-check-input">
                                        <label class="form-label" for="emailAddress">Speak</label>
                                    </div>
                                    
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="lastName" >Hindi</label><br>
                                        <input type="checkbox" id="paddp" name="padd" value="add" class="form-check-input">
                                        <label class="form-label" for="emailAddress" >Read</label><br>
                                        <input type="checkbox" id="paddp" name="padd" value="add" class="form-check-input">
                                        <label class="form-label" for="emailAddress">Write</label><br>
                                        <input type="checkbox" id="paddp" name="padd" value="add" class="form-check-input">
                                        <label class="form-label" for="emailAddress">Speak</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Other Languages -->
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="otherLanguage">Other Language</label>
                                    <input type="text" id="otherLanguage" class="form-control form-control-lg" required />
                                    <div class="invalid-feedback">Write NA if not !</div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mt-4 pt-1">
                            <div class="col">
                                <input class="btn btn-primary btn-lg" name="submit" type="submit" value="Save & Next" />
                            </div>
                        </div>

                    </form>
                    <!-- FORM END -->
                </div>
            </div>
        </div>
    </div>
</div>
