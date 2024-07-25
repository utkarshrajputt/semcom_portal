<?php
require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
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
    <style>
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
    <br>
    <h2 class="text-center" style="font-weight:bolder;">Alumni Report</h2>

    <div id="councelTable" class="table-responsive mt-3">

        <div id="searchBox" class="mb-3 d-flex justify-content-end">
            <input type="text" class="form-control w-50 me-2" id="searchInput" placeholder="Search...">
            <button class="btn btn-info" onclick="searchTable()">Search</buttonid>
        </div>
        <div class="container mt-4">
            <form method="post">
                <div class="row mb-3">
                    <div class="col-md-12">
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
                </div>
            </form>
        </div>
        <table class="table table-bordered table-hover text-center">
            <thead class="table-light text-center">
                <thead>
                    <th>Enroll</th>
                    <th>Name</th>
                    <th>Student Image</th>
                    <th>Course</th>
                    <th>Admission<br> Year</th>
                    <th>Action</th>
                </thead>
            <tbody id="councel_body">
                <form method="post" action="../admin/report/pdfData.php">
                    <?php
                    try {
                        require '../config/alumini_db.php';

                        $enrollDtlResult = mysqli_query($conn, "select enroll_no,concat(f_name,' ',m_name,' ',l_name) as full_name,stud_course,adm_date,pro_pic from stud_personal_details");
                        if ($enrollDtlResult->num_rows > 0) {
                            while ($enrollDtl = $enrollDtlResult->fetch_assoc()) {
                    ?>
                                <tr data-course="<?php echo $enrollDtl['stud_course'] ?>">
                                    <td><input type="text" name="alumini_enroll" style="border:0;background:transparent;width:auto;" readonly value="<?php echo $enrollDtl['enroll_no']; ?>"></td>

                                    <td><?php echo $enrollDtl['full_name'] ?></td>
                                    <td>
                                        <?php
                                        $filepath = "../alumini/uploaded_images/" . $enrollDtl['pro_pic'];
                                        echo "<img src='$filepath' width='50' height='50'>";
                                        ?>
                                    </td>
                                    <td><?php echo $enrollDtl['stud_course'] ?></td>
                                    <td><?php echo date('Y', strtotime($enrollDtl['adm_date'])); ?></td>
                                    <td>
                                        <input type="hidden" name="type" value="alumini">
                                        <button type="submit" name="alumini_sub" class="btn btn-primary">GET PDF</button>
                                    </td>
                                </tr>
                    <?php
                            }
                        } else {
                            echo "<tr class='text-center'><td colspan='6'>No Data Found in Table</td></tr>";
                        }
                    } catch (mysqli_sql_exception $e) {
                        echo $e->getMessage();
                        header('location:../config/on_maintainance.php');
                    }
                    ?>
                </form>
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

        function ref() {
            window.location.href = "http://localhost/semcom_portal/admin/admin_dashboard.php";
        }

        function searchTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.getElementById('councel_body').getElementsByTagName('tr');

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