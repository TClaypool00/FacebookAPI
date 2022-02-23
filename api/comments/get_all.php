<?php
include '../../partial_files/get_all_headeres.php';
include '../../partial_files/object_partial_files/new_comment.php';
include '../../global_functions.php';

$user_checked = get_isset('userId');
$post_checked = get_isset('postId');

if($user_checked) {
    $comment->user_id = set_get_variable('userId');
}

if ($post_checked) {
    $comment->post_id = set_get_variable('postId');
}

$all_comments =  $comment->get_all($user_checked, $post_checked);
$num = $all_comments->rowCount();

if ($num > 0) {
    $comments_array = array();

    while ($row = $all_comments->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $comment_item = array(
            'commentId' => $CommentId,
            'commentBody' => $CommentBody,
            'datePosted' => $DatePosted,
            'postId' => $PostId,
            'userId' => $UserId,
            'userFirstName'=> $FirstName,
            'userLastName' => $LastName
        );

        array_push($comments_array, $comment_item);
    }

    http_response_code(200);
    echo display_list($comments_array);
} else {
    http_response_code(404);
    echo custom_array('No comments found.');
}