<?php
include '../../partial_files/update_headers.php';
include '../../partial_files/object_partial_files/new_post.php';
include '../../global_functions.php';

$post->post_id = set_id();
$post->body = $data->body;
$post->user_id = $data->user_id;

if ($post->update()) {
    http_response_code(200);

    echo custom_array('Post has been updated');
} else {
    http_response_code(400);

    echo custom_array('Post could not be updated');
}