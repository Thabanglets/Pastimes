<?php
session_start();
include("dbCon.php");
$_SESSION['userid'];
$result = mysqli_query($link,"SELECT * FROM tbl_item WHERE Gender = 'Male'");

if(isset($_POST['add'])){

    $id = $_POST['itemId'];
    $price = $_POST['sellPrice'];
    $quan = 1;

    
    $sql = "SELECT * FROM tbl_cart WHERE user_id = '$userId' AND product_id = '$id'";

    
    $check = mysqli_query($link,$sql );

    if (mysqli_num_rows($check) > 0) {

    $sql = "UPDATE tbl_cart SET Quantity = Quantity + $quan WHERE user_id='$userId' AND product_id='$id'";
        mysqli_query($link, $sql);

    } else {
        $sql = "INSERT INTO tbl_cart (user_id, product_id, quantity)
            VALUES ('$userId', '$id', '$quan')";
        mysqli_query($link, $sql);
    }
}
?>