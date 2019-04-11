<?php

include "../models/ExclusivetyRepository.php";

$config = include("../db/config.php");
$db = new PDO($config["db"], $config["username"], $config["password"]);
$exlusiverties = new ExclusivetyRepository($db);


switch($_SERVER["REQUEST_METHOD"]) {
    case "GET"://get with filter options
        $result = $exlusiverties->getAll(array(
            "location_id" => $_GET["location_id"],
            "blocked_location_id" => $_GET["blocked_location_id"],
            "rule_active" => $_GET["rule_active"]
        ));
        break;

    case "POST":
        $result = $locations->insert(array(
            "location_id" => $_POST["location_id"],
            "blocked_location_id" => $_POST["blocked_location_id"],            
            "rule_active" => $_POST["rule_active"]
        ));
        break;

    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);

        $result = $locations->update(array(
          "location_id" => $_PUT["location_id"],
            "blocked_location_id" => $_PUT["blocked_location_id"],            
            "rule_active" => $_PUT["rule_active"]
        ));
        break;

    case "DELETE":
        parse_str(file_get_contents("php://input"), $_DELETE);

        $result = $locations->remove(intval($_DELETE["id"]));
        break;
}


header("Content-Type: application/json");
echo json_encode($result);

?>
