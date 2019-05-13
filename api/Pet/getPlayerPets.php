<?php
	/*
        Return information of a player's pet
    */
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	include_once '../../config/DatabaseObject.php';
	include_once '../../model/Pet.php';

	if($_POST['player_id']){
		$player_id = $_POST['player_id'];
	}
	//Instantiate DB& connect
	$dbObj = new DatabaseObject();
	$db = $dbObj->connect();

	$petObj = new Pet($db);
	if(isset($player_id)){
		$result =  $petObj->GetPet($player_id);
		
		if(count($result) >0){
			$dataAry = array();
			$dataAry['data'] = array();
	
			foreach($result as $val){
				$data = array(
					'pet_id' => $val['pet_id'],
					'pet_name' => $val['pet_name'],
					'pet_type' => $val['pet_type'],
					'happiness' => $val['happiness'],
					'hunger' => $val['hunger'],
				);
				array_push($dataAry['data'], $data);
			}
			//Turn to json & output
			echo json_encode($dataAry);
		}else{
			echo json_encode(array('message'=>'No pet found'));
		}
	}else{
		echo json_encode(array('error_message'=>'Error!'));	
	}

	
?>