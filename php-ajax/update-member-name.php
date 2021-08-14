<?php

session_start();
require '../config-main.php';

if ($_GET["m_name"] != null && $_GET["m_sirname"] != null) {
    $sql = "UPDATE member SET 
m_name ='" . $_GET["m_name"] . "',
m_sirname ='" . $_GET["m_sirname"] . "'
WHERE m_id = '" . $_SESSION["m_id"] . "'";

    if ($conn->query($sql) === TRUE) {
        echo "0";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>