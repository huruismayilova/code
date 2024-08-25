<?php
session_start();
include '../includes/header.php';  
include '../config/database.php';  
include '../helper/helper.php';  
include '../includes/footer.php'; 

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}
$user = getUserDetails($conn);
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">



                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../client/profile.php">
                            <img src="http://localhost/final-project/<?php echo $user['profile']; ?>" alt="Profile"
                                style="width: 50px; height: 50px; border-radius: 50%;object-fit:cover;">
                            Profile

                            <br>
                            <?php echo $_SESSION['user_name']; ?>


                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../auth/logout.php">Logout</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="../auth/search.php">Search</a>
                    </li> -->
                </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1>Welcome, <?php echo $_SESSION['user_name']; ?>!</h1>

</div>
<?php include '../auth/search.php'; ?>
<div class="container mt-5">
    <button type="submit" class="btn btn-primary">
        <a href="../client/blog/homeblog.php" style="color: beige;text-decoration:none;">Show All Blogs</a>
    </button>
    <button type="submit" class="btn btn-primary">
        <a href="../client/blog/createblog.php" style="color: #fff;text-decoration:none;">Add Blogs</a>
    </button>

</div>
