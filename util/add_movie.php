<?php
require 'db_conn.php';
/** @var mysqli $conn */

$title = $_POST['title'];
$release_date = $_POST['release_date'];
$description = $_POST['description'];
$genre = $_POST['genre'];
$imgfile = $_FILES['poster']['tmp_name'];
$poster = addslashes(file_get_contents($imgfile));

$query = "INSERT INTO movie (title, release_date, description, genre, poster) VALUES ('$title', '$release_date', '$description', '$genre', '$poster')";

if (mysqli_query($conn, $query)) {
    $_SESSION["success"] = "New record created successfully";
    echo "New record created successfully";
    header("location: ../home.php");
} else {
    $_SESSION['error'] = "Error!";
    header("location: ../admin.php");
}