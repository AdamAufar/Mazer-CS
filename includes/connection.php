<?php
date_default_timezone_set('Asia/Jakarta');
$host = "localhost";
$username = "root";
$password = "";
$database = "db_cleaning_service";
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_errno) {
    die("Failed to connect to MySQL: " . $conn->connect_error);
}
?>