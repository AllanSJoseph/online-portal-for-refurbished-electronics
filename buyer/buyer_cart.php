<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link  rel="stylesheet" href="../style.css" type="text/css">
</head>
<body>


<?php
session_start();

// Check if the session variable is not set
if (!isset($_SESSION['email'])) {
    // Redirect to login.php
    header("Location: login.php");
    exit();
}

include ('buyer.php');
include('cart.php');

$bid = intval($_SESSION['userid']);
$cartProds = $cart->viewCart($bid);

if(isset($_GET['removeCartId'])){
  $cartid = intval($_GET['removeCartId']);
  $cart->removeFromCart($cartid);
}

if(isset($_GET['checkout'])){
  // echo "<script> alert('Checkout is paged')</script>";
  $cart->checkout($cartProds);

  echo '<script>alert("Checkout Successfull!!");';
  header("Location: buyer_cart.php");
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
                <a class="nav-link" href="buyer_home.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Cart</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="orders.php">Your Orders</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../about.html" target="_blank">About</a>
              </li>
            </ul>

            <form class="d-xl-flex navform" role="search" method="GET" action="search.php">
                <div class="input-group">
                    <select name="category" id="cars" class="btn btn-outline-secondary" style="width: 4rem;">
                        <option class="dropdown-item" value="all">All</option>
                        <?php $buyer->showCategories(); ?>
                    </select>
                    <input name="query" id="query" class="form-control search" style="width: 10rem;" type="search" placeholder="Enter item for search" aria-label="Search">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
                
            </form>
            <div class="container-fluid" style="width: 100px;"></div>
            <a class="btn btn-light" href="../logout.php" style="margin-right: 5px;">Log Out</a>
            <a class="btn btn-light" href="buyer_profile.php"><?php echo $_SESSION['name']?></a>

          </div>
        </div>
</nav>

<br><br><br><br>


    <h1 style="color:DarkSlateGrey;">Your Cart</h1>

    <?php  
    if(empty($cartProds)){
      echo "<centre><p><b>No products in the cart...</b></p><centre>";
      $disabled = "disabled";
    }else{
      echo '<table border="1">';
          echo '<table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Product Image</th>
              <th scope="col">Name</th>
              <th scope="col">Quantity</th>
              <th scope="col">Price</th>
              <th scope="col">Actions</th>
            </tr>
          </thead><tbody>';

          $disabled = "";

          $count = 1;

          foreach($cartProds as $row){
            echo '<tr>';
              echo '<td>' . $count . '</td>';
              echo '<td><img src="'.$row["images"].'" width="100px" height="100px"></td>';
              echo '<td>' . $row["pname"] . '</td>';
              echo '<td>' . $row["qty"] . '</td>';
              echo '<td>' . $row["price"] . '</td>';
              echo '<td><button class="btn btn-outline-danger" onclick="removefrmCart(' .$row["c_id"]. ')">Remove</button></td>';
              echo '</tr>';

              $count++;
          }
    }
    
    ?>


    <br><br>

    <table class="table">
        <thead>
            <tr>
                <th>Total Price: </th>
                <th><?php echo $cart->calcTotalPrice($bid); ?></th>
                <th style="width: 50%;"></th>
                <th><a href="buyer_home.php" class="btn btn-outline-secondary" style="width: fit-content; margin-right: 5%;">Continue Shopping</a></th>
                <th><button class="btn btn-success <?php echo $disabled; ?>" style="width: fit-content; margin-right: 5%;" onclick="checkout()">Checkout</button></th>
            </tr>
        </thead>
        
    </table>

    <script>
      function removefrmCart(cid){
        if (confirm('Are you sure you want to remove this product from cart?')) {
            window.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>?removeCartId=' + cid;
        }
      }

      function checkout(){
        if(confirm('Do you want to place an order for all products in the cart?')){
          window.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>?checkout=1';
        }
      }
    </script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>