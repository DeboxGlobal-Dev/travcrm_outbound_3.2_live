    <?php
/////////////////////////////
//                         //
//   Sample Request Json   //
//   {                     //
//      "userid":"144",    //
//      "year":"2022"      //
//   }                     //
//                         //
/////////////////////////////

	//header('Content-type: text/html');
	header("Content-Type: application/json");
    //include "../../../travcrm-dev/inc.php";
    include "../../../inc.php";
	//include "config/inc.php";

	// $parameterdata = file_get_contents('php://input');
	// $parameterdata = str_replace("null","\"\"",$parameterdata);

	// $dataToExtract= json_decode($parameterdata);
	// $UserId = $dataToExtract->userid;
	// $Year = $dataToExtract->year;
$UserId = $_REQUEST['userid'];
$Year = date('Y');
$strYearWhere = '';
if ($_REQUEST['year']!='') {
	$strYearWhere = ' and year='.$_REQUEST['year'].'';
	$Year = $_REQUEST['year'];	
}else{
	$strYearWhere = ' and year='.date('Y').'';
	$Year = date('Y');	
}


class clsDBResponse 
{
    public $Status;
    public $DataTable=array();
}

class clsDataTable
{
    public $AssignTo, $Year, $January, $February, $March, $April, $May, $June, $July, $August, $September, $October, $November,$December, $UserId, $AddBy, $AddDate, $TargetQtrJanuaryToMarch, $TargetQtrAprilToJune, $TargetQtrJulyToSeptember, $TargetQtrOctoberToDecember, $TargetHalfYearlyJanuaryToJune, $TargetHalfYearlyJulyToDecember, $TargetYearly;

}


$sqlQuery = "select * from "._TARGET_MASTER_." where assign_to = _ASSIGNTO _YEAR";

$sqlQuery = str_replace('_ASSIGNTO',$UserId,$sqlQuery);
$sqlQuery = str_replace('_YEAR',$strYearWhere,$sqlQuery);

try {

	$RecordSet = mysqli_query(db(),$sqlQuery);

	$objResponse = new clsDBResponse();

	$arrayDataRows = array();

	while($dataList=mysqli_fetch_array($RecordSet)) { 

		if (mysqli_num_rows($RecordSet) > 0) {
		
			$objDataTable = new  clsDataTable ();

			$objDataTable->AssignTo = $dataList['assign_to'];
			$objDataTable->Year = $dataList['year'];
			$objDataTable->January = $dataList['January'];
			$objDataTable->February = $dataList['February'];
			$objDataTable->March = $dataList['March'];
			$objDataTable->April = $dataList['April'];
			$objDataTable->May = $dataList['May'];
			$objDataTable->June = $dataList['June'];
			$objDataTable->July = $dataList['July'];
			$objDataTable->August = $dataList['August'];
			$objDataTable->September = $dataList['September'];
			$objDataTable->October = $dataList['October'];
			$objDataTable->November = $dataList['November'];
			$objDataTable->December = $dataList['December'];
			$objDataTable->UserId = $dataList['userid'];
			$objDataTable->AddBy = $dataList['addby'];
			$objDataTable->AddDate = $dataList['adddate'];
			$objDataTable->AddBy = $dataList['addby'];


			$objDataTable->TargetQtrJanuaryToMarch = (float)$dataList['January']+(float)$dataList['February']+(float)$dataList['March'];
			$objDataTable->TargetQtrAprilToJune = (float)$dataList['April']+(float)$dataList['May']+(float)$dataList['June'];
			$objDataTable->TargetQtrJulyToSeptember = (float)$dataList['July']+(float)$dataList['August']+(float)$dataList['September'];
			$objDataTable->TargetQtrOctoberToDecember = (float)$dataList['October']+(float)$dataList['November']+$m12 = (float)$dataList['December'];
			$objDataTable->TargetHalfYearlyJanuaryToJune = (float)$dataList['January']+(float)$dataList['February']+(float)$dataList['March']+(float)$dataList['April']+(float)$dataList['May']+(float)$dataList['June'];
			$objDataTable->TargetHalfYearlyJulyToDecember = (float)$dataList['July']+(float)$dataList['August']+(float)$dataList['September']+(float)$dataList['October']+(float)$dataList['November']+$m12 = (float)$dataList['December'];
			$objDataTable->TargetYearly = (float)$dataList['January']+(float)$dataList['February']+(float)$dataList['March']+(float)$dataList['April']+(float)$dataList['May']+(float)$dataList['June']+(float)$dataList['July']+(float)$dataList['August']+(float)$dataList['September']+(float)$dataList['October']+(float)$dataList['November']+$m12 = (float)$dataList['December'];

			$a = array_push($arrayDataRows,$objDataTable);	
    	}
	} 

	$objResponse->Status = "true";
  	$objResponse->DataTable = $arrayDataRows;
	
} catch (Exception $e) {
	$objResponse->Status = "false";
	echo "Exception Sales Target API  ===>  ". $e->getMessage();
}

finally
{
    echo json_encode($objResponse,JSON_PRETTY_PRINT);
}


?>	