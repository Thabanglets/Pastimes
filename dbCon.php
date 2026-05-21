<?php

    $link= mysqli_connect("localhost","root","","clothingstore");

    if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}else{
    // echo"connected";
}
?>