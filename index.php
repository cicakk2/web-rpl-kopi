<?php
require_once 'config/db_config.php';
$page = 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Robusta Dampit</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">Cita Rasa <br>Kopi Nusantara Terbaik</h1>
                <p class="hero-description">Temukan biji kopi berkualitas tinggi dengan aroma dan rasa autentik</p>
                <div class="hero-buttons">
                    <a href="product.php" class="btn btn-primary">Lihat Produk</a>
                    <a href="about.php" class="btn btn-secondary">Tentang Kami</a>
                </div>
            </div>
        </div>
        <div class="hero-overlay"></div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">☕</div>
                    <h3>Disangrai Segar</h3>
                    <p>Bubuk kopi disangrai fresh dalam batch kecil untuk aroma dan rasa terbaik</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🌍</div>
                    <h3>Sumber Berkelanjutan</h3>
                    <p>Dipilih langsung dari petani terpercaya dengan standar kualitas tinggi</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3>Pilihan Ahli</h3>
                    <p>Dikurasi khusus dari biji kopi terbaik untuk seduhan yang sempurna</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
<?php
// 1. Query untuk mengambil produk yang di-set sebagai featured
// Kita batasi 3 produk saja agar sesuai dengan layout grid awal
$featured_query = "SELECT * FROM products WHERE is_featured = 1 ORDER BY created_at DESC LIMIT 3";
$featured_result = mysqli_query($conn, $featured_query);
?>

<section class="featured-products">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Produk Pilihan</span>
            <h2 class="section-title">Pilihan Bubuk Kopi Terbaik</h2>
        </div>
        
        <div class="products-grid">
            <?php if (mysqli_num_rows($featured_result) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($featured_result)): ?>
                    <div class="product-card">
                        <div class="product-image" style="background: linear-gradient(135deg, #6B4423 0%, #3E2723 100%);">
                            <?php if ($product['is_organic']): ?>
                                <span class="product-badge">Organic</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-info">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="product-origin"><?php echo htmlspecialchars($product['origin']); ?></p>
                            <p class="product-notes"><?php echo htmlspecialchars($product['flavor_notes']); ?></p>
                            
                            <div class="product-footer">
                                <span class="product-price">$<?php echo number_format($product['price'], 2); ?></span>
                                <a href="product.php?id=<?php echo $product['id']; ?>" class="btn-small">View</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No featured products at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
    <!-- Call to Action -->
    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h2>Temukan Kopi Favoritmu Sekarang</h2>
                <p>Jelajahi berbagai pilihan roast terbaik bersama kami</p>
                <a href="contact.php" class="btn btn-light">Hubungi Kami</a>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>