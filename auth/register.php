<?php
include "../index.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../vendor/PHPMailer/src/Exception.php";
require "../vendor/PHPMailer/src/PHPMailer.php";
require "../vendor/PHPMailer/src/SMTP.php";

$errors = [];
try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = validation(['name', 'surname', 'email', 'password', 'password_confirmation', 'gender']);

        if (post('password') !== post('password_confirmation')) {
            $errors['password_confirmation'] = 'Passwords do not match';
        }

        if (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
            $newFileName = fileUpload('../public/', $_FILES['profile']);
            $destination = $newFileName ? "public/" . $newFileName : null;

            if (!$destination) {
                $errors['profile'] = 'Failed to upload profile picture';
            }
        }

        if (empty($errors)) {
            $otp = rand(1000, 9999);
            $passwordHash = password_hash(post('password'), PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, surname, email, password, gender, dob, profile, otp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $insertQuery = $conn->prepare($sql);
            $check = $insertQuery->execute([
                post("name"),
                post("surname"),
                post("email"),
                $passwordHash,
                post('gender'),
                post("dob"),
                $destination ?? null,
                $otp
            ]);

            if ($check) {
                $_SESSION['user_role'] = post('role');
                $_SESSION['user_profile'] = $destination;
                $_SESSION['otp_email'] = post('email');
                $_SESSION['otp'] = $otp;
                $_SESSION['otp_ttl'] = time() + 300;

                $email = new PHPMailer(true);

                try {
                    $email->isSMTP();
                    $email->Host = 'smtp.gmail.com';
                    $email->SMTPAuth = true;
                    $email->Username = 'ksereks71@gmail.com';
                    $email->Password = 'xbbi mgvg qdra urgv';
                    $email->SMTPSecure = 'tls';
                    $email->Port = 587;

                    $email->setFrom('ksereks71@gmail.com', 'Final Project');
                    $email->addAddress("quluyevanigar77@gmail.com");

                    $email->isHTML(true);
                    $email->Subject = 'Your OTP Code';
                    $email->Body = 'Your OTP code is ' . $otp;

                    $email->send();
                    header('Location: ' . route('auth/otp.php'));
                    exit();
                } catch (Exception $e) {
                    $errors['email'] = 'Failed to send OTP email: ' . $e->getMessage();
                }
            }
        }
    }
} catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        $errors['email'] = "This email is already registered";
    } else {
        $errors['general'] = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <h4>Register Form</h4>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Name">
                            <?php if (isset($errors['name'])) { ?>
                                <span class="error"><?php echo $errors['name'] ?></span>
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <label for="surname" class="form-label">Surname</label>
                            <input type="text" class="form-control" name="surname" id="surname"
                                placeholder="Enter Your Surname">
                            <?php if (isset($errors['surname'])) { ?>
                                <span class="error"><?php echo $errors['surname'] ?></span>
                            <?php } ?>
                        </div>
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="1">
                            <label class="form-check-label" for="inlineRadio1">Male</label>
                        </div>
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="2">
                            <label class="form-check-label" for="inlineRadio2">Female</label>
                            <?php if (isset($errors['gender'])): ?>
                                <span class="error"><?php echo $errors['gender']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" name="dob" id="date" placeholder="Enter Your Date">
                            <?php if (isset($errors['dob'])) { ?>
                                <span class="error"><?php echo $errors['dob'] ?></span>
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <label for="profile" class="form-label">Profile</label>
                            <input type="file" class="form-control" name="profile" id="profile">
                            <?php if (isset($errors['profile'])) { ?>
                                <span class="error"><?php echo $errors['profile'] ?></span>
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter Your Email">
                            <?php if (isset($errors['email'])) { ?>
                                <span class="error"><?php echo $errors['email'] ?></span>
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter Your Password">
                            <?php if (isset($errors['password'])) { ?>
                                <span class="error"><?php echo $errors['password'] ?></span>
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Password Confirmation</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                            <?php if (isset($errors['password_confirmation'])) { ?>
                                <span class="error"><?php echo $errors['password_confirmation'] ?></span>
                            <?php } ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>