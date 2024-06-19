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
        $tourManagerId = $managerId['tourManager'];
        $json_result = '';
        $name="";
        $guestMobile="";
        
         $resphone1 = GetPageRecord('*','mice_guestListMaster','queryId="'.$tourId.'" ');
       while ($phoneRes1=mysqli_fetch_assoc($resphone1)) {
       $name =$phoneRes1['guest_first_name']." ".$phoneRes1['last_name'];
       $Id =$phoneRes1['id'];
       
        if($phoneRes1['mobile_number'] == ""){
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

    
        $json_result .= '{
            "id" : "' .$phoneRes1['id']. '",
            "tourid" : "'.$phoneRes1['tourId'].'",
            "refid" : "'.$refId.'",
            "name" : "'.$name.'",
            "agentname" : "'.$phoneRes1['agent_corporate_name'].'",
            "email" : "'.$phoneRes1['email_address'].'",
            "phone" : "'.$phoneRes1['mobile_number'].'",
            "seen" : "'.$count.'"
        },';
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

 
