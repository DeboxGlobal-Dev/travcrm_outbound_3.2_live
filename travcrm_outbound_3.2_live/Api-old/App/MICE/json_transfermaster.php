<?php 
include "../../config/database.php";
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');   
header("Content-Type: application/json");


// kjnsjndjkndhsbhbhdds
	$select='*';  
// 	$where='id= 783'; 
	$where = 'status =1 order by id asc'; 
	
$rs=GetPageRecord($select,_PACKAGE_BUILDER_TRANSFER_MASTER,$where);

          while($resultlists=mysqli_fetch_assoc($rs)){
        //   $resultlists=mysqli_fetch_array($rs);
          
          $serviceCode = makeServiceCode('ENT',$resultlists['id']);
          $transferName = $resultlists['transferName'];
          $transferDetail = $resultlists['transferDetail'];
         $transferCity = $resultlists['transferCity'];
        
          
          
         $json_result .='{
        	"$serviceCode" : "'.$serviceCode.'",
        	"$entranceName" : "'.$entranceName.'",
        	"$entranceCity" : "'.$entranceCity.'",
        	"$entDescription" : "'.$entDescription.'"
        },';
    }

?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}