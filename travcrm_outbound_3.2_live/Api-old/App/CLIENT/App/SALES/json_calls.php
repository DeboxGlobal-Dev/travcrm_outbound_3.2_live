<?php
  header('Content-type: text/html');
  // include "../../../travcrm-dev/inc.php";
  include "../../../inc.php";
  // supplier list
  $json_result = "";
  $callsSql = "select * from callsMaster where 1  and deletestatus=0 order by id desc";
  $callsQuery=mysqli_query(db(),$callsSql); 
  while($callsData=mysqli_fetch_array($callsQuery)) { 
    // supplier date listing
    $callsTypeSql = "select * from directiontype where 1 and  id=".$callsData['directiontype']."";
    $callsTypeQuery=mysqli_query(db(),$callsTypeSql); 
    $callsTypeData=mysqli_fetch_array($callsTypeQuery);
    $callsType = $callsTypeData['name'];

    if ($callsData['clientType'] == 2) {
      
      $contactno =  getContactPersonPhone($callsData['companyId'], 'contacts');
    }
    if ($callsData['clientType'] != 2) {

      $contactno = getContactPersonPhone($callsData['companyId'], "corporate");
    }

      $companyname = getCorporateCompany($callsData['companyId']);
    $agentname = showClientTypeUserName($callsData['clientType'],$callsData['companyId']); 

    // if($callsData['status']==1){ 
    //   $status = 'shedule'; 
    // }
    // if($callsData['status']==2){ 
    //   $status = 'confirm'; 
    // }
    // if($callsData['status']==3){ 
    //   $status = 'canceled'; 
    // }
    if($callsData['status']==1){ 
      $status = 'Scheduled'; 
    }
    if($callsData['status']==2){ 
      $status = 'Held'; 
    }
    if($callsData['status']==3){ 
      $status = 'Cancelled'; 
    }

    $json_result.= '{
      "id" : "'.$callsData['id'].'",
      "callsubject" : "'.$callsData['subject'].'",
      "client" : "'.showClientTypeUserName($callsData['clientType'],$callsData['companyId']).'",
      "startdate" : "'.$callsData['fromDate'].'",
      "name" : "'.$name.'",
      "status" : "'.$status.'",
      "agenda" : "'.$agenda.'",
      "phoneno" : "'.$phoneno.'",
      "calltype" : "'.$callsType.'",
      "companyname" : "'.$companyname.'",
      "contactno" : "'.$contactno.'",
      "salesperson" : "'.getUserName($callsData['assignTo']).'",
      "clientType" : "'.$callsData['clientType'].'",
      "description" : "'.$callsData['description'].'",
      "campaign" : "'.$callsData['campaign'].'",
      "starttime" : "'.$callsData['starttime'].'",
      "followupdate" : "'.$callsData['followupdate'].'",
      "createdate" : "'.date('d/m/Y',$callsData['dateAdded']).'"
    },';
  }

  // json is here
  ?>
  {
    "status":"true",
    "results":[<?php echo trim($json_result, ',');?>]
  }