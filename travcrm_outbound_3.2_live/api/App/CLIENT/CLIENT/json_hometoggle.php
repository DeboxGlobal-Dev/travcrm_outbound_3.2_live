<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$activate=$_REQUEST['activate'];
           if($activate!=""){
   
    $rs = "update `toggle` set `status`='$activate' where `id`=1";
    $query =mysqli_query(db(),$rs);
    
        if ($query) {
        $resemail1 = GetPageRecord('*','toggle','id=1');
        $emailRes1 = mysqli_fetch_assoc($resemail1);

        $json_result = '{
            "message" : "'.$emailRes1['status'].'"
        }';

    }else{
        $json_result='{
            "error:"Data not insert"
        }';
    }
    
}

?>

{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}