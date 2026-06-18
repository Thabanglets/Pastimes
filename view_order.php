<?php
include("dbCon.php");

if (!isset($_GET['id'])) {
    die("No Order Selected");
}

$order_id = intval($_GET['id']);

/*
|--------------------------------------------------------------------------
| ORDER DETAILS
|--------------------------------------------------------------------------
*/

$orderQuery = "
SELECT
    o.*,
    u.user_name,
    u.user_email
FROM tbl_orders o
INNER JOIN tbl_user u
ON o.user_id = u.user_id
WHERE o.order_id = $order_id
";

$orderResult = mysqli_query($conn, $orderQuery);

if(mysqli_num_rows($orderResult) == 0){
    die("Order Not Found");
}

$order = mysqli_fetch_assoc($orderResult);

/*
|--------------------------------------------------------------------------
| ORDER ITEMS
|--------------------------------------------------------------------------
*/

$itemQuery = "
SELECT *
FROM tbl_order_item
WHERE order_id = $order_id
";

$itemResult = mysqli_query($conn, $itemQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>View Order</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#f5f5f5;
    padding:30px;
}

.container{
    max-width:1100px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 15px rgba(0,0,0,.1);
}

h1{
    margin-bottom:25px;
    color:#333;
}

.info-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
    margin-bottom:30px;
}

.card{
    background:#f8f9fa;
    padding:15px;
    border-radius:8px;
    border-left:5px solid #007bff;
}

.card h3{
    color:#666;
    margin-bottom:8px;
}

.card p{
    font-size:18px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

table th{
    background:#343a40;
    color:white;
}

table th,
table td{
    border:1px solid #ddd;
    padding:12px;
    text-align:center;
}

table tr:nth-child(even){
    background:#f8f8f8;
}

.total{
    margin-top:20px;
    text-align:right;
    font-size:24px;
    font-weight:bold;
}

.actions{
    margin-top:30px;
}

.btn{
    display:inline-block;
    padding:10px 20px;
    text-decoration:none;
    border:none;
    border-radius:5px;
    cursor:pointer;
    color:white;
    margin-right:10px;
}

.back{
    background:#007bff;
}

.print{
    background:#28a745;
}

.back:hover{
    background:#0056b3;
}

.print:hover{
    background:#218838;
}

.status{
    padding:6px 12px;
    border-radius:20px;
    color:white;
}

.pending{
    background:orange;
}

.completed{
    background:green;
}

.cancelled{
    background:red;
}

@media print{
    .actions{
        display:none;
    }
}

</style>
</head>

<body>

<div class="container">

<h1>Order #<?php echo $order['order_id']; ?></h1>

<div class="info-grid">

    <div class="card">
        <h3>Customer Name</h3>
        <p><?php echo $order['user_name']; ?></p>
    </div>

    <div class="card">
        <h3>Email Address</h3>
        <p><?php echo $order['user_email']; ?></p>
    </div>

    <div class="card">
        <h3>Order Date</h3>
        <p><?php echo $order['order_date']; ?></p>
    </div>

    <div class="card">
        <h3>Status</h3>

        <span class="status <?php echo strtolower($order['order_status']); ?>">
            <?php echo ucfirst($order['order_status']); ?>
        </span>
    </div>

</div>

<h2>Products Ordered</h2>

<table>

<thead>
<tr>
    <th>Product Name</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Subtotal</th>
</tr>
</thead>

<tbody>

<?php

$grandTotal = 0;

while($item = mysqli_fetch_assoc($itemResult))
{
    $subtotal = $item['price'] * $item['quantity'];
    $grandTotal += $subtotal;
?>

<tr>
    <td><?php echo $item['item_name']; ?></td>
    <td>R <?php echo number_format($item['price'],2); ?></td>
    <td><?php echo $item['quantity']; ?></td>
    <td>R <?php echo number_format($subtotal,2); ?></td>
</tr>

<?php
}
?>

</tbody>

</table>

<div class="total">
    Total: R <?php echo number_format($grandTotal,2); ?>
</div>

<div class="actions">

    <a href="orders.php" class="btn back">
        Back To Orders
    </a>

    <button onclick="window.print()" class="btn print">
        Print Order
    </button>

</div>

</div>

</body>
</html>