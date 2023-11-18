<?php

require_once("db.php");

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $chatroom_id = isset($_POST["chatroom_id"]) ? $_POST["chatroom_id"] : null;
    $user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : null;
    $content = isset($_POST["content"]) ? $_POST["content"] : null;

    if ($chatroom_id !== null && $user_id !== null && $content !== null) {
        $sql = "INSERT INTO Messages (chatroom_id, user_id, content) VALUES ($chatroom_id, $user_id, '$content')";

        if ($conn->query($sql) === TRUE) {
            echo "Message sent successfully";
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
