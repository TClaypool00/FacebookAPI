<?php
include '../../partial_files/get_all_headeres.php';
include '../../partial_files/object_partial_files/new_friend.php';
include '../../global_functions.php';

if(get_isset('senderId')) {
    $friend->sender_id = set_get_variable('senderId');
}

if (get_isset('receiverId')) {
    $friend->receiver_id = set_get_variable('receiverId');
}

if (get_isset('isAccpted')) {
    $friend->is_accepted = set_get_variable('isAccpted');
}

if (get_isset('dateAccpted')) {
    $friend->date_accepted = set_get_variable('dateAccpted');
}

$all_friends = $friend->get_all();
$num = $all_friends->rowCount();

if ($num > 0) {
    $friend_array = array();

    while($row = $all_friends->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $friend_item = array(
            'friendId' => $FriendId,
            'senderId' => $SenderId,
            'senderFirstName' => $SenderFirstName,
            'senderLastName' => $SenderLastName,
            'receiverId' => $ReceiverId,
            'receiverFirstName' => $ReceiverFirstName,
            'receiverLastName' => $ReceiverLastName,
            'isAccepted' => $IsAccepted,
            'dateAccepted' => checks_date_is_null($DateAccepted)
        );

        array_push($friend_array, $friend_item);
    }

    http_response_code(200);
    echo json_encode($friend_array);
} else {
    http_response_code(404);
    echo custom_array('No firend(s) found.');
}