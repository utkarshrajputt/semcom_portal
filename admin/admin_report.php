<?php
// require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require('../includes/fetchTableData.php');
$admin_email = $_SESSION['admin_email'];

if (!isset($admin_email)) {
    header('location:admin_login.php');
    exit();
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
            $start = $data["class_enroll_start"];
            $end = $data["class_enroll_end"];

            $options = "<option value='' disabled hidden selected>--Select--</option>";

            for ($i = $start; $i <= $end; $i++) {
                $enrollDtlResult = mysqli_query($conn, "SELECT roll_no, CONCAT(f_name, ' ', m_name, ' ', l_name) AS full_name FROM stud_personal_details WHERE enroll_no='$i'");
                if ($enrollDtlResult->num_rows > 0) {
                    $enrollDtl = $enrollDtlResult->fetch_assoc();
                    $options .= "<option value='" . $i . "'>" . $enrollDtl['roll_no'] . "-" . $enrollDtl['full_name'] . "</option>";
                }
            }
        } catch (mysqli_sql_exception $e) {
            $options .= "<option value='' disabled>Error: " . $e->getMessage() . "</option>";
        }
        echo $options;
        exit();
    }
    if (isset($_POST['fetch']) && $_POST['fetch'] == 'fetchDataExcel') {
        $course = $_POST['course'];
        $semester = $_POST['semester'];
        $division = $_POST['division'];

        $dataResult = mysqli_query($conn, "SELECT class_enroll_start, class_enroll_end FROM course_class WHERE course_name='$course' AND class_semester='$semester' AND class_div='$division'");
        $data = $dataResult->fetch_assoc();

        $start = $data["class_enroll_start"];
        $end = $data["class_enroll_end"];

        echo json_encode(['start' => $start, 'end' => $end]);
        exit();
    }
    ob_end_flush();
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
        //js edit course,sem,div filter
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('course').addEventListener('change', function() {
                var course = this.value;
                if (course) {
                    document.getElementById('fetchPDFBtn').style = "pointer-events:none;background-color:grey;";
                    document.getElementById('fetchEXCELBtn').style = "pointer-events:none;background-color:grey;";

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

                            document.getElementById('studentSingle').innerHTML = '';
                            document.getElementById('studentSingle').innerHTML = this.responseText;

                            document.getElementById('studentRangeStart').innerHTML = '';
                            document.getElementById('studentRangeStart').innerHTML = this.responseText;

                            document.getElementById('studentRangeEnd').innerHTML = '';
                            document.getElementById('studentRangeEnd').innerHTML = this.responseText;

                        } else if (type == 'fetchDataExcel') {
                            var data = JSON.parse(this.responseText);
                            var start = data.start;
                            var end = data.end;

                            var enrollStart = document.getElementsByClassName('startEnroll');
                            for (var i = 0; i < enrollStart.length; i++) {
                                enrollStart[i].value = start;
                            }

                            var enrollEnd = document.getElementsByClassName('endEnroll');
                            for (var i = 0; i < enrollEnd.length; i++) {
                                enrollEnd[i].value = end;
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

            document.getElementById('fetchPDFBtn').addEventListener('click', function() {
                var course = document.getElementById('course').value;
                var semester = document.getElementById('semester').value;
                var division = document.getElementById('division').value;

                fetchOptions('fetchData', {
                    course: course,
                    semester: semester,
                    division: division
                })

                document.getElementById('pdfDiv').style.display = "block";
                document.getElementById('excelDiv').style.display = "none";
            });

            document.getElementById('fetchEXCELBtn').addEventListener('click', function() {
                var course = document.getElementById('course').value;
                var semester = document.getElementById('semester').value;
                var division = document.getElementById('division').value;

                fetchOptions('fetchDataExcel', {
                    course: course,
                    semester: semester,
                    division: division
                })

                document.getElementById('excelDiv').style.display = "block";
                document.getElementById('pdfDiv').style.display = "none";
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
        <h2 class="text-center">Student Report</h2>
    
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
                        <button class="btn btn-info mt-4" id="fetchPDFBtn" type="button" style="pointer-events:none;background-color:grey;">Fetch PDF</button>
                        <button class="btn btn-info mt-4" id="fetchEXCELBtn" type="button" style="pointer-events:none;background-color:grey;">Fetch EXCEL</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    
        <?php
            require('report/admin_pdf.php');
        ?>
    
    
        <?php
            require('report/admin_excel.php');
            ob_end_flush();
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
                document.getElementById('fetchPDFBtn').style = "pointer-events:none;background-color:grey;";
                document.getElementById('fetchEXCELBtn').style = "pointer-events:none;background-color:grey;";
            } else {
                document.getElementById('fetchPDFBtn').style = "pointer-events:auto;background-color:lightblue;";
                document.getElementById('fetchEXCELBtn').style = "pointer-events:auto;background-color:lightblue;";
            }
            document.getElementById('pdfDiv').style.display = 'none';
            document.getElementById('excelDiv').style.display = 'none';
        }

        function ref() {
            window.location.href = "http://localhost/semcom_portal/admin/admin_dashboard.php";
        }
    </script>
    <script src="../assets/js/main.js"></script>
</body>

</html>