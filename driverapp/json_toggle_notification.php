<?php
include("../inc.php");

header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');

if(isset($_REQUEST)){
    
           $notification= 0;
           $id=61;
        //   $resultnotification = mysqli_query(db(), "UPDATE `toggle_notification_php` set `notification`='$notification' WHERE id ='".$id."'");
           $notificationresult = mysqli_query(db(),"SELECT * from `toggle_notification_php` where id=61 ");
           $fetchnotification = mysqli_fetch_assoc($notificationresult);
           $resultconter =$fetchnotification['notification'];
           if($resultconter ==1){
               $dutystatus ="On duty";
               $status ="true";
           }else{
               $dutystatus = "Off duty";
               $status ="false";
           }
           
        //   print_r($resultconter);die();
           
           
        if ($fetchnotification) {
            echo json_encode(['status' => "true", 'results' => [["counter"=>"$resultconter" , "duty"=>"$dutystatus", "statusclock"=>"$status"]]]);
        } else {
            http_response_code(400);
            echo json_encode(['status' => "failure", 'message' => "Something went wrong in creating Toggle, Please try again later"]);
        }
    
}






?>