<?php
session_start();
    include("dbCon.php");
   

    if (isset($_SESSION['userId'])) {
        echo "Logged in as User ID: " . $_SESSION['userId'];
    } else {
        echo "No user logged in";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/buyer.css">  
    <title>Pastimes|| Home</title>
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
                <a href="buyer-Home.php" class="active">Home</a>
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

<div id="carouselExampleCaptions" class="carousel slide" style="margin: 20px;">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/dress1.jpg" class="d-block w-100" alt="..." style="height: 500px;">
      <div class="carousel-caption d-none d-md-block">
        <h5>
            <a href="product.php" class="btn btn-primary">Explore Products</a>
        </h5>
        <!-- <p>Some representative placeholder content for the first slide.</p> -->
      </div>
    </div>
    <!-- <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Second slide label</h5>
        <p>Some representative placeholder content for the second slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Third slide label</h5>
        <p>Some representative placeholder content for the third slide.</p>
      </div>
    </div> -->
  </div>
  <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button> -->
</div>

<section class="promo-grid">
    <div class="card pink">
        <a href="womens_fashion.php">
            WOMAN'S CLOTHING
        </a>
    </div>
    <div class="card yellow">
        <a href="Mens_fashion.php">
            MAN'S CLOTHING
        </a>
    </div>
</section>


<h2 style="margin: 20px;">POPULAR PRODUCTS</h2>

<section class="promo-grid">
    <div class="card pink">
        <a href="womens_fashion.php">
            TOPS & SWEATERS
        </a>
    </div>
    <div class="card yellow">
        <a href="Mens_fashion.php">
            Jackets & Coats
        </a>
    </div>
    <div class="card yellow">
        <a href="Mens_fashion.php">
            Jeans
        </a>
    </div>
</section>

   



        </a>
    </div>
</section>

   



</body>
</html>