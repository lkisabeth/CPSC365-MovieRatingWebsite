<?php
/** @var mysqli $admin
 * @var mysqli $user
 */
?>

<nav class="flex items-center justify-between flex-wrap bg-black p-6 fixed inset-x-0 z-10">
    <div class="flex items-center flex-shrink-0 text-white mr-6">
        <a href="home.php" class="font-semibold text-xl tracking-tight">Movie Ratings</a>
    </div>
    <div class="block lg:hidden">
        <button class="flex items-center px-3 py-2 border rounded text-white hover:border-white">
            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
        </button>
    </div>
    <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
        <div class="text-sm lg:flex-grow">
            <a href="recommended.php" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-gray-200 mr-4">
                Recommended
            </a>
        </div>
        <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            if ($admin == 1) { ?>
                <div>
                    <a href="admin.php" class="inline-block text-sm px-4 py-2 leading-none rounded text-white bg-green-500 hover:border-transparent hover:text-black hover:bg-green-600 mt-4 lg:mt-0 mr-4">Admin Dashboard</a>
                </div>
            <?php } ?>
            <div>
                <a href="user.php?id=<?php echo $user['id'] ?>" class="inline-block text-sm px-4 py-2 rounded leading-none text-white hover:border-transparent hover:text-black hover:bg-white mt-4 lg:mt-0 mr-4"><?php echo $_SESSION['username'] ?></a>
            </div>
            <div>
                <a href="util/authenticate.php?logout=true" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-black hover:bg-red-500 mt-4 lg:mt-0 mr-4">Log Out</a>
            </div>
        <?php } else { ?>
            <div>
                <a href="login.php" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-black hover:bg-white mt-4 lg:mt-0 mr-4">Login</a>
            </div>
            <div>
                <a href="register.php" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-black hover:bg-white mt-4 lg:mt-0">Signup</a>
            </div>
        <?php } ?>
    </div>
</nav>