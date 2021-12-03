<?php
require 'db_conn.php';
/** @var mysqli $conn */

$rating = $_POST['rating'];
$user_id = $_POST['user_id'];
$movie_id = $_POST['movie_id'];

$query = "INSERT INTO rating (movie_id, user_id, rating) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE rating=VALUES(rating)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'iii', $movie_id, $user_id, $rating);
mysqli_stmt_execute($stmt);

header('location: ../movie.php?id='.$movie_id);