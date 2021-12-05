<?php
session_start();
require 'db_conn.php';
/** @var mysqli $conn */

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM user WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $query)) {
        header('location: ../login.php');
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) == 1 && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['success'] = "You are now logged in.";
            header('location: ../home.php');
        } else {
            // Security Update Requirement
            $_SESSION['error'] = "Your Username or Password is incorrect. Wait three seconds before trying again.";
            $_SESSION['locked'] = true;
            header('location: ../login.php');
        }
    }
}

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $password = mysqli_real_escape_string($conn, $hash);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    if (isset($_POST['admin'])) $admin = 1; else $admin = 0;

    $query = "SELECT * FROM user WHERE username = ? OR email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $query)) {
        header('location: ../register.php');
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $id, $username, $password, $email, $admin);

        if (mysqli_stmt_num_rows($stmt) == 0) {
            $query = "INSERT INTO user (username, password, email, admin) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "sssi", $username, $password, $email, $admin);
            mysqli_stmt_execute($stmt);
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now registered and can log in.";
            header('location: ../home.php');
        } else {
            $_SESSION['error'] = "That username or email is already taken.";
            header('location: ../register.php');
        }
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location: ../home.php');
}