<?php
$auth_data = file_get_contents("secrets.json", true);
$auth = json_decode($auth_data);
$mysql = $auth->mysql;
$dsn = $mysql->dsn;
$user = $mysql->user;
$password = $mysql->password;

// Connect to CloudSQL from App Engine.
$db = new PDO ($dsn, $user, $password);
?>
