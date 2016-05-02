<?php

class DataBase{

	private $db_host;
	private $db_name;
	private $db_user;
	private $db_pass;

	private $pdo;

	public function __construct($db_host, $db_name, $db_user, $db_pass){

		$this->db_name = $db_name;
		$this->db_user = $db_user;
		$this->db_pass = $db_pass;
		$this->db_host = $db_host;

	}

	private function getPDO(){

		if($this->pdo === null){
			try {
				$pdo = new PDO("mysql:dbname=$this->db_name;host=$this->db_host", $this->db_user, $this->db_pass, array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			} catch (PDOException $e) {
			    die($e->getMessage());
			}
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo = $pdo;
		}

		return $this->pdo;

	}

	private function query($statement, $one=false, $fetch='obj'){

		$req = $this->getPDO()->query($statement);

		if($fetch==='obj')
			$req->setFetchMode(PDO::FETCH_OBJ);
		elseif($fetch==='assoc')
			$req->setFetchMode(PDO::FETCH_ASSOC);
		elseif($fetch==='num')
			$req->setFetchMode(PDO::FETCH_NUM);
		else{
			$req->setFetchMode();
		}
		
		if($one) $datas = $req->fetch();
		else $datas = $req->fetchAll();


		
		return $datas;

	}






	public function getTables(){

		$tables = $this->query("SHOW TABLES");
		$ee = [];

		foreach ($tables as $table) {
            $t = 'Tables_in_' . strtolower($this->db_name);
            $ee[] = $table->$t;
        }

        return $ee;

	}

	public function getStructure($table){

		if($table==='') return false;

		$structure = $this->query("DESCRIBE `$table`");
		$new_structure = [];

		foreach ($structure as $v) {
			$new_structure[$v->Field] = (object) ['Field'=>$v->Field, 'Type'=>$v->Type, 'Null'=>$v->Null, 'Key'=>$v->Key, 'Default'=>$v->Default, 'Extra'=>$v->Extra];
		}

		ksort($new_structure);

		return $new_structure;

	}

	public function getContent($table){

		$content = $this->query("SELECT * FROM `$table`", false);

		return $content;
		// print_r($content);

		// die();

		// $new_content = [];
		// foreach ($content as $v) {
		// 	$new_content[ $v-> ] = $v;
		// }


		// print_r($new_content);

	}

}