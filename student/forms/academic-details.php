<div class="container-fluid pt-3">
  <div class="row justify-content-center align-items-center h-100">
    <div class="col-12 col-lg-9 col-xl-7 w-100">
      <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
        <div class="card-body p-4 p-md-5">
            <!-- FORM START -->
          <form class="academic-details-form" novalidate>
            <div class="row text-center">
                <div class="col-md-12">
                    <br><h4 style="letter-spacing: 0.2em;" class="lh-lg"> <span>-----</span> SSC DETAILS <span>-----</span> </h4><br>
                </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-4">
                <!-- SSC BOARD NAME -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="sscBoardName">SSC Board Name</label>
                  <input type="text" id="sscBoardName" class="form-control form-control-lg" pattern="^[A-Za-z][A-Za-z\s]*" oninput="this.value = this.value.replace(/^[^A-Za-z]+|[^A-Za-z\s]/g, '')" required />
                  <div class="invalid-feedback">Please fill name !</div>
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <!-- SSC BOARD NAME -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="sscSchoolName">SSC School Name</label>
                  <input type="text" id="sscSchoolName" class="form-control form-control-lg" pattern="^[A-Za-z][A-Za-z\s]*" oninput="this.value = this.value.replace(/^[^A-Za-z]+|[^A-Za-z\s]/g, '')" required />
                  <div class="invalid-feedback">Please fill school name !</div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-4 pb-2">
                <!-- SSC PASS MONTH -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="sscPassingMonth">SSC Passing Month</label>
                  <select id="sscPassingMonth" class="form-control form-control-lg" required>
                    <option value="" disabled  selected>-- Select Month --</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                  </select>
                  <div class="invalid-feedback">Please select month !</div>
                </div>
              </div>
              <div class="col-md-6 mb-4 pb-2">
                <!-- SSC PASS YEAR -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="sscPassingYear">SSC Passing Year</label>
                  <select id="sscPassingYear" class="form-control form-control-lg" required>
                    <option value="" disabled selected  hidden>--Select Year--</option>
                    <!-- Add year options dynamically or manually as per requirement -->
                    <option value="2000">2000</option>
                    <option value="2001">2001</option>
                    <option value="2002">2002</option>
                    <option value="2003">2003</option>
                    <option value="2004">2004</option>
                    <option value="2005">2005</option>
                    <option value="2006">2006</option>
                    <option value="2007">2007</option>
                    <option value="2008">2008</option>
                    <option value="2009">2009</option>
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                  </select>
                  <div class="invalid-feedback">Please select year !</div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3 mb-4">
                <!-- SSC OBT MARKS -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="sscObtainedMarks">SSC Obtained Marks</label>
                  <input type="text" id="sscObtainedMarks" class="form-control form-control-lg" maxlength="3" pattern="^[0-9]*$" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
                  <div class="invalid-feedback">Please fill marks !</div>
                </div>
              </div>
              <div class="col-md-3 mb-4">
                <!-- SSC TOTAL MARKS -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="sscTotalMarks">SSC Total Marks</label>
                  <input type="text" id="sscTotalMarks" class="form-control form-control-lg" maxlength="3" pattern="^[0-9]*$" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
                  <div class="invalid-feedback">Please fill marks !</div>
                </div>
              </div>
              <div class="col-md-5 mb-4">
                <!-- SSC PERCENTAGE -->
                <div class="input-group d-block">
                    <label for="" class="lh-lg" style="">SSC Percentage</label>
                    <div data-mdb-input-init class="input-group-prepend d-flex">
                        <span class="input-group-text">%</span>
                        <input type="text" id="" class="form-control form-control-lg" disabled>
                    </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-4">
                <!-- SSC MEDIUM -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="sscMedium">SSC Medium of Study</label>
                  <input type="text" id="sscMedium" class="form-control form-control-lg" pattern="^[A-Za-z][A-Za-z\s]*" oninput="this.value = this.value.replace(/^[^A-Za-z]+|[^A-Za-z\s]/g, '')"  required />
                  <div class="invalid-feedback">Please fill medium of study !</div>
                </div>
              </div>
            </div>

            <div class="row text-center">
                <div class="col-md-12">
                    <br><h4 style="letter-spacing: 0.2em;" class="lh-lg"> <span>-----</span> HSC DETAILS <span>-----</span> </h4><br>
                </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-4">
                <!-- HSC BOARD NAME -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="hscBoardName">HSC Board Name</label>
                  <input type="text" id="hscBoardName" class="form-control form-control-lg" pattern="^[A-Za-z][A-Za-z\s]*" oninput="this.value = this.value.replace(/^[^A-Za-z]+|[^A-Za-z\s]/g, '')" required />
                  <div class="invalid-feedback">Please fill board name !</div>
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <!-- HSC SCHOOL -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="hscSchoolName">HSC School Name</label>
                  <input type="text" id="hscSchoolName" class="form-control form-control-lg" pattern="^[A-Za-z][A-Za-z\s]*" oninput="this.value = this.value.replace(/^[^A-Za-z]+|[^A-Za-z\s]/g, '')" required />
                  <div class="invalid-feedback">Please fill name !</div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-4 pb-2">
                <!-- HSC PASS MONTH -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="hscPassingMonth">HSC Passing Month</label>
                  <select id="hscPassingMonth" class="form-control form-control-lg" required>
                    <option value="" disabled selected hidden>--Select Month--</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                  </select>
                  <div class="invalid-feedback">Please selecct month !</div>
                </div>
              </div>
              <div class="col-md-6 mb-4 pb-2">
                <!-- HSC PASS YEAR -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="hscPassingYear">HSC Passing Year</label>
                  <select id="hscPassingYear" class="form-control form-control-lg" required>
                    <option value="" disabled selected hidden>--Select Year--</option>
                    <!-- Add year options dynamically or manually as per requirement -->
                    <option value="2000">2000</option>
                    <option value="2001">2001</option>
                    <option value="2002">2002</option>
                    <option value="2003">2003</option>
                    <option value="2004">2004</option>
                    <option value="2005">2005</option>
                    <option value="2006">2006</option>
                    <option value="2007">2007</option>
                    <option value="2008">2008</option>
                    <option value="2009">2009</option>
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                  </select>
                  <div class="invalid-feedback">Please select year !</div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3 mb-4">
                <!-- HSC OBT MARKS -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="hscObtainedMarks">HSC Obtained Marks</label>
                  <input type="text" id="hscObtainedMarks" class="form-control form-control-lg" maxlength="3" pattern="^[0-9]*$" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
                  <div class="invalid-feedback">Please fill marks !</div>
                </div>
              </div>
              <div class="col-md-3 mb-4">
                <!-- HSC TOT MARKS -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="hscTotalMarks">HSC Total Marks</label>
                  <input type="text" id="hscTotalMarks" class="form-control form-control-lg" maxlength="3" pattern="^[0-9]*$" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
                  <div class="invalid-feedback">Please fill total marks !</div>
                </div>
              </div>
              <div class="col-md-5 mb-4">
                <!-- HSC PERC -->
                <div class="input-group d-block">
                    <label class="lh-lg" for="">HSC Percentage</label>
                    <div data-mdb-input-init class="form-outline input-group-prepend d-flex">
                        <span class="input-group-text">%</span>
                        <input type="text" id="hscPercentage" class="form-control form-control-lg" disabled />
                    </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-4">
                <!-- HSC MEDIUM -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="hscMedium">HSC Medium of Study</label>
                  <input type="text" id="hscMedium" class="form-control form-control-lg" pattern="^[A-Za-z][A-Za-z\s]*" oninput="this.value = this.value.replace(/^[^A-Za-z]+|[^A-Za-z\s]/g, '')" required />
                  <div class="invalid-feedback">Please fill medium !</div>
                </div>
              </div>
            </div>

            <!-- SUBMIT  -->
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
