<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$host = "localhost";
$dbname = "users";
$username = "postgres";
$password = "Sw@ggie190";


$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$consent = filter_input(INPUT_POST, 'consent', FILTER_VALIDATE_BOOLEAN);

// Validate input
if (!$name || !$email || !$consent) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide all required information.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
    exit;
}

try {
    // Connection to the database
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Checking if email already exists
    $stmt = $pdo->prepare("SELECT id FROM Users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'This email is already registered.']);
        exit;
    }

    // Inserting new user
    $stmt = $pdo->prepare("INSERT INTO Users (name, email, consent_given) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $consent]);

    echo json_encode(['success' => true, 'message' => 'Thank you for registering! You will now receive notifications about new blog posts.']);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
    
    error_log("Registration error: " . $e->getMessage());
}
?>