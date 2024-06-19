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


$where = 'status=1 and deletestatus=0 order by id desc';

$result1 = Getpagerecord('*','transferTypeMaster',$where);

while($res=mysqli_fetch_array($result1)){
    $name=$res['name'];
    $dateAdded=$res['dateAdded'];
    $addedBy=$res['addedBy'];
    
    
    $json_result.= '{
          "name": '.$name.',
          "dateAdded": '.$dateAdded.',
          "addedBy":'.$addedBy.'
        }';
    
}

?>
{
 "status":"true",
 "results":[<?php echo trim($json_result, ','); ?>]
}
}