<?php

include "Location.php";

class LocationRepository {

    protected $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function read($row) {
        $result = new Location();
        $result->id = $row["id"];
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
        $result->state = $row["state"];
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
        	$sql += " AND state = ".$state;
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
        $sql = "INSERT INTO location ( name, apbnumber, address, zipcode, city, phone, email, website) 
        		VALUES ( :name, :apbnumber,  :address, :zipcode, :city, :phone, :email, :website)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":name", $data["name"]);
        $q->bindParam(":apbnumber", $data["apbnumber"]);
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
    }

    public function remove($id) {
        $sql = "DELETE FROM location WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
    }

}

?>