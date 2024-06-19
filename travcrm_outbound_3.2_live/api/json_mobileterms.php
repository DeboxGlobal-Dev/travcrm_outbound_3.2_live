<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$select='*';
$where='fit_git="Mobile"';
$rs=GetPageRecord($select,_PACKAGE_TERMS_CONDITIONS_MASTER,$where);
while($termsList=mysqli_fetch_array($rs)){
    $termscondition=strip_tags($termsList['termscondition']);
}

$json_result.= '{
        	"termscondition" : "'.$termscondition.'"
},';


 ?>
	{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
	}