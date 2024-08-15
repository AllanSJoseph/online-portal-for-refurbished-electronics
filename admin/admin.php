<?php

include("../connect.php");

class Admin{

  function returnSummary(){
    $summary = [0,0,0];
    global $conn;
  
    $stmt = $conn->prepare("SELECT type, COUNT(*) as count FROM users GROUP BY type");
    $stmt->execute();
    $plist = $stmt->get_result();

    if ($plist->num_rows != 0) {
      $count = 0;
      while($row = $plist->fetch_assoc()){
          $summary[$count] = $row['count'];
          $count++;
      }
    }
    $stmt->close();
    return $summary;
  }
  function displayUserTable($plist){
    echo "<table class=\"table table-hover\">
        <thead>
          <tr>
            <th scope=\"col\">User Id</th>
            <th scope=\"col\">Name</th>
            <th scope=\"col\">Email</th>
            <th scope=\"col\">Phone No</th>
            <th scope=\"col\">Actions</th>
          </tr>
        </thead>
        <tbody>";
    
    while ($row = $plist->fetch_assoc()) {
      echo '<tr>';
      echo '<td>' . $row['userid'] . '</td>';
      echo '<td>' . $row['name'] . '</td>';
      echo '<td>' . $row['email'] . '</td>';
      echo '<td>' . $row['mob_no'] . '</td>';
      echo '<td><button class="btn btn-outline-primary" onclick="editUser('.$row["userid"].')">Edit</button><button class="btn btn-outline-danger" onclick="removeUser('.$row["userid"].')">Remove</button></td>';
      echo '</tr>';
    }
  }
  function viewSellers(){
    //View Sellers
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE type = 'Seller'");
    $stmt->execute();
    $plist = $stmt->get_result();
  
    if ($plist->num_rows === 0) {
      echo "<div class=\"alert alert-primary\">
      <strong>No Users!</strong><br> There are no Users in this category</div>";
    } else {
      $this->displayUserTable($plist);
    }
  }

  function viewBuyers(){
    //View Buyers
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE type = 'Buyer'");
    $stmt->execute();
    $plist = $stmt->get_result();
  
    if ($plist->num_rows === 0) {
      echo "<div class=\"alert alert-primary\">
      <strong>No Users!</strong><br> There are no Users in this category</div>";
    } else {
      $this->displayUserTable($plist);
    }
  }

  function removeUser($userId){
    //Removes user from the database
    global $conn;
    $sql = "DELETE FROM users WHERE userid = $userId";

    if ($conn->query($sql) === TRUE) {
        return 0;
    } else {
        echo "Error deleting record: " . $conn->error;
        return 1;
    }
  }

}


$admin = new Admin();