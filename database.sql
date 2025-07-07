CREATE DATABASE IF NOT EXISTS music_manager;
USE music_manager;

CREATE TABLE playlists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE songs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    playlist_id INT,
    title VARCHAR(100),
    artist VARCHAR(100),
    url VARCHAR(255),
    FOREIGN KEY (playlist_id) REFERENCES playlists(id) ON DELETE CASCADE
);