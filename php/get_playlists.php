<?php
include 'db.php';
$result = $conn->query("SELECT * FROM playlists");
$playlists = array();
while($row = $result->fetch_assoc()) {
    $playlists[] = $row;
}
echo json_encode($playlists);
$conn->close();
?>