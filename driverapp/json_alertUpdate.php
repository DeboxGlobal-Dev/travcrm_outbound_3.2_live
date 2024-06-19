<?php
include "../inc.php";
header("Content-Type: application/json");

$roleId=$_REQUEST['roleId'];

if($roleId==2){

    $namevalue = 'readalert="1"';
    $where = 'showid=1';
    $update = updatelisting('driverAllocationDetails',$namevalue,$where);

    if($update=='yes'){
    $message="Update Now.";

$json_alert.= '{
  
    "message":"'.$message.'"
  
},'; 

}
}elseif($roleId==3){

    $namevalue = 'readalert="1"';
    $where = 'showId=1';
    $update = updatelisting('guideAllocation',$namevalue,$where);

    if($update=='yes'){
    $message="Update Now.";

$json_alert.= '{
  
    "message":"'.$message.'"
  
},'; 

}

}
?>
{
		"status":"true",
		"alertDetails":[<?php echo trim($json_alert, ',');?>]
}