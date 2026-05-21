<?php
include("dbCon.php");
if (!isset($_GET['id'])) {
    die("No product selected.");
}
$id = $_GET['id'];
// Get product from database
$result = mysqli_query($link,"SELECT * FROM tbl_Item WHERE ItemID = $id");


if ($row = mysqli_fetch_assoc($result)) {
    $name = $row['ItemName'];
    $ItemDescription = $row['ItemDescription'];
    $price = $row['SellPrice'];
    $image = $row['Image'];
} else {
    die("Product not found.");
}

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
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/prodView.css">
</head>
<body>
    <body>

<!-- NAVBAR (simple version) -->
<header class="nvbr">
    <!-- top nav -->
    <nav class="topnav">
        <div class="navlinks">
            <span>
                <a href="womens_fashion.php" >Women</a>
            </span>
            <span >
                <a href="buyer-Home.php">Home</a>
            </span>
            <span>
                <a href="Mens_fashion.php"  >Men</a>
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

<!-- PRODUCT SECTION -->
<form action="" method="post">
    <section class="product-container">

    <!-- LEFT IMAGE -->
    <div class="product-left">
        <img src="img/<?php echo $image; ?>" alt="Product Image">
    </div>

    <!-- RIGHT DETAILS -->
    <div class="product-right">

        <!-- CATEGORY (optional) -->
        <p class="category">MEN'S RUNNING SHOE</p>

        <!-- PRODUCT NAME -->
        <h1><?php echo $name; ?></h1>

        <!-- PRICE -->
        <p class="price">R<?php echo $price; ?></p>

        <!-- DESCRIPTION -->
        <p class="description">
            <?php echo $ItemDescription; ?>
        </p>

        <!-- SIZE SELECTOR -->
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

        <input type="hidden" name="itemId" value="<?php echo $row['ItemID']; ?>">
            <input type="hidden" name="image" value="<?php echo $row['Image']; ?>">
            <input type="hidden" name="itemName" value="<?php echo $row['ItemName']; ?>">
            <input type="hidden" name="sellPrice" value="<?php echo $row['SellPrice']; ?>">
            <button type="submit" name="add" class="add-to-cart">
                ADD TO CART
            </button>
       

        <!-- CART LINK -->
        <a href="cart.php">Go to Cart 🛒</a>

    </div>

</section>
</form>



</body>
</html>