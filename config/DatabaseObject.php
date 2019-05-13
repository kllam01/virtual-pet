<?php 
	/*
		Base class for Database connection
	*/
	class DatabaseObject{
		
		private $_host = 'localhost';
		private $_db_name = 'tmpDB';
		private $_username = 'root';
		private $_password = '';
		private $_db;
		
		//DB Connect
		public function connect(){
			$this->_db = null;
			try{
				$this->_db =  new PDO('mysql:host='.$this->_host.';dbname='.$this->_db_name,$this->_username, $this->_password);
				$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
			}catch(PDOException $e){
				echo 'Connection Error: '.$e->getMessage();
			}
			return $this->_db;
		}
	}

?>