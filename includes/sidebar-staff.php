<?php
$stmt = mysqli_query($conn, "select full_name from staff_dtl where clg_email='$staff_email'");
$name = mysqli_fetch_assoc($stmt);
?>

<head>
    <style>
        .dropdown {
            color: red;
        }
    </style>
</head>
<header class="header" id="header">

    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i></div>
    <div class="logos" style="margin-left:-135px;">
        <img src="../assets/images/cvmu-logo.png" alt="cvmu" height="50px" width="170px">
        <img src="../assets/images/semcom-logo.png" alt="cvmu" height="50px" width="170px">
    </div>
    <p class="h4" style="color:#1865A1;font-weight:bolder;padding-right:5%;">SEMCOMITE Staff Corner</p>

    <div>
        <h5 class="h4" style="color:#1865A1;font-weight:bolder;">Hello, <?php echo $name['full_name'] ?></h5>
        <?php
        echo '<p class="mb-1" id="datetime">';
        date_default_timezone_set("Asia/Kolkata");
        echo  date('d-M-Y , h:i');
        ?>
    </div>
</header>

<div class="l-navbar" id="nav-bar" style="background-color:#4b524e;">
    <!-- close button under 768px screen width -->
    <i class='bx bx-x nav_close-btn' id="nav-close-btn"></i>
    <nav class="nav">
        <div>
            <!-- SEMCOM  -->
            <a href="#" class="nav_logo">
                <img src="../assets/images/semcom.png" class="img-fluid" style="width: 25px;" alt="">
                <span class="nav_logo-name">SEMCOM</span>
            </a>

            <div class="nav_list">
                <!-- PERSONAL DETAILS -->

                <a href="../staff/dashboard.php" class="nav_link" style="margin-bottom:20px;">
                    <i class="fa-solid fa-table-columns"></i>
                    <span class="nav_name">Dashboard</span>
                </a>
                <a href="../staff/counsel.php" class="nav_link" style="margin-bottom:20px;">
                    <i class="fa-solid fa-person-chalkboard"></i>
                    <span class="nav_name">Counselling</span>
                </a>
                <div class="dropdown">
                    <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                        <i class="fas fa-pencil-alt"></i>
                        <span class="nav_name">Edit Student Detail</span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="../staff/editForms/personal-details.php">
                            <i class="fa-solid fa-address-card"></i>
                            <span class="nav_name">Personal Details</span>
                        </a>
                        <a class="dropdown-item" href="../staff/editForms/address.php">
                            <i class="fa-solid fa-house"></i>
                            <span class="nav_name">Address</span>
                        </a>
                        <a class="dropdown-item" href="../staff/editForms/basic-details.php">
                            <i class="fa-solid fa-user"></i>
                            <span class="nav_name">Basic Details</span>
                        </a>
                        <a class="dropdown-item" href="../staff/editForms/parents-details.php">
                            <i class="fa-solid fa-people-arrows" style="margin-left:-2px;"></i>
                            <span class="nav_name">Parents details</span>
                        </a>
                        <a class="dropdown-item" href="../staff/editForms/academic-details.php">
                            <i class="fa-solid fa-book"></i>
                            <span class="nav_name">Academic details</span>
                        </a>
                    </div>
                </div>
                <a href="../staff/report.php" class="nav_link mt-4" style="margin-left:2px">
                    <i class="fa-solid fa-file-lines"></i>
                    <span class="nav_name">Student Report</span>
                </a>
                <a href="../staff/attendance.php" class="nav_link mt-4">
                    <i class="fa-solid fa-id-card-clip"></i>
                    <span class="nav_name">Attendance</span>
                </a>
                <a href="../staff/attendance_report.php" class="nav_link mt-4">
                    <i class="fa-solid fa-address-book"></i>
                    <span class="nav_name">Attendance Report</span>
                </a>
            </div>
        </div>

        <a class="lg" href="../includes/staff_logout.php" onclick="return confirm('Do you really want to Logout?');"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
    </nav>
</div>
<script>
        function updateTime() {
            const dateElement = document.getElementById('datetime');
            const now = new Date();
            const options = { 
                day: '2-digit', 
                month: 'short', 
                year: 'numeric', 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit', 
                hour12: true 
            };
            const formatter = new Intl.DateTimeFormat('en-IN', options);
            dateElement.textContent = formatter.format(now);
        }

        setInterval(updateTime, 1000);
        updateTime(); // Initial call to set the time immediately on load
    </script>