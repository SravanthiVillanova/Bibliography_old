<?php
 class Database {
	 private $host = 'localhost';
	 private $user = 'root';
	 private $pwd  = '';
	 private $dbname = 'panta_rhei';
	 
	 private $dbh;
	 private $error;
	 private $qstmt;
	 
	 public function __construct() {
		 // set DSN
		 $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
		 // set options
		 $option = array(
		           PDO::ATTR_PERSISTENT      => true,
				   PDO::ATTR_ERRMODE         => PDO::ERRMODE_EXCEPTION
		 );
		 // create new PDO
		 try {
			 $this->dbh = new PDO($dsn, $this->user, $this->pwd, $option);
		 } catch(PDOECEPTION $e) {
			 $this->error = $e->getMessage();
		 }
	 }
	 
	 public function query($query) {
		 $this->qstmt = $this->dbh->prepare($query);
	 }
	 
	 public function bind($param, $value, $type = null) {
		 if(is_null($type)) {
			 switch(true) {
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
		 $this->qstmt->bindValue($param, $value, $type);
	 }
	 
	 public function execute() {
		 return $this->qstmt->execute();
	 }
	 
	 public function resultset() {
		 $this->execute();
		 return $this->qstmt->fetchAll(PDO::FETCH_ASSOC);
	 }
 }
?>