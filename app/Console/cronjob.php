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

$sql = "UPDATE konten SET lama_donasi=lama_donasi - 1 WHERE lama_donasi>0 AND status='aktif'";

if ($conn->query($sql) === TRUE) {
    echo "Update lama donasi sukses";
} else {
    echo "Gagal ubah lama donasi: " . $conn->error;
}

$sql2 = "UPDATE konten SET status='selesai' WHERE lama_donasi=0 AND status<>'selesai'";
if ($conn->query($sql2) === TRUE) {
    echo "Update status donasi sukses";
} else {
    echo "Gagal update donasi selesai: " . $conn->error;
}

$conn->close();
?>