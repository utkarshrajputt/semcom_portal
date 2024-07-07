<?php

   $db_name = 'mysql:host=localhost;dbname=semcom_db';
   $user_name = 'semcom';
   $user_password = 'semcom';

   // Create connection
   
   try{
      $conn = new PDO($db_name, $user_name, $user_password);
   }catch(PDOException $e){
      echo $e->getMessage();
      header('location:../config/on_maintainance.php');
   }