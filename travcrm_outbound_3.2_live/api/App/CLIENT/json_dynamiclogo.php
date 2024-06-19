<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

// print_r($documentType);die();
$rscms=GetPageRecord('*','companySettingsMaster','id=1'); 
$editresultcsm=mysqli_fetch_array($rscms); 
$masterLogo = $editresultcsm['logoupload'];
$ulr= $fullurl;
$folder= "dirfiles/";
// "agenda" : "'.$ulr.''.$folder.''.$masterLogo.'"
?>

<?php
$json_result = '{
        
		"Img" : "'.$ulr.''.$folder.''.$masterLogo.'"
		
	},';

?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}
