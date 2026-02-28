# Admin Panel Setup Guide

## 🎯 Admin Panel Features

The admin panel provides complete management capabilities for your coffee business website:

### ✨ Features:
- **Dashboard**: Overview with statistics and recent activity
- **Products Management**: Full CRUD operations (Create, Read, Update, Delete)
- **Orders Management**: View and track customer orders
- **Messages**: Manage contact form submissions
- **Secure Login**: Password-protected admin access
- **Responsive Design**: Works on all devices
- **Coffee-Themed UI**: Matches the main website design

## 🔐 Default Login Credentials

**Important**: Change these credentials immediately after first login!

```
Username: admin
Password: admin123
```

## 📁 Admin Panel Structure

```
admin/
├── admin-login.php          # Admin login page (root level)
├── admin/
│   ├── dashboard.php        # Main admin dashboard
│   ├── products.php         # Products CRUD page
│   ├── orders.php           # Orders management
│   ├── contacts.php         # Messages management
│   ├── logout.php           # Logout handler
│   ├── auth_check.php       # Authentication check
│   ├── css/
│   │   └── admin.css        # Admin panel styles
│   ├── js/
│   │   └── admin.js         # Admin panel scripts
│   └── includes/
│       ├── sidebar.php      # Navigation sidebar
│       └── topbar.php       # Top navigation bar
```

## 🚀 Installation Steps

### 1. Database Setup

The admin functionality requires the `admins` table. Import the updated schema:

```bash
mysql -u root -p coffee_business < database/schema.sql
```

This will create:
- `admins` table with a default admin user
- All other necessary tables
- Sample products data

### 2. File Permissions

Ensure proper permissions for admin files:

```bash
chmod 755 admin/
chmod 644 admin-login.php
chmod 644 admin/*.php
chmod 755 admin/css/ admin/js/ admin/includes/
```

### 3. Access the Admin Panel

Navigate to:
```
http://localhost/admin-login.php
```

Or:
```
http://your-domain.com/admin-login.php
```

### 4. Login

Use the default credentials:
- Username: `admin`
- Password: `admin123`

## 🔑 Changing Admin Password

### Method 1: Using PHP Script

Create a temporary file `change-password.php` in your root directory:

```php
<?php
require_once 'config/db_config.php';

$username = 'admin';
$new_password = 'your-new-secure-password';
$hashed = password_hash($new_password, PASSWORD_DEFAULT);

$sql = "UPDATE admins SET password = ? WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $hashed, $username);

if (mysqli_stmt_execute($stmt)) {
    echo "Password updated successfully!";
} else {
    echo "Error updating password.";
}

mysqli_stmt_close($stmt);
// DELETE THIS FILE AFTER USE!
?>
```

Run it once, then **DELETE IT IMMEDIATELY**.

### Method 2: Using MySQL Command

```sql
UPDATE admins 
SET password = '$2y$10$YOUR_HASHED_PASSWORD_HERE' 
WHERE username = 'admin';
```

Generate hash using PHP:
```php
echo password_hash('your-new-password', PASSWORD_DEFAULT);
```

## 📊 Admin Dashboard Features

### Statistics Cards
- Total Products count
- Total Orders count
- Pending Orders count
- Low Stock Items alert

### Recent Activity
- Latest 5 orders with status
- Recent contact messages
- Quick action buttons

## 🛍️ Products Management (CRUD)

### Create Product
1. Click "Add New Product" button
2. Fill in product details:
   - Name
   - Origin
   - Roast Level (Light/Medium/Dark)
   - Flavor Notes
   - Description
   - Price
   - Stock Quantity
   - Featured checkbox
   - Organic checkbox
3. Click "Save Product"

### Read/View Products
- All products displayed in a table
- Shows: ID, Name, Origin, Roast Level, Price, Stock, Featured status
- Color-coded badges for roast levels
- Stock status indicators (low stock highlighted)

### Update Product
1. Click the edit icon (pencil) on any product
2. Modify the details in the modal
3. Click "Save Product"

### Delete Product
1. Click the delete icon (trash) on any product
2. Confirm the deletion
3. Product is permanently removed

### Features:
- Real-time form validation
- Modal-based editing
- Inline stock status indicators
- Responsive table design
- Filtering by roast level

## 📦 Orders Management

- View all customer orders
- Order details: Order #, Customer, Email, Amount, Payment Status, Order Status
- Color-coded status badges
- Date sorting
- Customer information at a glance

## 💬 Messages Management

- View all contact form submissions
- Status indicators (New/Read/Replied)
- Mark as read functionality
- View full message in modal
- Quick reply via email link
- Delete messages
- New messages highlighted

## 🎨 Design Features

### Coffee Theme Colors
All admin panel colors match the main website:
- Dark Coffee: `#2C1810`
- Coffee Brown: `#4E342E`
- Medium Coffee: `#6B4423`
- Coffee Cream: `#D4A574`

### UI Elements
- Smooth animations and transitions
- Hover effects on all interactive elements
- Responsive sidebar navigation
- Mobile-friendly design
- Modal dialogs for actions
- Toast notifications for success/error messages

## 🔒 Security Features

### Authentication
- Session-based login system
- Password hashing with bcrypt
- Session timeout (30 minutes of inactivity)
- Login required for all admin pages

### SQL Injection Prevention
- Prepared statements for all queries
- Input sanitization
- Parameter binding

### XSS Protection
- HTML special characters escaped
- Output encoding
- CSP headers ready

### Best Practices
- Secure password storage
- Session management
- Access control
- Error handling

## 📱 Responsive Design

The admin panel is fully responsive and works on:
- Desktop (1920px+)
- Laptop (1024px+)
- Tablet (768px+)
- Mobile (320px+)

### Mobile Features:
- Collapsible sidebar
- Touch-friendly buttons
- Optimized tables
- Simplified navigation

## 🎯 Usage Tips

### Product Management
1. Keep stock quantities updated
2. Use descriptive flavor notes
3. Enable "Featured" for homepage display
4. Mark organic products appropriately
5. Update prices regularly

### Order Processing
1. Check pending orders daily
2. Update order status promptly
3. Verify customer information
4. Track payment status

### Customer Communication
1. Respond to messages within 24 hours
2. Mark messages as read after handling
3. Use the reply link for quick responses
4. Delete spam messages

## 🛠️ Troubleshooting

### Cannot Login
1. Verify database connection in `config/db_config.php`
2. Check if `admins` table exists
3. Verify username and password
4. Check session permissions

### Products Not Saving
1. Check database connection
2. Verify form validation
3. Check browser console for errors
4. Ensure all required fields are filled

### Session Timeout Issues
1. Check PHP session settings
2. Verify session directory permissions
3. Adjust timeout in `auth_check.php`

### Styling Issues
1. Clear browser cache
2. Check if CSS files are loading
3. Verify file paths
4. Check console for 404 errors

## 🔄 Updating the Admin Panel

### Adding New Features
1. Create new PHP file in `admin/`
2. Include `auth_check.php` at the top
3. Add navigation link in `includes/sidebar.php`
4. Follow existing code patterns

### Modifying Styles
- Edit `admin/css/admin.css`
- Use existing CSS variables for consistency
- Test responsive design

### Adding New Admin Users

```sql
INSERT INTO admins (username, password, full_name, email) 
VALUES ('newuser', '$2y$10$HASHED_PASSWORD', 'Full Name', 'email@example.com');
```

## 📈 Performance Optimization

- Prepared statements for faster queries
- Efficient table indexing
- Lazy loading for large datasets
- Optimized CSS and JavaScript
- Minimal external dependencies

## 🎓 Learning Resources

### PHP & MySQL
- [PHP Manual](https://www.php.net/manual/)
- [MySQL Documentation](https://dev.mysql.com/doc/)

### Security
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Best Practices](https://www.php.net/manual/en/security.php)

## ⚠️ Important Notes

1. **Change default password immediately**
2. **Always use HTTPS in production**
3. **Regular database backups**
4. **Keep PHP and MySQL updated**
5. **Monitor admin access logs**
6. **Use strong passwords**
7. **Limit admin user accounts**

## 🎉 You're All Set!

Your admin panel is now fully functional and ready to manage your coffee business website. The system is secure, user-friendly, and fully integrated with your website's design.

For questions or issues, refer to the troubleshooting section or check the code comments for detailed explanations.

---

**Happy Managing! ☕**
