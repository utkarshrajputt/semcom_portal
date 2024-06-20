<?php
require("config/mysqli_db.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Course Selection</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a79beb4099.js" crossorigin="anonymous"></script>

    <!-- BOXICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- MAIN STUDENT CSS -->
    <link rel="stylesheet" href="../assets/css/student.css">
    <style>
        /* Add any custom CSS here */
        .form-outline {
            margin-bottom: 1rem;
        }

        .form-check-inline {
            margin-right: 1rem;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('course').addEventListener('change', function() {
                var course = this.value;
                if (course) {
                    fetchOptions('semesters', {
                        course: course
                    });
                } else {
                    resetDropdown('semester');
                    resetDropdown('division');
                }
            });

            document.getElementById('semester').addEventListener('change', function() {
                var course = document.getElementById('course').value;
                var semester = this.value;
                if (semester) {
                    fetchOptions('divisions', {
                        course: course,
                        semester: semester
                    });
                } else {
                    resetDropdown('division');
                }
            });

            function fetchOptions(type, data) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '', true); // Change to your backend endpoint
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (this.status == 200) {
                        if (type == 'semesters') {
                            updateDropdown('semester', this.responseText);
                            resetDropdown('division');
                        } else if (type == 'divisions') {
                            updateDropdown('division', this.responseText);
                        }
                    }
                };
                var params = 'fetch=' + type + '&' + new URLSearchParams(data).toString();
                xhr.send(params);
            }

            function updateDropdown(dropdownId, optionsHtml) {
                var dropdown = document.getElementById(dropdownId);
                dropdown.innerHTML = optionsHtml;
                dropdown.disabled = false;
            }

            function resetDropdown(dropdownId) {
                var dropdown = document.getElementById(dropdownId);
                dropdown.innerHTML = '<option value="">--Select--</option>';
                dropdown.disabled = true;
            }
        });
    </script>
</head>

<body>
    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['fetch']) && $_POST['fetch'] == 'semesters') {
            $course = $_POST['course'];
            $result = $conn->query("SELECT DISTINCT class_semester FROM course_class WHERE course_name = '$course'");
            $options = '<option value="">--Select--</option>';
            while ($row = $result->fetch_assoc()) {
                $options .= '<option value="' . $row['class_semester'] . '">' . $row['class_semester'] . '</option>';
            }
            echo $options;
            exit();
        }

        if (isset($_POST['fetch']) && $_POST['fetch'] == 'divisions') {
            $course = $_POST['course'];
            $semester = $_POST['semester'];
            $result = $conn->query("SELECT DISTINCT class_div FROM course_class WHERE course_name = '$course' AND class_semester = '$semester'");
            $options = '<option value="">--Select--</option>';
            while ($row = $result->fetch_assoc()) {
                $options .= '<option value="' . $row['class_div'] . '">' . $row['class_div'] . '</option>';
            }
            echo $options;
            exit();
        }
    }
    ?>
    <div class="container-fluid pt-3">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-9 col-xl-7 w-100">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <!-- FORM START -->
                        <form class="personal-details-form" method="post" enctype="multipart/form-data" novalidate>
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <!-- ADMISSION STATUS -->
                                    <h6 class="mb-2 pb-1">Admission Status:</h6>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="adm_status" value="regular" required />
                                            <label class="form-check-label" for="regular">Regular</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="adm_status" value="prov_admission" required />
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
                                        <input type="date" name="ad_date" class="form-control form-control-lg" required />
                                        <div class="invalid-feedback">Please select the date!</div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <!-- SPID -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="spid">SPID</label>
                                        <input type="text" name="spid" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                        <div class="invalid-feedback">Please fill SPID!</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <!-- CVM ENROLLMENT ID -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="enrol_id">CVM Enrollment ID</label>
                                        <input type="text" name="enroll_id" readonly class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                        <div class="invalid-feedback">Please fill Enrollment ID!</div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <!-- ROLL NUMBER -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="roll">Roll Number</label>
                                        <input type="text" name="roll" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                        <div class="invalid-feedback">Please fill roll number!</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="course">Course</label>
                                        <select id="course">
                                        <option value="">--Select--</option>
                                        <?php
                                        $result = $conn->query("SELECT DISTINCT course_name FROM course_class");
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['course_name'] . '">' . $row['course_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="semester">Semester</label>
                                        <select id="semester" disabled>
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="division">Division</label>
                                        <select id="division" disabled>
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <!-- FIRST NAME -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="fname">First Name</label>
                                        <input type="text" name="fname" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                        <div class="invalid-feedback">Please fill first name!</div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <!-- MIDDLE NAME -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="mname">Middle Name</label>
                                        <input type="text" name="mname" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                        <div class="invalid-feedback">Please fill middle name!</div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <!-- LAST NAME -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="lname">Last Name</label>
                                        <input type="text" name="lname" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                        <div class="invalid-feedback">Please fill last name!</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <!-- GENDER -->
                                    <h6 class="mb-2 pb-1">Gender:</h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="male" required />
                                        <label class="form-check-label" for="maleGender">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="female" required />
                                        <label class="form-check-label" for="femaleGender">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="other" required />
                                        <label class="form-check-label" for="otherGender">Other</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4 pb-2">
                                    <!-- PHONE NUMBER -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="phoneNumber">Phone Number</label>
                                        <input type="text" name="phone" class="form-control form-control-lg" pattern="\d{10}" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                        <div class="invalid-feedback">Please fill phone number!</div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4 pb-2">
                                    <!-- EMAIL -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="emailAddress">Email</label>
                                        <input type="email" name="email" class="form-control form-control-lg" required />
                                        <div class="invalid-feedback">Please fill email!</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4 pb-2">
                                    <!-- AADHAR CARD NUMBER -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="aadhar">Aadhar Number</label>
                                        <input type="text" name="aadhar" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                        <div class="invalid-feedback">Please fill Aadhar card number!</div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4 pb-2">
                                    <!-- ABC ID -->
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="abc_id">ABC ID</label>
                                        <input type="text" name="abcid" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                        <div class="invalid-feedback">Please fill ABC ID!</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 pt-2">
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="filelbl">Upload Your Profile Picture</label>
                                    <input type="file" name="pfp" class="form-control" accept=".jpg, .jpeg" id="inputGroupFile02" required>
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
</body>

</html>