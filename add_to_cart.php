<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        die(json_encode(["success" => false, "message" => "User not logged in"]));
    }

    $user_id = $_SESSION['user_id'];
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT);
    $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;

    if ($quantity < 1) {
        $quantity = 1; // Ensure valid quantity
    }

    try {
        // ✅ Check if product already exists in cart
        $stmt = $connection->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $productExists = $result->num_rows > 0; // Check if product already exists

        if ($productExists) {
            // ✅ If product exists, update quantity (DO NOT change cart count)
            $stmt = $connection->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("iii", $quantity, $user_id, $product_id);
            $stmt->execute();
        } else {
            // ✅ If product does NOT exist, insert new row and return new count
            $stmt = $connection->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $user_id, $product_id, $quantity);
            $stmt->execute();

            // ✅ Fetch updated cart count (Only count unique products)
            $stmt = $connection->prepare("SELECT COUNT(*) AS unique_products FROM cart WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $cart_result = $stmt->get_result();
            $cart_row = $cart_result->fetch_assoc();
            $cart_count = $cart_row['unique_products'] ?? 0; // Unique product count
        }

        echo json_encode([
            "success" => true,
            "message" => "Product added to cart",
            "newProduct" => !$productExists, // ✅ Return whether a new product was added
            "cart_count" => $cart_count ?? null // ✅ Only return cart count when new product is added
        ]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
}
?>
