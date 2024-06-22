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
    <?php
        require '../includes/sidebar-staff.php';
    ?>

    <?php
        if (isset($_POST['res_accept'])) {
            $id=$_POST['result_id'];
            $result=mysqli_query($conn,"update stud_result set add_request='accepted' where result_id='$id'");
            if($result)
            {
                echo "<script>alert('Data Updated Successfully!!');</script>";
            }
            else
            {
                echo "<script>alert('Technical Error!!');</script>";
            }
        }
        if (isset($_POST['res_reject'])) {
            $id=$_POST['result_id'];

            $imgResult=mysqli_query($conn,"select result_img from stud_result where result_id='$id'");
            $imgData=mysqli_fetch_array($imgResult);
            $result=mysqli_query($conn,"delete from stud_result where result_id='$id'");
            if($result)
            {

                $file_path="../assets/images/result_images/".$imgData["result_img"];
                if (file_exists($file_path)) {
                    // Attempt to delete the file
                    if (unlink($file_path)) {
                        echo "<script>alert('Data Deleted Successfully!!');</script>";
                    }
                }
                
            }
            else
            {
                echo "<script>alert('Technical Error!!');</script>";
            }
        }
    ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-end mt-3">
            <button id="result_btn" class="btn btn-primary me-2">Result</button>
            <button id="councel_btn" class="btn btn-primary">Councelling</button>
        </div>
    </div>
    <div id="resultTable" class="table-responsive mt-3">
        <div id="searchBox" class="mb-3 d-flex justify-content-end">
            <input type="text" class="form-control w-50 me-2" id="searchInput1" placeholder="Search...">
            <button class="btn btn-info" onclick="searchTable('result_body','searchInput1')">Search</button>
        </div>
        <table class="table table-bordered table-hover text-center">
            <thead class="table-light">
                <th>Id</th>
                <th>Enroll</th>
                <th>Name</th>
                <th>Student Image</th>
                <th>SGPA</th>
                <th>CGPA</th>
                <th></th>
                <th></th>
            </thead>
            <tbody id="result_body">
                <?php
                $selectQuery = "select course,semester,division from staff_class_assign where staff_email='$staff_email'";
                $selectResult = $conn->query($selectQuery);
                if ($selectResult->num_rows > 0) {
                    $row = $selectResult->fetch_assoc();
                    $dataResult = mysqli_query($conn, "select class_enroll_start,class_enroll_end from course_class where course_name='" . $row['course'] . "' and class_semester='" . $row['semester'] . "' and class_div='" . $row['division'] . "'");
                    try {
                        $data = $dataResult->fetch_assoc();

                        $resultDataResult=mysqli_query($conn, "select * from stud_result where add_request='pending'");
                        if ($resultDataResult->num_rows > 0) {
                            while ($resultData = $resultDataResult->fetch_assoc()) {
                                if($resultData['enroll_no']>=$data['class_enroll_start'] && $resultData['enroll_no']<=$data['class_enroll_end']){
                                ?>
                                    <td><?php echo $resultData['result_id']; ?></td>
                                    <td><?php echo $resultData['enroll_no']; ?></td>
                                        <?php
                                        $enroll=$resultData['enroll_no'];
                                        $enrollDtlResult= mysqli_query($conn,"select concat(f_name,' ',m_name,' ',l_name) as full_name,pro_pic from stud_personal_details where enroll_no='$enroll'");
                                        $enrollDtl = $enrollDtlResult->fetch_assoc();                                        
                                        ?>
                                    <td><?php echo $enrollDtl['full_name']?></td>
                                    <td>
                                        <?php
                                            $filepath="../assets/images/uploaded_images/".$enrollDtl['pro_pic'];
                                            echo "<img src='$filepath' width='50' height='50'>";
                                        ?>
                                    </td>
                                    <td><?php echo $resultData['sgpa']; ?></td>
                                    <td><?php echo $resultData['cgpa']; ?></td>
                                    <td>
                                        <?php
                                            $path="../assets/images/result_images/".$resultData['result_img'];
                                            echo "<a href='$path' target='_blank'>View File</a>";
                                        ?>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="hidden" id="result_id" name="result_id" value="<?php echo $resultData['result_id']; ?>">                                                
                                            <button name="res_accept" class='btn btn-primary'>ACCEPT</button>
                                            <button name="res_reject" class='btn btn-danger'>REJECT</button>
                                        </form>
                                    </td>
                                <?php
                                }
                            }
                        }
                        else
                        {
                            echo "<tr class='text-center'><td colspan='2'>No Data Found in Result Table</td></tr>";
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
    <div id="councelTable" class="table-responsive d-none mt-3">
        <div id="searchBox" class="mb-3 d-flex justify-content-end">
            <input type="text" class="form-control w-50 me-2" id="searchInput2" placeholder="Search...">
            <button class="btn btn-info" onclick="searchTable('councel_body','searchInput2')">Search</button>
        </div>
        <table class="table table-bordered table-hover">
            <thead class="table-light text-center">

            </thead>
            <tbody id="councel_body">

            </tbody>
        </table>
    </div>
    <script>
        document.getElementById('councel_btn').addEventListener('click', () => {
            document.getElementById('resultTable').classList.add('d-none');
            document.getElementById('councelTable').classList.remove('d-none');
            // document.getElementById('modalBackdrop').classList.remove('d-none');
        });

        document.getElementById('result_btn').addEventListener('click', () => {
            document.getElementById('resultTable').classList.remove('d-none');
            document.getElementById('councelTable').classList.add('d-none'); // Simulate refresh
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
    <script src="../assets/js/main.js"></script>
</body>

</html>