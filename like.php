<?php
$servername = "localhost"; // or "db" if you are using Docker
$username = "root";
$password = "password";
$dbname = "mywall";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Increment like count
$sql = "UPDATE likes SET count = count + 1 WHERE id = 1";

if ($conn->query($sql) === TRUE) {
    echo "Like count updated successfully";
} else {
    echo "Error updating like count: " . $conn->error;
}

$conn->close();
?>
