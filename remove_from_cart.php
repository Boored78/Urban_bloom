<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    if (!isset($_SESSION['user_id'])) {
        die(json_encode(["success" => false, "message" => "User not logged in"]));
    }

    $user_id = $_SESSION['user_id'];
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT);

    try {
        // Delete item from cart
        $stmt = $connection->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();

        // Fetch updated cart count
        $stmt = $connection->prepare("SELECT COUNT(*) AS unique_products FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $cart_result = $stmt->get_result();
        $cart_row = $cart_result->fetch_assoc();
        $cart_count = $cart_row['unique_products'] ?? 0;

        echo json_encode([
            "success" => true,
            "message" => "Item removed from cart",
            "cart_count" => $cart_count
        ]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
}
?>
