<?php
include '../config/pdo_db.php';

session_start();
session_unset();
session_destroy();

header('location:../student/student_login.php');