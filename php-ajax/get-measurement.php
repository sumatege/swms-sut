<?php

session_start();
require '../config-main.php';

if (isset($_SESSION["selectedProjectId"]) && isset($_GET["sdate"]) && isset($_GET["edate"])) {
    $sql = "SELECT * FROM measurement WHERE m_project_id='" . $_SESSION["selectedProjectId"] . "' 
    AND (m_date BETWEEN CAST('" . $_GET["sdate"] . "' AS DATE) AND CAST('" . $_GET["edate"] . "' AS DATE))";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $url = "SELECT * FROM project WHERE p_id='" . $row["m_project_id"] . "'";
            $query = mysqli_query($conn, $url);
            $result_pdata = mysqli_fetch_array($query, MYSQLI_ASSOC);

            $data[] = array(
                "m_id" => $row["m_id"],
                "m_project_id" => $row["m_project_id"],
                "m_key" => $result_pdata["p_key"],
                "m_name" => $result_pdata["p_name"],
                "m_date" => $row["m_date"],
                "m_time" => $row["m_time"],
                "m_oxigen" => $row["m_oxigen"],
                "m_water_temp" => $row["m_water_temp"],
                "m_ph" => $row["m_ph"],
                "m_salinity" => $row["m_salinity"],
                "m_conductivity" => $row["m_conductivity"],
                "m_air_temp" => $row["m_air_temp"],
                "m_humidity" => $row["m_humidity"]
            );
            //$data[] = $row;
        }
        echo json_encode($data);
    }else{
        echo '0';    
    }
} else {
    echo '0';
}

$conn->close();
