<?php
require('loader.php');
require('../../includes/session.php');
require('../../config/mysqli_db.php');
$staff_email = "";

if (!isset($_SESSION['staff_email'])) {
    header('location:staff_login.php');
    exit();
} else {
    $staff_email = $_SESSION['staff_email'];
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
    if (isset($_POST['add_submit'])) {
        $id = $_POST['id'];
        $enroll = $_POST["enroll_no"];
        $liv_status = $_POST["liv_status"];
        $perm_add1 = $_POST["perm_add1"];
        $perm_add2 = $_POST["perm_add2"];
        $perm_city = $_POST["permanentcity"];
        $perm_pin = $_POST["permanentpincode"];
        $pres_add1 = $_POST["pres_add1"];
        $pres_add2 = $_POST["pres_add2"];
        $pres_city = $_POST["presentcity"];
        $pres_pin = $_POST["presentpincode"];

        try {

            $stmt = mysqli_query($conn, "UPDATE stud_address SET enroll_no='$enroll',resident_type='$liv_status',permanent_add='$perm_add1',permanent_add2='$perm_add2',permanent_city='$perm_city',permanent_pincode='$perm_pin',present_add='$pres_add1',present_add2='$pres_add2',present_city='$pres_city',present_pincode='$pres_pin' WHERE add_id='$id'");
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
                        <th>Full name</th>
                        <th>Roll No</th>
                        <th>Resident Type</th>
                        <th>Permannat Address</th>
                        <th>Permannat Address<br> Line 2</th>
                        <th>Permannat City</th>
                        <th>Permannat Pincode</th>
                        <th>Present Address</th>
                        <th>Present Address <br>Line 2</th>
                        <th>Present City</th>
                        <th>Present Pincode</th>
                    </tr>
                </thead>
                <tbody id="result_body">
                    <?php
                    $selectQuery = "select course,semester,division from staff_class_assign where staff_email='$staff_email'";
                    $selectResult = $conn->query($selectQuery);
                    if ($selectResult->num_rows > 0) {
                        $row = $selectResult->fetch_assoc();
                        $dataResult = mysqli_query($conn, "select class_enroll_start,class_enroll_end,other_enrolls from course_class where course_name='" . $row['course'] . "' and class_semester='" . $row['semester'] . "' and class_div='" . $row['division'] . "'");
                        try {
                            $data = $dataResult->fetch_assoc();
                            $start = $data['class_enroll_start'];
                            $end = $data['class_enroll_end'];
                            $other_enrolls = $data['other_enrolls'];
                            $other_enrolls_array = array_map('trim', explode(',', $other_enrolls));

                            // Merge the range enrollments with the additional enrollments
                            $all_enrolls = range($start, $end);
                            $all_enrolls = array_merge($all_enrolls, $other_enrolls_array);
                            // Remove duplicates in case some enrollments are in both the range and the additional list
                            $all_enrolls = array_unique($all_enrolls);

                            // Convert the array to a comma-separated string for use in the SQL IN clause
                            $enroll_list = implode(',', $all_enrolls);

                            $resultDataResult = mysqli_query($conn, "select * from stud_address where enroll_no IN ($enroll_list)");
                            if ($resultDataResult->num_rows > 0) {
                                while ($resultData = $resultDataResult->fetch_assoc()) {
                                      $enroll = $resultData['enroll_no'];
                                        $enrollDtlResult = mysqli_query($conn, "select concat(f_name,' ',m_name,' ',l_name) as full_name,roll_no from stud_personal_details where enroll_no='$enroll'");
                                        $enrollDtl = $enrollDtlResult->fetch_assoc();
                    ?>
                                        <td><button class="btn btn-warning btn-sm" onclick="editRecord(this)">Edit</button></td>
                                        <td><?php echo $resultData['add_id']; ?></td>
                                        <td><?php echo $resultData['enroll_no']; ?></td>
                                        <td><?php echo $enrollDtl['full_name']; ?></td>
                                        <td><?php echo $enrollDtl['roll_no']; ?></td>
                                        <td><?php echo $resultData['resident_type']; ?></td>
                                        <td><?php echo $resultData['permanent_add']; ?></td>
                                        <td><?php echo $resultData['permanent_add2']; ?></td>
                                        <td><?php echo $resultData['permanent_city']; ?></td>
                                        <td><?php echo $resultData['permanent_pincode']; ?></td>
                                        <td><?php echo $resultData['present_add']; ?></td>
                                        <td><?php echo $resultData['present_add2']; ?></td>
                                        <td><?php echo $resultData['present_city']; ?></td>
                                        <td><?php echo $resultData['present_pincode']; ?></td>
                                        </tr>
                    <?php
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
                            <form class="address-form" novalidate method="post">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <!-- ID -->
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label">Student ID</label>
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
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <!-- LIVING STATUS -->
                                        <h6 class="mb-2 pb-1">Living Status:</h6>
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="local" name="liv_status" value="localite" required />
                                                <label class="form-check-label" for="localite">Localite</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="hostel" name="liv_status" value="hostalite" required />
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
                                            <input type="text" id="perm_add1" name="perm_add1" class="form-control form-control-lg" maxlength="60" oninput="this.value = this.value.replace(/^\s+/g, '');" required />
                                            <div class="invalid-feedback">Please fill address line !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="add2">Address Line 2</label>
                                            <input type="text" id="perm_add2" name="perm_add2" class="form-control form-control-lg" maxlength="60" oninput="this.value = this.value.replace(/^\s+/g, '');" required />
                                            <div class="invalid-feedback">Please fill address line !</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Permanent City and Pincode -->
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="permanentCity">Permanent City</label>
                                            <input type="text" id="perm_city" name="permanentcity" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                            <div class="invalid-feedback">Please fill city !</div>
                                        </div>
                                    </div>
                                    <!-- pincode -->
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="permanentPincode">Permanent Pincode</label>
                                            <input type="text" id="perm_pin" name="permanentpincode" class="form-control form-control-lg" pattern="\d{6}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="6" required />
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
                                            <input type="text" id="pres_add1" name="pres_add1" class="form-control form-control-lg" maxlength="60" oninput="this.value = this.value.replace(/^\s+/g, '');" required />
                                            <div class="invalid-feedback">Please fill address line !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="add2">Address Line 2</label>
                                            <input type="text" id="pres_add2" name="pres_add2" class="form-control form-control-lg" maxlength="60" oninput="this.value = this.value.replace(/^\s+/g, '');" required />
                                            <div class="invalid-feedback">Please fill address line !</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Present City and Pincode -->
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="presentCity">Present City</label>
                                            <input type="text" id="pres_city" name="presentcity" class="form-control form-control-lg" pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" required />
                                            <div class="invalid-feedback">Please fill city !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="presentPincode">Present Pincode</label>
                                            <input type="tel" id="pres_pin" name="presentpincode" class="form-control form-control-lg" pattern="\d{6}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="6" required />
                                            <div class="invalid-feedback">Please fill pincode !</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-4 pt-2">
                                    <input data-mdb-ripple-init class="btn btn-primary btn-lg" name="add_submit" type="submit" value="EDIT" />
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
            if (row.cells[5].innerText == 'localite') {
                document.getElementById('local').checked = true;
            } else {
                document.getElementById('hostel').checked = true;
            }
            document.getElementById('perm_add1').value = row.cells[6].innerText;
            document.getElementById('perm_add2').value = row.cells[7].innerText;
            document.getElementById('perm_city').value = row.cells[8].innerText;
            document.getElementById('perm_pin').value = row.cells[9].innerText;
            document.getElementById('pres_add1').value = row.cells[10].innerText;
            document.getElementById('pres_add2').value = row.cells[11].innerText;
            document.getElementById('pres_city').value = row.cells[12].innerText;
            document.getElementById('pres_pin').value = row.cells[13].innerText;
        }

        function closeForm(formId) {
            document.getElementById('displayTable').classList.remove('blur-background');
            document.getElementById(formId).classList.add('d-none');
            document.getElementById('modalBackdrop').classList.add('d-none');
        }

        document.addEventListener('DOMContentLoaded', function() {
            var forms = document.querySelectorAll('.address-form');
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