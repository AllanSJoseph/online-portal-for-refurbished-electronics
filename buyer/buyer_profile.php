<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Profile</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link  rel="stylesheet" href="../style.css" type="text/css">
    <style>
      body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .profile-container {
            display: flex;
            flex-direction: column;
        }

        .profile-card{
            display: flex;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 500px;
            max-width: 90%;
        }

        .profile-photo {
            margin-right: 20px;
        }
        .profile-photo img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .profile-details {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .profile-details h2 {
            margin: 0 0 10px;
            font-size: 24px;
        }
        .profile-details p {
            margin: 5px 0;
            font-size: 16px;
        }
        .profile-footer{
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 500px;
            max-width: 90%;
        }
    </style>
</head>
<body>
<?php 

session_start();
include('../profile.php');

$uid = intval($_SESSION['userid']);

$details = $user->viewProfile($uid);

?>

<div class="profile-container">
    <div class="profile-card">
    <div class="profile-photo">
        <img src="../res/user_icons/buyer.png" alt="User Photo">
    </div>
    <div class="profile-details">
        <h2><?php echo $details['name']; ?></h2>
        <p><strong>Email:</strong> <?php echo $details['email']; ?></p>
        <p><strong>Mobile Number:</strong> <?php echo $details['mob_no']; ?></p>
        <p><strong>Address:</strong> <?php echo $details['address']; ?></p>
    </div>
    </div>
    <div class="profile-footer">
        <a class="btn btn-outline-secondary" href="editUser.php">Edit Details</a>
        <a class="btn btn-outline-secondary" href="changePassword.php">Change Password</a>
        <a class="btn btn-outline-secondary" href="buyer_home.php">Home</a>
    </div>
</div>


</body>
</html>