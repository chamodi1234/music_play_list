<?php
include 'db.php';
$q = $_GET['q'];
$result = $conn->query("SELECT * FROM songs WHERE title LIKE '%$q%' OR artist LIKE '%$q%'");
$songs = array();
while($row = $result->fetch_assoc()) {
    $songs[] = $row;
}
echo json_encode($songs);
$conn->close();
?>