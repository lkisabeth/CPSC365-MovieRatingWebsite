<!DOCTYPE html>
<html lang="en-us">
<?php session_start(); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

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

<div class="w-full flex flex-wrap">

    <!-- Register Section -->
    <div class="w-full md:w-1/2 flex flex-col">

        <div class="flex justify-center md:justify-start pt-12 md:pl-12 md:-mb-12">
            <a href="home.php" class="rounded bg-black text-white font-bold text-xl p-4" alt="Movie Ratings Logo">Movie Ratings</a>
        </div>

        <div class="flex flex-col justify-center md:justify-start my-auto pt-8 md:pt-0 px-8 md:px-24 lg:px-32">
            <p class="text-center text-3xl">Create an account.</p>

            <p class="text-center text-red-500"> <?php if (isset($_SESSION['error'])) { echo $_SESSION['error']; $_SESSION['error'] = ''; } ?> </p>

            <form class="flex flex-col pt-3 md:pt-8" action="util/authenticate.php" method="post">
                <div class="flex flex-col pt-4">
                    <label for="username" class="text-lg">Username</label>
                    <input type="text" name="username" id="username" placeholder="Username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline" required/>
                </div>

                <div class="flex flex-col pt-4">
                    <label for="email" class="text-lg">Email</label>
                    <input type="email" name="email" id="email" placeholder="your@email.com" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline" required/>
                </div>

                <div class="flex flex-col pt-4">
                    <label for="password" class="text-lg">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" onchange='check_pass();' class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline" required/>
                </div>

                <div class="flex flex-col pt-4">
                    <label for="confirm_password" class="text-lg">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Password" onchange='check_pass();' class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline" required/>
                </div>

                <div class="flex flex-col pt-4">
                    <label for="admin" class="text-sm">Admin?</label>
                    <span><input type="checkbox" name="admin" id="admin" required/></span>
                </div>

                <input type="submit" name="register" value="Register" id="submit" class="rounded bg-black text-white font-bold text-lg hover:bg-gray-800 p-2 mt-8" disabled/>
            </form>
            <div class="text-center pt-12 pb-12">
                <p>Already have an account? <a href="login.php" class="underline font-semibold">Log in here.</a></p>
            </div>
        </div>

    </div>

    <!-- Image Section -->
    <div class="w-1/2 shadow-2xl">
        <img class="object-cover w-full h-screen hidden md:block" src="https://images.unsplash.com/photo-1626814026160-2237a95fc5a0?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2670&q=80" alt="Background" />
    </div>
</div>

</body>
</html>