<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->connect();

$user = new User($db);

$result = $user->getAll();
$num = $result->rowCount();

if ($num > 0) {
    $user_arr = array();
    $user_arr['users'] = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $user_item = array(
            'userId' => $userId,
            'firstName' => $first_name,
            'lastName' => $last_name,
            'email' => $email,
            'password' => $password,
            'isAdmin' => $isAdmin
        );

        array_push($user_arr['users'], $user_item);
    }

    echo json_encode($user_arr);
} else {
    echo json_encode(
        array('message' => 'No users found')
    );
}