<?php

$host = "localhost";
$user = "mkunjo1";
$pass = "mkunjo1";
$dbname = "mkunjo1";

// Connecting to DB
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if file has been uploaded
if (isset($_FILES['jsonFile'])) {
    $jsonFile = $_FILES['jsonFile']['tmp_name'];
    $jsonData = file_get_contents($jsonFile);
    $data = json_decode($jsonData, true);

    // Loop through the JSON data
    foreach ($data["items"] as $item) {
        // Extracting data from JSON
        $added_at = $item['added_at'];
        $track = $item['track'];
        $track_name = $conn->real_escape_string($track['name']);
        $track_id = $track['id'];
        $album = $track['album'];
        $album_name = $conn->real_escape_string($album['name']);
        $album_id = $album['id'];
        $artist = $track['artists'][0]; // considering first artist
        $artist_name = $conn->real_escape_string($artist['name']);
        $artist_id = $artist['id'];
        $duration_ms = $track['duration_ms'];
        $popularity = $track['popularity'];
        $explicit = $track['explicit'] ? 1 : 0;
        $preview_url = isset($track['preview_url']) ? $track['preview_url'] : "";
        $track_uri = $track['uri'];

        // SQL to insert data
        $sql = "INSERT INTO songs (added_at, track_name, track_id, album_name, album_id, artist_name, artist_id, duration_ms, popularity, explicit, preview_url, track_uri) 
                VALUES ('$added_at', '$track_name', '$track_id', '$album_name', '$album_id', '$artist_name', '$artist_id', $duration_ms, $popularity, $explicit, '$preview_url', '$track_uri')";

        // Execute query
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>
