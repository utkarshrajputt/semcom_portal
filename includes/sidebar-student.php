<header class="header" id="header">

    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i></div>
    <div class="logos" style="margin-left:-100px;">
        <img src="../assets/images/cvmu-logo.png" alt="cvmu" height="50px" width="170px">
        <img src="../assets/images/semcom-logo.png" alt="cvmu" height="50px" width="170px">
    </div>
    <p class="h4" style="color:#1865A1;font-weight:bolder;padding-right:5%;">SEMCOMITE Student Corner</p>
    


    <b><div id="link-title">Enroll : <?php echo $enroll; ?></b>
    <?php
                        echo '<p class="mb-1" id="datetime">';
                        date_default_timezone_set("Asia/Kolkata");
                        echo  date('d-M-Y , h:i')  ;
                        ?>
                        </div>
</header>
<br>
<p class="sem" style="color:#1865A1;font-weight:bolder;padding-left:20%;">SEMCOMITE Student Corner</p>
<div class="l-navbar" id="nav-bar" style="background-color:#1865A1;">
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
                <a href="../student/dashboard.php" class="nav_link">
                    <i class="fa-solid fa-address-card"></i>
                    <span class="nav_name">Profile</span>
                </a>
            </div>
            <div class="nav_list">
                <!-- PERSONAL DETAILS -->
                <a href="../student/counsel.php" class="nav_link">
                <i class="fa-solid fa-headset"></i>
                    <span class="nav_name">Counselling</span>
                </a>
            </div>

            <div class="nav_list">
                <!-- PERSONAL DETAILS -->
                <a href="../student/result.php" class="nav_link">
                    <i class="fa-solid fa-chart-bar"></i>
                    <span class="nav_name">Result</span>
                </a>
            </div>
            <div class="nav_list">
                <!-- PERSONAL DETAILS -->
                <a href="../student/achievement.php" class="nav_link">
                    <i class="fa-solid fa-trophy"></i>
                    <span class="nav_name">Achievements</span>
                </a>
            </div>
            <div class="nav_list">
                <!-- PERSONAL DETAILS -->
                <a href="../student/attendance.php" class="nav_link">
                <i class="fa-solid fa-address-book"></i>
                    <span class="nav_name">Attendance Report</span>
                </a>
            </div>
            <div class="nav_list">
                <!-- PERSONAL DETAILS -->
                <a href="../student/changepass.php" class="nav_link">
                    <i class="fa-solid fa-user-lock"></i>
                    <span class="nav_name">Change Password</span>
                </a>
            </div>
        </div>

        <a class="lg" href="../includes/s_logout.php" onclick="return confirm('Do you really want to Logout?');"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
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