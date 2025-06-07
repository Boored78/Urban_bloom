<?php
session_start();
require 'db_connection.php';

$limit = 6;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

$sql = "SELECT id, name, image, price FROM products LIMIT $limit OFFSET $offset";
$result = $connection->query($sql);

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products); // Return products as JSON
?>
