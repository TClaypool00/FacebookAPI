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
    echo json_encode(
        array('message' => 'No users found')
    );
}