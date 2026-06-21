<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    die("Access denied");
}

include("../includes/db.php");
include("../admin/layout.php"); 

$message = "";
$messageClass = "";

if(isset($_POST['submit'])){

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];

    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];

    $uploadPath = "../uploads/" . $imageName;

    if(move_uploaded_file($imageTmp, $uploadPath)){

        $sql = "INSERT INTO products (name, description, price, image)
                VALUES ('$name', '$description', '$price', '$imageName')";

        if($conn->query($sql)){
            $message = "Product added successfully!";
            $messageClass = "success-message";
        } else {
            $message = "Database error!";
            $messageClass = "error-message";
        }

    } else {
        $message = "Image upload failed!";
        $messageClass = "error-message";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="admin-page">

<div class="admin-container">

    <div class="admin-card">
   <div class="admin-header">
            <h2 class="admin-title">📦 Add New Product</h2>
            <span class="admin-badge">Admin Panel</span>
        </div>

        <p class="admin-desc">
            Add products to your store catalog
        </p>


        <?php if(!empty($message)): ?>
            <div class="<?php echo $messageClass; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

 

<form method="POST" enctype="multipart/form-data" class="product-form">

    <input type="text"
           name="name"
           placeholder="Product Name"
           required>

    <textarea
        name="description"
        placeholder="Product Description"
        rows="5"></textarea>

    <input type="number"
           step="0.01"
           name="price"
           placeholder="Product Price"
           required>

    <div class="upload-box">
        <label>📷 Product Image</label>
        <input type="file" name="image" required>
    </div>

    <button type="submit" name="submit">
        ➕ Add Product
    </button>

</form>
    </div>

</div>

</body>
</html>