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

if (isset($_POST['ach_submit'])) {
    $semester=$_POST['semester'];
    $event_date=$_POST['eventDate'];
    $event=$_POST['eventName'];
    $description=$_POST['description'];

    try
    {
       
            $stmt = mysqli_query($conn, "insert into stud_achieve(enroll_no, semester, event_date, event, description) values('$enroll','$semester','$event_date','$event','$description')");

            echo "<script>alert('Data Saved Successfully!!');</script>";
       
    }
    catch(mysqli_sql_exception $e)
    {
        echo "". $e->getMessage() ."";
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

        .content .active {
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
        <div class="row mb-4">
            <div class="col-md-10">
                <button class="btn btn-primary mr-2 active" onclick="showContent('achievements')">My Achievements</button>
            </div>
            <div class="col-md-2 text-right">
                <button class="btn btn-secondary" onclick="showContent('addAchievementForm')">Add New Achievement</button>
            </div>
        </div>
        <div id="achievements" class="content active">
            <h2 class="text-dark">Achievements</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-custom">
                        <tr>
                            <th>Semester</th>
                            <th>Event Date</th>
                            <th>Event Name</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamically filled with user's achievements -->
                        <tr>
                            <td>Spring 2023</td>
                            <td>2023-05-15</td>
                            <td>CVMU GYANOSTAV</td>
                            <td>Awarded 2nd place in coding competition.</td>
                        </tr>
                        <tr>
                            <td>Fall 2022</td>
                            <td>2022-11-20</td>
                            <td>GREEN BUSINESS</td>
                            <td>Participated in the sustainability project presentation.</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
        <div id="addAchievementForm" class="content">
            <h2 class="text-dark">Add New Achievement</h2>
            <form method="post">
                <div class="container-fluid pt-4">
                    <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-9 col-xl-7 w-70">
                            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                <div class="card-body p-4 p-md-5">

                                    <div class="row">
                                        <div class="col-md-6 mb-6 ">
                                            <div class="form-group form-check-inline">
                                                <label for="semester" class="text-dark">Semester</label>
                                                <input type="text" class="form-control" id="semester" name="semester">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-6 ">
                                            <div class="form-group form-check-inline">
                                                <label for="eventDate" class="text-dark">Event Date</label>
                                                <input type="date" class="form-control" id="eventDate" name="eventDate">
                                                <br>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="eventName" class="text-dark">Event Name</label>
                                            <select class="form-control" id="eventName" name="eventName">
                                                <option value="CVMU GYANOSTAV">CVMU GYANOSTAV</option>
                                                <option value="CVMU HACKATHON">CVMU HACKATHON</option>
                                                <option value="GREEN BUSINESS">GREEN BUSINESS</option>
                                                <option value="BBIC">BBIC</option>
                                                <option value="other">Other</option>
                                            </select><br>
                                            <input type="text" class="form-control mt-2" id="otherEventName" name="otherEventName" placeholder="Enter other event name" style="display: none;">
                                        </div>
                                        <div class="form-group">
                                            <label for="description" class="text-dark">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <br>
                                            <button type="submit" class="btn btn-primary btn-md float-end" name="ach_submit">Submit</button>
                                        </div>
            </form>
        </div>

    </div>


    <!-- MAIN STUDENT JS -->
    <script src="../assets/js/main.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            const eventNameDropdown = document.getElementById('eventName');
            const otherEventNameInput = document.getElementById('otherEventName');

            eventNameDropdown.addEventListener('change', function() {
                if (this.value === 'other') {
                    otherEventNameInput.style.display = 'block';
                } else {
                    otherEventNameInput.style.display = 'none';
                }
            });
        });

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