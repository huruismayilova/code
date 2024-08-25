<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <title>
    Material Dashboard 2 by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.min.css" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">

  <aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">

    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard "
        target="_blank">
        <img src="http://localhost/final-project/admin/assets/img/logo-ct.png" class="navbar-brand-img h-100"
          alt="main_logo">
        <span class="ms-1 font-weight-bold text-white">Php Icon</span>
      </a>
    </div>


    <hr class="horizontal light mt-0 mb-2">

    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <!-- <li class="nav-item">
<a class="nav-link text-white active bg-gradient-primary" href="http://localhost/final-project/admin/profil/profiles.php">
 <span class="nav-link-text ms-1">Profile</span>
</a>
</li> -->
        <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-primary"
            href="http://localhost/final-project/admin/category/category.php">
            <span class="nav-link-text ms-1">Category</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white "
            href="http://localhost/final-project/admin/blogsPage/blogsPages.php">
            <span class="nav-link-text ms-1">Blogs</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white " href="http://localhost/final-project/admin/usersPage/userPages.php">
            <span class="nav-link-text ms-1">Users</span>
          </a>
        </li>
        <!-- <li class="nav-item">
<a class="nav-link text-white " href="http://localhost/final-project/admin/logout/logout.php">
  <span class="nav-link-text ms-1">Log Out</span>
</a>
</li> -->
      </ul>
    </div>

    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        <a class="btn btn-outline-primary mt-4 w-100"
          href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard?ref=sidebarfree"
          type="button">Documentation</a>
        <a class="btn bg-gradient-primary w-100"
          href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree"
          type="button">Upgrade to pro</a>
      </div>

    </div>

  </aside>

  <main class="main-content border-radius-lg ">
    <?php

    include '../includes/header.php';
    include '../includes/footer.php';
    include '../../config/database.php';
    $sql = "SELECT * FROM categories";
    $selectCate = $conn->prepare($sql);
    $selectCate->execute();
    $categories = $selectCate->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $sql = "INSERT INTO categories (name) VALUES (?)";
      $insertQuery = $conn->prepare($sql);
      $insertQuery->execute([post('categories')]);

      $_SESSION['select_category'] = post('categories');
    }
    ?>


    <div class="container mt-5">
      <div class="row justify-content-center">
        <h2>Add Categories</h2>
        <div class="col-md-8 col-lg-6">
          <form action="" method="POST" class="needs-validation">
            <label for="categories" class="form-label">Category Name:</label>
            <input type="text" name="categories" class="form-control" id="categories" required
              style="border:1px solid black">
            <button class="btn btn-primary" type="submit">Add Category</button>
          </form>


          <table border="1" cellpadding="10" cellspacing="0" class="table">
            <thead>
              <tr>
                <th scope="col">Category ID</th>
                <th scope="col">Category Name</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($categories as $category): ?>
                <tr>
                  <td scope="row"><?= htmlspecialchars($category['id']); ?></td>
                  <td scope="row"><?= htmlspecialchars($category['name']); ?></td>
                  <td scope="row">
                    <a href="../category/categoryEdit.php?id=<?php echo  $category['id']; ?>"><button
                        class="btn btn-primary"
                        style="background-color: red;text-decoration:none;">Edit</button></a>
                    <a href="../category/categoryDel.php?id=<?php echo  $category['id']; ?>"
                      onclick="return confirm('Are you sure you want to delete this category?');"><button
                        class="btn btn-primary"
                        style="background-color: green;text-decoration:none;">Delete</button></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>