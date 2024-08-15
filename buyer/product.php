<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link  rel="stylesheet" href="../style.css" type="text/css">
    <style>
      * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
      }
      
      
      .container {
        max-width: 75%;
        min-height: 80vh;
        margin-top: 5%;
        background: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1), 0 0 10px rgba(0, 0, 0, 0.1), 0 0 10px rgba(0, 0, 0, 0.1), 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 1rem;
      }
      
      .col {
        padding: 30px;
      }
      
      .flex {
        display: flex;
        justify-content: space-between;
      }
      
      .flex1 {
        display: flex;
      }
      
      .main_image {
        width: auto;
        height: auto;
      }
      
      .option img {
        width: 75px;
        height: 75px;
        padding: 10px;
      }
      
      .right {
        padding: 50px 100px 50px 50px;
      }
      
      h3 {
        color: #af827d;
        margin: 20px 0 20px 0;
        font-size: 25px;
      }
      
      h5,
      p,
      small {
        color: #837D7C;
      }
      
      h4 {
        color: red;
      }
      
      p {
        margin: 20px 0 30px 0;
        line-height: 25px;
      }
      
      h5 {
        font-size: 15px;
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
  
  include ('buyer.php');
  include ('cart.php');
  
  if (isset($_GET['pid'])){
    $pid = intval($_GET['pid']);
    $product = $buyer->viewProduct($pid);
    $sid = $product['seller'];
    $seller = $buyer->viewSellerName($sid);

    if (isset($_GET['add_Cartqty'])){
      $qty = intval($_GET['add_Cartqty']);
      $bid = intval($_SESSION['userid']);
      $cart->addToCart($bid,$pid,$qty);
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
                <a class="nav-link active" aria-current="page" href="buyer_home.php">Home</a>
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

<div class="container mt-2">
    <div class="row">
      <div class="col-sm-6" style="padding: 30px;">
        <div class="main_image">
          <img src="<?php echo $product['images']; ?>" class="slide" width="100%" height="100%">
        </div>
        
      </div>
      <div class="col-sm-5" style="padding: 30px;">
        <h3><?php echo $product['pname']; ?></h3>
        <h4> <small>INR</small> <?php echo $product['price']; ?> </h4>
        <h5><b>Seller:</b> <?php echo $seller; ?></h5>
        <p><?php echo $product['description']; ?></p>
        <h5><b>Brand:</b> <?php echo $product['brand']; ?></h5>
        <h5><b>Category:</b> <?php echo $product['category']; ?></h5>
        <h5><b>Available Stock:</b> <?php echo $product['quantity']; ?></h5> 
        <br>
        <label for="qty" class="form-contorl" style="color: #837D7C;">Quantity: </label>
        <select name="qty" class="form-control" id="qty" style="width: 4rem;" title="Click to choose how many units of this product you want">
            <?php 
              $qty = $product['quantity'];
              $display = 1;
              while($display <= $qty){
                echo '<option class="form-control" value="'.$display.'">'.$display.'</option>';
                $display ++;
              }
            ?>
        </select>
        <br><br>
        <button class="btn btn-outline-primary" style="width: 100%;" onclick="addtoCart(<?php echo $product['pid']; ?>)">Add to Cart</button>
        <a class="btn btn-primary" style="width: 100%;margin-top: 5px;" href="buyer_cart.php">View Cart</a>
      </div>
  </div>
</div>

<script>
    function addtoCart(pid){
        let quantity = document.getElementById('qty').value;
        console.log(quantity);
        if (confirm('Are you sure you want to add this product to cart?')) {
                window.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>?pid=' + pid + '&add_Cartqty=' + quantity;
        }
    }
</script>

</body>
</html>