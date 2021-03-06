<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$conn = new mysqli($servername, $username, $password, $dbname);

$conn->query('SET charset utf8');
$conn->query('SET CHARACTER_SET utf8_polish_ci');

$data = array();
$all = 0;
$data_min = $_POST['data_min'];
$data_max = $_POST['data_max'];

$sql = "SELECT COUNT(*) AS total FROM rodzaj_serwera";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = array("<tr>"
            . "<td>Ilość wyników: " . $row['total'] . "</td>"
            . "</tr>"
            . "<tr>"
            . "<td>ID rodzaju</td>"
            . "<td>nazwa</td>"
            . "<td>ilość </td>"
            . "<td>procent </td>"
            . "</tr>");
    }
}

$sql = "SELECT COUNT(*) AS total FROM uslugi WHERE data_poczatkowa BETWEEN '$data_min' AND '$data_max'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        $all = $row['total'];
    }
}

$sql = "SELECT COUNT(*) AS total FROM nieaktywne_uslugi WHERE data_poczatkowa BETWEEN '$data_min' AND '$data_max'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        $all = $all + $row['total'];
    }
}

$sql = "SELECT r.*, 
((SELECT COUNT(*) from uslugi u, serwery s WHERE r.id_rodzaju = s.id_rodzaju AND s.id_serwera = u.id_serwera AND
 (u.data_poczatkowa BETWEEN '$data_min' AND '$data_max'))
 + 
(SELECT COUNT(*) from nieaktywne_uslugi u, serwery s WHERE r.id_rodzaju = s.id_rodzaju AND s.id_serwera = u.id_serwera AND
 (u.data_poczatkowa BETWEEN '$data_min' AND '$data_max')))
 as total FROM rodzaj_serwera r";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $procent = ($row['total'] / $all) * 100;

        $data[] = array(
            "<tr>"
                . "<td>" . $row["id_rodzaju"] . "</td>"
                . "<td>" . $row['nazwa_rodzaju'] . "</td>"
                . "<td>" . $row['total'] . "</td>"
                . "<td>" . round($procent,2) . "%</td>"
                . "</tr>"
        );
    }
}
echo json_encode($data);
$conn->close();
