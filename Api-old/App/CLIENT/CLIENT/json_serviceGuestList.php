<?php 
include "../../../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Content-Type: application/json");

$status = $_REQUEST['status'];
$serviceId = $_REQUEST['serviceId'];

      if ($serviceId!='' && $status!="") {

       $countStatusZero=0;
            $resphone3 = GetPageRecord('*','serviceGuestList','serviceId="'.$serviceId.'" AND status="'.$status.'" ');
             if (mysqli_num_rows($resphone3) > 0) {
            while($phoneRes3=mysqli_fetch_assoc($resphone3)){
                $ServiceID =$phoneRes3['serviceId'];
                $Name =$phoneRes3['Name'];
                $Mobile =$phoneRes3['mobile'];
                $date =$phoneRes3['updated_at'];
                
          if(!empty($Name)&&!empty($Mobile)){
            $json_result .= '{
                "serviceId" :"'.$ServiceID.'",
                "name": "' . $Name . '",
                "phone": "' . $Mobile.'",
                "checkInTime": "' . $date.'",
                "status": "' . $phoneRes3['status']. '"
            },';
            
            if ($phoneRes3['status'] == 1) {
                $countStatusZero++;
            }
            if($phoneRes3['status'] == 0){
                $countStatusZero++;
            }
           }
        }
            

        if ($json_result) {
            echo '{
                "status": "true",
                 "guestcount": "' . $countStatusZero . '",
                "results": [' . trim($json_result, ',') . ']
            }';
        }
        
             } else {
                echo '{
                    "status": "true",
                    "guestcount":"0",
                    "results": []
                }';
             }
    
    } else {
        echo '{
            "results" :[{"error": "Please Enter service Id"}]
        }';
    }
    
    

?>