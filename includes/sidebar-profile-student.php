<header class="header" id="header">
    
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    <div class="logos" style="margin-left:-105px;">
        <img src="../assets/images/cvmu-logo.png" alt="cvmu" height="50px" width="170px">
        <img src="../assets/images/semcom-logo.png" alt="cvmu" height="50px" width="170px">
    </div>


    
    <p class="h4 p-5" style="color:#4723D9;font-weight:bolder;padding-right:5%;">SEMCOMITE Profile Registration</p>
    

    <div id="link-title">Enroll : <?php echo $enroll; ?></div>
</header>
<br>
<p class="px-5 mt-2 sem" style="color:#4723D9;font-weight:bolder;">SEMCOMITE Profile Registration</p>

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
                <a href="#" class="nav_link active" data-target="dashboard" data-title="Personal Details">
                    <i class="fa-solid fa-address-card"></i>
                    <span class="nav_name">Personal Details</span>
                </a>
                <!-- ADDRESS -->
                <a href="#" class="nav_link" data-target="users" data-title="Address">
                    <i class="fa-solid fa-house"></i>
                    <span class="nav_name">Address</span>
                </a>
                <!-- BASIC DETAILS -->
                <a href="#" class="nav_link" data-target="messages" data-title="Basic Details">
                    <i class="fa-solid fa-user"></i>
                    <span class="nav_name">Basic Details</span>
                </a>
                <!-- PARENT DETAILS -->
                <a href="#" class="nav_link" data-target="bookmark" data-title="Parents details">
                    <i class="fa-solid fa-people-arrows" style="margin-left:-2px;"></i>
                    <span class="nav_name">Parents details</span>
                </a>
                <!-- ACCADEMIC DETAILS -->
                <a href="#" class="nav_link" data-target="files" data-title="Academic details">
                    <i class="fa-solid fa-book"></i>
                    <span class="nav_name">Academic details</span>
                </a>
                
            </div>
        </div>
 
    <a class="lg" href="../includes/s_logout.php" onclick="return confirm('Do you really want to Logout?');"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
    </nav>
</div>
<script>
</script>