<?php
require('loader.php');
require('../../includes/session.php');
require('../../config/mysqli_db.php');
$staff_email = "";

if (!isset($_SESSION['staff_email'])) {
    header('location:staff_login.php');
    exit();
}else{
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
    if (isset($_POST['basic_submit'])) {
        $id = $_POST['id'];
        $enroll = $_POST["enroll_no"];
        $date = $_POST["birthdate"];
        $bld_grp = $_POST["bloodgroup"];
        $height = $_POST["height"];
        $weight = $_POST["weight"];
        $hobby = $_POST["hobbies"];
        $category = $_POST["category"];
        $religion = $_POST["religion"];
        $eng = "";
        if (!empty($_POST['eng'])) {
            foreach ($_POST['eng'] as $eng_check) {
                $eng = $eng . "," . $eng_check;
            }
        }
        $eng = substr($eng, 1);

        $hindi = "";
        if (!empty($_POST['hindi'])) {
            foreach ($_POST['hindi'] as $hindi_check) {
                $hindi = $hindi . "," . $hindi_check;
            }
        }
        $hindi = substr($hindi, 1);

        $guj = "";
        if (!empty($_POST['guj'])) {
            foreach ($_POST['guj'] as $guj_check) {
                $guj = $guj . "," . $guj_check;
            }
        }
        $guj = substr($guj, 1);

        $other = $_POST["other"];


        try {

            $stmt = mysqli_query($conn, "UPDATE stud_other_details SET enroll_no='$enroll',dob='$date',blood_grp='$bld_grp',stud_height='$height',stud_weight='$weight',stud_hobbies='$hobby',stud_category='$category',stud_religion='$religion',eng_know='$eng',hindi_know='$hindi',guj_know='$guj',other_know='$other' WHERE other_id='$id'");
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
        <h3 class="mb-4">Edit Student Basic Details</h3>
        <div id="displayTable" class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-light">
                    <tr valign="top">
                        <th></th>
                        <th>ID</th>
                        <th>Enrollment No</th>
                        <th>Full name</th>
                        <th>Roll No</th>
                        <th>Date Of Birth</th>
                        <th>Blood Group</th>
                        <th>Height</th>
                        <th>Weight</th>
                        <th>Hobbies</th>
                        <th>Category</th>
                        <th>Religion</th>
                        <th>English Knowledge</th>
                        <th>Hindi Knowledge</th>
                        <th>Gujarati Knowldge</th>
                        <th>Other Language Knowldge</th>
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
                        
                            $resultDataResult = mysqli_query($conn, "select * from stud_other_details where enroll_no IN ($enroll_list)");
                            if ($resultDataResult->num_rows > 0) {
                                while ($resultData = $resultDataResult->fetch_assoc()) {
                                        $enroll = $resultData['enroll_no'];
                                        $enrollDtlResult = mysqli_query($conn, "select concat(f_name,' ',m_name,' ',l_name) as full_name,roll_no from stud_personal_details where enroll_no='$enroll'");
                                        $enrollDtl = $enrollDtlResult->fetch_assoc();
                    ?>
                                        <td><button class="btn btn-warning btn-sm" onclick="editRecord(this)">Edit</button></td>
                                        <td><?php echo $resultData['other_id']; ?></td>
                                        <td><?php echo $resultData['enroll_no']; ?></td>
                                        <td><?php echo $enrollDtl['full_name']; ?></td>
                                        <td><?php echo $enrollDtl['roll_no']; ?></td>
                                        <td><?php echo $resultData['dob']; ?></td>
                                        <td><?php echo $resultData['blood_grp']; ?></td>
                                        <td><?php echo $resultData['stud_height']; ?></td>
                                        <td><?php echo $resultData['stud_weight']; ?></td>
                                        <td><?php echo $resultData['stud_hobbies']; ?></td>
                                        <td><?php echo $resultData['stud_category']; ?></td>
                                        <td><?php echo $resultData['stud_religion']; ?></td>
                                        <td><?php echo $resultData['eng_know']; ?></td>
                                        <td><?php echo $resultData['hindi_know']; ?></td>
                                        <td><?php echo $resultData['guj_know']; ?></td>
                                        <td><?php echo $resultData['other_know']; ?></td>
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
            <div class="row justify-content-center align-items-center h-100 mt-2">
                <div class="col-12 col-lg-9 col-xl-7 w-100">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <!-- FORM START -->
                            <form class="basic-details-form" novalidate method="post">
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
                                    <div class="col-md-6 mb-4">
                                        <!-- Birth Date -->
                                        <div class="form-outline">
                                            <label class="form-label" for="birthDate">Birth Date</label>
                                            <input type="date" id="dob" name="birthdate" class="form-control form-control-lg" required />
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="category">Blood Group :</label>
                                            <select name="bloodgroup" id="blood_grp" class="form-control form-control-lg" required>
                                                <option value="" disabled selected hidden>-- Select Blood Group --</option>
                                                <option value="O-">O-</option>
                                                <option value="O+">O+</option>
                                                <option value="A-">A-</option>
                                                <option value="A+">A+</option>
                                                <option value="B-">B-</option>
                                                <option value="B+">B+</option>
                                                <option value="AB-">AB-</option>
                                                <option value="AB+">AB+</option>
                                            </select>
                                            <div class="invalid-feedback">Please select blood group!</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Height, Weight, Hobbies -->
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="height">Height (cm)</label>
                                            <input type="text" id="height" name="height" class="form-control form-control-lg" maxlength="7" pattern="[0-9.]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\./g, '$1');" required />
                                            <div class="invalid-feedback">Please fill height !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="weight">Weight (kg)</label>
                                            <input type="text" id="weight" name="weight" class="form-control form-control-lg" maxlength="7" pattern="[0-9.]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\./g, '$1');" required />
                                            <div class=" invalid-feedback">Please fill weight !
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="hobbies">Hobbies</label>
                                            <input type="text" id="hobbies" name="hobbies" class="form-control form-control-lg" required />
                                            <div class="invalid-feedback">Please fill hobbies with comma ( , ) !</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Category, Religion, Caste -->
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="category">Category : </label>
                                            <select name="category" id="category" class="form-control form-control-lg" required>
                                                <option value="" disabled selected hidden>-- Select Category --</option>
                                                <option value="general">General</option>
                                                <option value="sc">SC</option>
                                                <option value="st">ST</option>
                                                <option value="obc">OBC</option>
                                            </select>
                                            <div class="invalid-feedback">Please select category !</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="religion">Religion :</label><br>
                                            <select name="religion" id="religion" class="form-control form-control-lg" required>
                                                <option value="" disabled selected hidden>-- Select Category --</option>
                                                <option value="Hinduism">Hindu</option>
                                                <option value="Christianity">Christianity</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Jainism">Jainism</option>
                                                <option value="Secular">Secular</option>
                                                <option value="Sikhism">Sikhism</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <div class="invalid-feedback">Please select religion !</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Language You Know -->
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <h6>Language You Know</h6><br>
                                        <div class="col mb-4 d-flex gap-5">
                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="lastName">English</label><br>
                                                <input type="checkbox" class="eng" name="eng[]" value="Read" class="form-check-input">
                                                <label class="form-label">Read</label><br>
                                                <input type="checkbox" class="eng" name="eng[]" value="Write" class="form-check-input">
                                                <label class="form-label">Write</label><br>
                                                <input type="checkbox" class="eng" name="eng[]" value="Speak" class="form-check-input">
                                                <label class="form-label">Speak</label>
                                            </div>

                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="lastName">Hindi</label><br>
                                                <input type="checkbox" name="hindi[]" value="Read" class="form-check-input">
                                                <label class="form-label">Read</label><br>
                                                <input type="checkbox" name="hindi[]" value="Write" class="form-check-input">
                                                <label class="form-label">Write</label><br>
                                                <input type="checkbox" name="hindi[]" value="Speak" class="form-check-input">
                                                <label class="form-label">Speak</label>
                                            </div>

                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="lastName">Gujarati</label><br>
                                                <input type="checkbox" name="guj[]" value="Read" class="form-check-input">
                                                <label class="form-label">Read</label><br>
                                                <input type="checkbox" name="guj[]" value="Write" class="form-check-input">
                                                <label class="form-label">Write</label><br>
                                                <input type="checkbox" name="guj[]" value="Speak" class="form-check-input">
                                                <label class="form-label">Speak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Other Languages -->
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="otherLanguage">Other Language</label>
                                            <input type="text" id="other" name="other" class="form-control form-control-lg" required" />
                                            <div class="invalid-feedback">Write NA if not !</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="row mt-4 pt-1">
                                    <div class="col">
                                        <input class="btn btn-primary btn-lg" name="basic_submit" type="submit" value="Save" />
                                    </div>
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
            document.getElementById('dob').value = row.cells[5].innerText;
            document.getElementById('blood_grp').value = row.cells[6].innerText;
            document.getElementById('height').value = row.cells[7].innerText;
            document.getElementById('weight').value = row.cells[8].innerText;
            document.getElementById('hobbies').value = row.cells[9].innerText;
            document.getElementById('category').value = row.cells[10].innerText;
            document.getElementById('religion').value = row.cells[11].innerText;

            var engValues = row.cells[12].innerText;
            var hindiValues = row.cells[13].innerText;
            var gujValues = row.cells[14].innerText;

            function checkCheckboxes(category, values) {
                var valueArray = values.split(',');
                valueArray.forEach(function(value) {
                    var checkbox = document.querySelector('input[name="' + category + '[]"][value="' + value + '"]');
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });
            }

            // Check checkboxes for each language category
            checkCheckboxes('eng', engValues);
            checkCheckboxes('hindi', hindiValues);
            checkCheckboxes('guj', gujValues);
            document.getElementById('other').value = row.cells[15].innerText;

        }

        function closeForm(formId) {
            document.getElementById('displayTable').classList.remove('blur-background');
            document.getElementById(formId).classList.add('d-none');
            document.getElementById('modalBackdrop').classList.add('d-none');
        }

        document.addEventListener('DOMContentLoaded', function() {
            var forms = document.querySelectorAll('.basic-details-form');
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