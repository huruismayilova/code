<?php
session_start();
include '../../config/database.php';

if (isset($_GET['id'])) {
    $categoryId = intval($_GET['id']);

    $sql = "DELETE FROM categories WHERE id = ?";
    $deleteQuery = $conn->prepare($sql);
    $deleteQuery->execute([$categoryId]);
    header("Location: categories.php");
    exit;
} else {
    echo "Invalid category ID.";
}
