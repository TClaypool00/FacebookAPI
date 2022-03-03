<?php
include '../../partial_files/get_all_headeres.php';
include '../../partial_files/object_partial_files/new_comment.php';
include '../../global_functions.php';

$comment->comment_id = set_id();
$comment->get_single();

if ($comment->comment_body != null) {
    $comment_array = array(
        'comentId' => $comment->comment_id,
        'commentBody' => $comment->comment_body,
        'datePosted' => $comment->date_posted,
        'postId' => $comment->post_id,
        'userId' => $comment->user_id,
        'firstName' => $comment->user_first_name,
        'lastName' => $comment->user_last_name
    );

    http_response_code(200);
    echo display_list($comment_array);
} else {
    http_response_code(404);
    echo custom_array('no comment was found.');
}