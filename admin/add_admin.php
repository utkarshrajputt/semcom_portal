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



if (isset($_POST['change_pass_btn'])) {
    $old_password = $_POST['old-password'];
    $new_password = $_POST['new-password'];
    $retype_password = $_POST['retype-password'];

    // Retrieve the current password from the database
    $stmt = $conn->prepare("SELECT password FROM stud_login WHERE enroll_no = ?");
    $stmt->bind_param("s", $enroll);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($current_password);
        $stmt->fetch();

        // Verify the old password
        if ($old_password === $current_password) {
            // Update the password in the database
            $update_stmt = $conn->prepare("UPDATE stud_login SET password = ? WHERE enroll_no = ?");
            $update_stmt->bind_param("si", $new_password, $enroll);

            if ($update_stmt->execute()) {
                echo "<script>alert('Password succesfully changed.');</script>";
            } else {
                echo "<script>alert('Error updating password. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Old password is incorrect.');</script>";
        }
    } else {
        echo "<script>alert('User not found.');</script>";
    }

    $stmt->close();
    $conn->close();
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
        .form-container {
            margin-left: 35%;
            margin-top: 150px;
            max-width: 400px;
            background-color: #fff;
            padding: 32px 24px;
            font-size: 14px;
            font-family: inherit;
            color: #212121;
            display: flex;
            flex-direction: column;
            gap: 20px;
            box-sizing: border-box;
            border-radius: 10px;
            box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.084), 0px 2px 3px rgba(0, 0, 0, 0.168);
        }

        .form-container button:active {
            scale: 0.95;
        }

        .form-container .logo-container {
            text-align: center;
            font-weight: 600;
            font-size: 18px;
        }

        .form-container .form {
            display: flex;
            flex-direction: column;
        }

        .form-container .form-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .form-container .form-group label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .form-container .form-group input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 6px;
            font-family: inherit;
            border: 1px solid #ccc;
        }

        .form-container .form-group input::placeholder {
            opacity: 0.5;
        }

        .form-container .form-group input:focus {
            outline: none;
            border-color: #1778f2;
        }

        .form-container .form-submit-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: inherit;
            color: #fff;
            background-color: blue;
            border: none;
            width: 100%;
            padding: 12px 16px;
            font-size: inherit;
            gap: 8px;
            margin: 12px 0;
            cursor: pointer;
            border-radius: 6px;
            box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.084), 0px 2px 3px rgba(0, 0, 0, 0.168);
        }

        .form-container .form-submit-btn:hover {
            background-color: #313131;
        }

        .error-message {
            color: red;
            display: none;
        }

        @media (max-width: 768px) {
            .form-container {
                margin-left: 0;
            }
        }
    </style>
</head>

<body id="body-pd">
    <?php
    require '../includes/sidebar-admin.php';
    ?>

    <div class="form-container">
        <div class="logo-container">
            New Admin Credential
        </div>

        <form class="form" id="change-password-form" method="post">
            <div class="form-group">
                <label for="old-password">Email</label>
                <input type="password" id="old-password" name="old-password" required>
            </div>
            <div class="form-group">
                <label for="new-password">Password</label>
                <input type="password" id="new-password" name="new-password" required>
            </div>
            <div class="form-group">
                <label for="retype-password">Re-Type Password</label>
                <input type="password" id="retype-password" name="retype-password" required>
            </div>
            <div class="error-message" id="error-message">*Passwords do not match.</div>
            <button class="form-submit-btn" name="change_pass_btn" type="submit">Add Admin</button>
        </form>
    </div>



    <!-- MAIN STUDENT JS -->
    <script src="../assets/js/main.js"></script>
    <script>
        document.getElementById('change-password-form').addEventListener('submit', function(event) {
            var newPassword = document.getElementById('new-password').value;
            var retypePassword = document.getElementById('retype-password').value;
            var errorMessage = document.getElementById('error-message');

            if (newPassword !== retypePassword) {
                errorMessage.style.display = 'block';
                event.preventDefault(); // Prevent form submission
            } else {
                errorMessage.style.display = 'none';
            }
        });
    </script>

</body>

</html>