<?php
session_start();
include("../includes/db.php");

/* 🔐 ADMIN CHECK */
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    die("Access denied");
}

/* 📊 STATS */
$totalProducts = $conn->query("
    SELECT COUNT(*) as total
    FROM products
")->fetch_assoc()['total'];

$totalOrders = $conn->query("
    SELECT COUNT(*) as total
    FROM orders
")->fetch_assoc()['total'];

$totalUsers = $conn->query("
    SELECT COUNT(*) as total
    FROM users
")->fetch_assoc()['total'];

$totalRevenue = $conn->query("
    SELECT SUM(total) as revenue
    FROM orders
")->fetch_assoc()['revenue'];

if(!$totalRevenue){
    $totalRevenue = 0;
}

$lowStock = $conn->query("
    SELECT COUNT(*) as total
    FROM products
    WHERE stock <= 5
")->fetch_assoc()['total'];

$recentOrders = $conn->query("
    SELECT id,total,status,created_at
    FROM orders
    ORDER BY id DESC
    LIMIT 5
");

include("layout.php");
?>

<h1 class="dash-title">📊 Dashboard</h1>

<div class="stats-grid">

    <div class="stat-card">
        <h3>📦 Products</h3>
        <p><?php echo $totalProducts; ?></p>
    </div>

    <div class="stat-card">
        <h3>🧾 Orders</h3>
        <p><?php echo $totalOrders; ?></p>
    </div>

    <div class="stat-card">
        <h3>👤 Users</h3>
        <p><?php echo $totalUsers; ?></p>
    </div>

    <div class="stat-card">
        <h3>💰 Revenue</h3>
        <p>$<?php echo number_format($totalRevenue, 2); ?></p>
    </div>

    <div class="stat-card warning-card">
        <h3>⚠️ Low Stock</h3>
        <p><?php echo $lowStock; ?></p>
    </div>

</div>

<div class="action-box">

    <a href="add-product.php" class="btn-primary">
        ➕ Add Product
    </a>

    <a href="orders.php" class="btn-secondary">
        📄 View Orders
    </a>

</div>

<div class="recent-orders">

    <h2>🧾 Recent Orders</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
        </tr>

        <?php while($order = $recentOrders->fetch_assoc()): ?>

        <tr>

            <td>#<?php echo $order['id']; ?></td>

            <td>
                $<?php echo $order['total']; ?>
            </td>

            <td>
                <?php echo ucfirst($order['status']); ?>
            </td>

            <td>
                <?php echo $order['created_at']; ?>
            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

</div> <!-- close layout -->