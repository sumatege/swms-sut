<?php

session_start();
require '../config-main.php';

$sql = "UPDATE project SET 
p_display = '1'
WHERE p_key = '" . $_GET["p_key"] . "'";

if ($conn->query($sql) === TRUE) {
    unset($_SESSION["selectedProjectId"]);
    unset($_SESSION["selectedProjectName"]);
    unset($_SESSION["selectedProjectKey"]);

    echo "0";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
