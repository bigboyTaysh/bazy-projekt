<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$id = $_POST['id'];

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $sql = "DELETE FROM pakiety WHERE id_pakietu = '$id'";
    $conn->query($sql);
    
    $conn->close();
}
?>