<?php
require_once 'auth_check.php';

// Pastikan koneksi database tersedia (asumsi variabel $conn berasal dari auth_check atau config)
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
        $image_path = "../uploads/" . $product['image_url'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    
    // Delete product from database
    $delete_sql = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        $success_message = "Produk berhasil dihapus!";
    } else {
        $error_message = "Gagal menghapus produk.";
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
    
    $upload_ok = true;

    // Handle image upload logic
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_size = $_FILES['image']['size'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (!in_array($file_extension, $allowed_extensions)) {
            $error_message = "Format file tidak valid. Gunakan: JPG, PNG, GIF, WEBP";
            $upload_ok = false;
        } elseif ($file_size > 5 * 1024 * 1024) { 
            $error_message = "Ukuran file terlalu besar. Maksimal 5MB.";
            $upload_ok = false;
        } else {
            $new_filename = 'product_' . time() . '_' . uniqid() . '.' . $file_extension;
            $upload_dir = '../uploads/';
            
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            if (move_uploaded_file($file_tmp, $upload_dir . $new_filename)) {
                $image_url = $new_filename;
                
                // Hapus gambar lama jika sedang edit
                if ($id > 0) {
                    $old_img_query = "SELECT image_url FROM products WHERE id = ?";
                    $stmt = mysqli_prepare($conn, $old_img_query);
                    mysqli_stmt_bind_param($stmt, "i", $id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $old_product = mysqli_fetch_assoc($result);
                    mysqli_stmt_close($stmt);
                    
                    if ($old_product && $old_product['image_url']) {
                        if (file_exists($upload_dir . $old_product['image_url'])) {
                            unlink($upload_dir . $old_product['image_url']);
                        }
                    }
                }
            } else {
                $error_message = "Gagal mengunggah gambar.";
                $upload_ok = false;
            }
        }
    } else if ($id > 0) {
        // Jika edit dan tidak upload gambar baru, ambil gambar lama
        $old_img_query = "SELECT image_url FROM products WHERE id = ?";
        $stmt = mysqli_prepare($conn, $old_img_query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $old_product = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        $image_url = $old_product['image_url'] ?? '';
    }

    // Save to database
    if ($upload_ok && !$error_message) {
        if ($id > 0) {
            $sql = "UPDATE products SET name=?, origin=?, roast_level=?, flavor_notes=?, description=?, price=?, stock_quantity=?, is_featured=?, is_organic=?, image_url=? WHERE id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssssdiiisi", $name, $origin, $roast_level, $flavor_notes, $description, $price, $stock_quantity, $is_featured, $is_organic, $image_url, $id);
        } else {
            $sql = "INSERT INTO products (name, origin, roast_level, flavor_notes, description, price, stock_quantity, is_featured, is_organic, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssssdiiis", $name, $origin, $roast_level, $flavor_notes, $description, $price, $stock_quantity, $is_featured, $is_organic, $image_url);
        }
        
        if (mysqli_stmt_execute($stmt)) {
            $success_message = $id > 0 ? "Produk berhasil diperbarui!" : "Produk berhasil ditambahkan!";
        } else {
            $error_message = "Kesalahan database: Gagal menyimpan data.";
        }
        mysqli_stmt_close($stmt);
    }
}

// Get all products
$products_query = "SELECT * FROM products ORDER BY created_at DESC";
$products_result = mysqli_query($conn, $products_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="admin-body">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="admin-content">
        <?php include 'includes/topbar.php'; ?>
        
        <div class="admin-main">
            <div class="page-header">
                <div>
                    <h1>Manajemen Produk</h1>
                    <p>Kelola katalog produk Anda di sini.</p>
                </div>
                <button class="btn btn-primary" onclick="openModal()">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                    Tambah Produk Baru
                </button>
            </div>
            
            <?php if ($success_message): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="alert alert-error"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <div class="dashboard-card">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Asal</th>
                                <th>Roast</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($products_result) > 0): ?>
                                <?php while ($product = mysqli_fetch_assoc($products_result)): ?>
                                    <tr>
                                        <td>
                                            <?php if ($product['image_url']): ?>
                                                <img src="../uploads/<?php echo htmlspecialchars($product['image_url']); ?>" class="table-product-image">
                                            <?php else: ?>
                                                <div class="no-image-placeholder">No Image</div>
                                            <?php endif; ?>
                                        </td>
                                        <td><strong><?php echo htmlspecialchars($product['name']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($product['origin']); ?></td>
                                        <td><span class="badge badge-<?php echo $product['roast_level']; ?>"><?php echo ucfirst($product['roast_level']); ?></span></td>
                                        <td>Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></td>
                                        <td><?php echo $product['stock_quantity']; ?></td>
                                        <td>
                                            <?php echo $product['is_featured'] ? '<span class="badge badge-success">Featured</span>' : ''; ?>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button onclick='editProduct(<?php echo json_encode($product); ?>)' class="btn-icon btn-edit">
                                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                                                </button>
                                                <a href="?delete=<?php echo $product['id']; ?>" class="btn-icon btn-delete" onclick="return confirm('Hapus produk ini?')">
                                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="8" class="text-center">Belum ada produk.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div id="productModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah Produk Baru</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" id="product_id" name="id">
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Produk *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Asal *</label>
                        <input type="text" id="origin" name="origin" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Roast Level *</label>
                        <select id="roast_level" name="roast_level" required>
                            <option value="light">Light</option>
                            <option value="medium">Medium</option>
                            <option value="dark">Dark</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Flavor Notes *</label>
                        <input type="text" id="flavor_notes" name="flavor_notes" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Deskripsi *</label>
                    <textarea id="description" name="description" rows="3" required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Harga (Rp) *</label>
                        <input type="number" id="price" name="price" required>
                    </div>
                    <div class="form-group">
                        <label>Stok *</label>
                        <input type="number" id="stock_quantity" name="stock_quantity" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Gambar Produk</label>
                    <label for="image" class="image-upload-container" id="dropZone">
                        <input type="file" id="image" name="image" accept="image/*" class="image-input" style="display:none">
                        <div class="image-upload-label">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            <span>Klik untuk upload gambar</span>
                            <p>PNG, JPG, WEBP (Maks 5MB)</p>
                        </div>
                    </label>
                    
                    <div id="imagePreviewContainer" class="image-preview-container" style="display: none; margin-top: 10px;">
                        <img id="imagePreview" src="" class="image-preview-img">
                        <button type="button" class="btn-remove-image" onclick="removeImage()">Hapus Gambar</button>
                    </div>
                </div>
                
                <div class="form-row">
                    <label class="checkbox-label">
                        <input type="checkbox" id="is_featured" name="is_featured"> Featured
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" id="is_organic" name="is_organic"> Organic
                    </label>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('productModal');
        const imageInput = document.getElementById('image');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImg = document.getElementById('imagePreview');

        function openModal() {
            modal.style.display = 'flex';
            document.getElementById('modalTitle').textContent = 'Tambah Produk Baru';
            document.querySelector('#productModal form').reset();
            document.getElementById('product_id').value = '';
            removeImage();
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        function editProduct(product) {
            modal.style.display = 'flex';
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
            
            if (product.image_url) {
                previewImg.src = '../uploads/' + product.image_url;
                previewContainer.style.display = 'block';
            } else {
                removeImage();
            }
        }

        function removeImage() {
            imageInput.value = '';
            previewContainer.style.display = 'none';
            previewImg.src = '';
        }

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        window.onclick = function(event) {
            if (event.target == modal) closeModal();
        }
    </script>
</body>
</html>