<?php
// require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require('../includes/fetchTableData.php');
$admin_email = $_SESSION['admin_email'];

if (!isset($admin_email)) {
    header('location:admin_login.php');
}
?>
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

    if (isset($_POST['fetch']) && $_POST['fetch'] == 'fetchData') {
        $course = $_POST['course'];
        $semester = $_POST['semester'];
        $division = $_POST['division'];
        $dataResult = mysqli_query($conn, "select class_enroll_start,class_enroll_end from course_class where course_name='" . $course . "' and class_semester='" . $semester . "' and class_div='" . $division . "'");
        try {
            $data = $dataResult->fetch_assoc();
            echo $data["class_enroll_start"] . "," . $data["class_enroll_end"];
            exit();
        } catch (mysqli_sql_exception $e) {
            echo "";
            exit();
        }
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
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .nav_link {
            margin-bottom: 20px;
        }

        .dropdown {
            margin-top: 25px;
            padding-top: 15px;
        }
    </style>
    <script>
        function assignEnroll(start, end) {
            if (start === '' || end === '') {
                document.getElementById('startId').value = '';
                document.getElementById('endId').value = '';
            } else {
                document.getElementById('startId').value = start;
                document.getElementById('endId').value = end;

                document.getElementById('pdfDiv').removeClassList
            }
        }
        //js edit course,sem,div filter
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('course').addEventListener('change', function() {
                var course = this.value;
                if (course) {
                    document.getElementById('fetchBtn').style = "pointer-events:none;background-color:grey;";
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
                        } else if (type == 'fetchData') {
                            if (this.responseText != ',') {
                                var enrollStart = (this.responseText).substr(0, (this.responseText).indexOf(','));
                                var enrollEnd = (this.responseText).substr((this.responseText).indexOf(',')+1);
                                assignEnroll(enrollStart, enrollEnd);
                            }else{
                                alert('No Enrollments Found');
                            }
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

            document.getElementById('fetchBtn').addEventListener('click', function() {
                var course = document.getElementById('course').value;
                var semester = document.getElementById('semester').value;
                var division = document.getElementById('division').value;
                fetchOptions('fetchData', {
                    course: course,
                    semester: semester,
                    division: division
                })
            });
        });
    </script>

</head>

<body id="body-pd">
    <?php
        require '../includes/sidebar-admin.php';
    ?>
    <br>
    <div id="reportTable" class="table-responsive mt-3">
        <div class="d-flex justify-content-end mt-3 mb-3">
            <button class="btn btn-info" onclick="ref()"><i class="fa-solid fa-arrow-left-long"></i> Back To Dashboard</button>
        </div>

        <div id="searchBox" class="mb-3 d-flex justify-content-end">
            <input type="text" class="form-control w-50 me-2" id="searchInput" placeholder="Search...">
            <button class="btn btn-info" onclick="searchTable()">Search</button>
        </div>
        <div class="container mt-4">
            <form method="post">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="course" class="form-label">Course:</label>
                        <select id="course" name="course" class="form-control">
                            <option value="" disabled selected hidden>--Select--</option>
                            <?php
                            $result = $conn->query("SELECT DISTINCT course_name FROM course_class");
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['course_name'] . '">' . $row['course_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="semester" class="form-label">Semester:</label>
                        <select id="semester" name="semester" class="form-control" disabled>
                            <option value="" disabled selected hidden>--Select--</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="division" class="form-label">Division:</label>
                        <select id="division" name="division" class="form-control" disabled>
                            <option value="" disabled selected hidden>--Select--</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-info mt-4" id="fetchBtn" type="button" style="pointer-events:none;background-color:grey;">Fetch</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    

    <?php
        require ('admin_pdf.php');
    ?>


    <script>



        document.getElementById('course').addEventListener('change', filterCheck);
        document.getElementById('semester').addEventListener('change', filterCheck);
        document.getElementById('division').addEventListener('change', filterCheck);
        function filterCheck() {
            var course = document.getElementById('course').value;
            var semester = document.getElementById('semester').value;
            var division = document.getElementById('division').value;
            if (course === '' || semester === '' || division === '') {
                document.getElementById('fetchBtn').style = "pointer-events:none;background-color:grey;";
            } else {
                document.getElementById('fetchBtn').style = "pointer-events:auto;background-color:lightblue;";
            }
        }

        function ref() {
            window.location.href = "http://localhost/semcom_portal/admin/admin_dashboard.php";
        }

        function searchTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.getElementById('student_body').getElementsByTagName('tr');

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