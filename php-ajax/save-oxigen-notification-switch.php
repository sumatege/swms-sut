<?php

session_start();
require '../config-main.php';

if ($_GET["switchval"] != null) {

    if($_GET["switchval"] == "true"){
        $switchval = 0;
    }else{
        $switchval = 1;
    }

    $sql = "UPDATE project SET 
        p_noti_switch = " . $switchval . " 
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