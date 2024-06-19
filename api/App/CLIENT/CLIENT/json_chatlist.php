<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$Id =$_REQUEST['id'];
$name =$_REQUEST['name'];
$mobile =$_REQUEST['mobile'];

if($Id!="" && $mobile!="" && $name!=""){
    
    $json_result = '{
            "id" : "'.$Id.'",
            "name" : "'.$name.'",
            "mobile" : "'.$mobile.'"
        }';
    
}else{
        $json_result='{
            "error:"Not data found"
        }';
     }
?>
{
	"status":"true",
	"results":[<?php echo trim($json_result, ',');?>]
}
