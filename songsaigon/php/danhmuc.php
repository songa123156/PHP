<?php
include_once("config.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, ten FROM danh_muc";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        array_push($data, $row);
    }
}
$conn->close();

header("Content-Type: application/json");
echo json_encode($data);
