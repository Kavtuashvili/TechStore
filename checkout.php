<?php
session_start();
include("includes/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

/* 🛒 CHECK CART */
if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
    die("Cart is empty");
}

$user_id = $_SESSION['user_id'];
$total = 0;

/* 💰 CALCULATE TOTAL */
foreach($_SESSION['cart'] as $item){
    $total += $item['price'] * $item['qty'];
}

/* 📦 CREATE ORDER */
$stmt = $conn->prepare("
    INSERT INTO orders (user_id, total)
    VALUES (?, ?)
");

$stmt->bind_param("id", $user_id, $total);
$stmt->execute();

$order_id = $stmt->insert_id;

/* 📋 SAVE ORDER ITEMS */
foreach($_SESSION['cart'] as $item){

    $stmt = $conn->prepare("
        INSERT INTO order_items
        (order_id, product_name, price, qty)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "isdi",
        $order_id,
        $item['name'],
        $item['price'],
        $item['qty']
    );

    $stmt->execute();
}

/* 🧹 CLEAR CART */
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <title>Order Success</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="success-box">

    <h1>✅ Order Placed Successfully!</h1>

    <p>
        Thank you for shopping with us.
    </p>

    <p>
        Your Order ID:
        <strong>#<?php echo $order_id; ?></strong>
    </p>

    <div class="success-actions">

        <a href="index.php" class="shop-btn">
            Continue Shopping
        </a>

        <a href="my-orders.php" class="orders-btn">
            My Orders
        </a>

    </div>

</div>
<?php include("includes/footer.php"); ?>
</body>
</html>