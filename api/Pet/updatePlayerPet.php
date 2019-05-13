<?php
	/*
        Function for updating an attribute of player's pet
    */
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	include_once '../../config/DatabaseObject.php';
	include_once '../../model/Pet.php';
	
	if($_POST['player_id'])$player_id = $_POST['player_id'];
    if($_POST['pet_id'])$pet_id = $_POST['pet_id'];
	if($_POST['attribute'])$attribute = $_POST['attribute'];

	//Instantiate DB& connect
	$dbObj = new DatabaseObject();
	$db = $dbObj->connect();

	$petObj = new Pet($db);
	//exit if not all attribute are set
	if(isset($player_id) && isset($pet_id) && isset($attribute)){
		$result =  $petObj->GetPet($player_id, $pet_id);
		//check if pet exist	
		if(count($result) > 0){
            $dataAry = array();
            $dataAry['data'] = array();
			// get highest possible value of the attribute
            $value = $result[0][$attribute];
			$maxValue = $petObj->MaximumAttribute($attribute);
			$status = false;
			switch($attribute){
				case 'happiness':
					// if attribute already at highest, return false
					if($value >= $maxValue){
						$status = false;						
					}else{
						$attributeRate = $attribute.'_rate';
						//calcualte the resulting value for the attribute 
						$value = ($value + intval($result[0][$attributeRate]) >= $maxValue)?$maxValue:($value + intval($result[0][$attributeRate]));
						$status = true;				
					}
					break;
				case 'hunger':
					// if attribute already at 0, return false
					if($value <= 0){
						$status = false;						
					}else{
						$attributeRate = $attribute.'_rate';
						//calcualte the resulting value for the attribute 
						$value = ($value - intval($result[0][$attributeRate]) <= 0)?0:($value - intval($result[0][$attributeRate]));	
						$status = true;					
					}
					break;
			}
			//if update the resulting value on the datebase
			if($status){
				$status =  $petObj->UpdatePet($player_id, $pet_id,$attribute,$value);
			}
			$result[0]['status'] = $status;
			$result[0][$attribute] = $value;
			//Turn to json & output            
            array_push($dataAry['data'], $result[0]);
            echo json_encode($dataAry);
		}else{
			echo json_encode(array('message'=>'No pet found'));
		}
	}else{
		echo json_encode(array('error_message'=>'Error!'));	
	}

	
?>