<?php
session_start();
include '../../includes/header.php';
include '../../config/database.php';

if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    
 
    $sql = "SELECT * FROM categories WHERE id = ?";
    $selectQuery = $conn->prepare($sql);
    $selectQuery->execute([$categoryId]);
    $category = $selectQuery->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $updatedName = post('name');
        $sql = "UPDATE categories SET name = ? WHERE id = ?";
        $updateQuery = $conn->prepare($sql);
        $updateQuery->execute([$updatedName, $categoryId]);

        header("Location: ../index.php");
        exit;
    }
} else {
    echo "Invalid category ID.";
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
           <form action="" method="POST" class="needs-validation">
           <h2>Edit Category</h2>
    <label for="name" class="form-label">Category Name:</label>
    <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($category['name']); ?>" required>
    <button type="submit" class="btn btn-primary">Update Category</button>
</form> 
        </div>
    </div>
</div>



