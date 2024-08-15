<?php
session_start();
include('../connect.php');

$message = "";
$extmess = "";
$error =  0;


if (!isset($_SESSION['userid'])) {
    header("Location: ../login.php");
    exit();
}


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function uploadImage($image) {
    global $message;
    global $error;
    $target_dir = "../productimages/";
    $target_file = $target_dir . basename($image["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        $message = "File is not an image.";
        $error = 1;
        $uploadOk = 0;
    }
    
    // 5 MB Limit for Images
    if ($image["size"] > 5000000) {
        $message =  "Sorry, your image file is too large.";
        $error = 1;
        $uploadOk = 0;
    }
    
    // Only .jpg, .png, .jpeg, and .gif image formats allowed
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $error = 1;
        $uploadOk = 0;
    }
    

    if ($uploadOk == 0) {
        $extmess ="Sorry, your file was not uploaded.";
        $error = 1;
        return false;
    } else {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            return $target_file;
        } else {
            $extmess = "Sorry, there was an error uploading your file.";
            $error = 1;
            return false;
        }
    }
}

// Handle form submission for updating product details
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['qty'];
    $description = $_POST['description'];

    // Image validation 
    $image_path = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../productimages/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            } else {
                $message = "Sorry, there was an error uploading your file.";
                $error = 1;
            }
        } else {
            $message = "File is not an image.";
            $error = 1;
        }
    }

    if ($image_path) {
        $sql = "UPDATE product SET pname='$name', brand='$brand', category='$category', price=$price, quantity=$quantity, description='$description', images='$image_path' WHERE pid=$id";
    } else {
        $sql = "UPDATE product SET pname='$name', brand='$brand', category='$category', price=$price, quantity=$quantity, description='$description' WHERE pid=$id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }


    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

//For submitting a new product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['newProd'])) {
    $name = $_POST['name'];
    $brand = $_POST['brand'] == 'other' ? $_POST['otherBrand'] : $_POST['brand'];
    $category = $_POST['category'] == 'other' ? $_POST['otherCat'] : $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['qty'];
    $description = $_POST['description'];
    $image_path = uploadImage($_FILES['image']);
    $uid = $_SESSION['userid'];

    if ($image_path !== false) {
        $sql = "INSERT INTO product (pname,brand,category,price,quantity,description,images,seller,status)
                VALUES ('$name', '$brand', '$category', $price, $quantity, '$description', '$image_path',$uid,0)";

        if ($conn->query($sql) === TRUE) {
            $message = "Your product entered to database successfully and is now placed for sale...";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Submission Result</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link  rel="stylesheet" href="../style.css" type="text/css">
    <style>
      .hidden{
        display: none;
      }
    </style>
    
</head>
<body>


<div class="container-sm loginbox" style="margin-top: 5%;">
<?php
   if($error == 1){
    echo"
    <div class=\"alert alert-danger\" role=\"alert\">
  <h4 class=\"alert-heading\">Error!</h4>
  <p>".$message."</p><br>
  <p>".$extmess."</p>
  <hr>
  <button type=\"button\" class=\"btn btn-outline-danger\" onclick=\"history.back();\">Edit Form</button>
  </div>";
   }  else{
        echo"
        <div class=\"alert alert-success\" role=\"alert\">
    <h4 class=\"alert-heading\">Success!</h4>
    <p>".$message."</p><br>
    <p>".$extmess."</p>
    <hr>
    <a class=\"btn btn-outline-success\" href=\"seller_dashboard.php\">Dashboard</a>
    </div>";
   }
?>
</div>


</body>