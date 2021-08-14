<?php

session_start();
require '../config-main.php';

if ($_GET["p_key"] != null) {
  $sql = "UPDATE project SET 
p_name ='" . $_GET["p_name"] . "',
p_owner ='" . $_SESSION["m_id"] . "',
p_date_create = '" . date("Y-m-d") . "',
p_req_status = '1',
p_display = '0',
p_noti_switch = '1',
wq_val = '5',
ae_val = '5' 
WHERE p_key = '" . $_GET["p_key"] . "'";

  if ($conn->query($sql) === TRUE) {
    echo "0";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
} else {
  echo "Error: " . $conn->error;
}


$conn->close();
