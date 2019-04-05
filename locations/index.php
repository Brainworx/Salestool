<?php

include "../models/LocationRepository.php";

$config = include("../db/config.php");
$db = new PDO($config["db"], $config["username"], $config["password"]);
$locations = new LocationRepository($db);


switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $result = $locations->getAll(array(
            "name" => $_GET["name"],
            "apbnumber" => $_GET["apbnumber"],
            "zipcode" => $_GET["zipcode"],
            "state" => $_GET["state"]
            /*
             *  "lattitude" => $_GET["lattitude"],
            "longitude" => $_GET["longitude"],
            "address" => $_GET["address"],
            "create_dt" => $_GET["create_dt"],
            "update_dt" => $_GET["update_dt"]
            "city" => $_GET["city"],
            "country" => $_GET["country"],
            "phone" => $_GET["phone"],
            "email" => $_GET["email"],
            "website" => $_GET["website"],
             */
        ));
        break;

    case "POST":
        $result = $locations->insert(array(
            "name" => $_POST["name"],
            "apbnumber" => $_POST["apbnumber"],            
            "address" => $_POST["address"],
            "zipcode" => $_POST["zipcode"],
            "city" => $_POST["city"],
            "country" => $_POST["country"],
            "state" => $_POST["state"]
            

//             "phone" => $_POST["phone"],
//             "email" => $_POST["email"],
//             "website" => $_POST["website"],
//             "lattitude" => $_POST["lattitude"],
//             "longitude" => $_POST["longitude"],
//             "create_dt" => $_POST["create_dt"],
//             "update_dt" => $_POST["update_dt"]
        ));
        break;

    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);

        $result = $locations->update(array(
            "id" => intval($_PUT["id"]),
            "name" => $_PUT["name"],
            "apbnumber" => $_PUT["apbnumber"],
            "lattitude" => $_PUT["lattitude"],
            "longitude" => $_PUT["longitude"],
            "address" => $_PUT["address"],
            "zipcode" => $_PUT["zipcode"],
            "city" => $_PUT["city"],
            "country" => $_PUT["country"],
            "phone" => $_PUT["phone"],
            "email" => $_PUT["email"],
            "website" => $_PUT["website"],
            "state" => $_PUT["state"],
            "create_dt" => $_PUT["create_dt"],
            "update_dt" => $_PUT["update_dt"]
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
