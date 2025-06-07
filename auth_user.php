<?php
require_once 'db_connection.php';

$profileImage = 'img/default.jpg';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $connection->prepare("SELECT profile_picture FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!empty($user['profile_picture']) && file_exists($user['profile_picture'])) {
        $profileImage = $user['profile_picture'];
    }
}
?>
