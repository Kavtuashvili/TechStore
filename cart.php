<?php
session_start();
include("includes/db.php");
include("includes/navbar.php");

/* ➖ REMOVE */
if(isset($_GET['remove'])){
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit();
}

/* ➕ INCREASE */
if(isset($_GET['inc'])){
    $id = $_GET['inc'];
    $_SESSION['cart'][$id]['qty']++;
    header("Location: cart.php");
    exit();
}

/* ➖ DECREASE */
if(isset($_GET['dec'])){
    $id = $_GET['dec'];

    if($_SESSION['cart'][$id]['qty'] > 1){
        $_SESSION['cart'][$id]['qty']--;
    } else {
        unset($_SESSION['cart'][$id]);
    }

    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>

    <!-- 🔥 CSS CONNECT -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<h1 class="title">Your Cart 🛒</h1>

<div class="cart-container">

<?php if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])): ?>

    <div class="empty-cart">
    <h2>🛒 Your cart is empty</h2>
    <p>Add some products and come back here.</p>
    <a href="index.php" class="shop-btn">
        Continue Shopping
    </a>
</div>

<?php else: ?>

    <?php $total = 0; ?>

    <div class="cart-items">

    <?php foreach($_SESSION['cart'] as $id => $item): ?>

        <?php $subtotal = $item['price'] * $item['qty']; ?>
        <?php $total += $subtotal; ?>

        <div class="cart-card">

            <img src="uploads/<?php echo $item['image']; ?>">

            <div class="cart-info">
                <h3><?php echo $item['name']; ?></h3>

                <p class="price">$<?php echo $item['price']; ?></p>

                <div class="qty">
                    <a href="?dec=<?php echo $id; ?>">➖</a>
                    <span><?php echo $item['qty']; ?></span>
                    <a href="?inc=<?php echo $id; ?>">➕</a>
                </div>

                <p class="subtotal">Subtotal: $<?php echo $subtotal; ?></p>
            </div>

            <a href="?remove=<?php echo $id; ?>" class="remove">Remove</a>

        </div>

    <?php endforeach; ?>

    </div>

    <div class="cart-total">
        <h2>Total: $<?php echo $total; ?></h2>
        <a href="checkout.php" class="checkout-btn">Checkout</a>
    </div>

<?php endif; ?>

</div>
<?php include("includes/footer.php"); ?>

</body>
</html>