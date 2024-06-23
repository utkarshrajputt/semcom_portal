<?php
require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
$staff_email = $_SESSION['staff_email'];

if (!isset($staff_email)) {
    header('location:staff_login.php');
    exit;
}

if (isset($_POST["counsel_submit"])) {
    $enroll_no = $_POST['enroll_no'];
    $c_date = $_POST['c_date'];
    $counselling_of = $_POST['counselling_of'];
    if ($counselling_of == "Other") {
        $counsel = $_POST['relation-counsel'];
    }
    $counsel_session_info = $_POST['counsel_session_info'];
    if ($_POST['relation-counsel']!="") {
        $insertQuery = "INSERT INTO stud_counsel (enroll_no,c_date,counselling_of,counsel_session_info) VALUES ('$enroll_no', '$c_date', '$counsel', '$counsel_session_info')";
    } else {
        $insertQuery = "INSERT INTO stud_counsel (enroll_no,c_date,counselling_of,counsel_session_info) VALUES ('$enroll_no', '$c_date', '$counselling_of', '$counsel_session_info')";
    }
    $stmt = mysqli_query($conn, $insertQuery);

    if ($stmt) {
        echo "<script>alert('Session added successfully');</script>";
        // echo "<script>location.reload(true);</script>";
    } else {
        echo "<script>alert('Error adding session');</script>";
    }
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
    </style>
</head>

<body id="body-pd">
    <?php require '../includes/sidebar-staff.php'; ?>
    <br>
    <h2 class="text-center" style="font-weight:bolder;">Counseling Summary</h2>
    <br>

    <div id="searchBox" class="mt -2 mb-3 d-flex justify-content-end">
        <input type="text" class="form-control w-50 me-2" id="searchInput" placeholder="Search...">
        <button class="btn btn-info" onclick="searchTable('result_body','searchInput')">Search</button>
    </div>
    <div class="container mt-5">
        <!-- <h3 class="mb-4">Counseling Summary</h3> -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-light">
                    <tr>
                        <th>Enroll No</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Number of Sessions</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="result_body">
                    <?php

                    //Individual Staff Assigned Enrollment nos
                    $selectQuery = "select course,semester,division from staff_class_assign where staff_email='$staff_email'";
                    $selectResult = $conn->query($selectQuery);
                    if ($selectResult->num_rows > 0) {
                        $row = $selectResult->fetch_assoc();
                        $dataResult = mysqli_query($conn, "select class_enroll_start,class_enroll_end from course_class where course_name='" . $row['course'] . "' and class_semester='" . $row['semester'] . "' and class_div='" . $row['division'] . "'");
                        try {
                            $data = $dataResult->fetch_assoc();

                            for ($i = $data['class_enroll_start']; $i <= $data['class_enroll_end']; $i++) {
                                $summaryQuery = "SELECT COUNT(stud_counsel.enroll_no) AS session_count FROM stud_counsel where stud_counsel.enroll_no=$i GROUP BY stud_counsel.enroll_no";
                                $summaryResult = $conn->query($summaryQuery);
                                $summary = $summaryResult->fetch_assoc();

                                $enrollDtlResult = mysqli_query($conn, "select concat(f_name,' ',m_name,' ',l_name) as full_name,pro_pic from stud_personal_details where enroll_no='$i'");
                                $enrollDtl = $enrollDtlResult->fetch_assoc();
                                echo "<tr>";
                                echo "<td>{$i}</td>";

                                echo "<td>";
                                if ($enrollDtlResult->num_rows == 0) {
                                    echo  '<b>STUDENT YET NOT COMPLETED REGISTRATION</b>';
                                } else {
                                    echo $enrollDtl['full_name'];
                                }
                                echo "</td>";

                                echo "<td>";
                                $enrollDtlResult->num_rows > 0 ? $filepath = "../assets/images/uploaded_images/" . $enrollDtl['pro_pic'] : $filepath = '';
                                echo $enrollDtlResult->num_rows > 0 ? "<img src='$filepath' width='50' height='50'>" : '';
                                echo "</td>";
                                echo "<td>";
                                echo $summaryResult->num_rows == 0 ? '0' : $summary['session_count'];
                                echo "</td>";
                                echo $enrollDtlResult->num_rows > 0 ? "<td><button class='btn btn-primary' onclick='showForm(this)'>Add New Session</button></td>" : "<td></td>";
                                echo "</tr>";
                            }
                        } catch (mysqli_sql_exception $e) {
                            echo "<tr class='text-center'><td colspan='2'>Enrollment Not Assigned</td></tr>";
                        }
                    } else {
                        echo "<tr class='text-center'><td colspan='2'>Class Not Assigned</td></tr>";
                    }
                    // Fetch summary data


                    ?>
                </tbody>
            </table>
        </div>

        <!-- <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" onclick="showForm()">Add New Session</button>
        </div> -->

        <div id="sessionForm" class="modal-form d-none">
            <button type="button" class="close-btn" onclick="closeForm('sessionForm')">&times;</button>
            <h5>Add New Session</h5>
            <form method="post" action="" class="councelling-form" novalidate>
                <input type="hidden" name="action" value="addSession">
                <div class="container-fluid pt-4">
                    <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-9 col-xl-7">
                            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-space-between">
                                    <div class="row mb-5">
                                        <h3 style="display: flex; align-items: center; justify-content: center;">Counseling Form</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-outline">
                                                <label for="enroll_no" class="form-label">Enroll No</label>
                                                <input type="text" pattern="\d+" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="15" class="form-control form-control-lg w-100" id="enroll_no" name="enroll_no" required readonly>
                                                <div class="invalid-feedback">Please fill enroll no!</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-outline">
                                                <label for="c_date" class="form-label">Date</label>
                                                <input type="date" class="form-control form-control-lg w-100" id="c_date" name="c_date" required>
                                                <div class="invalid-feedback">Please select date!</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-outline">
                                                <label for="counselling_of" class="form-label">Counseling Of</label>
                                                <select class="form-control form-control-lg" id="counselling_of" name="counselling_of" required>
                                                    <option hidden>-- Select --</option>
                                                    <option value="Students">Students</option>
                                                    <option value="Parents">Parents</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                <div class="invalid-feedback">Please select!</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3" id="relation_div" style="display: none;">
                                            <div class="form-outline">
                                                <label for="counselling_of" class="form-label">Relationship With Student</label>
                                                <input type="text" class="form-control mt-2" id="otherEventName" name="relation-counsel" placeholder="Enter other event name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3" id="otherCouncel" style="display:none;">
                                            <div class="form-outline">
                                                <label for="relationship" class="form-label">Relationship With Student</label>
                                                <input type="text" class="form-control mt-2" id="relationship" name="relationship">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="form-outline">
                                                <label for="counsel_session_info" class="form-label">Brief About Session</label>
                                                <textarea maxlength="100" oninput="this.value = this.value.replace(/^\s+/g, '');" id="counsel_session_info" class="form-control form-control-lg" name="counsel_session_info" rows="3" required></textarea>
                                                <div class="invalid-feedback">Please write in short!</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-3" style="display: flex; justify-content: center;">
                                            <input data-mdb-ripple-init class="btn btn-primary btn-lg" name="counsel_submit" type="submit" value="Save" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div id="modalBackdrop" class="modal-backdrop d-none"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var forms = document.querySelectorAll('.councelling-form');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });

            const eventNameDropdown = document.getElementById('counselling_of');
            const otherEventNameInput = document.getElementById('otherCouncel');
            eventNameDropdown.addEventListener('change', function() {
                if (this.value === 'Other') { // "Other" option
                    otherEventNameInput.style.display = 'block';
                } else {
                    otherEventNameInput.style.display = 'none';
                }
            });
        });

        function showForm(button) {
            var modalBackdrop = document.getElementById('modalBackdrop');
            var sessionForm = document.getElementById('sessionForm');
            modalBackdrop.classList.remove('d-none');
            sessionForm.classList.remove('d-none');

            const row = button.closest('tr');
            document.getElementById('enroll_no').value = row.cells[0].innerText;
        }

        function closeForm(formId) {
            var modalBackdrop = document.getElementById('modalBackdrop');
            var form = document.getElementById(formId);
            modalBackdrop.classList.add('d-none');
            form.classList.add('d-none');
            form.reset();
        }

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
    <script src="../assets/js/main.js"></script>

</body>

</html>