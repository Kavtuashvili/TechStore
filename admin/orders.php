<?php
session_start();
include("../includes/db.php");
include("layout.php");

/* 🔐 ADMIN CHECK */
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    die("Access denied");
}

$sql = "
SELECT orders.*, users.username, users.email
FROM orders
LEFT JOIN users ON orders.user_id = users.id
ORDER BY orders.created_at DESC
";

$result = $conn->query($sql);
?>

<h1 class="dash-title">🧾 Orders</h1>

<div class="table-box">

<table>

<tr>
    <th>ID</th>
    <th>User</th>
    <th>Email</th>
    <th>Total</th>
    <th>Status</th>
    <th>Date</th>
</tr>

<?php while($order = $result->fetch_assoc()): ?>

<tr>

<td>#<?php echo $order['id']; ?></td>
<td><?php echo $order['username']; ?></td>
<td><?php echo $order['email']; ?></td>
<td>$<?php echo $order['total']; ?></td>

<td>
    <form method="POST" action="update-status.php">

        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">

        <select name="status" onchange="this.form.submit()" class="status-select">

            <option value="pending" <?php if($order['status']=='pending') echo 'selected'; ?>>
                Pending
            </option>

            <option value="shipped" <?php if($order['status']=='shipped') echo 'selected'; ?>>
                Shipped
            </option>

            <option value="done" <?php if($order['status']=='done') echo 'selected'; ?>>
                Done
            </option>

        </select>

    </form>
</td>

<td><?php echo $order['created_at']; ?></td>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>