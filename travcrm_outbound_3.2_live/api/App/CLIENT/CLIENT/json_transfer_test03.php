<?PHP
//b2c get api
// included files 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";


// headers 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");


$where='1 and status=1 and deletestatus=0 order by id desc';

$result=GetPageRecord('*','contactsMaster',$where);


while($resultlists=mysqli_fetch_array($result)){
    $fname=$resultlists['firstName'];
    $lname=$resultlists['lastName'];
    $address=$resultlists['addressInfo'];
    $birthDate=$resultlists['birthDate'];

    


        $json_result .='{
            "Name": "'.$fname.''.$lname.'",
            "address": "'.$address.'",
            "birthDate":'.$birthDate.'
        }';
}

?>
{
 "status":"true",
 "results":[<?php echo trim($json_result, ','); ?>]
}