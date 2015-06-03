<?php
class db{

	private $host = 'localhost';
	private $username = 'root';
	private $password = '';
	private $database = 'tuto';
	private $db;
	
	public function __construct($host = null, $username = null, $password = null, $database = null){
		if($host != null){
			$this->host = $host;
			$this->username = $username;
			$this->password = $password;
			$this->database = $database;
		}
echo var_dump();
		try{
			$this->db = new PDO("mysql:dbname=tp_eshop;host=localhost", 'root', 'troiswa');
		}catch(PDOException $e){
			die('<h1>Impossible de se connecter a la base de donnee</h1>');
		}


	}

	function query($sql, $data = array()){
		$req =$this->db->prepare($sql);
		$req->execute($data);
		return $req->fetchAll(PDO::FETCH_OBJ);
	}

}