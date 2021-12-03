<?php
/** @var mysqli $conn
 * @var $comments
 * @var $user
 * @var $movie_id
 */

foreach ($comments as $comment) {
    $comment_id = $comment['id'];
    $commenter_id = $comment['user_id'];
    $comment_text = $comment['comment'];
    $date = date("F j, Y", strtotime($comment['created_at']));

    $query = "SELECT * FROM user WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $commenter_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $commenter = mysqli_fetch_assoc($result);

    $query = "SELECT * FROM likes WHERE comment_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $comment_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $likes_count = mysqli_num_rows($result);
    ?>

    <div class="bg-white rounded shadow-lg min-w-full p-8 m-2">
        <div class="flex justify-between mb-1">
            <p class="text-grey-darkest leading-normal text-lg"><?php echo $comment_text ?></p>
        </div>
        <div class="text-grey-dark leading-normal text-sm">
            <p> <a href="user.php?id=<?php echo $commenter['id'] ?>"><?php echo $commenter['username'] ?></a>
                <span class="mx-1 text-xs">&bull;</span>
                <?php echo $date ?>
            <form action="util/add_friend.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>">
                <input type="hidden" name="friend_id" value="<?php echo $commenter['id'] ?>">
                <input type="hidden" name="status" value="0">
                <input type="hidden" name="movie_id" value="<?php echo $movie_id ?>">
                <button type="submit">Add Friend</button>
            </form>
            </p>
        </div>
        <div class="flex flex-col items-center">
            <p class="text-sm text-gray-500"><?php echo $likes_count ?> <span class="text-sm text-gray-500">Likes</span></p>
        </div>
        <form action="util/like.php" method="post">
            <input type="hidden" name="comment_id" value="<?php echo $comment_id ?>">
            <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>">
            <input type="hidden" name="movie_id" value="<?php echo $movie_id ?>">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-1 rounded">Like</button>
        </form>
    </div>

<?php } ?>