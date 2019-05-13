<?php
	/*
		Base class for Pet
	*/
	class Pet {
		private $_db;

		private $pet_name;
		private $pet_type_id;
		private $happiness;
		private $hunger;
		private $active_ind;
		private $createddatetime;

		//pet attribute cap
		private $_max_happiness;
		private $_max_hunger;
		//how much attribute reduce per update
		private $_update_over_time;

		function __construct ($db){
			$this->_db = $db;
			$this->_max_happiness = 20;
			$this->_max_hunger = 20;
			$this->_update_over_time = 1; 
		}

		public function MaximumAttribute($attribute) {
			return $this->{'_max_'.$attribute};			
		}

		public function UpdateByValue(){
			return $this->_update_over_time;
		}

		public function GetPet($player_id = null, $pet_id = null){
			$sqlString = "SELECT l.player_id,p1.player_name, p.pet_id, p.pet_name, pt.pet_type,
						p.happiness, p.hunger, pt.happiness_rate, pt.hunger_rate
						FROM pet p 
						INNER JOIN pet_type pt ON pt.pet_type_id = p.pet_type_id
						INNER JOIN link_player_pet l ON l.pet_id = p.pet_id
						INNER JOIN player p1 ON p1.player_id = l.player_id
						WHERE p.active_ind = 1 AND p1.active_ind = 1";
			if($player_id){
				$sqlString .= " and  l.player_id = $player_id";
			}
			if($pet_id){
				$sqlString .= " AND l.pet_id = $pet_id";
			}

			$sqlString .= " ORDER BY p.createddatetime desc";
			//echo $sqlString;exit;
			$sqlResult = $this->_db->prepare($sqlString);
			$sqlResult->execute();
			return $sqlResult->fetchAll(PDO::FETCH_ASSOC);			
		}
		
		//public function StrokePet 
		public function UpdatePet($player_id, $pet_id = null, $field, $val){
			$sqlString = "UPDATE pet p 
					INNER JOIN link_player_pet l on l.pet_id = p.pet_id SET";
			if($field == 'happiness'){
				$sqlString .= " p.happiness = $val";
			}else if($field == 'hunger'){
				$sqlString .= " p.hunger = $val";
			}
			$sqlString .= " WHERE l.pet_id = $pet_id 
						AND l.player_id = $player_id";
			//echo $sqlString;exit;
			$sqlResult = $this->_db->prepare($sqlString);
			return $sqlResult->execute();

		}


	}
	
?>