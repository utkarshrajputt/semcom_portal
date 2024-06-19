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
    </style>
</head>

<body id="body-pd">
    <?php
    require '../includes/sidebar-admin.php';
    ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-end mb-3">
            <button id="displayBtn" class="btn btn-primary me-2">Display</button>
            <button id="assignBtn" class="btn btn-secondary">Assign</button>
        </div>

        <div id="searchBox" class="mb-3 d-flex justify-content-end">
            <input type="text" class="form-control w-50 me-2" id="searchInput" placeholder="Search...">
            <button class="btn btn-info" onclick="searchTable()">Search</button>
        </div>

        <div id="displayTable" class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light text-center">
                    <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Email</th>
                        <th>Enrollment No Start</th>
                        <th>Enrollment No End</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Sample Row for Display -->
                    <tr>
                        <td>John Doe</td>
                        <td><img src="path/to/photo.jpg" alt="Photo" class="img-thumbnail" style="width: 50px; height: 50px;"></td>
                        <td>john@example.com</td>
                        <td>1001</td>
                        <td>1010</td>
                        <td><button class="btn btn-warning btn-sm" onclick="editRecord(this)">Edit</button></td>
                    </tr>
                    <tr>
                        <td>Doe</td>
                        <td><img src="path/to/photo.jpg" alt="Photo" class="img-thumbnail" style="width: 50px; height: 50px;"></td>
                        <td>doe@example.com</td>
                        <td>1001</td>
                        <td>1010</td>
                        <td><button class="btn btn-warning btn-sm" onclick="editRecord(this)">Edit</button></td>
                    </tr>
                    <!-- More rows will be added dynamically here -->
                </tbody>
            </table>
        </div>

        <div id="editForm" class="modal-form d-none">
            <button type="button" class="close-btn" onclick="closeForm('editForm')">&times;</button>
            <h5>Edit Staff Member</h5>
            <form>
                <div class="mb-3">
                    <label for="editName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="editName" disabled>
                </div>
                <div class="mb-3">
                    <label for="editPhoto" class="form-label">Photo</label>
                    <input type="text" class="form-control" id="editPhoto" disabled>
                </div>
                <div class="mb-3">
                    <label for="editEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="editEmail" disabled>
                </div>
                <div class="mb-3">
                    <label for="editEnrollStart" class="form-label">Enrollment No Start</label>
                    <input type="text" class="form-control" id="editEnrollStart">
                </div>
                <div class="mb-3">
                    <label for="editEnrollEnd" class="form-label">Enrollment No End</label>
                    <input type="text" class="form-control" id="editEnrollEnd">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>

        <div id="assignForm" class="modal-form d-none">
            <button type="button" class="close-btn" onclick="closeForm('assignForm')">&times;</button>
            <h5>Assign Enrollment Numbers</h5>
            <form>
                <div class="mb-3">
                    <label for="assignEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="assignEmail">
                </div>
                <div class="mb-3">
                    <label for="assignEnrollStart" class="form-label">Enrollment No Start</label>
                    <input type="text" class="form-control" id="assignEnrollStart">
                </div>
                <div class="mb-3">
                    <label for="assignEnrollEnd" class="form-label">Enrollment No End</label>
                    <input type="text" class="form-control" id="assignEnrollEnd">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-primary">Assign</button>
                </div>
            </form>
        </div>

        <div id="modalBackdrop" class="modal-backdrop d-none"></div>
    </div>

    <script>
        function editRecord(button) {
            document.getElementById('displayTable').classList.add('blur-background');
            document.getElementById('editForm').classList.remove('d-none');
            document.getElementById('modalBackdrop').classList.remove('d-none');

            // Populate form fields with row data
            const row = button.closest('tr');
            document.getElementById('editName').value = row.cells[0].innerText;
            document.getElementById('editPhoto').value = row.cells[1].querySelector('img').src;
            document.getElementById('editEmail').value = row.cells[2].innerText;
            document.getElementById('editEnrollStart').value = row.cells[3].innerText;
            document.getElementById('editEnrollEnd').value = row.cells[4].innerText;
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