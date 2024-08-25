
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


$query = "SELECT id, name, surname, email, active FROM users WHERE role = 0 ORDER BY users.id ASC";
$stmt = $conn->prepare($query);
$stmt->execute();
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $clientId = $_POST['client_id'];
    $newStatus = $_POST['new_status'];

  
    $updateQuery = "UPDATE users SET active = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->execute([$newStatus, $clientId]);

    $updateBlogQuery = "UPDATE blogs SET is_publish = ? WHERE user_id = ?";
    $stmt = $conn->prepare($updateBlogQuery);
    $stmt->execute([$newStatus, $clientId]);

    header("Location: " . route("admin/usersPage/userPages.php"));
    exit;
}
?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <h1>Users List</h1>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Email</th>
                <th>Status</th>
               
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= htmlspecialchars($client['id']); ?></td>
                    <td><?= htmlspecialchars($client['name']); ?></td>
                    <td><?= htmlspecialchars($client['surname']); ?></td>
                    <td><?= htmlspecialchars($client['email']); ?></td>
                    
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="client_id" value="<?= $client['id']; ?>">
                            <input type="hidden" name="new_status" value="<?= $client['active'] ? 0 : 1; ?>">
                            <button type="submit" class="btn btn-primary <?= $client['active'] ? 'deactivate-btn' : 'activate-btn'; ?>">
                                <?= $client['active'] ? 'Activate' : 'Deactivate'; ?>
                            </button>
                        </form>
                    </td>
                    <td>
                        <a href="http://localhost/final-project/client/blog/detailsblog.php?id=<?= $client['id']; ?>" class="action-btn view-btn">View</a>
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