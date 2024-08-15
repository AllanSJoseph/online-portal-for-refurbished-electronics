<?php

include("../connect.php");

class Buyer{
    function viewProducts(){
        global $conn;
        $query = "SELECT * from product WHERE status <> 2";

        $result = $conn->query($query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        $products = [];

        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }

    function viewProduct($p_id){
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

    function searchProduct($searchQuery,$category){
        //This feature is halfbaked as of now, It may not work as intended
        global $conn;
        $keywords = "/under|below|above|over/i";
        $sql = "select * from product WHERE";

        if (preg_match($keywords,$searchQuery)){
            $components = preg_split($keywords, $searchQuery);
            print_r($components);
            if (preg_match("/under|below/",$searchQuery)){
                $sqln = "$sql pname LIKE '%$components[0]%' AND category = '$category' AND price <= '$components[1]'";
            }else {
                $sqln = "$sql pname LIKE '%$components[0]%' AND category = '$category' AND price >= '$components[1]'";
            }
            
        }else {
            $sqln = "$sql pname LIKE '%$searchQuery%' OR category = '$category'";
        }


        $stmt = $conn->prepare($sqln);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];

        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }

    function viewSeller($u_id){
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE userid=?");
        $stmt->bind_param("s",$u_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                echo "<h4>Details of the Seller:</h4>";
                echo "<b>Name:</b> " . $row['name'] . "<br>";
                echo "<b>Email:</b> " . $row['email'] . "<br>";
                echo "<b>Phone:</b> " . $row['mob_no'] . "<br>";
                echo "<b>Address:</b> " . $row['address'] . "<br>";
            }
        }else{
            echo "<h4>Seller not Found :(</h4>";
        }
    }

    function viewSellerName($u_id){
        global $conn;
        $stmt = $conn->prepare("SELECT name FROM users WHERE userid=?");
        $stmt->bind_param("s",$u_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                return $row['name'];
            }
        }else{
            return 'Error Finding Name';
        }
    }

    function showCategories(){
        global $conn;
        $stmt = $conn->prepare("SELECT DISTINCT category FROM product");
        $stmt->execute();
        $plist = $stmt->get_result();
    
        while($row = $plist->fetch_assoc()){
          echo '<option class="dropdown-item" value="'.$row['category'].'">'.$row['category'].'</option>';
        }
    }
}

$buyer = new Buyer();