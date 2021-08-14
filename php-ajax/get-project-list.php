<?php

session_start();
require '../config-main.php';

$sql = "SELECT * FROM project WHERE p_display = '0' AND p_owner='" . $_SESSION["m_id"] ."'";


$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        //$data = array(p_id"=>$row["p_id"], "p_name"=>$row["p_name"]);
        //echo json_encode($data);
        $data[] = array("p_id"=>$row["p_id"], "p_name"=>$row["p_name"], "p_key"=>$row["p_key"]);
    }
    echo json_encode($data);
} else {
    echo "0";
}

$conn->close();