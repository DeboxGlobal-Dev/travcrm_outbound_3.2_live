<?PHP
// included files 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";


// headers 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");


$where2='1 and status=1 and deletestatus=0 order by id desc';


// function 
$rs2=GetPageRecord('*','packageBuilderTransportMaster',$where2);


// geting data database all
while($resultlists=mysqli_fetch_array($rs2)){
    $transferName=$resultlists['transferName'];
    $destinationId=$resultlists['destinationId'];
    $transferType=$resultlists['transferType'];
    $transferDetail=$resultlists['transferDetail'];
    
    

    $json_result .='{
            "transferName":"'.$transferName.'",
            "destination":'.$destinationId.',
            "tranferType":'.$transferType.',
            "tranferDetails":"'.$transferDetail.'"
        }';
        
    };
    

?>
{
 "status":"true",
 "results":[<?php echo trim($json_result, ','); ?>]
}