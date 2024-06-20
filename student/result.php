<?php
require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require('../includes/fetchTableData.php');
$enroll = $_SESSION['enroll'];

if (!isset($enroll)) {
    header('location:student_login.php');
} else {
    $row = mysqli_fetch_row(mysqli_query($conn, "select complete_register from stud_login where enroll_no=$enroll"));
    $bool = $row[0];
    if ($bool == 'no') {
        header("location:profile_dashboard.php");
    }
}

if (isset($_POST['res_submit'])) {
    $semester = $_POST['semester'];
    $course = $_POST['course'];
    $sgpa = $_POST['sgpa'];
    $cgpa = $_POST['cgpa'];

    try {

        if (isset($_FILES['resultFile'])) {
            $uploads_dir = '../assets/images/result_images/';
            $tmp_name = $_FILES["resultFile"]["tmp_name"];
            $name = basename($_FILES["resultFile"]["name"]);
            $file = $uploads_dir . $name;

            if ($file == '../assets/images/result_images/') {
                echo "<script>alert('Upload Image Again')</script>";
            } else {
                $temp = explode(".", $_FILES["resultFile"]["name"]);
                $extension = end($temp);
                $filename = $enroll . "_" . $semester . "." . $extension;
                $move = move_uploaded_file($tmp_name, "$uploads_dir/$filename");

                if ($move == true) {

                    $stmt = mysqli_query($conn, "insert into stud_result(enroll_no, course, semester, sgpa, cgpa, result_img) values('$enroll','$course','$semester','$sgpa','$cgpa','$filename')");


                    echo "<script>alert('Data Saved Successfully!!');</script>";
                }
            }
        }
    } catch (mysqli_sql_exception $e) {
        echo "" . $e->getMessage() . "";
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
        .content {
            display: none;
        }

        .content.active {
            display: block;
        }

        .thead-custom {
            background-color: #f8f9fa;
            /* Change this to your desired color */
        }

        @media (max-width: 450px) {
            .btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
            }
        }
    </style>
</head>

<body id="body-pd">
    <?php
    require '../includes/sidebar-student.php';
    ?>
    <!-- Results Module -->
    <div class="container mt-5 pt-5">
        <div class="d-flex justify-content-end mb-4">
            <button class="btn btn-success add-new" onclick="showAddForm()">Add New</button>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <button class="btn btn-primary mr-2" onclick="showContent('myResults')">My Results</button>
                <button class="btn btn-secondary" onclick="showContent('pendingStatus')">Pending Status</button>
            </div>
        </div>

        <div id="myResults" class="content active">
            <h2 class="text-dark">My Results</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-custom">
                        <tr>
                            <th>Course</th>
                            <th>Semester</th>
                            <th>CGPA</th>
                            <th>SGPA</th>
                            <th>View File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamically filled with user's results -->
                        <?php
                            $stmt = mysqli_query($conn, "select * from stud_result where enroll_no='$enroll' and add_request='accepted' order by semester");
                            while ($data = mysqli_fetch_assoc($stmt)) {
                        ?>
                            <tr>
                                <td><?php echo $data['course']; ?></td>
                                <td><?php echo $data['semester']; ?></td>
                                <td><?php echo $data['cgpa']; ?></td>
                                <td><?php echo $data['sgpa']; ?></td>
                                <td><a href='../assets/images/result_images/<?php echo $data['result_img'] ?>' target="_blank">View</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="pendingStatus" class="content">
            <h2 class="text-dark">Pending Status</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-custom">
                        <tr>
                            <th>Course</th>
                            <th>Semester</th>
                            <th>CGPA</th>
                            <th>SGPA</th>
                            <th>Status</th>
                            <th>View File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamically filled with user's pending results -->
                        <?php
                            $stmt = mysqli_query($conn, "select * from stud_result where enroll_no='$enroll' and add_request='pending' order by semester");
                            while ($data = mysqli_fetch_assoc($stmt)) {
                        ?>
                            <tr>
                                <td><?php echo $data['course']; ?></td>
                                <td><?php echo $data['semester']; ?></td>
                                <td><?php echo $data['cgpa']; ?></td>
                                <td><?php echo $data['sgpa']; ?></td>
                                <td><?php echo $data['add_request']; ?></td>
                                <td><a href='../assets/images/result_images/<?php echo $data['result_img'] ?>' target="_blank">View</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="addResultForm" class="content">
            <h2 class="text-dark">Add New Result</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="container-fluid pt-4">
                    <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-9 col-xl-7 w-70">
                            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                <div class="card-body p-4 p-md-5">

                                    <div class="row">
                                        <div class="col-md-6 mb-6 ">
                                            <div class="form-group form-check-inline">
                                                <label for="course" class="text-dark">Course</label>
                                                <select name="course" class="form-control form-control-lg" required>
                                                    <option value="" disabled selected hidden>-- Select Course --</option>
                                                    <option value="BCA">BCA</option>
                                                    <option value="BCOM">BCOM</option>
                                                    <option value="BBA">BBA</option>
                                                    <option value="BBA-ITM">BBA-ITM</option>
                                                    <option value="MCOM">MCOM</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-6 mb-6">
                                            <div class="form-group form-check-inline">
                                                <label for="semester" class="text-dark">Semester</label>
                                                <input type="text" class="form-control" id="semester" name="semester">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-6">
                                            <div class="form-group form-check-inline">
                                                <label for="cgpa" class="text-dark">CGPA</label>
                                                <input type="text" class="form-control" id="cgpa" name="cgpa">
                                            </div>
                                        </div>


                                        <div class="col-md-6 mb-6">
                                            <div class="form-group form-check-inline">
                                                <label for="sgpa" class="text-dark">SGPA</label>
                                                <input type="text" class="form-control" id="sgpa" name="sgpa">
                                            </div>
                                            <br>
                                            <br>
                                        </div>

                                        <div class="form-group">
                                            <label for="resultFile" class="text-dark">Add File</label>
                                            <input type="file" name="resultFile" class="form-control w-70" accept=".jpg, .jpeg" id="inputGroupFile02" required>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-lg float-end " name="res_submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- MAIN STUDENT JS -->
    <script src="../assets/js/main.js"></script>
    <script>
        function showContent(contentId) {
            var contents = document.getElementsByClassName('content');
            for (var i = 0; i < contents.length; i++) {
                contents[i].classList.remove('active');
            }
            document.getElementById(contentId).classList.add('active');
        }

        function showAddForm() {
            showContent('addResultForm');
        }
    </script>


</body>

</html>