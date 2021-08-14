<?php

session_start();
require '../config-main.php';

if ($_GET["m_email"] != null) {
    $sql = "UPDATE member SET 
m_email ='" . $_GET["m_email"] . "'
WHERE m_id = '" . $_SESSION["m_id"] . "'";

    if ($conn->query($sql) === TRUE) {
        echo "0";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>