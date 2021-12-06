<!DOCTYPE html>
<html lang="en">

<?php require 'util/session_manager.php';
/** @var mysqli $conn */
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Profile</title>

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

<?php
$user_id = $_GET['id'];
$query = "SELECT * FROM user WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

$username = $user['username'];

$query = "SELECT * FROM rating WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$rating = mysqli_fetch_assoc($result);
?>

<div class="max-w-4xl flex items-center h-auto lg:h-screen flex-wrap mx-auto my-32 lg:my-0">

    <!--Main Col-->
    <div id="profile" class="w-full lg:w-3/5 rounded-lg lg:rounded-l-lg lg:rounded-r-none shadow-2xl bg-white opacity-75 mx-6 lg:mx-0">

        <div class="p-4 md:p-12 text-center lg:text-left">
            <!-- Image for mobile view-->
            <div class="block lg:hidden rounded-full shadow-xl mx-auto -mt-16 h-48 w-48 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1517423440428-a5a00ad493e8?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2683&q=80')"></div>

            <h1 class="text-3xl font-bold pt-8 lg:pt-0"><?php echo $username ?></h1>
            <div class="mx-auto lg:mx-0 w-4/5 pt-3 border-b-2 border-green-500 opacity-25"></div>
            <p class="pt-8 text-sm">I'm just like a really cool dog and I want you to know that your love for me is completely justified...</p>

            <div class="pt-12 pb-8">
                <button type="submit" id="add_friend" onclick="addFriend(<?php echo $user['id'] ?>, <?php echo $user_id ?>)" class="bg-green-700 hover:bg-green-900 text-white font-bold py-2 px-4 rounded-full">
                    Add as Friend
                </button>
            </div>

        </div>

    </div>

    <!--Img Col-->
    <div class="w-full lg:w-2/5">
        <!-- Big profile image for side bar (desktop) -->
        <img src="https://images.unsplash.com/photo-1517423440428-a5a00ad493e8?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2683&q=80" class="rounded-none lg:rounded-lg shadow-2xl hidden lg:block" alt="profile picture">

    </div>

</div>

<?php
$query = "SELECT * FROM movie, rating WHERE movie.id = rating.movie_id AND rating.user_id = ? ORDER BY id ASC LIMIT 10";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i",$user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$movies = mysqli_fetch_all($result, MYSQLI_ASSOC);
foreach ($movies as $movie) {
    $id = $movie['id'];
    $title = $movie['title'];
    $release_date = date("F j, Y", strtotime($movie['release_date']));
    $description = $movie['description'];
    $genre = $movie['genre'];
    $poster = $movie['poster'];

    $query = "SELECT rating FROM rating WHERE movie_id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rating = mysqli_fetch_assoc($result);
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
                        <div class="bg-yellow-400 font-bold rounded-xl p-2"><?php if (isset($rating)) { echo $rating['rating']; } else { echo 'N/A'; } ?></div>
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

</body>

</html>