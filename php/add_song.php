<?php
include 'db.php';

$title = $_POST['title'] ?? '';
$artist = $_POST['artist'] ?? '';
$url = $_POST['url'] ?? '';
$playlist_id = $_POST['playlist_id'] ?? '';

if ($title && $artist && $url && $playlist_id) {
    $stmt = $conn->prepare("INSERT INTO songs (playlist_id, title, artist, url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $playlist_id, $title, $artist, $url);
    $stmt->execute();
    echo "Song added";
} else {
    http_response_code(400);
    echo "Missing data";
}

$conn->close();
?>
