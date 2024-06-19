<?php 
include "../../../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Content-Type: application/json");

$refId = $_REQUEST['refId'];
$serviceId = $_REQUEST['serviceId'];
$mobile = $_REQUEST['mobile'];
date_default_timezone_set('Asia/Kolkata');
$currentDate = date('d-m-Y');
$currentTime = date('H:i A');

// print_r($refId);die();

$countStatusZero = 0;
$json_result='';


   if (empty($mobile)) {
    if (!empty($refId)) {
        // Fetch tourId based on refId
        $rs3 = 'SELECT * FROM `queryMaster` WHERE `referanceNumber`="' . $refId . '"';
        $fetchmanager = mysqli_query(db(), $rs3);
        $managerId = mysqli_fetch_assoc($fetchmanager);
        $tourId = $managerId['id'];

        // Fetch guest list based on tourId
        $resphone1 = GetPageRecord('*', 'mice_guestListMaster', 'queryId="' . $tourId . '"');
        while ($phoneRes1 = mysqli_fetch_assoc($resphone1)) {
            $name = $phoneRes1['guest_first_name'] . " " . $phoneRes1['middle_name'] . " " . $phoneRes1['last_name'];
            $Guestmobile = $phoneRes1['mobile_number'];

            if (!empty($name) && !empty($Guestmobile)) {
                // Fetch service guest list based on serviceId and mobile
                $resphone3 = GetPageRecord('*', 'seviceGuestList', 'serviceId="' . $serviceId . '" AND mobile="' . $Guestmobile . '"');
                while ($phoneRes3 = mysqli_fetch_assoc($resphone3)) {
                    $json_result .= '{
                        "tourid": "' . $phoneRes1['id'] . '",
                        "refid": "' . $refId . '",
                        "name": "' . $name . '",
                        "agentname": "' . $phoneRes1['agent_corporate_name'] . '",
                        "email": "' . $phoneRes1['email_address'] . '",
                        "phone": "' . $Guestmobile . '",
                        "status": "' . $phoneRes3['status'] . '"
                    },';

                    if ($phoneRes3['status'] == 0) {
                        $countStatusZero++;
                    }
                }
            }
        }

        // Output JSON result
        echo json_encode([
            "status" => "true",
            "guestcount" => "$countStatusZero",
            "results" => json_decode("[" . rtrim($json_result, ',') . "]"),
        ]);
    } else {
        // Error: RefId is empty
        echo json_encode([
            "results" => [["error" => "Please Enter RefId"]],
        ]);
    }
    
   
}else {
    

    if ($refId != '') {
         $rs3 = 'SELECT * FROM queryMaster WHERE referanceNumber="'.$refId.'"';
        $fetchmanager = mysqli_query(db(), $rs3);
        $managerId = mysqli_fetch_assoc($fetchmanager);
                $tourId = $managerId['id'];
        $json_result = '';
        $name="";
        $countStatusZero=0;
        $phone=[];
         $resphone1 = GetPageRecord('*','mice_guestListMaster','queryId="'.$tourId.'" ');
       while ($phoneRes1=mysqli_fetch_assoc($resphone1)) {
       $name =$phoneRes1['guest_first_name']." ".$phoneRes1['last_name'];
       $phone[] =$phoneRes1['mobile_number'];
       $Guestmobile=$phoneRes1['mobile_number'];


             $resphone3 = GetPageRecord('*','seviceGuestList','serviceId="'.$serviceId.'" AND mobile="'.$Guestmobile.'" ');
            while($phoneRes3=mysqli_fetch_assoc($resphone3)){
                 

            $json_result .= '{
                "tourid": "'.$phoneRes1['id'].'",
                "refid": "'.$refId.'",
                "name": "' . $name . '",
                "agentname": "' . $phoneRes1['agent_corporate_name'] . '",
                "email": "' . $phoneRes1['email_address'] . '",
                "phone": "' . $Guestmobile.'",
                "status": "' . $phoneRes3['status']. '"
            },';
            
            if ($phoneRes3['status'] == 0) {
                $countStatusZero++;
            }
            }

        }
        if (in_array($mobile, $phone)){
        $statusupdate1 = "UPDATE `seviceGuestList` SET `status`=1,`updated_at`='$currentDate $currentTime' where `mobile`='$mobile' AND serviceId='$serviceId'";
        $updatequery1 = mysqli_query(db(), $statusupdate1);
        
        } else {
            echo json_encode([
                "status" => "true",
                "results"=>[["message" => "Mobile No does not match"]]
            ]);die();
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
        "results": [{"error": "Please Enter Tour Id No"}]
        }';
    }
    
}


?>