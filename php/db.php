<?php
require_once 'utils.php';

function createUser($name, $phoneNumber, $pin) {
    $conn = connectTODatabase();
    try {
        $sql = 'INSERT INTO users (username, phone_number, pin) VALUES (?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $name, $phoneNumber, $pin);
        $stmt->execute();

        $newUserId = $stmt->insert_id;
        $user = getUserById($newUserId);
        return $user;

    } catch (\Throwable $th) {
        throw $th;
    }
    $conn->close();
}

function getUserById($userId) {
    $conn = connectTODatabase();
    try {
        $sql = 'SELECT id, username, phone_number FROM users WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $userId); 
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Fetch the user data
        $user = $result->fetch_assoc();
        
        return $user;
    } catch (\Throwable $th) {
        throw $th;
    }
    $conn->close();
}

function getUserByPhoneNumber($phoneNumber) {
    $conn = connectTODatabase();
    try {
        $sql = 'SELECT id, username, phone_number, pin FROM users WHERE phone_number = ?';
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die('Error preparing statement: ' . $conn->error);
        }
        
        $stmt->bind_param('s', $phoneNumber);
        
        if (!$stmt->execute()) {
            die('Error executing statement: ' . $stmt->error);
        }
        
        $result = $stmt->get_result();        

        if ($result->num_rows > 0) {
            $userData = $result->fetch_assoc();
            return $userData;
        } else {
            return false;
        }
    } catch (\Throwable $th) {
        throw $th;
    } finally {
        $conn->close();
    }
}

function getUserByPin($pin) {
    $conn = connectTODatabase();
    try {
        $sql = 'SELECT id, username, phone_number FROM users WHERE pin = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $pin);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    } catch (\Throwable $th) {
        throw $th;
    }
    $conn->close();
}

function updateUserData($userId, $name, $phoneNumber) {
    $conn = connectTODatabase();
    try {
        $sql='UPDATE users SET phonenumber = ?, username = ?, WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $phoneNumber, $name, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    } catch (\Throwable $th) {
        throw $th;
    }
    $conn->close();
}

function deleteUserData($userId){
    $conn = connectTODatabase();
    try {
        $sql='DELETE from users where id =?';
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('s',$userId);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result;
       
    } catch (\Throwable $th) {
        throw $th;
    }
    $conn->close();
}

function deletePhoneNumber(string $phoneNumber) {
    $conn = connectTODatabase();
    try {
        $sql = 'DELETE FROM phone_numbers WHERE phone_number = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $phoneNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        echo $result;
        return $result;
    } catch (\Throwable $th) {
        echo $th;
        throw $th;
    } finally {
        $conn->close();
    }
}

function addPhoneNumber(string $phoneNumber, $userId) {
    $conn = connectTODatabase();
    try {
        $sql = 'INSERT INTO phone_numbers (phone_number, user_id) VALUES (?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $phoneNumber, $userId);
        $stmt->execute();
        $newPhoneNumberId = $stmt->insert_id;
        $phoneNumber = getPhoneNumberById($newPhoneNumberId);
        return $phoneNumber;
    } catch (\Throwable $th) {
        error_log("Error adding phone number: " . $th->getMessage());
        return false;
    } finally {
        $conn->close();
    }
}

function getPhoneNumberById($phoneNumberId) {
    $conn = connectTODatabase();
    try {
        $sql = 'SELECT phone_number, user_id FROM phone_numbers WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $phoneNumberId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $phoneNumber = $result->fetch_assoc();
            return $phoneNumber;
        } else {
            return false;
        }
    } catch (\Throwable $th) {
        return false;
    } finally {
        $conn->close();
    }
}

function getPhoneNumbers(int $userId) {
    $conn = connectTODatabase();
    try {
        $sql = 'SELECT id, phone_number FROM phone_numbers WHERE user_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $phoneNumbers = $result->fetch_all(MYSQLI_ASSOC);
        return $phoneNumbers;
    } catch (\Throwable $th) {
        throw $th;
    } finally {
        $conn->close();
    }
}
?>