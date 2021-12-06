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
    <!-- Fixed sidebar -->
    <!-- Friend Requests Requirement -->
    <div class="bg-gray-200 w-1/3 pt-20">
        <?php
        $query = "SELECT * FROM friendship WHERE friend_id = ? AND status = 0";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $user['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $friend_requests = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($friend_requests as $request) {
            $query = "SELECT * FROM user WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $request['user_id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $requester = mysqli_fetch_assoc($result);
            ?>
            <div id="friend_request" class="bg-white rounded shadow-lg min-w-full p-8 m-2">
                <div class="flex justify-between mb-1">
                    <p class="text-grey-darkest leading-normal text-lg">Friend Request</p>
                </div>
                <div class="text-grey-dark leading-normal text-sm">
                    <p> <?php echo $requester['username'] ?> </p>
                    <button type="submit" id="accept_friend" onclick="acceptFriend(<?php echo $request['user_id'] ?>, <?php echo $user['id'] ?>)" class="flex items-center justify-center bg-green-500 hover:bg-green-700 text-white font-bold rounded py-1 px-2">Accept</button>
                    <button type="submit" id="remove_friend" onclick="removeFriend(<?php echo $request['user_id'] ?>, <?php echo $user['id'] ?>)" class="flex items-center justify-center bg-red-500 hover:bg-red-700 text-white font-bold rounded py-1 px-2">Reject</button>
                </div>
            </div>
        <?php } ?>

        <!-- Friends' Activity Requirement -->
        <?php
        $query = "SELECT * FROM comment
            WHERE user_id 
            IN (SELECT friend_id FROM friendship WHERE user_id = ? AND status = 1
                UNION
                SELECT user_id FROM friendship WHERE friend_id = ? AND status = 1)
            ORDER BY created_at DESC
            LIMIT 10";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ii", $user['id'], $user['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
        require 'ui_components/comment_section.php';
        ?>
    </div>
    <!-- Scroll wrapper -->
    <div class="flex-1 flex overflow-hidden">
        <div class="flex-1 overflow-y-scroll pt-20">
            <div class="bg-gray-50 py-2 flex flex-col justify-center">
                <div class="sm:max-w-xl sm:mx-auto">
                    <h1 class="black text-black text-2xl font-bold m-6">10 Most Recently Added Movies</h1>
                </div>
            </div>
            <?php
            $query = "SELECT * FROM movie ORDER BY id DESC LIMIT 10";
            $result = mysqli_query($conn, $query);
            $movies = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach ($movies as $movie) {
                $id = $movie['id'];
                $title = $movie['title'];
                $release_date = date("F j, Y", strtotime($movie['release_date']));
                $description = $movie['description'];
                $genre = $movie['genre'];
                $poster = $movie['poster'];

                $query = "SELECT ROUND(AVG(rating), 1) FROM rating WHERE movie_id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $average_rating = mysqli_fetch_assoc($result);
                ?>
                <div class="bg-gray-100 py-6 flex flex-col justify-center sm:py-12">

                    <div class="py-3 sm:max-w-xl sm:mx-auto">
                        <div class="bg-white shadow-lg border-gray-100 max-h-80	 border sm:rounded-2xl p-8 flex space-x-8">
                            <div class="h-48 overflow-visible w-1/2">
                                <a href="movie.php?id=<?php echo $id ?>">
                                    <img class="rounded-3xl shadow-lg" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($poster); ?>" alt="">
                                </a>
                            </div>
                            <div class="flex flex-col w-1/2 space-y-4">
                                <div class="flex justify-between items-start">
                                    <a href="movie.php?id=<?php echo $id ?>">
                                        <h2 class="text-3xl font-bold"><?php echo $title ?></h2>
                                    </a>
                                    <div class="bg-yellow-400 font-bold rounded-xl p-2">
                                        <?php if (isset($average_rating['ROUND(AVG(rating), 1)'])) {
                                            echo $average_rating['ROUND(AVG(rating), 1)'];
                                        } else {
                                            echo 'N/A';
                                        } ?>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-md text-gray-500"><?php echo $genre ?></div>
                                    <div class="text-lg text-gray-800"><?php echo $release_date ?></p></div>
                                </div>
                                <p class=" text-gray-400 max-h-60 overflow-scroll"><?php echo $description ?></p>
                            </div>

                        </div>
                    </div>

                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>