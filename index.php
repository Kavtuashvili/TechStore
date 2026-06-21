<?php
session_start();
include("includes/db.php");
include("includes/navbar.php");

/* SEARCH + CATEGORY */
$search = "";
$cat = "";

/* BASE QUERY */
$sql = "SELECT * FROM products ORDER BY id DESC";

/* SEARCH */
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $search = $conn->real_escape_string($search);

    $sql = "SELECT * FROM products 
            WHERE name LIKE '%$search%' 
            ORDER BY id DESC";
}

/* CATEGORY FILTER */
if (isset($_GET['cat']) && !empty($_GET['cat'])) {
    $cat = intval($_GET['cat']);

    $sql = "SELECT * FROM products 
            WHERE category_id = $cat 
            ORDER BY id DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tech Store</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- HERO -->
<div class="hero">
    <h2>Welcome to Tech Store</h2>
    <p>Best gadgets, accessories and tech deals</p>
</div>

<!-- TITLE -->
<h1 class="title">Products</h1>

<!-- SEARCH -->
<form method="GET" class="search-form">
    <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Search</button>
</form>

<!-- CATEGORIES -->
<div class="cats">
    <a href="index.php">All</a>

    <?php
    $cats = $conn->query("SELECT * FROM categories");
    while ($c = $cats->fetch_assoc()):
    ?>
        <a href="?cat=<?php echo $c['id']; ?>">
            <?php echo htmlspecialchars($c['name']); ?>
        </a>
    <?php endwhile; ?>
</div>

<!-- PRODUCTS -->
<div class="products">

    <?php if ($result && $result->num_rows > 0): ?>

        <?php while ($row = $result->fetch_assoc()): ?>

            <div class="card">

                <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>">

                <h3><?php echo htmlspecialchars($row['name']); ?></h3>

                <p><?php echo htmlspecialchars($row['description']); ?></p>

                <p class="price">$<?php echo $row['price']; ?></p>

                <a href="product.php?id=<?php echo $row['id']; ?>" class="view-btn">
                    View Product →
                </a>

                <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
                    <div class="admin-links">
                        <a href="admin/edit-product.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="admin/delete-product.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this product?')">Delete</a>
                    </div>
                <?php endif; ?>

            </div>

        <?php endwhile; ?>

    <?php else: ?>
        <p style="text-align:center;">No products found.</p>
    <?php endif; ?>

</div>

<?php include("includes/footer.php"); ?>
</body>
</html>