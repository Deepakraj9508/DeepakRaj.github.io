<?php
header('Content-Type: text/plain'); // Prevent XSS
header('X-Content-Type-Options: nosniff');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = strip_tags(trim($_POST["name"] ?? ''));
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"] ?? ''));
    $message = trim($_POST["message"] ?? '');
    
    // Check data
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please complete the form and try again.";
        exit;
    }
    
    // Recipient email
    $recipient = "deepakrajnoorsarai@gmail.com";
    
    // Email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Subject: $subject\n\n";
    $email_content .= "Message:\n$message\n";
    
    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Send email
    if (mail($recipient, $subject, $email_content, $headers)) {
        http_response_code(200);
        echo "Thank you! Your message has been sent.";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>