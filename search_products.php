<?php
require 'db_connection.php'; 

// Fetch search query
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';
$results = [];

if (!empty($searchQuery)) {
    // Prepare and execute the search query
    $stmt = $connection->prepare("SELECT id, name, image, price FROM products WHERE name LIKE ?");
    $likeQuery = "%" . $searchQuery . "%";
    $stmt->bind_param("s",$likeQuery);
    $stmt->execute();
    $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// Return results as JSON
header('Content-Type: application/json');
echo json_encode($results);
?>
