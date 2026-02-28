<?php
require_once 'config/db_config.php';
$page = 'contact';

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    $sql = "INSERT INTO contacts (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $subject, $message);
    
    if (mysqli_stmt_execute($stmt)) {
        $success_message = "Thank you! Your message has been sent successfully.";
    } else {
        $error_message = "Sorry, there was an error sending your message. Please try again.";
    }
    
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Robusta Dampit</title>
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
            <span class="page-subtitle">Hubungi Kami</span>
            <h1 class="page-title">Hubungi Kami untuk<br>Pemesanan</h1>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info">
                    <h2>Temukan Kopi Favorit Anda</h2>
                    <p>Masih bingung memilih kopi yang pas? Hubungi kami untuk rekomendasi terbaik dan nikmati kualitas kopi pilihan untuk setiap momen Anda.</p>
                    
                    <div class="social-links">
                        <h4>Ikuti Kami</h4>
                        <div class="social-icons">
                            <a href="#" class="social-icon">Instagram</a>
                            <a href="#" class="social-icon">Whatsapp</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>