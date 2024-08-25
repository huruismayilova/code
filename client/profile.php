<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/footer.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$_SESSION['id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen melumatlar
    $name = post('name');
    $surname = post('surname');
    $email = post('email');
    $dob = post('dob');
    $gender = post('gender');

    // Profil seklini deyisdirmek ucun
    if (!empty($_FILES["profile"]["name"])) {
        $profile = basename($_FILES["profile"]["name"]);
        $target_dir = "../public/";
        $target_file = $target_dir . $profile;
        move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file);
        $profile = "public/$profile";
    } else {
        //  movcud sekil yeri
        $profile = $user['profile'];
    }

    $updateQuery = "UPDATE users SET name = ?, surname = ?, email = ?, dob = ?, gender = ?, profile = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->execute([$name, $surname, $email, $dob, $gender, $profile, $_SESSION['id']]);
    $_SESSION['user_name'] = $name;
    $_SESSION['user_profile'] = $profile;


    header("Location: profile.php");
    exit();
}
?>

<style>
    body {
        background-color: darkgray;
    }
</style>

<div class="container mt-5">
    <h1>You Profile</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>">
        </div>
        <div class="mb-3">
            <label for="surname" class="form-label">Surname</label>
            <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $user['surname']; ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>">
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="date" name="dob" value="<?php echo $user['dob']; ?>">
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-select" id="gender" name="gender">
                <option value="1" <?php echo $user['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="2" <?php echo $user['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="profile" class="form-label">Profile Picture</label>
            <input type="file" class="form-control" id="profile" name="profile">
            <img src="../<?php echo $user['profile']; ?>" alt="Profile"
                style="width: 150px; height: 150px; border-radius: 50%; margin-top: 10px;object-fit:cover;">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>