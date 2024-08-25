<?php
session_start();
include '../../includes/header.php'; 
include '../../includes/footer.php';
include '../../config/database.php';
include '../../helper/helper.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {

 
    $errors = validation(['email','password']);

    if (empty($errors)) {
   
        $query = "SELECT * FROM users WHERE email=?";
        $loginQuery = $conn->prepare($query);
        $loginQuery->execute([$_POST['email']]);
        $admin = $loginQuery->fetch(PDO::FETCH_ASSOC);


        if ($admin && password_verify($_POST['password'], $admin['password'])) {
        
            $_SESSION['user'] = $admin;
            $_SESSION['user_name'] = $admin['name'];
      
            header('Location:index.php');
            exit(); 
        } else {
          
            $errors['general'] = "Invalid email or password.";
        }
    }
}

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Login Form</h2>
            <nav class="navbar navbar-expand-lg bg-body-tertiary" style="width:100%; display:flex;">
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                                <?php if (isset($errors['email'])) { ?>
                                    <span style="color: red;"><?php echo $errors['email'] ?></span>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                <?php if (isset($errors['password'])) { ?>
                                    <span style="color: red;"><?php echo $errors['password'] ?></span>
                                <?php } ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <?php if (isset($errors['general'])) { ?>
                                <span style="color: red;"><?php echo $errors['general'] ?></span>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
