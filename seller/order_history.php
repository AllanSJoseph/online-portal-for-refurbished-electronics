<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Orders</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- <link  rel="stylesheet" href="../style.css" type="text/css"> -->
    <style>
      .modal {
          display: none;
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-color: rgba(0, 0, 0, 0.6);
          backdrop-filter: blur(3px);
          z-index: 5;
      }

      .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70%;

        background-color: white;
        padding: 3rem;
        border-radius: 5px;
        box-shadow: 0 3rem 5rem rgba(0, 0, 0, 0.3);
        font-size: larger;
        z-index: 10;
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

$sid = intval($_SESSION['userid']);
$orders = $seller->viewPastOrders($sid);



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
                <a class="nav-link" href="seller_products.php">View Products</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="review_orders.php">Review Orders</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Order History</a>
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


    <h2 style="color:DarkSlateGrey;">Order History</h2>
    <p>Showing the past accepted orders...</p>

    <?php
    if(empty($orders)){
        echo "<centre><p class='text-centre'><b>No products</b></p><centre>";
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
                <th scope="col">Order Date</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead><tbody>';
  
            $disabled = "";
  
            $count = 1;
  
            foreach($orders as $row){
              $status = $row['status'];
              if ($status == NULL){
                $statusTxt = "<p class=\"text-muted\">RESPONSE PENDING</p>";
              }else if($status == 0){
                $statusTxt = "<p class=\"text-success\">SELLER ACCEPTED</p>";
              }else if($status == 1){
                $statusTxt = "<p class=\"text-danger\">SELLER REJECTED</p>";
              }
              echo '<tr>';
                echo '<td>' . $count . '</td>';
                echo '<td><img src="'.$row["images"].'" width="100px" height="100px"></td>';
                echo '<td>' . $row["pname"] . '</td>';
                echo '<td>' . $row["qty"] . '</td>';
                echo '<td>' . $row["price"] . '</td>';
                echo '<td>' . $row["order_date"] . '</td>';
                echo '<td><p class="text-success">SELLER ACCEPTED</p></td>';
                echo '<td><button class="btn btn-outline-primary" onclick="viewBuyer('.$row['bid'].')">Buyer Details</button>';
                echo '</tr>';
  
                $count++;
            }
      }
      ?>

        <div id="myModal" class="modal">
            <div class="modal-content">
                <div id="modal-body"></div>
                <br>
                <button class="btn btn-primary" onclick="closeModal()">Close</button>
            </div>
        </div>

    <script src="script.js"></script>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>