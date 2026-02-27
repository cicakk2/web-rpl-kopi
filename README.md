# Coffee Business Website

A complete, modern website for a specialty coffee roastery business built with PHP, MySQL, CSS, and JavaScript.

## Features

- **Responsive Design**: Fully responsive layout that works on all devices
- **Modern UI**: Coffee-themed color scheme with smooth animations
- **Database Integration**: PHP-based backend with MySQL database
- **Contact Form**: Functional contact form with database storage
- **Product Catalog**: Dynamic product display with filtering
- **SEO Friendly**: Semantic HTML and proper structure

## Coffee Theme Colors

- Dark Coffee: `#2C1810`
- Coffee Brown: `#4E342E`
- Medium Coffee: `#6B4423`
- Light Coffee: `#8B5A3C`
- Coffee Cream: `#D4A574`
- Coffee Beige: `#F5E6D3`
- Cream Background: `#FFF8F0`

## Pages

1. **Home (index.php)**: Landing page with hero section, features, and featured products
2. **About (about.php)**: Company story, values, and team members
3. **Products (product.php)**: Complete product catalog with filtering by roast level
4. **Contact (contact.php)**: Contact form and business information

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Web browser

### Setup Instructions

1. **Clone or Download the Project**
   ```bash
   # Place all files in your web server's root directory
   # Example: /var/www/html/ or C:/xampp/htdocs/
   ```

2. **Database Setup**
   
   a. Create the database:
   ```bash
   mysql -u root -p
   ```
   
   b. Import the schema:
   ```bash
   mysql -u root -p < database/schema.sql
   ```
   
   Or manually execute the SQL file in phpMyAdmin.

3. **Configure Database Connection**
   
   Edit `config/db_config.php` and update the following constants:
   ```php
   define('DB_HOST', 'localhost');     // Your database host
   define('DB_USER', 'root');          // Your database username
   define('DB_PASS', '');              // Your database password
   define('DB_NAME', 'coffee_business');// Database name
   ```

4. **File Permissions**
   
   Ensure proper permissions are set:
   ```bash
   chmod 755 index.php about.php product.php contact.php
   chmod 755 config/
   chmod 644 config/db_config.php
   chmod 755 css/ js/ includes/
   ```

5. **Start Your Server**
   
   - **XAMPP**: Start Apache and MySQL services
   - **MAMP**: Start servers
   - **Local PHP**: `php -S localhost:8000`

6. **Access the Website**
   
   Open your browser and navigate to:
   ```
   http://localhost/
   ```
   or
   ```
   http://localhost:8000/
   ```

## Project Structure

```
coffee-business/
│
├── index.php              # Homepage
├── about.php              # About page
├── product.php            # Products page
├── contact.php            # Contact page
│
├── config/
│   └── db_config.php      # Database configuration
│
├── includes/
│   ├── header.php         # Header component
│   └── footer.php         # Footer component
│
├── css/
│   └── style.css          # Main stylesheet
│
├── js/
│   └── script.js          # JavaScript functionality
│
├── database/
│   └── schema.sql         # Database schema and sample data
│
└── README.md              # This file
```

## Database Tables

1. **products**: Store coffee products
2. **contacts**: Store contact form submissions
3. **customers**: Store customer information
4. **orders**: Store order details
5. **order_items**: Store individual order items
6. **newsletter_subscribers**: Store newsletter subscriptions

## Features Breakdown

### Navigation
- Sticky header with smooth scroll
- Mobile-responsive hamburger menu
- Active page highlighting

### Homepage
- Full-screen hero section with animations
- Feature cards with icons
- Featured products showcase
- Call-to-action section

### About Page
- Company story and mission
- Core values with numbered items
- Team member profiles

### Products Page
- Interactive filter buttons (All, Light, Medium, Dark roast)
- Product cards with hover effects
- Product details and pricing
- "Add to Cart" functionality (demo)

### Contact Page
- Functional contact form
- Form validation
- Database submission
- Contact information display
- Map placeholder section

## Customization

### Changing Colors

Edit the CSS variables in `css/style.css`:
```css
:root {
    --coffee-dark: #2C1810;
    --coffee-brown: #4E342E;
    /* ... add your colors ... */
}
```

### Adding Products

Insert products directly into the database:
```sql
INSERT INTO products (name, origin, roast_level, flavor_notes, description, price, stock_quantity)
VALUES ('Product Name', 'Origin', 'medium', 'Flavor Notes', 'Description', 19.99, 50);
```

### Updating Content

- Edit page content directly in the PHP files
- Modify header/footer in `includes/header.php` and `includes/footer.php`
- Update styles in `css/style.css`
- Add JavaScript functionality in `js/script.js`

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

## Performance

- Optimized CSS with animations
- Lazy loading for images
- Efficient JavaScript
- Prepared statements for database queries

## Security Features

- SQL injection prevention with prepared statements
- Input sanitization
- XSS protection with htmlspecialchars
- CSRF protection ready (can be added)
- Secure database connections

## Troubleshooting

### Database Connection Errors

1. Check MySQL service is running
2. Verify credentials in `config/db_config.php`
3. Ensure database exists: `coffee_business`
4. Check user permissions

### Page Not Loading

1. Check web server is running
2. Verify PHP is installed: `php -v`
3. Check file permissions
4. Review server error logs

### Styles Not Applying

1. Clear browser cache
2. Check CSS file path is correct
3. Verify web server serves CSS files
4. Check browser console for errors

## Future Enhancements

- Shopping cart functionality
- User authentication system
- Admin dashboard
- Payment gateway integration
- Email notifications
- Product reviews and ratings
- Inventory management
- Order tracking
- Newsletter system

## Credits

- Fonts: Google Fonts (Cormorant Garamond, Montserrat)
- Icons: Unicode emoji (can be replaced with Font Awesome)
- Design: Custom coffee-themed aesthetic

## License

This project is free to use for personal and commercial purposes.

## Support

For issues or questions, please use the contact form on the website or open an issue in the repository.

---

**Developed with ☕ and passion for great coffee**
