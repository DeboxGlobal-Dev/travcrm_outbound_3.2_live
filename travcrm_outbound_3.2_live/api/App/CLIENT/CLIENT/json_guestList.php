<?php 
include "../../../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Content-Type: application/json");

$refId = $_REQUEST['refId'];

if($refId!= ''){
    
        $rs3 = 'SELECT * FROM queryMaster WHERE referanceNumber="'.$refId.'"';
        $fetchmanager = mysqli_query(db(), $rs3);
        $managerId = mysqli_fetch_assoc($fetchmanager);
        $tourId = $managerId['id'];
        $json_result = '';
        $name="";
         $resphone1 = GetPageRecord('*','contactsMaster','queryId2="'.$tourId.'" ');
       while ($phoneRes1=mysqli_fetch_assoc($resphone1)) {
       $name =$phoneRes1['firstName']." ".$phoneRes1['lastName'];
       
         $where2='masterId="'.$phoneRes1['id'].'" and sectionType="contacts" ';
        $rs2=GetPageRecord('*','phoneMaster',$where2);
        $phoneData=mysqli_fetch_assoc($rs2);
        
        $where3='masterId="'.$phoneRes1['id'].'" and sectionType="contacts" order by id desc';
        $rs4=GetPageRecord('*',_EMAIL_MASTER_,$where3);
        $emailData=mysqli_fetch_array($rs4);
        
         if($phoneData['phoneNo'] == ""){
            continue;
        }
       
      $count = 0;
        
        $resphone2 = GetPageRecord('*','tbl_guidemaster','id="'.$tourManagerId.'" ');
        $phoneRes2 = mysqli_fetch_assoc($resphone2);
        $managerphoneNo = $phoneRes2['phone'];
        
        $selectQuery = 'SELECT * FROM chatroom WHERE guestid="' . $Id . '" and mobile="'.$managerphoneNo.'"';
        $fetch = mysqli_query(db(), $selectQuery);
        
        if ($fetch && mysqli_num_rows($fetch) > 0) {
            while ($emailRes1 = mysqli_fetch_assoc($fetch)) {
                if ($emailRes1['seen'] == 0) {
                    $count++;
                }
            }
        }
        
       if($phoneData['phoneNo']!="" && $name!=""){
           
           
    
        $json_result .= '{
            "id" : "' .$phoneRes1['id']. '",
            "tourid" : "'.$phoneRes1['tourId'].'",
            "refid" : "'.$refId.'",
            "name" : "'.$name.'",
            "agentname" : "'.$phoneRes1['agentName'].'",
            "email" : "'.$emailData['email'].'",
            "phone" : "'. $phoneData['phoneNo'].'",
            "seen" : "'.$count.'"
        },';
       }
      }
    
} else {
    $json_result .= '{
        "results" :[{"error" : "Please Enter Tour Id No"}]
    }';
}

if (!empty($json_result)) {
    echo '{
        "status": "true",
        "results": [' . trim($json_result, ',') . ']
    }';
} else {
    echo '{
        "status": "false",
        "results: [{"error": "No tour data found for the given Tour Id"}]
    }';
        
  }

 
