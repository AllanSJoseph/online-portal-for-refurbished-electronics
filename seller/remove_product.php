<?php

include('seller_class.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $seller->removeProduct($id);

}

