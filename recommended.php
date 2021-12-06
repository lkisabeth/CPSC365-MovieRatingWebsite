<!DOCTYPE html>
<html lang="en-us">

<?php require 'util/session_manager.php' /** @var mysqli $conn */ ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="util/scripts.js"></script>

    <link href="https://unpkg.com/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

        .font-family-karla {
            font-family: karla;
        }
    </style>
</head>
<body class="bg-white font-family-karla h-screen">

<?php require 'ui_components/navbar.php' ?>

<div class="h-screen flex">

<div class="flex-1 flex overflow-hidden">
    <div class="flex-1 overflow-y-scroll pt-20">
        <div class="bg-gray-50 py-2 flex flex-col justify-center">
            <div class="sm:max-w-xl sm:mx-auto">
                <h1 class="black text-black text-2xl font-bold m-6">Recommended By Your Friends</h1>
            </div>
        </div>
        <?php
        $query = "SELECT movie.*, ROUND(AVG(rating), 1) AS avg_rating FROM movie, rating WHERE movie.id = rating.movie_id AND rating.user_id IN (SELECT friend_id FROM friendship WHERE user_id = ? AND status = 1 UNION SELECT user_id FROM friendship WHERE friend_id = ? AND status = 1) GROUP BY movie.id ORDER BY COUNT(rating.rating), ROUND(AVG(rating), 1) DESC LIMIT 10";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ii",$user['id'], $user['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $movies = mysqli_fetch_all($result, MYSQLI_ASSOC);
        require 'ui_components/movie_list.php';
        ?>
    </div>
</div>

</div>
</body>
</html>