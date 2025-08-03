<?php

// Define recipient email and subject
$to = 'grinsdental065@gmail.com';
$subject = 'New Contact Message from Website';

// Sanitize and validate input
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$msg = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Basic validation
if (empty($name) || empty($email) || empty($phone) || empty($msg)) {
    echo 'failed'; // Or a more specific error like 'failed_missing_fields'
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'failed'; // Or 'failed_invalid_email'
    exit;
}

// Construct email headers
// IMPORTANT: Replace 'noreply@yourdomain.com' with an actual email from your website's domain
// This significantly improves email deliverability and avoids being marked as spam.
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "From: noreply@yourdomain.com\r\n"; // Sender: Your website's email
$headers .= "Reply-To: " . $name . " <" . $email . ">\r\n"; // Replies go to the user

// Construct HTML email body
$message_body = '
<html>
<head>
<title>New Contact Message</title>
<style>
    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
    .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; background-color: #f9f9f9; }
    h2 { color: #4a7cd2; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
    p { margin-bottom: 10px; }
    strong { color: #000; }
</style>
</head>
<body>
    <div class="container">
        <h2>New Contact Inquiry from Your Website</h2>
        <p><strong>Name:</strong> ' . $name . '</p>
        <p><strong>Email:</strong> ' . $email . '</p>
        <p><strong>Phone:</strong> ' . $phone . '</p>
        <p><strong>Message:</strong><br>' . nl2br($msg) . '</p>
        <p style="font-size: 0.9em; color: #777;">This message was sent from your website\'s contact form.</p>
    </div>
</body>
</html>
';

// Attempt to send the email
if (mail($to, $subject, $message_body, $headers)) {
    echo 'sent';
} else {
    echo 'failed';
}
?>