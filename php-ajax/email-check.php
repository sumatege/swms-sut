<?php

session_start();
require '../config-main.php';

if (isset($_GET["m_email"])) {
    $sql = "SELECT * FROM member WHERE m_email = '" . $_GET["m_email"] . "'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "1";
    } else {
        echo "0";
    }
}

$conn->close();
