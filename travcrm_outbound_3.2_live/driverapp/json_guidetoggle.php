<?php
include("../inc.php");

header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
   
if (isset($_REQUEST['status'])) {
    $status = $_REQUEST['status'];
    if($status=="true"){
        $bool =true;
    }else{
        $bool=false;
    }if($status=='true'){
       $notification=1; 
    }else{
        $notification=0;
    }
    // print_r($notification);die();

    if ($status == "") {
        http_response_code(400);
        echo json_encode(['status' => "failure", 'message' => "Please provide a statusclock"]);
    } else {
        $result = mysqli_query(db(), "UPDATE `toggle_notification_php` set `notification`='$notification' where id=62");
        // $resultnotification = mysqli_query(db(), "UPDATE `toggle_notification_php` set `notification` = '$notification' where id= '".61."'");
        if ($result) {
            echo json_encode(['status' => "success", 'results' => [['statusclock' =>$bool]]]);
        } else {
            http_response_code(400);
            echo json_encode(['status' => "failure", 'message' => "Something went wrong in creating Toggle, Please try again later"]);
        }
    }
} elseif (isset($_REQUEST['status'])) {
    $statusfalse = $_REQUEST['status'];
    if ($statusfalse == "") {
        http_response_code(400);
        echo json_encode(['status' => "failure", 'message' => "Please provide a statusclock"]);
    } else {
        $result = mysqli_query(db(), "UPDATE `toggle_notification_php` set `notification`='$notification' where id =62");

        if ($result) {
            echo json_encode(['status' => "success", 'results' => [['statusclock' =>$bool ]]]);
        } else {
            http_response_code(400);
            echo json_encode(['status' => "failure", 'message' => "Something went wrong in creating Toggle, Please try again later"]);
        }
    }
}
?>
