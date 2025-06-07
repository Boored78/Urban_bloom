<?php
session_start();
session_destroy(); // End session (user is now logged out)
header("Location: index.php");
exit();
?>
