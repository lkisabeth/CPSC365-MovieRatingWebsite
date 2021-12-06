<?php
require 'db_conn.php';
/** @var mysqli $conn */

if (isset($_POST['comment_id']) && isset($_POST['user_id'])) {
    $comment_id = $_POST['comment_id'];
    $user_id = $_POST['user_id'];
    $query = "SELECT * FROM likes WHERE comment_id = $comment_id AND user_id = $user_id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $query = "DELETE FROM likes WHERE comment_id = $comment_id AND user_id = $user_id";
        $result = mysqli_query($conn, $query);
        echo "unliked";
    } else {
        $query = "INSERT INTO likes (comment_id, user_id) VALUES ($comment_id, $user_id)";
        $result = mysqli_query($conn, $query);
        echo "liked";
    }
}