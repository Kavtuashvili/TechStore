<?php
session_start();
include("../includes/db.php");
include("layout.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    die("Access denied");
}

/* DELETE PRODUCT */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: products.php");
    exit();
}

/* SEARCH */
$search = "";
if(isset($_GET['search'])){
    $search = $_GET['search'];
    $sql = "SELECT * FROM products WHERE name LIKE '%$search%' ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM products ORDER BY id DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="admin-page">


<div class="admin-container">

    <h1 class="dash-title">Products</h1>

    <!-- SEARCH -->
    <form class="search-box" method="GET">
    <input type="text" name="search" placeholder="Search products..." value="<?php echo $search; ?>">
    <button type="submit">Search</button>
</form>


    <!-- TABLE -->
    <div class="table-box">

        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>

            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><img src="../uploads/<?php echo $row['image']; ?>" width="60"></td>
                <td><?php echo $row['name']; ?></td>
                <td>$<?php echo $row['price']; ?></td>
             <td class="actions-cell">

    <div class="actions-wrap">

        <a class="btn-edit" href="edit-product.php?id=<?php echo $row['id']; ?>">
            Edit
        </a>

        <a class="btn-delete"
           href="delete-product.php?id=<?php echo $row['id']; ?>"
           onclick="return confirm('Delete this product?')">
            Delete
        </a>

    </div>

</td>
            </tr>
            <?php endwhile; ?>

        </table>

    </div>

</div>

</body>
</html>