
<?php

include "../inc.php";
header("Content-Type: application/json");



$date = $_REQUEST['pickupdate'];
$qdate =date("Y-m-d",strtotime($date));

$time = $_REQUEST['pickuptime'];
$transferQuoteId = $_GET['transferQuoteId'];
$qtime =date("h:i A",strtotime($time));
// print_r($qtime);die();


$insert = "select * from reminderBell";
$selectdata =mysqli_query(db(),$insert);
$reminderdata =mysqli_fetch_assoc($selectdata);

date_default_timezone_set('Asia/kolkata');
$currentTime = date('H:i:s');
$changetime =date("h:i A",strtotime($currentTime));



 

$join = "SELECT * FROM quotationTransferTimelineDetails WHERE transferQuoteId= '".$transferQuoteId."' and pickupTime ='".$qtime."'";
$pendingStatusDataaaq = mysqli_query(db(),$join);
$fetch = mysqli_fetch_assoc($pendingStatusDataaaq);

// $fetch['pickupTime']
if($changetime == $fetch['pickupTime'] ){
     $reminder =0;
$insertdata = "UPDATE `reminderBell` SET `reminder`='$reminder' where id=1";
 $updatedata =mysqli_query(db(),$insertdata);
 }



// print_r($fetch['pickupTime']);die();

$DataQuery = "SELECT * FROM driverAllocationDetails WHERE  finalActive=1 and quotationId ='".$fetch['quotationId']."' and fromDate ='".$qdate."' ";
$pending=mysqli_query(db(),$DataQuery);
$fetchdata=mysqli_fetch_assoc($pending);
// print_r($fetchdata['fromDate']);die();

$rs=GetPageRecord('*',_QUERY_MASTER_,'id="'.$fetchdata['queryId'].'"');  
$queryData=mysqli_fetch_array($rs);
$guestname=$queryData['guest1'];

$tourtoDate=date('d-M-Y',strtotime($fetchdata['fromDate']));

echo json_encode([
    "status"=>"true",
    "result"=>[[
    "transferQuoteId"=>$transferQuoteId,
    "reminder"=>$reminderdata['reminder'],
    "guestname"=>$guestname,
    "phone"=>"8786565434",
    "pickupdate"=>$tourtoDate,
    "pickupTime"=>$fetch['pickupTime'],
    "pickupadd"=>$fetch['pickupAddress'],
    ]]]);



?>
