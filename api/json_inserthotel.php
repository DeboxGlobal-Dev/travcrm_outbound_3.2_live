<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");


    $hotelName=clean($_REQUEST['hotelName']);
    $url=clean($_REQUEST['url']);   
	$hotelCity=clean($_REQUEST['hotelCity']); 
	$hotelChain=clean($_REQUEST['hotelChain']);  
	$hotelAddress=clean($_REQUEST['hotelAddress']);  
	$hotelCategory=clean($_REQUEST['hotelCategory']); 
	$hoteldetail=cleanNonAsciiCharactersInString($_REQUEST['hoteldetail']);
	$hotelpolicy=clean($_REQUEST['hotelpolicy']);
	$hoteltermandcondition=clean($_REQUEST['hoteltermandcondition']);
	$gstn=clean($_REQUEST['gstn']); 
	$supplier=$_REQUEST['supplier'];
	$roomType = implode(',', $_REQUEST['roomType']); 
	$status=clean($_REQUEST['status']);
	$weekendid=$_REQUEST['weekend'];

	$ishotelCat=GetPageRecord('*','hotelCategoryMaster','id="'.$hotelCategory.'" ');
	$reCateHot=mysqli_fetch_array($ishotelCat);

if(!empty($_FILES['hotelImage']['name'])){  
		$hotelImageN = str_replace(" ","_",trim($_FILES['hotelImage']['name']));
		$file_name=time().$hotelImageN;  
		copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name);
		$hotelIMagName=$file_name; 
	}

	$namevalue ='hotelName="'.$hotelName.'",hotelCity="'.$hotelCity.'",policy="'.$hotelpolicy.'",termAndCondition="'.$hoteltermandcondition.'",hotelChain="'.$hotelChain.'",hotelAddress="'.$hotelAddress.'",hoteldetail="'.$hoteldetail.'",hotelCategory="'.$hotelCategory.'",hotelImage="'.$hotelIMagName.'",gstn="'.$gstn.'",status="'.$status.'",url="'.$url.'",roomType="'.$roomType.'",supplier="'.$supplier.'",weekendDays="'.$weekendid.'",hotelCategoryName="'.$reCateHot['name'].'"';

$insertHotel=addlisting(_PACKAGE_BUILDER_HOTEL_MASTER_,$namevalue);

if($insertHotel!=''){
$json_result.= '{
		"insert" : "Data Inserted Succesfully",
	},';
}else{
    $json_result.= '{
		"error" : "Please Try Again!",
	},';
}
?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}
