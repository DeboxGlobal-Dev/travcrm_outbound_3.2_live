<?php
	header('Content-type: text/html'); 
	include "../../../inc.php";
 	// include "../../../travcrm-dev/inc.php";
	
	//	5000000
// 	function coverttosmall($value){
// 		if($value > 1000 && $value < 100000){
// 			return round($value/1000)."K";  
// 		}else if($value > 100000 && $value < 10000000){
// 			return round($value/100000)."L";
// 		}else if($value > 10000000){
// 			return round($value/10000000)."Cr";
// 		}else{
// 			return 0;
// 		}
// 	}
	
	$json_result = "";

// // json is here

if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
    $fromDate = $_REQUEST['fromDate'];
    $toDate = $_REQUEST['toDate'];
    
    // $dateFilter = 'and fromDate between "'$fromDate'" and "'$toDate'" ';
    $dateFilter = ' and fromDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
}

$where = 'status=1 and deletestatus=0 '.$dateFilter.' ';
$calls = getPageRecord( 'COUNT(*) AS SUM','callsMaster',$where);
 
$row = mysqli_fetch_assoc($calls);
$totalCalls = $row['SUM'];

 
 
     

$where1 = 'status=1 and deletestatus=0 '.$dateFilter.'';
$meetings = getPageRecord( 'COUNT(*) AS totalMeetings','meetingsMaster',$where1);
 
$ress = mysqli_fetch_assoc($meetings);
$totalmeetings = $ress['totalMeetings'];

 

$where2 = 'status=1 and deletestatus=0 '.$dateFilter.'';
$tasks = getPageRecord( 'COUNT(*) AS totaltasks','tasksMaster',$where2);
 
$ress1 = mysqli_fetch_assoc($tasks);
$totaltasks = $ress1['totaltasks'];

  
    $rs=GetPageRecord('SUM(finalCost) AS finalCost','agentPaymentRequest','finalCost>0'); 
    $resultS=mysqli_fetch_array($rs);  
    $totalSales= $resultS['finalCost'];
    
  
    
    
$json_result.= '{
		"totalCalls" : "'.$totalCalls.'",		
		"totalmeetings" : "'.$totalmeetings.'",		
		"totaltasks" : "'.$totaltasks.'",
		"totalsale" : "'.$totalSales.'"
		},';

?>
	{
		"status":"true",
		"results":[<?php echo trim($json_result,',');  ?>]
	}
