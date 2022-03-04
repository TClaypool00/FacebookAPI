<?php
include '../../partial_files/get_all_headeres.php';
include '../../partial_files/object_partial_files/new_user.php';
include '../../global_functions.php';

$result = $user->getAll();
$num = $result->rowCount();

if ($num > 0) {
    $user_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $user_item = array(
            'userId' => $UserId,
            'firstName' => $FirstName,
            'lastName' => $LastName,
            'email' => $Email,
            'password' => $Password,
            'isAdmin' => $IsAdmin
        );

        array_push($user_arr, $user_item);
    }

    echo json_encode($user_arr);
} else {
    echo custom_array('No users found');
}