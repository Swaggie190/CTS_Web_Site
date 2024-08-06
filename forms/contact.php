<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $subject = sanitize_input($_POST['subject']);
    $message = sanitize_input($_POST['message']);


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        exit;
    }

  
    $to = "wisdomsibafo45@gmail.com";
    $email_subject = "New Contact Form Submission: $subject";
    $email_body = "You have received a new message from your website contact form.\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Subject: $subject\n";
    $email_body .= "Message:\n$message\n";

 
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com';  
        $mail->SMTPAuth   = true;
        $mail->Username   = 'wisdomsibafo45@gmail.com';     
        $mail->Password   = 'opah sysc jmfx nfod';     
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587;                 

        
        $mail->setFrom($email, $name);
        $mail->addAddress($to);
        $mail->addReplyTo($email, $name);

        $mail->isHTML(false);
        $mail->Subject = $email_subject;
        $mail->Body    = $email_body;

        $mail->send();
        echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>