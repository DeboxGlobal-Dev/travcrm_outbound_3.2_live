<?php
	header('Content-type: text/html');
	include "../../../inc.php";
	// include "../../config/logincheck.php"; 

	// sales revenue 
	if($loginuserprofileId==1){ 
	    $wheresearchassign=' 1 ';
	} 
	else { 
	    $wheresearchassign=' ( id in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].') ) or id in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))  or id in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))  or id in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))) or id in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))) or id in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))))) or id in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))))))  '; 
	    $wheresearchassign='( '.$wheresearchassign.'  or id = '.$_REQUEST['userid'].' or addedBy = '.$_REQUEST['userid'].') ';
	} 

	$year=date('Y');
	$monthName=date('F');
	$thismonth=date('m');

	if($_GET['assignto']!=''){  
	    $whereQuery=''; 
	    $whereQuery=' and  assignTo='.decode($_GET['assignto']).''; 
	    $whereQuery222=' and  assign_to='.decode($_GET['assignto']).''; 
	}

	$select=''; 
	$where=''; 
	$rs='';   
	$select='*'; 
	$where=' year='.$year.' '.$whereQuery222.''; 
	$rs=GetPageRecord($select,_TARGET_MASTER_,$where); 
	$resultTarget=mysqli_fetch_array($rs);  

	$select=''; 
	$where=''; 
	$rs='';  
	$select='*';  
	$salesrevenue_target_monethvaluetotal=0;  
	$salesrevenue_opportunity_monethvaluetotal=0;  
	$monthvalue=0; 
	$monthvalue_opportunity=0; 
	$totalcallonly_stage=0; 
	$initialmeeting_stage=0; 
	$quotation_stage=0; 
	$followupforclose_stage=0; 
	$total_achievement=0; 
	$total_lost=0;

	$m=date('F'); 
	if($_GET['assignto']!=''){  
	    $salesrevenue_target_monethvaluetotal = $resultTarget["".$m.""]; 
	} 
	else { 
	    $menu22=mysqli_query(db(),"select * from "._TARGET_MASTER_." where 1 "); 
	    while($rest22=mysqli_fetch_array($menu22)){ 
	        $salesrevenue_target_monethvaluetotal = $rest22["".$m.""]+$salesrevenue_target_monethvaluetotal; 
	    }
	}
	// totalsales block
	if($totalSales*100/$salesrevenue_target_monethvaluetotal>100){ 
		$percentage = '100'; 
	}
	else { 
		$percentage = $totalSales*100/$salesrevenue_target_monethvaluetotal; 
	}
	// end of the totalsales report block
	$totalSales='0';
	$menu2=mysqli_query(db(),"select id from "._QUERY_MASTER_." where 1 ".$whereQuery." "); 
	while($rest2=mysqli_fetch_array($menu2)){ 
	    
	    $select=''; 
	    $where=''; 
	    $rs='';   
	    $select='*'; 
	    $where=' queryId='.$rest2['id'].''; 
	    $rs=GetPageRecord($select,'agentPaymentRequest',$where); 
	    $resultS=mysqli_fetch_array($rs);  
	    $totalSales=$totalSales+$resultS['finalCost'];

	} 
	// json result variables 
	$json_result = "";	
	if ($_REQUEST['todolist'] == "today") {
		$wheresearch = " 1 and toDoDate='".date('Y-m-d')."'";
	}else{
		$wheresearch = " 1 ";
	}
	$module = "";
	$view = "";
	$id = "";
	
	$todoSql = "select * from toDoTimeLine where ".$wheresearch." and deleteStatus=0 order by toDotime asc";
	$todoQuery = mysqli_query(db(),$todoSql);
	$todoNumRows = mysqli_num_rows($todoQuery);
	while ($todoData = mysqli_fetch_array($todoQuery)) {
	  	if($todoData['toDoDate']!='' && $todoData['toDoDate']!='1970-01-01' && $todoData['toDoDate']!='0000-00-00'){
		  	$todoDatatodo=date('Y-m-d',strtotime($todoData['toDoDate']));
		    $select='';
			$where='';
			$rs='';
			$select='*'; 
			$where='id='.$todoData['serviceId'].''; 
			$rs=GetPageRecord($select,_QUERY_MASTER_,$where);
			$resultpage=mysqli_fetch_array($rs); 
			
			// get the first  column  sssssss ssssss ssssss ssssss
			if($todoData['serviceId']!='' && $todoData['serviceId']!='0'){
				$module = "query";
				$view = "yes";
				// $id = encode($todoData['serviceId']);
				$QueryId = $resultpage['displayId'];
			}
			else if($todoData['serviceId']==0 && $todoData['serviceType']=='Task') {
				$module = "tasks";
				$view = "yes";
				// $id = encode($todoData['taskId']);
				$QueryId = $todoData['taskId'];
			}
			else if($todoData['serviceId']==0 && $todoData['serviceType']=='Calls'){
				$module = "calls";
				$view = "yes";
				// $id = encode($todoData['taskId']);
				$QueryId = $todoData['taskId'];
			}
			else{
				$module = "meetings";
				$view = "yes";
				// $id = encode($todoData['taskId']);
				$QueryId = $todoData['taskId'];
			}
			// get the expired or not
			if($todoDatatodo >= date('Y-m-d')){
				$isExpired = 'true';
			}
			elseif($todoDatatodo < date('Y-m-d')){
				$isExpired = 'false';
			}
			else{
				$isExpired = 'true';
			}
			// client details
			$clientname = showClientTypeUserName($resultpage['clientType'],$resultpage['companyId']);
			$clientphone = $resultpage['guest1phone'];
			// make json 
			$json_result.= '{
				"id" : "'.$todoData['id'].'",
				"module" : "calls",
				"view" : "yes",
				"QueryId" : "'.makeQueryId($QueryId).'",
				"clientname" : "'.$clientname.'",
				"clientphone" : "'.$clientphone.'",
				"Date" : "'.date('d-m-Y',strtotime($todoData['toDoDate'])).'",
				"isExpired" : '.$isExpired.',
				"Time" : "'.$todoData['toDotime'].'",
				"Type" : "'.$todoData['serviceType'].'"
				
			},';  
		}
	}
	// json is here
?>
	{	
		"sales":"<?php echo $totalSales; ?>",
		"percentage":"<?php echo $percentage; ?>",
		"target":"<?php echo $salesrevenue_target_monethvaluetotal; ?>",
		"status":true,
		"totalResults":"<?php echo $todoNumRows; ?>",
		"articles":[<?php echo trim($json_result, ',');?>]
	}
