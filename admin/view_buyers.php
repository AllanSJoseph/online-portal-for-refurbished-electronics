<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyers @ OPRE</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link  rel="stylesheet" href="../style.css" type="text/css">
</head>
<body>

<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include('admin.php');

if (isset($_GET['remove_id'])) {
  $id = intval($_GET['remove_id']);

  if(!$admin->removeUser($id)){
    echo '<script>';
    echo 'alert("Buyer Removed Successfully")';
    echo 'window.location.href = "view_buyers.php"';
    echo '</script>';
  }else{
    echo '<script>';
    echo 'alert("Something Went Wrong! Please Try Again Later")';
    echo 'window.location.href = "view_buyers.php"';
    echo '</script>';
  }
}

?>

    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">OPRE</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="admin_dashboard.php">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="view_sellers.php">View Sellers</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">View Buyers</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../about.html" target="_blank">About</a>
              </li>
            </ul>

            <div class="container-fluid" style="width: 100px;"></div>
            <a class="btn btn-light" href="../logout.php" style="margin-right: 5px;">Log Out</a>
            <a class="btn btn-light" href="admin_profile.php"><?php echo $_SESSION['name']?></a>

          </div>
        </div>
    </nav>

    <br><br><br><br>


    <h2 style="color:DarkSlateGrey;">Buyers @ OPRE</h2>
    <p>Below are the buyers/users who registered to OPRE</p>
    <?php $admin->viewBuyers(); ?>

    <script>
      function removeUser(id) {
            if (confirm('Are you sure you want to remove this user?')) {
                window.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>?remove_id=' + id;
            }
        }
        
        function editUser(id){
          if (confirm('Are you sure you want edit details of this user?')) {
                window.location.href = 'editOtherUser.php?uid=' + id;
            }
        }
    </script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>