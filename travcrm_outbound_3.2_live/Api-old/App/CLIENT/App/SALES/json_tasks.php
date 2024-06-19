<?php
  header('Content-type: text/html');
  include "../../../inc.php";
  // include "../../../travcrm-dev/inc.php";
  // supplier list
  $json_result = "";
  $tasksSql = "select * from tasksMaster where 1  and deletestatus=0 order by id desc";
  $tasksQuery=mysqli_query(db(),$tasksSql); 
  while($tasksData=mysqli_fetch_array($tasksQuery)) { 
    if($tasksData['clientType']==10){ 
      $clientname = 'My Task'; 
    } 
    else { 
      $clientname = showClientTypeUserName($tasksData['clientType'],$tasksData['companyId']); 
    }
    
     
    
     

    // company master 
    // if($tasksData['clientType'] == 1){ 
    //   $contactno = getPrimaryPhone($tasksData['companyId'],'corporate');
    // }
    // if($tasksData['clientType'] == 2){ 
    //   $contactno = getPrimaryPhone($tasksData['companyId'],'contacts');
    // }

    if ($tasksData['clientType'] == 2) {
      
      $contactno =  getContactPersonPhone($tasksData['companyId'], 'contacts');
    }
    if ($tasksData['clientType'] != 2) {

      $contactno = getContactPersonPhone($tasksData['companyId'], "corporate");
    }
    
  $companyname = getCorporateCompany($tasksData['companyId']);
    $agentname = showClientTypeUserName($tasksData['clientType'],$tasksData['companyId']); 


    // supplier date listing
    if($tasksData['status']==1){ 
      $status = 'shedule'; 
    }
    if($tasksData['status']==2){ 
      $status = 'confirm'; 
    }
    if($tasksData['status']==3){ 
      $status = 'canceled'; 
    }
    if($tasksData['status']==1){ 
      $status = 'Scheduled'; 
    }
    if($tasksData['status']==2){ 
      $status = 'Held'; 
    }
    if($tasksData['status']==3){ 
      $status = 'Canceled'; 
    }

    $json_result.= '{
      "id" : "'.$tasksData['id'].'",
      "tasksubject" : "'.$tasksData['subject'].'",
      "client" : "'.$clientname.'",
      "contactno" : "'.$contactno.'",
      "startdate" : "'.$tasksData['fromDate'].'",
      "status" : "'.$status.'",
      "salesperson" : "'.getUserName($tasksData['assignTo']).'",
      "createdate" : "'.date('d/m/Y',$tasksData['dateAdded']).'",
      "clientType" : "'.$tasksData['clientType'].'",
      "description" : "'.$tasksData['description'].'",
      "directiontype" : "'.$tasksData['directiontype'].'",
      "starttime" : "'.$tasksData['starttime'].'",
      "reminderTime" : "'.$tasksData['reminderTime'].'",
      "priorty" : "'.$priorty.'",
      "phoneno" : "'.$phoneno.'"
    },';
  }

  // json is here
  ?>
  {
    "status":"true",
    "results":[<?php echo trim($json_result, ',');?>]
  }