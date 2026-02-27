<header class="header">
    <div class="container">
        <nav class="navbar">
            <a href="index.php" class="logo">
                <span class="logo-icon">☕</span>
                <span class="logo-text">Roasted Bliss</span>
            </a>
            
            <button class="mobile-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php" class="nav-link <?php echo $page === 'home' ? 'active' : ''; ?>">Home</a></li>
                <li><a href="about.php" class="nav-link <?php echo $page === 'about' ? 'active' : ''; ?>">About</a></li>
                <li><a href="product.php" class="nav-link <?php echo $page === 'product' ? 'active' : ''; ?>">Products</a></li>
                <li><a href="contact.php" class="nav-link <?php echo $page === 'contact' ? 'active' : ''; ?>">Contact</a></li>
            </ul>
        </nav>
    </div>
</header>
