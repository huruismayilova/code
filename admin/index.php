<?php
session_start();


if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
  header("Location: ../client/index.php");
  exit;
}
include 'includes/header.php';
include 'includes/footer.php';

include 'includes/navbar.php';
include '../config/database.php';
include '../helper/helper.php';
// include './login/login.php';

$displayName = $_SESSION['user_name'] ?? 'ADMIN';
?>
<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($displayName); ?>!</h2>
</div>
<?php

?>




<style>
h2 {
    text-align: center;
}
</style>