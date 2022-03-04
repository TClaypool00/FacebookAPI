<?php
include '../../partial_files/get_single_headers.php';
include '../../partial_files/object_partial_files/new_post.php';
include '../../global_functions.php';

$post->post_id = set_id();

$post->get_single();

if ($post->body != null) {
    $post_arr = array(
        'postId' => $post->post_id,
        'body' => $post->body,
        'datePosted' => $post->date_posted,
        'userId' => $post->user_id,
        'firstName' => $post->user_firstname,
        'lastName' => $post->user_lastname
    );

    http_response_code(200);

    echo json_encode($post_arr);
} else {
    http_response_code(404);

    echo json_encode(array('message' => 'Post does not exist.'));
}