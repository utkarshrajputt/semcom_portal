<?php
require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require('../includes/fetchTableData.php');
$enroll = $_SESSION['enroll'];

if (!isset($enroll)) {
    header('location:student_login.php');
} else {
    $row=mysqli_fetch_row(mysqli_query($conn,"select complete_register from stud_login where enroll_no=$enroll"));
    $bool=$row[0];
    if($bool=='no')
    {
        header("location:profile_dashboard.php");
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
        .icon-btn{
            background-color:#1865A1;
        }
        .icon-btn:hover{
            background-color:#1D83C4;
        }
    </style>
</head>
<body id="body-pd">
<?php
        require '../includes/sidebar-student.php';
    ?>
    <div id="councelTable" class="table-responsive d-none mt-3">
        <div id="searchBox" class="mb-3 d-flex justify-content-end">
            <input type="text" class="form-control w-50 me-2" id="searchInput2" placeholder="Search...">
            <button class="btn btn-info" onclick="searchTable('councel_body','searchInput2')">Search</button>
        </div>
        <table class="table table-bordered table-hover">
            <thead class="table-light text-center">
            <thead class="table-light">
                <th>Id</th>
                <th>Enroll</th>
                <th>Name</th>
                <th>Student Image</th>
                <th>Councelling Date</th>
                <th>Counselling Of</th>
                <th>Description</th>
            </thead>
            <tbody id="councel_body">
            <?php
                $resultDataResult=mysqli_query($conn, "select * from stud_counsel");
                        if ($resultDataResult->num_rows > 0) {
                            while ($resultData = $resultDataResult->fetch_assoc()) {
                                if($resultData['enroll_no']==$enroll){
                                ?>
                                    <td><?php echo $resultData['c_id']; ?></td>
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
                                    <td><?php echo $resultData['c_date']; ?></td>
                                    <td><?php echo $resultData['counselling_of']; ?></td>
                                    <td><?php echo $resultData['counsel_session_info']; ?></td>
                                    </tr>
                                <?php
                                }
                            }
                        }
                        else
                        {
                            echo "<tr class='text-center'><td colspan='2'>No Data Found in Table</td></tr>";
                        }
                 
                ?>
            </tbody>
        </table>
    </div>

</body>
<script src="../assets/js/main.js"></script>        

</html>