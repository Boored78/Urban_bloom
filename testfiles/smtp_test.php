<?php
$to = "angelovbojidar23@gmail.com";
$subject = "Mailjet SMTP Test";
$message = "Hello, this is a test email!";
$headers = "From: bobonoob25@gmail.com";

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email.";
}
?>

