<?php 
include "../../../inc.php";

// include "../../../travcrm-dev/inc.php";

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
// header('Cache-Control: max-age=900');
header("Content-Type: application/json");

class clsDBResponse 
{
    public $Status;
    public $DataTable=array();
}

class clsDataTable
{
    public $City;
    public $Country;
    public $State;
}

$where2='1 order by id desc limit 24154';
$rs2=GetPageRecord('*','cityMaster',$where2);
// $refid= mysqli_num_rows($rs2);
// if($refid>0){
  $arrayDataRows = array();
while($resListing=mysqli_fetch_assoc($rs2)){
$res3 = GetPageRecord('*','countryMaster','id="'.$resListing['countryId'].'" order by id asc');
$quotationData1 = mysqli_fetch_assoc($res3);

$res4 = GetPageRecord('*','stateMaster','id="'.$resListing['stateId'].'" order by id asc');
$quotationData2 = mysqli_fetch_assoc($res4);


	$objDataTable = new  clsDataTable();
	   	$objDataTable->City = $resListing['name'];
        $objDataTable->Country = $quotationData1['name'];
	    $objDataTable->State = $quotationData2['name'];
	    $a = array_push($arrayDataRows,$objDataTable);

} 

 $objResponse->Status = "0";
 $objResponse->DataTable = $arrayDataRows;

    echo json_encode($objResponse,JSON_PRETTY_PRINT);
    // echo "h";
