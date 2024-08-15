<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up to OPRE</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link  rel="stylesheet" href="style.css" type="text/css">
        <style>
            body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('./res/background/background_buyer.jpg') no-repeat center center fixed; 
            background-size: cover;
            position: relative;
        }
        </style>
    </head>    
    <body>
   <!-- PHP CODE -->

   <?php 
     
     include('connect.php');
     if($_SERVER["REQUEST_METHOD"] == "POST"){


        if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["mob"]) && isset($_POST["address"]) && isset($_POST["password"])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $mob = $_POST['mob'];
            $address = $_POST['address'];
            $password = $_POST['password'];
            $duplicate_entry_err_no = 1062;

            $query = "SELECT email FROM users WHERE email=\"$email\"";
            $checkDuplicate = mysqli_query($conn,$query);

            if (mysqli_num_rows($checkDuplicate) === 0){
                $query = "INSERT INTO users VALUES(NULL,\"$email\",\"$name\",\"$mob\",\"$address\",\"$password\",\"Buyer\")";
                $res = mysqli_query($conn,$query);

                if($res){
                    header("Location: login.php");
                    die;
                } else{
                    echo "<script>alert('Something went wrong!! Please Try again later...')</script>";
                }

            } else{
                echo "<script>alert('Email Already exists, Please Try Again')</script>";
            }            
        }
      }


   ?>


   <!-- PHP CODE -->

   <div class="container-form-suggestion">
        <div class="container-sm signupbox" style="margin-top: 2%;">
        <h1 style="text-align: center;"><b>Sign Up as Buyer</b></h1>
        <form onsubmit="return validate()" method="POST">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" ><br>

            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" ><br>
            
            <label for="mob" class="form-label">Mob No:</label>
            <input type="number" class="form-control" id="mob" name="mob" >
            <div id="mobHelpBlock" class="form-text"></div><br>

            <label for="address" class="form-label">Address:</label>
            <input type="text" class="form-control" id="address" name="address" ><br>
            
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelpBlock">
            <div id="passwordHelpBlock" class="form-text">
                Your password must be <b>atleast 8 characters</b> long, contain <b>Uppercase and LowerCase Letters, Numbers, and Special Characters</b>.
            </div><br>

            <label for="confpassword" class="form-label">Confirm Password:</label>
            <input type="password" class="form-control" id="confpassword" name="confpassword">
            <div id="confPassHelpBlock" class="form-text"></div><br>
            
            <input type="submit" class="btn btn-outline-success" id="submit_btn" value="Sign Up"    ><br><br>
            </form>
        </div>

        <div class="suggestion-container-login">
                    <div class="suggestion-card">
                        <div class="suggestion-img">
                            <img src="./res/user_icons/buyer.png">
                        </div>
                        
                        <div class="suggestion-content">
                        <h5>Already a User?</h5>
                        <p>Login below...<br><a class="menu__link" href="login.php" target="_self" title="signup">Login</a></p>
                        
                        </div>
                    </div>
                    <div class="suggestion-card">
                        <div class="suggestion-img">
                            <img src="./res/user_icons/seller.png">
                        </div>
                        
                        <div class="suggestion-content">
                        <h5>Become a Seller?</h5>
                        <p>Sign Up as Seller in a few steps...<br><a class="menu__link" href="sellersignup.php" target="_self" title="signup">Seller Registation</a></p>
                        
                        </div>
                    </div>
        </div>
    </div>

    <script src="validationScript.js"></script>
</body>
</html>