<?php
include "inc.php";  

if($_REQUEST['action']=='hotel' && $_REQUEST['id']>0){
		  
	$spacialReq= $_REQUEST['spacialReq'];     
	$namevalue='specialRequest="'.$spacialReq.'"';
	updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.$_REQUEST['id'].'"');

}


if($_REQUEST['action']=='transfer' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	updatelisting(_QUOTATION_TRANSFER_MASTER_,'remark="'.$spacialReq.'"','id="'.$_REQUEST['id'].'"');

}


if($_REQUEST['action']=='entrance' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	updatelisting(_QUOTATION_ENTRANCE_MASTER_,'remark="'.$spacialReq.'"','id="'.$_REQUEST['id'].'"');

}

if($_REQUEST['action']=='activity' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	updatelisting(_QUOTATION_OTHER_ACTIVITY_MASTER_,'remark="'.$spacialReq.'"','id="'.$_REQUEST['id'].'"');

}

if($_REQUEST['action']=='train' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	updatelisting(_QUOTATION_TRAINS_MASTER_,'remark="'.$spacialReq.'"','id="'.$_REQUEST['id'].'"');

}

if($_REQUEST['action']=='flight' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	updatelisting(_QUOTATION_FLIGHT_MASTER_,'remark="'.$spacialReq.'"','id="'.$_REQUEST['id'].'"');

}


if($_REQUEST['action']=='guide' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	updatelisting(_QUOTATION_GUIDE_MASTER_,'remark="'.$spacialReq.'"','id="'.$_REQUEST['id'].'"');

}



if($_REQUEST['action']=='hotelConfirmation' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];    


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmationTime="'.$confirmationTime.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalQuote',$namevalue,'id="'.$_REQUEST['id'].'"');
	?>
	<script>
	parent.loadquotationfun(2);
	</script>
	<?php

}


if($_REQUEST['action']=='transferConfirmation' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];    


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalQuotetransfer',$namevalue,'id="'.$_REQUEST['id'].'"');

	?>
	<script>
	parent.loadquotationfun(2);
	</script>
	<?php
}


if($_REQUEST['action']=='entranceConfirmation' && $_REQUEST['id']>0){
		  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];    


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalQuoteEntrance',$namevalue,'id="'.$_REQUEST['id'].'"');

	?>
	<script>
	parent.loadquotationfun(2);
	</script>
	<?php
}


if($_REQUEST['action']=='activityConfirmation' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];    


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalQuoteActivity',$namevalue,'id="'.$_REQUEST['id'].'"');

	?>
	<script>
	parent.loadquotationfun(2);
	</script>
	<?php
}


if($_REQUEST['action']=='finalQuoteTrains' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];    


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('trainConfirmation',$namevalue,'id="'.$_REQUEST['id'].'"');

	?>
	<script>
	parent.loadquotationfun(2);
	</script>
	<?php
}


if($_REQUEST['action']=='flightConfirmation' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];    


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalQuoteFlights',$namevalue,'id="'.$_REQUEST['id'].'"');

	?>
	<script>
	parent.loadquotationfun(2);
	</script>
	<?php
}


if($_REQUEST['action']=='guideConfirmation' && $_REQUEST['id']>0){
		  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];    


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalQuoteGuides',$namevalue,'id="'.$_REQUEST['id'].'"');

	?>
	<script>
	parent.loadquotationfun(2);
	</script>
	<?php
}
 


if($_REQUEST['action']=='updateFinalQuote_hotel' && $_REQUEST['hotelfinalId']>0){
		  
	$hotelfinalId=$_REQUEST['hotelfinalId']; 
	$supplierId=$_REQUEST['supplierId'];  

	$roomsinglecost=$_REQUEST['roomsinglecost'];
	$roomdoublecost=$_REQUEST['roomdoublecost'];
	$roomtriplecost=$_REQUEST['roomtriplecost']; 

	$roomsingle=$_REQUEST['roomsingle'];
	$roomdouble=$_REQUEST['roomdouble'];
	$roomtriple=$_REQUEST['roomtriple'];  

	$namevalue ='supplierId="'.$supplierId.'",roomSingleCost="'.$roomsinglecost.'",roomDoubleCost="'.$roomdoublecost.'",roomTripleCost="'.$roomtriplecost.'",roomSingle="'.$roomsingle.'",roomDouble="'.$roomdouble.'",roomTriple="'.$roomtriple.'"';  

	$where='id="'.$hotelfinalId.'"  ';  
	$update = updatelisting('finalQuote',$namevalue,$where); 

	// $where1='serviceId="'.$quotationId.'" and taskId = "'.$hotelfinalId.'" and serviceType="hotel_supp_conf"'; 
	// $rs1=GetPageRecord('*',_TO_DO_TIMELINE_,$where1);
	// if(mysqli_num_rows($rs1) > 0){
	// 	$wherex='serviceId='.$quotationId.' and taskId = "'.$hotelfinalId.'" and serviceType="hotel_supp_conf"';
	// 	$re ='followupDate="'.$followupDateTime.'"';  
	// 	$update = updatelisting(_TO_DO_TIMELINE_,$re,$wherex);

	// }else{
	// 		$re ='serviceId="'.$quotationId.'",taskId="'.$hotelfinalId.'",serviceType="hotel_supp_conf",followupDate="'.$followupDateTime.'"'; 
	// 	addlistinggetlastid(_TO_DO_TIMELINE_,$re);
	// }

}	

if($_REQUEST['action']=='updateFinalQuote_transfer' && $_REQUEST['transferfinalId']>0){

	$transferfinalId=$_REQUEST['transferfinalId'];
	$vehicleCost=$_REQUEST['vehicleCost'];  

	$namevalue ='shareQuoteStatus="'.$manualStatus.'",followupDate="'.date('Y-m-d H:i:s', strtotime($followupDateTime)).'",vehicleCost="'.$vehicleCost.'",remarks="'.$remarks.'"';  
	$where='id="'.$transferfinalId.'" ';  
	$update = updatelisting('finalQuotetransfer',$namevalue,$where); 

	// $where1='serviceId="'.$quotationId.'" and taskId = "'.$transferfinalId.'" and serviceType="transfer_supp_conf"'; 
	// $rs1=GetPageRecord('*',_TO_DO_TIMELINE_,$where1);
	// if(mysqli_num_rows($rs1) > 0){
	// 	$wherex='serviceId='.$quotationId.' and taskId = "'.$transferfinalId.'" and serviceType="transfer_supp_conf"';
	// 	$re ='followupDate="'.$followupDateTime.'"';   
	// 	$update = updatelisting(_TO_DO_TIMELINE_,$re,$wherex);

	// }else{
	// 		$re ='serviceId="'.$quotationId.'",taskId="'.$transferfinalId.'",serviceType="transfer_supp_conf",followupDate="'.$followupDateTime.'"'; 
	// 	addlistinggetlastid(_TO_DO_TIMELINE_,$re);
	// }
}

if($_REQUEST['action']=='updateFinalQuote_flight' && $_REQUEST['flightfinalId']>0){


	$flightfinalId=$_REQUEST['flightfinalId'];
   	$supplierId=$_REQUEST['supplierId']; 

	$adultCost=$_REQUEST['adultCost']; 
	$childCost=$_REQUEST['childCost']; 
	$infantCost=$_REQUEST['infantCost']; 

	$namevalue ='supplierId="'.$supplierId.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'"';  
	
	$where='id="'.$flightfinalId.'"';  
	$update = updatelisting('finalQuoteFligts',$namevalue,$where); 

	// $where1='serviceId="'.$quotationId.'" and taskId = "'.$flightfinalId.'" and serviceType="flight_supp_conf"'; 
	// $rs1=GetPageRecord('*',_TO_DO_TIMELINE_,$where1);
	// if(mysqli_num_rows($rs1) > 0){
	// 	$wherex='serviceId='.$quotationId.' and taskId = "'.$flightfinalId.'" and serviceType="flight_supp_conf"';
	// 	$re ='followupDate="'.$followupDateTime.'"';    
	// 	$update = updatelisting(_TO_DO_TIMELINE_,$re,$wherex);
		
	// }else{
 // 		$re ='serviceId="'.$quotationId.'",taskId="'.$flightfinalId.'",serviceType="flight_supp_conf",followupDate="'.$followupDateTime.'"'; 
	// 	addlistinggetlastid(_TO_DO_TIMELINE_,$re);
	// }
}

if($_REQUEST['action']=='updateFinalQuote_guide' && $_REQUEST['guidefinalId']>0){

	$guidefinalId=$_REQUEST['guidefinalId'];
  	$guideId=$_REQUEST['guideId'];
	$supplierId=$_REQUEST['supplierId'];  
	$adultCost=$_REQUEST['adultCost']; 
 
	$namevalue ='supplierId="'.$supplierId.'",adultCost="'.$adultCost.'"';  

	$where='id="'.$guidefinalId.'"';  
	$update = updatelisting('finalQuoteGuides',$namevalue,$where); 

	// $where1='serviceId="'.$quotationId.'" and taskId = "'.$guidefinalId.'" and serviceType="guide_supp_conf"'; 
	// $rs1=GetPageRecord('*',_TO_DO_TIMELINE_,$where1);
	// if(mysqli_num_rows($rs1) > 0){
	// $wherex='serviceId='.$quotationId.' and taskId = "'.$guidefinalId.'" and serviceType="guide_supp_conf"';
	// $re ='followupDate="'.$followupDateTime.'"';    
	// $update = updatelisting(_TO_DO_TIMELINE_,$re,$wherex);

	// }else{
	// $re ='serviceId="'.$quotationId.'",taskId="'.$guidefinalId.'",serviceType="guide_supp_conf",followupDate="'.$followupDateTime.'"'; 
	// addlistinggetlastid(_TO_DO_TIMELINE_,$re);
	// }

}

if($_REQUEST['action']=='updateFinalQuote_train' && $_REQUEST['trainfinalId']>0){

	$trainfinalId=$_REQUEST['trainfinalId']; 
 	$supplierId=$_REQUEST['supplierId']; 

	$adultCost=$_REQUEST['adultCost']; 
	$childCost=$_REQUEST['childCost'];
	$infantCost=$_REQUEST['infantCost'];
 
	$namevalue ='supplierId="'.$supplierId.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'"';  

	$where='id="'.$trainfinalId.'"';  
	$update = updatelisting('finalQuoteTrains',$namevalue,$where); 

	// $where1='serviceId="'.$quotationId.'" and taskId = "'.$trainfinalId.'" and serviceType="train_supp_conf"'; 
	// $rs1=GetPageRecord('*',_TO_DO_TIMELINE_,$where1);
	// if(mysqli_num_rows($rs1) > 0){
	// $wherex='serviceId='.$quotationId.' and taskId = "'.$trainfinalId.'" and serviceType="train_supp_conf"';
	// $re ='followupDate="'.$followupDateTime.'"';    
	// $update = updatelisting(_TO_DO_TIMELINE_,$re,$wherex);

	// }else{
	// $re ='serviceId="'.$quotationId.'",taskId="'.$trainfinalId.'",serviceType="train_supp_conf",followupDate="'.$followupDateTime.'"'; 
	// addlistinggetlastid(_TO_DO_TIMELINE_,$re);
	// }

}

if($_REQUEST['action']=='updateFinalQuote_entrance' && $_REQUEST['hotelfinalId']>0){

	$entrancefinalId=$_REQUEST['entrancefinalId'];
	$supplierId=$_REQUEST['supplierId'];

	$adultCost=$_REQUEST['adultCost']; 
	$childCost=$_REQUEST['childCost'];
	$infantCost=$_REQUEST['infantCost'];

	$namevalue ='supplierId="'.$supplierId.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'"';  

	$where='id="'.$entrancefinalId.'" ';  
	$update = updatelisting('finalQuoteEntrance',$namevalue,$where); 

	// $where1='serviceId="'.$quotationId.'" and taskId = "'.$entrancefinalId.'" and serviceType="entrance_supp_conf"'; 
	// $rs1=GetPageRecord('*',_TO_DO_TIMELINE_,$where1);
	// if(mysqli_num_rows($rs1) > 0){
	// $wherex='serviceId='.$quotationId.' and taskId = "'.$entrancefinalId.'" and serviceType="entrance_supp_conf"';
	// $re ='followupDate="'.$followupDateTime.'"';   
	// $update = updatelisting(_TO_DO_TIMELINE_,$re,$wherex);

	// }else{
	// $re ='serviceId="'.$quotationId.'",taskId="'.$entrancefinalId.'",serviceType="entrance_supp_conf",followupDate="'.$followupDateTime.'"'; 
	// addlistinggetlastid(_TO_DO_TIMELINE_,$re);
	// }

}

if($_REQUEST['action']=='updateFinalQuote_activity' && $_REQUEST['activityfinalId']>0){

	$activityfinalId=$_REQUEST['activityfinalId'];
	$supplierId=$_REQUEST['supplierId']; 

	$activityCost=$_REQUEST['activityCost']; 
	$maxpax=$_REQUEST['maxpax'];
	$perPaxCost=$_REQUEST['perPaxCost'];



	$namevalue ='supplierId="'.$supplierId.'",activityCost="'.$activityCost.'",maxpax="'.$maxpax.'",perPaxCost="'.$perPaxCost.'"';  

	$where='id="'.$activityfinalId.'"';  
	$update = updatelisting('finalQuoteActivity',$namevalue,$where); 

	// $where1='serviceId="'.$quotationId.'" and taskId = "'.$activityfinalId.'" and serviceType="activity_supp_conf"'; 
	// $rs1=GetPageRecord('*',_TO_DO_TIMELINE_,$where1);
	// if(mysqli_num_rows($rs1) > 0){
	// $wherex='serviceId='.$quotationId.' and taskId = "'.$activityfinalId.'" and serviceType="activity_supp_conf"';
	// $re ='followupDate="'.$followupDateTime.'"';    
	// $update = updatelisting(_TO_DO_TIMELINE_,$re,$wherex);

	// }else{
	// $re ='serviceId="'.$quotationId.'",taskId="'.$activityfinalId.'",serviceType="activity_supp_conf",followupDate="'.$followupDateTime.'"'; 
	// addlistinggetlastid(_TO_DO_TIMELINE_,$re);
	// }

}


?>