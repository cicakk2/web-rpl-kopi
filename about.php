<?php
require_once 'config/db_config.php';
$page = 'about';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Roasted Bliss</title>
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
            <span class="page-subtitle">Our Story</span>
            <h1 class="page-title">Crafting Excellence<br>One Cup at a Time</h1>
        </div>
    </section>

    <!-- About Content -->
    <section class="about-content">
        <div class="container">
            <div class="about-grid">
                <div class="about-text">
                    <h2>Our Journey</h2>
                    <p>Founded in 2024, Roasted Bliss began with a simple mission: to bring exceptional, ethically-sourced coffee to passionate enthusiasts. What started as a small roastery has grown into a beloved destination for those who appreciate the art and science of specialty coffee.</p>
                    <p>Every bean that passes through our hands is carefully selected from sustainable farms around the world. We believe in building lasting relationships with our farmers, ensuring fair prices and supporting communities that share our commitment to quality.</p>
                    <p>Our small-batch roasting approach allows us to highlight the unique characteristics of each origin, creating profiles that honor the hard work of everyone involved in bringing these exceptional coffees to your cup.</p>
                </div>
                <div class="about-image">
                    <div class="image-placeholder" style="background: linear-gradient(135deg, #6B4423 0%, #3E2723 100%);"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values">
        <div class="container">
            <h2 class="section-title">What Drives Us</h2>
            <div class="values-grid">
                <div class="value-item">
                    <div class="value-number">01</div>
                    <h3>Quality First</h3>
                    <p>We never compromise on quality. Every bean is carefully inspected and roasted to bring out its best characteristics.</p>
                </div>
                <div class="value-item">
                    <div class="value-number">02</div>
                    <h3>Sustainability</h3>
                    <p>Supporting sustainable farming practices and fair trade relationships that benefit farmers and communities.</p>
                </div>
                <div class="value-item">
                    <div class="value-number">03</div>
                    <h3>Community</h3>
                    <p>Building a community of coffee lovers who share our passion for exceptional coffee experiences.</p>
                </div>
                <div class="value-item">
                    <div class="value-number">04</div>
                    <h3>Innovation</h3>
                    <p>Constantly exploring new roasting techniques and brewing methods to enhance your coffee experience.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team">
        <div class="container">
            <h2 class="section-title">Meet Our Roasters</h2>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-image" style="background: linear-gradient(135deg, #8B5A3C 0%, #4E342E 100%);"></div>
                    <h3>Sarah Mitchell</h3>
                    <p class="member-role">Head Roaster</p>
                    <p class="member-bio">15 years of experience crafting perfect roast profiles</p>
                </div>
                <div class="team-member">
                    <div class="member-image" style="background: linear-gradient(135deg, #6B4423 0%, #3E2723 100%);"></div>
                    <h3>James Rodriguez</h3>
                    <p class="member-role">Coffee Sourcing</p>
                    <p class="member-bio">Direct relationships with farmers across 12 countries</p>
                </div>
                <div class="team-member">
                    <div class="member-image" style="background: linear-gradient(135deg, #5D4037 0%, #3E2723 100%);"></div>
                    <h3>Emma Chen</h3>
                    <p class="member-role">Quality Control</p>
                    <p class="member-bio">Certified Q-Grader ensuring consistency and excellence</p>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>