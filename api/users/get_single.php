<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->connect();

$user = new User($db);

$user->userId = isset($_GET['id']) ? $_GET['id'] : die();

$user->get_single();

$user_arr = array(
            'userId' => $user->userId,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'email' => $user->email,
            'password' => $user->password,
            'isAdmin' => $user->isAdmin
);

print_r(json_encode($user_arr));