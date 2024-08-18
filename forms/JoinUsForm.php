<?php

// Database connection details
$host = 'localhost';
$dbname = 'users';
$username = 'wisdom';
$password = ' ';


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


$response = array("success" => false, "message" => "");

// Checking form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING);

    // Validations
    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($bio)) {
        $response["message"] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["message"] = "Invalid email format.";
    } else {
      
        try {
            // database connection
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("INSERT INTO registrations (name, email, phone, address, bio) VALUES (:name, :email, :phone, :address, :bio)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':bio', $bio);

            $stmt->execute();

            $response["success"] = true;
            $response["message"] = "Registration successful!";
        } catch(PDOException $e) {
            $response["message"] = "Error: " . $e->getMessage();
        }
        
        // Close connection
        $pdo = null;
    }
} else {
    $response["message"] = "Invalid request method.";
}

echo json_encode($response);
?>