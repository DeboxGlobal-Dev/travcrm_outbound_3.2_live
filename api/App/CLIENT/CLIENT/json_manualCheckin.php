<?php 
include "../../../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Content-Type: application/json");


$mobile = $_REQUEST['mobile'];
$currentTime = $_REQUEST['time'];
$rollId =$_REQUEST['rollId']; 
date_default_timezone_set('Asia/Kolkata');
$currentDate = date('Y-m-d');

// print_r($mobile);die();

if($rollId==1){
    if ($mobile != '') {
        $statusupdate = "UPDATE `phoneMaster` SET `status1` = 0, `checkOutDate`='$currentDate', `checkOutTime`='$currentTime',`manualCheckInType`='manual' WHERE `phoneNo` = '" . $mobile . "'";
        $updatequery = mysqli_query(db(), $statusupdate);
        if($updatequery){
            echo json_encode([
                "status" => "true",
                "results"=>[["message" => "Guest chequeout Successfuly!"]]
            ]);
        }
        } else {
            echo json_encode([
                "status" => "true",
                "results"=>[["message" => "Mobile No does not match"]]
            ]);
        }
    
}else{
     if ($mobile != '') {
        $statusupdate = "UPDATE `phoneMaster` SET `status1` = 1, `checkInDate`='$currentDate', `checkInTime`='$currentTime',`manualCheckInType`='manual' WHERE `phoneNo` = '". $mobile . "'";
        $updatequery = mysqli_query(db(), $statusupdate);
        if($updatequery){
            echo json_encode([
                "status" => "true",
                "results"=>[["message" => "Guest chequein Successfuly!"]]
            ]);
        }
        } else {
            echo json_encode([
                "status" => "true",
                "results"=>[["message" => "Mobile No does not match"]]
            ]);
        }


}
?>