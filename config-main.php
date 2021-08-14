<?php

/*
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "swms_database";
*/

$servername = "http://157.245.149.179";
$username = "io";
$password = "7777777777yU";
$dbname = "swms_database	";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}