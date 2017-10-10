<?php
	header('content-type: application/json; charset=utf-8');
	
    if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Max-Age: 1728000'); //20days
        header("Content-Length: 0");
    } elseif($_SERVER['REQUEST_METHOD'] == "POST") {
        header('Access-Control-Allow-Origin: *');
		
		try{
			if ( !isset($_POST['k']) || !isset($_POST['i']) ) throw new Exception('Missing parameter(s)',905);
			$inKey		= 	preg_replace('/[^a-zA-Z0-9]/', 			'', 	$_POST['k'] ); 	#k for event key
			$inData		= 	preg_replace('/[^-a-zA-Z0-9_\.\@]/', 	'', 	$_POST['i']);	#i for input
			
			if (empty($inKey) || empty($inData)) throw new Exception("Empty query",900);
				if( preg_match('/^[a-zA-Z0-9]{8}$/',$inKey,$keyResult) ){
					include "classes/db_operate.php";
					$op = new Operation;
					$result = $op->record_select($inKey);
					if ( !empty($result)){
						$eID = $result['event_id'];
						if ( !filter_var($inData, FILTER_VALIDATE_EMAIL) === false ) {
							$op->record_insert_email($eID,$inData);
						}elseif (preg_match('/^\\d{8}$/',$inData,$inResult)){
							$op->record_insert_tel($eID,$inData);
						}else{
							throw new Exception('Record is invaild',903);
						}
						echo json_encode( array( "data" => array("success" => true))) ;
					}else{
						throw new Exception('Key is invalid',902);
					}
				}else{
					throw new Exception('Key format is invalid',901);
				}
		}catch(Exception $e){
			echo json_encode( array( 'error' => array('code' => $e->getCode(),'message' => $e->getMessage()) ) );
		}
		
    } else {
		header("HTTP/1.1 404 Not Found");
		exit;  
    }
	
?>