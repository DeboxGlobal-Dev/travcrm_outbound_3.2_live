<?php
include "../../../inc.php";
//include "../../../travcrm-dev/inc.php";
header("Content-Type: application/json");

$refid = $_REQUEST['Refid'];

$selectquery = '*';
$where_11 = 'referanceNumber="'.$refid.'" and tourManager !=""';
$result11 = GetPageRecord($selectquery,'queryMaster',$where_11);
$row = mysqli_fetch_assoc($result11);
$TourManagerid = $row['tourManager'];


$selectquery_2 = '*';
$where_2 = 'id="'.$TourManagerid.'" and status="1" and deletestatus=0 and serviceType=2';
$result12 = GetPageRecord($selectquery_2,'tbl_guidemaster',$where_2);
while($tourmanagerList = mysqli_fetch_assoc($result12)){										
$Name=$tourmanagerList['name'];
$email=$tourmanagerList['email'];
$phone=$tourmanagerList['phone'];
//josn structure
$json_manager .='{
    "name":"'.$Name.'",
    "email":"'.$email.'",
    "contactNumber":"'.$phone.'"
},';
}
?>
{
    "status":"true",
    "tourManager":[<?php echo trim($json_manager, ',');?>]
}