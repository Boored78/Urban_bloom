<?php
session_start();
require '../db_connection.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../login.php");
    exit();
}

// Check if order ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: orders.php");
    exit();
}

$order_id = intval($_GET['id']);

// Fetch order details
$order_query = $connection->prepare("SELECT * FROM orders WHERE id = ?");
$order_query->bind_param("i", $order_id);
$order_query->execute();
$order_result = $order_query->get_result();

if ($order_result->num_rows === 0) {
    header("Location: orders.php");
    exit();
}

$order = $order_result->fetch_assoc();

// Decode cart items
$cart_items = json_decode($order['cart_items'], true);

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="../css/my_bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'admin_navbar.php'; ?>
    
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Order #<?= $order['id'] ?></h1>
            <a href="orders.php" class="btn btn-secondary">Back to Orders</a>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> <?= htmlspecialchars($order['first_name']) ?> <?= htmlspecialchars($order['last_name']) ?></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars($order['address']) ?></p>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                        <p><strong>Payment Method:</strong> <?= ucfirst($order['payment_method']) ?></p>
                        <?php if ($order['payment_method'] === 'card'): ?>
                        <p><strong>Card Number:</strong> **** **** **** <?= substr($order['card_number'], -4) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Order Date:</strong> <?= date('M j, Y g:i a', strtotime($order['created_at'])) ?></p>
                        <p><strong>Status:</strong> Completed</p>
                        <p><strong>Total Items:</strong> 
                            <?php 
                            $total_items = 0;
                            foreach ($cart_items as $item) {
                                $total_items += $item['quantity'];
                            }
                            echo $total_items;
                            ?>
                        </p>
                        <p><strong>Total Amount:</strong> $<?= number_format($total, 2) ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5>Ordered Products</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="table-active">
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td><strong>$<?= number_format($total, 2) ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>