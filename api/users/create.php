<?php
include '../../partial_files/create_headers.php';
include '../../partial_files/object_partial_files/new_user.php';
include '../../global_functions.php';

$user->user_first_name = $data->firstName;
$user->user_last_name = $data->lastName;
$user->email = $data->email;
$user->password = $data->password;
$user->confirm_password = $data->confirmPassword;

if (!$user->password_confirm()) {
    http_response_code(400);
    echo custom_array('passwords do not match');
    die();
}

if (!$user->password_meets()) {
    http_response_code(400);
    echo custom_array('Password does not meet the minimum requirements');
    die();
}

if ($user->create()) {
    http_response_code(201);
    echo custom_array('user has been created');
} else {
    http_response_code(400);
    echo custom_array('user could be created');
}
