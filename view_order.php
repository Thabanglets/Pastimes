<?php
include("dbCon.php");

if (!isset($_GET['id'])) {
    die("No Order Selected");
}

$order_id = (int) $_GET['id'];

$orderQuery = "
    SELECT
        o.order_id,
        o.user_id,
        o.total_price,
        o.order_status,
        o.order_date,
        u.user_name,
        u.user_email
    FROM tbl_orders o
    INNER JOIN tbl_user u ON o.user_id = u.user_id
    WHERE o.order_id = $order_id
";

$orderResult = mysqli_query($link, $orderQuery);

if (!$orderResult || mysqli_num_rows($orderResult) === 0) {
    die("Order Not Found");
}

$order = mysqli_fetch_assoc($orderResult);

$itemQuery = "
    SELECT
        product_id,
        quantity,
        price,
        item_name
    FROM tbl_order_item
    WHERE order_id = $order_id
";

$itemResult = mysqli_query($link, $itemQuery);

$grandTotal = 0;
if ($itemResult) {
    while ($item = mysqli_fetch_assoc($itemResult)) {
        $grandTotal += (float) $item['price'] * (int) $item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>View Order</title>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    body {
        background: #f5f5f5;
        padding: 30px;
    }

    .container {
        max-width: 1100px;
        margin: auto;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    h1 {
        margin-bottom: 25px;
        color: #333;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .card {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 5px solid #007bff;
    }

    .card h3 {
        color: #666;
        margin-bottom: 8px;
    }

    .card p {
        font-size: 18px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th {
        background: #343a40;
        color: white;
    }

    table th,
    table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }

    table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .total {
        margin-top: 20px;
        text-align: right;
        font-size: 24px;
        font-weight: bold;
    }

    .actions {
        margin-top: 30px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        text-decoration: none;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        color: white;
        margin-right: 10px;
    }

    .back { background: #007bff; }
    .print { background: #28a745; }

    .back:hover { background: #0056b3; }
    .print:hover { background: #218838; }

    .status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        color: white;
        text-transform: capitalize;
    }

    .pending { background: orange; }
    .completed { background: green; }
    .cancelled { background: red; }
    .shipped { background: #0d6efd; }

    @media print {
        .actions {
            display: none;
        }
    }
</style>
</head>

<body>
    <div class="container">
        <h1>Order #<?php echo (int) $order['order_id']; ?></h1>

        <div class="info-grid">
            <div class="card">
                <h3>Customer Name</h3>
                <p><?php echo htmlspecialchars($order['user_name']); ?></p>
            </div>

            <div class="card">
                <h3>Email Address</h3>
                <p><?php echo htmlspecialchars($order['user_email']); ?></p>
            </div>

            <div class="card">
                <h3>Order Date</h3>
                <p><?php echo htmlspecialchars($order['order_date']); ?></p>
            </div>

            <div class="card">
                <h3>Status</h3>
                <span class="status <?php echo strtolower(htmlspecialchars($order['order_status'])); ?>">
                    <?php echo htmlspecialchars(ucfirst($order['order_status'])); ?>
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
                $itemResult = mysqli_query($link, $itemQuery);
                if ($itemResult && mysqli_num_rows($itemResult) > 0) {
                    while ($item = mysqli_fetch_assoc($itemResult)) {
                        $subtotal = (float) $item['price'] * (int) $item['quantity'];
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                        <td>R <?php echo number_format((float) $item['price'], 2); ?></td>
                        <td><?php echo (int) $item['quantity']; ?></td>
                        <td>R <?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                <?php
                    }
                } else {
                ?>
                    <tr>
                        <td colspan="4">No items found for this order.</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <div class="total">
            Total: R <?php echo number_format($grandTotal, 2); ?>
        </div>

        <div class="actions">
            <a href="orders.php" class="btn back">Back To Orders</a>
            <button onclick="window.print()" class="btn print">Print Order</button>
        </div>
    </div>
</body>
</html>