<header class="header" id="header">
    
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i></div>&nbsp;&nbsp;
    
    <!-- <div class="header_img"> <img src="https://i.imgur.com/hczKIze.jpg" alt=""> </div> -->
    <div id="link-title">Enroll : <?php echo $enroll; ?></div>
</header>

<div class="l-navbar" id="nav-bar">
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
                <a href="../student/changepass.php" class="nav_link">
                    <i class="fa-solid fa-user-lock"></i>
                    <span class="nav_name">Change Password</span>
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
                    <span class="nav_name">Achievement</span>
                </a>
            </div>
        </div>
 
    <a class="lg" href="../includes/s_logout.php" onclick="return confirm('Do you really want to Logout?');"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
    </nav>
</div>
<script>
</script>