<!DOCTYPE html>
<html lang="en-us">

<?php require 'util/session_manager.php' /** @var mysqli $conn */ ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

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

<div class="flex flex-col items-center justify-center pt-20">
    <h1 class="black text-black text-xl font-bold m-6">Add a Movie</h1>

    <p class="text-center text-red-500"> <?php if (isset($_SESSION['error'])) { echo $_SESSION['error']; $_SESSION['error'] = ''; } ?> </p>

    <form action="util/add_movie.php" method="post" enctype="multipart/form-data" class="w-full max-w-3xl bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label for="title" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                    Title
                </label>
                <input type="text" name="title" id="title" placeholder="Citizen Kane" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
            </div>

            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label for="release_date" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                    Release Date
                </label>
                <input type="date" name="release_date" id="release_date" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label for="description" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                    Description
                </label>
                <input type="text" name="description" id="description" placeholder="Give a short synopsis of the film." class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label for="genre" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                    Genre
                </label>
                <div class="relative">
                    <select name="genre" id="genre" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                        <option>Action</option>
                        <option>Adventure</option>
                        <option>Comedy</option>
                        <option>Crime</option>
                        <option>Drama</option>
                        <option>Documentary</option>
                        <option>Fantasy</option>
                        <option>Horror</option>
                        <option>Musical</option>
                        <option>Mystery</option>
                        <option>Romance</option>
                        <option>Romantic Comedy</option>
                        <option>Sci-fi</option>
                        <option>Thriller</option>
                        <option>Western</option>
                        <option>War</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label for="poster" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                    Poster
                </label>
                <input type="file" name="poster" id="poster" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
            </div>
        </div>

        <div class="flex items-center justify-center mt-6">
            <input type="submit" name="movie" id="submit" value="Add Movie" class="submit rounded bg-black text-white font-bold text-lg hover:bg-gray-700 p-2 mt-8">
        </div>
    </form>
</div>

</body>
</html>