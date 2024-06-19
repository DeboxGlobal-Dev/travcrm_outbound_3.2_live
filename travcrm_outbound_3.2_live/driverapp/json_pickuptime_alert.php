<?php
include "../inc.php";
header("Content-Type: application/json");

$date = $_REQUEST['pickupdate'];
$time = $_REQUEST['pickuptime'];
$transferQuoteId = $_GET['transferQuoteId'];
$qtime =date("h:i A",strtotime($time));
$qdate =date("Y-m-d",strtotime($date));
// print_r($qdate);die();
$reminder= 1;

$insertdata = "UPDATE `reminderBell` SET `reminder`='$reminder' where id=1";
$updatedata =mysqli_query(db(),$insertdata);



$join = "SELECT * FROM quotationTransferTimelineDetails WHERE transferQuoteId= '".$transferQuoteId."' and pickupTime ='".$qtime."'";
$pendingStatusDataaaq = mysqli_query(db(),$join);
$fetch = mysqli_fetch_assoc($pendingStatusDataaaq);
// print_r($fetch);die();


$DataQuery = "SELECT * FROM driverAllocationDetails WHERE  allocationStatus=1 and quotationId ='".$fetch['quotationId']."' and fromDate ='".$qdate."' ";
$pending=mysqli_query(db(),$DataQuery);
$fetchdata=mysqli_fetch_assoc($pending);

$rs=GetPageRecord('*',_QUERY_MASTER_,'id="'.$fetchdata['queryId'].'"');  
$queryData=mysqli_fetch_array($rs);
$guestname=$queryData['guest1'];
// print_r($fetch);die();
echo json_encode([
    "status"=>"true",
    "result"=>[[
    "massege" =>"Hello ".$guestname." you have an ".$fetch['pickupAddress']." pickup in 1 hours at ". $fetch['pickupTime']."",
    ]]]);



?>