<?php
include_once '../../models/BaseClass.php';
include_once '../../models/Comment.php';
include_once '../../config/Database.php';

$database = new Database();
$db = $database->connect();

$comment = new Comment($db);