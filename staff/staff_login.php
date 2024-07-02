<?php
require('../includes/loader.php');
require('../config/pdo_db.php');
require('../includes/session.php');
if (isset($_COOKIE['staff_email']) && isset($_COOKIE['staff_pass'])) {
  $staff_email = $_COOKIE['staff_email'];
  $staff_pass = $_COOKIE['staff_pass'];
  $checked = "checked";
  // echo "<script>document.getElementById('remember').value = 'True'; </script>";       
} else {
  $staff_email = "";
  $staff_pass = "";
  $checked = "";
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> SEMCOM </title>
  <link rel="stylesheet" href="../assets/css/stud.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    main {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
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

<body>
  <?php

  if (isset($_POST['staff_login'])) {
    $staff_email = $_POST['staff_email'];
    $staff_pass = $_POST['staff_pass'];


    $select_user = $conn->prepare("SELECT * FROM staff_dtl WHERE clg_email = ? AND password = ?");
    $select_user->execute([$staff_email, $staff_pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
      $_SESSION['staff_email'] = $row['clg_email'];
      header('location:dashboard.php');

      if (isset($_POST['remember'])) {
        setcookie('staff_email', $_POST['staff_email'], time() + (60 * 60 * 24));
        setcookie('staff_pass', $_POST['staff_pass'], time() + (60 * 60 * 24));
      } else {
        setcookie('staff_email', '', time() - (60 * 60 * 24));
        setcookie('staff_pass', '', time() - (60 * 60 * 24));
      }
    } else {
      echo "<script>alert('Incorrect Email OR Password!!')</script>";
      // $message[] = 'incorrect username or password!';
    }
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
          <div class="title"><img src="../assets/images/semcom-logo.png" height="100px" width="300px"></div>
          <form method="post" action="">
            <center><br><b>Login To Your Staff Dashboard</b></center>
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="email" name="staff_email" value="<?php echo $staff_email ?>" placeholder="Enter Staff Email" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="staff_pass" value="<?php echo $staff_pass ?>" placeholder="Enter Staff password" required>
              </div>

              <div class="text"></div>

              <!-- <div class="text"><a href="#" style="font-size: small;">Forgot password?</a> -->
                <label class="check"> <input type="checkbox" id="remember" name="remember" <?php echo $checked ?>> &nbsp;Remember Me</label>
              </div>
              <div class="button input-box">

                <input type="submit" name="staff_login" value="LOGIN">
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

</body>

</html>