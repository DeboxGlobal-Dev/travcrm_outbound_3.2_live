<?php
include "inc.php";  
if($_REQUEST['action']=='finalQuotSupplierStatus' && $_REQUEST['id']>0){
		  	  
	$supplierId= $_REQUEST['supplierId'];    
	$queryId= $_REQUEST['queryId'];        
	$quotationId= $_REQUEST['quotationId'];    
	$status= $_REQUEST['status'];      

	$namevalue='supplierId="'.$supplierId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",status="'.$status.'"';
	updatelisting('finalQuotSupplierStatus',$namevalue,'id="'.$_REQUEST['id'].'"');
	?>
	<script>
	parent.alert('Status Updated'); 
	</script>
	<?php

}
if($_REQUEST['action']=='specialRequest' && $_REQUEST['tableName']!='' && $_REQUEST['id']>0){
	
	$namevalue='specialRequest="'.$_REQUEST['spacialReq'].'"';
	updatelisting($_REQUEST['tableName'],$namevalue,'id="'.$_REQUEST['id'].'"');

}


//confirm status service wise
if($_REQUEST['action']=='confirm_status' and $_REQUEST['serviceType']=='hotel' && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalQuote',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
}
if($_REQUEST['action']=='confirm_status' and ($_REQUEST['serviceType']=='transfer' || $_REQUEST['serviceType']=='transportation') && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalQuotetransfer',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
}
if($_REQUEST['action']=='confirm_status' and $_REQUEST['serviceType']=='entrance' && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalQuoteEntrance',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
}
if($_REQUEST['action']=='confirm_status' and $_REQUEST['serviceType']=='ferry' && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalQuoteFerry',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
}
if($_REQUEST['action']=='confirm_status' and $_REQUEST['serviceType']=='activity' && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalQuoteActivity',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
}
if($_REQUEST['action']=='confirm_status' and $_REQUEST['serviceType']=='train' && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalQuoteTrains',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
}
if($_REQUEST['action']=='confirm_status' and $_REQUEST['serviceType']=='flight' && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalQuoteFlights',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
}

if($_REQUEST['action']=='confirm_status' and $_REQUEST['serviceType']=='visa' && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalQuoteVisa',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
}

if($_REQUEST['action']=='confirm_status' and $_REQUEST['serviceType']=='insurance' && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalQuoteInsurance',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
}

if($_REQUEST['action']=='confirm_status' and $_REQUEST['serviceType']=='passport' && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalQuotePassport',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
}

if($_REQUEST['action']=='confirm_status' and $_REQUEST['serviceType']=='guide' && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalQuoteGuides',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
}

if($_REQUEST['action']=='confirm_status' and $_REQUEST['serviceType']=='enroute' && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalQuoteEnroute',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
}

if($_REQUEST['action']=='confirm_status' and $_REQUEST['serviceType']=='cruise' && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalQuoteCruise',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
}

if($_REQUEST['action']=='confirm_status' and $_REQUEST['serviceType']=='mealPlan' && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalQuoteMealPlan',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
}

if($_REQUEST['action']=='confirm_status' and $_REQUEST['serviceType']=='additional' && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalQuoteExtra',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
}

if($_REQUEST['action']=='confirm_status' and $_REQUEST['serviceType']=='package' && $_REQUEST['serviceId']>0){
	$namevalue='manualStatus="'.trim($_REQUEST['manualStatus']).'"';
	updatelisting('finalPackWiseRateMaster',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
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
	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}

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

	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}
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

	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}
}

if($_REQUEST['action']=='ferryConfirmation' && $_REQUEST['id']>0){
		  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];    


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalQuoteFerry',$namevalue,'id="'.$_REQUEST['id'].'"');

	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}
}

if($_REQUEST['action']=='cruiseConfirmation' && $_REQUEST['id']>0){
		  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];    


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalQuoteCruise',$namevalue,'id="'.$_REQUEST['id'].'"');

	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}
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

	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}
}


// started trains files uploaded
if($_REQUEST['action']=="trainFileUploaded" ){
$quotationId=$_REQUEST['trainFile'];
$queryId=$_REQUEST['trainId'];

$datef=time(); 
if($_FILES['trainFile']['name']!=''){ 
    $file_name=$_FILES['trainFile']['name']; 
    $ext=$file_name;
    $file_name=str_replace (" ", "",$datef.$ext);
    copy($_FILES['trainFile']['tmp_name'],"upload/".$file_name);
    $image=$file_name;
	$namevalue ='image="'.$image.'"';
	updatelisting('finalQuoteTrains',$namevalue,'id="'.$_REQUEST['trainId'].'"');
}   
}
if($_REQUEST['action']=="trainFileUploaded2" ){
	$quotationId=$_REQUEST['trainFile2'];
	$queryId=$_REQUEST['trainId'];
	
	$datef=time(); 
	if($_FILES['trainFile2']['name']!=''){ 
		$file_name=$_FILES['trainFile2']['name']; 
		$ext=$file_name;
		$file_name=str_replace (" ", "",$datef.$ext);
		copy($_FILES['trainFile2']['tmp_name'],"upload/".$file_name);
		$image2=$file_name;
		$namevalue ='image2="'.$image2.'"';
		updatelisting('finalQuoteTrains',$namevalue,'id="'.$_REQUEST['trainId'].'"');
	}   
	}
if($_REQUEST['action']=="trainFileUploaded3" ){
	$quotationId=$_REQUEST['trainFile3'];
	$queryId=$_REQUEST['trainId'];
	
	$datef=time(); 
	if($_FILES['trainFile3']['name']!=''){ 
		$file_name=$_FILES['trainFile3']['name']; 
		$ext=$file_name;
		$file_name=str_replace (" ", "",$datef.$ext);
		copy($_FILES['trainFile3']['tmp_name'],"upload/".$file_name);
		$image3=$file_name;
		$namevalue ='image3="'.$image3.'"';
		updatelisting('finalQuoteTrains',$namevalue,'id="'.$_REQUEST['trainId'].'"');
	}   
	}
// ended trains files uploaded

// started flight files uploaded
if($_REQUEST['action']=="flightFileUploaded" ){
	$trainId=$_REQUEST['trainId'];
	
	$datef=time(); 
	if($_FILES['flightFile']['name']!=''){ 
		$file_name=$_FILES['flightFile']['name']; 
		$ext=$file_name;
		$file_name=str_replace (" ", "",$datef.$ext);
		copy($_FILES['flightFile']['tmp_name'],"upload/".$file_name);
		$image=$file_name;
		$namevalue ='image="'.$image.'"';
		updatelisting('finalQuoteFlights',$namevalue,'id="'.$_REQUEST['flightId'].'"');
	}   
	}
if($_REQUEST['action']=="flightFileUploaded2" ){
	$trainId=$_REQUEST['trainId'];
	
	$datef=time(); 
	if($_FILES['flightFile2']['name']!=''){ 
		$file_name=$_FILES['flightFile2']['name']; 
		$ext=$file_name;
		$file_name=str_replace (" ", "",$datef.$ext);
		copy($_FILES['flightFile2']['tmp_name'],"upload/".$file_name);
		$image2=$file_name;
		$namevalue ='image2="'.$image2.'"';
		updatelisting('finalQuoteFlights',$namevalue,'id="'.$_REQUEST['flightId'].'"');
	}   
	}
if($_REQUEST['action']=="flightFileUploaded3" ){
	$trainId=$_REQUEST['trainId'];
	
	$datef=time(); 
	if($_FILES['flightFile3']['name']!=''){ 
		$file_name=$_FILES['flightFile3']['name']; 
		$ext=$file_name;
		$file_name=str_replace (" ", "",$datef.$ext);
		copy($_FILES['flightFile3']['tmp_name'],"upload/".$file_name);
		$image3=$file_name;
		$namevalue ='image3="'.$image3.'"';
		updatelisting('finalQuoteFlights',$namevalue,'id="'.$_REQUEST['flightId'].'"');
	}   
	}
// ended flight files uploaded

// started transfer and transport files uploaded
if($_REQUEST['action']=="transferFileUploaded" ){
	
	$transferId=$_REQUEST['transferId'];
	
	$datef=time(); 
	if($_FILES['transferFile']['name']!=''){ 
		$file_name=$_FILES['transferFile']['name']; 
		$ext=$file_name;
		$file_name=str_replace (" ", "",$datef.$ext);
		copy($_FILES['transferFile']['tmp_name'],"upload/".$file_name);
		$image=$file_name;
		$namevalue ='image="'.$image.'"';
		// die("try it");
		updatelisting('finalQuotetransfer',$namevalue,'id="'.$transferId.'"');
	}   
	}
if($_REQUEST['action']=="transferFileUploaded2" ){
	
		$transferId=$_REQUEST['transferId'];
		
		$datef=time(); 
		if($_FILES['transferFile2']['name']!=''){ 
			$file_name2=$_FILES['transferFile2']['name']; 
			$ext=$file_name2;
			$file_name2=str_replace (" ", "",$datef.$ext);
			copy($_FILES['transferFile2']['tmp_name'],"upload/".$file_name2);
			$image2=$file_name2;
			$namevalue ='image2="'.$image2.'"';
			// die("try it");
			updatelisting('finalQuotetransfer',$namevalue,'id="'.$transferId.'"');
	}   
	}
if($_REQUEST['action']=="transferFileUploaded3" ){
	
			$transferId=$_REQUEST['transferId'];
			
			$datef=time(); 
			if($_FILES['transferFile3']['name']!=''){ 
				$file_name3=$_FILES['transferFile3']['name']; 
				$ext=$file_name3;
				$file_name3=str_replace (" ", "",$datef.$ext);
				copy($_FILES['transferFile3']['tmp_name'],"upload/".$file_name3);
				$image3=$file_name3;
				$namevalue ='image3="'.$image3.'"';
				// die("try it");
				updatelisting('finalQuotetransfer',$namevalue,'id="'.$transferId.'"');
	}   
	}


// ended transfer and transport files uploaded

if($_REQUEST['action']=='trainConfirmation' && $_REQUEST['id']>0){

	// trTitle,trfname,trmname,trlname,trgender,trpnrno
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];

	$trTitle= $_REQUEST['trTitle'];
	$trfname= $_REQUEST['trfname'];
	$trmname= $_REQUEST['trmname'];
	$trlname= $_REQUEST['trlname'];
	$trgender= $_REQUEST['trgender'];
	$trpnrno= $_REQUEST['trpnrno'];    
	$loopNo= $_REQUEST['loopNo'];    
	if($loopNo==1){
		$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",trTitle="'.$trTitle.'",trfname="'.$trfname.'",trmname="'.$trmname.'",trlname="'.$trlname.'",trgender="'.$trgender.'",trpnrno="'.$trpnrno.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalQuoteTrains',$namevalue,'id="'.$_REQUEST['id'].'"');
	}
	

	$rs = GetPageRecord('*','trainMultiDetailMaster','quotationId="'.$_REQUEST['quotationId'].'" and parentId="'.$_REQUEST['id'].'" and srn="'.$_REQUEST['loopNo'].'"');
	if(mysqli_num_rows($rs)>0){
		$namevaluemulti='quotationId="'.$_REQUEST['quotationId'].'",confirmationNo="'.$confirmationNo.'",dateAdded="'.$confirmationDate.'",addedBy="'.$confirmedBy.'",srn="'.$_REQUEST['loopNo'].'",title="'.$trTitle.'",firstName="'.$trfname.'",middleName="'.$trmname.'",lastName="'.$trlname.'",gender="'.$trgender.'",pnrNo="'.$trpnrno.'",parentId="'.$_REQUEST['id'].'",status="1"';
			$where ='quotationId="'.$_REQUEST['quotationId'].'" and parentId="'.$_REQUEST['id'].'" and srn="'.$_REQUEST['loopNo'].'"';
		updatelisting('trainMultiDetailMaster',$namevaluemulti,$where);
	}else{
		$namevaluemulti='quotationId="'.$_REQUEST['quotationId'].'",confirmationNo="'.$confirmationNo.'",dateAdded="'.$confirmationDate.'",addedBy="'.$confirmedBy.'",srn="'.$_REQUEST['loopNo'].'",title="'.$trTitle.'",firstName="'.$trfname.'",middleName="'.$trmname.'",lastName="'.$trlname.'",gender="'.$trgender.'",pnrNo="'.$trpnrno.'",parentId="'.$_REQUEST['id'].'",status="1"';

		addlisting('trainMultiDetailMaster',$namevaluemulti);
	}

	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}
}


if($_REQUEST['action']=='mealPlanConfirmation' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];    


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalQuoteMealPlan',$namevalue,'id="'.$_REQUEST['id'].'"');

	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}
}



if($_REQUEST['action']=='additionalConfirmation' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];    


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalQuoteExtra',$namevalue,'id="'.$_REQUEST['id'].'"');

	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}
}



if($_REQUEST['action']=='enrouteConfirmation' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote']; 


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalQuoteEnroute',$namevalue,'id="'.$_REQUEST['id'].'"');

	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}
}

if($_REQUEST['action']=='flightConfirmation' && $_REQUEST['id']>0 ){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];  

	$ftTitle= $_REQUEST['ftTitle'];
	$ftfname= $_REQUEST['ftfname'];
	$ftmname= $_REQUEST['ftmname'];
	$ftlname= $_REQUEST['ftlname'];
	$ftgender= $_REQUEST['ftgender'];
	$ftpnrno= $_REQUEST['ftpnrno'];  
	$loopNo= $_REQUEST['loopNo'];  

	if($loopNo==1){
	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",ftTitle="'.$ftTitle.'",ftfname="'.$ftfname.'",ftmname="'.$ftmname.'",ftlname="'.$ftlname.'",ftgender="'.$ftgender.'",ftpnrno="'.$ftpnrno.'",cutOffDate="'.$cutOffDate.'"';
	
	updatelisting('finalQuoteFlights',$namevalue,'id="'.$_REQUEST['id'].'"');
	}

	$rs = GetPageRecord('*','flightMultiDetailMaster','quotationId="'.$_REQUEST['quotationId'].'" and parentId="'.$_REQUEST['id'].'" and srn="'.$_REQUEST['loopNo'].'"');
	if(mysqli_num_rows($rs)>0){
		$namevaluemulti='quotationId="'.$_REQUEST['quotationId'].'",confirmationNo="'.$confirmationNo.'",dateAdded="'.$confirmationDate.'",addedBy="'.$confirmedBy.'",srn="'.$_REQUEST['loopNo'].'",title="'.$ftTitle.'",firstName="'.$ftfname.'",middleName="'.$ftmname.'",lastName="'.$ftlname.'",gender="'.$ftgender.'",pnrNo="'.$ftpnrno.'",parentId="'.$_REQUEST['id'].'",status="1"';
			$where ='quotationId="'.$_REQUEST['quotationId'].'" and parentId="'.$_REQUEST['id'].'" and srn="'.$_REQUEST['loopNo'].'"';
		updatelisting('flightMultiDetailMaster',$namevaluemulti,$where);
	}else{
		$namevaluemulti='quotationId="'.$_REQUEST['quotationId'].'",confirmationNo="'.$confirmationNo.'",dateAdded="'.$confirmationDate.'",addedBy="'.$confirmedBy.'",srn="'.$_REQUEST['loopNo'].'",title="'.$ftTitle.'",firstName="'.$ftfname.'",middleName="'.$ftmname.'",lastName="'.$ftlname.'",gender="'.$ftgender.'",pnrNo="'.$ftpnrno.'",parentId="'.$_REQUEST['id'].'",status="1"';

		addlisting('flightMultiDetailMaster',$namevaluemulti);
	}
	
	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}
}


if($_REQUEST['action']=='visaConfirmation' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];    


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalQuoteVisa',$namevalue,'id="'.$_REQUEST['id'].'"');

	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}
}



if($_REQUEST['action']=='passportConfirmation' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];    


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalQuotePassport',$namevalue,'id="'.$_REQUEST['id'].'"');

	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}
}

if($_REQUEST['action']=='insuranceConfirmation' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];    


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalQuoteInsurance',$namevalue,'id="'.$_REQUEST['id'].'"');

	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}
}

if($_REQUEST['action']=='completePackageConfirmation' && $_REQUEST['id']>0){
	  
	$spacialReq= $_REQUEST['spacialReq'];    
	$confirmationNo= $_REQUEST['confirmationNo'];    
	$confirmationDate= date('Y-m-d H:i:s', strtotime($_REQUEST['confirmationDate']));    
	$cutOffDate= date('Y-m-d H:i:s', strtotime($_REQUEST['cutOffDate']));    
	$confirmationTime= $_REQUEST['confirmationTime'];    
	$confirmedBy= $_REQUEST['confirmedBy'];    
	$confirmedNote= $_REQUEST['confirmedNote'];    


	$namevalue='specialRequest="'.$spacialReq.'",confirmationNo="'.$confirmationNo.'",confirmationDate="'.$confirmationDate.'",confirmedBy="'.$confirmedBy.'",confirmedNote="'.$confirmedNote.'",cutOffDate="'.$cutOffDate.'"';
	updatelisting('finalPackWiseRateMaster',$namevalue,'id="'.$_REQUEST['id'].'"');

	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}
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
	if($_REQUEST['msgType'] == 0){ 
	?>
	<script>
	parent.alert('Data Saved');
	parent.loadquotationfun(2);
	</script>
	<?php
	}
}


  
if($_REQUEST['action']=='savefinalQuote' ){
	?>
	<script>
	parent.alert('Data Saved Successfully');
	parent.loadquotationfun(2);
	</script>
<?php
}

if($_REQUEST['action']=='saveShowHideCost' && $_REQUEST['supplierStatusId']!='' ){ 
	// update finalQuotSupplierStatus set isCostShow=1 where id=1186;

	$sql_ins='update finalQuotSupplierStatus set isCostShow='.$_REQUEST["isCostShow"].' where id='.$_REQUEST['supplierStatusId'];
	mysqli_query(db(),$sql_ins) or die(mysqli_error(db()));

}


if($_REQUEST['action']=='updateFinalQuote_hotel' && $_REQUEST['hotelfinalId']>0){

	$approvedBy=$_REQUEST['approvedBy'];  
	$approvedDate=$_REQUEST['approvedDate'];  
		  
	$hotelfinalId=$_REQUEST['hotelfinalId']; 
 
	$roomsinglecost=$_REQUEST['roomsinglecost'];
	$roomdoublecost=$_REQUEST['roomdoublecost'];
	$roomtriplecost=$_REQUEST['roomtriplecost']; 
	$roomtwincost=$_REQUEST['roomtwincost']; 

	$roomsingle=$_REQUEST['roomsingle'];
	$roomdouble=$_REQUEST['roomdouble'];
	$roomtriple=$_REQUEST['roomtriple'];  
	$roomtwin=$_REQUEST['roomtwin'];  

	$tenNoofBedRoom=$_REQUEST['tenNoofBedRoom'];  
	$eightNoofBedRoom=$_REQUEST['eightNoofBedRoom'];  
	$sixNoofBedRoom=$_REQUEST['sixNoofBedRoom'];  
	$roomEBedC=$_REQUEST['roomEBedC'];  
	$roomENBedC=$_REQUEST['roomENBedC'];  
	$teenNoofRoom=$_REQUEST['teenNoofRoom'];  
	$quadNoofRoom=$_REQUEST['quadNoofRoom'];  
	$roomEBedA=$_REQUEST['roomEBedA'];  

	$roomEBedACost=$_REQUEST['roomEBedACost'];  
	$quadRoomCost=$_REQUEST['quadRoomCost'];  
	$teenRoomCost=$_REQUEST['teenRoomCost'];  
	$roomEBedCCost=$_REQUEST['roomEBedCCost'];  
	$roomENBedCCost=$_REQUEST['roomENBedCCost'];  
	$sixBedRoomCost=$_REQUEST['sixBedRoomCost'];  
	$eightBedRoomCost=$_REQUEST['eightBedRoomCost'];  
	$tenBedRoomCost=$_REQUEST['tenBedRoomCost'];  
	

	$namevalue ='approvedBy="'.$approvedBy.'",approvedDate="'.$approvedDate.'",roomSingleCost="'.$roomsinglecost.'",roomDoubleCost="'.$roomdoublecost.'",roomTripleCost="'.$roomtriplecost.'",roomTwinCost="'.$roomtwincost.'",roomSingle="'.$roomsingle.'",roomDouble="'.$roomdouble.'",roomTriple="'.$roomtriple.'",roomTwin="'.$roomtwin.'",sixNoofBedRoom="'.$sixNoofBedRoom.'",eightNoofBedRoom="'.$eightNoofBedRoom.'",tenNoofBedRoom="'.$tenNoofBedRoom.'",teenNoofRoom="'.$teenNoofRoom.'",quadNoofRoom="'.$quadNoofRoom.'",roomEBedC="'.$roomEBedC.'",roomENBedC="'.$roomENBedC.'",roomEBedA="'.$roomEBedA.'",roomEBedACost="'.$roomEBedACost.'",quadRoomCost="'.$quadRoomCost.'",teenRoomCost="'.$teenRoomCost.'",roomEBedCCost="'.$roomEBedCCost.'",roomENBedCCost="'.$roomENBedCCost.'",sixBedRoomCost="'.$sixBedRoomCost.'",eightBedRoomCost="'.$eightBedRoomCost.'",tenBedRoomCost="'.$tenBedRoomCost.'"';  

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

	$approvedBy=$_REQUEST['approvedBy'];  
	$approvedDate=$_REQUEST['approvedDate'];  

	$transferfinalId=$_REQUEST['transferfinalId'];
	$adultCost=$_REQUEST['adultCost'];  
	$childCost=$_REQUEST['childCost'];  
	$infantCost=$_REQUEST['infantCost'];  
	$vehicleCost=$_REQUEST['vehicleCost'];   

	$namevalue ='approvedBy="'.$approvedBy.'",approvedDate="'.$approvedDate.'",shareQuoteStatus="'.$manualStatus.'",followupDate="'.date('Y-m-d H:i:s', strtotime($followupDateTime)).'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",vehicleCost="'.$vehicleCost.'",remarks="'.$remarks.'"';  
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

	$approvedBy=$_REQUEST['approvedBy'];  
	$approvedDate=$_REQUEST['approvedDate'];  


	$flightfinalId=$_REQUEST['flightfinalId'];

	$adultCost=$_REQUEST['adultCost']; 
	$childCost=$_REQUEST['childCost']; 
	$infantCost=$_REQUEST['infantCost']; 

	$namevalue ='approvedBy="'.$approvedBy.'",approvedDate="'.$approvedDate.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'"';  
	
	$where='id="'.$flightfinalId.'"';  
	$update = updatelisting('finalQuoteFlights',$namevalue,$where); 

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

if($_REQUEST['action']=='updateFinalQuote_visa' && $_REQUEST['visafinalId']>0){

	$approvedBy=$_REQUEST['approvedBy'];  
	$approvedDate=$_REQUEST['approvedDate'];  


	$visafinalId=$_REQUEST['visafinalId'];

	$adultCost=$_REQUEST['adultCost']; 
	$childCost=$_REQUEST['childCost']; 
	$infantCost=$_REQUEST['infantCost']; 

	$namevalue ='approvedBy="'.$approvedBy.'",approvedDate="'.$approvedDate.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'"';  
	
	$where='id="'.$visafinalId.'"';  
	$update = updatelisting('finalQuoteVisa',$namevalue,$where); 


}

if($_REQUEST['action']=='updateFinalQuote_passport' && $_REQUEST['passportfinalId']>0){

	$approvedBy=$_REQUEST['approvedBy'];  
	$approvedDate=$_REQUEST['approvedDate'];  


	$passportfinalId=$_REQUEST['passportfinalId'];

	$adultCost=$_REQUEST['adultCost']; 
	$childCost=$_REQUEST['childCost']; 
	$infantCost=$_REQUEST['infantCost']; 

	$namevalue ='approvedBy="'.$approvedBy.'",approvedDate="'.$approvedDate.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'"';  
	
	$where='id="'.$passportfinalId.'"';  
	$update = updatelisting('finalQuotePassport',$namevalue,$where); 

}

if($_REQUEST['action']=='updateFinalQuote_insurance' && $_REQUEST['insurancefinalId']>0){

	$approvedBy=$_REQUEST['approvedBy'];  
	$approvedDate=$_REQUEST['approvedDate'];  


	$insurancefinalId=$_REQUEST['insurancefinalId'];

	$adultCost=$_REQUEST['adultCost']; 
	$childCost=$_REQUEST['childCost']; 
	$infantCost=$_REQUEST['infantCost']; 

	$namevalue ='approvedBy="'.$approvedBy.'",approvedDate="'.$approvedDate.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'"';  
	
	$where='id="'.$insurancefinalId.'"';  
	$update = updatelisting('finalQuoteInsurance',$namevalue,$where); 

}

if($_REQUEST['action']=='updateFinalQuote_guide' && $_REQUEST['guidefinalId']>0){

	$approvedBy=$_REQUEST['approvedBy'];  
	$approvedDate=$_REQUEST['approvedDate'];  

	$guidefinalId=$_REQUEST['guidefinalId'];
  	$guideId=$_REQUEST['guideId'];
	$adultCost=$_REQUEST['adultCost']; 
 
	$namevalue ='approvedBy="'.$approvedBy.'",approvedDate="'.$approvedDate.'",adultCost="'.$adultCost.'"';  
	$where='id="'.$guidefinalId.'"';  
	$update = updatelisting('finalQuoteGuides',$namevalue,$where); 
}

if($_REQUEST['action']=='updateFinalQuote_meal' && $_REQUEST['mealfinalId']>0){

	$approvedBy=$_REQUEST['approvedBy'];  
	$approvedDate=$_REQUEST['approvedDate'];  

	$mealfinalId=$_REQUEST['mealfinalId'];
	$adultCost=$_REQUEST['adultCost']; 
	$childCost=$_REQUEST['childCost']; 
	$infantCost=$_REQUEST['infantCost']; 
 
	$namevalue ='approvedBy="'.$approvedBy.'",approvedDate="'.$approvedDate.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'"';  

	$where='id="'.$mealfinalId.'"';  
	$update = updatelisting('finalQuoteMealPlan',$namevalue,$where); 
}


if($_REQUEST['action']=='updateFinalQuote_additional' && $_REQUEST['additionalfinalId']>0){

	$approvedBy=$_REQUEST['approvedBy'];  
	$approvedDate=$_REQUEST['approvedDate'];  

	$additionalfinalId=$_REQUEST['additionalfinalId'];
	$adultCost=$_REQUEST['adultCost']; 
	$childCost=$_REQUEST['childCost']; 
	$infantCost=$_REQUEST['infantCost']; 
 
	$namevalue ='approvedBy="'.$approvedBy.'",approvedDate="'.$approvedDate.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'"';  

	$where='id="'.$additionalfinalId.'"';  
	$update = updatelisting('finalQuoteExtra',$namevalue,$where); 
}


if($_REQUEST['action']=='updateFinalQuote_enroute' && $_REQUEST['enroutefinalId']>0){

	$approvedBy=$_REQUEST['approvedBy'];  
	$approvedDate=$_REQUEST['approvedDate'];  

	$enroutefinalId=$_REQUEST['enroutefinalId'];
	$adultCost=$_REQUEST['adultCost']; 
	$childCost=$_REQUEST['childCost']; 
	$infantCost=$_REQUEST['infantCost']; 
 
	$namevalue ='approvedBy="'.$approvedBy.'",approvedDate="'.$approvedDate.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'"';  

	$where='id="'.$enroutefinalId.'"';  
	$update = updatelisting('finalQuoteEnroute',$namevalue,$where); 
}



if($_REQUEST['action']=='updateFinalQuote_train' && $_REQUEST['trainfinalId']>0){

	$approvedBy=$_REQUEST['approvedBy'];  
	$approvedDate=$_REQUEST['approvedDate'];  

	$trainfinalId=$_REQUEST['trainfinalId']; 
	$adultCost=$_REQUEST['adultCost']; 
	$childCost=$_REQUEST['childCost'];
	$infantCost=$_REQUEST['infantCost'];
 
	$namevalue ='approvedBy="'.$approvedBy.'",approvedDate="'.$approvedDate.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'"';  

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

if($_REQUEST['action']=='updateFinalQuote_entrance' && $_REQUEST['entrancefinalId']>0){

	$approvedBy=$_REQUEST['approvedBy'];  
	$approvedDate=$_REQUEST['approvedDate'];  

	$entrancefinalId=$_REQUEST['entrancefinalId'];
 
	$ticketAdultCost=$_REQUEST['ticketAdultCost']; 
	$ticketchildCost=$_REQUEST['ticketchildCost'];
	$ticketinfantCost=$_REQUEST['ticketinfantCost'];

	$adultCost=$_REQUEST['adultCost']; 
	$childCost=$_REQUEST['childCost'];
	$infantCost=$_REQUEST['infantCost'];

	$vehicleCost=$_REQUEST['vehicleCost']; 
	$repCost=$_REQUEST['repCost'];

	$namevalue ='approvedBy="'.$approvedBy.'",approvedDate="'.$approvedDate.'",ticketAdultCost="'.$ticketAdultCost.'",ticketchildCost="'.$ticketchildCost.'",ticketinfantCost="'.$ticketinfantCost.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",vehicleCost="'.$vehicleCost.'",repCost="'.$repCost.'"';  

	$where='id="'.$entrancefinalId.'"';  
	$update = updatelisting('finalQuoteEntrance',$namevalue,$where);
 

}

if($_REQUEST['action']=='updateFinalQuote_ferry' && $_REQUEST['ferryfinalId']>0){

	$approvedBy=$_REQUEST['approvedBy'];  
	$approvedDate=$_REQUEST['approvedDate'];  
	$ferryfinalId=$_REQUEST['ferryfinalId'];

	$adultCost=$_REQUEST['adultCost']; 
	$childCost=$_REQUEST['childCost']; 
	$infantCost=$_REQUEST['infantCost']; 
	$processingfee=$_REQUEST['processingfee']; 
	$miscCost=$_REQUEST['miscCost']; 
	$namevalue ='approvedBy="'.$approvedBy.'",approvedDate="'.$approvedDate.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",processingfee="'.$processingfee.'",miscCost="'.$miscCost.'"';  
	$where='id="'.$ferryfinalId.'" ';  
	$update = updatelisting('finalQuoteFerry',$namevalue,$where);
 

}

if($_REQUEST['action']=='updateFinalQuote_activity' && $_REQUEST['activityfinalId']>0){

	$approvedBy=$_REQUEST['approvedBy'];  
	$approvedDate=$_REQUEST['approvedDate'];  

	$activityfinalId=$_REQUEST['activityfinalId'];

	$activityCost=$_REQUEST['activityCost']; 
	$maxpax=$_REQUEST['maxpax'];
	$perPaxCost=$_REQUEST['perPaxCost'];


	$namevalue ='approvedBy="'.$approvedBy.'",approvedDate="'.$approvedDate.'",activityCost="'.$activityCost.'",maxpax="'.$maxpax.'",perPaxCost="'.$perPaxCost.'"';  

	$where='id="'.$activityfinalId.'"';  
	$update = updatelisting('finalQuoteActivity',$namevalue,$where); 
 

}
 
if($_REQUEST['action']=='saveVoucherChanges_notInUse' && $_REQUEST['quotationId']>0 && $_REQUEST['id']>0){
	   
	$supplierStatusId = addslashes($_REQUEST['supplierStatusId']);
	$voucherNotes = addslashes($_REQUEST['voucherNotes']);
	$voucherNo = addslashes($_REQUEST['voucherNo']);
	$voucherDate = date('Y-m-d H:i:s', strtotime($_REQUEST['voucherDate']));
	$billingInstructions = addslashes(clean($_REQUEST['billingInstructions']));
 
	//update voucher details
	$namevalue ='voucherNo = "'.$voucherNo.'",voucherDate = "'.$voucherDate.'",voucherNotes = "'.$voucherNotes.'",billingInstructions = "'.$billingInstructions.'"';
	$where='id="'.$_REQUEST['id'].'"';  
	$update = updatelisting('finalQuotSupplierStatus',$namevalue,$where);
 	if($update == 'yes'){
		?>
		<script type="text/javascript" >
			alert('Data Saved');		
		</script>		
		<?php
	}
}
 
if($_REQUEST['action']=='saveVIPVoucher_client' && $_REQUEST['quotationId']>0 && $_REQUEST['voucherDetailId']>0){
	  

	$quotationId = strip($_REQUEST['quotationId']);
	$billInstYes = $_REQUEST['billInstYes'];
	$voucherDetailId = strip($_REQUEST['voucherDetailId']);
	$voucherNotes = addslashes(clean($_REQUEST['voucherNotesvip']));
	$billingInstructions = addslashes(clean($_REQUEST['billingInstructionsvip'])); 
	 
	//voucher details  
	$supplierStatusId = addslashes($_REQUEST['supplierStatusId']);
	$voucherNumbervip = addslashes($_REQUEST['voucherNumbervip']);
	$voucherDate = date('Y-m-d H:i:s', strtotime($_REQUEST['voucherDatevip']));
	$voucherReferanceNumbervip = $_REQUEST['voucherReferanceNumbervip'];
	
	
	$namevalue ='quotationId = "'.$quotationId.'",supplierStatusId = "'.$supplierStatusId.'",voucherNo = "'.$voucherNumbervip.'",voucherDate = "'.$voucherDate.'",cl_ = "'.$voucherNotes.'",billingInstructions = "'.$billingInstructions.'",billInstYes = "'.$billInstYes.'"';
	$where='id="'.$voucherDetailId.'"';  
	$update = updatelisting('voucherDetailsMaster',$namevalue,$where); 
	 
 	if($update == 'yes'){
 		?>
		<script type="text/javascript" >
			alert('Data Saved');
			parent.location.reload();
			parent.$('#pageloading').hide();
			parent.$('#pageloader').hide(); 
		</script>		
		<?php
	}
 
}

// work for both client voucher and supplier voucher
if($_REQUEST['action']=='saveVoucherArrivalDeparture_client' && $_REQUEST['quotationId']>0 && $_REQUEST['id']>0){
	  
	$quotationId = strip($_REQUEST['quotationId']);
	$h_arrival_on = date('Y-m-d H:i:s', strtotime($_REQUEST['h_arrival_on']));
	$h_from = strip($_REQUEST['h_from']);
	$h_by_from = strip($_REQUEST['h_by_from']);
	$h_at_from = date('Y-m-d H:i:s', strtotime($_REQUEST['h_at_from']));
	
	$h_departure_on = date('Y-m-d H:i:s', strtotime($_REQUEST['h_departure_on']));
	$h_to = strip($_REQUEST['h_to']);
	$h_by_to = strip($_REQUEST['h_by_to']); 
	$h_at_to = date('Y-m-d H:i:s', strtotime($_REQUEST['h_at_to']));
	 
	//voucher details  
	$supplierStatusId = addslashes($_REQUEST['supplierStatusId']);
	$voucherNotes = addslashes($_REQUEST['voucherNotes']);
	$voucherNo = addslashes($_REQUEST['voucherNo']);
	$voucherDate = date('Y-m-d H:i:s', strtotime($_REQUEST['voucherDate']));
	$billingInstructions = addslashes(clean($_REQUEST['billingInstructions']));
	$billInstYes = $_REQUEST['billInstYes'];
	
	
	$namevalue ='h_arrival_on = "'.$h_arrival_on.'",h_from = "'.$h_from.'",h_by_from = "'.$h_by_from.'",h_at_from = "'.$h_at_from.'",h_departure_on = "'.$h_departure_on.'",h_to = "'.$h_to.'",h_by_to = "'.$h_by_to.'",h_at_to = "'.$h_at_to.'",quotationId = "'.$quotationId.'",supplierStatusId = "'.$supplierStatusId.'",voucherNo = "'.$voucherNo.'",voucherDate = "'.$voucherDate.'",voucherNotes = "'.$voucherNotes.'",billingInstructions = "'.$billingInstructions.'",billInstYes = "'.$billInstYes.'"';
	$where='id="'.$_REQUEST['id'].'"';  
	$update = updatelisting('voucherDetailsMaster',$namevalue,$where); 
	 
 	if($update == 'yes'){
 		?>
		<script type="text/javascript" >
			alert('Data Saved');
			parent.location.reload();
			parent.$('#pageloading').hide();
			parent.$('#pageloader').hide(); 
		</script>		
		<?php
	}
 
}


if($_REQUEST['action']=='visibleArrivalDepartureTime' && $_REQUEST['voucherId']>0){

	if($_REQUEST['ArrivalDepartureStatus']==1){
		$ArrivalDepartureStatus=0;
	}else{
		$ArrivalDepartureStatus=1;
	}

	$namevalue ='ArrivalDepartureStatus = "'.$ArrivalDepartureStatus.'"';
	$where='id="'.$_REQUEST['voucherId'].'"';  
	$update = updatelisting('voucherDetailsMaster',$namevalue,$where);
 	if($update == 'yes'){
		?>
		<script type="text/javascript" >
			// parent.location.reload();	
		</script>		
		<?php
	}
}

// Over Headings editable part
if($_REQUEST['action']=="updateOverviewTitleText" && $_REQUEST['titleText']!='' && $_REQUEST['param']!=''){
	$param = $_REQUEST['param'];
	$nameValue = 'overviewTitle_'.$param.'="'.$_REQUEST['titleText'].'"';
	$where = 'id="'.$_REQUEST['id'].'"';
	$update = updatelisting(_OVERVIEW_MASTER_,$nameValue,$where);
	if($update=='yes'){
		echo ucwords(clean($_REQUEST['titleText']));
	}

}

// FIT Title update
if($_REQUEST['action']=="updateFITINCTitleText" && $_REQUEST['titleText']!='' && $_REQUEST['param']!=''){
	$param = clean($_REQUEST['param']);
	$nameValue = 'title_'.$param.'="'.$_REQUEST['titleText'].'"';
	$where = 'id="'.$_REQUEST['id'].'"';
	$update = updatelisting('fitIncExcMaster',$nameValue,$where);
	if($update=='yes'){
		echo ucwords(clean($_REQUEST['titleText']));
	}

}

// GIT Title Update
if($_REQUEST['action']=="updateGITINCTitleText" && $_REQUEST['titleText']!='' && $_REQUEST['param']!=''){
	$param = clean($_REQUEST['param']);
	$nameValue = 'title_'.$param.'="'.$_REQUEST['titleText'].'"';
	$where = 'id="'.$_REQUEST['id'].'"';
	$update = updatelisting('gitIncExcMaster',$nameValue,$where);
	if($update=='yes'){
		echo ucwords(clean($_REQUEST['titleText']));
	}

}

//Update Service Wise Markup and GST
if($_REQUEST['action']=='updateSWMGst' and $_REQUEST['serviceType']!='' && $_REQUEST['serviceId']>0 && $_REQUEST['quotationId']>0){

	if($_REQUEST['serviceType']=='hotel'){
		
        $sglMarkup = ($_REQUEST['sglMarkup'] == 'undefined')?0:$_REQUEST['sglMarkup'];
        $dblMarkup = ($_REQUEST['dblMarkup'] == 'undefined')?0:$_REQUEST['dblMarkup'];
        $twinMarkup = ($_REQUEST['twinMarkup'] == 'undefined')?0:$_REQUEST['twinMarkup'];
        $tplMarkup = ($_REQUEST['tplMarkup'] == 'undefined')?0:$_REQUEST['tplMarkup'];
        $quadMarkup = ($_REQUEST['quadMarkup'] == 'undefined')?0:$_REQUEST['quadMarkup'];
        $sixMarkup = ($_REQUEST['sixMarkup'] == 'undefined')?0:$_REQUEST['sixMarkup'];
        $eightMarkup = ($_REQUEST['eightMarkup'] == 'undefined')?0:$_REQUEST['eightMarkup'];
        $tenMarkup = ($_REQUEST['tenMarkup'] == 'undefined')?0:$_REQUEST['tenMarkup'];
        $teenMarkup = ($_REQUEST['teenMarkup'] == 'undefined')?0:$_REQUEST['teenMarkup'];

        $exMarkup = ($_REQUEST['exMarkup'] == 'undefined')?0:$_REQUEST['exMarkup'];
        $cwbMarkup = ($_REQUEST['cwbMarkup'] == 'undefined')?0:$_REQUEST['cwbMarkup'];
        $cnbMarkup = ($_REQUEST['cnbMarkup'] == 'undefined')?0:$_REQUEST['cnbMarkup'];
        $mealMarkup = ($_REQUEST['mealMarkup'] == 'undefined')?0:$_REQUEST['mealMarkup'];
        
        // markupCost="'.trim($_REQUEST['markupCost']).'",
		$namevalue='markupType="'.trim($_REQUEST['markupType']).'",sglMarkup="'.$sglMarkup.'",dblMarkup="'.$dblMarkup.'",twinMarkup="'.$twinMarkup.'",tplMarkup="'.$tplMarkup.'",quadMarkup="'.$quadMarkup.'",sixMarkup="'.$sixMarkup.'",eightMarkup="'.$eightMarkup.'",tenMarkup="'.$tenMarkup.'",teenMarkup="'.$teenMarkup.'",cwbMarkup="'.$cwbMarkup.'",cnbMarkup="'.$cnbMarkup.'",exMarkup="'.$exMarkup.'",mealMarkup="'.$mealMarkup.'",taxType="'.trim($_REQUEST['taxType']).'",roomGST="'.trim($_REQUEST['gstTax']).'"';
		updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'supplierId="'.$_REQUEST['serviceId'].'" and quotationId = "'.$_REQUEST['quotationId'].'" and dayId = "'.$_REQUEST['dayId'].'"');
	}elseif($_REQUEST['serviceType']=='transfer'){
		$namevalue='markupType="'.trim($_REQUEST['markupType']).'",markupCost="'.trim($_REQUEST['markupCost']).'",taxType="'.trim($_REQUEST['taxType']).'",gstTax="'.trim($_REQUEST['gstTax']).'"';
		updatelisting(_QUOTATION_TRANSFER_MASTER_,$namevalue,'id="'.$_REQUEST['serviceId'].'" and quotationId = "'.$_REQUEST['quotationId'].'"');
	}elseif($_REQUEST['serviceType']=='transportation'){
		$namevalue='markupType="'.trim($_REQUEST['markupType']).'",markupCost="'.trim($_REQUEST['markupCost']).'",taxType="'.trim($_REQUEST['taxType']).'",gstTax="'.trim($_REQUEST['gstTax']).'"';
		updatelisting(_QUOTATION_TRANSFER_MASTER_,$namevalue,'id="'.$_REQUEST['serviceId'].'" and quotationId = "'.$_REQUEST['quotationId'].'"');
	}elseif($_REQUEST['serviceType']=='entrance'){
		$namevalue='markupType="'.trim($_REQUEST['markupType']).'",markupCost="'.trim($_REQUEST['markupCost']).'",taxType="'.trim($_REQUEST['taxType']).'",gstTax="'.trim($_REQUEST['gstTax']).'"';
		updatelisting(_QUOTATION_ENTRANCE_MASTER_,$namevalue,'id="'.$_REQUEST['serviceId'].'" and quotationId = "'.$_REQUEST['quotationId'].'"');
	}elseif($_REQUEST['serviceType']=='ferry'){
		$namevalue='markupType="'.trim($_REQUEST['markupType']).'",markupCost="'.trim($_REQUEST['markupCost']).'",taxType="'.trim($_REQUEST['taxType']).'",gstTax="'.trim($_REQUEST['gstTax']).'"';
		updatelisting(_QUOTATION_FERRY_MASTER_,$namevalue,'id="'.$_REQUEST['serviceId'].'" and quotationId = "'.$_REQUEST['quotationId'].'"');
	}elseif($_REQUEST['serviceType']=='activity'){
		$namevalue='markupType="'.trim($_REQUEST['markupType']).'",markupCost="'.trim($_REQUEST['markupCost']).'",taxType="'.trim($_REQUEST['taxType']).'",gstTax="'.trim($_REQUEST['gstTax']).'"';
		updatelisting(_QUOTATION_OTHER_ACTIVITY_MASTER_,$namevalue,'id="'.$_REQUEST['serviceId'].'" and quotationId = "'.$_REQUEST['quotationId'].'"');
	}elseif($_REQUEST['serviceType']=='train'){
		$namevalue='markupType="'.trim($_REQUEST['markupType']).'",markupCost="'.trim($_REQUEST['markupCost']).'",taxType="'.trim($_REQUEST['taxType']).'",gstTax="'.trim($_REQUEST['gstTax']).'"';
		updatelisting(_QUOTATION_TRAINS_MASTER_,$namevalue,'id="'.$_REQUEST['serviceId'].'" and quotationId = "'.$_REQUEST['quotationId'].'"');
	}elseif($_REQUEST['serviceType']=='flight'){
		$namevalue='markupType="'.trim($_REQUEST['markupType']).'",markupCost="'.trim($_REQUEST['markupCost']).'",taxType="'.trim($_REQUEST['taxType']).'",gstTax="'.trim($_REQUEST['gstTax']).'"';
		updatelisting(_QUOTATION_FLIGHT_MASTER_,$namevalue,'id="'.$_REQUEST['serviceId'].'" and quotationId = "'.$_REQUEST['quotationId'].'"');
	}elseif($_REQUEST['serviceType']=='guide'){
		$namevalue='markupType="'.trim($_REQUEST['markupType']).'",markupCost="'.trim($_REQUEST['markupCost']).'",taxType="'.trim($_REQUEST['taxType']).'",gstTax="'.trim($_REQUEST['gstTax']).'"';
		updatelisting(_QUOTATION_GUIDE_MASTER_,$namevalue,'id="'.$_REQUEST['serviceId'].'" and quotationId = "'.$_REQUEST['quotationId'].'"');
	}elseif($_REQUEST['serviceType']=='mealplan'){
		$namevalue='markupType="'.trim($_REQUEST['markupType']).'",markupCost="'.trim($_REQUEST['markupCost']).'",taxType="'.trim($_REQUEST['taxType']).'",gstTax="'.trim($_REQUEST['gstTax']).'"';
		updatelisting(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$namevalue,'id="'.$_REQUEST['serviceId'].'" and quotationId = "'.$_REQUEST['quotationId'].'"');
	}elseif($_REQUEST['serviceType']=='additional'){
		$namevalue='markupType="'.trim($_REQUEST['markupType']).'",markupCost="'.trim($_REQUEST['markupCost']).'",taxType="'.trim($_REQUEST['taxType']).'",gstTax="'.trim($_REQUEST['gstTax']).'"';
		updatelisting(_QUOTATION_EXTRA_MASTER_,$namevalue,'id="'.$_REQUEST['serviceId'].'" and quotationId = "'.$_REQUEST['quotationId'].'"');
	}else{
		echo "Invalid service type";
	}
}


//updated client feedback form
if($_REQUEST['action']=='updateFeedBackRating' && $_REQUEST['serviceType']!='' && $_REQUEST['serviceId']>0){
	
	// echo "islam";
	// exit;
	$feedbackDate = date('Y-m-d');
	$creditNSql="";
	$creditNSql=GetPageRecord('*','onlineFeedbackMaster','serviceType="'.$_REQUEST['serviceType'].'" and serviceId="'.$_REQUEST['serviceId'].'" and quotationId="'.$_REQUEST['quotationId'].'"'); 
	if(mysqli_num_rows($creditNSql)>0){

		$namevalue='serviceType="'.trim($_REQUEST['serviceType']).'",serviceId="'.trim($_REQUEST['serviceId']).'",destinationId="'.trim($_REQUEST['destinationId']).'",rating="'.trim($_REQUEST['ratingId']).'",quotationId="'.trim($_REQUEST['quotationId']).'",queryId="'.trim($_REQUEST['queryId']).'",clientType="'.trim($_REQUEST['clientType']).'",companyId="'.trim($_REQUEST['companyId']).'",serviceTypeId="'.trim($_REQUEST['serviceTypeId']).'",feedbackDate="'.$feedbackDate.'"';
		updatelisting('onlineFeedbackMaster',$namevalue,'serviceType="'.$_REQUEST['serviceType'].'" and serviceId="'.$_REQUEST['serviceId'].'" and quotationId="'.$_REQUEST['quotationId'].'"');
		?>
		<!-- <script type="text/javascript" >
			alert('Thanks you have updated your feedback'); 
		</script>		 -->
		<?php
	}else{

		$dateAdded=time();
		$namevalue='serviceType="'.trim($_REQUEST['serviceType']).'",serviceId="'.trim($_REQUEST['serviceId']).'",destinationId="'.trim($_REQUEST['destinationId']).'",rating="'.trim($_REQUEST['ratingId']).'",quotationId="'.trim($_REQUEST['quotationId']).'",queryId="'.trim($_REQUEST['queryId']).'",clientType="'.trim($_REQUEST['clientType']).'",companyId="'.trim($_REQUEST['companyId']).'",serviceTypeId="'.trim($_REQUEST['serviceTypeId']).'",feedbackDate="'.$feedbackDate.'"';
		$creditNoteId = addlistinggetlastid('onlineFeedbackMaster',$namevalue);
		?>
		<!-- <script type="text/javascript" >
			alert('You have successfully submitted your feeback for <?php echo ucfirst($_REQUEST['serviceType']);?>'); 
		</script>		 -->
		<?php
	}
}

//updated client feedback form
if($_REQUEST['action']=='updateFeedBackAllRating' && $_REQUEST['clientratings']!='' && $_REQUEST['quotationId']!=''){
	
	// echo "islam";
	// exit;
	$feedbackDate = date('Y-m-d');
	$creditNSql="";
	$creditNSql=GetPageRecord('*','onlineFeedbackMaster','serviceType="overall" and quotationId="'.$_REQUEST['quotationId'].'"'); 
	if(mysqli_num_rows($creditNSql)>0){
		$ressult = mysqli_fetch_assoc($creditNSql);
		echo $namevalue='serviceType="overall",serviceId=0,isfuturerecommend="'.trim($_REQUEST['isfuturerecommend']).'",isfamily="'.trim($_REQUEST['isfamily']).'",rating="'.$_REQUEST['clientratings'].'",comment="'.trim($_REQUEST['comment']).'",quotationId="'.trim($_REQUEST['quotationId']).'",queryId="'.trim($_REQUEST['queryId']).'",clientType="'.trim($_REQUEST['clientType']).'",companyId="'.trim($_REQUEST['companyId']).'",feedbackDate="'.$feedbackDate.'",fromDate="'.$_REQUEST['fromDate'].'"';
		$where = 'id="'.$ressult['id'].'" and quotationId="'.$_REQUEST['quotationId'].'"';
		updatelisting('onlineFeedbackMaster',$namevalue,$where);
		?>
		<script type="text/javascript" >
			alert('Thanks you have updated your feedback'); 
		</script>		
		<?php
	}else{
 
		echo $namevalue='serviceType="overall",serviceId=0,isfuturerecommend="'.trim($_REQUEST['isfuturerecommend']).'",isfamily="'.trim($_REQUEST['isfamily']).'",rating="'.$_REQUEST['clientratings'].'",comment="'.trim($_REQUEST['comment']).'",quotationId="'.trim($_REQUEST['quotationId']).'",queryId="'.trim($_REQUEST['queryId']).'",clientType="'.trim($_REQUEST['clientType']).'",companyId="'.trim($_REQUEST['companyId']).'",feedbackDate="'.$feedbackDate.'",fromDate="'.$_REQUEST['fromDate'].'"';
		$creditNoteId = addlistinggetlastid('onlineFeedbackMaster',$namevalue);
		?>
		<script type="text/javascript" >
			alert('You have successfully submitted your feeback');
			 
		</script>		
		<?php
	}
}



// remove entrance resitrictions

	if($_REQUEST['action']=="removeEntranceRestrictions" && $_REQUEST['restrictionId']!='' && $_REQUEST['entranceId']!=''){
	$rowNum = $_REQUEST['rowNum'];
	$entranceId = $_REQUEST['entranceId'];
	$query ="DELETE FROM `hoteloperationRestriction` WHERE id='".$_REQUEST['restrictionId']."' and entranceId='".$entranceId."'";
	$result = mysqli_query(db(),$query);
	if($result==true){
		?>
		<script>
			alert('Restriction Removed');
			$('#entRowNum'+<?php echo $rowNum ;?>).closest('tr').remove();
		</script>
		<?php
		exit();
	}else{
		?>
		<script>
			alert('Something Went Wrong');
		</script>
		<?php
		exit();
	}
	}


	if($_REQUEST['action']=="removeHotelRestrictions" && $_REQUEST['restrictionId']!='' && $_REQUEST['hotelId']!=''){
		$rowNum = $_REQUEST['rowNum'];
		$hotelId = $_REQUEST['hotelId'];
		$query ="DELETE FROM `hoteloperationRestriction` WHERE id='".$_REQUEST['restrictionId']."' and hotelId='".$hotelId."'";
		$result = mysqli_query(db(),$query);
		if($result==true){
			?>
			<script>
				  swal("Success! Your restriction has been deleted!", {
      					icon: "success",
    					});

				$('#hotelRowNum'+<?php echo $rowNum ;?>).closest('tr').remove();
			</script>
			<?php
			exit();
		}else{
			?>
			<script>
				 swal("Error! Something went wrong!", {
      					icon: "error",
    					});
			</script>
			<?php
			exit();
		}
		}

		if($_REQUEST['action']=="removeActivityRestrictions" && $_REQUEST['restrictionId']!='' && $_REQUEST['otheractivityId']!=''){
			$rowNum = $_REQUEST['rowNum'];
			$otheractivityId = $_REQUEST['otheractivityId'];
			$query ="DELETE FROM `hoteloperationRestriction` WHERE id='".$_REQUEST['restrictionId']."' and otheractivityId='".$otheractivityId."'";
			$result = mysqli_query(db(),$query);
			if($result==true){
				?>
				<script>
					alert('Restriction Removed');
					$('#activityRowNum'+<?php echo $rowNum ;?>).closest('tr').remove();
				</script>
				<?php
				exit();
			}else{
				?>
				<script>
					alert('Something Went Wrong');
				</script>
				<?php
				exit();
			}
			}

			if($_REQUEST['action']=="updateProposalTotalCost" && $_REQUEST['checkValue']!=''){

				updatelisting('proposalSettingMaster','isProposalCost="'.$_REQUEST['checkValue'].'"','proposalName!=""');
			}

			if($_REQUEST['action']=="updateProposalTotalCostPP" && $_REQUEST['checkValue']!=''){

				updatelisting('proposalSettingMaster','isProposalCostPP="'.$_REQUEST['checkValue'].'"','proposalName!=""');
			}


			
		if($_REQUEST['action']=='selectVoucherTemplates' && $_REQUEST['templateNo']!=''){

			$templateNo = $_REQUEST['templateNo'];
			
			$updateTemp = updatelisting('voucherSettingMaster','setDefaultTemplate="'.$templateNo.'"','id=1');
			
			if($updateTemp == 'yes'){
				?>
			<script type="text/javascript" >
					
					swal("Done! New Template applied to all vouchers!",{
						icon: "success",
						
						}).then((selected) => {
							parent.location.reload();
						});

						
			</script>		
			<?php
			}
			
			}


	// started invoice template update code
	if($_REQUEST['action']=='selectInvoiceTemplates' && $_REQUEST['templateNo']!=''){

		$templateNo = $_REQUEST['templateNo'];
		
		$updateTemp = updatelisting('invoiceSettingMaster','setDefaultTemplate="'.$templateNo.'"','id=1');
		
		if($updateTemp == 'yes'){
			?>
		<script type="text/javascript" >
				
				swal("Done! New Template applied to all invoices!",{
					icon: "success",
					
					}).then((selected) => {
						parent.location.reload();
					});

					
		</script>		
		<?php
		}
		
		}
	//ended invoice template update code

	// DMC Voucher block 
	if($_REQUEST['action']=='saveDMCVoucherChanges' && $_REQUEST['quotationId']!=''){

		if($_REQUEST['dmcNotes']!='' || $_REQUEST['dmcRemarks']!=''){

			$where = 'id="'.$_REQUEST['voucherId'].'" and quotationId="'.$_REQUEST['quotationId'].'" and serviceType="dmcvoucher"';
			$nameValue = 'cli_voucherNotes="'.$_REQUEST['dmcNotes'].'",voucherNotes="'.$_REQUEST['dmcRemarks'].'"';

			$update = updatelisting('voucherDetailsMaster',$nameValue,$where);

		}


		// Started add mode detail sec dmc voucher
		if(($_REQUEST['selectboxmodebox']=="flight" || $_REQUEST['selectboxmodebox']=="train" || $_REQUEST['selectboxmodebox']=="surface") && ($_REQUEST['EditselModeId']=="")){

			$quotationId= $_REQUEST['quotationId'];
			// echo $modeType= $_REQUEST['mafts_type_dmc'];
			echo $modeType= $_REQUEST['selectboxmodebox'];
			// die("tttsss");
			

		// Flight get data	
		if($modeType=="flight" ){
				$Aname= $_REQUEST['maf_name_dmc'];
				$Anumber= $_REQUEST['maf_number_dmc'];
				$Afrom= $_REQUEST['maf_from_dmc'];

				$ApicAdd= $_REQUEST['maf_picadd_dmc'];
				$AdropAdd= $_REQUEST['maf_dropadd_dmc'];
				$Atype= $_REQUEST['maf_type_dmc'];

				$Dtype= $_REQUEST['mdf_type_dmc'];
				$Dname= $_REQUEST['mdf_name_dmc'];
				$Dnumber= $_REQUEST['mdf_number_dmc'];
				$Dfrom= $_REQUEST['mdf_to_dmc'];
				$DpicAdd= $_REQUEST['mdf_picadd_dmc'];
				$DdropAdd= $_REQUEST['mdf_dropadd_dmc'];

				if($_REQUEST['maf_arrtime_dmc']!=''){
					$ArrTime = date('H:i:s',strtotime($_REQUEST['maf_arrtime_dmc']));
				}else{
					$ArrTime = '';
				}
			
				if($_REQUEST['mdf_dpttime_dmc']!=''){
					$DptTime = date('H:i:s',strtotime($_REQUEST['mdf_dpttime_dmc']));
				}else{
					$DptTime = '';
				}
				if($_REQUEST['maf_arrdate_dmc']!=''){
					$arrDate = date('Y-m-d',strtotime($_REQUEST['maf_arrdate_dmc']));
				}else{
					$arrDate = '';
				}
				if($_REQUEST['mdf_dptdate_dmc']!=''){
					$dropDate = date('Y-m-d',strtotime($_REQUEST['mdf_dptdate_dmc']));
				}else{
					$dropDate = '';
				}
		}

		// train get data

		if($modeType=="train" ){
			$TrainAtype= $_REQUEST['mat_type_dmc'];
			$TrainAname= $_REQUEST['mat_name_dmc'];
			$TrainAnumber= $_REQUEST['mat_number_dmc'];
			$TrainAfrom= $_REQUEST['mat_from_dmc'];

			$TrainApicAdd= $_REQUEST['mat_picadd_dmc'];
			$TrainAdropAdd= $_REQUEST['mat_dropadd_dmc'];

			$TrainDtype= $_REQUEST['mdt_type_dmc'];
			$TrainDname= $_REQUEST['mdt_name_dmc'];
			$TrainDnumber= $_REQUEST['mdt_number_dmc'];
			$TrainDfrom= $_REQUEST['mdt_to_dmc'];
			$TrainDpicAdd= $_REQUEST['mdt_picadd_dmc'];
			$TrainDdropAdd= $_REQUEST['mdt_dropadd_dmc'];

			if($_REQUEST['mat_arrtime_dmc']!=''){
				$TrainArrTime = date('H:i:s',strtotime($_REQUEST['mat_arrtime_dmc']));
			}else{
				$TrainArrTime = '';
			}
		
			if($_REQUEST['mdt_dpttime_dmc']!=''){
				$TrainDptTime = date('H:i:s',strtotime($_REQUEST['mdt_dpttime_dmc']));
			}else{
				$TrainDptTime = '';
			}
			if($_REQUEST['mat_arrdate_dmc']!=''){
				$TrainarrDate = date('Y-m-d',strtotime($_REQUEST['mat_arrdate_dmc']));
			}else{
				$TrainarrDate = '';
			}
			if($_REQUEST['mdt_dptdate_dmc']!=''){
				$TraindropDate = date('Y-m-d',strtotime($_REQUEST['mdt_dptdate_dmc']));
			}else{
				$TraindropDate = '';
			}

		}
		// surface get data
		if($modeType=="surface" ){

			$SurfaceAtype= $_REQUEST['mas_type_dmc'];
			$SurfaceAname= $_REQUEST['mas_vehiletype_dmc'];
			$SurfaceAnumber= $_REQUEST['mas_number_dmc'];
			$SurfaceAfrom= $_REQUEST['mas_from_dmc'];

			$SurfaceApicAdd= $_REQUEST['mas_picadd_dmc'];
			$SurfaceAdropAdd= $_REQUEST['mas_dropadd_dmc'];

			$SurfaceDtype= $_REQUEST['mds_type_dmc'];
			$SurfaceDname= $_REQUEST['mds_vehiletype_dmc'];
			$SurfaceDnumber= $_REQUEST['mds_number_dmc'];
			$SurfaceDfrom= $_REQUEST['mds_to_dmc'];
			$SurfaceDpicAdd= $_REQUEST['mds_picadd_dmc'];
			$SurfaceDdropAdd= $_REQUEST['mds_dropadd_dmc'];

			if($_REQUEST['mas_arrtime_dmc']!=''){
				$SurfaceArrTime = date('H:i:s',strtotime($_REQUEST['mas_arrtime_dmc']));
			}else{
				$SurfaceArrTime = '';
			}
		
			if($_REQUEST['mds_dpttime_dmc']!=''){
				$SurfaceDptTime = date('H:i:s',strtotime($_REQUEST['mds_dpttime_dmc']));
			}else{
				$SurfaceDptTime = '';
			}
			if($_REQUEST['mas_arrdate_dmc']!=''){
				$SurfacearrDate = date('Y-m-d',strtotime($_REQUEST['mas_arrdate_dmc']));
			}else{
				$SurfacearrDate = '';
			}
			if($_REQUEST['mds_dptdate_dmc']!=''){
				$SurfacedropDate = date('Y-m-d',strtotime($_REQUEST['mds_dptdate_dmc']));
			}else{
				$SurfacedropDate = '';
			}
		}


		// if($id>0){
			// $namevalue = 'pickupTime="'.$pickupTime.'",dropTime="'.$dropTime.'",pickupAddress="'.$pickupAddress.'",dropAddress="'.$dropAddress.'"';
			// $where = 'id="'.$id.'"';
			// $update = updatelisting('quotationTransferTimelineDetails',$namevalue,$where);
			// }else{
	
			// $a = GetPageRecord('*','quotationTransferMaster','id="'.$tptquoteId.'"');
			// $tranferData = mysqli_fetch_assoc($a);


			// TrainAtype,TrainAname,TrainAnumber,TrainAfrom,TrainApicAdd,TrainAdropAdd
			// TrainDtype,TrainDname,TrainDnumber,TrainDfrom,TrainDpicAdd
			// TrainDdropAdd,TrainArrTime,TrainDptTime,TrainarrDate,TraindropDate
	
			echo $namevalue = 'quotationId="'.$quotationId.'",type="'.$Atype.'",name="'.$Aname.'",number="'.$Anumber.'",Afrom="'.$Afrom.'",picAdd="'.$ApicAdd.'",dropAdd="'.$AdropAdd.'",modeType="'.$modeType.'",ArrTime="'.$ArrTime.'",arrDate="'.$arrDate.'",DptTime="'.$DptTime.'",dropDate="'.$dropDate.'",Dtype="'.$Dtype.'",Dname="'.$Dname.'",Dnumber="'.$Dnumber.'",Dfrom="'.$Dfrom.'",DpicAdd="'.$DpicAdd.'",DdropAdd="'.$DdropAdd.'",TrainAtype="'.$TrainAtype.'",TrainAname="'.$TrainAname.'",TrainAnumber="'.$TrainAnumber.'",TrainAfrom="'.$TrainAfrom.'",TrainApicAdd="'.$TrainApicAdd.'",TrainAdropAdd="'.$TrainAdropAdd.'",TrainDtype="'.$TrainDtype.'",TrainDname="'.$TrainDname.'",TrainDnumber="'.$TrainDnumber.'",TrainDfrom="'.$TrainDfrom.'",TrainDpicAdd="'.$TrainDpicAdd.'",TrainDdropAdd="'.$TrainDdropAdd.'",TrainArrTime="'.$TrainArrTime.'",TrainDptTime="'.$TrainDptTime.'",TrainarrDate="'.$TrainarrDate.'",TraindropDate="'.$TraindropDate.'",SurfaceAtype="'.$SurfaceAtype.'",SurfaceAname="'.$SurfaceAname.'",SurfaceAnumber="'.$SurfaceAnumber.'",SurfaceAfrom="'.$SurfaceAfrom.'",SurfaceApicAdd="'.$SurfaceApicAdd.'",SurfaceAdropAdd="'.$SurfaceAdropAdd.'",SurfaceDtype="'.$SurfaceDtype.'",SurfaceDname="'.$SurfaceDname.'",SurfaceDnumber="'.$SurfaceDnumber.'",SurfaceDfrom="'.$SurfaceDfrom.'",SurfaceDpicAdd="'.$SurfaceDpicAdd.'",SurfaceDdropAdd="'.$SurfaceDdropAdd.'",SurfaceArrTime="'.$SurfaceArrTime.'",SurfaceDptTime="'.$SurfaceDptTime.'",SurfacearrDate="'.$SurfacearrDate.'",SurfacedropDate="'.$SurfacedropDate.'"';
			// die("test");
	
			addlisting('dmcFlightTrainSurfaceDetails',$namevalue);
			// }
		}
		// Ended add mode detail sec dmc voucher




				//Started  update seletc dmc voucher details sec
				if(($_REQUEST['selectboxmodebox']=="flight" || $_REQUEST['selectboxmodebox']=="train" || $_REQUEST['selectboxmodebox']=="surface") && ($_REQUEST['EditselModeId']!="")){

					$quotationId= $_REQUEST['quotationId'];
					// echo $modeType= $_REQUEST['mafts_type_dmc'];
					echo $modeType= $_REQUEST['selectboxmodebox'];
					// die("tttsss123");
					$EditselModeId = $_REQUEST['EditselModeId'];
					
		
				// Flight get data	
				if($modeType=="flight" ){
						$Aname= $_REQUEST['maf_name_dmc'];
						$Anumber= $_REQUEST['maf_number_dmc'];
						$Afrom= $_REQUEST['maf_from_dmc'];
		
						$ApicAdd= $_REQUEST['maf_picadd_dmc'];
						$AdropAdd= $_REQUEST['maf_dropadd_dmc'];
						$Atype= $_REQUEST['maf_type_dmc'];
		
						$Dtype= $_REQUEST['mdf_type_dmc'];
						$Dname= $_REQUEST['mdf_name_dmc'];
						$Dnumber= $_REQUEST['mdf_number_dmc'];
						$Dfrom= $_REQUEST['mdf_to_dmc'];
						$DpicAdd= $_REQUEST['mdf_picadd_dmc'];
						$DdropAdd= $_REQUEST['mdf_dropadd_dmc'];
		
						if($_REQUEST['maf_arrtime_dmc']!=''){
							$ArrTime = date('H:i:s',strtotime($_REQUEST['maf_arrtime_dmc']));
						}else{
							$ArrTime = '';
						}
					
						if($_REQUEST['mdf_dpttime_dmc']!=''){
							$DptTime = date('H:i:s',strtotime($_REQUEST['mdf_dpttime_dmc']));
						}else{
							$DptTime = '';
						}
						if($_REQUEST['maf_arrdate_dmc']!=''){
							$arrDate = date('Y-m-d',strtotime($_REQUEST['maf_arrdate_dmc']));
						}else{
							$arrDate = '';
						}
						if($_REQUEST['mdf_dptdate_dmc']!=''){
							$dropDate = date('Y-m-d',strtotime($_REQUEST['mdf_dptdate_dmc']));
						}else{
							$dropDate = '';
						}
				}
		
				// train get data
		
				if($modeType=="train" ){
					$TrainAtype= $_REQUEST['mat_type_dmc'];
					$TrainAname= $_REQUEST['mat_name_dmc'];
					$TrainAnumber= $_REQUEST['mat_number_dmc'];
					$TrainAfrom= $_REQUEST['mat_from_dmc'];
		
					$TrainApicAdd= $_REQUEST['mat_picadd_dmc'];
					$TrainAdropAdd= $_REQUEST['mat_dropadd_dmc'];
		
					$TrainDtype= $_REQUEST['mdt_type_dmc'];
					$TrainDname= $_REQUEST['mdt_name_dmc'];
					$TrainDnumber= $_REQUEST['mdt_number_dmc'];
					$TrainDfrom= $_REQUEST['mdt_to_dmc'];
					$TrainDpicAdd= $_REQUEST['mdt_picadd_dmc'];
					$TrainDdropAdd= $_REQUEST['mdt_dropadd_dmc'];
		
					if($_REQUEST['mat_arrtime_dmc']!=''){
						$TrainArrTime = date('H:i:s',strtotime($_REQUEST['mat_arrtime_dmc']));
					}else{
						$TrainArrTime = '';
					}
				
					if($_REQUEST['mdt_dpttime_dmc']!=''){
						$TrainDptTime = date('H:i:s',strtotime($_REQUEST['mdt_dpttime_dmc']));
					}else{
						$TrainDptTime = '';
					}
					if($_REQUEST['mat_arrdate_dmc']!=''){
						$TrainarrDate = date('Y-m-d',strtotime($_REQUEST['mat_arrdate_dmc']));
					}else{
						$TrainarrDate = '';
					}
					if($_REQUEST['mdt_dptdate_dmc']!=''){
						$TraindropDate = date('Y-m-d',strtotime($_REQUEST['mdt_dptdate_dmc']));
					}else{
						$TraindropDate = '';
					}
		
				}
				// surface get data
				if($modeType=="surface" ){
		
					$SurfaceAtype= $_REQUEST['mas_type_dmc'];
					$SurfaceAname= $_REQUEST['mas_vehiletype_dmc'];
					$SurfaceAnumber= $_REQUEST['mas_number_dmc'];
					$SurfaceAfrom= $_REQUEST['mas_from_dmc'];
		
					$SurfaceApicAdd= $_REQUEST['mas_picadd_dmc'];
					$SurfaceAdropAdd= $_REQUEST['mas_dropadd_dmc'];
		
					$SurfaceDtype= $_REQUEST['mds_type_dmc'];
					$SurfaceDname= $_REQUEST['mds_vehiletype_dmc'];
					$SurfaceDnumber= $_REQUEST['mds_number_dmc'];
					$SurfaceDfrom= $_REQUEST['mds_to_dmc'];
					$SurfaceDpicAdd= $_REQUEST['mds_picadd_dmc'];
					$SurfaceDdropAdd= $_REQUEST['mds_dropadd_dmc'];
		
					if($_REQUEST['mas_arrtime_dmc']!=''){
						$SurfaceArrTime = date('H:i:s',strtotime($_REQUEST['mas_arrtime_dmc']));
					}else{
						$SurfaceArrTime = '';
					}
				
					if($_REQUEST['mds_dpttime_dmc']!=''){
						$SurfaceDptTime = date('H:i:s',strtotime($_REQUEST['mds_dpttime_dmc']));
					}else{
						$SurfaceDptTime = '';
					}
					if($_REQUEST['mas_arrdate_dmc']!=''){
						$SurfacearrDate = date('Y-m-d',strtotime($_REQUEST['mas_arrdate_dmc']));
					}else{
						$SurfacearrDate = '';
					}
					if($_REQUEST['mds_dptdate_dmc']!=''){
						$SurfacedropDate = date('Y-m-d',strtotime($_REQUEST['mds_dptdate_dmc']));
					}else{
						$SurfacedropDate = '';
					}
				}
			
					echo $namevalue = 'quotationId="'.$quotationId.'",type="'.$Atype.'",name="'.$Aname.'",number="'.$Anumber.'",Afrom="'.$Afrom.'",picAdd="'.$ApicAdd.'",dropAdd="'.$AdropAdd.'",modeType="'.$modeType.'",ArrTime="'.$ArrTime.'",arrDate="'.$arrDate.'",DptTime="'.$DptTime.'",dropDate="'.$dropDate.'",Dtype="'.$Dtype.'",Dname="'.$Dname.'",Dnumber="'.$Dnumber.'",Dfrom="'.$Dfrom.'",DpicAdd="'.$DpicAdd.'",DdropAdd="'.$DdropAdd.'",TrainAtype="'.$TrainAtype.'",TrainAname="'.$TrainAname.'",TrainAnumber="'.$TrainAnumber.'",TrainAfrom="'.$TrainAfrom.'",TrainApicAdd="'.$TrainApicAdd.'",TrainAdropAdd="'.$TrainAdropAdd.'",TrainDtype="'.$TrainDtype.'",TrainDname="'.$TrainDname.'",TrainDnumber="'.$TrainDnumber.'",TrainDfrom="'.$TrainDfrom.'",TrainDpicAdd="'.$TrainDpicAdd.'",TrainDdropAdd="'.$TrainDdropAdd.'",TrainArrTime="'.$TrainArrTime.'",TrainDptTime="'.$TrainDptTime.'",TrainarrDate="'.$TrainarrDate.'",TraindropDate="'.$TraindropDate.'",SurfaceAtype="'.$SurfaceAtype.'",SurfaceAname="'.$SurfaceAname.'",SurfaceAnumber="'.$SurfaceAnumber.'",SurfaceAfrom="'.$SurfaceAfrom.'",SurfaceApicAdd="'.$SurfaceApicAdd.'",SurfaceAdropAdd="'.$SurfaceAdropAdd.'",SurfaceDtype="'.$SurfaceDtype.'",SurfaceDname="'.$SurfaceDname.'",SurfaceDnumber="'.$SurfaceDnumber.'",SurfaceDfrom="'.$SurfaceDfrom.'",SurfaceDpicAdd="'.$SurfaceDpicAdd.'",SurfaceDdropAdd="'.$SurfaceDdropAdd.'",SurfaceArrTime="'.$SurfaceArrTime.'",SurfaceDptTime="'.$SurfaceDptTime.'",SurfacearrDate="'.$SurfacearrDate.'",SurfacedropDate="'.$SurfacedropDate.'"';
					// die("test");
					$where='id="'.$_REQUEST['EditselModeId'].'"';
					$update = updatelisting('dmcFlightTrainSurfaceDetails',$namevalue,$where);
					// addlisting('dmcFlightTrainSurfaceDetails',$namevalue);
					// }
				}
				
		// Ended update seclect dmc voucher details sec







		

		if($_POST['tptAction']=="transferServices" && $_POST['tptNum']>0){
			$tptNum = $_POST['tptNum'];
			for($i=1; $i<$tptNum; $i++){

				$id = $_REQUEST['tpttimeId'.$i];

		$pickupAddress = $_REQUEST['pickupAddress'.$i];
		$dropAddress = $_REQUEST['dropAddress'.$i];
		if($_REQUEST['pickupTime'.$i]!=''){
			$pickupTime = date('H:i:s',strtotime($_REQUEST['pickupTime'.$i]));
		}else{
			$pickupTime = '';
		}
	
		if($_REQUEST['dropTime'.$i]!=''){
			$dropTime = date('H:i:s',strtotime($_REQUEST['dropTime'.$i]));
		}else{
			$dropTime = '';
		}

		$tptquoteId = $_REQUEST['tptquoteId'.$i];

		if($id>0){
			$namevalue = 'pickupTime="'.$pickupTime.'",dropTime="'.$dropTime.'",pickupAddress="'.$pickupAddress.'",dropAddress="'.$dropAddress.'"';
			$where = 'id="'.$id.'"';
			$update = updatelisting('quotationTransferTimelineDetails',$namevalue,$where);
			}else{
	
				$a = GetPageRecord('*','quotationTransferMaster','id="'.$tptquoteId.'"');
				$tranferData = mysqli_fetch_assoc($a);
	
				$namevalue = 'pickupTime="'.$pickupTime.'",dropTime="'.$dropTime.'",pickupAddress="'.$pickupAddress.'",dropAddress="'.$dropAddress.'",quotationId="'.$tranferData['quotationId'].'",dayId="'.$tranferData['dayId'].'",transferQuoteId="'.$tptquoteId.'",supplierId="'.$tranferData['supplierId'].'"';
	
				addlisting('quotationTransferTimelineDetails',$namevalue);
			}

			}
		}


		if($_POST['entAction']=="entranceServices" && $_POST['entNum']>0){
			$entNum = $_POST['entNum'];

			for($i=1; $i<$entNum; $i++){

			$id = $_REQUEST['entranceTimeId'.$i];

			
			if($_REQUEST['entStartTime'.$i]!=''){
				$entStartTime = $_REQUEST['entStartTime'.$i];
			}else{
				$entStartTime = '';
			}

			if($_REQUEST['entEndTime'.$i]!=''){
				$entEndTime = $_REQUEST['entEndTime'.$i];
			}else{
				$entEndTime = '';
			}
			

			if($_REQUEST['entraPickupTime'.$i]!=''){
				$entPickupTime = $_REQUEST['entraPickupTime'.$i];
			}else{
				$entPickupTime = '';
			}

			if($_REQUEST['entraDropTime'.$i]!=''){
				$entDropTime = $_REQUEST['entraDropTime'.$i];
			}else{
				$entDropTime = '';
			}

			$pickupAddress = $_POST['entpickupAddress'.$i];
			$dropAddress = $_POST['entdropAddress'.$i];

			$entranceQuoteId = $_REQUEST['entranceQuoteId'.$i];
		if($id>0){
		$namevalue = 'startTime="'.$entStartTime.'",endTime="'.$entEndTime.'",pickupTime="'.$entPickupTime.'",dropTime="'.$entDropTime.'",pickupAddress="'.$pickupAddress.'",dropAddress="'.$dropAddress.'"';
		$where = 'id="'.$id.'"';
		$update = updatelisting('quotationEntranceTimelineDetails',$namevalue,$where);
		}else{

			$a = GetPageRecord('*','quotationEntranceMaster','id="'.$entranceQuoteId.'"');
			$entData = mysqli_fetch_assoc($a);

			$namevalue = 'startTime="'.$entStartTime.'",endTime="'.$entEndTime.'",hotelQuoteId="'.$entranceQuoteId.'",supplierId="'.$entData['supplierId'].'",quotationId="'.$entData['quotationId'].'",dayId="'.$entData['dayId'].'",pickupTime="'.$entPickupTime.'",dropTime="'.$entDropTime.'",pickupAddress="'.$pickupAddress.'",dropAddress="'.$dropAddress.'"';

			addlisting('quotationEntranceTimelineDetails',$namevalue);
		}
			}

		}

		if($_POST['actAction']=="activityServices" && $_POST['actNum']>0){
			$actNum = $_POST['actNum'];

			for($i=1; $i<$actNum; $i++){

				$id = $_REQUEST['activityTimeId'.$i];

				if($_REQUEST['actStartTime'.$i]!=''){
					$actStartTime = $_REQUEST['actStartTime'.$i];
				}else{
					$actStartTime = '';
				}

				if($_REQUEST['actStartTime'.$i]!=''){
					$actEndTime = $_REQUEST['actEndTime'.$i];
				}else{
					$actEndTime = '';
				}
				

				
				$activityQuoteId = $_REQUEST['activityQuoteId'.$i];

				if($id>0){
				$namevalue = 'startTime="'.$actStartTime.'",endTime="'.$actEndTime.'"';
				$where = 'id="'.$id.'"';
				$update = updatelisting('quotationActivityTimelineDetails',$namevalue,$where);
				}else{

					$a = GetPageRecord('*','quotationOtherActivitymaster','id="'.$activityQuoteId.'"');
					$actData = mysqli_fetch_assoc($a);

					$namevalue = 'startTime="'.$actStartTime.'",endTime="'.$actEndTime.'",hotelQuoteId="'.$activityQuoteId.'",supplierId="'.$actData['supplierId'].'",quotationId="'.$actData['quotationId'].'",dayId="'.$actData['dayId'].'"';

					addlisting('quotationActivityTimelineDetails',$namevalue);
				}

			}
			



			if($_POST['flightAction']=="flightServices" && $_POST['flightNum']>0){

				$flightNum = $_POST['flightNum'];

				for($i=1; $i<$flightNum; $i++){

					$id = $_REQUEST['flightTimeId'.$i];
					if($_REQUEST['flightDptDate'.$i]!=''){
						$flightDptDate = date('Y-m-d',strtotime($_REQUEST['flightDptDate'.$i]));
					}else{
						$flightDptDate = '';
					}
					if($_REQUEST['flightDptTime'.$i]!=''){
						$flightDptTime = date('H:i:s',strtotime($_REQUEST['flightDptTime'.$i]));
					}else{
						$flightDptTime = '';
					}
					if($_REQUEST['flightarrDate'.$i]!=''){
						$flightarrDate = date('Y-m-d',strtotime($_REQUEST['flightarrDate'.$i]));
					}else{
						$flightarrDate = '';
					}
					if($_REQUEST['flightarrTime'.$i]!=''){
						$flightarrTime = date('H:i:s',strtotime($_REQUEST['flightarrTime'.$i]));
					}else{
						$flightarrTime = '';
					}

					$flightQuoteId = $_REQUEST['flightQuoteId'.$i];
					$serviceType = $_REQUEST['serviceType'.$i];

					if($id>0){
					if($serviceType=="flight"){
					$namevalue = 'departureDate="'.$flightDptDate.'",departureTime="'.$flightDptTime.'",arrivalDate="'.$flightarrDate.'",arrivalTime="'.$flightarrTime.'",serviceType="flight"';
					$where = 'id="'.$id.'"';
					$update = updatelisting('flightTimeLineMaster',$namevalue,$where);
					}
					}else{

						if($serviceType=="flight"){

						
						$a = GetPageRecord('*','quotationFlightMaster','id="'.$flightQuoteId.'"');
						$flightData = mysqli_fetch_assoc($a);

						$namevalue = 'departureDate="'.$flightDptDate.'",departureTime="'.$flightDptTime.'",arrivalDate="'.$flightarrDate.'",arrivalTime="'.$flightarrTime.'",flightQuoteId="'.$flightQuoteId.'",quotationId="'.$flightData['quotationId'].'",queryId="'.$flightData['queryId'].'",flightId="'.$flightData['flightId'].'",dayId="'.$flightData['dayId'].'",serviceType="flight"';

						addlisting('flightTimeLineMaster',$namevalue);
					}
					}

				}
			}



		}

		?>
		<script>
			alert("All changes Saved.");
			parent.$('#pageloader').hide();
			parent.$('#pageloading').hide();

			// mode detail reloade 
			parent.setupbox('showpage.crm?module=ClientVoucher&qid=<?php echo encode($_REQUEST['quotationId']); ?>&voucherType=client&alt=2');


        	// window.location.reload();
		</script>
		<?php

	}


	// update Emergency Heading Name

if($_REQUEST['action']=="emergencyHeadingDetail" && $_REQUEST['headingName']!=''){
	$headingName = $_REQUEST['headingName'];
	$nameValue = 'emergencyHeading="'.$headingName.'"';
	$where = 'id!=" " ';
	$update = updatelisting(_PACKAGE_TERMS_CONDITIONS_MASTER,$nameValue,$where);
	if($update == 'yes'){
		$rs1=GetPageRecord('emergencyHeading',_PACKAGE_TERMS_CONDITIONS_MASTER,'emergencyHeading!=" " order by id desc');
		$emdata=mysqli_fetch_array($rs1);
		echo stripslashes($emdata['emergencyHeading']);
	}
}

if($_REQUEST['action']=="saveBankMasterTitle" && $_REQUEST['id']!='' && $_REQUEST['title']!=''){

	$update = updatelisting('bankMaster','title="'.$_REQUEST['title'].'"','id="'.$_REQUEST['id'].'"');

	if($update=='yes'){
		echo $_REQUEST['title'];
	}
}

if($_REQUEST['action']=="deleteCompletePackageCost" && $_REQUEST['id']>0){
	$query = 'DELETE FROM packageWiseRateMaster WHERE id="'.$_REQUEST['id'].'"';
		mysqli_query(db(),$query);
	?>
	<script>
		location.reload();
		warningalert('Package Rate Deleted');
	</script>
	<?php
}

if($_REQUEST['action']=="deleteQueryMultipleservices" && $_REQUEST['id']!=''){
	$countNum = $_REQUEST['countNum'];

	if($_REQUEST['serviceType']=='Flight'){
		$query = 'DELETE FROM flightQueryMaster WHERE id="'.$_REQUEST['id'].'"';
		mysqli_query(db(),$query);
	}

	if($_REQUEST['serviceType']=='Visa'){
		$query = 'DELETE FROM visaQueryMaster WHERE id="'.$_REQUEST['id'].'"';
		mysqli_query(db(),$query);
	}

	if($_REQUEST['serviceType']=='Insurance'){
		$query = 'DELETE FROM insuranceQueryMaster WHERE id="'.$_REQUEST['id'].'"';
		mysqli_query(db(),$query);
	}

	if($_REQUEST['serviceType']=='Train'){
		$query = 'DELETE FROM trainQueryMaster WHERE id="'.$_REQUEST['id'].'"';
		mysqli_query(db(),$query);
	}

	if($_REQUEST['serviceType']=='transferQueryMaster'){
		$query = 'DELETE FROM trainQueryMaster WHERE id="'.$_REQUEST['id'].'"';
		mysqli_query(db(),$query);
	}

	if($countNum==1){
	?>
	<script>
		location.reload();
	</script>
	<?php
	}
}

if($_REQUEST['action']=="deleteCompletePackageWiseRates" && $_REQUEST['id']!=''){
	$countNum = $_REQUEST['countNum'];

		$query = 'DELETE FROM packageWiseRateMaster WHERE id="'.$_REQUEST['id'].'"';
		mysqli_query(db(),$query);

	if($countNum==1){
	?>
	<script>
		location.reload();
	</script>
	<?php
	}
}

if($_REQUEST['action']=='loadcodetocheckhoteltype' && $_REQUEST['quotationId']!='' && $_REQUEST['queryId']!='' && $_REQUEST['hotelType']!=''){
	$quotationId = $_REQUEST['quotationId'];
	$queryId = $_REQUEST['queryId'];
	$hotelType = $_REQUEST['hotelType'];
	$rsAl = GetPageRecord('*','newQuotationDays','quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and deletestatus=0');
			while($newQuotationDay = mysqli_fetch_assoc($rsAl)){
				
				$hotelcheck = GetPageRecord('*','quotationHotelMaster','quotationId="'.$newQuotationDay['quotationId'].'" and queryId="'.$newQuotationDay['queryId'].'" and dayId="'.$newQuotationDay['id'].'"');
				if(mysqli_num_rows($hotelcheck)>0){
					
				$quotationHotelType = explode(',',$hotelType);
				foreach($quotationHotelType as $val){
					$rsDH = GetPageRecord('*','quotationHotelMaster','quotationId="'.$newQuotationDay['quotationId'].'" and queryId="'.$newQuotationDay['queryId'].'" and dayId="'.$newQuotationDay['id'].'" and hotelTypeId="'.$val.'"');
					$num = mysqli_num_rows($rsDH);
					
					if($num==0){
						?>
						<script>
				
						parent.alertspopupopen('action=remainingHotelTypeAlert&queryId=<?php echo $queryId; ?>&quotationId=<?php echo $quotationId; ?>&hotelType=<?php echo $hotelType; ?>','800px','auto')
						exit();
						</script>
						<?php

					}

				}
			}
			}

}

?>