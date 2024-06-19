<?php
include "../../inc.php";
//   include "../../travcrm-dev/inc.php";
header('Content-type: text/html');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

if($_REQUEST['username']!='' && $_REQUEST['password']!=''){ 
// if(isset($_REQUEST['username']!='') && isset($_REQUEST['password']!='')){
$username = $_REQUEST['username']; 
$password = md5($_REQUEST['password']); 



$sql=GetPageRecord('*','cms_user_master','email="'.$username.'" and password="'.$password.'" and status=1');


// $sql=mysqli_query(db(),"SELECT * FROM cms_user_master WHERE email='".$username."' and password='".$password."' and status=1");

	if (mysqli_num_rows($sql) > 0) {
		
	$userinfo=mysqli_fetch_assoc($sql); 


	$id=$userinfo['id'];
print_r($id);die();
	$json_result ='{
	    "id":"'.$id.'"
	},';

	}else{
		$json_result ='{
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