<?php
session_start();
include '../blog/head.php';
include '../../config/database.php';
include '../../helper/helper.php';

$sql = "SELECT id, name FROM categories";
$selectCate = $conn->prepare($sql);
$selectCate->execute();
$categories = $selectCate->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = post('title');
    $description = post('description');
    $category_id = post('category_id');
    $view_count = post('view_count') == 0;
    $user_id = $_SESSION["id"];


    if (!empty($_FILES['profile']['name'])) {

        $newFileName = fileUpload('public/', $_FILES['profile']);
        move_uploaded_file($_FILES["profile"]["tmp_name"], $newFileName);
    }
    $sql = "INSERT INTO blogs (title, description, user_id,category_id ,profile,view_count) VALUES (?, ?, ?,?,?, ?)";
    $insertQuery = $conn->prepare($sql);
    $insertQuery->execute([
        $title,
        $description,
        $user_id,
        $category_id,
        $newFileName,
        $view_count
    ]);

    header('location:../blog/homeblog.php');
}

$sql = 'SELECT * FROM blogs';
$sqls = $conn->prepare($sql);
$sqls->execute([]);
$select = $sqls->fetchAll(PDO::FETCH_ASSOC);
?>



<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <h2>Create Blog</h2>
            <form action="" method="POST" class="needs-validation" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter blog title"
                        required>
                </div>
                <div class="mb-3">

                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4"
                        placeholder="Enter blog description" required></textarea>

                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category:</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <?php
                        $sql = "SELECT * FROM categories";
                        $selectCategories = $conn->prepare($sql);
                        $selectCategories->execute();
                        $categories = $selectCategories->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($categories as $category) {
                            $selected = $category['id'] == $blog['category_id'] ? 'selected' : '';
                            echo "<option value='{$category['id']}' {$selected}>{$category['name']}</option>";
                        }
                        ?>
                    </select><br>
                </div>

                <div class="mb-3">
                    <label for="profile" class="form-label">Profile Image</label>
                    <input type="file" name="profile" id="profile" class="form-control">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">Create Blog</button>
                </div>
            </form>
        </div>
    </div>
</div>