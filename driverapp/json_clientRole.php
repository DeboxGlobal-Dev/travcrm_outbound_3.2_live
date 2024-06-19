<?php 
include "../inc.php";
header("Content-Type: application/json");

$orderRequestcall = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


$rs=GetPageRecord('*',PhoneClientRoleMaster,'status=1 order by id asc');  
while($roleList=mysqli_fetch_array($rs)){
$roleId=$roleList['id'];
$clientRole=$roleList['clientRole'];
$json_roles.= '{
		"roleId" : "'.$roleId.'",
		"clientRole" : "'.$clientRole.'"
	},';
}
$namevalue2 ="requestString='.$orderRequestcall.',responseString='.$json_roles.'"; 
addlistinggetlastid('apicallingLog',$namevalue2);
?>
{
		"status":"true",
		"clientrole":[<?php echo trim($json_roles, ',');?>]
}