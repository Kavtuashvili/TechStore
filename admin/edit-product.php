<?php
session_start();
include("../includes/db.php");

/* 🔐 ADMIN CHECK */
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    die("Access denied");
}

/* 📌 GET ID */
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

/* 📌 GET PRODUCT */
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if(!$product){
    die("Product not found");
}

/* 📌 UPDATE */
$message = "";

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    /* 📌 IMAGE CHECK */
    if(!empty($_FILES['image']['name'])){

        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];

        move_uploaded_file($imageTmp, "../uploads/" . $imageName);

    } else {
        $imageName = $product['image'];
    }

    $stmt = $conn->prepare("
        UPDATE products
        SET name=?, description=?, price=?, stock=?, image=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "ssdisi",
        $name,
        $description,
        $price,
        $stock,
        $imageName,
        $id
    );

    if($stmt->execute()){

        $message = "Product updated successfully!";

        /* refresh product data */
        $stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

    } else {
        $message = "Update failed!";
    }
}

include("layout.php");
?>

<h1 class="dash-title">✏️ Edit Product</h1>

<?php if($message): ?>
    <div class="success-message">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<div class="form-box">

<form method="POST" enctype="multipart/form-data">

    <label>Name</label>
    <input
        type="text"
        name="name"
        value="<?php echo htmlspecialchars($product['name']); ?>"
        required
    >

    <label>Description</label>
    <textarea name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>

    <label>Price</label>
    <input
        type="number"
        step="0.01"
        name="price"
        value="<?php echo $product['price']; ?>"
        required
    >

    <label>Stock</label>
    <input
        type="number"
        name="stock"
        value="<?php echo $product['stock']; ?>"
        required
    >

    <label>Current Image</label>
    <br>

    <img
        src="../uploads/<?php echo htmlspecialchars($product['image']); ?>"
        class="edit-img"
        alt="Product Image"
    >

    <label>Change Image</label>
    <input type="file" name="image">

    <button type="submit" name="update">
        Update Product
    </button>

</form>

</div>

</div>