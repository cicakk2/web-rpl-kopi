<?php
require_once 'config/db_config.php';
$page = 'product';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Roasted Bliss</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <span class="page-subtitle">Produk Kami</span>
            <h1 class="page-title">Kopi Premium<br>Pilihan</h1>
        </div>
    </section>
    <!-- Products Grid -->
    <section class="products-section">
        <div class="container">
            <div class="products-grid large">
                <div class="product-card" data-category="light">
                    <div class="product-image" style="background: linear-gradient(135deg, #6B4423 0%, #3E2723 100%);">
                        <span class="product-badge">Popular</span>
                    </div>
                    <div class="product-info">
                        <h3>Ethiopian Yirgacheffe</h3>
                        <p class="product-origin">Ethiopia · Light Roast</p>
                        <p class="product-notes">Floral, Citrus, Tea-like</p>
                        <p class="product-description">A bright and complex coffee with delicate floral notes and citrus undertones. Perfect for pour-over brewing.</p>
                        <div class="product-footer">
                            <span class="product-price">$18.99</span>
                            <button class="btn-small">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <div class="product-card" data-category="medium">
                    <div class="product-image" style="background: linear-gradient(135deg, #8B5A3C 0%, #4E342E 100%);">
                        <span class="product-badge">New</span>
                    </div>
                    <div class="product-info">
                        <h3>Colombian Supremo</h3>
                        <p class="product-origin">Colombia · Medium Roast</p>
                        <p class="product-notes">Caramel, Nuts, Chocolate</p>
                        <p class="product-description">A well-balanced coffee with sweet caramel notes and a smooth, chocolatey finish. Versatile for any brewing method.</p>
                        <div class="product-footer">
                            <span class="product-price">$16.99</span>
                            <button class="btn-small">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <div class="product-card" data-category="dark">
                    <div class="product-image" style="background: linear-gradient(135deg, #5D4037 0%, #3E2723 100%);">
                    </div>
                    <div class="product-info">
                        <h3>Sumatra Mandheling</h3>
                        <p class="product-origin">Indonesia · Dark Roast</p>
                        <p class="product-notes">Earthy, Herbal, Spiced</p>
                        <p class="product-description">A full-bodied coffee with earthy complexity and herbal notes. Low acidity makes it ideal for espresso.</p>
                        <div class="product-footer">
                            <span class="product-price">$17.99</span>
                            <button class="btn-small">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <div class="product-card" data-category="light">
                    <div class="product-image" style="background: linear-gradient(135deg, #7B5544 0%, #4A312C 100%);">
                    </div>
                    <div class="product-info">
                        <h3>Kenya AA</h3>
                        <p class="product-origin">Kenya · Light Roast</p>
                        <p class="product-notes">Berry, Wine, Bright</p>
                        <p class="product-description">Vibrant acidity with berry-like sweetness and wine-like complexity. A true connoisseur's choice.</p>
                        <div class="product-footer">
                            <span class="product-price">$19.99</span>
                            <button class="btn-small">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <div class="product-card" data-category="medium">
                    <div class="product-image" style="background: linear-gradient(135deg, #6D4C41 0%, #3E2723 100%);">
                    </div>
                    <div class="product-info">
                        <h3>Guatemala Antigua</h3>
                        <p class="product-origin">Guatemala · Medium Roast</p>
                        <p class="product-notes">Cocoa, Spice, Smoky</p>
                        <p class="product-description">Rich and complex with cocoa notes and a hint of smoke. Grown in volcanic soil at high altitude.</p>
                        <div class="product-footer">
                            <span class="product-price">$17.49</span>
                            <button class="btn-small">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <div class="product-card" data-category="medium">
                    <div class="product-image" style="background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);">
                        <span class="product-badge">Organic</span>
                    </div>
                    <div class="product-info">
                        <h3>Costa Rica Tarrazu</h3>
                        <p class="product-origin">Costa Rica · Medium Roast</p>
                        <p class="product-notes">Honey, Citrus, Clean</p>
                        <p class="product-description">Certified organic with honey sweetness and bright citrus acidity. Clean and crisp finish.</p>
                        <div class="product-footer">
                            <span class="product-price">$18.49</span>
                            <button class="btn-small">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <div class="product-card" data-category="dark">
                    <div class="product-image" style="background: linear-gradient(135deg, #4E342E 0%, #2C1810 100%);">
                    </div>
                    <div class="product-info">
                        <h3>Italian Espresso Blend</h3>
                        <p class="product-origin">Blend · Dark Roast</p>
                        <p class="product-notes">Bold, Rich, Creamy</p>
                        <p class="product-description">Our signature espresso blend. Bold and intense with a creamy crema. Perfect for straight shots or milk drinks.</p>
                        <div class="product-footer">
                            <span class="product-price">$16.49</span>
                            <button class="btn-small">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <div class="product-card" data-category="light">
                    <div class="product-image" style="background: linear-gradient(135deg, #876445 0%, #543A2F 100%);">
                    </div>
                    <div class="product-info">
                        <h3>Panama Geisha</h3>
                        <p class="product-origin">Panama · Light Roast</p>
                        <p class="product-notes">Jasmine, Tropical, Delicate</p>
                        <p class="product-description">An ultra-premium coffee with jasmine aromatics and tropical fruit flavors. Limited availability.</p>
                        <div class="product-footer">
                            <span class="product-price">$24.99</span>
                            <button class="btn-small">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <div class="product-card" data-category="dark">
                    <div class="product-image" style="background: linear-gradient(135deg, #5C4033 0%, #3A2821 100%);">
                    </div>
                    <div class="product-info">
                        <h3>French Roast</h3>
                        <p class="product-origin">Blend · Dark Roast</p>
                        <p class="product-notes">Bold, Smoky, Intense</p>
                        <p class="product-description">A classic dark roast with bold, smoky flavors and low acidity. Strong and satisfying.</p>
                        <div class="product-footer">
                            <span class="product-price">$15.99</span>
                            <button class="btn-small">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Info Section -->
    <section class="product-info-section">
        <div class="container">
            <div class="info-cards">
                <div class="info-card">
                    <h3>🚚 Free Shipping</h3>
                    <p>On orders over $30</p>
                </div>
                <div class="info-card">
                    <h3>🌱 Fresh Guarantee</h3>
                    <p>Roasted within 48 hours</p>
                </div>
                <div class="info-card">
                    <h3>🔄 Easy Returns</h3>
                    <p>30-day satisfaction guarantee</p>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>