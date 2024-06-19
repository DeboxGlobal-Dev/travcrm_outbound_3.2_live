<?php 

// included files 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";


// headers 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");


// condition and fetch data 

$where2='1 and status=1 and deletestatus=0 order by id desc';


// funftion 
$rs2=GetPageRecord('*','contactsMaster',$where2);


// geting data database all
while($resultlists=mysqli_fetch_array($rs2)){
    $fname=$resultlists['firstName'];
    $lname=$resultlists['lastName'];
    $birthDate=$resultlists['birthDate'];


   
    
    
    
    // create jsonvariable store key and values 
        $json_result.='{
          "salesperson": "'.$fname.' '.$lname.'",
          "birthDate": '.$birthDate.'
          
        }';
    
    
};

?>


{
    "status":"true",
    "results":[<?php echo trim($json_result, ','); ?>]
}