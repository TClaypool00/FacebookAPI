<?php
include_once '../../models/BaseClass.php';
include_once '../../models/Reply.php';
include_once '../../config/Database.php';

$database = new Database();
$db = $database->connect();

$reply = new Reply($db);