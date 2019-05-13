<?php
    /*
        Function for updating all the pets within the system
        To be call periodically
    */
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	include_once '../../config/DatabaseObject.php';
	include_once '../../model/Pet.php';

	//Instantiate DB& connect
	$dbObj = new DatabaseObject();
    $db = $dbObj->connect();
    
    $attributes = array('happiness', 'hunger');

	$petObj = new Pet($db);

    $result =  $petObj->GetPet();
    //check if pet exist	
    if(count($result) > 0){
        $dataAry = array();
        $dataAry['data'] = array();

        foreach($result as $val){
            foreach($attributes as $attribute){
                $value = $val[$attribute];
                // get highest possible value of the attribute
                $maxValue = $petObj->MaximumAttribute($attribute);     
                $rate = $petObj->UpdateByValue();         
                $status = false;
                switch($attribute){
                    case 'hunger':
                        // if attribute already at highest, return false
                        if($value >= $maxValue){
                            $status = false;						
                        }else{                        
                            //calcualte the resulting value for the attribute 
                            $value = ($value + $rate > $maxValue)?$maxValue:($value + $rate);	
                            $status = true;				
                        }
                        break;
                    case 'happiness':
                        // if attribute already at 0, return false
                        if($value <= 0){
                            $status = false;						
                        }else{
                            //calcualte the resulting value for the attribute 
                            $value = ($value - $rate < 0)?0:($value - $rate);					
                            $status = true;
                        }
                        break;
                }
                //if update the resulting value on the datebase
                if($status){
                    $status =  $petObj->UpdatePet($val['player_id'], $val['pet_id'],$attribute,$value);
                }
                $result[0]['status'] = $status;
                $result[0][$attribute] = $value;
                //Turn to json & output           
            }            
            array_push($dataAry['data'], $result[0]);
        }
        echo json_encode($dataAry);
    }else{
        echo json_encode(array('message'=>'No pet found'));
    }

	
?>