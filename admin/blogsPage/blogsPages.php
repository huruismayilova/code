
<!DOCTYPE html>
<html lang="en">
  <head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
<link rel="icon" type="image/png" href="./assets/img/favicon.png">
<title>
   Material Dashboard 2  by Creative Tim
</title>

<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

<link id="pagestyle" href="../assets/css/material-dashboard.min.css" rel="stylesheet" />
 </head>
  <body class="g-sidenav-show  bg-gray-100">
    
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">

<div class="sidenav-header">
  <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
  <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
    <img src="http://localhost/final-project/admin/assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
    <span class="ms-1 font-weight-bold text-white">Php Icon</span>
  </a>
</div>


<hr class="horizontal light mt-0 mb-2">

<div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
  <ul class="navbar-nav">

 <li class="nav-item">
<a class="nav-link text-white active bg-gradient-primary" href="http://localhost/final-project/admin/category/category.php">
 <span class="nav-link-text ms-1">Category</span>
</a>
</li>
<li class="nav-item">
<a class="nav-link text-white " href="http://localhost/final-project/admin/blogsPage/blogsPages.php">
  <span class="nav-link-text ms-1">Blogs</span>
</a>
</li>

<li class="nav-item">
<a class="nav-link text-white " href="http://localhost/final-project/admin/usersPage/userPages.php">
  <span class="nav-link-text ms-1">Users</span>
</a>
</li> 
<li class="nav-item">
<a class="nav-link text-white " href="http://localhost/final-project/admin/logout/logout.php">
  <span class="nav-link-text ms-1">Log Out</span>
</a>
</li>
 </ul>
</div>

<div class="sidenav-footer position-absolute w-100 bottom-0 ">
  <div class="mx-3">
    <a class="btn btn-outline-primary mt-4 w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard?ref=sidebarfree" type="button">Documentation</a>
    <a class="btn bg-gradient-primary w-100" href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">Upgrade to pro</a>
  </div>
  
</div>

</aside>

  <main class="main-content border-radius-lg ">  

  
  <?php 
    include '../includes/footer.php';
    include '../includes/navbar.php';
    include '../../config/database.php';
    include '../../helper/helper.php';
    session_start();


    $query = "
        SELECT blogs.*, users.name AS user_name, blogs.is_publish AS blog_status, categories.name AS category_name
        FROM blogs
        LEFT JOIN users ON blogs.user_id = users.id
        LEFT JOIN categories ON blogs.category_id = categories.id
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $blog_id = $_POST['blog_id'];
        $current_status = $_POST['blog_status'];
        $new_status = $current_status == '1' ? '0' : '1';

        $update_query = "UPDATE blogs SET is_publish = :new_status WHERE id = :blog_id";
        $stmt = $conn->prepare($update_query);
        $stmt->execute(['new_status' => $new_status, 'blog_id' => $blog_id]);

        header('Location: blogsPages.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog List</title>
    <link rel="stylesheet" href="path/to/your/bootstrap.css">
</head>
<body>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <h1 class="mb-4">Blogs List</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                <th>Profile</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($blogs as $blog): ?>
                    <tr>
                    <td>
        <img src="http://localhost/final-project/client/blog/public/<?= htmlspecialchars($blog['profile']); ?>" alt="<?= htmlspecialchars($blog['title']); ?>" style="width: 100px; height: auto;">
    </td>
                        <td><?= htmlspecialchars($blog['title']); ?></td>
                        <td><?= htmlspecialchars($blog['description']); ?></td>
                        <td><?= htmlspecialchars($blog['category_name']); ?></td>
                        <td><?= htmlspecialchars($blog['user_name']); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="blog_id" value="<?= $blog['id']; ?>">
                                <input type="hidden" name="blog_status" value="<?= $blog['blog_status']; ?>">
                                <button type="submit" class="btn btn-sm <?= $blog['blog_status'] == '1' ? 'btn-danger' : 'btn-success'; ?>">
                                    <?= $blog['blog_status'] == '1' ? 'Activate' : 'Deactivate'; ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table> 
        </div>
      </div>
       
    </div>

    <script src="../../assets/js/jquery-3.7.1.min.js"></script>
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>

