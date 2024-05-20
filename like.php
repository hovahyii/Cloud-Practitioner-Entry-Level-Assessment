<?php
$servername = "db"; // Use "localhost" if not using Docker
$username = "root";
$password = "password";
$dbname = "mywall";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Connection failed: " . $conn->connect_error);
}

// Increment like count
$sql = "UPDATE likes SET count = count + 1 WHERE id = 1";

if ($conn->query($sql) === TRUE) {
    echo "Like count updated successfully";
} else {
    error_log("Error updating like count: " . $conn->error);
    echo "Error updating like count: " . $conn->error;
}

$conn->close();
?>
