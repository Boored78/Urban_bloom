<?php
$profileImage = 'img/default_profile.png'; 
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $userQuery = "SELECT profile_picture FROM users WHERE id = ?";
    $stmt = $connection->prepare($userQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $userResult = $stmt->get_result();
    if ($userRow = $userResult->fetch_assoc()) {
        if (!empty($userRow['profile_picture'])) {
            $profileImage = htmlspecialchars($userRow['profile_picture']);
        }
    }
    $stmt->close();
}
?>