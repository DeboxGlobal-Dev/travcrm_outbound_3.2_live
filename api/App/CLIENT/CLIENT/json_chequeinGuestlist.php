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

        
         $resphone1 = GetPageRecord('*','contactsMaster','queryId2="'.$tourId.'" ');
       while ($phoneRes1=mysqli_fetch_assoc($resphone1)) {
       $name =$phoneRes1['firstName']." ".$phoneRes1['lastName'];
       
        $where2='masterId="'.$phoneRes1['id'].'" and sectionType="contacts" ';
        $rs2=GetPageRecord('*','phoneMaster',$where2);
        $phoneData=mysqli_fetch_assoc($rs2);
        $Guestmobile = $phoneData['phoneNo'];
        
        $where3='masterId="'.$phoneRes1['id'].'" and sectionType="contacts" order by id desc';
        $rs4=GetPageRecord('*',_EMAIL_MASTER_,$where3);
        $emailData=mysqli_fetch_array($rs4);
    
        $json_result .= '{
            "tourid" : "' .$managerId['tourId']. '",
            "refid" : "'.$refId.'",
            "name" : "'.$name.'",
            "agentname" : "'.$phoneRes1['agentName'].'",
            "email" : "'.$emailData['email'].'",
            "phone" : "'.$phoneData['phoneNo'].'",
            "chequeindate": "' . $phoneData['checkOutDate'] . '",
            "chequeintime": "' . $phoneData['checkOutTime'] . '",
            "chequeintype": "' . $phoneData['manualCheckInType'] . '",
            "status" : "'.$phoneData['status1'].'"
        },';
        if ($phoneData['status1'] == 0) {
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
         "guestcount": "'.$countStatusZero.'",
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
        
          $resphone1 = GetPageRecord('*','contactsMaster','queryId2="'.$tourId.'" ');
       while ($phoneRes1=mysqli_fetch_assoc($resphone1)) {
       $name =$phoneRes1['firstName']." ".$phoneRes1['lastName'];
       
        $where2='masterId="'.$phoneRes1['id'].'" and sectionType="contacts" ';
        $rs2=GetPageRecord('*','phoneMaster',$where2);
        $phoneData=mysqli_fetch_assoc($rs2);
        $Guestmobile = $phoneData['phoneNo'];
        
        $where3='masterId="'.$phoneRes1['id'].'" and sectionType="contacts" order by id desc';
        $rs4=GetPageRecord('*',_EMAIL_MASTER_,$where3);
        $emailData=mysqli_fetch_array($rs4);
    
        $json_result .= '{
            "tourid" : "' .$managerId['tourId']. '",
            "refid" : "'.$refId.'",
            "name" : "'.$name.'",
            "agentname" : "'.$phoneRes1['agentName'].'",
            "email" : "'.$emailData['email'].'",
            "phone" : "'.$phoneData['phoneNo'].'",
            "chequeindate": "' . $phoneData['checkOutDate'] . '",
            "chequeintime": "' . $phoneData['checkOutTime'] . '",
            "chequeintype": "' . $phoneData['manualCheckInType'] . '",
            "status" : "'.$phoneData['status1'].'"
        },';
        if ($phoneData['status1'] == 1) {
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
         "guestcount": "'.$countStatusZero.'",
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