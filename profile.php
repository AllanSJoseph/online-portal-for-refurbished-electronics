<?php

include("connect.php");

class Profile{
    function viewProfile($uid){
        //Function to view the user's Profile
        global $conn;
        $stmt = $conn->prepare("SELECT email,name,mob_no,address FROM users WHERE userid=?");
        $stmt->bind_param("s",$uid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                // echo "<h4>User Details:</h4>";
                // echo "<b>Name:</b> " . $row['name'] . "<br>";
                // echo "<b>Email:</b> " . $row['email'] . "<br>";
                // echo "<b>Phone:</b> " . $row['mob_no'] . "<br>";
                // echo "<b>Address:</b> " . $row['address'] . "<br>";
                return $row;
            }
        }else{
            // echo "<h4>User not Found :(</h4>";
            return [];
        }
    }

    function editProfile($uid,$name,$email,$mob,$address){
        //Function to edit user's profile
        global $conn;
        $sql = "UPDATE users SET name=?, email=?, mob_no=?, address=? WHERE userid=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisi", $name, $email, $mob, $address, $uid);

        if ($stmt->execute()) {
            $stmt->close();
            return 0;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            $stmt->close();
            return 1;
        }
    }

    function validatePassword($uid,$password){
        global $conn;
        $stmt = $conn->prepare("SELECT password FROM users WHERE userid=?");
        $stmt->bind_param("s",$uid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                if($row['password']===$password){
                    //Password Valid
                    return 0;
                }else{
                    //Password Invalid
                    return 1;
                }
            }
        }else{
            // Password Invalid
            return 1;
        }

    }

    function changePassword($uid,$newpassword){
        //Function to change Password
        global $conn;
        $sql = "UPDATE users SET password=? WHERE userid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si",$newpassword,$uid);

        if ($stmt->execute()){
            return 0;
        }else{
            return 1;
        }
    }

    function removeProfile($uid){
        //Function to remove profile
    }
}

$user = new Profile();