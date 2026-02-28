<?php
require_once 'config/db_config.php';

// Ambil ID produk dari URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query untuk mendapatkan detail produk
$query = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $query);

// Jika produk tidak ditemukan, redirect ke halaman produk
if (mysqli_num_rows($result) == 0) {
    header("Location: product.php");
    exit;
}

$product = mysqli_fetch_assoc($result);

// Tentukan gradient berdasarkan roast level
$gradient = "linear-gradient(135deg, #8B5A3C 0%, #4E342E 100%)"; // Default medium
if($product['roast_level'] == 'light') {
    $gradient = "linear-gradient(135deg, #6B4423 0%, #3E2723 100%)";
} elseif($product['roast_level'] == 'dark') {
    $gradient = "linear-gradient(135deg, #4E342E 0%, #2C1810 100%)";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Robusta Dampit</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style-product-detail.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Breadcrumb Navigation -->
    <section class="breadcrumb-section">
        <div class="container">
            <a href="product.php" class="breadcrumb-link">Produk</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current"><?php echo htmlspecialchars($product['name']); ?></span>
        </div>
    </section>

    <!-- Product Detail Section -->
    <section class="product-detail-section">
        <div class="container">
            <div class="product-detail-grid">
                
                <!-- Left Column: Product Image -->
                <div class="product-detail-image">
                    <?php if($product['image_url']): ?>
                        <img src="uploads/<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-detail-img">
                    <?php else: ?>
                        <div class="product-detail-placeholder" style="background: <?php echo $gradient; ?>;"></div>
                    <?php endif; ?>
                </div>

                <!-- Right Column: Product Description & Details -->
                <div class="product-detail-content">
                    <!-- Product Header -->
                    <div class="product-detail-header">
                        <h1 class="product-detail-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                        
                    </div>

                    <!-- Origin and Roast Level -->
                    <div class="product-meta">
                        <div class="meta-item">
                            <span class="meta-label">Asal Daerah:</span>
                            <span class="meta-value"><?php echo htmlspecialchars($product['origin']); ?></span>
                        </div>
                    </div>

                    <!-- Flavor Notes -->
                    <div class="flavor-notes-section">
                        <h3 class="flavor-notes-title">Deskripsi Rasa</h3>
                        <p class="flavor-notes-text"><?php echo htmlspecialchars($product['flavor_notes']); ?></p>
                    </div>

                    <!-- Full Description -->
                    <div class="product-full-description">
                        <h3 class="description-title">Deskripsi Produk</h3>
                        <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                    </div>

                    <!-- Price and Checkout Button -->
                    <div class="product-detail-footer">
                        <div class="price-section">
                            <span class="price-label">Harga:</span>
                            <span class="price-amount">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></span>
                        </div>
                        
                        <div class="checkout-buttons">
                            <button class="btn btn-primary btn-checkout" onclick="addToCart(<?php echo $product['id']; ?>)">
                                Tambah ke Keranjang
                            </button>
                            <a href="product.php" class="btn btn-secondary btn-back">
                                Lihat Produk Lainnya
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    
    <script src="js/script.js"></script>
    <script>
        // Simple add to cart function
        function addToCart(productId) {
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Ditambahkan!';
            button.style.background = '#4CAF50';
            
            // Restore button after 1.5 seconds
            setTimeout(() => {
                button.textContent = originalText;
                button.style.background = '';
            }, 1500);

            // You can add actual cart functionality here
            // For now, it just shows a visual feedback
        }
    </script>
</body>
</html>
