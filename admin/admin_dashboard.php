<?php
require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');
require('../includes/fetchTableData.php');
$admin_email = $_SESSION['admin_email'];

if (!isset($admin_email)) {
    header('location:admin_login.php');
}
try {

    $enrolledQuery = "select count(*) from stud_login";
    $enrolledRersult = mysqli_query($conn, $enrolledQuery);
    $enrolledData = mysqli_fetch_row($enrolledRersult);

    $regQuery = "select count(*) from stud_login where complete_register='yes'";
    $regRersult = mysqli_query($conn, $regQuery);
    $regData = mysqli_fetch_row($regRersult);

    $staffQuery = "select count(*) from staff_dtl";
    $staffRersult = mysqli_query($conn, $staffQuery);
    $staffData = mysqli_fetch_row($staffRersult);

    $courseQuery = "SELECT COUNT(course_name) FROM course_class GROUP BY course_name";
    $courseRersult = mysqli_query($conn, $courseQuery);
    $courseData = mysqli_num_rows($courseRersult);

    $classQuery = "select count(*) from staff_class_assign";
    $classRersult = mysqli_query($conn, $classQuery);
    $classData = mysqli_fetch_row($classRersult);

    $counselQuery = "select count(*) from stud_counsel";
    $counselRersult = mysqli_query($conn, $counselQuery);
    $counselData = mysqli_fetch_row($counselRersult);
} catch (Exception $e) {
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
        .dash-btn,
        .dash-btn:hover {

            border: none;
            background-color: transparent;
        }

        .responsive-img {
            max-width: 100%;
            height: 95%;
            margin-top: -35px;
            margin-left: 40px;
        }

        .dash-btn:focus {
            outline: none;
            box-shadow: none;
        }

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
    <h2 class="text-center" style="font-weight:bolder;">DASHBOARD</h2>


    <br>
    <div id="main-dash" class="row">
        <div class="row">
            <div class="col-md-6">
                <?php require('carousel.php'); ?>

            </div>


            <!-- <img src="../assets/images/semcom-color.png" alt="semcom" class="img-fluid responsive-img"> -->

            <!-- <div class="clock"> 
            <div class="outer-clock-face">

                <div class="marking marking-one"></div>
                <div class="marking marking-two"></div>
                <div class="marking marking-three"></div>
                <div class="marking marking-four"></div>
                <div class="inner-clock-face">

                    <div class="hand hour-hand"></div>
                    <div class="hand min-hand"></div>
                    <div class="hand second-hand"></div>
                    <div class="center-text">SEMCOM</div>
                    <div class="center-text2">
                        

                        <?php
                        echo '<p class="mb-1">' . date('l') . '</p>';
                        echo '<p>' . date('d M Y') . '</p>';
                        ?>
                    </div>
                </div>
            </div>
        </div>  -->
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    <button id="login_btn" class="dash-btn col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-4">Total Enrolled Students</p>
                                <p class="h3 mb-2"><?php echo $enrolledData[0]; ?></p>
                                <p>Total Logins of Stuents</p>
                            </div>
                        </div>
                    </button>
                    <button id="find_btn" class="dash-btn col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-light-danger">
                            <div class="card-body">
                                <p class="mb-4">Total Registered Students</p>
                                <p class="h3 mb-2"><?php echo $regData[0]; ?></p>
                                <p>Students Who Completed Registration</p>
                            </div>
                        </div>
                    </button>
                    <button id="staff_btn" class="dash-btn col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-light-danger">
                            <div class="card-body">
                                <p class="mb-4">Total Staff Members</p>
                                <p class="h3 mb-2"><?php echo $staffData[0]; ?></p>
                                <p>Active Faculty Members</p>
                            </div>
                        </div>
                    </button>
                    <button id="courses_btn" class="dash-btn col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Courses</p>
                                <p class="h3 mb-2"><?php echo $courseData; ?></p>
                                <p>Currently Available Courses</p>
                            </div>
                        </div>
                    </button>
                </div>
                <div class="row">
                    <button id="assign_btn" class="dash-btn col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Class</p>
                                <p class="h3 mb-2"><?php echo $classData[0]; ?></p>
                                <p>Active Classes</p>
                            </div>
                        </div>
                    </button>

                    <button id="councel_btn" class="dash-btn col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-light-danger">
                            <div class="card-body">
                                <p class="mb-4">No of Counselling</p>
                                <p class="h3 mb-2"><?php echo $counselData[0]; ?></p>
                                <p>Completed</p>
                            </div>
                        </div>
                    </button>
                </div>


            </div>
        </div>



        <script>
            document.getElementById('login_btn').addEventListener('click', () => {
                window.location.href = "http://localhost/semcom_portal/admin/edit_student.php";
            });
            document.getElementById('councel_btn').addEventListener('click', () => {
                window.location.href = "http://localhost/semcom_portal/admin/admin_counsel.php";
            });

            document.getElementById('staff_btn').addEventListener('click', () => {
                window.location.href = "http://localhost/semcom_portal/admin/edit_staff.php";
            });
            document.getElementById('assign_btn').addEventListener('click', () => {
                window.location.href = "http://localhost/semcom_portal/admin/assign_class.php";
            });
            document.getElementById('courses_btn').addEventListener('click', () => {
                window.location.href = "http://localhost/semcom_portal/admin/assign_class.php";
            });
            document.getElementById('find_btn').addEventListener('click', () => {
                window.location.href = "http://localhost/semcom_portal/admin/find_student.php";
            });
            const secondHand = document.querySelector('.second-hand');
            const minsHand = document.querySelector('.min-hand');
            const hourHand = document.querySelector('.hour-hand');

            function setDate() {
                const now = new Date();

                const seconds = now.getSeconds();
                const secondsDegrees = ((seconds / 60) * 360) + 90;
                secondHand.style.transform = `rotate(${secondsDegrees}deg)`;

                const mins = now.getMinutes();
                const minsDegrees = ((mins / 60) * 360) + ((seconds / 60) * 6) + 90;
                minsHand.style.transform = `rotate(${minsDegrees}deg)`;

                const hour = now.getHours();
                const hourDegrees = ((hour / 12) * 360) + ((mins / 60) * 30) + 90;
                hourHand.style.transform = `rotate(${hourDegrees}deg)`;
            }

            setInterval(setDate, 1000);

            setDate();
        </script>


        <!-- MAIN STUDENT JS -->
        <script src="../assets/js/main.js"></script>

</body>

</html>