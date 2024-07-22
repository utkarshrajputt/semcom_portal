<?php
include '../config/pdo_db.php';

session_start();
session_unset();
session_destroy();

header('location:../staff/index.php');