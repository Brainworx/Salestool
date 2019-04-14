<?php
include "../models/UserRepository.php";

session_start();
// Change this to your connection info.
$config = include("../db/config.php");
$db = new PDO($config["db"], $config["username"], $config["password"]);
$users = new UserRepository($db);
// Try and connect using the info above.

if ( isset($_POST['username'], $_POST['password']) ) {
	$error = $users->verifyUser($_POST['username'], $_POST['password']);
	if(empty($error)){
		header('Content-Type: application/json');
		echo (json_encode(array('message' => 'User verified')));
	}else{
		header('HTTP/1.1 500 '.$error);
		header('Content-Type: application/json; charset=UTF-8');
		echo (json_encode(array('message' => 'User or password wrong', 'code' => 1337)));
	}
}