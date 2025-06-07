<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database credentials
$host = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "mydatabase"; 
$port = 3307;  // Specify the port number

// Create MySQLi connection with the specified port
$connection = new mysqli($host, $username, $password, $database, $port);

// ✅ Check for connection errors
if ($connection->connect_error) {
    die("Database connection failed: " . $connection->connect_error);
}
?>
