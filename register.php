<?php

require_once("db.php");  // Assuming you have a file with the database connection

// Allow cross-origin requests (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight OPTIONS request
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    exit; // No further action needed for OPTIONS requests
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user input
    $username = isset($_POST["username"]) ? htmlspecialchars($_POST["username"]) : null;
    $email = isset($_POST["email"]) ? filter_var($_POST["email"], FILTER_SANITIZE_EMAIL) : null;
    $password = isset($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : null;

    // Validate input data
    if ($username !== null && $email !== null && $password !== null) {
        // Check if the username is unique (you might want to enhance this validation)
        $checkUsernameQuery = "SELECT * FROM Users WHERE username='$username'";
        $checkResult = $conn->query($checkUsernameQuery);

        if ($checkResult->num_rows > 0) {
            echo "Username already exists";
        } else {
            // Insert user data into the database
            $insertQuery = "INSERT INTO Users (username, email, password) VALUES ('$username', '$email', '$password')";

            if ($conn->query($insertQuery) === TRUE) {
                echo "Registration successful";
            } else {
                echo "Error: " . $insertQuery . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Invalid input data";
    }
} else {
    echo "Invalid request method";
}

$conn->close();

?>
