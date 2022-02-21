<?php
include_once '../../models/BaseClass.php';
include_once '../../models/Friend.php';
include_once '../../config/Database.php';

$database = new Database();
$db = $database->connect();

$friend = new Friend($db);