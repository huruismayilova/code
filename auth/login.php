<?php
include "../index.php";

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $errors = validation(['email', 'password']);

    if (empty($errors)) {
        $query = "SELECT * FROM users WHERE email=?";
        $loginQuery = $conn->prepare($query);
        $loginQuery->execute([
            post('email')

        ]);
        $user = $loginQuery->fetch(PDO::FETCH_ASSOC);

        if ($user['otp'] != null) {
            $_SESSION['otp_email'] = post('email');
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_ttl'] = time() + 300;
            view(route("auth/otp.php"));
        } elseif ($user && password_verify(post('password'), $user['password'])) {
            $_SESSION['user_profile'] = 'public/' . $user['profile'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            if ($user['role'] == 1) {
                view(route('admin/index.php'));
            } elseif ($user['role'] == 0) {
                view(route('client/index.php'));
            } else {
                $errors['login'] = "Email və ya şifrə yanlışdır";
            }
        }
    }
}
?>

<div class="formDiv">
    <div class="imgDiv">
        <img src="../profile.webp" alt="">
    </div>

</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h2>Login Form</h2>
            <form method="post" action="">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">

                    <?php if (isset($errors['email'])) {   ?>

                        <span style="color: red;"><?php echo $errors['email'] ?></span>

                    <?php
                    }
                    ?>


                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    <?php if (isset($errors['password'])) {   ?>

                        <span style="color: red;"><?php echo $errors['password'] ?></span>

                    <?php
                    }
                    ?>
                    <?php if (isset($errors['login'])): ?>
                        <span class='error'><?php echo $errors['login']; ?></span>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="register.php">Register</a>
            </form>
        </div>
    </div>
</div>