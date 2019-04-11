<?php

include "Exclusivety.php";

class ExclusivetyRepository {

    protected $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function read($row) {
        $result = new Exclusivety();
        $result->id = $row["id"];
        $result->location_id =$row["location_id"];
        $result->blocked_location_id =$row["blocked_location_id"];
        $result->rule_active =$row["rule_active"];
        $result->create_dt = $row["create_dt"];
        $result->update_dt = $row["update_dt"];
        
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM exclusivety WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getAll($filter) {
        $location_id = "%" . $filter["location_id"] . "%";
        $blocked_location_id = "%" . $filter["blocked_location_id"] . "%";
        if(isset($filter["rule_active"]))
        	$rule_active = $filter["rule_active"];

        $sql = "SELECT * FROM exclusivety";
        $and = 0;
        if(!empty($location_id) || !empty($blocked_location_id) || !empty($rule_active)){
            $sql += " WHERE ";
        }
        if(!empty($location_id) ){
            $sql += "location_id = :location_id ";
            $and = 1;
        }
        if(!empty($location_id) || !empty($blocked_location_id) || !empty($rule_active)){
            if($and == 1){
                $sql += " AND ";
            }
            else{
                $and = 1;
            }
            $sql += "blocked_location_id = :blocked_location_id ";
        }
        if(!empty($rule_active)){
            if($and == 1)
                $sql += " AND ";
        	$sql += "rule_active = ".$rule_active;
        }
        $q = $this->db->prepare($sql);
         $q->bindParam(":location_id", $location_id);
         $q->bindParam(":blocked_location_id", $blocked_location_id);
         $q->bindParam(":rule_active", $rule_active);
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
    	$sql = "INSERT INTO exclusivety ( location_id, blocked_location_id)
        		VALUES ( :location_id, :blocked_location_id)";
    	$q = $this->db->prepare($sql);
   		$q->bindParam(":location_id", $data["location_id"], PDO::PARAM_INT);
   		$q->bindParam(":blocked_location_id", $data["blocked_location_id"], PDO::PARAM_INT);
    	
        $q->execute();
    	
        return $this->getById($this->db->lastInsertId());
    }

    public function update($data) {
        $sql = "UPDATE exclusivety SET location_id = :location_id, blocked_location_id = :blocked_location_id, rule_active = :rule_active";
        $q = $this->db->prepare($sql);
        $q->bindParam(":location_id", $data["location_id"], PDO::PARAM_INT);
        $q->bindParam(":blocked_location_id", $data["blocked_location_id"], PDO::PARAM_INT);
        $q->bindParam(":rule_active", $data["rule_active"], PDO::PARAM_INT);
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM exclusivety WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
    }

}

?>
