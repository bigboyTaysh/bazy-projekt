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
    $sql = "UPDATE uzytkownicy SET"
            . " id_rodzaju = 3"
            . " WHERE id_rodzaju = $id";
    $conn->query($sql);
            
    $sql = "DELETE FROM rodzaj_konta WHERE id_rodzaju = '$id'";
    $conn->query($sql);
    
    $conn->close();
}
?>