<?php
// Database configuration
$dbuser = "root";
$dbpass = "";
$host = "localhost";
$db = "database_tms(1)";

// Create the MySQLi connection
$mysqli = new mysqli($host, $dbuser, $dbpass, $db);

// Check for connection error
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
