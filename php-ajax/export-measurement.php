<?php

session_start();
require '../config-main.php';

if (isset($_SESSION["selectedProjectId"]) && isset($_GET["sdate"]) && isset($_GET["edate"])) {
    $sql = "SELECT * FROM measurement WHERE m_project_id='" . $_SESSION["selectedProjectId"] . "' 
    AND (m_date BETWEEN CAST('" . $_GET["sdate"] . "' AS DATE) AND CAST('" . $_GET["edate"] . "' AS DATE))";

    $result = $conn->query($sql);
    $i = 1;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $url = "SELECT * FROM project WHERE p_id='" . $row["m_project_id"] . "'";
            $query = mysqli_query($conn, $url);
            $result_pdata = mysqli_fetch_array($query, MYSQLI_ASSOC);

            $data[] = array(
                "#" => $i,
                "รหัสโปรเจ็ค" => $row["m_project_id"],
                "รหัสอุปกรณ์" => $result_pdata["p_key"],
                "ชื่อโครงการ" => $result_pdata["p_name"],
                "วันที่เก็บข้อมูล" => $row["m_date"],
                "เวลาที่เก็บข้อมูล" => $row["m_time"],
                "ปริมาณออกซิเจน" => $row["m_oxigen"],
                "อุณหภูมิน้ำ" => $row["m_water_temp"],
                "ค่า pH" => $row["m_ph"],
                "ความเค็มของน้ำ" => $row["m_salinity"],
                "การนำไฟฟ้า" => $row["m_conductivity"],
                "อุณหภูมิอากาศ" => $row["m_air_temp"],
                "ความชื้นสัมพัทธ์" => $row["m_humidity"]
            );
            //$data[] = $row;
            $i++;
        }
        echo json_encode($data);
    } else {
        echo '0';
    }
} else {
    echo '0';
}

$conn->close();
