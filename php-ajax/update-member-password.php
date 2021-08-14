<?php

session_start();
require '../config-main.php';

if ($_GET["m_password"] != null) {
    $sql = "UPDATE member SET 
m_password ='" . $_GET["m_password"] . "'
WHERE m_id = '" . $_SESSION["m_id"] . "'";

    if ($conn->query($sql) === TRUE) {
        echo "0";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
