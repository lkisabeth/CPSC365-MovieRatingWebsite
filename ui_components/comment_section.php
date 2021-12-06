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

    <div class="bg-white rounded shadow-lg p-8 m-2">
        <div class="flex justify-between mb-1">
            <p class="text-grey-darkest leading-normal text-lg"><?php echo $comment_text ?></p>
        </div>
        <div class="text-grey-dark leading-normal text-sm w-2/3">
            <p> <a href="../user.php?id=<?php echo $commenter['id'] ?>"><?php echo $commenter['username'] ?></a>
                <span class="mx-1 text-xs">&bull;</span>
                <?php echo $date ?>
                <button type="submit" id="add_friend" onclick="addFriend(<?php echo $user['id']?>, <?php echo $commenter['id']?>)" class="flex items-center justify-center bg-green-500 hover:bg-green-700 text-white font-bold rounded py-1 px-2">Add Friend</button>
            </p>
        </div>
        <div class="right w-1/3">
            <span class="text-sm text-gray-500">Likes: <span id="likes_count"><?php echo $likes_count ?></span></span>
            <button type="submit" id="like" onclick="likeComment(<?php echo $comment_id; ?>, <?php echo $user['id']; ?>)" class="flex items-center justify-center bg-blue-500 hover:bg-blue-700 text-white font-bold rounded py-1 px-2">Like</button>
        </div>
    </div>

<?php } ?>