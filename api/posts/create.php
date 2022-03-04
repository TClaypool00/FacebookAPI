<?php
include '../../partial_files/create_headers.php';
include '../../partial_files/object_partial_files/new_post.php';
include '../../global_functions.php';

$post->body = $data->body;
$post->user_id = $data->user_id;

if ($post->create()) {
    http_response_code(201);

    echo custom_array('Post has been created');
} else {
    http_response_code(400);

    echo custom_array('Post could not be added');
}