<?php
require 'db_connection.php'; // Ensure this file correctly defines $pdo

// Test values
$user_id = 2; // Replace with an existing user ID
$product_id = 2; // Replace with an existing product ID
$quantity = 3; // Sample quantity

try {
    // ✅ Insert test data into the cart using PDO
    $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
    $stmt->execute([
        'user_id' => $user_id,
        'product_id' => $product_id,
        'quantity' => $quantity
    ]);

    echo "✅ Test data inserted successfully!";
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage();
}
?>
