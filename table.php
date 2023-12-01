<?php
$host = "localhost";
$user = "mkunjo1";
$pass = "mkunjo1";
$dbname = "mkunjo1";

//create connection
$conn = new mysqli($host, $user, $pass, $dbname);
//check connection
if($conn->connect_error){
    die("connection failed: ".$conn->connect_error);
}

// sql to create table
// $sql = "CREATE TABLE USER_INFO(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, first_name VARCHAR(30) NOT NULL, last_name VARCHAR(30) NOT NULL, email VARCHAR(100) NOT NULL, username VARCHAR(30) NOT NULL, password VARCHAR(80) NOT NULL)";

// if($conn->query($sql) === TRUE){
//     echo "Table USER_INFO created succesfully";
// }else{
//     echo "Error creating table: ".$conn->error;
// }
// $conn->close();
// 

$sql = "CREATE TABLE SONG_INFO (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    added_at DATETIME NOT NULL,
    track_name VARCHAR(255) NOT NULL,
    track_id VARCHAR(100) NOT NULL,
    album_name VARCHAR(255) NOT NULL,
    album_id VARCHAR(100) NOT NULL,
    artist_name VARCHAR(255) NOT NULL,
    artist_id VARCHAR(100) NOT NULL,
    duration_ms INT UNSIGNED,
    popularity INT UNSIGNED,
    explicit BOOLEAN,
    preview_url VARCHAR(255),
    track_uri VARCHAR(255)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table SONG_INFO created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
$conn->close();


?>