<?php
$servername = "localhost";
$username = "fidaride_taxi";
$password = "QDsZ;BazhKad";
$dbname = "fidaride_taxi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>