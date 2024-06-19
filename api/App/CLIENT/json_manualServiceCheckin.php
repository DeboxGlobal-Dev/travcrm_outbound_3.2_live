<?php 
include "../../../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Content-Type: application/json");


$mobile = $_REQUEST['mobile'];
$serviceId = $_REQUEST['serviceId'];
$currentTime = '/'.$_REQUEST['time'];
date_default_timezone_set('Asia/Kolkata');
$currentDate = date('d-m-y');


    if ($mobile != '' && $serviceId!="") {
        $statusupdate = "UPDATE `serviceGuestList` SET `status` = 1, `updated_at`='$currentDate$currentTime',`manualCheckInType`='manual' WHERE `mobile` = '" . $mobile . "' and `serviceId` ='".$serviceId."'";
        $updatequery = mysqli_query(db(), $statusupdate);
        if($updatequery){
            echo json_encode([
                "status" => "true",
                "results"=>[["message" => "Guest checkIn Successfuly!"]]
            ]);
        }
        } else {
            echo json_encode([
                "status" => "true",
                "results"=>[["message" => "Mobile No or serviceId does not match"]]
            ]);
        }
    
?>