<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once 'db.php';
require_once 'sms.php';

function userRegistration(string $name, string $phoneNumber) {
    $checkUser = getUserByPhoneNumber($phoneNumber);
    if ($checkUser) {
        header('Location: ../userExists.html');
        return false;
    }

    $pin = generateUniquePin();
    $message = "Hi $name, your pin is $pin, do not share it with anyone. You will be using this pin to log in to your account.";
    $sendPin = sendSMS($phoneNumber, $message);
    if ($sendPin) {
        $pin = encryptPin($pin);
        $user = createUser($name, $phoneNumber, $pin);
        if ($user) {
            return $user;
        } else {
            return false; 
        }
    } else {
        return false;
    }
}

function userLogin( string $phoneNumber, string $pin) {
    $user = getUserByPhoneNumber($phoneNumber);
    $hash = $user['pin'];
    $verifyPin = password_verify($pin, $hash);
    
    if ($verifyPin) {
        $_SESSION["user_id"] = $user['id'];
        return true;
    } else {
        return false;
    }
    return false;
}

function createMessage($message, $userId) {
    $message = createMessage($message, $userId);
    return $message;
}

function processSavePhoneNumber(string $phoneNumber, $userId) {
    $phoneNumber = addPhoneNumber($phoneNumber, $userId);
    if ($phoneNumber) {
        return $phoneNumber;
    } else {
        return false;
    }
}

function processLoadPhoneNumbers(int $userId){
    try {
        $phoneNumbers = getPhoneNumbers($userId);
        return $phoneNumbers;
    } catch(\Throwable $th) {
        throw $th;
    }
}

function processGetPhoneNumbers($user) {
    $phoneNumbers = getPhoneNumbers($user);
    return $phoneNumbers;
}

function processSendSMSMessage(string $message, $userId) {
    $phoneNumbers = getPhoneNumbers($userId);
    $phoneNumberStrings = array_map(function($entry) {
        return $entry['phone_number'];
    }, $phoneNumbers);
    
    $phoneNumberString = implode(', ', $phoneNumberStrings);
    $message = sendSMS($phoneNumberString, $message);
    return $message;

}

function processDeletePhoneNumber($phoneNumber) {
    $deletePhoneNumber = deletePhoneNumber($phoneNumber);
    return $deletePhoneNumber;
}

function processLogin() {
    $phoneNumber = $_POST['phone'];
    $pin = $_POST['pin'];
    $user = userLogin($phoneNumber, $pin);

    if ($user) {
         header('Location: ../numberCreation.html');
         return true;
    } else {
        header('Location: ../index.html');
        return false;
    }
    header('Location: ../index.html');
}

function processRegistration() {
    $name = $_POST['name'];
    $phoneNumber = $_POST['phone'];
    $user = userRegistration($name, $phoneNumber);

    if ($user) {
        header('Location: ../validatePin.html');

    } else {
        header('Location: ../userExists.html');
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_SESSION['user_id'])) {
        $user = $_SESSION['user_id'];
        if (isset($_POST['Logout'])) {
            session_destroy();
            header('Location: ../index.html');
        } else if (isset($_POST['phoneNumberList'])) {
            $phoneNumbers = processLoadPhoneNumbers($user);
            echo json_encode($phoneNumbers);
        } else if (isset($_POST['Add'])) {
            $phoneNumber = $_POST['phone'];
            $phoneNumber = processSavePhoneNumber($phoneNumber, $user);
            echo json_encode($phoneNumber);
        } else if (isset($_POST['sendSMS'])) {
            $message = $_POST['message'];
            $message = processSendSMSMessage($message, $user);
            echo json_encode($message);
        } else if (isset($_POST['Delete'])) {
            $phoneNumber = $_POST['phone'];
            $deletePhoneNumber = processDeletePhoneNumber($phoneNumber);
            echo json_encode($deletePhoneNumber);
        } else {
            echo "Hi None of the above";
        }
    } else if (isset($_POST['Login'])) {
        processLogin();
    } else if (!isset($_SESSION['user_id'])) {
        if (isset($_POST['Register'])) {
            processRegistration();
        } else {
        header('Location: ../index.html');
        exit;
        }
    }
}

session_write_close();

?>