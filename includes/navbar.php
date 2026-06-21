<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="navbar">

    <!-- LOGO -->
    <a href="/tech-store/index.php" class="logo">TechStore</a>

    <!-- LEFT LINKS -->
    <div class="nav-links">

        <a href="/tech-store/index.php">Home</a>
        <a href="/tech-store/contact.php">Contact</a>

    </div>

    <!-- RIGHT SIDE -->
    <div class="nav-right">

        <!-- CART -->
        <a href="/tech-store/cart.php" class="cart">
            🛒 Cart
            <?php if(isset($_SESSION['cart_count'])): ?>
                <span class="cart-count">
                    <?php echo $_SESSION['cart_count']; ?>
                </span>
            <?php endif; ?>
        </a>

        <!-- AUTH -->
        <?php if(!isset($_SESSION['user_id'])): ?>
            <a href="/tech-store/login.php">Login</a>
        <?php else: ?>

            <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
    <a href="/tech-store/admin/add-product.php">Add Product</a>
<?php endif; ?>
             <a href="/tech-store/my-orders.php">📦 My Orders</a>

            <a href="/tech-store/logout.php">Logout</a>

            <?php if($_SESSION['role'] == 'admin'): ?>
                <a href="/tech-store/admin/dashboard.php" class="admin-link">Admin</a>
            <?php endif; ?>

        <?php endif; ?>

    </div>

</div>