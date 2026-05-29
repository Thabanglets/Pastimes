<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes || Add Listing</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #212121;
            --secondary-color: #757575;
            --border-light: #e0e0e0;
            --bg-light: #f8f9fa;
            --accent-green: #28a745;
            --sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--primary-color);
            background-color: var(--bg-light);
            margin: 0;
            padding: 0;
        }

        /* --- Layout --- */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* --- Sidebar --- */
        .sidebar {
            width: var(--sidebar-width);
            background-color: #fff;
            border-right: 1px solid var(--border-light);
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 30px 20px;
            z-index: 100;
        }

        .logo-section {
            margin-bottom: 50px;
            text-align: center;
        }

        .logo-section h2 {
            font-weight: 700;
            letter-spacing: 2px;
            margin: 0;
            font-size: 1.5rem;
        }

        .logo-section p {
            font-size: 0.8rem;
            color: var(--secondary-color);
            margin: 5px 0 0 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-nav {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .nav-link {
            padding: 12px 15px;
            border-radius: 8px;
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link:hover {
            background-color: var(--bg-light);
            color: var(--primary-color);
        }

        .nav-link.active {
            background-color: var(--primary-color);
            color: #fff;
        }

        .btn-new-listing {
            background-color: var(--primary-color);
            color: #fff !important;
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-new-listing:hover {
            background-color: var(--secondary-color);
        }

        /* --- Main Content --- */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 30px;
        }

        /* --- Header --- */
        .page-header {
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .page-subtitle {
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        /* --- Form Layout --- */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .form-card {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid var(--border-light);
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }

        .full-width {
            grid-column: span 2;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-light);
        }

        /* --- Form Elements --- */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
        }

        .form-control-custom {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-light);
            border-radius: 6px;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            transition: 0.3s;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
        }

        textarea.form-control-custom {
            resize: vertical;
            min-height: 120px;
        }

        /* --- Image Upload --- */
        .image-upload-area {
            border: 2px dashed var(--border-light);
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
            background: var(--bg-light);
        }

        .image-upload-area:hover {
            border-color: var(--primary-color);
            background: #fff;
        }

        .upload-icon {
            font-size: 2rem;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }

        .upload-text {
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        .preview-image {
            max-width: 100%;
            max-height: 300px;
            margin-top: 15px;
            border-radius: 6px;
            display: none;
        }

        /* --- Buttons --- */
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-save {
            padding: 12px 30px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-save:hover {
            background-color: var(--secondary-color);
        }

        .btn-cancel {
            padding: 12px 30px;
            background-color: transparent;
            color: var(--secondary-color);
            border: 1px solid var(--border-light);
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-cancel:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
                padding: 20px 10px;
            }
            .sidebar .logo-section p, .sidebar .nav-link span, .sidebar .btn-new-listing {
                display: none;
            }
            .main-content {
                margin-left: 80px;
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
            .full-width {
                grid-column: span 1;
            }
        }
    </style>
</head>
<body>

<div class="dashboard-container">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="logo-section">
            <h2>PASTIMES</h2>
            <p>Seller Panel</p>
        </div>

        <nav class="sidebar-nav">
            <a href="seller_Dashboard.php" class="nav-link">
                <i class="bi bi-grid-1x2-fill"></i> <span>Dashboard</span>
            </a>
            <a href="addListing.php" class="nav-link active">
                <i class="bi bi-plus-circle-fill"></i> <span>Add Listing</span>
            </a>
            <a href="orders.php" class="nav-link">
                <i class="bi bi-bag-fill"></i> <span>Orders</span>
            </a>
            <a href="messages.php" class="nav-link">
                <i class="bi bi-chat-dots-fill"></i> <span>Messages</span>
            </a>
        </nav>

        <a href="seller_Dashboard.php" class="btn-new-listing">
            Dashboard
        </a>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Add New Product</h1>
            <p class="page-subtitle">Create a new listing for your store</p>
        </div>

        <!-- Form -->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-grid">
                
                <!-- Product Details -->
                <div class="form-card">
                    <h3 class="section-title">Product Details</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="itemName" class="form-control-custom" placeholder="e.g. Classic Denim Jacket" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control-custom" placeholder="Describe the product features, materials, and fit..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-control-custom" required>
                            <option value="">Select Category</option>
                            <option value="womens">Women's Fashion</option>
                            <option value="mens">Men's Fashion</option>
                            <option value="tops">Tops & Sweaters</option>
                            <option value="shoes">Shoes</option>
                            <option value="accessories">Accessories</option>
                        </select>
                    </div>
                </div>

                <!-- Price & Inventory -->
                <div class="form-card">
                    <h3 class="section-title">Pricing & Inventory</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Sell Price (R)</label>
                        <input type="number" name="price" class="form-control-custom" placeholder="0.00" step="0.01" min="0" required>
                    </div>

                    <!-- <div class="form-group">
                        <label class="form-label">Cost Price (R)</label>
                        <input type="number" name="costPrice" class="form-control-custom" placeholder="0.00" step="0.01" min="0">
                    </div> -->

                    <div class="form-group">
                        <label class="form-label">Stock Quantity</label>
                        <input type="number" name="stock" class="form-control-custom" placeholder="0" min="0" required>
                    </div>

                    <!-- <div class="form-group">
                        <label class="form-label">Size(s)</label>
                        <input type="text" name="sizes" class="form-control-custom" placeholder="e.g. S, M, L, XL">
                    </div> -->
                </div>

                <!-- Image Upload -->
                <div class="form-card full-width">
                    <h3 class="section-title">Product Image</h3>
                    
                    <div class="image-upload-area" onclick="document.getElementById('fileInput').click()">
                        <i class="bi bi-cloud-arrow-up upload-icon"></i>
                        <p class="upload-text">Click to upload image</p>
                        <p class="upload-text" style="font-size: 0.8rem;">Supported: JPG, PNG</p>
                        <input type="file" id="fileInput" name="image" style="display: none;" accept="image/*" onchange="previewImage(event)">
                        <img id="imgPreview" class="preview-image" alt="Product Preview">
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="full-width" style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 10px;">
                    <a href="seller-Home.php" class="btn-cancel">Cancel</a>
                    <button type="submit" name="submit" class="btn-save">Publish Listing</button>
                </div>

            </div>
        </form>

    </main>

</div>

<script>
    // Simple Image Preview Script
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('imgPreview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

</body>
</html>