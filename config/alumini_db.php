<?php

   $servername = "localhost";
   $username = "semcom";
   $password = "semcom";
   $dbname = "semcom_alumini";

   // Create connection
   
   try{
      $conn = mysqli_connect($servername, $username, $password, $dbname);

   }catch(mysqli_sql_exception $e){
      echo $e->getMessage();
      header('location:../config/on_maintainance.php');
   }