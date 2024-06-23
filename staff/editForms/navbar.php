<?php 
    $stmt=mysqli_query($conn,"select full_name from staff_dtl where clg_email='$staff_email'");
    $name=mysqli_fetch_assoc($stmt);
?>

<header class="header" id="header" >
    
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i></div>&nbsp;&nbsp;

    <h5 class="h4" style="color:#1865A1;font-weight:bolder;">Hello, <?php echo $name['full_name'] ?></h5>
    
</header>

<div class="l-navbar" id="nav-bar" style="background-color:#4b524e;">
    <!-- close button under 768px screen width -->
    <i class='bx bx-x nav_close-btn' id="nav-close-btn"></i>
    <nav class="nav">
        <div>
            <!-- SEMCOM  -->
            <a href="#" class="nav_logo">
                <img src="../../assets/images/semcom.png" class="img-fluid" style="width: 25px;" alt="">
                <span class="nav_logo-name">SEMCOM</span>
            </a>
            
            <div class="nav_list">
                <!-- PERSONAL DETAILS -->
               
                <a href="../../staff/dashboard.php" class="nav_link">
                    <i class="fa-solid fa-table-columns"></i>
                    <span class="nav_name">Dashboard</span>
                </a>
                <a href="../../staff/counsel.php" class="nav_link">
                    <i class="fa-solid fa-person-chalkboard"></i>
                    <span class="nav_name">Counselling</span>
                </a>
                <a href="../../staff/editForms/personal-details.php" class="nav_link">
                    <i class="fa-solid fa-address-card"></i>
                    <span class="nav_name">Personal Details</span>
                </a>
                <a href="../../staff/editForms/address.php" class="nav_link">
                    <i class="fa-solid fa-house"></i>
                    <span class="nav_name">Address</span>
                </a>
                <a href="../../staff/editForms/basic-details.php" class="nav_link">
                    <i class="fa-solid fa-user"></i>
                    <span class="nav_name">Basic Details</span>
                </a>
                <a href="../../staff/editForms/parents-details.php" class="nav_link">
                    <i class="fa-solid fa-people-arrows" style="margin-left:-2px;"></i>
                    <span class="nav_name">Parents details</span>
                </a>
                <a href="../../staff/editForms/academic-details.php" class="nav_link">
                    <i class="fa-solid fa-book"></i>
                    <span class="nav_name">Academic details</span>
                </a>
            </div>
        </div>
 
    <a class="lg" href="../../includes/staff_logout.php" onclick="return confirm('Do you really want to Logout?');"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
    </nav>
</div>
<script>
</script>