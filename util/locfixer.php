<?php

include "../models/LocationRepository.php";

// Change this to your connection info.
$config = include("../db/config.php");
$db = new PDO($config["db"], $config["username"], $config["password"]);
$locations = new LocationRepository($db);



if ( isset($_POST['limit']) ) {
	$result = $locations->addMissingLatLong($_POST["limit"]);
	
	if($result){
		echo $result ." updates gedaan";
	}else{
		
		echo ("Geen resultaat");
	}
}