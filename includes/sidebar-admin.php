<header class="header" id="header">

    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i></div>
    <div class="logos" style="margin-left:-135px;">
        <img src="../assets/images/cvmu-logo.png" alt="cvmu" height="50px" width="170px">
        <img src="../assets/images/semcom-logo.png" alt="cvmu" height="50px" width="170px">
    </div>
    <p class="h4" style="color:#1865A1;font-weight:bolder;padding-right:5%;">SEMCOMITE Admin Corner</p>
    <div>
        <h5 class="h4" style="color:#1865A1;font-weight:bolder;">Hello, Admin</h5>
        <?php
        echo '<p class="mb-1" id="datetime">';
        date_default_timezone_set("Asia/Kolkata");
        echo  date('d-M-Y , h:i');
        ?>
    </div>
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
                <a href="../admin/admin_dashboard.php" class="nav_link">
                    <i class="fa-solid fa-table-columns"></i>
                    <span class="nav_name">Dashboard</span>
                </a>
            </div>
            <div class="nav_list">
                <a href="../admin/admin_counsel.php" class="nav_link">
                    <i class="fa-solid fa-headset"></i>
                    <span class="nav_name">Counselling Report</span>
                </a>
            </div>
            <!-- <div class="nav_list">
                <a href="../admin/admin_report.php" class="nav_link">
                    <i class="fa-solid fa-headset"></i>
                    <span class="nav_name">Student Report</span>
                </a>
            </div> -->
            <div class="dropdown">
                <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <span class="nav_name">Class</span>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="../admin/assign_class.php">
                        <i class="fa-solid fa-pen-ruler"></i>
                        <span class="nav_name">Assign Class</span>
                    </a>
                    <a class="dropdown-item" href="../admin/add_class.php">
                        <i class="fa-solid fa-school"></i>
                        <span class="nav_name">Add Class</span>
                    </a>
                </div>
            </div>
            <div class="dropdown">
                <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                    <i class="fa-solid fa-clipboard-user" style="margin-left:5px;"></i>
                    <span class="nav_name">Staff</span>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="../admin/add_staff.php">
                        <i class="fa-solid fa-users-gear"></i>
                        <span class="nav_name">Add Staff</span>
                    </a>
                    <a class="dropdown-item" href="../admin/edit_staff.php">
                        <i class="fa-solid fa-user-pen"></i>
                        <span class="nav_name">Edit Staff</span>
                    </a>
                </div>
            </div>
            <div class="dropdown">
                <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                    <i class="fa-solid fa-users"></i>
                    <span class="nav_name">Student</span>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="../admin/add_student.php">
                        <i class="fa-solid fa-user-plus"></i>
                        <span class="nav_name">Add Student</span>
                    </a>
                    <a class="dropdown-item" href="../admin/edit_student.php">
                        <i class="fa-solid fa-user-pen"></i>
                        <span class="nav_name">Edit Student</span>
                    </a>
                    <a class="dropdown-item" href="../admin/find_student.php">
                        <i class="fa-solid fa-users-viewfinder"></i>
                        <span class="nav_name">Find Student</span>
                    </a>
                </div>
            </div>
        </div>

        <a class="lg" href="../includes/a_logout.php" onclick="return confirm('Do you really want to Logout?');"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
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