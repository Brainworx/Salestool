<?php

include "Location.php";

class LocationRepository {

    protected $db;
    protected $config;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->config = include("../db/config.php");
    }

    private function read($row) {
        $result = new Location();
        $result->id = intval($row["id"]);
        $result->name = $row["name"];
        $result->apbnumber = $row["apbnumber"];
        $result->lattitude = $row["lattitude"];
        $result->longitude = $row["longitude"];
        $result->address = $row["address"];
        $result->zipcode = $row["zipcode"];
        $result->city = $row["city"];
        $result->country = $row["country"];
        $result->phone = $row["phone"];
        $result->email = $row["email"];
        $result->website = $row["website"];
        $result->state = intval($row["state"]);
        $result->create_dt = $row["create_dt"];
        $result->update_dt = $row["update_dt"];
        
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM location WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getAll($filter) {
        $name = "%" . $filter["name"] . "%";
        $apbnumber = "%" . $filter["apbnumber"] . "%";
        $zipcode = "%" . $filter["zipcode"] . "%";
        if(isset($filter["state"]))
        	$state = $filter["state"];

        $sql = "SELECT * FROM location WHERE name LIKE :name AND apbnumber LIKE :apbnumber AND zipcode like :zipcode";// AND state = :state";
        if(!empty($state)){
        	$sql .= " AND state = ".$state;
        }
        $q = $this->db->prepare($sql);
         $q->bindParam(":name", $name);
         $q->bindParam(":apbnumber", $apbnumber);
         $q->bindParam(":zipcode", $zipcode);
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
    	$data = $this->getLongLat($data);
    	$sql = "INSERT INTO location ( name, apbnumber,lattitude, longitude, address, zipcode, city, phone, email, website)
        		VALUES ( :name, :apbnumber, :lattitude, :longitude, :address, :zipcode, :city, :phone, :email, :website)";
    	$q = $this->db->prepare($sql);
   		$q->bindParam(":name", $data["name"]);
   		$q->bindParam(":apbnumber", $data["apbnumber"]);
   		$q->bindParam(":longitude", $data["longitude"], PDO::PARAM_INT);
   		$q->bindParam(":lattitude", $data["lattitude"], PDO::PARAM_INT);
   		$q->bindParam(":address", $data["address"]);
    	$q->bindParam(":zipcode", $data["zipcode"]);
   		$q->bindParam(":city", $data["city"]);
   		$q->bindParam(":phone", $data["phone"]);
   		$q->bindParam(":email", $data["email"]);
   		$q->bindParam(":website", $data["website"]);
    	
        $q->execute();
    	
        return $this->getById($this->db->lastInsertId());
    }

    public function update($data) {
    	if(empty($data["lattitude"])){
			$data = $this->getLongLat($data);
		}
        $sql = "UPDATE location SET name = :name, apbnumber = :apbnumber, lattitude = :lattitude, longitude = :longitude, address = :address,
        		zipcode = :zipcode, city = :city, phone = :phone, email = :email, website = :website, state = :state WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":name", $data["name"]);
        $q->bindParam(":apbnumber", $data["apbnumber"]);
        $q->bindParam(":lattitude", $data["lattitude"]);
        $q->bindParam(":longitude", $data["longitude"]);
        $q->bindParam(":address", $data["address"]);
        $q->bindParam(":zipcode", $data["zipcode"]);
        $q->bindParam(":city", $data["city"]);
        $q->bindParam(":phone", $data["phone"]);
        $q->bindParam(":email", $data["email"]);
        $q->bindParam(":website", $data["website"]);
        $q->bindParam(":state", $data["state"], PDO::PARAM_INT);
        $q->bindParam(":id", $data["id"], PDO::PARAM_INT);
        $q->execute();
        
        return $this->getById($data["id"]);
    }

    public function remove($id) {
        $sql = "DELETE FROM location WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
    }
    private function getLongLat($data){
    	$address   = urlencode($data['address'].', '.$data['zipcode'].' '.$data['city'].', '.$data['country']);
        $key       = $this->config["apikey"];
    	$url       = "https://maps.googleapis.com/maps/api/geocode/json?key={$key}&address={$address}";
    	$resp_json = file_get_contents($url);
    	$resp      = json_decode($resp_json, true);
    	
    	if ($resp['status'] == 'OK') {
    		// get the important data
    		$data["lattitude"] = $resp['results'][0]['geometry']['location']['lat'];
    		$data["longitude"] = $resp['results'][0]['geometry']['location']['lng'];  
    		return $data;  	
    	} else {
    		return false;
    	}	 
    }

}

?>
