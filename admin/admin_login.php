<?php
require('../includes/loader.php');
require('../config/pdo_db.php');
require('../includes/session.php');

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> SEMCOM </title>
  <link rel="stylesheet" href="../assets/css/stud.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="../assets/images/frontImg.jpg" alt="">
        <div class="text quote"><br><br>
          <span class="text-1">"What  <span class="think"><br>we Think</span> <br> Other's Don't"</span>

        </div>
      </div>
    </div>
    <div class="forms">
      <div class="form-content">
        <div class="login-form">
          <div class="title"><img src="../assets/images/semcom-logo.png" height="100px" width="300px"></div>
          <form method="post" action="">
          <center><br>-- Login To Your Admin Dashboard --</center>
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name="enroll" value="<?php echo $enroll ?>" placeholder="Enter Your Enrollment Number" maxlength="14" pattern="\d{14}" title="Enrollment Number Should Be of 14 Digits Only" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="pass" value="<?php echo $pass ?>" placeholder="Enter Your password" required>
              </div>

              <div class="text"></div>

              <div class="text"><a href="#" style="font-size: small;">Forgot password?</a>
                <label class="check"> <input type="checkbox" id="remember" name="remember" <?php echo $checked ?>> &nbsp;Remember Me</label>
              </div>
              <div class="button input-box">

                <input type="submit" name="login" value="LOGIN">
              </div>
              <div class="text sign-up-text">Designed by BCA(2021-2024)
                <!-- <label for="flip">Sigup now</label></div> -->
              </div>

          </form>
        </div>
      </div>
    </div>
</body>

</html>