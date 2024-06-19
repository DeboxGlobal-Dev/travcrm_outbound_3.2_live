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
$currentTime = '/'.date('H:i');

// print_r($refId);die();

$countStatusZero = 0;


    if (empty($mobile)) {
     if ($serviceId != '') {
    $countStatusZero = 0;
    $json_result = '';

    // Fetching data from queryMaster based on refId
    $rs3 = 'SELECT * FROM `queryMaster` WHERE `referanceNumber`="'.$refId.'"';
    $fetchmanager = mysqli_query(db(), $rs3);
    $managerId = mysqli_fetch_assoc($fetchmanager);
    $tourId = $managerId['id'];

    if (!empty($tourId)) {
        // Fetching guest list data based on tourId
        $resphone1 = GetPageRecord('*','contactsMaster','queryId2="'.$tourId.'" ');

        while ($phoneRes1 = mysqli_fetch_assoc($resphone1)) {
            $name = $phoneRes1['firstName']." ".$phoneRes1['lastName'];
            
        $where2='masterId="'.$phoneRes1['id'].'" and sectionType="contacts" ';
        $rs2=GetPageRecord('*','phoneMaster',$where2);
        $phoneData=mysqli_fetch_assoc($rs2);
        $Guestmobile = $phoneData['phoneNo'];
        
        $where3='masterId="'.$phoneRes1['id'].'" and sectionType="contacts" order by id desc';
        $rs4=GetPageRecord('*',_EMAIL_MASTER_,$where3);
        $emailData=mysqli_fetch_array($rs4);

            // Fetching service guest list data based on serviceId and mobile
            $resphone3 = GetPageRecord('*','serviceGuestList','serviceId="'.$serviceId.'" AND mobile="'.$Guestmobile.'" ');

            if (!empty($name) && !empty($Guestmobile)) {
                while ($phoneRes3 = mysqli_fetch_assoc($resphone3)) {
                    $ServiceID = $phoneRes3['serviceId'];

                    $json_result .= '{
                        "tourid": "'.$phoneRes1['id'].'",
                        "refid": "'.$refId.'",
                        "name": "' . $name . '",
                        "agentname": "'.$phoneRes1['agentName'].'",
                        "email": "' . $emailData['email'] . '",
                        "phone": "' . $Guestmobile.'",
                        "status": "' . $phoneRes3['status']. '"
                    },';

                    if ($phoneRes3['status'] == 0) {
                        $countStatusZero++;
                    }
                }

                if ($ServiceID == "") {
                    $statusupdate = "INSERT INTO `serviceGuestList` (`Name`, `updated_at`, `serviceId`, `mobile`)
                    VALUES ('$name', '$currentDate', '$serviceId', '$Guestmobile')";
                    $updatequery = mysqli_query(db(), $statusupdate);   
                } else {
                    $statusupdate = "UPDATE `serviceGuestList` SET `updated_at`='$currentDate', `serviceId`='$serviceId' where `serviceId` = '$serviceId'";
                    $updatequery = mysqli_query(db(), $statusupdate);
                }
            }
        }

        if ($json_result) {
            echo '{
                "status": "true",
                "guestcount": "' . $countStatusZero . '",
                "results": [' . trim($json_result, ',') . ']
            }';
        } else {
            echo '{
                "status": "true",
                "guestcount": "0",
                "results": []
            }';
        }
    } else {
        echo '{
            "results": [{"error": "Please Enter Tour Id No"}]
        }';
    }
} else {
    echo '{
        "results" :[{"error": "Please Enter service Id"}]
    }';
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
         $resphone1 = GetPageRecord('*','contactsMaster','queryId2="'.$tourId.'" ');
       while ($phoneRes1=mysqli_fetch_assoc($resphone1)) {
       $name =$phoneRes1['firstName']." ".$phoneRes1['lastName'];
       
        $where2='masterId="'.$phoneRes1['id'].'" and sectionType="contacts" ';
        $rs2=GetPageRecord('*','phoneMaster',$where2);
        $phoneData=mysqli_fetch_assoc($rs2);
        $Guestmobile = $phoneData['phoneNo'];
        $phone[] =$phoneData['phoneNo'];
        
        $where3='masterId="'.$phoneRes1['id'].'" and sectionType="contacts" order by id desc';
        $rs4=GetPageRecord('*',_EMAIL_MASTER_,$where3);
        $emailData=mysqli_fetch_array($rs4);
        
       


             $resphone3 = GetPageRecord('*','serviceGuestList','serviceId="'.$serviceId.'" AND mobile="'.$Guestmobile.'" ');
            while($phoneRes3=mysqli_fetch_assoc($resphone3)){
                 

            $json_result .= '{
                "tourid": "'.$phoneRes1['id'].'",
                "refid": "'.$refId.'",
                "name": "' . $name . '",
                "agentname": "' . $phoneRes1['agentName'] . '",
                "email": "' . $emailData['email'] . '",
                "phone": "' . $Guestmobile.'",
                "status": "' . $phoneRes3['status']. '"
            },';
            
            if ($phoneRes3['status'] == 0) {
                $countStatusZero++;
            }
            }

        }
        if (in_array($mobile, $phone)){
        $statusupdate1 = "UPDATE `serviceGuestList` SET `status`=1,`updated_at`='$currentDate$currentTime',`manualCheckInType`='auto' where `mobile`='$mobile' AND serviceId='$serviceId'";
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