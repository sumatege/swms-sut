<?php

session_start();
require '../config-main.php';

$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < 10; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
}

if (isset($_GET["m_email"]) && isset($_GET["m_password"]) && isset($_GET["m_name"]) && isset($_GET["m_sirname"])) {
    $sql = "INSERT INTO member (m_email, m_password, m_name, m_sirname, m_create_date, m_view) 
    VALUES ('" . $_GET["m_email"] . "', '" . $_GET["m_password"] . "', '" . $_GET["m_name"] . "', '" . $_GET["m_sirname"] . "', '" . date("Y-m-d") . "','" . $randomString . "')";

    if ($conn->query($sql) === TRUE) {
        $sqlmember = "SELECT * FROM member WHERE m_email='" . $_GET["m_email"] . "' AND m_password='" . $_GET["m_password"] . "'";
        $result = $conn->query($sqlmember);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $_SESSION["m_id"] = $row["m_id"];
                $_SESSION["m_name"] = $row["m_name"];
                $_SESSION["m_sirname"] = $row["m_sirname"];
                $_SESSION["m_email"] = $row["m_email"];
                $_SESSION["m_password"] = $row["m_password"];
                $_SESSION["m_create_date"] = $row["m_create_date"];
                $_SESSION["m_view"] = $row["m_view"];
            }
            echo "0";
        } else {
            setcookie("loginFailedTxt", "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง", time() + 5, "/");
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();