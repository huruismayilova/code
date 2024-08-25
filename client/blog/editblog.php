<?php
session_start();
include '../blog/head.php';
include '../../config/database.php';
include '../../helper/helper.php';
if (isset($_GET['id'])) {
    $blog_id = $_GET['id'];
    $sql = "SELECT * FROM blogs WHERE id = ?";
    $selectBlog = $conn->prepare($sql);
    $selectBlog->execute([$blog_id]);
    $blog = $selectBlog->fetch(PDO::FETCH_ASSOC);

    if (!$blog) {
        echo "Blog not found!";
        exit;
    }

  
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = post('title');
        $description = post('description');
        $category_id = post('category_id');

        $sql = "UPDATE blogs SET title = ?, description = ?, category_id = ? WHERE id = ?";
        $updateBlog = $conn->prepare($sql);
        $updateBlog->execute([$title, $description, $category_id, $blog_id]);

     
        header('Location: homeblog.php');
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <h2>Edit Blog</h2>
<form action="" method="POST" class="needs-validation">
<div class="mb-3">
       <label for="title" class="form-label">Title:</label>
    <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($blog['title']); ?>" required><br>
          
</div>
    <div class="mb-3">
      <label for="description" class="form-label">Description:</label>
    <textarea name="description" id="description" class="form-control" required><?= htmlspecialchars($blog['description']); ?></textarea><br>
   
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
   

    <button class="btn btn-primary" type="submit">Update Blog</button>
</form>
        </div>
    </div>
</div>



