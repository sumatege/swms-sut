<?php

session_start();
require '../config-main.php';

$sql = "SELECT * FROM project WHERE p_key='" . $_GET["projectkey"] ."'";


$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data = array(
            "p_id" => $row["p_id"],
            "p_key" => $row["p_key"],
            "p_name" => $row["p_name"],
            "p_owner" => $row["p_owner"],
            "p_date_create" => $row["p_date_create"],
            "p_req_val" => $row["p_req_status"],
            "p_display_val" => $row["p_display"],
            "p_noti_switch" => $row["p_noti_switch"],
            "p_wq_val" => $row["wq_val"],
            "p_ae_val" => $row["ae_val"],
            "p_ox_val" => $row["ox_val"],
            "p_wtemp_val" => $row["water_temp_val"],
            "p_ph_val" => $row["ph_val"],
            "p_sal_val" => $row["sal_val"],
            "p_cond_val" => $row["cond_val"],
            "p_atemp_val" => $row["air_temp_val"],
            "p_hum_val" => $row["hum_val"]
        );
    }
    echo json_encode($data);
} else {
    $data = array("p_key" => "null");
    echo json_encode($data);
}

$conn->close();

?>