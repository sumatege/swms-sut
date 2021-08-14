<?php

session_start();
require '../config-main.php';

$user = $_GET["username"];
$pw = $_GET["password"];

$sql = "SELECT * FROM member WHERE m_email='" . $user . "' AND m_password='" . $pw . "'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data = array("id" => $row["m_id"], "name" => $row["m_name"], "sirname" => $row["m_sirname"], "email" => $row["m_email"], "password" => $row["m_password"], "create_date" => $row["m_create_date"]);
        //echo json_encode($data);
        //echo "success";

        $_SESSION["m_id"] = $row["m_id"];
        $_SESSION["m_name"] = $row["m_name"];
        $_SESSION["m_sirname"] = $row["m_sirname"];
        $_SESSION["m_email"] = $row["m_email"];
        $_SESSION["m_password"] = $row["m_password"];
        $_SESSION["m_create_date"] = $row["m_create_date"];
        $_SESSION["m_view"] = $row["m_view"];

        echo json_encode($data);
    }
} else {
    setcookie("loginFailedTxt", "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง", time() + 5, "/");
    echo "0";
}

$conn->close();
