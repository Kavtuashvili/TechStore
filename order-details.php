<?php
session_start();
include("includes/db.php");

/* 🔐 CHECK LOGIN */
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

/* 📌 ORDER ID */
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($order_id <= 0){
    die("Invalid order ID");
}

$user_id = $_SESSION['user_id'];

/* 📦 GET ORDER */
$stmt = $conn->prepare("
    SELECT * 
    FROM orders 
    WHERE id = ? AND user_id = ?
");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if(!$order){
    die("Order not found");
}

/* 📦 GET ITEMS */
$stmt = $conn->prepare("
    SELECT * 
    FROM order_items 
    WHERE order_id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <link rel="stylesheet" href="css/order-details.css">
</head>

<body>

<div class="container">

    <!-- ORDER INFO -->
    <div class="card">

        <h1>🧾 Order #<?php echo $order['id']; ?></h1>

        <div class="info">

            <p><b>Date:</b> <?php echo $order['created_at']; ?></p>

            <p><b>Status:</b>
                <?php if($order['status'] == 'pending'): ?>
                    <span class="badge pending">Pending</span>

                <?php elseif($order['status'] == 'shipped'): ?>
                    <span class="badge shipped">Shipped</span>

                <?php else: ?>
                    <span class="badge done">Completed</span>
                <?php endif; ?>
            </p>

            <p><b>Total:</b> $<?php echo $order['total']; ?></p>

        </div>

    </div>

    <!-- ITEMS -->
    <div class="card">

        <h2>📦 Products</h2>

        <div class="items">

            <?php while($item = $items->fetch_assoc()): ?>

                <div class="item">

                    <div class="left">
                        <b><?php echo $item['product_name']; ?></b>

                        <div class="meta">
                            $<?php echo $item['price']; ?> × <?php echo $item['qty']; ?>
                        </div>
                    </div>

                    <div class="right">
                        $<?php echo $item['price'] * $item['qty']; ?>
                    </div>

                </div>

            <?php endwhile; ?>

        </div>

        <a class="back" href="my-orders.php">← Back to Orders</a>

    </div>

</div>
<?php include("includes/footer.php"); ?>
</body>
</html>