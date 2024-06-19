<?php
//header('Content-type: text/html');
header("Content-Type: application/json");
include "../../../inc.php";
//include "config/inc.php";

class clsDBResponse 
{
    public $Status;
    public $DataTable=array();
}

class clsDataTable
{
    public $Subject;
    public $Client;
    public $StartDate;
    public $Status;
    public $SalesPerson;
    public $CreatedDate;
}

function showdate($datestring){ 
if($datestring!='0000-00-00'){
return date("d-m-Y", strtotime($datestring));  
} else {
return '-';
}
}

$sqlQuery = "select * from tasksmaster";

//$sqlQuery = str_replace('_WHERE',$whereCond,$sqlQuery);


try {

	$RecordSet = mysqli_query(db(),$sqlQuery);

	$objResponse = new clsDBResponse();

	$arrayDataRows = array();

	while($dataList=mysqli_fetch_array($RecordSet)) { 

		if (mysqli_num_rows($RecordSet) > 0) {
		
			$objDataTable = new  clsDataTable ();

		    $objDataTable->Subject = $dataList['subject'];
		    if ($dataList['clientType'] == 10) {
		    	$objDataTable->Client ="My Task";
		    }else{
		    	$objDataTable->Client = showClientTypeUserName($dataList['clientType'], $dataList['companyId']);
		    }
			$objDataTable->StartDate=showdate($dataList['fromDate']);

			if ($dataList['status'] == 1) {
				$objDataTable->Status = "shedule";
			}elseif ($dataList['status'] == 2) {
				$objDataTable->Status = "confirm";
			}elseif ($dataList['status'] == 3) {
				$objDataTable->Status = "canceled";
			}
			$objDataTable->SalesPerson = getUserName($dataList['assignTo']);
			$objDataTable->CreatedDate = showdate(date('Y-m-d',$dataList['dateAdded']));

		    $a = array_push($arrayDataRows,$objDataTable);

    	}
	} 

	$objResponse->Status = "true";
  	$objResponse->DataTable = $arrayDataRows;
	
} catch (Exception $e) {
	$objResponse->Status = "false";
	echo "Exception Sales Tasks API  ===>  ". $e->getMessage();
}

finally
{
    echo json_encode([$objResponse],JSON_PRETTY_PRINT);
}

?>	