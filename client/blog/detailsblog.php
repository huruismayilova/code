<?php
session_start();
include '../../config/database.php';
include '../../helper/helper.php';
if (isset($_GET['id'])) {
    $blog_id = $_GET['id'];
    $sql = "SELECT blogs.*, categories.name AS category_name, users.name AS creator_name 
            FROM blogs 
            LEFT JOIN categories ON blogs.category_id = categories.id 
            LEFT JOIN users ON blogs.user_id = users.id 
            WHERE blogs.id = :id";
    $selectBlog = $conn->prepare($sql);
    $selectBlog->bindParam(':id', $blog_id, PDO::PARAM_INT);
    $selectBlog->execute();
    $blog = $selectBlog->fetch(PDO::FETCH_ASSOC);

    if ($blog) {
        ?>
       <div class="container mt-4">
    <div class="row " style="width:100%;display:flex;gap:20px;">
        <!-- Sol tarafta resim -->
        <div class="col-md-4" style="max-width: 50%;">
            <?php if (!empty($blog['profile'])): ?>
                <img src="../blog/public/<?= htmlspecialchars($blog['profile']); ?>" alt="Profile Image" class="img-fluid" style="max-width: 100%;object-fit:cover;">
            <?php endif; ?>
        </div>
        
        <!-- Sağ tarafta başlık, açıklama ve kategori bilgisi -->
        <div class="col-md-8" style="max-width: 50%;">
            <h2><?= htmlspecialchars($blog['title']); ?></h2>
            <p><?= htmlspecialchars($blog['description']); ?></p>
            <p><strong>Category:</strong> <?= htmlspecialchars($blog['category_name']); ?></p>
            <p><strong>Created by:</strong> <?= htmlspecialchars($blog['creator_name']); ?></p>
        </div>
    </div>
</div>

        <?php
    } else {
        echo "<p>Blog not found.</p>";
    }
} else {
    echo "<p>No blog id provided.</p>";
}
?>
