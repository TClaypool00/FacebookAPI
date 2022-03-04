<?php
include '../../partial_files/get_single_headers.php';
include '../../partial_files/object_partial_files/new_user.php';
include '../../global_functions.php';

$user->user_id = set_id();
$show_password = false;

if (get_isset('showPassword')) {
    $show_password = set_get_variable('showPassword');
}

$user->get_single($show_password);

if ($user->user_first_name != null) {
    $user_arr = array(
        'userId' => $user->user_id,
        'firstName' => $user->user_first_name,
        'lastName' => $user->user_last_name,
        'email' => $user->email,
        'password' => $user->password,
        'isAdmin' => $user->isAdmin
);

http_response_code(200);
print_r(json_encode($user_arr));
} else {
    http_response_code(404);
    echo custom_array('User does not exist');
}