<?php
$servername = "localhost";
$username = "u447245851_hostdonasi";
$password = "passdbdonasi";
$dbname = "u447245851_donasi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE konten SET lama_donasi=lama_donasi - 1 WHERE lama_donasi>0";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>