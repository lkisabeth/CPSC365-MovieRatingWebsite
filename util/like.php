<?php
require 'db_conn.php';
/** @var mysqli $conn */

$comment_id = $_POST['comment_id'];
$user_id = $_POST['user_id'];
$movie_id = $_POST['movie_id'];

$query = "INSERT INTO likes (comment_id, user_id) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'ii', $comment_id, $user_id);
mysqli_stmt_execute($stmt);

header('location: ../movie.php?id='.$movie_id);