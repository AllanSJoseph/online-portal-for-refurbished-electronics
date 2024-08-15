<?php

include ('buyer.php');


if(isset($_GET['sid'])){
    $sid = intval($_GET['sid']);
    $buyer->viewSeller($sid);
}else{
    echo "Seller Not Found";
}
