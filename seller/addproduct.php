<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place a Product for Sale</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link  rel="stylesheet" href="../style.css" type="text/css">
    <style>
      .hidden{
        display: none;
      }
    </style>
    
</head>
<body>

<?php
session_start();
include('../connect.php');



if (!isset($_SESSION['userid'])) {
    header("Location: ../login.php");
    exit();
}

function showCategories(){
    global $conn;
    $stmt = $conn->prepare("SELECT DISTINCT category FROM product");
    $stmt->execute();
    $plist = $stmt->get_result();

    while($row = $plist->fetch_assoc()){
      echo "<option value=\"".$row['category']."\">".$row['category']."</option>";
    }
}

function showBrands(){
  global $conn;
  $stmt = $conn->prepare("SELECT DISTINCT brand FROM product");
  $stmt->execute();
  $plist = $stmt->get_result();

  while($row = $plist->fetch_assoc()){
    echo "<option value=\"".$row['brand']."\">".$row['brand']."</option>";
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
                <a class="nav-link" href="seller_dashboard.php">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active"  aria-current="page" href="#">Add Product</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="seller_products.php">View Products</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="review_orders.php">Review Orders</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="order_history.php">Order History</a>
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

      <div class="container-sm" style="margin-top: 2%;">
        <h1 style="color:DarkSlateGrey;text-align: center;"><b>Place a Product for Sale</b></h1>


        <form onsubmit="return validate()" method="POST" enctype="multipart/form-data" action="submitproduct.php">
          <label for="name" class="form-label">Name of the Product:</label>
          <input type="text" class="form-control" id="name" name="name" ><br>

          <label for="brand" class="form-label">Brand:</label>
          <select id="brand" class="form-control" name="brand" onchange="handleBrandSelection()">
              <option value="" disabled selected>Select a brand</option>
              <?php showBrands(); ?>
              <option value="other">Other</option>
          </select>
          <div id="otherBrandDiv" class="hidden form-control">
            <label for="otherBrand">Add a New Brand:</label>
            <input type="text" id="otherBrand" class="form-control" name="otherBrand">
          </div><br>
          <div class="alert alert-warning alert-dismissible">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <strong>Tip!</strong> If your desired brand does not exist, select the other option in the dropdown...
          </div>
          <br>

          <label for="category" class="form-label">Category:</label>
          <select id="category" class="form-control" name="category" onchange="handleCatSelection()">
              <option value="" disabled selected>Select your product category</option>
              <?php showCategories(); ?>
              <option value="other">Other</option>
          </select><div id="otherCatDiv" class="hidden form-control">
            <label for="otherCat">Add a New Category:</label>
            <input type="text" id="otherCat" class="form-control" name="otherCat">
          </div><br>
          <div class="alert alert-warning alert-dismissible">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <strong>Tip!</strong> If your desired category does not exist, select the other option in the dropdown...
          </div>
          <br>
          
          <label for="price" class="form-label">Enter your Price:</label>
          <input type="number" class="form-control" id="price" name="price" ><br>

          <label for="qty" class="form-label">Enter Quantity:</label>
          <input type="number" class="form-control" id="qty" name="qty" ><br>

          <label for="description" class="form-label">Enter Some more details of your product:</label>
          <textarea name="description" id="description" class="form-control" rows="10" cols="20"></textarea>
          <br>

          <label for="image" class="form-label">Upload an image of the product: </label>
          <input type="file" class="form-control" id="image" name="image" accept="image/*" style="margin-top: 10px; display: block;"><br>

          <input type="submit" class="btn btn-outline-success" name="newProd" value="Submit"><br><br>
        </form>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
      function handleBrandSelection() {
            const brandSelect = document.getElementById('brand');
            const otherBrandDiv = document.getElementById('otherBrandDiv');
            const otherBrandInput = document.getElementById('otherBrand');

            if (brandSelect.value === 'other') {
                otherBrandDiv.classList.remove('hidden');
            } else {
                otherBrandDiv.classList.add('hidden');
                brandSelect.disabled = false;
                otherBrandInput.value = '';
            }
        }

        function handleCatSelection() {
            const CatSelect = document.getElementById('category');
            const otherCatDiv = document.getElementById('otherCatDiv');
            const otherCatInput = document.getElementById('otherCat');

            if (CatSelect.value === 'other') {
                otherCatDiv.classList.remove('hidden');
            } else {
                otherCatDiv.classList.add('hidden');
                CatSelect.disabled = false;
                otherCatInput.value = '';
            }
        }

        function validate(){
            let pname = document.getElementById('name').value;
            let brand = document.getElementById('brand').value;
            let otherBrand = document.getElementById('otherBrand').value;
            let category = document.getElementById('category').value;
            let otherCat = document.getElementById('otherCat').value;
            let price = document.getElementById('price').value;
            let qty = document.getElementById('qty').value;
            let desc = document.getElementById('description').value;

            console.log(pname,brand,otherBrand,category,price,qty,desc);
            if (pname === '' || brand === '' || category === '' || price === '' || qty === '' || desc === '') {
                alert('Please fill in the required fields.');
                return false;
            }


            if(brand === 'other'){
              if(otherBrand === ''){
                alert('Please fill in a valid Brand...');
                return false;
              }
            }


            if(category === 'other'){
              if(otherCat === ''){
                alert('Please fill in a valid category...');
                return false;
              }
            }

            if(confirm('Do you want to submit these details to the database?') == false){
              return false;
            }

            return true;
        }


    </script>
    
</body>
</html>