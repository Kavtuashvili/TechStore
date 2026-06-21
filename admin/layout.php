<?php
if(!isset($_SESSION)) session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    die("Access denied");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>

    <link rel="stylesheet" href="/tech-store/css/style.css">
</head>

<body>
  <div class="mobile-header">
            <button class="hamburger" onclick="toggleMenu()">☰</button>
            <h2 class="mobile-logo">TechStore</h2>
        </div>
<div class="admin-wrapper">
     

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">

        <!-- MOBILE HEADER -->
      

        <h2 class="logo">TechStore</h2>

        <a href="dashboard.php">📊 Dashboard</a>
        <a href="users.php">👤 Users</a>
        <a href="products.php">📦 Products</a>
        <a href="add-product.php">➕ Add Product</a>
        <a href="orders.php">🧾 Orders</a>

        <div class="sidebar-bottom">
            <a href="../index.php">🏪 View Store</a>
            <a href="../logout.php">🚪 Logout</a>
        </div>

    </div>
    <script src="../js/admin.js"></script>
    <!-- MAIN CONTENT START -->
    <div class="main-content">


  