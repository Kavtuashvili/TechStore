<?php
session_start();
include("includes/db.php");
include("includes/navbar.php");

/* 🔐 CHECK LOGIN */
if(!isset($_SESSION['user_id'])){
    die("Please login first");
}

$user_id = $_SESSION['user_id'];

/* 📌 GET USER ORDERS */
$stmt = $conn->prepare("
    SELECT *
    FROM orders
    WHERE user_id = ?
    ORDER BY created_at DESC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="orders-page">

    <h1 class="orders-title">📦 My Orders</h1>

    <?php if($result->num_rows == 0): ?>

        <div class="empty-orders">
            <h2>No Orders Yet</h2>
            <p>You haven't placed any orders yet.</p>

            <a href="index.php" class="shop-btn">
                Start Shopping
            </a>
        </div>

    <?php else: ?>

        <div class="orders-grid">

            <?php while($order = $result->fetch_assoc()): ?>

                <div class="order-card modern">

                    <div class="order-header">
                        <div>
                            <h3>Order #<?php echo $order['id']; ?></h3>
                            <p class="order-date"><?php echo $order['created_at']; ?></p>
                        </div>

                        <?php if($order['status'] == 'pending'): ?>
                            <span class="status pending">Pending</span>

                        <?php elseif($order['status'] == 'shipped'): ?>
                            <span class="status shipped">Shipped</span>

                        <?php else: ?>
                            <span class="status done">Completed</span>
                        <?php endif; ?>

                    </div>

                    <div class="order-body">
                        <div class="order-total">
                            Total: <span>$<?php echo $order['total']; ?></span>
                        </div>

                         <a href="order-details.php?id=<?php echo $order['id']; ?>" class="view-btnn">
        View Details 
    </a>
                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    <?php endif; ?>

</div>
<?php include("includes/footer.php"); ?>
</body>
</html>