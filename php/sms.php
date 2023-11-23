<?php

function sendSMS($phoneNumber, $message){
    require 'config.php';
    // Set your shortCode or senderId
    $from = "T-WAVE";

    // Define the API endpoint
    $url =  "https://api.sandbox.africastalking.com/version1/messaging";

    // Prepare the request data
    $data = [
    "username" => $africas_talking_username,
    "to" => $phoneNumber,
    "message" => $message,
    // "from" => $from
    ];
    // Initialize cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        'apiKey: ' . $africas_talking_api_key
    ]);
    // Execute the cURL request
    $response = curl_exec($ch);

    // Check for errors
    if($response === false) {
        return 'cURL Error: ' . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);

    // return the response
    return $response;
}
?>