<?php
try {
  $sql = "SELECT * FROM stud_academic_details WHERE enroll_no = '$enroll'";
  $stmt = mysqli_query($conn, $sql);

  if (mysqli_num_rows($stmt) == 0) {
    if (isset($_POST["academic_submit"])) {
      $ssc_board = $_POST["sscboard"];
      $ssc_skl = $_POST["sscSchoolName"];
      $sscmonthyear = $_POST["sscmonth_year"];
      $ssc_perc = $_POST["sscPercentage"];
      $ssc_medium = $_POST["sscMedium"];

      $hsc_board = $_POST["hscboard"];
      $hsc_skl = $_POST["hscSchoolName"];
      $hscmonthyear = $_POST["hscmonth_year"];
      $hsc_perc = $_POST["hscPercentage"];
      $hsc_medium = $_POST["hscMedium"];

      $ach = $_POST["achievements"];



      $insert = mysqli_query($conn, "insert into stud_academic_details (enroll_no, ssc_board, ssc_month_year, ssc_percentage, ssc_school, ssc_medium, hsc_board, hsc_month_year, hsc_percentage, hsc_school, hsc_medium, stud_achieve) values('$enroll','$ssc_board', '$sscmonthyear','$ssc_perc','$ssc_skl',  '$ssc_medium', '$hsc_board','$hscmonthyear', '$hsc_perc','$hsc_skl',  '$hsc_medium','$ach')");
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
          <form class="academic-details-form" novalidate method="post">
            <div class="row text-center">
              <div class="col-md-12">
                <br>
                <h4 style="letter-spacing: 0.2em;" class="lh-lg"> <span class="span-lines">-----</span> SSC DETAILS <span class="span-lines">-----</span> </h4><br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-4">
                <!-- SSC BOARD NAME -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="sscBoardName">SSC Board Name</label>
                  <select name="sscboard" class="form-control form-control-lg" required>
                    <option value="" disabled selected hidden>-- Select Board --</option>
                    <option value="CBSE">CBSE</option>
                    <option value="ICSE">ICSE</option>
                    <option value="IB">IB</option>
                    <option value="NIOS">NIOS</option>
                    <option value="AISSCE">AISSCE</option>
                    <option value="GSEB">GSEB</option>
                    <option value="Others">Others</option>
                  </select>
                  <div class="invalid-feedback">Please select Board!</div>
                  <!-- <input type="text" name="sscBoardName" class="form-control form-control-lg" pattern="^[A-Za-z][A-Za-z\s]*" oninput="this.value = this.value.replace(/^[^A-Za-z]+|[^A-Za-z\s]/g, '')" required />
                  <div class="invalid-feedback">Please fill board name !</div> -->
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <!-- SSC BOARD NAME -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="sscSchoolName">SSC School Name</label>
                  <input type="text" name="sscSchoolName" class="form-control form-control-lg" pattern="^[A-Za-z][A-Za-z\s]*" oninput="this.value = this.value.replace(/^[^A-Za-z]+|[^A-Za-z\s]/g, '')" required />
                  <div class="invalid-feedback">Please fill school name !</div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-4 pb-2">
                <!-- SSC PASS MONTH -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="sscPassingMonth">SSC Passing Month & Year</label>
                  <input type="month" name="sscmonth_year" class="form-control form-control-lg" required />

                  <div class="invalid-feedback">Please select Month and Year !</div>
                </div>
              </div>


              <div class="col-md-6 mb-4">
                <!-- SSC PERCENTAGE -->
                <div class="input-group d-block">
                  <label for="" class="lh-lg">SSC Percentage</label>
                  <div data-mdb-input-init class="input-group-prepend d-flex">
                    <span class="input-group-text">%</span>
                    <input type="text" name="sscPercentage" class="form-control form-control-lg">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-4">
                <!-- SSC MEDIUM -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="sscMedium">SSC Medium of Study</label>
                  <input type="text" name="sscMedium" class="form-control form-control-lg" pattern="^[A-Za-z][A-Za-z\s]*" oninput="this.value = this.value.replace(/^[^A-Za-z]+|[^A-Za-z\s]/g, '')" required />
                  <div class="invalid-feedback">Please fill medium of study !</div>
                </div>
              </div>
            </div>

            <div class="row text-center">
              <div class="col-md-12">
                <br>
                <h4 style="letter-spacing: 0.2em;" class="lh-lg"> <span class="span-lines">-----</span> HSC DETAILS <span class="span-lines">-----</span> </h4><br>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-4">
                <!-- HSC BOARD NAME -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="hscBoardName">HSC Board Name</label>
                  <select name="hscboard" class="form-control form-control-lg" required>
                    <option value="" disabled selected hidden>-- Select Board --</option>
                    <option value="CBSE">CBSE</option>
                    <option value="ICSE">ICSE</option>
                    <option value="IB">IB</option>
                    <option value="NIOS">NIOS</option>
                    <option value="AISSCE">AISSCE</option>
                    <option value="GSEB">GSEB</option>
                    <option value="Others">Others</option>
                  </select>
                  <div class="invalid-feedback">Please select Board!</div>

                </div>
              </div>
              <div class="col-md-6 mb-4">
                <!-- HSC SCHOOL -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="hscSchoolName">HSC School Name</label>
                  <input type="text" name="hscSchoolName" class="form-control form-control-lg" pattern="^[A-Za-z][A-Za-z\s]*" oninput="this.value = this.value.replace(/^[^A-Za-z]+|[^A-Za-z\s]/g, '')" required />
                  <div class="invalid-feedback">Please fill name !</div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-4 pb-2">
                <!-- SSC PASS MONTH -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="sscPassingMonth">HSC Passing Month & Year</label>
                  <input type="month" name="hscmonth_year" class="form-control form-control-lg" required />

                  <div class="invalid-feedback">Please select Month and Year !</div>
                </div>
              </div>

              <div class="col-md-6 mb-4">
                <!-- HSC PERC -->
                <div class="input-group d-block">
                  <label class="lh-lg" for="">HSC Percentage</label>
                  <div data-mdb-input-init class="form-outline input-group-prepend d-flex">
                    <span class="input-group-text">%</span>
                    <input type="text" name="hscPercentage" class="form-control form-control-lg" />
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-4">
                <!-- HSC MEDIUM -->
                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="hscMedium">HSC Medium of Study</label>
                  <input type="text" name="hscMedium" class="form-control form-control-lg" pattern="^[A-Za-z][A-Za-z\s]*" oninput="this.value = this.value.replace(/^[^A-Za-z]+|[^A-Za-z\s]/g, '')" required />
                  <div class="invalid-feedback">Please fill medium !</div>
                </div>
              </div>
            </div>


            <div class="row text-center">
              <div class="col-md-12">
                <br>
                <h4 style="letter-spacing: 0.2em;" class="lh-lg"> <span class="span-lines">-----</span> Achievements <span class="span-lines">-----</span> </h4><br>
              </div>
            </div>


            <div class="row">
              <div class="col-md-12 mb-4">

                <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="hscMedium">Your Achievements</label>
                  <input type="text" name="achievements" class="form-control form-control-lg" pattern="^[A-Za-z][A-Za-z\s]*" oninput="this.value = this.value.replace(/^[^A-Za-z]+|[^A-Za-z\s]/g, '')" required />
                  <div class="invalid-feedback">Please fill Achievements !</div>
                </div>
              </div>
            </div>

            <!-- SUBMIT  -->
            <div class="mt-4 pt-2">
              <input class="btn btn-primary btn-lg" name="academic_submit" type="submit" value="Save & Next">
            </div>
          </form>
          <!-- FORM END -->
        </div>
      </div>
    </div>
  </div>
</div>