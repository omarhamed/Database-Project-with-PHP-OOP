<?php

require_once("config\config.php");


class Database{
	private $host = DB_HOST;
	private $user = DB_USER;
	private $pass = DB_PWD;
	private $db_name = DB_NAME;

	private $conncetion;
	private $error;
	private $stmt;
	private $dbconnceted = false;

	function __construct(){
		//Set PDO Connection
		$dsn = 'mysql:host=' . $this->host . ';dbname='. $this->db_name;
		$options = array(
					PDO::ATTR_PERSISTENT => true,
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
				);
		try {

			$this->conncetion = new PDO ($dsn, $this->user, $this->pass, $options);
			$this->dbconnceted = true;
			
		} catch (PDOException $e) {
			$this->error = $e->getMessage()."<br>";
			$this->dbconnceted = false;
		}
	}

	public function getError(){
		return $this->error;
	}

	public function isConnected(){
		return $this->dbconnceted;
	}

	//Prepare The statmenet with Query
	public function query($query){
		$this->stmt = $this->conncetion->prepare($query);
	}

	//Execute Prepare The prepared statmenet
	public function execute(){
		return $this->stmt->execute();
	}

	//Get results as a array of objects
	public function setResults(){
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_OBJ);
	}

	//Get results as a varaible
	// public function getResult(){
	// 	$this->stmt->execute();
	// 	while ($row = $this->stmt->fetch()) {
	// 		echo "ID: ".$row['id']."<br>";
	// 		echo "Name: ".$row['name']."<br>";
	// 	}
	// }

	//Get the row count
	public function rowCount(){
		return $this->stmt->rowCount();
	} 

	//Get the single record as object 
	public function single(){
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_OBJ);
	} 

	public function bind($param,$value,$type = NULL){
		if ( is_null($type) ) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param,$value,$type);
	}


}