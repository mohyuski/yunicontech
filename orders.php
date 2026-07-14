<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

require "db_connect.php";

$result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Customer Orders | Yunicon Tech Admin</title>
<style>
    body{font-family:Arial, sans-serif;background:#0f172a;color:#fff;padding:20px;}
    h1{display:inline-block;}
    a.logout{float:right;color:#ff6666;text-decoration:none;font-weight:bold;padding:10px;}
    table{width:100%;border-collapse:collapse;margin-top:20px;background:#1e293b;}
    th,td{padding:10px;border:1px solid #334155;text-align:left;font-size:14px;}
    th{background:#0d1b2a;color:#00bfff;}
    tr:hover{background:#243448;}
    .empty{text-align:center;padding:40px;color:#888;}
</style>
</head>
<body>

<h1>📦 Customer Orders</h1>
<a class="logout" href="admin_logout.php">Logout</a>

<?php if ($result->num_rows > 0): ?>
<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Address</th>
    <th>Product</th>
    <th>Price</th>
    <th>Payment</th>
    <th>Date</th>
</tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['phone']) ?></td>
    <td><?= htmlspecialchars($row['address']) ?></td>
    <td><?= htmlspecialchars($row['product_name']) ?></td>
    <td><?= htmlspecialchars($row['product_price']) ?></td>
    <td><?= htmlspecialchars($row['payment_method']) ?></td>
    <td><?= $row['order_date'] ?></td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
    <p class="empty">No orders yet.</p>
<?php endif; ?>

</body>
</html>
