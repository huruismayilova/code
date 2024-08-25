<?php
session_start();
include '../../config/database.php';  
include '../../helper/helper.php'; 
$_SESSION=[];
session_destroy();
header('location:../../auth/login.php');
