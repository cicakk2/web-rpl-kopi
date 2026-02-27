<?php
require_once 'config/db_config.php';
$page = 'about';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Robusta Dampit</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="about-page-main">
        <div class="container">
            <h1 class="page-title-simple">Tentang Kami</h1>

            <div class="about-simple-grid">
                <div class="about-image-wrapper">
                    <img src="images/barista.jpg" alt="Barista Robusta Dampit" class="img-fluid rounded">
                </div>
                <div class="about-text-content">
                    <p>Robusta Dampit adalah brand kopi yang berfokus menghadirkan bubuk kopi berkualitas dari biji pilihan Nusantara. Setiap produk kami melalui proses sangrai yang terkontrol untuk menjaga aroma, rasa, dan kesegaran terbaik di setiap seduhan. Kami berkomitmen memberikan kopi yang konsisten, nikmat, dan mudah dinikmati oleh pecinta kopi, baik untuk konsumsi harian maupun kebutuhan usaha.</p>
                </div>
            </div>

            <div class="map-container-simple">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126438.2854809287!2d112.5617424!3d-7.9784695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd62822025136df%3A0x1042718428e2363a!2sMalang%2C%20East%20Java!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>