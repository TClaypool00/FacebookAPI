<?php
include '../../partial_files/create_headers.php';
include '../../partial_files/object_partial_files/new_friend.php';

$friend->sender_id = $data->senderId;
$friend->receiver_id = $data->receiverId;

if ($friend->create()) {
    http_response_code(201);

    echo json_encode(array('message' => 'Friend request has been sent'));
} else {
    http_response_code(400);

    echo json_encode(array('message' => 'Friend request could not be sent'));
}