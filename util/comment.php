<?php
require 'db_conn.php';
/** @var mysqli $conn */

$movie_id = $_POST['movie_id'];
$user_id = $_POST['user_id'];
$comment = $_POST['comment'];

$query = "INSERT INTO comment (movie_id, user_id, comment) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'iis', $movie_id, $user_id, $comment);
mysqli_stmt_execute($stmt);

header('location: ../movie.php?id='.$movie_id);