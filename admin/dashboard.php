<?php
require_once 'auth_check.php';

// Mengambil Statistik
$stats = [];

// Total produk
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM products");
$stats['total_products'] = mysqli_fetch_assoc($result)['count'];

// Total pesanan
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM orders");
$stats['total_orders'] = mysqli_fetch_assoc($result)['count'];

// Pesanan perlu diproses (pending)
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM orders WHERE status = 'pending'");
$stats['pending_orders'] = mysqli_fetch_assoc($result)['count'];

// Produk stok menipis
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM products WHERE stock_quantity < 20");
$stats['low_stock'] = mysqli_fetch_assoc($result)['count'];

// Pesanan Terbaru
$recent_orders = mysqli_query($conn, "
    SELECT o.*, c.first_name, c.last_name, c.email 
    FROM orders o 
    LEFT JOIN customers c ON o.customer_id = c.id 
    ORDER BY o.created_at DESC 
    LIMIT 8
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Robusta Dampit</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Penyesuaian responsif tambahan untuk Dashboard */
        .dashboard-full {
            grid-template-columns: 1fr;
            width: 100%;
        }
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="admin-body">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="admin-content">
        <?php include 'includes/topbar.php'; ?>
        
        <div class="admin-main">
            <div class="page-header">
                <div>
                    <h1>Dashboard</h1>
                    <p>Selamat datang kembali, <?php echo htmlspecialchars($_SESSION['admin_name']); ?>!</p>
                </div>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #6B4423 0%, #8B5A3C 100%);">
                        <svg width="24" height="24" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a2 2 0 012-2h8a2 2 0 012 2v9a2 2 0 01-2 2H6a2 2 0 01-2-2V7z" />
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $stats['total_products']; ?></h3>
                        <p>Total Produk</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4E342E 0%, #6B4423 100%);">
                        <svg width="24" height="24" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z" />
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $stats['total_orders']; ?></h3>
                        <p>Total Pesanan</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #D4A574 0%, #8B5A3C 100%);">
                        <svg width="24" height="24" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $stats['pending_orders']; ?></h3>
                        <p>Menunggu Proses</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #dc3545 0%, #a71d2a 100%);">
                        <svg width="24" height="24" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm4 4a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $stats['low_stock']; ?></h3>
                        <p>Stok Menipis</p>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-grid dashboard-full">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2>Pesanan Terbaru</h2>
                        <a href="orders.php" class="view-all">Lihat Semua Pesanan</a>
                    </div>
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>No. Pesanan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($recent_orders) > 0): ?>
                                    <?php while ($order = mysqli_fetch_assoc($recent_orders)): ?>
                                        <tr>
                                            <td><strong>#<?php echo htmlspecialchars($order['order_number']); ?></strong></td>
                                            <td><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                                            <td>Rp <?php echo number_format($order['total_amount'], 0, ',', '.'); ?></td>
                                            <td>
                                                <span class="status-badge status-<?php echo $order['status']; ?>">
                                                    <?php 
                                                        $status_indo = [
                                                            'pending' => 'Menunggu',
                                                            'processing' => 'Diproses',
                                                            'shipped' => 'Dikirim',
                                                            'delivered' => 'Selesai',
                                                            'cancelled' => 'Dibatalkan'
                                                        ];
                                                        echo $status_indo[$order['status']] ?? $order['status']; 
                                                    ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('d M Y', strtotime($order['created_at'])); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada pesanan masuk.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../js/script.js"></script>
    <script src="js/admin.js"></script>
</body>
</html>