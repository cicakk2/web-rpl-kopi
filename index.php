<?php
require_once 'config/db_config.php';
$page = 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roasted Bliss - Artisan Coffee Roasters</title>
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
                <span class="hero-subtitle">Est. 2024</span>
                <h1 class="hero-title">Where Every Bean <br>Tells a Story</h1>
                <p class="hero-description">Hand-roasted specialty coffee sourced from sustainable farms around the world</p>
                <div class="hero-buttons">
                    <a href="product.php" class="btn btn-primary">Explore Coffee</a>
                    <a href="about.php" class="btn btn-secondary">Our Story</a>
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
                    <h3>Freshly Roasted</h3>
                    <p>Every batch roasted to perfection in small quantities for maximum freshness</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🌍</div>
                    <h3>Ethically Sourced</h3>
                    <p>Direct trade relationships with farmers who share our passion for quality</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3>Expert Selection</h3>
                    <p>Carefully curated beans from the world's finest coffee-growing regions</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products">
        <div class="container">
            <div class="section-header">
                <span class="section-subtitle">Our Selection</span>
                <h2 class="section-title">Featured Roasts</h2>
            </div>
            <div class="products-grid">
                <div class="product-card">
                    <div class="product-image" style="background: linear-gradient(135deg, #6B4423 0%, #3E2723 100%);">
                        <span class="product-badge">Popular</span>
                    </div>
                    <div class="product-info">
                        <h3>Ethiopian Yirgacheffe</h3>
                        <p class="product-origin">Ethiopia</p>
                        <p class="product-notes">Floral, Citrus, Tea-like</p>
                        <div class="product-footer">
                            <span class="product-price">$18.99</span>
                            <a href="product.php" class="btn-small">View</a>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image" style="background: linear-gradient(135deg, #8B5A3C 0%, #4E342E 100%);">
                        <span class="product-badge">New</span>
                    </div>
                    <div class="product-info">
                        <h3>Colombian Supremo</h3>
                        <p class="product-origin">Colombia</p>
                        <p class="product-notes">Caramel, Nuts, Chocolate</p>
                        <div class="product-footer">
                            <span class="product-price">$16.99</span>
                            <a href="product.php" class="btn-small">View</a>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image" style="background: linear-gradient(135deg, #5D4037 0%, #3E2723 100%);">
                    </div>
                    <div class="product-info">
                        <h3>Sumatra Mandheling</h3>
                        <p class="product-origin">Indonesia</p>
                        <p class="product-notes">Earthy, Herbal, Spiced</p>
                        <div class="product-footer">
                            <span class="product-price">$17.99</span>
                            <a href="product.php" class="btn-small">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h2>Start Your Coffee Journey</h2>
                <p>Join our community of coffee enthusiasts and discover your perfect roast</p>
                <a href="contact.php" class="btn btn-light">Get In Touch</a>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>