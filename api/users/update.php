<?php
include "../../partial_files/update_headers.php";
include '../../partial_files/object_partial_files/new_user.php';

$user->userId = isset($_GET['id']) ? $_GET['id'] : die();
$user->first_name = $data->first_name;
$user->last_name = $data->last_name;
$user->email = $data->email;
$user->password = $data->password;
$user->isAdmin = $data->isAdmin;

if ($user->update()) {
    echo json_encode(
        array('message' => 'User updated')
    );
} else {
    echo json_encode(
        array('message' => 'User not updated')
    );
}
