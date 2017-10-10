<?php

	header('content-type: application/json; charset=utf-8');
	
    if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
		
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Max-Age: 1728000'); //20days
        header("Content-Length: 0");
        header("Content-Type: application/json");
		
    } elseif($_SERVER['REQUEST_METHOD'] == "POST") {
		
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

		include 'classes/db_config.php';
		include 'classes/db_function.php';
		
		try{
			
			if (!isset($_POST['k']) || !isset($_POST['i']) || !isset($_POST['c'])) throw new Exception('missing parameter(s)',905);
			
			$inKey		= 	preg_replace('/[^a-zA-Z0-9]/', 			'', 	$_POST['k'] ); 	#k for event key
			$inData		= 	preg_replace('/[^-a-zA-Z0-9_\.\@]/', 	'', 	$_POST['i']);	#i for input
			$inCaptcha	= 	preg_replace('/[^-a-zA-Z0-9_]/', 		'', 	$_POST['c']);	#c for captcha
			
			if (empty($inKey) || empty($inData) || empty($inData)) throw new Exception("Empty query",900);

			//Start google recaptcha
			$secret = '6Ld_QxATAAAAAJN2dkTe89mKR_xErP0M0IV3jPYM';
			$response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$inCaptcha."&remoteip=".$_SERVER["REMOTE_ADDR"]), true);
			if ($response["success"] != false) {
			//end google recaptcha
			
				if( preg_match('/^[a-zA-Z0-9]{8}$/',$inKey,$keyResult) ){
					$db = new Database();
					$db->query('SELECT `event_id` FROM `event` WHERE `event_key` = :eKey');
					$db->bind(':eKey', $inKey);
					$result =$db->single();	
					
					if ( !empty($result)){
						$eID = $result[event_id];
						if ( !filter_var($inData, FILTER_VALIDATE_EMAIL) === false ) {
							$db->query('INSERT INTO record (event_id, email) VALUES ('.$eID.', :email)');
							$db->bind(':email', $inData);
							$db->execute();
						}elseif (preg_match('/^\\d{8}$/',$inData,$inResult)){
							$db->query('INSERT INTO record (event_id, tel) VALUES ('.$eID.', :eTel)');
							$db->bind(':eTel', $inData);
							$db->execute();
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
			}else{
				throw new Exception('Captcha is invaild',904);
			}
			
			
		}catch(Exception $e){
			echo json_encode( array( 'error' => array('code' => $e->getCode(),'message' => $e->getMessage()) ) );
		}
		
    } else {
        die('Permission denied');
    }
	
?>