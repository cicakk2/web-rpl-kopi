<?php
require_once 'auth_check.php';

$success_message = '';
$error_message = '';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $delete_sql = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        $success_message = "Product deleted successfully!";
    } else {
        $error_message = "Error deleting product.";
    }
    mysqli_stmt_close($stmt);
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $origin = mysqli_real_escape_string($conn, $_POST['origin']);
    $roast_level = mysqli_real_escape_string($conn, $_POST['roast_level']);
    $flavor_notes = mysqli_real_escape_string($conn, $_POST['flavor_notes']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $stock_quantity = intval($_POST['stock_quantity']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_organic = isset($_POST['is_organic']) ? 1 : 0;
    
    if ($id > 0) {
        // Update
        $sql = "UPDATE products SET name=?, origin=?, roast_level=?, flavor_notes=?, description=?, price=?, stock_quantity=?, is_featured=?, is_organic=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssdiixi", $name, $origin, $roast_level, $flavor_notes, $description, $price, $stock_quantity, $is_featured, $is_organic, $id);
    } else {
        // Insert
        $sql = "INSERT INTO products (name, origin, roast_level, flavor_notes, description, price, stock_quantity, is_featured, is_organic) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssdixi", $name, $origin, $roast_level, $flavor_notes, $description, $price, $stock_quantity, $is_featured, $is_organic);
    }
    
    if (mysqli_stmt_execute($stmt)) {
        $success_message = $id > 0 ? "Product updated successfully!" : "Product added successfully!";
    } else {
        $error_message = "Error saving product.";
    }
    mysqli_stmt_close($stmt);
}

// Get all products
$products_query = "SELECT * FROM products ORDER BY created_at DESC";
$products_result = mysqli_query($conn, $products_query);

// Get product for editing
$edit_product = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $edit_query = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $edit_query);
    mysqli_stmt_bind_param($stmt, "i", $edit_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $edit_product = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Roasted Bliss Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="admin-body">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="admin-content">
        <?php include 'includes/topbar.php'; ?>
        
        <div class="admin-main">
            <div class="page-header">
                <div>
                    <h1>Products Management</h1>
                    <p>Add, edit, and manage your coffee products</p>
                </div>
                <button class="btn btn-primary" onclick="openModal()">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                    Add New Product
                </button>
            </div>
            
            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="alert alert-error">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <!-- Products Table -->
            <div class="dashboard-card">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Origin</th>
                                <th>Roast Level</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Featured</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($products_result) > 0): ?>
                                <?php while ($product = mysqli_fetch_assoc($products_result)): ?>
                                    <tr>
                                        <td><?php echo $product['id']; ?></td>
                                        <td><strong><?php echo htmlspecialchars($product['name']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($product['origin']); ?></td>
                                        <td><span class="badge badge-<?php echo $product['roast_level']; ?>"><?php echo ucfirst($product['roast_level']); ?></span></td>
                                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                                        <td>
                                            <span class="stock-badge <?php echo $product['stock_quantity'] < 20 ? 'stock-low' : 'stock-good'; ?>">
                                                <?php echo $product['stock_quantity']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($product['is_featured']): ?>
                                                <span class="badge badge-success">Yes</span>
                                            <?php else: ?>
                                                <span class="badge badge-gray">No</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button onclick='editProduct(<?php echo json_encode($product); ?>)' class="btn-icon btn-edit" title="Edit">
                                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                    </svg>
                                                </button>
                                                <a href="?delete=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?')" class="btn-icon btn-delete" title="Delete">
                                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No products found. Add your first product!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add/Edit Product Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add New Product</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form method="POST" action="">
                <input type="hidden" id="product_id" name="id" value="">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Product Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="origin">Origin *</label>
                        <input type="text" id="origin" name="origin" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="roast_level">Roast Level *</label>
                        <select id="roast_level" name="roast_level" required>
                            <option value="light">Light Roast</option>
                            <option value="medium">Medium Roast</option>
                            <option value="dark">Dark Roast</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="flavor_notes">Flavor Notes *</label>
                        <input type="text" id="flavor_notes" name="flavor_notes" placeholder="e.g., Floral, Citrus, Tea-like" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" rows="3" required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price ($) *</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="stock_quantity">Stock Quantity *</label>
                        <input type="number" id="stock_quantity" name="stock_quantity" min="0" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="is_featured" name="is_featured">
                            <span>Featured Product</span>
                        </label>
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="is_organic" name="is_organic">
                            <span>Organic</span>
                        </label>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="../js/script.js"></script>
    <script src="js/admin.js"></script>
    <script>
        function openModal() {
            document.getElementById('productModal').style.display = 'flex';
            document.getElementById('modalTitle').textContent = 'Add New Product';
            document.querySelector('#productModal form').reset();
            document.getElementById('product_id').value = '';
        }
        
        function closeModal() {
            document.getElementById('productModal').style.display = 'none';
        }
        
        function editProduct(product) {
            document.getElementById('productModal').style.display = 'flex';
            document.getElementById('modalTitle').textContent = 'Edit Product';
            document.getElementById('product_id').value = product.id;
            document.getElementById('name').value = product.name;
            document.getElementById('origin').value = product.origin;
            document.getElementById('roast_level').value = product.roast_level;
            document.getElementById('flavor_notes').value = product.flavor_notes;
            document.getElementById('description').value = product.description;
            document.getElementById('price').value = product.price;
            document.getElementById('stock_quantity').value = product.stock_quantity;
            document.getElementById('is_featured').checked = product.is_featured == 1;
            document.getElementById('is_organic').checked = product.is_organic == 1;
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('productModal');
            if (event.target == modal) {
                closeModal();
            }
        }
        
        <?php if ($edit_product): ?>
            editProduct(<?php echo json_encode($edit_product); ?>);
        <?php endif; ?>
    </script>
</body>
</html>
