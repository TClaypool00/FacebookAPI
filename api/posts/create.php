<?php
include '../../partial_files/create_headers.php';
include '../../partial_files/object_partial_files/new_post.php';

$data = json_decode(file_get_contents('php://input'));

$post->body = $data->body;
$post->user_id = $data->user_id;

if ($post->create()) {
    http_response_code(201);

    echo json_encode(array('message' => 'Post has been added'));
} else {
    http_response_code(400);

    echo json_encode(array('message' => 'Post has not been added'));
}