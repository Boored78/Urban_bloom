<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["cartCount" => 0]);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $connection->prepare("SELECT COUNT(*) AS unique_products FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode(["cartCount" => $row['unique_products'] ?? 0]);
?>
