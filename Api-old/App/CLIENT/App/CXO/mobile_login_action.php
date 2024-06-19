<?php

include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";
header('Content-type: text/html');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

if($_REQUEST['username']!='' && $_REQUEST['password']!=''){ 
    $username = $_REQUEST['username'];
    $password = md5($_REQUEST['password']);  
    
    $sql=GetPageRecord('*',_USER_MASTER_,'email="'.$username.'" and password="'.$password.'" and status=1 and admin=1');

	if (mysqli_num_rows($sql) > 0) {
    	$userinfo=mysqli_fetch_array($sql); 
    	$id=$userinfo['id'];
    	$json_result ='{
    	    "id":"'.$id.'"
	    },';

	}else{
		$json_result = '{
	        "error":"Invalid Login"
		},'; 		
	}

}else{
    $json_result ='{
        "error":"Error Try Again"
    },'; 
}
?>
{
    "status":"true",
    "results":[<?php echo trim($json_result, ',');?>]
}