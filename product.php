<?php
session_start();
include("includes/db.php");
include("includes/navbar.php");

/* 📌 GET PRODUCT ID */
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id <= 0){
    die("Product ID is missing");
}
/* 📌 GET PRODUCT */
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

/* ❌ NOT FOUND */
if(!$product){
    die("Product not found");
}

/* 🛒 ADD TO CART */
if(isset($_POST['add_to_cart'])){

    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit();
    }

    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }

    $pid = $product['id'];

    /* თუ უკვე არსებობს → რაოდენობა გაზარდე */
    if(isset($_SESSION['cart'][$pid])){
        $_SESSION['cart'][$pid]['qty'] += 1;
    } else {
        $_SESSION['cart'][$pid] = [
            "name" => $product['name'],
            "price" => $product['price'],
            "image" => $product['image'],
            "qty" => 1
        ];
    }

    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $product['name']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<div class="product-page">

    <div class="product-container">

        <!-- LEFT IMAGE -->
        <div class="product-left">
            <img src="uploads/<?php echo $product['image']; ?>">
        </div>

        <!-- RIGHT INFO -->
        <div class="product-right">

            <h1 class="product-title">
                <?php echo $product['name']; ?>
            </h1>

            <p class="product-desc">
                <?php echo $product['description']; ?>
            </p>

            <div class="product-meta">

                <div class="product-price">
                    $<?php echo $product['price']; ?>
                </div>

                <?php if($product['stock'] > 0): ?>
                    <div class="stock-badge in-stock">
                        ✅ In Stock (<?php echo $product['stock']; ?>)
                    </div>
                <?php else: ?>
                    <div class="stock-badge out-stock">
                        ❌ Out of Stock
                    </div>
                <?php endif; ?>

            </div>

            <form method="POST">

    <?php if(isset($_SESSION['user_id'])): ?>

        <button type="submit" name="add_to_cart" class="buy-btn">
            🛒 Add to Cart
        </button>

    <?php else: ?>

        <a href="login.php" class="buy-btn">
            🔐 Login to Buy
        </a>

    <?php endif; ?>

</form>

            <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
                <div class="admin-actions">
                    <a href="admin/edit-product.php?id=<?php echo $product['id']; ?>">Edit</a>
                    <a href="admin/delete-product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
                </div>
            <?php endif; ?>

            <a href="index.php" class="back-link">← Back to Products</a>

        </div>

    </div>

</div>
<?php include("includes/footer.php"); ?>
</body>
</html>