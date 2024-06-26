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
    <link rel="stylesheet" href="../assets/css/admin.css">
    <script>
        //js edit course,sem,div filter
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('course').addEventListener('change', function() {
                var course = this.value;
                if (course) {
                    fetchOptions('semesters', {
                        course: course
                    });
                } else {
                    resetDropdown('semester');
                    resetDropdown('division');
                }
            });

            document.getElementById('semester').addEventListener('change', function() {
                var course = document.getElementById('course').value;
                var semester = this.value;
                if (semester) {
                    fetchOptions('divisions', {
                        course: course,
                        semester: semester
                    });
                } else {
                    resetDropdown('division');
                }
            });

            function fetchOptions(type, data) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '', true); // Change to your backend endpoint
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (this.status == 200) {
                        if (type == 'semesters') {
                            updateDropdown('semester', this.responseText);
                            resetDropdown('division');
                        } else if (type == 'divisions') {
                            updateDropdown('division', this.responseText);
                        }
                    }
                };
                var params = 'fetch=' + type + '&' + new URLSearchParams(data).toString();
                xhr.send(params);
            }

            function updateDropdown(dropdownId, optionsHtml) {
                var dropdown = document.getElementById(dropdownId);
                dropdown.innerHTML = optionsHtml;
                dropdown.disabled = false;
            }

            function resetDropdown(dropdownId) {
                var dropdown = document.getElementById(dropdownId);
                dropdown.innerHTML = '<option value="">--Select--</option>';
                dropdown.disabled = true;
            }
        });

        //js assign course,sem,div filter
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('add_course').addEventListener('change', function() {
                var course = this.value;
                if (course) {
                    fetchOptions('semesters', {
                        course: course
                    });
                } else {
                    resetDropdown('add_semester');
                    resetDropdown('add_division');
                }
            });

            document.getElementById('add_semester').addEventListener('change', function() {
                var course = document.getElementById('add_course').value;
                var semester = this.value;
                if (semester) {
                    fetchOptions('divisions', {
                        course: course,
                        semester: semester
                    });
                } else {
                    resetDropdown('add_division');
                }
            });

            function fetchOptions(type, data) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '', true); // Change to your backend endpoint
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (this.status == 200) {
                        if (type == 'semesters') {
                            updateDropdown('add_semester', this.responseText);
                            resetDropdown('add_division');
                        } else if (type == 'divisions') {
                            updateDropdown('add_division', this.responseText);
                        }
                    }
                };
                var params = 'fetch=' + type + '&' + new URLSearchParams(data).toString();
                xhr.send(params);
            }

            function updateDropdown(dropdownId, optionsHtml) {
                var dropdown = document.getElementById(dropdownId);
                dropdown.innerHTML = optionsHtml;
                dropdown.disabled = false;
            }

            function resetDropdown(dropdownId) {
                var dropdown = document.getElementById(dropdownId);
                dropdown.innerHTML = '<option value="">--Select--</option>';
                dropdown.disabled = true;
            }
        });
    </script>
    <?php
    //php course,sem,div
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['fetch']) && $_POST['fetch'] == 'semesters') {
            $course = $_POST['course'];
            $result = $conn->query("SELECT DISTINCT class_semester FROM course_class WHERE course_name = '$course'");
            $options = '<option value="0" disabled selected hidden>--Select--</option>';
            while ($row = $result->fetch_assoc()) {
                $options .= '<option value="' . $row['class_semester'] . '">' . $row['class_semester'] . '</option>';
            }
            echo $options;
            exit();
        }

        if (isset($_POST['fetch']) && $_POST['fetch'] == 'divisions') {
            $course = $_POST['course'];
            $semester = $_POST['semester'];
            $result = $conn->query("SELECT DISTINCT class_div FROM course_class WHERE course_name = '$course' AND class_semester = '$semester'");
            $options = '<option value="0" disabled selected hidden>--Select--</option>';
            while ($row = $result->fetch_assoc()) {
                $options .= '<option value="' . $row['class_div'] . '">' . $row['class_div'] . '</option>';
            }
            echo $options;
            exit();
        }
    }
    ?>

</head>

<body id="body-pd">
    <?php
    require '../includes/sidebar-admin.php';
    ?>
    <br>
    <div id="councelTable" class="table-responsive mt-3">
        <div class="d-flex justify-content-end mt-3 mb-3 mx-5">
            <button class="btn btn-info" onclick="ref()">Back To Dashboard</button>
        </div>

        <div id="searchBox" class="mb-3 d-flex justify-content-end">
            <input type="text" class="form-control w-50 me-2" id="searchInput2" placeholder="Search...">
            <button class="btn btn-info" onclick="searchTable('councel_body','searchInput2')">Search</button>
        </div>
        <div class="mt-2 mb-2">
            <form method="post">
                <div class="row">
                    <div class="col-md-1">
                        Course:
                        <select id="course" name="editCourse">
                            <option value="" disabled selected hidden>--Select--</option>
                            <?php
                            $result = $conn->query("SELECT DISTINCT course_name FROM course_class");
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['course_name'] . '">' . $row['course_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-1">
                        Semester:
                        <select id="semester" name="editSemester" disabled>
                            <option value="0" disabled selected hidden>--Select--</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        Division:
                        <select id="division" name="editDivision" disabled>
                            <option value="0" disabled selected hidden>--Select--</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-bordered table-hover text-center">
            <thead class="table-light text-center">
                <thead>
                    <th>Id</th>
                    <th width="50px">Enroll</th>
                    <th width="50px">Name</th>
                    <th>Student Image</th>
                    <th>Course</th>
                    <th>Semester</th>
                    <th>Division</th>
                    <th>Councelling<br> Date</th>
                    <th>Counselling<br> Of</th>
                    <th>Mode<br> Of <br>Counselling</th>
                    <th>Councelling<br> Time</th>
                    <th>Description</th>
                </thead>
            <tbody id="councel_body">
                <?php
                $resultDataResult = mysqli_query($conn, "select * from stud_counsel");
                if ($resultDataResult->num_rows > 0) {
                    while ($resultData = $resultDataResult->fetch_assoc()) {

                        $enroll = $resultData['enroll_no'];
                        $enrollDtlResult = mysqli_query($conn, "select concat(f_name,' ',m_name,' ',l_name) as full_name,stud_course,stud_sem,stud_div,pro_pic from stud_personal_details where enroll_no='$enroll'");
                        $enrollDtl = $enrollDtlResult->fetch_assoc();
                ?>
                        <tr data-course="<?php echo $enrollDtl['stud_course'] ?>" data-semester="<?php echo $enrollDtl['stud_sem'] ?>" data-division="<?php echo $enrollDtl['stud_div'] ?>">
                            <td><?php echo $resultData['c_id']; ?></td>
                            <td><?php echo $resultData['enroll_no']; ?></td>

                            <td><?php echo $enrollDtl['full_name'] ?></td>
                            <td>
                                <?php
                                $filepath = "../assets/images/uploaded_images/" . $enrollDtl['pro_pic'];
                                echo "<img src='$filepath' width='50' height='50'>";
                                ?>
                            </td>
                            <td><?php echo $enrollDtl['stud_course'] ?></td>
                            <td><?php echo $enrollDtl['stud_sem'] ?></td>
                            <td><?php echo $enrollDtl['stud_div'] ?></td>
                            <td><?php echo $resultData['c_date']; ?></td>
                            <td><?php echo $resultData['counselling_of']; ?></td>
                            <td><?php echo $resultData['mode_counsel']; ?></td>
                            <td><?php echo $resultData['c_time']; ?></td>
                            <td><?php echo $resultData['counsel_session_info']; ?></td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr class='text-center'><td colspan='2'>No Data Found in Table</td></tr>";
                }

                ?>
            </tbody>
        </table>
    </div>



    <script>
        document.getElementById('course').addEventListener('change', filterCourse);
        document.getElementById('semester').addEventListener('change', filterSemester);
        document.getElementById('division').addEventListener('change', filterDiv);

        function filterCourse() {
            var course = document.getElementById('course').value;
            var rows = document.querySelectorAll('#councel_body tr');

            rows.forEach(function(row) {
                var rowCourse = row.getAttribute('data-course');
                if ((course === '' || course === rowCourse)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function filterSemester() {
            var course = document.getElementById('course').value;
            var semester = document.getElementById('semester').value;
            var rows = document.querySelectorAll('#councel_body tr');

            rows.forEach(function(row) {
                var rowCourse = row.getAttribute('data-course');
                if ((course === '' || course === rowCourse) &&
                    (semester === '' || semester === rowSemester)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function filterDiv() {
            var course = document.getElementById('course').value;
            var semester = document.getElementById('semester').value;
            var division = document.getElementById('division').value;
            var rows = document.querySelectorAll('#councel_body tr');

            rows.forEach(function(row) {
                var rowCourse = row.getAttribute('data-course');
                var rowSemester = row.getAttribute('data-semester');
                var rowDivision = row.getAttribute('data-division');

                if ((course === '' || course === rowCourse) &&
                    (semester === '' || semester === rowSemester) &&
                    (division === '' || division === rowDivision)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        function ref() {
            window.location.href="http://localhost/semcom_portal/admin/admin_dashboard.php";
        }
       
    </script>
    <script src="../assets/js/main.js"></script>
</body>

</html>