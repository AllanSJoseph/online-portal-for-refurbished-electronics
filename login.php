<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login to OPRE</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link  rel="stylesheet" href="./style.css" type="text/css">
        <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('./res/background/background_login.jpg') no-repeat center center fixed; 
            background-size: cover;
            position: relative;
        }

        </style>
    </head>
    <body>

      <!-- PHP CODE -->

      <?php 
        session_start();

        include('connect.php');

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
            if (isset($_POST["email"]) && isset($_POST["password"])){
                $email = $_POST['email'];
                $passwd = $_POST['password'];
    
                
                $query = "SELECT * FROM users WHERE email=\"$email\"";
    
                $checkDetails = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($checkDetails);
    
                if (mysqli_num_rows($checkDetails)===0){
                    echo "<script>alert('Invalid Email or Password')</script>";
                }else{
                    if($row['password']===$passwd){
                        $_SESSION['userid']=$row['userid'];
                        $_SESSION['email']=$row['email'];
                        $_SESSION['name']=$row['name'];
                        $_SESSION['usertyp']=$row['type'];
                        if($row['type']==="Buyer"){
                            header("Location: ./buyer/buyer_home.php");
                            die;
                        }else if($row['type']==="Seller"){
                            header("Location: ./seller/seller_dashboard.php");
                            die;
                        }else{
                            header("Location: ./admin/admin_dashboard.php");
                            die;
                        }
                        
                    }else{
                        echo "<script>alert('Invalid Password')</script>";
                    }
                }
    
                
            }else{
                echo "<script>alert('Invalid Password')</script>";
            }
    
        }


      ?>
        
      <!-- PHP CODE -->

      <div class="container-form-suggestion">
            <div class="container-sm loginbox">
                <h1 style="text-align: center;"><b>LOGIN</b></h1>

                <form onsubmit="return validateLogin()" method="POST">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control"><br><br>
                    
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" name="password" class="form-control"><br><br>
                    
                    <input type="submit" class="btn btn-outline-success" value="Log In"><br><br>
                </form>
            </div>

            <div class="suggestion-container-login">
                <div class="suggestion-card">
                    <div class="suggestion-img">
                        <img src="./res/user_icons/buyer.png">
                    </div>
                    
                    <div class="suggestion-content">
                      <h5>New Here?</h5>
                      <p>Sign Up as Buyer in a few steps...<br><a href="signup.php" target="_self" title="Signup" class="menu__link">Signup</a></p>
                      
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

        <script>
            function validateLogin(){
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;

            if (email === '' || password === '') {
                alert('Please fill in all fields.');
                return false;
            }

            return true;
        }
        </script>

    </body>
</html>