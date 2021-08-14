<?php

session_start();
require '../config-main.php';

if ($_GET["p_name"] != null) {
    $sql = "UPDATE project SET 
p_name ='" . $_GET["p_name"] . "'
WHERE p_key = '" . $_GET["p_key"] . "'";

    if ($conn->query($sql) === TRUE) {
        echo "0";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>