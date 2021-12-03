<?php
require 'db_conn.php';
/** @var mysqli $conn */

$user_id = $_POST['user_id'];
$friend_id = $_POST['friend_id'];
$status = $_POST['status'];

if (isset($_POST['movie_id'])) {
    $movie_id = $_POST['movie_id'];
}

$query = "INSERT INTO friendship (user_id, friend_id, status) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE status=VALUES(status)";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'iii', $user_id, $friend_id, $status);
mysqli_stmt_execute($stmt);

if (isset($movie_id)) {
    header('location: ../movie.php?id='.$movie_id);
} else {
    header('location: ../user.php?id='.$user_id);
}