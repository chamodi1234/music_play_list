<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Parse id from URL or body
    parse_str(file_get_contents("php://input"), $delete_vars);
    $id = $delete_vars['id'] ?? $_GET['id'] ?? null;

    if ($id) {
        $stmt = $conn->prepare("DELETE FROM songs WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            http_response_code(200);
            echo "Song deleted";
        } else {
            http_response_code(500);
            echo "Failed to delete song";
        }
    } else {
        http_response_code(400);
        echo "Song ID required";
    }
} else {
    http_response_code(405); // Method not allowed
    echo "Only DELETE method allowed";
}

$conn->close();
?>
