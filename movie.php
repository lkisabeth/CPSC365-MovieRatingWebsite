<!DOCTYPE html>
<html lang="en-us">

<?php require 'util/session_manager.php';
/** @var mysqli $conn */
global $conn;
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details</title>

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
$movie_id = $_GET['id'];
$query = "SELECT * FROM movie WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $movie_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$movie = mysqli_fetch_assoc($result);

$title = $movie['title'];
$release_date = date("F j, Y", strtotime($movie['release_date']));
$description = $movie['description'];
$genre = $movie['genre'];
$poster = $movie['poster'];

$query = "SELECT * FROM rating WHERE movie_id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $movie_id, $user['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$rating = mysqli_fetch_assoc($result);

if ($rating) {
    $rating_value = $rating['rating'];
} else {
    $rating_value = 0;
}
?>
<div class="bg-gray-100 py-6 flex flex-col justify-center sm:py-12">

    <div class="py-3 sm:max-w-xl sm:mx-auto">
        <div class="bg-white shadow-lg border-gray-100 max-h-80	 border sm:rounded-2xl p-8 flex space-x-8">
            <div class="h-48 overflow-visible w-1/2">
                <img class="rounded-3xl shadow-lg" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($poster); ?>" alt="">
            </div>
            <div class="flex flex-col w-1/2 space-y-4">
                <div class="flex justify-between items-start">
                    <h2 class="text-3xl font-bold"><?php echo $title ?></h2>
                    <div class="bg-yellow-400 font-bold rounded-xl p-2"><?php echo $rating_value ?></div>
                </div>
                <div class="flex flex-col justify-center">
                    <form action="util/rate.php" method="post">
                        <input type="hidden" name="movie_id" value="<?php echo $movie_id ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>">
                        <input type="hidden" name="rating" value="<?php echo $rating_value ?>">
                        <div class="flex justify-center">
                            <input type="radio" name="rating" value="1" <?php if ($rating_value == 1) { echo "checked"; } ?>>
                            <label class="text-gray-600">1</label>
                            <input type="radio" name="rating" value="2" <?php if ($rating_value == 2) { echo "checked"; } ?>>
                            <label class="text-gray-600">2</label>
                            <input type="radio" name="rating" value="3" <?php if ($rating_value == 3) { echo "checked"; } ?>>
                            <label class="text-gray-600">3</label>
                            <input type="radio" name="rating" value="4" <?php if ($rating_value == 4) { echo "checked"; } ?>>
                            <label class="text-gray-600">4</label>
                            <input type="radio" name="rating" value="5" <?php if ($rating_value == 5) { echo "checked"; } ?>>
                            <label class="text-gray-600">5</label>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold rounded">Rate</button>
                        </div>
                    </form>
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

<div class="container mx-auto px-4">
    <div class="flex flex-col items-center">

        <div class="flex mx-auto items-center justify-center shadow-lg mx-8 mb-4 max-w-lg rounded">
            <form action="util/comment.php" method="post" class="w-full max-w-xl bg-white rounded-lg px-4 pt-2">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <h2 class="px-4 pt-3 pb-2 text-gray-800 text-lg">Add a new comment</h2>
                    <div class="w-full md:w-full px-3 mb-2 mt-2">
                        <textarea name="comment" placeholder='Type Your Comment' class="bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white" required></textarea>
                    </div>
                    <div class="w-full md:w-full flex items-start md:w-full px-3">
                        <input type="hidden" name="movie_id" value="<?php echo $movie_id ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>">
                        <input type='submit' class="bg-black text-white font-medium py-1 px-4 rounded tracking-wide mr-1 hover:bg-gray-700" value='Post Comment'>
                    </div>
                </div>
            </form>
        </div>

        <div class="flex flex-col items-center">
            <h1 class="text-4xl font-bold text-center">Comments</h1>
        </div>

        <div class="flex flex-col items-center">
            <?php
            $query = "SELECT * FROM comment WHERE movie_id = ? ORDER BY id DESC LIMIT 10";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $movie_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
            require 'ui_components/comment_section.php'
            ?>
        </div>

    </div>
</div>

</body>
</html>
