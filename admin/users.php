<?php
session_start();
include("../includes/db.php");
include("layout.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    die("Access denied");
}

$result = $conn->query("SELECT id, username, email, role FROM users ORDER BY id DESC");
?>

<h1 class="dash-title">👤 Users</h1>

<div class="table-box">

<table>

<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Email</th>
    <th>Role</th>
</tr>

<?php while($user = $result->fetch_assoc()): ?>
<tr>

<td>#<?php echo $user['id']; ?></td>
<td><?php echo $user['username']; ?></td>
<td><?php echo $user['email']; ?></td>

<td>
<?php if($user['role'] == 'admin'): ?>
    <span class="badge-admin">Admin</span>
<?php else: ?>
    <span class="badge-user">User</span>
<?php endif; ?>
</td>

</tr>
<?php endwhile; ?>

</table>

</div>

</div>