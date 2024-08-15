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
  
  include ('seller_class.php');
  
  if (isset($_GET['pid'])){
    $pid = intval($_GET['pid']);
    $product = $seller->showProduct($pid);
  }

?>


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
        <p><?php echo $product['description']; ?></p>
        <h5><b>Brand:</b> <?php echo $product['brand']; ?></h5>
        <h5><b>Category:</b> <?php echo $product['category']; ?></h5>
        <h5><b>Available Stock:</b> <?php echo $product['quantity']; ?></h5> 
        <br>
        <br><br>
        <a class="btn btn-outline-secondary" style="width: 100%;margin-top: 5px;" href="seller_products.php">Back</a>
      </div>
  </div>
</div>

</body>
</html>