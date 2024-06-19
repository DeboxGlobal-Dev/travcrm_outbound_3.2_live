<?php
header('Content-type: text/html');
// include "../../../travcrm-dev/inc.php";
include "../../../inc.php";
header('Content-Type: application/json');
// include "../../config/logincheck.php"; 
// $select2='*';    
// $where2=' 1 group by assignTo';  
// $rs2=GetPageRecord($select2,_MEETINGS_MASTER_,$where2); 

$meetingsQuery = "SELECT * FROM meetingsMaster";
$sqliquery = mysqli_query(db(),$meetingsQuery);
while($meetingsData=mysqli_fetch_array($sqliquery)){ 
$select='*';    
$where=' id='.$meetingsData['assignTo'].' order by firstName asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 

$resListing=mysqli_fetch_array($rs);
    $firstName=$resListing['firstName'];
    $lastName=$resListing['lastName'];
    
    $rs11=GetPageRecord('name,id',_COUNTRY_MASTER_,'id="'.$meetingsData['country'].'"'); 
    $resList11=mysqli_fetch_array($rs11);
    $countryName=$resList11['name'];
     
    // $json_salesperson.= '{
    //   "assignTo" : "'.$firstName.' '.$lastName.'"
    // },';

/////////////////////////////////////////////////////////
    // $searchFieldcommon=clean($_GET['searchFieldcommon']);
    // $assignto='';
    // if($_GET['assignto']!=''){
    // $assignto=' and	assignTo='.$_GET['assignto'].'';
    // }
    // if($_REQUEST['keyword']!=''){
    //     $wheresearch2=' and (assignTo in ( select id from '._MEETINGS_MASTER_.' where assignTo like "%'.$_REQUEST['keyword'].'%" or assignTo like "%'.$_REQUEST['keyword'].'%"))';   
    // }
    // $searchFieldcommonquery='';
    // if($searchFieldcommon!=''){
    // $searchFieldcommonquery=' and (subject like "%'.$searchFieldcommon.'%" or companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$searchFieldcommon.'%"))';
    // } 
    // $where3='';
    // $where3='where 1 '.$searchFieldcommonquery.' and deletestatus=0 order by dateAdded desc';  
    // $rs3=GetRecordList('*',_MEETINGS_MASTER_,$where3); 
    // while($meetingsData=mysqli_fetch_array($rs3[0])){ 
    // supplier date listing

    $meetingsOutcomeSql = "select * from meetingsOutcome where 1 and  id=".$meetingsData['directiontype']."";
    $meetingsOutcomeQuery=mysqli_query(db(),$meetingsOutcomeSql); 
    $meetingsOutcomeData=mysqli_fetch_array($meetingsOutcomeQuery);
    $meetingsOutcome = $meetingsOutcomeData['name'];


    if ($meetingsData['clientType'] == 2) {
      
      $contactno =  getContactPersonPhone($meetingsData['companyId'], 'contacts');
    }
    if ($meetingsData['clientType'] != 2) {

      $contactno = getContactPersonPhone($meetingsData['companyId'], "corporate");
    }
    
      $companyname = getCorporateCompany($meetingsData['companyId']);
    $agentname = showClientTypeUserName($meetingsData['clientType'],$meetingsData['companyId']); 


    if($meetingsData['status']==1){ 
      $status = 'shedule'; 
    }
    if($meetingsData['status']==2){ 
      $status = 'confirm'; 
    }
    if($meetingsData['status']==3){ 
      $status = 'canceled'; 
    }
    if($meetingsData['status']==1){ 
      $status = 'Scheduled'; 
    }
    if($meetingsData['status']==2){ 
      $status = 'Held'; 
    }
    if($meetingsData['status']==3){ 
      $status = 'Canceled'; 
    }

    $json_result.= '{
      "id" : "'.$meetingsData['id'].'",
      "leadid" : "'.makeQueryId($meetingsData['id']).'",
      "meeting_agenda" : "'.$meetingsData['subject'].'",
      "client" : "'.showClientTypeUserName($meetingsData['clientType'],$meetingsData['companyId']).'",
      "startdate" : "'.$meetingsData['fromDate'].'",
      "status" : "'.$status.'",
      "contactno" : "'.$contactno.'",
      "meetingsOutcome" : "'.$meetingsOutcome.'",
      "salesperson" : "'.getUserName($meetingsData['assignTo']).'",
      "clientType" : "'.$meetingsData['clientType'].'",
      "description" : "'.$meetingsData['description'].'",
      "campaign" : "'.$meetingsData['campaign'].'",
      "starttime" : "'.$meetingsData['starttime'].'",
      "followupdate" : "'.$meetingsData['followupdate'].'",
      "createdate" : "'.date('d/m/Y',$meetingsData['dateAdded']).'",
      "location" : "'.$countryName.'",
      "phoneNo"  : "'.$phoneNo.'"
    },';
  }
?>
{
"status":"true",
"json_result":[<?php echo trim($json_result, ',');?>]
}
