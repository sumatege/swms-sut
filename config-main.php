<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "swms_database";

/*
$servername = "localhost";
$username = "id17235519_swms2021";
$password = "[MSc-EOe<1hV[-\c";
$dbname = "id17235519_swms_database	";
*/

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}