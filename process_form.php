<?php
$servername = "db";
$username = "root";
$password = "password";
$dbname = "mywall";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$message = $_POST['message'];
$avatar = $_FILES['avatar'];

// Handle file upload
$target_dir = "uploads/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0755, true);
}

$target_file = $target_dir . basename($avatar["name"]);
if (move_uploaded_file($avatar["tmp_name"], $target_file)) {
    // Save the relative path in the database
    $relative_path = $target_file;
    $sql = "INSERT INTO messages (name, message, avatar) VALUES ('$name', '$message', '$relative_path')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Sorry, there was an error uploading your file.";
}

$conn->close();
?>
