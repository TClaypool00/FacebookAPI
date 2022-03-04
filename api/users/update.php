<?php
include "../../partial_files/update_headers.php";
include '../../partial_files/object_partial_files/new_user.php';

$user->userId = set_id();
$user->first_name = $data->first_name;
$user->last_name = $data->last_name;
$user->email = $data->email;
$user->isAdmin = $data->isAdmin;

if ($user->update()) {
    echo custom_array('User has been updated');
} else {
    echo custom_array('Could not update use');
}
