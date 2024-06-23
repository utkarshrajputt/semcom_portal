<?php
require('../../includes/loader.php');
require('../../includes/session.php');
require('../../config/mysqli_db.php');
$staff_email = $_SESSION['staff_email'];

if (!isset($staff_email)) {
    header('location:staff_login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">
    <title>SEMCOM</title>

    <!-- BOOTSTRAP & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a79beb4099.js" crossorigin="anonymous"></script>

    <!-- BOXICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- MAIN STUDENT CSS -->
    <link rel="stylesheet" href="../../assets/css/student.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .blur-background {
            filter: blur(5px);
            opacity: 0.6;
        }

        .modal-form {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 80%;
            max-height: 90%;
            /* Set a maximum height for the modal */
            overflow-y: auto;
        }

        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
        }

        .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            font-size: 35px;
            border: none;
            background: transparent;
        }

        .form-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .modal-form::-webkit-scrollbar {
            width: 10px;
        }

        .modal-form::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .modal-form::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .modal-form::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>

<body id="body-pd">
    <?php require 'navbar.php'; ?>
    <?php
    if (isset($_POST['pers_edit'])) {
        $id=$_POST['id'];
        $adm_status = $_POST["adm_status"];
        $adm_date = $_POST["ad_date"];
        $spid = $_POST["spid"];
        $enroll= $_POST["enroll_no"];
        $course = $_POST["course"];
        $roll = $_POST["roll"];
        $fname = $_POST["fname"];
        $mname = $_POST["mname"];
        $lname = $_POST["lname"];
        $gender = $_POST["gender"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $aadhar = $_POST["aadhar"];
        $abcid = $_POST["abcid"];

        try {
            if (isset($_FILES['pfp']) && $_FILES['pfp']["name"] != '') {

                $data = mysqli_fetch_assoc(mysqli_query($conn, "select pro_pic from stud_personal_details where stud_id='$id'"));
                if (isset($data["pro_pic"])) {
                    $file_path = "../../assets/images/uploaded_images/" . $data["pro_pic"];
                    if (file_exists($file_path)) {
                        // Attempt to delete the file
                        if (unlink($file_path)) {
                            $uploads_dir = '../../assets/images/uploaded_images/';
                            $tmp_name = $_FILES["pfp"]["tmp_name"];
                            $name = basename($_FILES["pfp"]["name"]);
                            $file = $uploads_dir . $name;

                            if ($file == '../../assets/images/uploaded_images/') {
                                echo "<script>alert('Upload Image Again')</script>";
                            } else {
                                $temp = explode(".", $_FILES["pfp"]["name"]);
                                $extension = end($temp);
                                $filename = $enroll . "." . $extension;
                                $move = move_uploaded_file($tmp_name, "$uploads_dir/$filename");

                                if ($move == true) {
                                    $stmt = mysqli_query($conn, "UPDATE stud_personal_details SET adm_status='$adm_status',adm_date='$adm_date',spid='$spid',enroll_no='$enroll',stud_course='$course',roll_no='$roll',f_name='$fname',m_name='$mname',l_name='$lname',gender='$gender',mob_no='$phone',email_id='$email',aadhar_no='$aadhar',abc_id='$abcid',pro_pic='$filename' WHERE stud_id='$id'");
                                    echo "<script>alert('Data Updated Successfully!!');</script>";
                                }
                            }
                        }
                    }
                }
            } else {
                $stmt = mysqli_query($conn, "UPDATE stud_personal_details SET adm_status='$adm_status',adm_date='$adm_date',spid='$spid',enroll_no='$enroll',stud_course='$course',roll_no='$roll',f_name='$fname',m_name='$mname',l_name='$lname',gender='$gender',mob_no='$phone',email_id='$email',aadhar_no='$aadhar',abc_id='$abcid' WHERE stud_id='$id'");
                echo "<script>alert('Data Updated Successfully!!');</script>";
            }
        } catch (mysqli_sql_exception $e) {
            echo "" . $e->getMessage() . "";
        }
    }
    ?>
    <div id="searchBox" class="mt -2 mb-3 d-flex justify-content-end">
        <input type="text" class="form-control w-50 me-2" id="searchInput" placeholder="Search...">
        <button class="btn btn-info" onclick="searchTable('result_body','searchInput')">Search</button>
    </div>
    <div class="container mt-5">
        <h3 class="mb-4">Edit Student Personal Details</h3>
        <div id="displayTable" class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-light">
                    <tr>
                        <th></th>
                        <th>Student ID</th>
                        <th>Admission Status</th>
                        <th>Admission Date</th>
                        <th>SPID</th>
                        <th>Enrollment No</th>
                        <th>Course</th>
                        <th>Roll No</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Mobile NO</th>
                        <th>Email Id</th>
                        <th>Aadhar No</th>
                        <th>ABC ID</th>
                        <th>Profile Pic</th>
                    </tr>
                </thead>
                <tbody id="result_body">
                    <?php
                    $selectQuery = "select course,semester,division from staff_class_assign where staff_email='$staff_email'";
                    $selectResult = $conn->query($selectQuery);
                    if ($selectResult->num_rows > 0) {
                        $row = $selectResult->fetch_assoc();
                        $dataResult = mysqli_query($conn, "select class_enroll_start,class_enroll_end from course_class where course_name='" . $row['course'] . "' and class_semester='" . $row['semester'] . "' and class_div='" . $row['division'] . "'");
                        try {
                            $data = $dataResult->fetch_assoc();

                            $resultDataResult = mysqli_query($conn, "select * from stud_personal_details order by enroll_no");
                            if ($resultDataResult->num_rows > 0) {
                                while ($resultData = $resultDataResult->fetch_assoc()) {
                                    if ($resultData['enroll_no'] >= $data['class_enroll_start'] && $resultData['enroll_no'] <= $data['class_enroll_end']) {
                    ?>
                                        <td><button class="btn btn-warning btn-sm" onclick="editRecord(this)">Edit</button></td>
                                        <td><?php echo $resultData['stud_id']; ?></td>
                                        <td><?php echo $resultData['adm_status']; ?></td>
                                        <td><?php echo $resultData['adm_date']; ?></td>
                                        <td><?php echo $resultData['spid']; ?></td>
                                        <td><?php echo $resultData['enroll_no']; ?></td>
                                        <td><?php echo $resultData['stud_course']; ?></td>
                                        <td><?php echo $resultData['roll_no']; ?></td>
                                        <td><?php echo $resultData['f_name']; ?></td>
                                        <td><?php echo $resultData['m_name']; ?></td>
                                        <td><?php echo $resultData['l_name']; ?></td>
                                        <td><?php echo $resultData['gender']; ?></td>
                                        <td><?php echo $resultData['mob_no']; ?></td>
                                        <td><?php echo $resultData['email_id']; ?></td>
                                        <td><?php echo $resultData['aadhar_no']; ?></td>
                                        <td><?php echo $resultData['abc_id']; ?></td>
                                        <td><img id="img_<?php echo $resultData['enroll_no']; ?>" src="../../assets/images/uploaded_images/<?php echo $resultData['pro_pic']; ?>" width="70" height="70"></td>
                                        </tr>
                    <?php
                                    }
                                }
                            } else {
                                echo "<tr class='text-center'><td colspan='2'>No Data Found in Table</td></tr>";
                            }
                        } catch (mysqli_sql_exception $e) {
                            echo "<tr class='text-center'><td colspan='2'>Enrollment Not Assigned</td></tr>";
                        }
                    } else {
                        echo "<tr class='text-center'><td colspan='2'>Class Not Assigned</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="editForm" class="modal-form d-none">
        <div class="container-fluid pt-3">
            <button type="button" class="close-btn" onclick="closeForm('editForm')">&times;</button>
            <div class="row justify-content-center align-items-center h-100 mt-4">
                <div class="col-12 col-lg-9 col-xl-7 w-100">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <!-- FORM START -->
                            <form class="personal-details-form" method="post" enctype="multipart/form-data" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <!-- ID -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label">Student ID</label>
                                            <input type="text" id="id" name="id" class="form-control form-control-md" required readonly />
                                            <div class="invalid-feedback">Fetch ID!</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <!-- ADMISSION STATUS -->
                                        <h6 class="mb-2 pb-1">Admission Status:</h6>
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="reg" name="adm_status" value="regular" required />
                                                <label class="form-check-label" for="regular">Regular</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="prov" name="adm_status" value="prov_admission" required />
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
                                            <input type="Date" id="ad_date" name="ad_date" class="form-control form-control-lg" required />
                                            <div class="invalid-feedback">Please select the date !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <!-- SPID -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="spid">SPID</label>
                                            <input type="text" id="spid" name="spid" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                            <div class="invalid-feedback">Please fill SPID !</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <!-- CVM ENROLLMENT ID -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="enrol_id">CVM Enrollment ID</label>
                                            <input type="text" id="enroll_no" name="enroll_no" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                            <div class="invalid-feedback">Please fill Enrollment ID !</div>
                                        </div>

                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <!-- ROLL NUMBER -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="roll">Roll Number</label>
                                            <input type="text" id="roll" name="roll" class="form-control form-control-lg" pattern="\d*" required />
                                            <div class="invalid-feedback">Please fill roll number !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <!-- Course -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="roll">Course</label>
                                            <select name="course" id="course" class="form-control form-control-lg" required>
                                                <option value="" disabled selected hidden>-- Select Course --</option>
                                                <?php
                                                $result = $conn->query("SELECT DISTINCT course_name FROM course_class");
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option>' . $row['course_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">Please fill roll number !</div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <!-- FIRST NAME -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="firstName">First Name</label>
                                            <input type="text" id="fname" name="fname" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                            <div class="invalid-feedback">Please fill first name !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <!-- MIDDLE NAME -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="firstName">Middle Name</label>
                                            <input type="text" id="mname" name="mname" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                            <div class="invalid-feedback">Please fill first name !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <!-- LAST NAME -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="lastName">Last Name</label>
                                            <input type="text" id="lname" name="lname" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                            <div class="invalid-feedback">Please fill last name !</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <!-- GENDER -->
                                        <h6 class="mb-2 pb-1">Gender:</h6>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="rd_male" name="gender" value="male" required />
                                            <label class="form-check-label" for="maleGender">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="rd_female" name="gender" value="female" required />
                                            <label class="form-check-label" for="femaleGender">Female</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="rd_other" name="gender" value="other" required />
                                            <label class="form-check-label" for="otherGender">Other</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4 pb-2">
                                        <!-- PHONE NUMBER -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="phoneNumber">Phone Number</label>
                                            <input type="text" id="phone" name="phone" class="form-control form-control-lg" required />
                                            <div class="invalid-feedback">Please fill phone number !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4 pb-2">
                                        <!-- EMAIL -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="emailAddress">Email</label>
                                            <input type="email" id="email" name="email" class="form-control form-control-lg" required />
                                            <div class="invalid-feedback">Please fill email !</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4 pb-2">
                                        <!-- AADHAR CARD NUMBER -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="aadhar">Aadhar Number Number</label>
                                            <input type="text" id="aadhar" name="aadhar" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                            <div class="invalid-feedback">Please choose aadhar card !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4 pb-2">
                                        <!-- ABC ID -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="abc_id">ABC ID</label>
                                            <input type="text" id="abcid" name="abcid" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                            <div class="invalid-feedback">Please fill ABC ID !</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mt-2" data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="filelbl">Upload Your Profile Picture</label>
                                        <input type="file" name="pfp" class="form-control" accept=".jpg, .jpeg" id="inputGroupFile02">
                                    </div>
                                    <div class="col-md-6">
                                        <img id="editphoto" src="" width="100" height="120">
                                    </div>
                                </div>
                                <!-- SUBMIT & NEXT -->
                                <div class="mt-4 pt-2">
                                    <input data-mdb-ripple-init class="btn btn-primary btn-lg" name="pers_edit" type="submit" value="EDIT" />
                                </div>
                            </form>
                            <!-- FORM END -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalBackdrop" class="modal-backdrop d-none"></div>

    <script>
        function editRecord(button) {
            document.getElementById('displayTable').classList.add('blur-background');
            document.getElementById('editForm').classList.remove('d-none');

            const row = button.closest('tr');

            document.getElementById('id').value = row.cells[1].innerText;
            if (row.cells[2].innerText == 'regular') {
                document.getElementById('reg').checked = true;
            } else {
                document.getElementById('prov').checked = true;
            }
            document.getElementById('ad_date').value = row.cells[3].innerText;
            document.getElementById('spid').value = row.cells[4].innerText;
            document.getElementById('enroll_no').value = row.cells[5].innerText;
            document.getElementById('course').value = row.cells[6].innerText;
            document.getElementById('roll').value = row.cells[7].innerText;
            document.getElementById('fname').value = row.cells[8].innerText;
            document.getElementById('mname').value = row.cells[9].innerText;
            document.getElementById('lname').value = row.cells[10].innerText;
            if (row.cells[11].innerText == 'male') {
                document.getElementById('rd_male').checked = true;
            } else if (row.cells[11].innerText == 'female') {
                document.getElementById('rd_female').checked = true;
            } else {
                document.getElementById('rd_other').checked = true;
            }
            document.getElementById('phone').value = row.cells[12].innerText;
            document.getElementById('email').value = row.cells[13].innerText;
            document.getElementById('aadhar').value = row.cells[14].innerText;
            document.getElementById('abcid').value = row.cells[15].innerText;
            document.getElementById('editphoto').src = document.getElementById('img_' + row.cells[5].innerText).src;

        }

        function closeForm(formId) {
            document.getElementById('displayTable').classList.remove('blur-background');
            document.getElementById(formId).classList.add('d-none');
            document.getElementById('modalBackdrop').classList.add('d-none');
        }

        document.addEventListener('DOMContentLoaded', function() {
            var forms = document.querySelectorAll('.personal-details-form');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });

        function searchTable(tableBody, searchtxt) {
            const searchInput = document.getElementById(searchtxt).value.toLowerCase();
            const rows = document.getElementById(tableBody).getElementsByTagName('tr');
            for (const row of rows) {
                row.style.display = 'none';
                const cells = row.getElementsByTagName('td');
                for (const cell of cells) {
                    if (cell.innerText.toLowerCase().includes(searchInput)) {
                        row.style.display = '';
                        break;
                    }
                }
            }
        }
    </script>
    <script src="../../assets/js/main.js"></script>
</body>

</html>