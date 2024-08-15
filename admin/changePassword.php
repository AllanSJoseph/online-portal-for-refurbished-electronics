<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Your Details</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link  rel="stylesheet" href="../style.css" type="text/css">
    </head>    
    <body>
   <!-- PHP CODE -->

   <?php 
     
     session_start();

    include('../connect.php');
    include('../profile.php');
    $uid = intval($_SESSION['userid']);


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["currpassword"]) && isset($_POST["newpassword"])){
            $currpasswd = $_POST['currpassword'];
            $newpasswd = $_POST['newpassword'];

            $isCurrPassValid = $user->validatePassword($uid,$currpasswd); 

            if(!$isCurrPassValid){
                $isPassChanged = $user->changePassword($uid,$newpasswd); 
                if(!$isPassChanged){
                    echo "<script>";
                    echo "alert('Password Updated Successfully! Please consider remembering your password...');";
                    echo 'window.location.href = "admin_profile.php"';
                    echo "</script>";
                }else{
                    echo "<script>alert('Oops! Something Went Wrong, Please Try Again...');</script>";
                }
                
            }else{
                echo "<script>";
                echo "alert('Sorry We can't change your password... Please enter your CORRECT current password...');";
                echo 'window.location.href = "admin_profile.php"';
                echo "</script>";
            }

        }
      }


   ?>


   <!-- PHP CODE -->

    <div class="container-sm loginbox" style="margin-top: 2%;">
       <h1 style="color:DarkSlateGrey;text-align: center;"><b>Change your Password...</b></h1>
       <form onsubmit="return validate()" method="POST">
       <label for="password" class="form-label">Current Password:</label>
       <input type="password" class="form-control" id="currpassword" name="currpassword"><br>

        <label for="password" class="form-label">Password:</label>
        <input type="password" class="form-control" id="newpassword" name="newpassword"><br>

        <label for="confpassword" class="form-label">Confirm Password:</label>
        <input type="password" class="form-control" id="confpassword" name="confpassword"><br>

        <a class="btn btn-outline-secondary" href="admin_profile.php">Back</a>
        <input type="submit" class="btn btn-outline-success" value="Submit"><br><br>
        </form>
        
    </div>

    <script>
        function validate(){
            let currpassword = document.getElementById('currpassword').value;
            let newpassword = document.getElementById('newpassword').value;
            let confpassword = document.getElementById('confpassword').value;

            if (currpassword === '' || newpassword === '' || confpassword === '') {
                alert('Please fill in all fields.');
                return false;
            }

            if (newpassword !== confpassword) {
                alert('Passwords do not match.');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>