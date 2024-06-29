<?php
require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require('../includes/fetchTableData.php');
$admin_email = $_SESSION['admin_email'];

if (!isset($admin_email)) {
    header('location:admin_login.php');
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
    <link rel="stylesheet" href="../assets/css/student.css">
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
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 600px;
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
            top: 10px;
            right: 10px;
            font-size: 1.2rem;
            border: none;
            background: transparent;
        }

        .form-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .nav_link {
            margin-bottom: 20px;
        }

        .dropdown {
            margin-top: 25px;
            padding-top: 15px;
        }
    </style>
</head>

<body id="body-pd">
    <?php
    require '../includes/sidebar-admin.php';
    ?>
    <?php
    if (isset($_POST['btn_add'])) {
        $course = $_POST['course'];
        $semester = $_POST['semester'];
        $division = $_POST['division'];
        $start = $_POST['enroll_start'];
        $end = $_POST['enroll_end'];

        try {

            $sql = "SELECT * FROM course_class WHERE course_name='$course' and class_semester='$semester' and class_div='$division'";


            $stmt = mysqli_query($conn, $sql);
            if (mysqli_num_rows($stmt) == 0) {
                $stmt = mysqli_query($conn, "insert into course_class(course_name,class_semester,class_div,class_enroll_start,class_enroll_end) values('$course','$semester','$division',$start,$end)");

                echo "<script>alert('Data Saved Successfully!!');</script>";
            } else {
                echo "<script>alert('Data Already Exist, Edit or Delete Via Display Module!!');</script>";
            }
        } catch (mysqli_sql_exception $e) {
            echo "" . $e->getMessage() . "";
        }
    }

    if (isset($_POST["btn_update"])) {
        $course = $_POST['editCourse'];
        $semester = $_POST['editSemester'];
        $division = $_POST['editDivision'];
        $start = $_POST['editEnrollStart'];
        $end = $_POST['editEnrollEnd'];
        try {
            $stmt = mysqli_query($conn, "update course_class set class_enroll_start='$start',class_enroll_end='$end' where course_name='$course' and class_semester='$semester' and class_div='$division'");

            echo "<script>alert('Data Updated Successfully!!');</script>";
        } catch (mysqli_sql_exception $e) {
            echo '' . $e->getMessage() . '';
        }
    }
    if (isset($_POST["btn_delete"])) {
        $course = $_POST['editCourse'];
        $semester = $_POST['editSemester'];
        $division = $_POST['editDivision'];
        try {
            $stmt = mysqli_query($conn, "delete from course_class where course_name='$course' and class_semester='$semester' and class_div='$division'");

            echo "<script>alert('Data Deleted Successfully!!');</script>";
        } catch (mysqli_sql_exception $e) {
            echo '' . $e->getMessage() . '';
        }
    }
    ?>
    <div class="container mt-5">
        <h2 class="text-center" style="font-weight:bolder;">Add Class Details</h2>

        <div class="d-flex justify-content-end mb-3">
            <button id="displayBtn" class="btn btn-primary me-2">Display</button>
            <button id="addBtn" class="btn btn-secondary">Add Class</button>
        </div>

        <div id="displayTable" class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light text-center">
                    <tr>
                        <th>Course</th>
                        <th>Semester</th>
                        <th>Division</th>
                        <th>Staff Name</th>
                        <th>Enrollment No Start</th>
                        <th>Enrollment No End</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="text-center">
                    <!-- More rows will be added dynamically here -->
                    <?php
                    $stmt = mysqli_query($conn, "select * from course_class");
                    while ($data = mysqli_fetch_assoc($stmt)) {

                    ?>
                        <tr>
                            <td><?php echo $data['course_name']; ?></td>
                            <td><?php echo $data['class_semester']; ?></td>
                            <td><?php echo $data['class_div']; ?></td>
                            <?php
                            try {
                                $course = $data['course_name'];
                                $sem = $data['class_semester'];
                                $div = $data['class_div'];
                                $staff_qry = mysqli_query($conn, "select staff_email from staff_class_assign where course='$course' and semester='$sem' and division='$div'");
                                if(mysqli_num_rows($staff_qry)>0)
                                {
                                    $staff = mysqli_fetch_assoc($staff_qry);
                                    $staff_email = $staff["staff_email"];
                                    $staff_dtl=mysqli_fetch_assoc(mysqli_query($conn, "select full_name from staff_dtl where clg_email='$staff_email'"));
                                    $full_name=$staff_dtl["full_name"];
                                }
                                else
                                {
                                    $full_name = '<b>NOT ASSIGNED</b>';
                                }
                            } catch (mysqli_sql_exception $e) {
                                $full_name = '<b>NOT ASSIGNED</b>';
                            }
                            ?>
                            <td><?php echo $full_name ?></td> 
                            <td><?php echo $data['class_enroll_start']; ?></td>
                            <td><?php echo $data['class_enroll_end']; ?></td>
                            <td><button class="btn btn-warning btn-sm" onclick="editRecord(this)">Edit</button></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="editForm" class="modal-form d-none">
            <button type="button" class="close-btn" onclick="closeForm('editForm')">&times;</button>
            <h5>Edit Class</h5>
            <form method="post" onsubmit="return up_validateForm()">
                <div class="mb-3">
                    <label for="editCourse" class="form-label">Course</label>
                    <input type="text" class="form-control" id="editCourse" name="editCourse" style="pointer-events:none;background-color:#e9ecef;">
                </div>
                <div class="mb-3">
                    <label for="editSemester" class="form-label">Semester</label>
                    <input type="text" class="form-control" id="editSemester" name="editSemester" style="pointer-events:none;background-color:#e9ecef;">
                </div>
                <div class="mb-3">
                    <label for="editDivision" class="form-label">Division</label>
                    <input type="text" class="form-control" id="editDivision" name="editDivision" style="pointer-events:none;background-color:#e9ecef;">
                </div>
                <div class="mb-3">
                    <label for="editEnrollStart" class="form-label">Enrollment No Start</label>
                    <input type="text" class="form-control" id="editEnrollStart" name="editEnrollStart">
                </div>
                <div class="mb-3">
                    <label for="editEnrollEnd" class="form-label">Enrollment No End</label>
                    <input type="text" class="form-control" id="editEnrollEnd" name="editEnrollEnd">
                </div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-success" name="btn_update">Update</button>
                    <button class="btn btn-danger" name="btn_delete">Delete</button>
                </div>
            </form>
        </div>

        <div id="addForm" class="modal-form d-none">
            <button type="button" class="close-btn" onclick="closeForm('addForm')">&times;</button>
            <h5>Add Class</h5>
            <form method="post" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label for="addCourse" class="form-label">Course</label>
                    <input type="text" class="form-control" id="addCourse" name="course" required>
                </div>
                <div class="mb-3">
                    <label for="addSemester" class="form-label">Semester</label>
                    <input type="text" class="form-control" id="addSemester" name="semester" pattern="[1-9]" title="Semester must be a single digit from 1 to 9" required>
                </div>
                <div class="mb-3">
                    <label for="addDivision" class="form-label">Division <span style="color:red;">(Use '-' if doesn't exist)</span></label>
                    <input type="text" class="form-control" id="addDivision" name="division" pattern="[A-Z\-]" title="Division must be a single uppercase letter from A to Z or - " required>
                </div>
                <div class="mb-3">
                    <label for="addEnrollStart" class="form-label">Enrollment No Start</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="addEnrollStart" pattern="[0-9]{14,}" title="Enroll must be at least 14 digits" name="enroll_start" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <input type="checkbox" name="enroll_start_chk" id="enroll_start_chk" aria-label="Fill Later?">&nbsp;&nbsp;<small class="form-text text-muted">Fill Later?</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="addEnrollEnd" class="form-label">Enrollment No End</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="addEnrollEnd" pattern="[0-9]{14,}" title="Enroll must be at least 14 digits" name="enroll_end" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <input type="checkbox" name="enroll_end_chk" id="enroll_end_chk" aria-label="Fill Later?">&nbsp;&nbsp;<small class="form-text text-muted">Fill Later?</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button name="btn_add" type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>

        <script>
            function validateForm() {
                const enrollStart = document.getElementById('addEnrollStart').value;
                const enrollEnd = document.getElementById('addEnrollEnd').value;
                if (!(document.getElementById('enroll_start_chk').checked || document.getElementById('enroll_end_chk').checked)) {

                    if (isNaN(enrollStart) || isNaN(enrollEnd)) {
                        alert('Enrollment numbers must be numeric');
                        return false;
                    }

                    if (parseInt(enrollEnd) <= parseInt(enrollStart)) {
                        alert('Enrollment No End must be greater than Enrollment No Start');
                        return false;
                    }
                }


                return true;
            }

            function up_validateForm() {
                const enrollStart = document.getElementById('editEnrollStart').value;
                const enrollEnd = document.getElementById('editEnrollEnd').value;
                if (isNaN(enrollStart) || isNaN(enrollEnd)) {
                    alert('Enrollment numbers must be numeric');
                    return false;
                }

                if (parseInt(enrollEnd) <= parseInt(enrollStart)) {
                    alert('Enrollment No End must be greater than Enrollment No Start');
                    return false;
                }


                return true;
            }
        </script>


        <div id="modalBackdrop" class="modal-backdrop d-none"></div>
    </div>

    <script>
        function editRecord(button) {
            document.getElementById('displayTable').classList.add('blur-background');
            document.getElementById('editForm').classList.remove('d-none');
            document.getElementById('modalBackdrop').classList.remove('d-none');

            // Populate form fields with row data
            const row = button.closest('tr');
            document.getElementById('editCourse').value = row.cells[0].innerText;
            document.getElementById('editSemester').value = row.cells[1].innerText;
            document.getElementById('editDivision').value = row.cells[2].innerText;
            document.getElementById('editEnrollStart').value = row.cells[4].innerText;
            document.getElementById('editEnrollEnd').value = row.cells[5].innerText;
        }

        function closeForm(formId) {
            document.getElementById('displayTable').classList.remove('blur-background');
            document.getElementById(formId).classList.add('d-none');
            document.getElementById('modalBackdrop').classList.add('d-none');
        }

        document.getElementById('addBtn').addEventListener('click', () => {
            document.getElementById('displayTable').classList.add('blur-background');
            document.getElementById('addForm').classList.remove('d-none');
            document.getElementById('modalBackdrop').classList.remove('d-none');
        });

        document.getElementById('enroll_start_chk').addEventListener('click', () => {
            if (document.getElementById('enroll_start_chk').checked) {
                document.getElementById('addEnrollStart').value = "NULL";
                document.getElementById('addEnrollStart').style = "pointer-events:none;background-color:#e9ecef;";
                document.getElementById('addEnrollStart').removeAttribute('pattern');
            } else {
                document.getElementById('addEnrollStart').value = "";
                document.getElementById('addEnrollStart').style = "pointer-events:auto;background-color:white;";
                document.getElementById('addEnrollStart').removeAttribute('pattern');
            }
        });
        document.getElementById('enroll_end_chk').addEventListener('click', () => {
            if (document.getElementById('enroll_end_chk').checked) {
                document.getElementById('addEnrollEnd').value = "NULL";
                document.getElementById('addEnrollEnd').style = "pointer-events:none;background-color:#e9ecef;";
                document.getElementById('addEnrollEnd').removeAttribute('pattern');
            } else {
                document.getElementById('addEnrollEnd').value = "";
                document.getElementById('addEnrollEnd').style = "pointer-events:auto;background-color:white;";
                document.getElementById('addEnrollEnd').removeAttribute('pattern');
            }
        });

        document.getElementById('displayBtn').addEventListener('click', () => {
            window.location.reload(); // Simulate refresh
        });
    </script>





    <!-- MAIN STUDENT JS -->
    <script src="../assets/js/main.js"></script>

</body>

</html>