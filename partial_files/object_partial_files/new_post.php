<?php
include_once "../../models/Post.php";
include_once "../../config/Database.php";

$database = new Database();
$db = $database->connect();

$post = new Post($db);