<?php
include("dbCon.php");
$result = mysqli_query($link,"SELECT * FROM tbl_item Where Gender = 'Female'");
// $row = mysqli_fetch_assoc($result);

if(isset($_POST['add'])){

    $id = $_POST['itemId'];
    $image = $_POST['image'];
    $item = $_POST['itemName'];
    $price = $_POST['sellPrice'];

    $quan = $_POST['quantity'];
    $subtotal = $price * $quan;

    $sql = "INSERT INTO cart_item 
    (itemId, image, itemName, sellPrice, subTotal, quantity, total)
    VALUES
    ('$id', '$image', '$item', '$price', '$subtotal', '$quan', '$subtotal')";

    mysqli_query($link, $sql);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes || Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/product.css">
</head>
<body>

<!-- HEADER -->
<header class="nvbr">
    <!-- top nav -->
    <nav class="topnav">
        <div class="navlinks">
            <span>
                <a href="womens_fashion.php" >Women</a>
            </span>
            <span >
                <a href="buyer-Home.php" >Home</a>
            </span>
            <span>
                <a href="Mens_fashion.php" class="active" >Men</a>
            </span>
        </div>
        <div class="logos">PASTIMES</div>
        <div class="navicons">
            <span>
                <a href="#profile">👤profile</a>
            </span>
            <span>
                <a href="cart.php">🛒cart
                    <?php echo mysqli_fetch_assoc(mysqli_query($link, "SELECT COUNT(*) AS cart FROM cart_item"))['cart']; ?>
                </a>
            </span>
        </div>
    </nav>

    <!-- bottom nav -->
    <nav class="subnav">
        <span>
            <a href="explore_product.php">Clothing</a>
        </span>
        <span>
            <a href="tops&sweaters.php">Tops & Sweaters</a>
        </span>
       
    </nav>

</header>

<!-- BREADCRUMB -->
<section class="breadcrumb" >
    <p>
        <a href="User_Home.php">HOME /   <span class="active">Mens fashion</span></a>
    </p>
</section>

<!-- FILTER -->
<!-- <section class="filter-bar" style="margin: 30px;">
    <div class="categories">
        <a href="tops&sweaters.php" class="active" style="margin-right: 20px;" >All Products</a>
        <a href="tops&sweaters-women.php" style="margin-right: 20px;">Women</a>
        <a href="tops&sweaters-mens.php" style="margin-right: 20px;">Men</a>
        <input type="button" value="men" name="mens">
    </div>
</section> -->

<!-- PRODUCTS -->
<section class="products">
<?php while ($row = mysqli_fetch_assoc($result)) { ?>

<form action="" method="post">
    <div class="card" style="width: 20rem;">

        <a href="productView.php?id=<?php echo $row['ItemID']; ?>">
            <img src="img/<?php echo $row['Image']; ?>" class="card-img-top">
        </a>

        <div class="card-body">
            <h5 class="card-title"><?php echo $row['ItemName']; ?></h5>
            <p class="card-text">R<?php echo $row['SellPrice']; ?></p>

            <input type="hidden" name="itemId" value="<?php echo $row['ItemID']; ?>">
            <input type="hidden" name="image" value="<?php echo $row['Image']; ?>">
            <input type="hidden" name="itemName" value="<?php echo $row['ItemName']; ?>">
            <input type="hidden" name="sellPrice" value="<?php echo $row['SellPrice']; ?>">

            <div class="sizes">
                 <label for="quantity">Quantity:</label>
                <select name="quantity" id="quantity">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </div>

            <input type="submit" name="add" value="Add To Cart" class="btn btn-primary">
        </div>

    </div>
</form>
<?php } ?>

</section>
</body>
</html>