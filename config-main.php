<?php

/*
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "swms_database";
*/

$servername = "remotemysql.com";
$username = "a33Dt0J2lv";
$password = "vg2Iesyxne";
$dbname = "a33Dt0J2lv";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>