<?php
include "../models/UserRepository.php";

session_start();
// Change this to your connection info.
$config = include("../db/config.php");
$db = new PDO($config["db"], $config["username"], $config["password"]);
$users = new UserRepository($db);
// Try and connect using the info above.

if ( isset($_POST['username'], $_POST['password']) ) {
	if($users->insert(array('username'=>$_POST['username'],'password'=>password_hash($_POST['password'], PASSWORD_DEFAULT)))){
		$message = 'Na activatie door admin kan je inloggen met de door jou gekozen gegevens';
		echo $message;
	}else{
		header('HTTP/1.1 500 Username reeds in gebruik');
		header('Content-Type: application/json; charset=UTF-8');
		echo (json_encode(array('message' => 'User or password wrong', 'code' => 1337)));
	}
}