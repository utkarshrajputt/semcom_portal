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

        select {}
    </style>
</head>

<body id="body-pd">
    <?php
    require '../includes/sidebar-admin.php';
    ?>
    <?php
    if (isset($_POST['btn_assign'])) {
        $course = $_POST['course'];
        $semester = $_POST['semester'];
        $division = $_POST['division'];
        $email = $_POST['clg_email'];

        try {
            $class = "SELECT * FROM staff_class_assign WHERE course='$course' and semester='$semester' and division='$division'";
            $class_stmt = mysqli_query($conn, $class);
            if (mysqli_num_rows($class_stmt) == 0) {
                $sql = "SELECT * FROM staff_class_assign WHERE staff_email = '$email'";
                $stmt = mysqli_query($conn, $sql);
                if (mysqli_num_rows($stmt) == 0) {
                    $stmt = mysqli_query($conn, "insert into staff_class_assign(staff_email,course,semester,division) values('$email','$course','$semester','$division')");

                    echo "<script>alert('Data Saved Successfully!!');</script>";
                } else {
                    echo "<script>alert('Email Already Assigned, Edit or Delete Via Display Module!!');</script>";
                }
            } else {
                echo "<script>alert('Class Already Assigned, Edit or Delete Via Display Module!!');</script>";
            }
        } catch (mysqli_sql_exception $e) {
            echo "" . $e->getMessage() . "";
        }
    }

    if (isset($_POST["btn_update"])) {
        $course = $_POST['editCourse'];
        $semester = $_POST['editSemester'];
        $division = $_POST['editDivision'];
        $email = $_POST['editEmail'];

        try {
            $class = "SELECT * FROM staff_class_assign WHERE course='$course' and semester='$semester' and division='$division'";
            $class_stmt = mysqli_query($conn, $class);
            if (mysqli_num_rows($class_stmt) == 0) {
                $stmt = mysqli_query($conn, "update staff_class_assign set course='$course',semester='$semester',division='$division' where staff_email='$email'");
                echo "<script>alert('Data Updated Successfully!!');</script>";
            }else{
                echo "<script>alert('Class Already Assigned, Delete Old Entry!!');</script>";
            }
            
        } catch (mysqli_sql_exception $e) {
            echo "" . $e->getMessage() . "";
        }
    }
    if (isset($_POST["btn_delete"])) {
        $email = $_POST['editEmail'];
        try {
            $stmt = mysqli_query($conn, "delete from staff_class_assign where staff_email='$email'");

            echo "<script>alert('Data Deleted Successfully!!');</script>";
        } catch (mysqli_sql_exception $e) {
            echo '' . $e->getMessage() . '';
        }
    }
    ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-end mb-3">
            <button id="displayBtn" class="btn btn-primary me-2">Display</button>
            <button id="assignBtn" class="btn btn-secondary">Assign Class</button>
        </div>

        <div id="searchBox" class="mb-3 d-flex justify-content-end">
            <input type="text" class="form-control w-50 me-2" id="searchInput" placeholder="Search...">
            <button class="btn btn-info" onclick="searchTable()">Search</button>
        </div>

        <div id="displayTable" class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light text-center">
                    <tr>
                        <th>Course</th>
                        <th>Semester</th>
                        <th>Division</th>
                        <th>Class Counsellor</th>
                        <th>Email</th>
                        <th>Photo</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- More rows will be added dynamically here -->
                    <?php
                    $result = $conn->query("SELECT * FROM staff_class_assign");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $semail = $row["staff_email"];
                        $data = mysqli_fetch_array(mysqli_query($conn, "select * from staff_dtl where clg_email='$semail'"));
                    ?>
                        <tr class="text-center">
                            <td><?php echo $row['course']; ?></td>
                            <td><?php echo $row['semester']; ?></td>
                            <td><?php echo $row['division']; ?></td>
                            <td><?php echo $data['full_name']; ?></td>
                            <td><?php echo $data['clg_email']; ?></td>
                            <td><img class="img" src="../assets/images/staff_images/<?php echo $data['staff_img'] ?>" width="100" height="100"></td>
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
            <h5>Edit Class Assign</h5>
            <form method="post">
                <div class="mb-3">
                    <label for="editName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="editName" disabled>
                </div>
                <div class="mb-3">
                    <label for="editEmail" class="form-label">Email</label>
                    <input type="text" class="form-control" name="editEmail" id="editEmail" readonly>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <!-- ROLL NUMBER -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="roll">Course</label>
                            <select name="editCourse" class="form-control form-control-md">
                                <option value="" disabled selected hidden>-- Select Course --</option>
                                <?php
                                $result = $conn->query("SELECT DISTINCT course_name FROM course_class");
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['course_name'] . '">' . $row['course_name'] . '</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please fill Course !</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <!-- Semester -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="roll">Semester</label>
                            <select name="editSemester" class="form-control form-control-md">
                                <option value="" disabled selected hidden>-- Select Semester --</option>
                                <?php
                                $result = $conn->query("SELECT DISTINCT class_semester FROM course_class");
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['class_semester'] . '">' . $row['class_semester'] . '</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please Select Semester !</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <!-- Course -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="roll">Division</label>
                            <select name="editDivision" class="form-control form-control-md">
                                <option value="" disabled selected hidden>-- Select Division --</option>
                                <?php
                                $result = $conn->query("SELECT DISTINCT class_div FROM course_class");
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['class_div'] . '">' . $row['class_div'] . '</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please Select Division !</div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-success" name="btn_update">Update</button>
                    <button class="btn btn-danger" name="btn_delete">Delete</button>
                </div>
            </form>
        </div>

        <div id="assignForm" class="modal-form d-none">
            <button type="button" class="close-btn" onclick="closeForm('assignForm')">&times;</button>
            <h5>Assign Class</h5>
            <form method="post" class="assignForm" onsubmit="return validateForm()" novalidate>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <!-- Course -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="roll">Course</label>
                            <select name="course" class="form-control form-control-md" required>
                                <option value="" disabled selected hidden>-- Select Course --</option>
                                <?php
                                $result = $conn->query("SELECT DISTINCT course_name FROM course_class");
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['course_name'] . '">' . $row['course_name'] . '</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please fill Course !</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <!-- ROLL NUMBER -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="roll">Semester</label>
                            <select name="semester" class="form-control form-control-md" required>
                                <option value="" disabled selected hidden>-- Select Semester --</option>
                                <?php
                                $result = $conn->query("SELECT DISTINCT class_semester FROM course_class");
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['class_semester'] . '">' . $row['class_semester'] . '</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please Select Semester !</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <!-- ROLL NUMBER -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="roll">Division</label>
                            <select name="division" class="form-control form-control-md" required>
                                <option value="" disabled selected hidden>-- Select Division --</option>
                                <?php
                                $result = $conn->query("SELECT DISTINCT class_div FROM course_class");
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['class_div'] . '">' . $row['class_div'] . '</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please Select Division !</div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="assignEmail" class="form-label">Email</label>
                    <select name="clg_email" class="form-control form-control-md" required>
                        <option value="" disabled selected hidden>- Select -</option>
                        <?php
                        $qry = mysqli_query($conn, 'select clg_email from staff_dtl');
                        while ($row = mysqli_fetch_array($qry)) {
                            echo "<option>" . $row['clg_email'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <button name="btn_assign" type="submit" class="btn btn-primary">Assign</button>
                </div>
            </form>
        </div>

        <script>
            function applyValidation(forms) {
                Array.prototype.slice.call(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }

            document.addEventListener('DOMContentLoaded', function() {

                var personalDetailsForms = document.querySelectorAll('.assignForm');
                applyValidation(personalDetailsForms);

            });

            function validateForm() {
                const enrollStart = document.getElementById('assignEnrollStart').value;
                const enrollEnd = document.getElementById('assignEnrollEnd').value;

                if (!enrollStart || !enrollEnd) {
                    alert('Enrollment numbers cannot be empty');
                    return false;
                }

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
            document.getElementById('editName').value = row.cells[3].innerText;
            document.getElementById('editEmail').value = row.cells[4].innerText;
        }

        function closeForm(formId) {
            document.getElementById('displayTable').classList.remove('blur-background');
            document.getElementById(formId).classList.add('d-none');
            document.getElementById('modalBackdrop').classList.add('d-none');
        }

        document.getElementById('assignBtn').addEventListener('click', () => {
            document.getElementById('displayTable').classList.add('blur-background');
            document.getElementById('assignForm').classList.remove('d-none');
            document.getElementById('modalBackdrop').classList.remove('d-none');
        });

        document.getElementById('displayBtn').addEventListener('click', () => {
            window.location.reload(); // Simulate refresh
        });

        function searchTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.getElementById('tableBody').getElementsByTagName('tr');

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





    <!-- MAIN STUDENT JS -->
    <script src="../assets/js/main.js"></script>

</body>

</html>