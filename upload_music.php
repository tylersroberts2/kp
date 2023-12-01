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

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO SONG_INFO (added_at, track_name, track_id, album_name, album_id, artist_name, artist_id, duration_ms, popularity, explicit, preview_url, track_uri) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Loop through the JSON data
    foreach ($data["items"] as $item) {
        // Extract data from each item
        $track = $item['track'];
        $added_at = $item['added_at'];
        $track_name = $track['name'];
        $track_id = $track['id'];
        $album_name = $track['album']['name'];
        $album_id = $track['album']['id'];
        $artist_name = $track['artists'][0]['name']; // considering first artist
        $artist_id = $track['artists'][0]['id'];
        $duration_ms = $track['duration_ms'];
        $popularity = $track['popularity'];
        $explicit = $track['explicit'] ? 1 : 0; // Convert boolean to integer
        $preview_url = $track['preview_url'];
        $track_uri = $track['uri'];

        // Bind parameters to the prepared statement
        $stmt->bind_param("sssssssiibss", $added_at, $track_name, $track_id, $album_name, $album_id, $artist_name, $artist_id, $duration_ms, $popularity, $explicit, $preview_url, $track_uri);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "New record created successfully\n";
        } else {
            echo "Error: " . $stmt->error . "\n";
        }
    }

    // Close statement
    $stmt->close();
} else {
    echo "No file uploaded";
}

// Close connection
$conn->close();
?>
