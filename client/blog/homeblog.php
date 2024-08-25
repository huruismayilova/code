<?php
session_start();
include '../blog/head.php';
include '../blog/root.php';

include '../../config/database.php';
include '../../helper/helper.php';


$user_id = $_SESSION["id"];


$sql = "SELECT blogs.*, categories.name AS category_name, users.name AS creator_name 
        FROM blogs 
        LEFT JOIN categories ON blogs.category_id = categories.id 
        LEFT JOIN users ON blogs.user_id = users.id";
$selectBlog = $conn->prepare($sql);
$selectBlog->execute();
$blogs = $selectBlog->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
  <button class="btn btn-primary">
   <a href="../index.php" style="color: #fff; text-decoration:none;" >Back to</a> 
  </button>
  
  <h2>Blog List</h2>
  
  <div class="row">
    <?php if (count($blogs) > 0): ?>
      <?php foreach ($blogs as $blog): ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100" style="width: 18rem;">
            <?php if (!empty($blog['profile'])): ?>
              <img src="../blog/public/<?= htmlspecialchars($blog['profile']); ?>" class="card-img-top"
                alt="Profile Image" style="height: 200px; object-fit: cover;">
            <?php else: ?>
              <img src="placeholder.png" class="card-img-top" alt="Default Image"
                style="height: 200px; object-fit: cover;">
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><strong>Title:</strong><?= htmlspecialchars($blog['title']); ?></h5>
              <p class="card-text"><strong>Content:</strong><?= htmlspecialchars($blog['description']); ?></p>
              <p class="card-text"><strong>Category:</strong> <?= htmlspecialchars($blog['category_name']); ?></p>
              <p class="card-text"><strong>User:</strong> <?= htmlspecialchars($blog['creator_name']); ?></p>
              <a href="detailsblog.php?id=<?= $blog['id']; ?>" class="btn btn-primary">See Blog
                Details</a><br><br>
              
              <?php if ($user_id === $blog['user_id']): ?>
                <a href="editblog.php?id=<?= $blog['id']; ?>" class="btn btn-warning mt-2">Edit</a>
                <a href="deleteblog.php?id=<?= $blog['id']; ?>"
                  onclick="return confirm('Are you sure you want to delete this blog?');"
                  class="btn btn-danger mt-2">Delete</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No blogs found.</p>
    <?php endif; ?>
  </div>
</div>
