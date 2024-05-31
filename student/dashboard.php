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
<?php include '../includes/sidebar-student.php' ?>

<!-- Container Main start -->
    <div class="height-auto pt-3 pb-5" style="color: black;">
        <div id="dashboard" class="content active text-dark">
            <h4>Personal Details</h4>
            <?php require '/forms/personal-details.php'; ?>
        </div>
        <div id="users" class="content text-dark">
            <h4>Users</h4>
            <p>Kushal Chutmarino</p>
        </div>
        <div id="messages" class="content text-dark">
            <h4>Messages</h4>
            <p>Kunj Chutyo</p>
        </div>
        <div id="bookmark" class="content text-dark">
            <h4>Bookmark</h4>
            <p>Aman Lodo</p>
        </div>
        <div id="files" class="content text-dark">
            <h4>Files</h4>
            <p>Litti Litti ( mitho salo )</p>
        </div>
        <div id="stats" class="content text-dark">
            <h4>Stats</h4>
            <p>Diya tu bhai hai mera</p>
        </div>
    </div>
<!-- Container Main end -->

<!-- MAIN STUDENT JS -->
<script src="../assets/js/student.js"></script>

</body>
</html>