<?php

require '../config-main.php';

if (!empty($_POST['p_key']) && !empty($_POST['p_req_status']) && !empty($_POST['p_ox']) && !empty($_POST['p_water_temp']) && !empty($_POST['p_ph']) && !empty($_POST['p_sal']) && !empty($_POST['p_cond']) && !empty($_POST['p_air_temp']) && !empty($_POST['p_hum'])) {

  $sql = "UPDATE project SET 
p_req_status = " . $_POST['p_req_status'] . ",
ox_val = " . $_POST['p_ox'] . ",
water_temp_val = " . $_POST['p_water_temp'] . ",
ph_val = " . $_POST['p_ph'] . ",
sal_val = " . $_POST['p_sal'] . ",
cond_val = " . $_POST['p_cond'] . ",
air_temp_val = " . $_POST['p_air_temp'] . ",
hum_val = " . $_POST['p_hum'] . ",
WHERE p_key = '" . $_POST["p_key"] . "'";

  if ($conn->query($sql) === TRUE) {
    echo "0";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
} else {
  echo "Error: Empty data";
}


$conn->close();
