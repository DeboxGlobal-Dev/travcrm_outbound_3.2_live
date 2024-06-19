<?php 
include "../../../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Content-Type: application/json");

$Id = $_REQUEST['id'];
$mobile = $_REQUEST['mobile'];

if($Id!="" && $mobile!=""){
    $json_result = array();
    $count = 0;
   
        $selectQuery = 'SELECT * FROM chatroom WHERE guestid="' . $Id . '" and mobile="'.$mobile.'"';
        $fetch = mysqli_query(db(), $selectQuery);

        if ($fetch && mysqli_num_rows($fetch) > 0) {
            while ($emailRes1 = mysqli_fetch_assoc($fetch)) {
                if($emailRes1['seen']==0){
                    
                    $count++;
                    }
                    
                
            }
        }
        $json_result[] = array(
            "seen" => "$count"
        );
    
}else {
        $json_result[] = array(
            "error" => "Please insert Id or mobile No"
        );
    }
echo json_encode(array(
    "status" => "true",
    "result" => $json_result
));

?>
