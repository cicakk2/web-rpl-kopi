<?php
require_once 'auth_check.php';

$success_message = '';
$error_message = '';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Get image path before deleting
    $img_query = "SELECT image_url FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $img_query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    // Delete image file if exists
    if ($product && $product['image_url']) {
        $image_path = "../uploads/" . basename($product['image_url']);
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    
    // Delete product from database
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
    $image_url = '';
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_size = $_FILES['image']['size'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Validation
        if (!in_array($file_extension, $allowed_extensions)) {
            $error_message = "Invalid file format. Allowed: JPG, PNG, GIF, WEBP";
        } elseif ($file_size > 5 * 1024 * 1024) { // 5MB limit
            $error_message = "File size too large. Maximum 5MB allowed.";
        } else {
            // Create unique filename
            $new_filename = 'product_' . time() . '_' . uniqid() . '.' . $file_extension;
            $upload_dir = '../uploads/';
            
            // Create directory if not exists
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($file_tmp, $upload_path)) {
                $image_url = $new_filename;
                
                // Delete old image if editing
                if ($id > 0) {
                    $old_img_query = "SELECT image_url FROM products WHERE id = ?";
                    $stmt = mysqli_prepare($conn, $old_img_query);
                    mysqli_stmt_bind_param($stmt, "i", $id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $old_product = mysqli_fetch_assoc($result);
                    mysqli_stmt_close($stmt);
                    
                    if ($old_product && $old_product['image_url']) {
                        $old_image_path = $upload_dir . $old_product['image_url'];
                        if (file_exists($old_image_path)) {
                            unlink($old_image_path);
                        }
                    }
                }
            } else {
                $error_message = "Failed to upload image. Please try again.";
            }
        }
    } else if ($id > 0 && !isset($_FILES['image'])) {
        // If editing without uploading new image, keep old image
        $old_img_query = "SELECT image_url FROM products WHERE id = ?";
        $stmt = mysqli_prepare($conn, $old_img_query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $old_product = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        
        $image_url = $old_product['image_url'] ?? '';
    }
    
    // Save to database only if no error occurred
    if (!$error_message) {
        if ($id > 0) {
            // UPDATE: 11 Parameter (10 Kolom + 1 ID untuk WHERE)
            if ($image_url) {
                $sql = "UPDATE products SET name=?, origin=?, roast_level=?, flavor_notes=?, description=?, price=?, stock_quantity=?, is_featured=?, is_organic=?, image_url=? WHERE id=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssssdiiisi", $name, $origin, $roast_level, $flavor_notes, $description, $price, $stock_quantity, $is_featured, $is_organic, $image_url, $id);
            } else {
                $sql = "UPDATE products SET name=?, origin=?, roast_level=?, flavor_notes=?, description=?, price=?, stock_quantity=?, is_featured=?, is_organic=? WHERE id=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssssdiiii", $name, $origin, $roast_level, $flavor_notes, $description, $price, $stock_quantity, $is_featured, $is_organic, $id);
            }
        } else {
            // INSERT: 10 Parameter
            $sql = "INSERT INTO products (name, origin, roast_level, flavor_notes, description, price, stock_quantity, is_featured, is_organic, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssssdiiiis", $name, $origin, $roast_level, $flavor_notes, $description, $price, $stock_quantity, $is_featured, $is_organic, $image_url);
        }
        
        if (mysqli_stmt_execute($stmt)) {
            $success_message = $id > 0 ? "Product updated successfully!" : "Product added successfully!";
        } else {
            $error_message = "Error saving product.";
        }
        mysqli_stmt_close($stmt);
    }
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
                    <h1>Manajemen Produk</h1>
                    <p>Tambahkan dan Edit Produkmu.</p>
                </div>
                <button class="btn btn-primary" onclick="openModal()">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                    Tambahkan Produk Baru
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
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Asal</th>
                                <th>Warna</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Featured</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($products_result) > 0): ?>
                                <?php while ($product = mysqli_fetch_assoc($products_result)): ?>
                                    <tr>
                                        <td>
                                            <?php if ($product['image_url']): ?>
                                                <img src="../uploads/<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="table-product-image">
                                            <?php else: ?>
                                                <div class="no-image-placeholder">No Image</div>
                                            <?php endif; ?>
                                        </td>
                                        <td><strong><?php echo htmlspecialchars($product['name']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($product['origin']); ?></td>
                                        <td><span class="badge badge-<?php echo $product['roast_level']; ?>"><?php echo ucfirst($product['roast_level']); ?></span></td>
                                        <td>Rp. <?php echo number_format($product['price'], 2); ?></td>
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
                <h2 id="modalTitle">Tambahkan Produk Baru`</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" id="product_id" name="id" value="">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nama Produk *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="origin">Asal *</label>
                        <input type="text" id="origin" name="origin" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="roast_level">Warna *</label>
                        <select id="roast_level" name="roast_level" required>
                            <option value="light">Cream</option>
                            <option value="medium">Tan</option>
                            <option value="dark">Dark</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="flavor_notes">Karakter Rasa *</label>
                        <input type="text" id="flavor_notes" name="flavor_notes" placeholder="e.g., Floral, Citrus, Tea-like" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Deskripsi *</label>
                    <textarea id="description" name="description" rows="3" required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price (Rp) *</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="stock_quantity">Jumlah Stok *</label>
                        <input type="number" id="stock_quantity" name="stock_quantity" min="0" required>
                    </div>
                </div>
                
                <!-- Image Upload Section -->
                <div class="form-group">
                    <label for="image">Gambar Produk</label>
                    <div class="image-upload-container">
                        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp" class="image-input">
                        <div class="image-upload-label">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            <span>Click to upload or drag and drop</span>
                            <p>PNG, JPG, GIF, WEBP (Max 5MB)</p>
                        </div>
                    </div>
                    <div id="imagePreviewContainer" class="image-preview-container" style="display: none;">
                        <img id="imagePreview" src="" alt="Preview" class="image-preview-img">
                        <button type="button" class="btn-remove-image" onclick="removeImage()">Remove Image</button>
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
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Batalkan</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="../js/script.js"></script>
    <script src="js/admin.js"></script>
    <script>
        function openModal() {
            document.getElementById('productModal').style.display = 'flex';
            document.getElementById('modalTitle').textContent = 'Tambahkan Produk Baru';
            document.querySelector('#productModal form').reset();
            document.getElementById('product_id').value = '';
            document.getElementById('imagePreviewContainer').style.display = 'none';
        }
        
        function closeModal() {
            document.getElementById('productModal').style.display = 'none';
        }
        
        function editProduct(product) {
            document.getElementById('productModal').style.display = 'flex';
            document.getElementById('modalTitle').textContent = 'Edit Produk';
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
            
            // Show existing image if available
            if (product.image_url) {
                const previewContainer = document.getElementById('imagePreviewContainer');
                const previewImg = document.getElementById('imagePreview');
                previewImg.src = '../uploads/' + product.image_url;
                previewContainer.style.display = 'block';
            }
        }
        
        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreviewContainer').style.display = 'none';
        }
        
        // Image preview on file select
        const imageInput = document.getElementById('image');
        if (imageInput) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('imagePreview').src = e.target.result;
                        document.getElementById('imagePreviewContainer').style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
            
            // Drag and drop
            const uploadContainer = document.querySelector('.image-upload-container');
            uploadContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });
            
            uploadContainer.addEventListener('dragleave', function() {
                this.classList.remove('dragover');
            });
            
            uploadContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    imageInput.files = files;
                    const event = new Event('change', { bubbles: true });
                    imageInput.dispatchEvent(event);
                }
            });
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