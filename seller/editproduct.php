<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product Details</title>
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
// include('../connect.php');

include('seller_class.php');



if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['pid'])){
  $p_id = $_GET['pid'];
  $detail = $seller->showProduct($p_id);
  $img = $detail['images'];
}

function showCategories(){
    global $conn;
    $stmt = $conn->prepare("SELECT category FROM product");
    $stmt->execute();
    $plist = $stmt->get_result();

    while($row = $plist->fetch_assoc()){
      echo "<option value=\"".$row['category']."\">".$row['category']."</option>";
    }
}

function showBrands(){
  global $conn;
  $stmt = $conn->prepare("SELECT brand FROM product");
  $stmt->execute();
  $plist = $stmt->get_result();

  while($row = $plist->fetch_assoc()){
    echo "<option value=\"".$row['brand']."\">".$row['brand']."</option>";
  }
}

?>


      <br><br><br><br>

      <div class="container-sm" style="margin-top: 2%;">
        <h1 style="color:DarkSlateGrey;text-align: center;"><b>Edit your Product</b></h1>


        <form onsubmit="return validate()" method="POST" enctype="multipart/form-data" action="submitproduct.php">
          <input type="hidden" name="id" id="productId" value="<?php echo $p_id;?>">
          <label for="name" class="form-label">Name of the Product:</label>
          <input type="text" class="form-control" id="name" name="name" value="<?php echo $detail['pname']; ?>"><br>

          <label for="brand" class="form-label">Brand:</label>
          <select id="brand" class="form-control" name="brand" onchange="handleBrandSelection()">
              <option value="<?php echo $detail['brand']; ?>"  selected><?php echo $detail['brand']; ?></option>
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
              <option value="<?php echo $detail['category']; ?>" selected><?php echo $detail['category']; ?></option>
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
          <input type="number" class="form-control" id="price" name="price"  value="<?php echo $detail['price']; ?>" ><br>

          <label for="qty" class="form-label">Enter Quantity:</label>
          <input type="number" class="form-control" id="qty" name="qty" value="<?php echo $detail['quantity']; ?>"><br>

          <label for="description" class="form-label">Enter Some more details of your product:</label>
          <textarea name="description" id="description" class="form-control" rows="10" cols="20"  value="<?php echo $detail['description']; ?>"></textarea>
          <br>

          <label for="image" class="form-label">Upload an image of the product: </label>
          <input type="file" class="form-control" id="image" name="image" accept="image/*" style="margin-top: 10px; display: block;" value="<?php echo substr($img, 17); ?>"><br>

          <a class="btn btn-outline-secondary" href="seller_products.php">Cancel</a>
          <input type="submit" class="btn btn-outline-success" name="update" value="Update"><br><br>
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