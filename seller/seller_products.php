<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Products</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link  rel="stylesheet" href="style.css" type="text/css">
    <style>
      .actionbtns{
        margin: 5px;
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

if (isset($_GET['remove_id'])) {
    $id = intval($_GET['remove_id']);

    $seller->removeProduct($id);
    header('orders.php');
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
                <a class="nav-link" aria-current="page" href="seller_dashboard.php">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="addproduct.php">Add Product</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="#">View Products</a>
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
            <a class="btn btn-lignt" href="../logout.php" style="margin-right: 5px;">Log Out</a>
            <a class="btn btn-light" href="seller_profile.php"><?php echo $_SESSION['name']?></a>

          </div>
        </div>
      </nav>

      <br><br><br><br>


    <h2 style="color:DarkSlateGrey;">Your Products</h2>
    <p>You can sort the products, you've uploaded on the below tabs...</p>


    <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane" type="button" role="tab" aria-controls="all-tab-pane" aria-selected="true">All</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="onReview-tab" data-bs-toggle="tab" data-bs-target="#onReview-tab-pane" type="button" role="tab" aria-controls="onReview-tab-pane" aria-selected="false">On Review</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="sale-tab" data-bs-toggle="tab" data-bs-target="#sale-tab-pane" type="button" role="tab" aria-controls="sale-tab-pane" aria-selected="false">For Sale</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="sold-tab" data-bs-toggle="tab" data-bs-target="#sold-tab-pane" type="button" role="tab" aria-controls="sold-tab-pane" aria-selected="false">Sold</button>
    </li>
    </ul>
    <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0"><?php $seller->viewProducts(); ?></div>
    <div class="tab-pane fade" id="onReview-tab-pane" role="tabpanel" aria-labelledby="onReview-tab" tabindex="0"><?php $seller->sortProduct(1); ?></div>
    <div class="tab-pane fade" id="sale-tab-pane" role="tabpanel" aria-labelledby="sale-tab" tabindex="0"><?php $seller->sortProduct(0); ?></div>
    <div class="tab-pane fade" id="sold-tab-pane" role="tabpanel" aria-labelledby="sold-tab" tabindex="0"><?php $seller->sortProduct(2); ?></div>
    </div>

    <script>
        function removeProduct(id) {
            if (confirm('Are you sure you want to remove this product?')) {
                window.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>?remove_id=' + id;
            }
        }

        function editProduct(id){
          if (confirm('Do you want to Edit details of this product?')) {
                window.location.href = 'editproduct.php?pid=' + id;
            }
        }

        function viewProduct(pid){
          window.location.href = 'view_product.php?pid=' + pid;
        }
    </script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>