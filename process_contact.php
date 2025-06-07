<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Basic validation
    if (empty($email) || empty($message)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: contact.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format!";
        header("Location: contact.php");
        exit();
    }

    // Insert into database
    $stmt = $connection->prepare("INSERT INTO messages (email, message) VALUES (?, ?)");
    $stmt->bind_param("ss",$email, $message);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Message sent successfully!";
    } else {
        $_SESSION['error'] = "Error sending message.";
    }

    $stmt->close();
    $connection->close();

    header("Location: contact.php"); // Redirect back to the form
    exit();
}
?>
