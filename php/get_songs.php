<?php
include 'db.php';
$playlist_id = $_GET['playlist_id'];
$result = $conn->query("SELECT * FROM songs WHERE playlist_id = $playlist_id");
$songs = array();
while($row = $result->fetch_assoc()) {
    $songs[] = $row;
}
echo json_encode($songs);
$conn->close();
?>