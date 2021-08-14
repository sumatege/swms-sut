<?php

session_start();
require '../config-main.php';

if ($_GET["oxval"] != null) {
    $sql = "UPDATE project SET 
        wq_val = " . $_GET["oxval"] . " 
        WHERE p_id = '" . $_SESSION["selectedProjectId"] . "'";

    if ($conn->query($sql) === TRUE) {
        echo "0";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}else{
    echo "Error: " . $conn->error;
}

$conn->close();
?>