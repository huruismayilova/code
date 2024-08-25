<?php
session_start();
include '../../config/database.php';
include '../../helper/helper.php';

// Kateqoriyaları əldə et
$sql = "SELECT id, name FROM categories";
$selectCate = $conn->prepare($sql);
$selectCate->execute();
$categories = $selectCate->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = post('title');
    $description = post('description');
    $category_id = post('category_id');
    $profile = ''; 
$user_name = $_SESSION['user_name'] ;

    if (!empty($_FILES['profile']['name'])) {
        $target_dir = "uploads/";
        $profile = $target_dir . basename($_FILES["profile"]["name"]);
        move_uploaded_file($_FILES["profile"]["tmp_name"], $profile);
    }

  
    $sql = "INSERT INTO blogs (title, description, category_id, profile, user_name) VALUES (?, ?, ?, ?, ?)";
    $insertQuery = $conn->prepare($sql);
    $insertQuery->execute([$title, $description, $category_id, $profile, $user_name]);

    echo "Blog uğurla əlavə olundu!";
}
?>

<h2>Create Blog</h2>
<form action="" method="POST" enctype="multipart/form-data">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" required><br><br>

    <label for="description">Description</label>
    <textarea name="description" id="description" required></textarea><br><br>

    <label for="category_id">Select Category</label>
    <select name="category_id" id="category_id" required>
        <?php foreach ($categories as $categ): ?>
            <option value="<?= $categ['id']; ?>"><?= $categ['name']; ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="profile">Profile Image</label>
    <input type="file" name="profile" id="profile"><br><br>

    <button type="submit">Create Blog</button>
</form>
