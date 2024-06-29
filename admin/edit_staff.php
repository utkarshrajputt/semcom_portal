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
        $id = $_POST["editstaff_id"];
        $prefix = $_POST["editprefix"];
        $full_name = $_POST["editname"];
        $gender = $_POST["editgender"];
        $dob = $_POST["editdob_date"];
        $doj = $_POST["editjoin_date"];
        $mob = $_POST["editphone"];
        $h_qual = $_POST["editHi_qualify"];
        $exp = $_POST["editexperience"];
        $skills = $_POST["editskills"];
        $qual = $_POST["editqualify"];
        $staff_email = $_POST["editclg_email"];
        $pass = $_POST["editclg_pass"];

        try {
            if (isset($_FILES['editpfp']) && $_FILES['editpfp']["name"]!='') {

                $data=mysqli_fetch_assoc(mysqli_query($conn,"select staff_img from staff_dtl where staff_id='$id'"));
                if(isset($data["staff_img"])) {
                $file_path="../assets/images/staff_images/".$data["staff_img"];
                if (file_exists($file_path)) {
                    // Attempt to delete the file
                    if (unlink($file_path)) {
                        $uploads_dir = '../assets/images/staff_images/';
                        $tmp_name = $_FILES["editpfp"]["tmp_name"];
                        $name = basename($_FILES["editpfp"]["name"]);
                        $file = $uploads_dir . $name;

                        if ($file == '../assets/images/staff_images/') {
                            echo "<script>alert('Upload Image Again')</script>";
                        } else {
                            $temp = explode(".", $_FILES["editpfp"]["name"]);
                            $extension = end($temp);
                            $filename = substr($_POST['editname'], 0, strpos($_POST['editname'], ' ')) . date('YmdHis') . "." . $extension;
                            $move = move_uploaded_file($tmp_name, "$uploads_dir/$filename");

                            if ($move == true) {
                                $stmt = mysqli_query($conn, "UPDATE staff_dtl SET prefix='$prefix',full_name='$full_name',gender='$gender',dob='$dob',doj='$doj',mob_no='$mob',hi_qualification='$h_qual',exp='$exp',skills='$skills',qualifications='$qual',clg_email='$staff_email',password='$pass',staff_img='$filename' WHERE staff_id='$id'");
                                echo "<script>alert('Data Updated Successfully!!');</script>";
                            }
                        }
                    }
                }
            } 
        }else {
            $stmt = mysqli_query($conn, "UPDATE staff_dtl SET prefix='$prefix',full_name='$full_name',gender='$gender',dob='$dob',doj='$doj',mob_no='$mob',hi_qualification='$h_qual',exp='$exp',skills='$skills',qualifications='$qual',clg_email='$staff_email',password='$pass' WHERE staff_id='$id'");
                echo "<script>alert('Data Updated Successfully!!');</script>";
            }
        } catch (mysqli_sql_exception $e) {
            echo "" . $e->getMessage() . "";
        }
    }
    if (isset($_POST["btn_delete"])) {
        $id=$_POST['editstaff_id'];
        try {
            $stmt = mysqli_query($conn, "delete from staff_dtl where staff_id='$id'");

            echo "<script>alert('Data Deleted Successfully!!');</script>";
        } catch (mysqli_sql_exception $e) {
            echo '' . $e->getMessage() . '';
        }
    }
    ?>

    <div class="container mt-5">
    <h2 class="text-center" style="font-weight:bolder;">Edit Staff Details</h2><br>

        <div id="searchBox" class="mb-3 d-flex justify-content-end">
            <input type="text" class="form-control w-50 me-2" id="searchInput" placeholder="Search...">
            <button class="btn btn-info" onclick="searchTable()">Search</button>
        </div>

        <div id="displayTable" class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light text-center">
                    <tr>
                        <th>Edit</th>
                        <th>Staff Id</th>
                        <th>Prefix</th>
                        <th>Full Name</th>
                        <th>Gender</th>
                        <th>Date<br>Of<br>Birth</th>
                        <th>Date<br>Of<br>Join</th>
                        <th>Mobile No.</th>
                        <th>Highest Qualification</th>
                        <th>Experience</th>
                        <th>Skills</th>
                        <th>Qualification</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Photo</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- More rows will be added dynamically here -->
                    <?php
                    $result = $conn->query("SELECT * FROM staff_dtl");
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr class="text-center">
                            <td><button class="btn btn-warning btn-sm" onclick="editRecord(this)">Edit</button></td>
                            <td><?php echo $row['staff_id']; ?></td>
                            <td><?php echo $row['prefix']; ?></td>
                            <td><?php echo $row['full_name']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td><?php echo $row['dob']; ?></td>
                            <td><?php echo $row['doj']; ?></td>
                            <td><?php echo $row['mob_no']; ?></td>
                            <td><?php echo $row['hi_qualification']; ?></td>
                            <td><?php echo $row['exp']; ?></td>
                            <td><?php echo $row['skills']; ?></td>
                            <td><?php echo $row['qualifications']; ?></td>
                            <td><?php echo $row['clg_email']; ?></td>
                            <td><?php echo $row['password']; ?></td>
                            <td><img class="img" id="img<?php echo $row['staff_id']; ?>" src="../assets/images/staff_images/<?php echo $row['staff_img'] ?>" width="100" height="100"></td>
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
                    <div class="col-md-2">
                        <!-- ROLL NUMBER -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label">Staff Id</label>
                            <input type="text" id="editstaff_id" name="editstaff_id" class="form-control form-control-md" required readonly />
                            <div class="invalid-feedback">Please fill staff_id !</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <!-- ROLL NUMBER -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="roll">Prefix</label>
                            <select id="editprefix" name="editprefix" class="form-control form-control-md" required>
                                <option value="" disabled selected hidden>- Prefix -</option>
                                <option>Mrs.</option>
                                <option>Ms.</option>
                                <option>Mr.</option>
                                <option>Dr.</option>
                                <option>Er.</option>
                            </select>
                            <div class="invalid-feedback">Please Select Prefix !</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- SPID -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="spid">Full Name</label>
                            <input type="text" id="editname" name="editname" class="form-control form-control-md" required />
                            <div class="invalid-feedback">Please fill full name !</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <!-- GENDER -->
                        <h6 class="pb-1">Gender:</h6>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="editgender" name="editgender" value="male" required />
                            <label class="form-check-label" for="maleGender">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="editgender" name="editgender" value="female" required />
                            <label class="form-check-label" for="femaleGender">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="editgender" name="editgender" value="other" required />
                            <label class="form-check-label" for="otherGender">Other</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2">

                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="ad_date">Date of Birth</label>
                            <input type="Date" id="editdob_date" name="editdob_date" class="form-control form-control-md" required />
                            <div class="invalid-feedback">Please select the date !</div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="ad_date">Date of Joining</label>
                            <input type="Date" id="editjoin_date" name="editjoin_date" class="form-control form-control-md" required />
                            <div class="invalid-feedback">Please select the date !</div>
                        </div>
                    </div>
                </div>


                <div class="row mt-2">
                    <div class="col-md-6 pb-2">
                        <!-- PHONE NUMBER -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="phoneNumber">Phone Number</label>
                            <input type="text" id="editphone" name="editphone" class="form-control form-control-md" pattern="\d{10}" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required />
                            <div class="invalid-feedback">Please fill phone number !</div>
                        </div>
                    </div>
                    <div class="col-md-6 pb-2">
                        <!-- EMAIL -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="emailAddress">Highest Qualifaction</label>
                            <select id="editHi_qualify" name="editHi_qualify" class="form-control form-control-md" required>
                                <option value="" disabled selected hidden>- Select -</option>
                                <option>Graduate</option>
                                <option>Post Graduate</option>
                                <option>Ph.D</option>
                            </select>
                            <div class="invalid-feedback">Please Select Highest Qualifaction !</div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 pb-2">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="emailAddress">Skills</label>
                            <input type="text" id="editskills" name="editskills" pattern="[A-Za-z0.9\ ]*" oninput="this.value=this.value.replace(/[^A-Za-z0-9\ ]/g,'');" class="form-control form-control-md" required />
                            <div class="invalid-feedback">Please fill Skills !</div>
                        </div>

                    </div>
                    <div class="col-md-4 pb-2">
                        <!-- EMAIL -->
                        <div data-mdb-input-init class="form-outline">

                            <label class="form-label" for="phoneNumber">Experience</label>
                            <input type="text" id="editexperience" name="editexperience" pattern="[A-Za-z0-9\ \-]*" oninput="this.value=this.value.replace(/[^A-Za-z0-9\ \-]/g,'');" class="form-control form-control-md" required />
                            <div class="invalid-feedback">Please fill Experience !</div>
                        </div>
                    </div>
                    <div class="col-md-4 pb-2">
                        <!-- EMAIL -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="emailAddress">Qualifaction</label>
                            <input type="text" id="editqualify" name="editqualify" pattern="[A-Za-z\ ]*" oninput="this.value=this.value.replace(/[^A-Za-z\ ]/g,'');" class="form-control form-control-md" required />
                            <div class="invalid-feedback">Please fill Qualifaction !</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 pb-2">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="aadhar">Email</label>
                            <input type="email" id="editclg_email" name="editclg_email" class="form-control form-control-md" required />
                            <div class="invalid-feedback">Please Enter Valid Email !</div>
                        </div>
                    </div>
                    <div class="col-md-6 pb-2">
                        <!-- ABC ID -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="abc_id">Password</label>
                            <input type="password" id="editclg_pass" name="editclg_pass" class="form-control form-control-md" pattern=".{8,}" required />
                            <div class="invalid-feedback">Password Must Be Minimum 8 Characters !</div>
                        </div>
                    </div>
                </div>
                <div class="row mt-1 pt-2">
                    <div class="col-md-6">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="filelbl">Upload Your Profile Picture</label>
                            <input type="file" id="editpfp" name="editpfp" class="form-control" accept=".jpg, .jpeg" id="inputGroupFile02">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img id="editphoto" src="" width="100" height="120">
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
            document.getElementById('editstaff_id').value = row.cells[1].innerText;
            document.getElementById('editprefix').value = row.cells[2].innerText;
            document.getElementById('editname').value = row.cells[3].innerText;
            var radios = document.getElementsByName('editgender');
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].value === row.cells[4].innerText) {
                    radios[i].checked = true;
                }
            }
            document.getElementById('editdob_date').value = row.cells[5].innerText;
            document.getElementById('editjoin_date').value = row.cells[6].innerText;
            document.getElementById('editphone').value = row.cells[7].innerText;
            document.getElementById('editHi_qualify').value = row.cells[8].innerText;
            document.getElementById('editskills').value = row.cells[10].innerText;
            document.getElementById('editexperience').value = row.cells[9].innerText;
            document.getElementById('editqualify').value = row.cells[11].innerText;
            document.getElementById('editclg_email').value = row.cells[12].innerText;
            document.getElementById('editclg_pass').value = row.cells[13].innerText;
            document.getElementById('editphoto').src = document.getElementById('img' + row.cells[1].innerText).src;

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