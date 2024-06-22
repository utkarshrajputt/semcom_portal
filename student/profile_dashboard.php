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
    if($bool=='yes')
    {
        header("location:dashboard.php");
    }
    $personalDetails = fetchData('stud_personal_details', $enroll, $conn);
    $address=fetchData('stud_address', $enroll, $conn);
    $basic_dtl=fetchData('stud_other_details', $enroll, $conn);
    $parent_dtl=fetchData('stud_parents_details', $enroll, $conn);
    $academic_dtl=fetchData('stud_academic_details', $enroll, $conn);

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
        /* Additional CSS */
        .disable-form input, .disable-form select {
            pointer-events: none;
            background: #dddddd;
        }

        .form-navigation-buttons {
            margin-left: 85%;
            padding-bottom: 10px;
        }
        @media screen and (max-width: 1080px) {
            .form-navigation-buttons {
                margin-left: 70%;
            }
        }
        @media screen and (max-width: 586px) {
            .form-navigation-buttons {
                margin-left: 50%;
            }
        }
    </style>
</head>


<body id="body-pd">

    <?php
    require '../includes/sidebar-profile-student.php';
   
        if($personalDetails && $address && $basic_dtl && $parent_dtl && $academic_dtl)  
        {
    ?>
           <form method="post" class="form-navigation-buttons"><input type="submit" name="final" class="btn btn-primary" value="Complete Submission"></form>
    <br>
    <?php
        }
    ?>
    <!-- Form Sections -->
    <div id="dashboard" class="content active text-dark">
        <div class="form-navigation-buttons">
            <button type="button" class="previous-button btn btn-secondary">Previous</button>
            <button type="button" class="next-button btn btn-primary">Next</button>
        </div>
        <h4 class="px-4"><b>Personal Details </b></h4>
        <!-- Personal Details Form -->
        <br>
        <p style="color:red;" class="px-4">Note : Fill the details carefully. Once Submitted it cannot be edited or modified.*</p>
        <?php
        require './forms/personal-details.php';
        ?>

    </div>
    <div id="users" class="content text-dark">
        <div class="form-navigation-buttons">
            <button type="button" class="previous-button btn btn-secondary">Previous</button>
            <button type="button" class="next-button btn btn-primary">Next</button>
        </div>
        <h4 class="px-4"><b>Address </b></h4>
        <!-- Address Form -->
        <br>
        <p style="color:red;" class="px-4">Note : Fill the details carefully. Once Submitted it cannot be edited or modified.*</p>
        <?php
        require './forms/address.php';
        ?>
    </div>
    <div id="messages" class="content text-dark">
        <div class="form-navigation-buttons">
            <button type="button" class="previous-button btn btn-secondary">Previous</button>
            <button type="button" class="next-button btn btn-primary">Next</button>
        </div>
        <h4 class="px-4"><b>Basic Details </b></h4>
        <!-- Basic Details Form -->
        <br>
        <p style="color:red;" class="px-4">Note : Fill the details carefully. Once Submitted it cannot be edited or modified.*</p>
        <?php
        require './forms/basic-details.php';
        ?>
    </div>
    <div id="bookmark" class="content text-dark">
        <div class="form-navigation-buttons">
            <button type="button" class="previous-button btn btn-secondary">Previous</button>
            <button type="button" class="next-button btn btn-primary">Next</button>
        </div>
        <h4 class="px-4"><b>Parents Details </b></h4>
        <!-- Parents Details Form -->
        <br>
        <p style="color:red;" class="px-4">Note : Fill the details carefully. Once Submitted it cannot be edited or modified.*</p>
        <?php
        require './forms/parents-details.php';
        ?>
    </div>
    <div id="files" class="content text-dark">
        <div class="form-navigation-buttons">
            <button type="button" class="previous-button btn btn-secondary">Previous</button>
            <button type="button" class="next-button btn btn-primary">Next</button>
        </div>
        <h4 class="px-4"><b>Academic Details </b></h4>
        <!-- Parents Details Form -->
        <br>
        <p style="color:red;" class="px-4">Note : Fill the details carefully. Once Submitted it cannot be edited or modified.*</p>
        <?php
        require './forms/academic-details.php';
        ?>
    </div>
    <!-- MAIN STUDENT JS -->
    <script src="../assets/js/student.js"></script>
    <script type="text/javascript">
    <?php
        if(!$personalDetails)
        {
            ?>
            document.getElementById('dashboard').classList.add('active');
            <?php            
        }
        else if(!$address) {
            ?>
                document.getElementById('dashboard').classList.remove('active');
                document.getElementById('users').classList.add('active');

            <?php
        }
        else if(!$basic_dtl) {
            ?>
                document.getElementById('dashboard').classList.remove('active');
                document.getElementById('messages').classList.add('active');
            <?php
        }
        else if(!$parent_dtl) {
            ?>
                document.getElementById('dashboard').classList.remove('active');
                document.getElementById('bookmark').classList.add('active');
            <?php
        }
        else if(!$academic_dtl) {
            ?>
                document.getElementById('dashboard').classList.remove('active');
                document.getElementById('files').classList.add('active');
            <?php
        }
    ?>
    </script>

    <?php
        if(isset($_POST['final']))
        {
            $qry=mysqli_query($conn,"update stud_login set complete_register='yes' where enroll_no=$enroll");
            if($qry)
            {
                echo "<script>location.reload(true);</script>";
            }
        }
    ?>
</body>

</html>