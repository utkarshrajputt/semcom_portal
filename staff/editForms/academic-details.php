<?php
require('loader.php');
require('../../includes/session.php');
require('../../config/mysqli_db.php');
$staff_email = $_SESSION['staff_email'];

if (!isset($staff_email)) {
    header('location:../../staff/staff_login.php');
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
    if (isset($_POST['academic_submit'])) {
        $id = $_POST['id'];
        $enroll = $_POST["enroll_no"];
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

        try {

            $stmt = mysqli_query($conn, "UPDATE stud_academic_details SET enroll_no='$enroll',ssc_board='$ssc_board',ssc_month_year='$sscmonthyear',ssc_percentage='$ssc_perc',ssc_school='$ssc_skl',ssc_medium='$ssc_medium',hsc_board='$hsc_board',hsc_month_year='$hscmonthyear',hsc_percentage='$hsc_perc',hsc_school='$hsc_skl',hsc_medium='$hsc_medium',stud_achieve='$ach' WHERE academic_id='$id'");
            echo "<script>alert('Data Updated Successfully!!');</script>";
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
        <h3 class="mb-4">Edit Student Address Details</h3>
        <div id="displayTable" class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-light">
                    <tr valign="top">
                        <th></th>
                        <th>ID</th>
                        <th>Enrollment No</th>
                        <th>Full Name</th>
                        <th>Roll No</th>
                        <th>SSC Board</th>
                        <th>SSC School</th>
                        <th>SSC Month & Year</th>
                        <th>SSC Percentage</th>
                        <th>SSC Medium</th>
                        <th>HSC Board</th>
                        <th>HSC School</th>
                        <th>HSC Month & Year</th>
                        <th>HSC Percentage</th>
                        <th>HSC Medium</th>
                        <th>Achievements</th>
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

                            $resultDataResult = mysqli_query($conn, "select * from stud_academic_details order by enroll_no");
                            if ($resultDataResult->num_rows > 0) {
                                while ($resultData = $resultDataResult->fetch_assoc()) {
                                    if ($resultData['enroll_no'] >= $data['class_enroll_start'] && $resultData['enroll_no'] <= $data['class_enroll_end']) {
                                        $enroll = $resultData['enroll_no'];
                                        $enrollDtlResult = mysqli_query($conn, "select concat(f_name,' ',m_name,' ',l_name) as full_name,roll_no from stud_personal_details where enroll_no='$enroll'");
                                        $enrollDtl = $enrollDtlResult->fetch_assoc();
                    ?>
                                        <td><button class="btn btn-warning btn-sm" onclick="editRecord(this)">Edit</button></td>
                                        <td><?php echo $resultData['academic_id']; ?></td>
                                        <td><?php echo $resultData['enroll_no']; ?></td>
                                        <td><?php echo $enrollDtl['full_name']; ?></td>
                                        <td><?php echo $enrollDtl['roll_no']; ?></td>
                                        <td><?php echo $resultData['ssc_board']; ?></td>
                                        <td><?php echo $resultData['ssc_school']; ?></td>
                                        <td><?php echo $resultData['ssc_month_year']; ?></td>
                                        <td><?php echo $resultData['ssc_percentage']; ?></td>
                                        <td><?php echo $resultData['ssc_medium']; ?></td>
                                        <td><?php echo $resultData['hsc_board']; ?></td>
                                        <td><?php echo $resultData['hsc_school']; ?></td>
                                        <td><?php echo $resultData['hsc_month_year']; ?></td>
                                        <td><?php echo $resultData['hsc_percentage']; ?></td>
                                        <td><?php echo $resultData['hsc_medium']; ?></td>
                                        <td><?php echo $resultData['stud_achieve']; ?></td>
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
            <div class="row mt-2 justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7 w-100">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <!-- FORM START -->
                            <form class="academic-details-form" novalidate method="post">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <!-- ID -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label">ID</label>
                                            <input type="text" id="id" name="id" class="form-control form-control-md" required readonly />
                                            <div class="invalid-feedback">Fetch ID!</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <!-- CVM ENROLLMENT ID -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="enrol_id">CVM Enrollment ID</label>
                                            <input type="text" id="enroll_no" name="enroll_no" class="form-control form-control-lg" pattern="\d*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                                            <div class="invalid-feedback">Please fill Enrollment ID !</div>
                                        </div>
                                    </div>
                                </div>
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
                                            <label class="form-label" for="sscBoardName">SSC Board Name</label><br>
                                            <br>
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
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <!-- SSC SCHOOL NAME -->
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
                                            <input type="text" name="sscmonth_year" class="form-control form-control-lg" required />
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
                                            <label class="form-label" for="hscBoardName">HSC Board Name</label><br>
                                            <br>
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
                                            <input type="text" name="hscmonth_year" class="form-control form-control-lg" required />
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
                                            <label class="form-label" for="achivements">Your Achievements</label>
                                            <input type="text" name="achievements" class="form-control form-control-lg" required />
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
    </div>
    <div id="modalBackdrop" class="modal-backdrop d-none"></div>

    <script>
        function editRecord(button) {
            document.getElementById('displayTable').classList.add('blur-background');
            document.getElementById('editForm').classList.remove('d-none');

            const row = button.closest('tr');

            document.getElementById('id').value = row.cells[1].innerText;
            document.getElementById('enroll_no').value = row.cells[2].innerText;


            // Populate the SSC details
            document.querySelector('[name="sscboard"]').value = row.cells[5].innerText;
            document.querySelector('[name="sscSchoolName"]').value = row.cells[6].innerText;
            document.querySelector('[name="sscmonth_year"]').value = row.cells[7].innerText;
            document.querySelector('[name="sscPercentage"]').value = row.cells[8].innerText;
            document.querySelector('[name="sscMedium"]').value = row.cells[9].innerText;

            // Populate the HSC details
            document.querySelector('[name="hscboard"]').value = row.cells[10].innerText;
            document.querySelector('[name="hscSchoolName"]').value = row.cells[11].innerText;
            document.querySelector('[name="hscmonth_year"]').value = row.cells[12].innerText;
            document.querySelector('[name="hscPercentage"]').value = row.cells[13].innerText;
            document.querySelector('[name="hscMedium"]').value = row.cells[14].innerText;

            // Populate the achievements
            document.querySelector('[name="achievements"]').value = row.cells[15].innerText;
        }

        function closeForm(formId) {
            document.getElementById('displayTable').classList.remove('blur-background');
            document.getElementById(formId).classList.add('d-none');
            document.getElementById('modalBackdrop').classList.add('d-none');
        }

        document.addEventListener('DOMContentLoaded', function() {
            var forms = document.querySelectorAll('.academic-details-form');
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