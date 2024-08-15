<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link  rel="stylesheet" href="stylle.css" type="text/css">
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

$bid = intval($_SESSION['userid']);


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
                <a class="nav-link" href="buyer_cart.php">Cart</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Your Orders</a>
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

      <h1 style="color:DarkSlateGrey;">Your Orders</h1>

      <?php
      $orderedProds = $cart->viewOrders($bid);
      if(empty($orderedProds)){
        echo "<centre><p><b>You have not placed any orders...</b></p><centre>";
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
  
            foreach($orderedProds as $row){
              $status = $row['status'];
              if ($status === NULL){
                $statusTxt = "<p class=\"text-muted\">RESPONSE PENDING</p>";
              }else if($status === 0){
                $statusTxt = "<p class=\"text-success\">SELLER ACCEPTED</p>";
              }else if($status === 1){
                $statusTxt = "<p class=\"text-danger\">SELLER REJECTED</p>";
              }
              echo '<tr>';
                echo '<td>' . $count . '</td>';
                echo '<td><img src="'.$row["images"].'" width="100px" height="100px"></td>';
                echo '<td>' . $row["pname"] . '</td>';
                echo '<td>' . $row["qty"] . '</td>';
                echo '<td>' . $row["price"] . '</td>';
                echo '<td>' . $row["order_date"] . '</td>';
                echo '<td>' . $statusTxt . '</td>';
                echo '<td><button class="btn btn-outline-primary" onclick="viewSeller('.$row['sid'].')">Seller Details</button></td>';
                echo '</tr>';
  
                $count++;
            }
      }
      ?>

<div id="myModal" class="modal">
    <div class="modal-content">
        <div id="modal-body" class="modal-body"></div>
        <br>
        <button class="btn btn-primary" onclick="closeModal()">Close</button>
    </div>
</div>


      <script>
          function viewSeller(sid) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "view_seller.php?sid=" + sid, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("modal-body").innerHTML = xhr.responseText;
                    document.getElementById("myModal").style.display = "block";
                }
            };
          xhr.send();
          }

          function closeModal() {
              document.getElementById("myModal").style.display = "none";
          }

          window.onclick = function(event) {
              if (event.target == document.getElementById("myModal")) {
                  closeModal();
              }
          }
      </script>
      <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>