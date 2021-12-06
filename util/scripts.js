function check_pass() {
    if (document.getElementById('password').value ==
        document.getElementById('confirm_password').value) {
        document.getElementById('submit').disabled = false;
    } else {
        document.getElementById('submit').disabled = true;
    }
}

function likeComment(comment_id, user_id) {
    $.ajax({ url: "util/like.php",
        type: "POST",
        data: {
            comment_id: comment_id,
            user_id: user_id
        },
        success: function (data) {
            if (data == "liked") {
                $("#like").html("Unlike");
                $("#likes_count").html(parseInt($("#likes_count").html()) + 1);
            } else if (data == "unliked") {
                $("#like").html("Like");
                $("#likes_count").html(parseInt($("#likes_count").html()) - 1);
            }
        }
    });
}

function addFriend(user_id, friend_id) {
    $.ajax({ url: "util/friendship.php",
        type: "POST",
        data: {
            user_id: user_id,
            friend_id: friend_id,
        },
        success: function (data) {
            if (data == "friend request sent") {
                $("#add_friend").html("Request Sent");
                $("#add_friend").addClass("bg-gray-500 disabled");
            } else if (data == "already friends") {
                $("#add_friend").html("Already Friends");
                $("#add_friend").addClass("bg-gray-500 disabled");
            }
        }
    });
}

function acceptFriend(user_id, friend_id) {
    $.ajax({ url: "util/friendship.php",
        type: "POST",
        data: {
            user_id: user_id,
            friend_id: friend_id,
            accept_friend: true
        },
        success: function (data) {
            if (data == "friend request accepted") {
                $("#friend_request").remove();
            }
        }
    });
}

function removeFriend(user_id, friend_id) {
    $.ajax({ url: "util/friendship.php",
        type: "POST",
        data: {
            user_id: user_id,
            friend_id: friend_id,
            remove_friend: true
        },
        success: function (data) {
            if (data == "friendship removed") {
                $("#friend_request").remove();
            }
        }
    });
}

