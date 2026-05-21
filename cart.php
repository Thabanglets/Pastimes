<?php
    include("dbCon.php");
    $result = mysqli_query($link, "SELECT * FROM cart_item");


    $totalprice = mysqli_fetch_assoc(mysqli_query($link, "SELECT SUM(subTotal) AS total FROM cart_item"))['total'];
    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/cart.css">
</head>
<body>
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
<section class="breadcrumb" style="margin: 30px;" >
    <p>
        <a href="Buyer-Home.php">HOME /   <span class="active">Mens fashion</span></a>
    </p>
</section>
        <!-- header -->
        <div class="row m-4" >
                <div class="col-6">Product


                </div>
                
                <div class="col-2">Price

                    
                </div>
                
                <div class="col-2">Quantity

                    
                </div>

                <div class="col-2">Subtotal

                    
                </div>
            
        </div>
        
        <hr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="row m-4">
                    <!-- image -->
                    <div class="col-1">
                        <div class="card" style="width: 7rem;">
                              <img src="img/<?php echo $row['image']; ?>" width="110">
                            <!-- <div class="card-body">
                            <p class="card-text">
                                
                            </p> 
                            </div> -->

                        </div>    
                    </div>
                    <!-- product name + description -->
                    <div class="col-5" >
                        <h4><?php echo $row['itemName']; ?></h4>
                    </div>
                <!-- price -->
                    <div class="col-2">
                        <?php echo $row['sellPrice']; ?>      
                    </div> 
                
                    <!-- quantity -->
                    <div class="col-2">
                        <?php echo $row['quantity']; ?>
                    </div>
                    <!-- subtotal -->
                    <div class="col-1">
                        <?php echo $row['subTotal']; ?>    
                    </div>

                    <div class="col-1">
                        <button type="button" class="btn btn-danger">
                            <a href="delete.php?cart_item_id=<?php echo $row['cart_item_id']; ?>"
                                 onclick="return confirm('Are you sure you want to delete?')">
                                Delete
                            </a>
                        </button>
                    </div>

        </div>

        <?php } ?>

        <hr>

        <div class="row m-4">
            <div class="col-10">
                <button type="button" class="btn btn-warning"><a href="buyer-Home.php">< Continue Shopping</a></button>
            </div>
            
            <div class="col-1"> <b>
               total:R <?php echo $totalprice?>
            </b>

                
            </div>
            
            <div class="col-1">
                <button type="button" class="btn btn-success">Checkout></button>
            </div>

        </div>

    
</body>
<script src="/js/bootstrap.bundle.min.js"></script>
</html>

