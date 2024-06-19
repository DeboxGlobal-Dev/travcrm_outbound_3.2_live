<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$id=$_REQUEST['Refid'];
	
	$select='*';
	$where='referanceNumber="'.$id.'"';
	$rs=GetPageRecord('displayId',_QUERY_MASTER_,$where); 
	$querydata=mysqli_fetch_array($rs);
	$pin = trim($querydata['displayId']);
	$countrow = mysqli_num_rows($rs);
    if($countrow < 1)
	{
		$json_pin = '{
	    "result" : "Error",
		"msg" : "Tour Id not Exists"
	}';
	}
	else if($pin=='' || strlen($pin) != 4 )
	{
		$json_pin = '{
	    "result" : "Error",
		"msg" : "Invalid PIN Registered"
	}';
	}
	else
	{
		$json_pin = '{
	    "result" : "Success",
		"msg" : "'.$pin.'"
	}';
	}
	echo $json_pin; 

	?>