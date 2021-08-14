<?php

session_start();

if ($_GET["p_name"] == "nodata") {
    require '../config-main.php';

    $sql = "SELECT * FROM project WHERE p_owner='" . $_SESSION["m_id"] . "' AND p_id='" . $_GET["p_id"] . "'";


    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION["selectedProjectId"] = $row["p_id"];
            $_SESSION["selectedProjectName"] = $row["p_name"];
            $_SESSION["selectedProjectKey"] = $row["p_key"];
            $data = array("p_id" => $row["p_id"], "p_name" => $row["p_name"], "p_key" => $row["p_key"]);
            echo json_encode($data);
        }
    }

    $conn->close();
} else {
    $_SESSION["selectedProjectId"] = $_GET["p_id"];
    $_SESSION["selectedProjectName"] = $_GET["p_name"];
    $_SESSION["selectedProjectKey"] = $_GET["p_key"];
}