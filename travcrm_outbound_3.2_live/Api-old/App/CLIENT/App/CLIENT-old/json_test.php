if($rollId==1){
    if (empty($mobile)) {
      if ($refId!='') {
        $rs3 = 'SELECT * FROM `queryMaster` WHERE `referanceNumber`="'.$refId.'"';
        $fetchmanager = mysqli_query(db(), $rs3);
        $managerId = mysqli_fetch_assoc($fetchmanager);
        $tourId = $managerId['id'];
print_r($tourId);die();
        $json_result='';
        $name="";
        $countStatusZero=0,
         $resphone1 = GetPageRecord('*','mice_guestListMaster','queryId="'.$tourId.'" ');
       while ($phoneRes1=mysqli_fetch_assoc($resphone1)) {
       $name =$phoneRes1['guest_first_name']." ".$phoneRes1['last_name'];

            $json_result .= '{
                "tourid": "'.$phoneRes1['id'].'",
                "refid": "'.$refId.'",
                "name": "' . $name . '",
                "agentname": "' . $phoneRes1['agent_corporate_name'] . '",
                "email": "' . $phoneRes1['email_address'] . '",
                "phone": "' . $phoneRes1['mobile_number'] . '",
                "status": "' . $phoneRes1['status1'] . '"
            },';

            if ($phoneRes1['status'] == 1) {
                $countStatusZero++;
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
            "results" :[{"error": "Please Enter Tour Id No"}]
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
        $countStatusZero=0,
         $resphone1 = GetPageRecord('*','mice_guestListMaster','queryId="'.$tourId.'" ');
       while ($phoneRes1=mysqli_fetch_assoc($resphone1)) {
       $name =$phoneRes1['guest_first_name']." ".$phoneRes1['last_name'];

            $json_result .= '{
                "tourid": "'.$phoneRes1['id'].'",
                "refid": "'.$refId.'",
                "name": "' . $name . '",
                "agentname": "' . $phoneRes1['agent_corporate_name'] . '",
                "email": "' . $phoneRes1['email_address'] . '",
                "phone": "' . $phoneRes1['mobile_number'] . '",
                "status": "' . $phoneRes1['status1'] . '"
            },';

            if ($phoneRes1['status'] == 1) {
                $countStatusZero++;
            }
        }
        if ($phoneRes1['mobile_number'] == $mobile) {
        $statusupdate = "UPDATE `mice_guestListMaster` SET `status1` = 0, `checkOutDate`='$currentDate', `checkOutTime`='$currentTime' WHERE `mobile_number` = '" . $mobile . "'";
        $updatequery = mysqli_query(db(), $statusupdate);
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
    
}else{
    if (empty($mobile)) {
      if ($refId != '') {
        $rs3 = 'SELECT * FROM queryMaster WHERE referanceNumber="'.$refId.'"';
        $fetchmanager = mysqli_query(db(), $rs3);
        $managerId = mysqli_fetch_assoc($fetchmanager);
                $tourId = $managerId['id'];
        $json_result = '';
        $name="";
        $countStatusZero=0,
         $resphone1 = GetPageRecord('*','mice_guestListMaster','queryId="'.$tourId.'" ');
           while ($phoneRes1=mysqli_fetch_assoc($resphone1)) {
           $name =$phoneRes1['guest_first_name']." ".$phoneRes1['last_name'];

            $json_result .= '{
                "tourid": "'.$phoneRes1['id'].'",
                "refid": "'.$refId.'",
                "name": "' . $name . '",
                "agentname": "' . $phoneRes1['agent_corporate_name'] . '",
                "email": "' . $phoneRes1['email_address'] . '",
                "phone": "' . $phoneRes1['mobile_number'] . '",
                "status": "' . $phoneRes1['status1'] . '"
            },';

                if ($phoneRes1['status'] == 0) {
                    $countStatusZero++;
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
                "results" :[{"error": "Please Enter Refrence Id No"}]
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
        $countStatusZero=0,
         $resphone1 = GetPageRecord('*','mice_guestListMaster','queryId="'.$tourId.'" ');
       while ($phoneRes1=mysqli_fetch_assoc($resphone1)) {
       $name =$phoneRes1['guest_first_name']." ".$phoneRes1['last_name'];

            $json_result .= '{
                "tourid": "'.$phoneRes1['id'].'",
                "refid": "'.$refId.'",
                "name": "' . $name . '",
                "agentname": "' . $phoneRes1['agent_corporate_name'] . '",
                "email": "' . $phoneRes1['email_address'] . '",
                "phone": "' . $phoneRes1['mobile_number'] . '",
                "status": "' . $phoneRes1['status1'] . '"
            },';

            if ($phoneRes1['status'] == 0) {
                $countStatusZero++;
            }
        }
        if ($phoneRes1['mobile_number'] == $mobile) {
        $statusupdate = "UPDATE `mice_guestListMaster` SET `status1` = 1, `checkInDate`='$currentDate', `checkInTime`='$currentTime' WHERE `mobile_number` = '" . $mobile . "'";
        $updatequery = mysqli_query(db(), $statusupdate);
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
            "results": [{"error": "Please Enter Refrence Id No"}]
            }';
        }
    
    }
}
