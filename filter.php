<?php
require 'db_connection.php';

// Get filter values from user input (default to empty)
$sex = isset($_GET['sex']) ? $_GET['sex'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';

// ✅ Start building SQL query dynamically
$sql = "SELECT * FROM products WHERE 1=1";  // Always true condition

if (!empty($sex)) {
    $sql .= " AND sex = '" . $connection->real_escape_string($sex) . "'";
}

if (!empty($type)) {
    $sql .= " AND type = '" . $connection->real_escape_string($type) . "'";
}

// ✅ Execute query
$result = $connection->query($sql);
?>