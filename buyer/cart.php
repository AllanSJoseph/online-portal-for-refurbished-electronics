<?php

include('../connect.php');

class Cart{
    function addToCart($bid,$pid,$qty){
      //Add Product to cart
      global $conn;
      $stmt = $conn->prepare("INSERT INTO cart (b_id, p_id, qty) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE qty = ?");
      $stmt->bind_param("iiii", $bid, $pid, $qty, $qty);

      if ($stmt->execute()) {
          echo "<script>alert('Product Added to Cart Successfully')</script>";
      } else {
          echo "Error: " . $stmt->error;
      }

      $stmt->close();
    }

  function viewCart($bid){
      //View Cart
      global $conn;
      $sql = "SELECT c.c_id, c.b_id, c.qty, p.pid, p.pname, p.price, p.images, p.seller
      FROM cart c
      INNER JOIN product p ON c.p_id = p.pid
      WHERE c.b_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $bid);
      $stmt->execute();
      $result = $stmt->get_result();

      $cartPrds = [];

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cartPrds[] = $row;
        }
      }

      $stmt->close();
      return $cartPrds;
  }

  function removeFromCart($cid){
      //Remove Item from Cart
      global $conn;
      $sql = "DELETE FROM cart WHERE c_id = $cid";

      if ($conn->query($sql) === TRUE) {
          echo "<script>alert('Item Removed from cart successfully');</script>";
          header("Location: buyer_cart.php");
      } else {
          echo "Error deleting record: " . $conn->error;
      }
  }

  function OrderProduct($bid,$pid,$sid,$qty){
      //The product is put on review and it is requested to the seller, the buyer details are given to seller
      global $conn;

      $stmt = $conn->prepare("INSERT INTO orders (bid, pid, sid,qty,order_date) VALUES (?, ?, ?, ?, ?)");
      $currDate = date("Y-m-d");
      $stmt->bind_param("iiiis", $bid, $pid, $sid, $qty,$currDate);

      if ($stmt->execute()) {
          echo "Order had been placed";
      } else {
          echo "Error: " . $stmt->error;
      }

      $stmt->close();
      
  }

  function viewOrders($bid){
      //Orders Placed by the user..
      global $conn;

      $sql = "SELECT o.order_id, o.sid, o.qty, o.order_date, o.status, p.pname, p.images, p.price
      FROM orders o
      INNER JOIN product p ON o.pid = p.pid
      WHERE o.bid = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $bid);
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

  function checkout($cartProds){
      //If the Seller Approves, the product is considered sold and order will be archived...
      global $conn;
      if(empty($cartProds)){
        echo "<script>alert('Nothing in cart to checkout...');</script>";
      }else{
        foreach($cartProds as $row){
          $bid = $row['b_id'];
          $pid = $row['pid'];
          $sid = $row['seller'];
          $qty = $row['qty'];

          $this->OrderProduct($bid,$pid,$sid,$qty);

          $sql = "UPDATE product SET status = 1";
          $conn->query($sql);
          
        }

        $sql = "DELETE FROM cart WHERE b_id = $bid";
        $conn->query($sql);

      }
  }

  function calcTotalPrice($bid){
    global $conn;
      $sql = "SELECT SUM(p.price) AS total_price
      FROM cart c
      INNER JOIN product p ON c.p_id = p.pid
      WHERE c.b_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $bid);
      $stmt->execute();
      $result = $stmt->get_result();
      $total_price =0;

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_price = $row['total_price'];
      }

      $conn->close();
      return $total_price;
  }
}

$cart = new Cart();