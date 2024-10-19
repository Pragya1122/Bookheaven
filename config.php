<?php
// config.php

// Database configuration
$host = 'localhost'; // Host name
$db_name = 'bookstore'; // Database name
$username = 'root'; // Database username (default is 'root' in XAMPP)
$password = ''; // Database password (default is empty in XAMPP)

// Create connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully"; // Uncomment for debugging
?>
