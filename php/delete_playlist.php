<?php
// delete_playlist.php

header('Content-Type: application/json');

// Allow DELETE method only
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Only DELETE method allowed']);
    exit;
}

if (!isset($_GET['id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Playlist ID is required']);
    exit;
}

$playlist_id = intval($_GET['id']);

// Include database connection
include 'db.php';

// Start transaction to ensure data integrity
$conn->begin_transaction();

try {
    // First delete songs in the playlist
    $stmtSongs = $conn->prepare("DELETE FROM songs WHERE playlist_id = ?");
    $stmtSongs->bind_param("i", $playlist_id);
    $stmtSongs->execute();

    // Then delete the playlist itself
    $stmtPlaylist = $conn->prepare("DELETE FROM playlists WHERE id = ?");
    $stmtPlaylist->bind_param("i", $playlist_id);
    $stmtPlaylist->execute();

    // Commit changes
    $conn->commit();

    echo json_encode(['success' => true, 'message' => 'Playlist and songs deleted successfully']);
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(['error' => 'Failed to delete playlist: ' . $e->getMessage()]);
}

$conn->close();
