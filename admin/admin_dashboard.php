<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link  rel="stylesheet" href="../style.css" type="text/css">
    <style>
      .summary_container{
            margin: 1rem;
            padding-left: 1rem;
            padding-right: 1rem;
        }

      .summary_card{
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1), 0 0 10px rgba(0, 0, 0, 0.1), 0 0 10px rgba(0, 0, 0, 0.1), 0 0 10px rgba(0, 0, 0, 0.1);
      }

      .summary_card:hover{
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2), 0 0 10px rgba(0, 0, 0, 0.2), 0 0 10px rgba(0, 0, 0, 0.2), 0 0 10px rgba(0, 0, 0, 0.2);
      }
    </style>
</head>
<body>

<?php
session_start();


if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include ('admin.php');

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
                <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="view_sellers.php">View Sellers</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="view_buyers.php">View Buyers</a>
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


      <?php 
        $sum = $admin->returnSummary();
      ?>

    <h1 class="text-center">Welcome <?php echo $_SESSION['name']?></h1>
    <h2 class="text-center">Admin Dashboard</h2>



    <div class="container d-flex justify-content-center">
        <div class="card-group summary_container">
            <div class="col">
                <div class="card summary_card">
                <img src="../res/user_icons/buyer.png" width="100%" height="200" style="border-top-radius: 1rem;">
                <div class="card-body">
                    <h5 class="card-title text-center">No of registered <br> BUYERS</h5>
                    <h1 class="card-text text-center"><?php echo $sum[1]; ?></h1>
                </div>
                </div>
            </div>
            <div class="col">
                <div class="card summary_card">
                <img src="../res/user_icons/seller.png" width="100%" height="200" style="border-top-radius: 1rem;">
                <div class="card-body">
                    <h5 class="card-title text-center">No of registered <br> SELLERS</h5>
                    <h1 class="card-text text-center"><?php echo $sum[2]; ?></h1>
                </div>
                </div>
            </div>
        </div>
    </div>

      

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>