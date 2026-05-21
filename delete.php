<?php
include("dbCon.php");

if(isset($_GET['cart_item_id'])){

    $id = $_GET['cart_item_id'];

    $sql = "DELETE FROM cart_item WHERE cart_item_id = '$id'";

    if(mysqli_query($link, $sql)){
        header("Location: cart.php");
        exit();
    } else {
        echo "Error deleting item";
    }
} else {
    echo "No item selected";
}
?>