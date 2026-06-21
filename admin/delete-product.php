<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    die("Access denied");
}

$id = intval($_GET['id']);

$sql = "DELETE FROM products WHERE id=$id";
$conn->query($sql);

header("Location: ../index.php");
exit();
?>