<?php

require_once("db.php");

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
    $chatroom_id = isset($_GET["chatroom_id"]) ? $_GET["chatroom_id"] : null;

    if ($chatroom_id !== null) {
        $sql = "SELECT * FROM Messages WHERE chatroom_id=$chatroom_id ORDER BY sent_at";

        $result = $conn->query($sql);

        $messages = array();

        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }

        echo json_encode($messages);
    } else {
        echo "Invalid input data";
    }
} else {
    echo "Invalid request method";
}

$conn->close();

?>
