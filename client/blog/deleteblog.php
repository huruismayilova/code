<?php
session_start();
include '../../config/database.php';
include '../../helper/helper.php';

// Get the blog ID from the URL
if (isset($_GET['id'])) {
    $blog_id = $_GET['id'];

    // Delete the blog post from the database
    $sql = "DELETE FROM blogs WHERE id = ?";
    $deleteBlog = $conn->prepare($sql);
    $deleteBlog->execute([$blog_id]);

    // Redirect back to the blog list after deletion
    header('Location: homeblog.php');
    exit;
} else {
    echo "Invalid request!";
    exit;
}
?>
