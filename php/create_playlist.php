<?php
include 'db.php';
$name = $_POST['name'];
$desc = $_POST['description'];
$sql = "INSERT INTO playlists (name, description) VALUES ('$name', '$desc')";
$conn->query($sql);
$conn->close();
?>