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
    <title>Pastimes || Modern Fashion</title>
    
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="css/global.css">
</head>
<body>

    
    <header>
        <nav class="navbar navbar-expand-lg navbar-light navbar-custom fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">PASTIMES</a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link-custom" href="womens_fashion.php">Women</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom active" href="buyer-Home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom" href="Mens_fashion.php">Men</a>
                        </li>
                    </ul>
                </div>

                <div class="d-none d-lg-flex align-items-center">
                    <a href="#profile" class="nav-icon">Account</a>
                    <a href="cart.php" class="nav-icon">
                        Cart 
                        <!-- Placeholder for Cart Count PHP -->
                        (<?php echo mysqli_fetch_assoc(mysqli_query($link, "SELECT COUNT(*) AS cart FROM tbl_cart"))['cart']; ?>)
                    </a>
                </div>
            </div>
        </nav>

        <!-- Sub Navigation (Categories) -->
        <div class="sub-navbar" style="background:#fff; padding: 10px 0; border-bottom:1px solid #eee; position:sticky; top:73px; z-index:999;">
            <div class="container d-flex justify-content-center gap-4">
                <a href="explore_product.php" style="text-decoration:none; color:#555; font-size:0.85rem; text-transform:uppercase;">Clothing</a>
                <a href="tops&sweaters.php" style="text-decoration:none; color:#555; font-size:0.85rem; text-transform:uppercase;">Tops & Sweaters</a>
            </div>
        </div>
    </header>

    <main>
        
        <section class="hero-section">
            <div class="hero-overlay"></div>
            <div class="hero-content container">
                <h1 class="hero-title animate__animated animate__fadeInUp">REDEFINING CLASSICS</h1>
                <a href="product.php" class="btn btn-custom">Shop Collection</a>
            </div>
        </section>

        <!-- Categories Grid -->
        <section class="container section-padding">
            <h2 class="section-title">Shop by Category</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="grid-card">
                        <img src="https://images.unsplash.com/photo-1485230946086-1d99d50b11f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Women's Fashion">
                        <a href="womens_fashion.php" class="grid-label">Woman's Clothing</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="grid-card">
                        <img src="https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Men's Fashion">
                        <a href="Mens_fashion.php" class="grid-label">Man's Clothing</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Popular Products -->
        <section class="container section-padding" style="background-color: #fafafa;">
            <h2 class="section-title">Popular Products</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="grid-card" style="height: 300px;">
                        <img src="https://images.unsplash.com/photo-1620799140408-ed5341cd2431?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Tops">
                        <a href="tops&sweaters.php" class="grid-label">Tops & Sweaters</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="grid-card" style="height: 300px;">
                        <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Jackets">
                        <a href="Mens_fashion.php" class="grid-label">Jackets</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="grid-card" style="height: 300px;">
                        <img src="https://images.unsplash.com/photo-1542272454315-4c01d7abdf4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Jeans">
                        <a href="Mens_fashion.php" class="grid-label">Jeans</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 PASTIMES. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>