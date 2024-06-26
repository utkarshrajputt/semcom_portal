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
</body>
<script src="../assets/js/main.js"></script>        

</html>