<?php
require('../includes/loader.php');
require('../config/mysqli_db.php');
require('../includes/session.php');
if (isset($_COOKIE['enroll']) && isset($_COOKIE['pass'])) {
  $enroll = $_COOKIE['enroll'];
  $pass = $_COOKIE['pass'];
  $checked = "checked";
  // echo "<script>document.getElementById('remember').value = 'True'; </script>";       
} else {
  $enroll = "";
  $pass = "";
  $checked = "";
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> SEMCOM </title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../assets/css/stud.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">

  <style>
    main {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 75%;
    }

    footer {
      background-color: rgba(255, 255, 255, 0.503);
      ;
      text-align: center;
      padding: 5px;
      position: fixed;
      width: 100%;
      bottom: 0;
    }
  </style>
</head>
<?php

if (isset($_POST['login'])) {
  $enroll = $_POST['enroll'];
  $pass = $_POST['pass'];

  // Prepare the statement
  $stmt = $conn->prepare("SELECT * FROM stud_login WHERE enroll_no = ? AND password = ?");
  $stmt->bind_param("ss", $enroll, $pass);
  $stmt->execute();

  // Get the result
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  if ($result->num_rows > 0) {
    $_SESSION['enroll'] = $row['enroll_no'];
    header('location:profile_dashboard.php');

    if (isset($_POST['remember'])) {
      setcookie('enroll', $_POST['enroll'], time() + (60 * 60 * 24));
      setcookie('pass', $_POST['pass'], time() + (60 * 60 * 24));
    } else {
      setcookie('enroll', '', time() - (60 * 60 * 24));
      setcookie('pass', '', time() - (60 * 60 * 24));
    }
  } else {
    echo "<script>alert('Incorrect Enrollment Number OR Password!!')</script>";
    // $message[] = 'incorrect username or password!';
  }

  // Close the statement
  $stmt->close();
}

?>

<main>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="../assets/images/frontImg.jpg" alt="">
        <div class="text quote"><br><br>
          <span class="text-1">"What <span class="think"><br>we Think</span> <br> Others Don't"</span>

        </div>
      </div>
    </div>
    <div class="forms">
      <div class="form-content">
        <div class="login-form">
          <div class="title"><img src="../assets/images/semcom-logo.png" height="80px" width="260px"></div>
          <form method="post" action="">
            <center><br><b>Login To Your Student Dashboard</b></center>
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name="enroll" value="<?php echo $enroll ?>" placeholder="Enter Your Enrollment Number" title="Enrollment Number Should Be of 14 Digits Only" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="pass" value="<?php echo $pass ?>" placeholder="Enter Your password" required>
              </div>

              <div class="">
              <a href="#" class="" data-toggle="modal" data-target="#forgotPasswordModal" style="float:left;">
                Forgot Password?
              </a>


              <!-- <div class="text"><a href="#" style="font-size: small;">Forgot password?</a> -->

              <label style="float:right;"> <input type="checkbox" id="remember" name="remember" <?php echo $checked ?>> &nbsp;Remember Me</label>
              </div>
<br>


              <div class="button input-box">

                <input type="submit" name="login" value="LOGIN">
              </div>

          </form>
        </div>
      </div>
    </div>
  </div>

</main>
<footer>
  Designed and Developed by BCA(2021-2024)
  <br> <a href="https://www.linkedin.com/in/utkarshrajputt/" target="_blank">Utkarsh</a> | <a href="https://www.linkedin.com/in/darshparikh11/" target="_blank">Darsh</a> | <a href="https://www.linkedin.com/in/diyapatel14/" target="_blank">Diya</a> | <a href="https://www.linkedin.com/in/kunjpatel11/" target="_blank">Kunj</a> | <a href="https://www.linkedin.com/in/manan-patel-4b31b8300/" target="_blank">Manan</a>
</footer>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="forgotPasswordForm" method="post" action="">
          <div class="form-group">
            <label for="enroll">Enrollment Number</label>
            <input type="text" class="form-control" id="enroll" name="enroll" placeholder="Enter your enrollment number" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
          </div>
          <div class="form-group">
            <label for="securityQuestion">Security Question</label>
            <select class="form-control" id="securityQuestion" name="securityQuestion" required>
            <option value="" disabled selected>Select a security question</option>
                <option value="pet_name">What is the name of your first pet?</option>
                <option value="frnd_name">What is the name of your best friend name?</option>
                <option value="mother_maiden">What is your mother's maiden name?</option>
                <option value="first_school">What is the name of your first school?</option>
                <option value="favorite_teacher">Who was your favorite teacher?</option>
            </select>
          </div>
          <div class="form-group">
            <label for="securityAnswer">Answer</label>
            <input type="text" class="form-control" id="securityAnswer" name="securityAnswer" placeholder="Enter your answer" required>
          </div>
          <div class="form-group">
            <label for="newPassword">New Password</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password" required>
          </div>
          <div class="form-group">
            <label for="confirmNewPassword">Confirm New Password</label>
            <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" placeholder="Confirm new password" required>
          </div>
          <button type="submit" name="reset_pass" class="btn btn-primary">Reset Password</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
if (isset($_POST['reset_pass'])){
    $enroll = $_POST['enroll'];
    $email = $_POST['email'];
    $securityQuestion = $_POST['securityQuestion'];
    $securityAnswer = $_POST['securityAnswer'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    // Validation checks
    if (empty($enroll) || empty($email) || empty($securityQuestion) || empty($securityAnswer) || empty($newPassword) || empty($confirmNewPassword)) {
      echo "<script>alert('All fields are required.!!')</script>";
        exit;
    }

    if ($newPassword !== $confirmNewPassword) {
      echo "<script>alert('Passwords do not match.!!')</script>";
        exit;
    }


    // Check if enrollment number, email, and security question/answer match
    $stmt = $conn->prepare("SELECT * FROM stud_personal_details WHERE enroll_no = ? AND email_id = ? AND security_que = ? AND security_ans = ?");
    $stmt->bind_param("ssss", $enroll, $email, $securityQuestion, $securityAnswer);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update password
        $updateStmt = $conn->prepare("UPDATE stud_login SET password = ? WHERE enroll_no = ?");
        $updateStmt->bind_param("ss", $newPassword, $enroll);
        if ($updateStmt->execute()) {
          echo "<script>alert('Password reset successfully.')</script>";
        } else {
          echo "<script>alert('Error updating password.')</script>";
        }
    } else {
      echo "<script>alert('Invalid credentials.')</script>";
    }

    $stmt->close();
}
?>








</body>

</html>