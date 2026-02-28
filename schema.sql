-- ==========================================
-- Coffee Business Database Schema
-- ==========================================

-- Create database
CREATE DATABASE IF NOT EXISTS coffee_business;
USE coffee_business;

-- ==========================================
-- Table: products
-- Stores coffee product information
-- ==========================================
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    origin VARCHAR(100) NOT NULL,
    roast_level ENUM('light', 'medium', 'dark') NOT NULL,
    flavor_notes TEXT,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT DEFAULT 0,
    image_url VARCHAR(255),
    is_featured BOOLEAN DEFAULT FALSE,
    is_organic BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_roast_level (roast_level),
    INDEX idx_is_featured (is_featured)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Table: admins
-- Stores administrator accounts
-- ==========================================
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Table: contacts
-- Stores customer contact form submissions
-- ==========================================
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Table: customers
-- Stores customer information
-- ==========================================
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(100),
    state VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Table: orders
-- Stores order information
-- ==========================================
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    order_number VARCHAR(50) NOT NULL UNIQUE,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    shipping_address TEXT,
    payment_method VARCHAR(50),
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    INDEX idx_customer_id (customer_id),
    INDEX idx_status (status),
    INDEX idx_order_number (order_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Table: order_items
-- Stores individual items in each order
-- ==========================================
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_order_id (order_id),
    INDEX idx_product_id (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Table: newsletter_subscribers
-- Stores newsletter subscription information
-- ==========================================
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    status ENUM('active', 'unsubscribed') DEFAULT 'active',
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    unsubscribed_at TIMESTAMP NULL,
    INDEX idx_email (email),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Insert Default Admin User
-- Username: admin
-- Password: admin123 (Please change after first login!)
-- ==========================================
INSERT INTO admins (username, password, full_name, email) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@roastedbliss.com');

-- ==========================================
-- Insert Sample Products
-- ==========================================
INSERT INTO products (name, origin, roast_level, flavor_notes, description, price, stock_quantity, is_featured, is_organic) VALUES
('Ethiopian Yirgacheffe', 'Ethiopia', 'light', 'Floral, Citrus, Tea-like', 'A bright and complex coffee with delicate floral notes and citrus undertones. Perfect for pour-over brewing.', 18.99, 50, TRUE, FALSE),
('Colombian Supremo', 'Colombia', 'medium', 'Caramel, Nuts, Chocolate', 'A well-balanced coffee with sweet caramel notes and a smooth, chocolatey finish. Versatile for any brewing method.', 16.99, 75, TRUE, FALSE),
('Sumatra Mandheling', 'Indonesia', 'dark', 'Earthy, Herbal, Spiced', 'A full-bodied coffee with earthy complexity and herbal notes. Low acidity makes it ideal for espresso.', 17.99, 60, TRUE, FALSE),
('Kenya AA', 'Kenya', 'light', 'Berry, Wine, Bright', 'Vibrant acidity with berry-like sweetness and wine-like complexity. A true connoisseur\'s choice.', 19.99, 40, FALSE, FALSE),
('Guatemala Antigua', 'Guatemala', 'medium', 'Cocoa, Spice, Smoky', 'Rich and complex with cocoa notes and a hint of smoke. Grown in volcanic soil at high altitude.', 17.49, 55, FALSE, FALSE),
('Costa Rica Tarrazu', 'Costa Rica', 'medium', 'Honey, Citrus, Clean', 'Certified organic with honey sweetness and bright citrus acidity. Clean and crisp finish.', 18.49, 45, FALSE, TRUE),
('Italian Espresso Blend', 'Blend', 'dark', 'Bold, Rich, Creamy', 'Our signature espresso blend. Bold and intense with a creamy crema. Perfect for straight shots or milk drinks.', 16.49, 80, FALSE, FALSE),
('Panama Geisha', 'Panama', 'light', 'Jasmine, Tropical, Delicate', 'An ultra-premium coffee with jasmine aromatics and tropical fruit flavors. Limited availability.', 24.99, 20, FALSE, FALSE),
('French Roast', 'Blend', 'dark', 'Bold, Smoky, Intense', 'A classic dark roast with bold, smoky flavors and low acidity. Strong and satisfying.', 15.99, 90, FALSE, FALSE);

-- ==========================================
-- Sample Contact Entry
-- ==========================================
INSERT INTO contacts (name, email, subject, message, status) VALUES
('John Doe', 'john@example.com', 'Product Inquiry', 'I would like to know more about your Ethiopian Yirgacheffe coffee.', 'new');

-- ==========================================
-- Create Views for Reporting
-- ==========================================

-- View: Featured Products
CREATE OR REPLACE VIEW v_featured_products AS
SELECT 
    id,
    name,
    origin,
    roast_level,
    flavor_notes,
    price,
    stock_quantity
FROM products
WHERE is_featured = TRUE AND stock_quantity > 0
ORDER BY name;

-- View: Order Summary
CREATE OR REPLACE VIEW v_order_summary AS
SELECT 
    o.id,
    o.order_number,
    CONCAT(c.first_name, ' ', c.last_name) as customer_name,
    c.email,
    o.total_amount,
    o.status,
    o.created_at
FROM orders o
JOIN customers c ON o.customer_id = c.id
ORDER BY o.created_at DESC;

-- View: Product Inventory Alert (Low Stock)
CREATE OR REPLACE VIEW v_low_stock_products AS
SELECT 
    id,
    name,
    origin,
    stock_quantity
FROM products
WHERE stock_quantity < 20
ORDER BY stock_quantity ASC;

-- ==========================================
-- End of Schema
-- ==========================================
