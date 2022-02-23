<?php
include '../../partial_files/get_single_headers.php';
include '../../partial_files/object_partial_files/new_friend.php';
include '../../global_functions.php';

if (get_isset('id')) {
    $friend->friend_id = set_get_variable('id');
} else if (get_isset('senderId') && (get_isset('receiverId'))) {
    $friend->sender_id = set_get_variable('senderId');
    $friend->receiver_id = set_get_variable('receiverId');
} else {
    echo custom_array('id cannot be empty');
    die();
}

$friend->get_single();

if ($friend->sender_id != null) {
    $friend_array = array(
        'friendId' => $friend->friend_id,
        'senderId' => $friend->sender_id,
        'senderFirstName' => $friend->sender_frist_name,
        'senderLastName' => $friend->sender_last_name,
        'receiverId' => $friend->receiver_id,
        'receiverFirstName' => $friend->receiver_first_name,
        'receiverLastName' => $friend->receiver_last_name,
        'isAccepted' => $friend->is_accepted,
        'dateAccepted' => checks_date_is_null($friend->date_accepted)
    );

    http_response_code(200);
    echo json_encode($friend_array);
} else {
    http_response_code(404);
    echo custom_array('Friend not found.');
}