<?php
/** @var mysqli $movies */

foreach ($movies as $movie) {
    $id = $movie['id'];
    $title = $movie['title'];
    $release_date = date("F j, Y", strtotime($movie['release_date']));
    $description = $movie['description'];
    $genre = $movie['genre'];
    $poster = $movie['poster'];
    $average_rating = $movie['avg_rating'];
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
                            <?php if (isset($average_rating)) {
                                echo $average_rating;
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