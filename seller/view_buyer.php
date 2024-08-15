<?php

include ('seller_class.php');


if(isset($_GET['bid'])){
    $sid = intval($_GET['bid']);
    $seller->viewBuyer($sid);
}else{
    echo "Buyer Not Found";
}
