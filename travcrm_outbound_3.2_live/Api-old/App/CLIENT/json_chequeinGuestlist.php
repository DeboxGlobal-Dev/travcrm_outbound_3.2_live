<?php 
include "../../../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Content-Type: application/json");

$refId = $_REQUEST['refId'];
$rollId =$_REQUEST['rollId'];

if($rollId==1){
    if ($refId != '') {
    
        $rs3 = 'SELECT * FROM queryMaster WHERE referanceNumber="' .$refId. '"';
        $fetchmanager = mysqli_query(db(), $rs3);
        $managerId = mysqli_fetch_assoc($fetchmanager);
        $tourId = $managerId['id'];
        $json_result = '';
        $name="";
        $countStatusZero=0;

        
         $resphone1 = GetPageRecord('*','mice_guestListMaster','queryId="'.$tourId.'" ');
            while ($phoneRes1 = mysqli_fetch_assoc($resphone1)) {
           $name =$phoneRes1['guest_first_name']." ".$phoneRes1['last_name'];
    
        $json_result .= '{
            "tourid" : "' .$managerId['tourId']. '",
            "refid" : "'.$refId.'",
            "name" : "'.$name.'",
            "agentname" : "'.$managerId['agentName'].'",
            "email" : "'.$phoneRes1['email_address'].'",
            "phone" : "'.$phoneRes1['mobile_number'].'",
            "chequeindate": "' . $phoneRes1['checkOutDate'] . '",
            "chequeintime": "' . $phoneRes1['checkOutTime'] . '",
            "chequeintype": "' . $phoneRes1['manualCheckInType'] . '",
            "status" : "'.$phoneRes1['status1'].'"
        },';
        if ($phoneRes1['status1'] == 0) {
        $countStatusZero++;
    }
}
    
} else {
    $json_result .= '{
        "error" : "Please Enter Tour Id No"
    }';
}

if (!empty($json_result)) {
    echo '{
        "status": "true",
         "guestcount":"'.$countStatusZero.'",
        "results": [' . trim($json_result, ',') . ']
    }';
} else {
    echo '{
        "status": "false",
    "results" : [{"error": "No tour data found for the given Tour Id"}]
    }';
}

    
}else{
if ($refId != '') {
    
       $rs3 = 'SELECT * FROM queryMaster WHERE referanceNumber="' .$refId. '"';
        $fetchmanager = mysqli_query(db(), $rs3);
        $managerId = mysqli_fetch_assoc($fetchmanager);
        $tourId = $managerId['id'];
        $json_result = '';
        $name="";
        $countStatusZero=0;
        
         $resphone1 = GetPageRecord('*','mice_guestListMaster','queryId="'.$tourId.'" ');
            while ($phoneRes1 = mysqli_fetch_assoc($resphone1)) {
           $name =$phoneRes1['guest_first_name']." ".$phoneRes1['last_name'];

    
        $json_result .= '{
            "tourid" : "' .$managerId['tourId']. '",
            "refid" : "'.$refId.'",
            "name" : "'.$name.'",
            "agentname" : "'.$managerId['agentName'].'",
            "email" : "'.$phoneRes1['email_address'].'",
            "phone" : "'.$phoneRes1['mobile_number'].'",
            "chequeindate": "' . $phoneRes1['checkInDate'] . '",
            "chequeintime": "' . $phoneRes1['checkInTime'] . '",
            "chequeintype": "' . $phoneRes1['manualCheckInType'] . '",
            "status" : "'.$phoneRes1['status1'].'"
        },';
        if ($phoneRes1['status1'] == 1) {
        $countStatusZero++;
    }
}
    
} else {
    $json_result .= '{
        "error" : "Please Enter Tour Id No"
    }';
}

if (!empty($json_result)) {
    echo '{
        "status": "true",
         "guestcount":"'.$countStatusZero.'",
        "results": [' . trim($json_result, ',') . ']
    }';
} else {
    echo '{
        "status": "false",
    "results" : [{"error": "No tour data found for the given Tour Id"}]
    }';
}
}
?>