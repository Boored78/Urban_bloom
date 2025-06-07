<?php
session_start();
include 'db_connection.php'; // Ensure database connection

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = intval($_POST['product_id']);
    $newQuantity = intval($_POST['quantity']);
    $userId = intval($_SESSION['user_id']);

    if ($newQuantity < 1) {
        echo json_encode(['success' => false, 'message' => 'Quantity must be at least 1']);
        exit;
    }

    // Update the cart quantity
    $stmt = $connection->prepare("UPDATE cart SET quantity = ? WHERE product_id = ? AND user_id = ?");
    $stmt->bind_param("iii", $newQuantity, $productId, $userId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Get updated price for the product
        $stmt = $connection->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $newTotal = $row ? floatval($row['price']) * $newQuantity : 0;

        // Get updated subtotal for the entire cart
        $stmt = $connection->prepare("
            SELECT COALESCE(SUM(p.price * c.quantity), 0) AS subtotal 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $newSubtotal = $row ? floatval($row['subtotal']) : 0;

        // ✅ FIX: Send JSON only once
        echo json_encode([
            'success' => true,
            'newTotal' => $newTotal,
            'subtotal' => $newSubtotal
        ]);
    
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
