<?php

require_once("db.php");

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $chatroom_name = isset($_POST["chatroom_name"]) ? $_POST["chatroom_name"] : null;
    $created_by = isset($_POST["created_by"]) ? $_POST["created_by"] : null;

    if ($chatroom_name !== null && $created_by !== null) {
        $sql = "INSERT INTO ChatRooms (chatroom_name, created_by) VALUES ('$chatroom_name', $created_by)";

        if ($conn->query($sql) === TRUE) {
            echo "Chat room created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid input data";
    }
} else {
    echo "Invalid request method";
}

$conn->close();

?>
