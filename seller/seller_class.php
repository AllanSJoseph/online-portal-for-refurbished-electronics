<?php

include("../connect.php");

class Seller{
    public $summary = [0,0,0];
    function calcSellerSummary(){
        global $conn;
  
        $stmt = $conn->prepare("SELECT status, COUNT(*) as count FROM product WHERE seller = ? GROUP BY status");
        $stmt->bind_param("s", $_SESSION['userid']); 
        $stmt->execute();
        $plist = $stmt->get_result();
  
      if ($plist->num_rows != 0) {
        while($row = $plist->fetch_assoc()){
            $this->summary[$row['status']] = $row['count'];
        }
      }
    }

    function returnSellerSummary(){
        return $this->summary;
    }
    
    function displayProductTable($plist){
      
  
      $statusTxt = "";
      echo "<table class=\"table table-hover\">
        <thead>
          <tr>
            <th scope=\"col\">#</th>
            <th scope=\"col\">Product Image</th>
            <th scope=\"col\">Name</th>
            <th scope=\"col\">Brand</th>
            <th scope=\"col\">Category</th>
            <th scope=\"col\">Quantity</th>
            <th scope=\"col\">Price</th>
            <th scope=\"col\">Status</th>
            <th scope=\"col\">Actions</th>
          </tr>
        </thead>
        <tbody>";
        $count =1;
        while ($row = $plist->fetch_assoc()) {
          $status = $row["status"];
          if($status == 0){
            $statusTxt = "<p class=\"text-success\">ON SALE</p>";
            $aBtns = "<button class=\"btn btn-outline-danger actionbtns\" onclick=\"removeProduct(".$row["pid"].")\">Remove</button><button class=\"btn btn-outline-primary actionbtns\" onclick=\"editProduct(".$row["pid"].")\">Edit</button><button class=\"btn btn-outline-secondary actionbtns\" onclick=\"viewProduct(".$row["pid"].")\">Product Details</button>";
          }else if($status == 1){
            $statusTxt = "<p class=\"text-muted\">On Review</p>";
            $aBtns = "<a class=\"btn btn-outline-success actionbtns\" href=\"review_orders.php\">Review Order</a><button class=\"btn btn-outline-primary actionbtns\" onclick=\"editProduct(".$row["pid"].")\">Edit</button><button class=\"btn btn-outline-secondary actionbtns\" onclick=\"viewProduct(".$row["pid"].")\">Product Details</button>";
          }else{
            $statusTxt = "<p class=\"text-danger\">SOLD</p>";
            $aBtns = "<button class=\"btn btn-outline-secondary actionbtns\" onclick=\"viewProduct(".$row["pid"].")\">Product Details</button>";
          }
          
          echo "<tr>
            <th scope=\"row\">$count</th>
            <td><img src=\"$row[images]\" width=\"100px\" height=\"100px\"></td>
            <td>".$row["pname"]."</td>
            <td>".$row["brand"]."</td>
            <td>".$row["category"]."</td>
            <td>".$row["quantity"]."</td>
            <td>₹ ".$row["price"]."</td>
            <td>".$statusTxt."</td>
            <td>".$aBtns."</td>
          </tr>";
          $count++;
        }
        echo "</tbody></table>";
    }
    function viewProducts(){
      global $conn;
  
      $stmt = $conn->prepare("SELECT * FROM product WHERE seller = ?");
      $stmt->bind_param("s", $_SESSION['userid']); 
      $stmt->execute();
      $plist = $stmt->get_result();
  
      if ($plist->num_rows === 0) {
        echo "<div class=\"alert alert-primary\">
        <strong>No Products Placed!</strong><br> You haven't placed any products for sale...</div>";
      } else {
        $this->displayProductTable($plist);
      }
    }
  
    function sortProduct($type){
      global $conn;
  
      $stmt = $conn->prepare("SELECT * FROM product WHERE status = ".$type." AND seller = ?");
      $stmt->bind_param("s", $_SESSION['userid']); 
      $stmt->execute();
      $plist = $stmt->get_result();
  
      if ($plist->num_rows === 0) {
        echo "<div class=\"alert alert-primary\">
        <strong>Nothing to Show!</strong><br> No Orders have been placed yet...</div>";
      } else {
        $this->displayProductTable($plist);
      }
    }

    function viewBuyer($b_id){
      global $conn;
      $stmt = $conn->prepare("SELECT * FROM users WHERE userid=?");
      $stmt->bind_param("s",$b_id);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0){
          while ($row = $result->fetch_assoc()) {
              echo "<h4>Details of the Buyer:</h4>";
              echo "<b>Name:</b> " . $row['name'] . "<br>";
              echo "<b>Email:</b> " . $row['email'] . "<br>";
              echo "<b>Phone:</b> " . $row['mob_no'] . "<br>";
              echo "<b>Address:</b> " . $row['address'] . "<br>";
          }
      }else{
          echo "<h4>Buyer not Found :(</h4>";
      }
    }

    function showProduct($p_id){
      global $conn;
      $stmt = $conn->prepare("SELECT * FROM product WHERE pid=?");
      $stmt->bind_param("i",$p_id);
      $stmt->execute();
      $result = $stmt->get_result();


      if ($result->num_rows > 0){
          $row = $result->fetch_assoc();
          return $row;
      }else{
          echo "Product Not Found";
      }
    }
  
    function removeProduct($delete_id){
        global $conn;
        $sql = "DELETE FROM product WHERE pid = $delete_id";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record deleted successfully');</script>";
            header("Location: seller_products.php");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
  
    }

    function validateQuantity($oid){
      global $conn;
      //Validates the Quantity of a Product...
      $sql = "SELECT o.qty, p.pid, p.quantity
      FROM orders o
      INNER JOIN product p ON o.pid = p.pid
      WHERE o.order_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i",$oid);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $orderedQty = intval($row['qty']);
        $availableQty = intval($row['quantity']);
        $pid = intval($row['pid']);

        if($orderedQty < $availableQty){
          $availableQty = $availableQty - $orderedQty;
          $stmt1 = $conn->prepare("UPDATE product SET status=0, quantity=? WHERE pid=?");
          $stmt1->bind_param("ii",$availableQty,$pid);
          $stmt1->execute();
          return 0;
        }else if($orderedQty == $availableQty){
          $availableQty = 0;
          $stmt1 = $conn->prepare("UPDATE product SET status=2, quantity=? WHERE pid=?");
          $stmt1->bind_param("ii",$availableQty,$pid);
          $stmt1->execute();
          return 0;
        }else{
          // echo '<script>alert("Sorry, We can\'t accept this order, Low Available Quantity");</script>';
          return 1;
        }
      }

    }

    function viewOrders($sid){
      //Function which views the orders placed by buyer
      global $conn;

      $sql = "SELECT o.order_id, o.bid, o.qty, o.order_date, o.status, p.pname, p.images, p.price
      FROM orders o
      INNER JOIN product p ON o.pid = p.pid
      WHERE o.sid = ? AND o.status IS NULL";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $sid);
      $stmt->execute();
      $result = $stmt->get_result();

      $orderedProds = [];

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orderedProds[] = $row;
        }
      }

      $stmt->close();
      return $orderedProds;
    }

    function viewPastOrders($sid){
      //Function which views the past accepted orders
      global $conn;

      $sql = "SELECT o.order_id, o.bid, o.qty, o.order_date, o.status, p.pname, p.images, p.price
      FROM orders o
      INNER JOIN product p ON o.pid = p.pid
      WHERE o.sid = ? AND o.status = 0";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $sid);
      $stmt->execute();
      $result = $stmt->get_result();

      $orderedProds = [];

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orderedProds[] = $row;
        }
      }

      $stmt->close();
      return $orderedProds;
    }

    function reviewProduct($decision,$oid){
      global $conn;
        if($decision == 0){
            echo "Request Accepted";
            $confirmQty = $this->validateQuantity($oid);
            if($confirmQty == 0){
              $stmt2 = $conn->prepare("UPDATE orders SET status=0 WHERE order_id = ?");  //Status set to 0 means the order is accepted
              $stmt2->bind_param('i',$oid);
              $stmt2->execute();
              echo '<script>';
              echo 'alert("Product Approved Successfully!!");';
              echo 'window.location.href = "review_orders.php";';
              echo '</script>';
            }else{
              echo '<script>';
              echo 'alert("Sorry, We can\'t accept this order, Low Available Quantity");';
              echo 'window.location.href = "review_orders.php";';
              echo '</script>';
            }
            
        }else{
            echo "Request Rejected";
            $stmt = $conn->prepare("UPDATE orders SET status=1 WHERE order_id = ?");  //Status set to 1 means the order is rejected
            $stmt->bind_param('i',$oid);
            $stmt->execute();
            echo '<script>';
            echo 'alert("Order Rejected Successfully!!");';
            echo 'window.location.href = "review_orders.php";';
            echo '</script>';
        }
    }
  }
  
  $seller = new Seller();