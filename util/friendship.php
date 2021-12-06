<?php
require 'db_conn.php';
/** @var mysqli $conn */

if (isset($_POST['user_id']) && isset($_POST['friend_id'])) {
    $user_id = $_POST['user_id'];
    $friend_id = $_POST['friend_id'];

    $query = "SELECT * FROM friendship WHERE user_id = ? AND friend_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $friend_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        if (isset($_POST['accept_friend'])) {
            $status = true;
            $query = "UPDATE friendship SET status = ? WHERE user_id = ? AND friend_id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'iii', $status, $user_id, $friend_id);
            mysqli_stmt_execute($stmt);
            echo "friend request accepted";
        } else if (isset($_POST['remove_friend'])) {
            $query = "DELETE FROM friendship WHERE user_id = ? AND friend_id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $user_id, $friend_id);
            mysqli_stmt_execute($stmt);
            echo "friendship removed";
        } else {
            echo "already friends";
        }
    } else {
        $query = "INSERT INTO friendship (user_id, friend_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $user_id, $friend_id);
        mysqli_stmt_execute($stmt);
        echo "friend request sent";
    }
}