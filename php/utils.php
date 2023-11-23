<?php

function connectTODatabase() {
    require 'config.php';

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function encryptPin($pin) {
    return password_hash($pin, PASSWORD_DEFAULT);
}

function generateUniquePin() {
    $pin = range(1000, 9999);
     foreach ($pin as $key => $value) {
         $pinStr = (string) $value;
         if(preg_match('/(\d)\1/', $pinStr) || abs($pinStr[0] - $pinStr[1]) == 1 || abs($pinStr[1] - $pinStr[2]) == 1 || abs($pinStr[2] - $pinStr[3]) == 1) {
             unset($pin[$key]);
         }
     }
     shuffle($pin);
     return array_pop($pin);
}



?>