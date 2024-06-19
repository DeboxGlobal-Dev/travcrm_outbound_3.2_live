<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$masterid=$_REQUEST['id'];
$clientType=$_REQUEST['type'];
$select='*';
$where='companyId='.$masterid.' and clientType='.$clientType.' and deletestatus=0';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
while($querydata=mysqli_fetch_array($rs)){
    
$adult=$querydata['adult'];
$child=$querydata['child'];  
$infant=$querydata['infant'];  
   
$json_result.= '{
        "queryid" : "'.'#'.makeQueryId($querydata['id']).'",
        "subject" : "'.$querydata['subject'].'",
        "queryDate" : "'.date('j F Y', strtotime($querydata['queryDate'])).'",
        "adult" : "'.$adult.'",
        "child" : "'.$child.'",
		"infant" : "'.$infant.'",
		
	},';
	
	
}

?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}