<?php
include "User.php";
class UserRepository {

	protected $db;

	public function __construct(PDO $db) {
		$this->db = $db;
	}
	private function read($row) {
		$result = new User();
		$result->id = $row["id"];
		$result->username = $row["username"];
		$result->password = $row["password"];
		$result->active = $row["active"];
	
		return $result;
	}
	//return error if any
	public function verifyUser($user,$password){
		$found = $this->getByName($user);		
		if (isset($found) && !empty($found) ) {
			// Account exists, now we verify the password.
			// Note: remember to use password_hash in your registration file to store the hashed passwords.
			$stored_secret= $found->password;
			if (password_verify($password, $stored_secret))
			{
				if($found->active){
					// Verification success! User has loggedin!
					// Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
					session_regenerate_id();
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['name'] = $found->username;
					$_SESSION['id'] = $found->id;
					return false;
				}else{
					return "Gebruiker niet actief, contacteer de admin.";
				}
			}else{
				return "Paswoord foutief";
			}
		}
		return "Username niet gevonden";
		
	}
	public function getByName($username){
		$found=false;
		$sql = "SELECT id,username, password, active FROM user WHERE username = :user";
		$q = $this->db->prepare($sql);
		$q->bindParam(":user", $username);
		$q->execute();
		$rows = $q->fetchAll();
		if(count($rows)>0)
			$found= $this->read($rows[0]);
		return $found;
	}
	public function insert($data) {
		try{
		$found = $this->getByName($data["username"]);
		if (empty($found) ) {
			$sql = "INSERT INTO user ( username, password)
	        		VALUES ( :username, :password )";
			$q = $this->db->prepare($sql);
			$q->bindParam(":username", $data["username"]);
			$q->bindParam(":password", $data["password"]);
			 
			$q->execute();
			return true;
		}else{
			return false;
		}
		}catch(Exception $i){
			$i;
		}
		
	}
}
