<?php
require('../includes/loader.php');
require('../config/pdo_db.php');
require('../includes/session.php');
if (isset($_COOKIE['admin_email']) && isset($_COOKIE['pass'])) {
  $admin_email = $_COOKIE['admin_email'];
  $admin_pass = $_COOKIE['pass'];
  $checked = "checked";
  // echo "<script>document.getElementById('remember').value = 'True'; </script>";       
} else {
  $admin_email = "";
  $admin_pass = "";
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
  <script src="https://kit.fontawesome.com/a79beb4099.js" crossorigin="anonymous"></script>
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

  if (isset($_POST['admin_login'])) {
    $admin_email = $_POST['admin_email'];
    $admin_pass = $_POST['pass'];


    $select_user = $conn->prepare("SELECT * FROM admin_login WHERE admin_email = ? AND password = ?");
    $select_user->execute([$admin_email, $admin_pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
      $_SESSION['admin_email'] = $row['admin_email'];
      header('location:admin_dashboard.php');

      if (isset($_POST['remember'])) {
        setcookie('admin_email', $_POST['admin_email'], time() + (60 * 60 * 24));
        setcookie('pass', $_POST['pass'], time() + (60 * 60 * 24));
      } else {
        setcookie('admin_email', '', time() - (60 * 60 * 24));
        setcookie('pass', '', time() - (60 * 60 * 24));
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
          <div class="title"><img src="../assets/images/semcom-logo.png" height="80px" width="260px"></div>
          <form method="post" action="">
            <center><br><b>Login To Your Admin Dashboard</b></center>
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name="admin_email" value="<?php echo $admin_email ?>" placeholder="Enter Your Admin Email" title="Enter your Admin Email" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="pass" value="<?php echo $admin_pass ?>" placeholder="Enter Your password" required>
              </div>

              <div class="text"></div>

              <!-- <div class="text"><a href="#" style="font-size: small;">Forgot password?</a> -->
                <label class="check"> <input type="checkbox" id="remember" name="remember" <?php echo $checked ?>> &nbsp;Remember Me</label>
              </div>
              <div class="button input-box">

                <input type="submit" name="admin_login" value="LOGIN">
              </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</main>

  <footer>
    Designed and Developed by BCA(2021-2024)
    <br></i><a href="https://www.linkedin.com/in/utkarshrajputt/" target="_blank">Utkarsh</a> | <a href="https://www.linkedin.com/in/darshparikh11/" target="_blank">Darsh</a> | <a href="https://www.linkedin.com/in/diyapatel14/" target="_blank">Diya</a> | <a href="https://www.linkedin.com/in/kunjpatel11/" target="_blank">Kunj</a> | <a href="https://www.linkedin.com/in/manan-patel-4b31b8300/" target="_blank">Manan</a>
  </footer>
</body>

</html>