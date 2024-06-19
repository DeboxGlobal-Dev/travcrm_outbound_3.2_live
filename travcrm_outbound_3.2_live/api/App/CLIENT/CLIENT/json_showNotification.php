<?php 
include "../../../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Content-Type: application/json");

$Id = $_REQUEST['id'];
$mobile =$_REQUEST['mobile'];
$status =$_REQUEST['status'];

if($Id!="" && $mobile!="" && $status!=""){
    $json_result = array();
   
        $selectQuery = 'SELECT * FROM chatroom WHERE guestid="' . $Id . '" and mobile ="'.$mobile.'" and status="'.$status.'"';
        $fetch = mysqli_query(db(), $selectQuery);

        if ($fetch && mysqli_num_rows($fetch) > 0) {
            while ($emailRes1 = mysqli_fetch_assoc($fetch)) {
                $time =$emailRes1['date_added'];
                $dateTime = new DateTime($time);
                $timeInAmPm = $dateTime->format('h:i A');
                
                $dateTime = new DateTime($time);
                $currentDate = new DateTime();
                
                $diff = $currentDate->diff($dateTime);
                
                if ($diff->days == 0) {
                    $formattedDate = "Today";
                } elseif ($diff->days == 1) {
                    $formattedDate = "Tomorrow";
                } elseif ($diff->days == -1) {
                    $formattedDate = "Yesterday";
                } else {
                    $formattedDate = $dateTime->format('d-M-Y');
                }

                $json_result[] = array(
                    "message" => $emailRes1['message'],
                    "days" => $formattedDate,
                    "time" => $timeInAmPm
                );
                
                
            }
        }
    
}else {
        $json_result[] = array(
            "error" => "Please insert Id or Mobile No or Status"
        );
    }
echo json_encode(array(
    "status" => "true",
    "result" => $json_result
));


?>
