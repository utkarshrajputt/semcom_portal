<?php 
      require('../includes/loader.php');
      require('../includes/session.php');


        $enroll = $_SESSION['enroll'];

        if(!isset($enroll)){
        header('location:student_login.php');
        }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- BOOTSTRAP & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a79beb4099.js" crossorigin="anonymous"></script>
    
    <!-- BOXICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- MAIN STUDENT CSS -->
    <link rel="stylesheet" href="../assets/css/student.css">

</head>


<body id="body-pd">
<?php require '../includes/sidebar-student.php' ?>

<!-- Container Main start -->
    <div class="height-auto pt-3 pb-5" style="color: black;">
        <!-- PERSONAL DETAILS -->
        <div id="dashboard" class="content active text-dark">
            <h4>Personal Details</h4>
            <?php require './forms/personal-details.php'; ?>
        </div>
        <!-- ADDRSSS -->
        <div id="users" class="content  text-dark">
            <h4>Address</h4>
            <?php require './forms/address.php'; ?>
        </div>
        <!-- BASIC DETAILS -->
        <div id="messages" class="content text-dark">
            <h4>Basic Details</h4>
            <?php require './forms/basic-details.php'; ?>
        </div>
        <!-- PARENTS DETAILS -->
        <div id="bookmark" class="content text-dark">
            <h4>Parents Details</h4>
            <?php require './forms/parents-details.php'; ?>
        </div>
        <!-- ACCEDEMIC DETAILS -->
        <div id="files" class="content text-dark">
            <h4>Academic Details</h4>
            <?php require './forms/academic-details.php'; ?>
        </div>
    </div>
<!-- Container Main end -->

<!-- MAIN STUDENT JS -->
<script src="../assets/js/student.js"></script>

</body>
</html>