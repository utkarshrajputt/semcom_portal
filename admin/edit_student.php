<?php
require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require('../includes/fetchTableData.php');
$admin_email = "";

if (!isset($_SESSION['admin_email'])) {
    header('location:index.php');
}
else{
    $admin_email = $_SESSION['admin_email'];
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
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 70%;
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

    if (isset($_POST["btn_update"])) {
        $id = $_POST["edituser_id"];
        $enroll= $_POST["editenroll_no"];
        $pass = $_POST["editpass"];
        $register = $_POST["editregister"];

        try {
       
            $stmt = mysqli_query($conn, "UPDATE stud_login SET enroll_no='$enroll',password='$pass' WHERE stud_id='$id'");
                echo "<script>alert('Data Updated Successfully!!');</script>";
            }
         catch (mysqli_sql_exception $e) {
            echo "" . $e->getMessage() . "";
        }
    }
    if (isset($_POST["btn_delete"])) {
        $id=$_POST['edituser_id'];
        try {
            $stmt = mysqli_query($conn, "delete from stud_login where stud_id='$id'");

            echo "<script>alert('Data Deleted Successfully!!');</script>";
        } catch (mysqli_sql_exception $e) {
            echo '' . $e->getMessage() . '';
        }
    }
    ?>

    <div class="container mt-5">
        
    <h2 class="text-center" style="font-weight:bolder;">Edit Student Credential Details</h2><br>

        <div id="searchBox" class="mb-3 d-flex justify-content-end">
            <input type="text" class="form-control w-50 me-2" id="searchInput" placeholder="Search...">
            <button class="btn btn-info" onclick="searchTable()">Search</button>
        </div>

        <div id="displayTable" class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light text-center">
                    <tr>
                        <th>Edit</th>
                        <th>User Id</th>
                        <th>Enrollment No</th>
                        <th>Password</th>
                        <th>Complete Register</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- More rows will be added dynamically here -->
                    <?php
                    $result = $conn->query("SELECT * FROM stud_login");
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr class="text-center">
                            <td><button class="btn btn-warning btn-sm" onclick="editRecord(this)">Edit</button></td>
                            <td><?php echo $row['stud_id']; ?></td>
                            <td><?php echo $row['enroll_no']; ?></td>
                            <td><?php echo $row['password']; ?></td>
                            <td><?php echo $row['complete_register']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="editForm" class="modal-form d-none">
            <button type="button" class="close-btn" onclick="closeForm('editForm')">&times;</button>
            <h5>Edit Staff</h5>
            <form class="personal-details-form" method="post" enctype="multipart/form-data" novalidate>

                <div class="row">
                    <div class="col-md-6">
                        <!-- ROLL NUMBER -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label">User Id</label>
                            <input type="text" id="edituser_id" name="edituser_id" class="form-control form-control-md" required readonly />
                            <div class="invalid-feedback">Please fill User ID !</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                <div class="col-md-6">
                        <!-- ROLL NUMBER -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="roll">Enrollment No</label>
                            <input type="text" id="editenroll_no" name="editenroll_no" class="form-control form-control-md" required />
                            <div class="invalid-feedback">Please fill Enrollment No !</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- SPID -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="spid">Password</label>
                            <input type="text" id="editpass" name="editpass" class="form-control form-control-md" required />
                            <div class="invalid-feedback">Please fill Password !</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label">Complete Registation</label>
                            <input type="text" id="editregister" name="editregister" class="form-control form-control-md" required readonly />
                            <div class="invalid-feedback">Please fill Field !</div>
                        </div>
                    </div>
                </div>
                <!-- SUBMIT & NEXT -->
                <div style="float:right;">
                    <button class="btn btn-success" name="btn_update">Update</button>
                    <button class="btn btn-danger" name="btn_delete">Delete</button>
                </div>
            </form>
        </div>

        <div id="modalBackdrop" class="modal-backdrop d-none"></div>
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

            var personalDetailsForms = document.querySelectorAll('.personal-details-form');
            applyValidation(personalDetailsForms);

        });
    </script>
    <script>
        function editRecord(button) {
            document.getElementById('displayTable').classList.add('blur-background');
            document.getElementById('editForm').classList.remove('d-none');
            document.getElementById('modalBackdrop').classList.remove('d-none');

            // Populate form fields with row data
            const row = button.closest('tr');
            // document.getElementById('editName').value = row.cells[3].innerText;
            // document.getElementById('editEmail').value = row.cells[4].innerText;
            document.getElementById('edituser_id').value = row.cells[1].innerText;
            document.getElementById('editenroll_no').value = row.cells[2].innerText;
            document.getElementById('editpass').value = row.cells[3].innerText;
            document.getElementById('editregister').value = row.cells[4].innerText;
        }

        function closeForm(formId) {
            document.getElementById('displayTable').classList.remove('blur-background');
            document.getElementById(formId).classList.add('d-none');
            document.getElementById('modalBackdrop').classList.add('d-none');
        }

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