<?php
$host = "localhost";
$user = "root";  // tumia jina lako la MySQL
$pass = "";      // kama una password weka hapa
$dbname = "chagga_translator";

// Unganisha na database
$conn = new mysqli($host, $user, $pass, $dbname);

// Kagua connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>