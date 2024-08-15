<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link  rel="stylesheet" href="../style.css" type="text/css">
    <style>
        * {
            box-sizing: border-box;
        }

        .container1 {
            display: flex;

            justify-content: space-evenly;
            flex-wrap: wrap;
        }

        .card {
            margin: 10px;
            /* background-color: #e9ecef; */
            border-radius: 10px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 300px;
        }

        .card-header img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            /* background-color: #e9ecef; */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
            min-height: 250px;
        }

        .btn-outline-primary{
            width: 100%;
        }
    </style>
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

$products = $buyer->viewProducts();

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
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="buyer_cart.php">Cart</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="orders.php">Your Orders</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../about.html" target="_blank">About</a>
              </li>
            </ul>

            <form class="d-xl-flex navform" role="search"  method="GET" action="search.php">
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

      <h1 style="color:DarkSlateGrey;">Welcome <?php echo $_SESSION['name']?></h1>

      <div class="container1">
        <?php

        foreach ($products as $product) {
            echo '<div class="card">';
            echo '<div class="card-header">';
            echo '<img src="'. $product['images'] .'" alt="' . $product['pname'] . '" width="250px" height="250px">';
            echo '</div>';
            echo '<div class="card-body">';
            echo '<h3>' . $product['pname'] . '</h3>';
            echo '<p>Price: ₹' . $product['price'] . '</p>';
            echo '<p>Brand: ' . $product['brand'] . '</p>';
            echo '<p>Category: ' . $product['category'] . '</p>'; 
            echo '<p> ' . $product['description'] . '</p>';
            echo '<a class="btn btn-outline-primary" href="product.php?pid='.$product['pid'].'">More Details</a>';
            echo '</div>';
            echo '</div>';
        }

        ?>
    </div>


      <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>