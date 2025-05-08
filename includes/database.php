<?php
$host = 'localhost'; // Database host
$user = 'root'; // Database username
$password = ''; // Database password
$dbname = 'cuahang'; // Database name

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

?>