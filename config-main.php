<?php

/*
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "swms_database";
*/

$servername = "localhost";
$username = "io";
$password = "7777777777yU";
$dbname = "swms_database";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>