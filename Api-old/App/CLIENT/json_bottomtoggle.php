<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

        $resemail1 = GetPageRecord('*','toggle','id=1');
        $emailRes1 = mysqli_fetch_assoc($resemail1);
        if($emailRes1){

        $json_result = '{
            "message" : "'.$emailRes1['status'].'"
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
