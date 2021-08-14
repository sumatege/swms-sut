<?php

session_start();
require '../config-main.php';


$sql = "SELECT * FROM member WHERE m_id='" . $_SESSION["m_id"] . "'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data = array(
            "m_id" => $row["m_id"],
            "m_name" => $row["m_name"],
            "m_sirname" => $row["m_sirname"],
            "m_create_date" => $row["m_create_date"],
            "m_email" => $row["m_email"],
            "m_password" => $row["m_password"],
            "m_view" => $row["m_view"],
            "status" => "0"
        );
    }
    echo json_encode($data);
} else {
    $data = array("status" => "1");
    echo json_encode($data);
}

$conn->close();