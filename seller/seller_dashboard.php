<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
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
// include('connect.php');
 
include('seller_class.php');



if (!isset($_SESSION['userid'])) {
    header("Location: ../login.php");
    exit();
}

$seller->calcSellerSummary();
$sum = $seller->returnSellerSummary();

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
                <a class="nav-link" href="addproduct.php">Add Product</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="seller_products.php">View Products</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="review_orders.php">Review Orders</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="order_history.php">Order History</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../about.html" target="_blank">About</a>
              </li>
            </ul>

            <div class="container-fluid" style="width: 100px;"></div>
            <a class="btn btn-light" href="../logout.php" style="margin-right: 5px;">Log Out</a>
            <a class="btn btn-light" href="seller_profile.php"><?php echo $_SESSION['name']?></a>

          </div>
        </div>
    </nav>

    <br><br><br><br>


    <h1 class="text-center">Welcome <?php echo $_SESSION['name']?></h1>
    <h2 class="text-center">Summary</h2>



    <div class="container d-flex justify-content-center">
        <div class="card-group summary_container">
            <div class="col">
                <div class="card summary_card">
                <img src="../res/seller_icons/ForSale.png" width="100%" height="200" style="border-top-radius: 1rem;">
                <div class="card-body">
                    <h5 class="card-title text-center">Products <br> ON SALE</h5>
                    <h1 class="card-text text-center"><?php echo $sum[0]; ?></h1>
                </div>
                </div>
            </div>
            <div class="col">
                <div class="card summary_card">
                <img src="../res/seller_icons/review.png" width="100%" height="200" style="border-top-radius: 1rem;">
                <div class="card-body">
                    <h5 class="card-title text-center">Products <br> ON REVIEW</h5>
                    <h1 class="card-text text-center"><?php echo $sum[1]; ?></h1>
                </div>
                </div>
            </div>
            <div class="col">
                <div class="card summary_card">
                <img src="../res/seller_icons/sold.jpg" width="100%" height="200" style="border-top-radius: 1rem;">
                <div class="card-body">
                    <h5 class="card-title text-center">Products <br> SOLD</h5>
                    <h1 class="card-text text-center"><?php echo $sum[2]; ?></h1>
                </div>
                </div>
            </div>
        </div>
    </div>


<div class="card mb-3" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Add an item for Sale?</h5>
    <p class="card-text">Place a product on sale from the link below</p>
    <a href="addproduct.php" class="btn btn-primary">Add Product</a>
  </div>
</div>

<?php 
  if($sum[1] != 0){
    echo "<div class=\"card mb-3\" style=\"width: 18rem;\">
    <div class=\"card-body\">
      <h5 class=\"card-title\">".$sum[1]." People are awaiting your response</h5>
      <p class=\"card-text\">Check who all are planning to buy the item...</p>
      <a href=\"review_product.php\" class=\"btn btn-primary\">Review Product</a>
    </div>
  </div>";
  }
?>

      
    
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>