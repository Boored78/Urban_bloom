<?php
session_start();

if (!isset($_SESSION['email'])) {
    die("Error: No email found in session.");
}

$userEmail = $_SESSION['email'];
echo "User email is: " . $userEmail;
?>