<?php
session_start();
include '../config/database.php';
include '../helper/helper.php';
$_SESSION = [];
session_destroy();

view(route('auth/register.php'));
