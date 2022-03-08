<?php
include_once '../../partial_files/create_headers.php';
include '../../partial_files/object_partial_files/new_reply.php';
include '../../global_functions.php';

$user_checked = get_isset('userId');
$comment_checked = get_isset('commentId');

if ($user_checked) {
    $reply->user_id = set_get_variable('userId');
}

if ($comment_checked) {
    $reply->comment_id = set_get_variable('commentId');
}

$all_replies = $reply->get_all($comment_checked, $user_checked);
$num = $all_replies->rowCount();

if ($num > 0) {
    $replies_array = array();

    while ($row = $all_replies->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $reply_item = array(
            'replyId' => $ReplyId,
            'replyBody' => $ReplyBody,
            'datePosted' => $DatePosted,
            'userId' => $UserId,
            'firstName' => $FirstName,
            'lastName' => $LastName
        );

        array_push($replies_array, $reply_item);
    }

    http_response_code(200);
    echo json_encode($replies_array);
} else {
    http_response_code(404);
    echo custom_array('No replies found.');
}