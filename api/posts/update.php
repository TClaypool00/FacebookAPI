<?php
include '../../partial_files/update_headers.php';
include '../../partial_files/object_partial_files/new_post.php';

$post->post_id = isset($_GET['id']) ? $_GET['id'] : die();
$post->body = $data->body;
$post->user_id = $data->user_id;

if ($post->update()) {
    http_response_code(200);

    echo json_encode(array('message' => 'Post has been updated'));
} else {
    http_response_code(400);

    echo json_encode(array('message' => 'Post has not been updated'));
}