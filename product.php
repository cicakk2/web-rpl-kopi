<?php
require_once 'config/db_config.php';
$page = 'product';

// 1. Ambil data produk dari database
$query = "SELECT * FROM products ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - Robusta Dampit</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="page-header">
        <div class="container">
            <span class="page-subtitle">Produk Kami</span>
            <h1 class="page-title">Kopi Premium<br>Pilihan</h1>
        </div>
    </section>

    <section class="products-section">
        <div class="container">
            <div class="products-grid large">
                <?php 
                // 2. Cek apakah ada data di database
                if (mysqli_num_rows($result) > 0): 
                    while($row = mysqli_fetch_assoc($result)): 
                        
                        // Logika untuk menentukan warna gradient berdasarkan level sangrai (roast level)
                        $gradient = "linear-gradient(135deg, #8B5A3C 0%, #4E342E 100%)"; // Default medium
                        if($row['roast_level'] == 'light') {
                            $gradient = "linear-gradient(135deg, #6B4423 0%, #3E2723 100%)";
                        } elseif($row['roast_level'] == 'dark') {
                            $gradient = "linear-gradient(135deg, #4E342E 0%, #2C1810 100%)";
                        }
                ?>
                    <div class="product-card" data-category="<?php echo $row['roast_level']; ?>">
                        <div class="product-image">
                            <?php if($row['image_url']): ?>
                                <!-- Display uploaded image -->
                                <img src="uploads/<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="product-img">
                            <?php else: ?>
                                <!-- Fallback to gradient if no image -->
                                <div class="product-img-placeholder" style="background: <?php echo $gradient; ?>;"></div>
                            <?php endif; ?>
                            
                            <?php if($row['is_featured']): ?>
                                <span class="product-badge badge-featured">Featured</span>
                            <?php elseif($row['is_organic']): ?>
                                <span class="product-badge badge-organic">Organic</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                            <p class="product-origin"><?php echo htmlspecialchars($row['origin']); ?></p>
                            <p class="product-notes"><?php echo htmlspecialchars($row['flavor_notes']); ?></p>
                            <p class="product-description"><?php echo htmlspecialchars($row['description']); ?></p>
                            <div class="product-footer">
                                <span class="product-price">Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></span>
                                <button class="btn-small">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                <?php 
                    endwhile; 
                else: 
                ?>
                    <p>Maaf, saat ini belum ada produk yang tersedia.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>