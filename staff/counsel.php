<?php
require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require('../includes/fetchTableData.php');
$staff_email = $_SESSION['staff_email'];

if (!isset($staff_email)) {
    header('location:staff_login.php');
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
    </style>
</head>

<body id="body-pd">
    <?php require '../includes/sidebar-staff.php'; ?>

    <h2 class="text-dark"></h2>
            <form method="post" action="" class="councelling-form" novalidate>
                <div class="container-fluid pt-4">
                    <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-9 col-xl-7">
                            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-space-between">
                                    <div class="row mb-5">
                                        <h3 style="display: flex; align-items: center; justify-content: center;">Counselling Form</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-outline">
                                                <label for="roll" class="form-label">Roll No</label>
                                                <input type="text" pattern="\d" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="3" class="form-control form-control-lg w-100" id="semester" name="roll" required>
                                                <div class="invalid-feedback">Please fill roll no !</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-outline">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text"  pattern="[A-Za-z]*" oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');" class="form-control form-control-lg w-100" id="semester" name="name" required>
                                                <div class="invalid-feedback">Please fill name !</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-outline">
                                                <label for="date" class="form-label">Date</label>
                                                <input type="date" class="form-control form-control-lg w-100" id="semester" name="date" required>
                                                <div class="invalid-feedback">Please select date !</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-outline">
                                                <label for="my-select" class="form-label">Councelling Of</label>
                                                <select class="form-control form-control-lg" id="councelName" name="" required>
                                                    <option hidden>-- Select --</option>
                                                    <option>Students</option>
                                                    <option>Parents</option>
                                                    <option>Other</option>
                                                </select>
                                                <div class="invalid-feedback">Please select !</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3" id="otherCouncel" style="display:none;">
                                            <div class="form-outline">
                                                <label for="my-select" class="form-label">Relationship With Student</label>
                                                <input type="text" class="form-control" name="otherCouncel">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="form-outline">
                                                <label for="my-textarea" class="form-label">Brief About Session</label>
                                                <textarea  maxlength="60" oninput="this.value = this.value.replace(/^\s+/g, '');" id="my-textarea" class="form-control form-control-lg" name="" rows="3" required></textarea>
                                                <div class="invalid-feedback">Please write in short !</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-3" style="display: flex; justify-content: center;">
                                        <input data-mdb-ripple-init class="btn btn-primary btn-lg" name="submit" type="submit" value="Save" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

    
    <script src="../assets/js/main.js"></script>
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
            var councellForm = document.querySelectorAll('.councelling-form');
            applyValidation(councellForm);
            
            const eventNameDropdown = document.getElementById('councelName');
            const otherEventNameInput = document.getElementById('otherCouncel');
            console.log(eventNameDropdown);
            eventNameDropdown.addEventListener('change', function() {
                if (this.value === 'Other') {
                    otherEventNameInput.style.display = 'block';
                } else {
                    otherEventNameInput.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>