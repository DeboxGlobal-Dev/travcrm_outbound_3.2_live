<?php
include "inc.php"; 

if($_REQUEST['add']==1){ 
	$rs='';  
	$rs=GetPageRecord('*','totalPaxSlab','1 and quotationId ="'.decode($_REQUEST['quotationId']).'" order by toRange desc '); 
	if(mysqli_num_rows($rs)>0){
		$paxData=mysqli_fetch_array($rs);

		$adult = $paxData['adult'];
		$child = $paxData['child'];
		$infant = $paxData['infant'];
		$sglRoom = $paxData['sglRoom'];
		$dblRoom = $paxData['dblRoom'];
		$twinRoom = $paxData['twinRoom'];
		$tplRoom = $paxData['tplRoom'];
		$ebedA = $paxData['extraNoofBed'];
		$cwb = $paxData['childwithNoofBed'];
		$cnb = $paxData['childwithoutNoofBed'];

		$fromRange = $paxData['toRange']+1;
		$toRange = $fromRange+2;
		$dividingFactor = $fromRange+1;


	}else{
		$quotQuery='';
		$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id='.decode($_REQUEST['quotationId']).'');
		$quotationData=mysqli_fetch_array($quotQuery);

		$pax = $quotationData['adult']+$quotationData['child'];
		$fromRange = $pax;
		$toRange = $pax;
		$dividingFactor = $pax;

		$adult = $quotationData['adult'];
		$child = $quotationData['child'];
		$infant = $quotationData['infant'];

		$sglRoom = $quotationData['sglRoom'];
		$dblRoom = $quotationData['dblRoom'];
		$twinRoom = $quotationData['twinRoom'];
		$tplRoom = $quotationData['tplRoom'];
		$quadNoofRoom = $quotationData['quadNoofRoom'];
		$sixNoofBedRoom = $quotationData['sixNoofBedRoom'];
		$eightNoofBedRoom = $quotationData['eightNoofBedRoom'];
		$tenNoofBedRoom = $quotationData['tenNoofBedRoom'];
		$teenNoofRoom = $quotationData['teenNoofRoom'];

		$extraNoofBed = $quotationData['extraNoofBed'];
		$childwithNoofBed = $quotationData['childwithNoofBed'];
		$childwithoutNoofBed = $quotationData['childwithoutNoofBed'];

		$DF_SGL = clean($quotationData['sglRoom']);
		$DF_DBL = clean($quotationData['dblRoom']*2);
		$DF_TWN = clean($quotationData['twinRoom']*2);
		$DF_TPL = clean($quotationData['tplRoom']*3);
		$DF_QUAD = clean($quotationData['quadNoofRoom']*4);
		$DF_SIX = clean($quotationData['sixNoofBedRoom']*6);
		$DF_EIGHT = clean($quotationData['eightNoofBedRoom']*8);
		$DF_TEN = clean($quotationData['tenNoofBedRoom']*10);
		$DF_ABED = clean($quotationData['extraNoofBed']);
		$DF_CBED = clean($quotationData['childwithNoofBed']+$quotationData['childwithoutNoofBed']+$quotationData['teenNoofRoom']);
	}

	$dateAdded=date('Y-m-d H:i:s A');
	$namevalueadd = 'quotationId="'.decode($_REQUEST['quotationId']).'",fromRange="'.$fromRange.'",toRange="'.$toRange.'",dividingFactor="'.$dividingFactor.'",DF_SGL="'.$DF_SGL.'",DF_DBL="'.$DF_DBL.'",DF_TWN="'.$DF_TWN.'",DF_TPL="'.$DF_TPL.'",DF_QUAD="'.$DF_QUAD.'",DF_SIX="'.$DF_SIX.'",DF_EIGHT="'.$DF_EIGHT.'",DF_TEN="'.$DF_TEN.'",DF_CBED="'.$DF_CBED.'",DF_ABED="'.$DF_ABED.'",addedBy="'.$_SESSION['userid'].'",status=0,dateAdded="'.$dateAdded.'",adult="'.$adult.'",child="'.$child.'",infant="'.$infant.'",sglRoom="'.$sglRoom.'",dblRoom="'.$dblRoom.'",twinRoom="'.$twinRoom.'",tplRoom="'.$tplRoom.'",quadNoofRoom="'.$quadNoofRoom.'",sixNoofBedRoom="'.$sixNoofBedRoom.'",eightNoofBedRoom="'.$eightNoofBedRoom.'",tenNoofBedRoom="'.$tenNoofBedRoom.'",teenNoofRoom="'.$teenNoofRoom.'",extraNoofBed="'.$extraNoofBed.'",childwithNoofBed="'.$childwithNoofBed.'",childwithoutNoofBed="'.$childwithoutNoofBed.'"';
	$lastid = addlistinggetlastid('totalPaxSlab',$namevalueadd);
	?>
	<script> 
	//alert('Slab Added Successfully');
	$("#addrow").load('loadpaxslab.php?view=1&quotationId=<?php echo $_REQUEST['quotationId']; ?>'); 
	</script>
	<?php
}   

if($_REQUEST['action']=='savetotalpaxslab' && trim($_REQUEST['id'])!='' ){ 
	$modifyDate=date('Y-m-d H:i:s A');
	$slabId=($_REQUEST['id']);
	$fromRange=clean($_REQUEST['fromRange']); 
	$toRange=clean($_REQUEST['toRange']); 
	$dividingFactor=clean($_REQUEST['dividingFactor']); 
	$dividingFactorC=clean($_REQUEST['dividingFactorC']); 
	$localEscort=clean($_REQUEST['localEscort']); 
	$foreignEscort=clean($_REQUEST['foreignEscort']);

	$status=1; 


 	$quotationId=decode($_REQUEST['quotationId']); 
	if($_REQUEST['fromRange'] > 0 && $_REQUEST['toRange'] > 0){

		$paxSlabDataq="";  
		$paxSlabDataq=GetPageRecord('*','totalPaxSlab',' 1 and ( fromRange BETWEEN "'.$fromRange.'" and "'.$toRange.'" OR "'.$toRange.'" BETWEEN fromRange and toRange ) and id != "'.$slabId.'" and quotationId="'.$quotationId.'"'); 
	 	if(mysqli_num_rows($paxSlabDataq) == 0 ){
			
			$adult = clean($_REQUEST['adult']);
			$child = clean($_REQUEST['child']);
			$infant = clean($_REQUEST['infant']);

			$sglRoom = clean($_REQUEST['sglRoom']);
			$dblRoom = clean($_REQUEST['dblRoom']);
			$twinRoom = clean($_REQUEST['twinRoom']);
			$tplRoom = clean($_REQUEST['tplRoom']);
			$quadNoofRoom = clean($_REQUEST['quadNoofRoom']);
			$sixNoofBedRoom = clean($_REQUEST['sixNoofBedRoom']);
			$eightNoofBedRoom = clean($_REQUEST['eightNoofBedRoom']);
			$tenNoofBedRoom = clean($_REQUEST['tenNoofBedRoom']);
			$teenNoofRoom = clean($_REQUEST['teenNoofRoom']);
			
			$extraNoofBed = clean($_REQUEST['extraNoofBed']);
			$childwithNoofBed = clean($_REQUEST['childwithNoofBed']);
			$childwithoutNoofBed = clean($_REQUEST['childwithoutNoofBed']);

			$DF_SGL  = clean($_REQUEST['DF_SGL']);
			$DF_DBL  = clean($_REQUEST['DF_DBL']);
			$DF_TWN  = clean($_REQUEST['DF_TWN']);
			$DF_TPL  = clean($_REQUEST['DF_TPL']);
			$DF_QUAD = clean($_REQUEST['DF_QUAD']);
			$DF_SIX  = clean($_REQUEST['DF_SIX']);
			$DF_EIGHT= clean($_REQUEST['DF_EIGHT']);
			$DF_TEN  = clean($_REQUEST['DF_TEN']);
			$DF_CBED = clean($_REQUEST['DF_CBED']);
			$DF_ABED = clean($_REQUEST['DF_ABED']);
			$DF_INF = clean($_REQUEST['DF_INF']);
			$discount_INF = clean($_REQUEST['discount_INF']);

			$namevalue ='fromRange="'.$fromRange.'",toRange="'.$toRange.'",dividingFactor="'.$dividingFactor.'",DF_SGL="'.$DF_SGL.'",DF_DBL="'.$DF_DBL.'",DF_TWN="'.$DF_TWN.'",DF_TPL="'.$DF_TPL.'",DF_QUAD="'.$DF_QUAD.'",DF_SIX="'.$DF_SIX.'",DF_EIGHT="'.$DF_EIGHT.'",DF_TEN="'.$DF_TEN.'",DF_CBED="'.$DF_CBED.'",DF_ABED="'.$DF_ABED.'",DF_INF="'.$DF_INF.'",discount_INF="'.$discount_INF.'",localEscort="'.$localEscort.'",foreignEscort="'.$foreignEscort.'",modifyBy="'.$_SESSION['userid'].'",modifyDate="'.$modifyDate.'",adult="'.$adult.'",child="'.$child.'",infant="'.$infant.'",sglRoom="'.$sglRoom.'",dblRoom="'.$dblRoom.'",twinRoom="'.$twinRoom.'",tplRoom="'.$tplRoom.'",quadNoofRoom="'.$quadNoofRoom.'",sixNoofBedRoom="'.$sixNoofBedRoom.'",eightNoofBedRoom="'.$eightNoofBedRoom.'",tenNoofBedRoom="'.$tenNoofBedRoom.'",teenNoofRoom="'.$teenNoofRoom.'",extraNoofBed="'.$extraNoofBed.'",childwithNoofBed="'.$childwithNoofBed.'",childwithoutNoofBed="'.$childwithoutNoofBed.'"';
			$where='id="'.$slabId.'"';
			$update = updatelisting('totalPaxSlab',$namevalue,$where);
			//insert and delete foc rows 
	 		if( $localEscort > 0 ){
				$focDataLE='';
	 			$focDataLE=GetPageRecord('*','quotationFOCRates','1 and quotationId="'.$quotationId.'" and focType="LE" and slabId="'.$slabId.'"');
				$alreadyExistLE = mysqli_num_rows($focDataLE);
				if($alreadyExistLE == 0){
					$namevalue ='quotationId="'.$quotationId.'",focType="LE",slabId="'.$slabId.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';
					$add = addlisting('quotationFOCRates',$namevalue); 
				}else{
					$namevalue ='dateAdded="'.$dateAdded.'",modifyBy="'.$_SESSION['userid'].'",modifyDate="'.$modifyDate.'"';
					$where='slabId="'.$slabId.'" and focType="LE" and quotationId="'.$quotationId.'"';
					$update = updatelisting('quotationFOCRates',$namevalue,$where); 
				} 	
			}
			else{
				deleteRecord('quotationFOCRates','quotationId="'.$quotationId.'" and focType="LE" and slabId = "'.$slabId.'"'); 
			}
	  		if( $foreignEscort > 0 ){
	 			$focDataFE='';
	  			$focDataFE=GetPageRecord('*','quotationFOCRates','1 and quotationId="'.$quotationId.'" and focType="FE" and slabId="'.$slabId.'"');
				$alreadyExistFE = mysqli_num_rows($focDataFE);
	 			if($alreadyExistFE == 0){
					$namevalue ='quotationId="'.$quotationId.'",focType="FE",slabId="'.$slabId.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'",modifyBy="'.$_SESSION['userid'].'",modifyDate="'.$modifyDate.'"';
					$add = addlisting('quotationFOCRates',$namevalue); 
				}else{
					$namevalue ='dateAdded="'.$dateAdded.'",modifyBy="'.$_SESSION['userid'].'",modifyDate="'.$modifyDate.'"';
					$where='slabId="'.$slabId.'" and focType="FE" and quotationId="'.$quotationId.'"';
					$update = updatelisting('quotationFOCRates',$namevalue,$where); 
				} 
			}
			else{
				deleteRecord('quotationFOCRates','quotationId="'.$quotationId.'" and focType="FE" and slabId = "'.$slabId.'"'); 
			}

			?>
			<script> 
			<?php 
			if( $msgShow != 1 ){
				if($fromRange==$toRange){ ?>
				alert('Pax Range <?php echo $fromRange; ?> Saved Successfully');
				<?php } else{ ?>
				alert('Pax Range <?php echo $fromRange; ?> To <?php echo $toRange; ?> Saved Successfully');
				<?php } 
			}   ?>  
			$("#addrow").load('loadpaxslab.php?view=1&msgShow=<?php echo ($msgShow); ?>&quotationId=<?php echo encode($quotationId); ?>'); 
			</script>
				<?php
		} else{ ?>
			<script> 
			alert('This Pax Range is already exist');
			$("#addrow").load('loadpaxslab.php?view=1&quotationId=<?php echo encode($quotationId); ?>'); 
			</script>
		<?php } 
	}else{
		?>
		<script> 
		alert('Pax range should be greater than zero.'); 
		</script>
		<?php 
	}
} 
 
if(trim($_REQUEST['action'])=='saveescortdata'){
	$id=$_REQUEST['id']; 
	$quotationId=decode($_REQUEST['quotationId']);
	$sglNORoom	=clean($_REQUEST['sglNORoom']); 
	$dblNORoom	=clean($_REQUEST['dblNORoom']); 
	$tplNORoom	=clean($_REQUEST['tplNORoom']); 
	$focType=clean($_REQUEST['focType']); 
	$hotelCost =clean($_REQUEST['hotelCost']);
	$guideCost =clean($_REQUEST['guideCost']);
	$activityCost =clean($_REQUEST['activityCost']);
	$entranceCost =clean($_REQUEST['entranceCost']);
	$transferCost =clean($_REQUEST['transferCost']);
	$trainCost =clean($_REQUEST['trainCost']);
	$flightCost =clean($_REQUEST['flightCost']);
	$restaurantCost =clean($_REQUEST['restaurantCost']);
	$otherCost =clean($_REQUEST['otherCost']);
	$hotelCalType =clean($_REQUEST['hotelCalType']);
	$guideCalType =clean($_REQUEST['guideCalType']);
	$activityCalType =clean($_REQUEST['activityCalType']);
	$entranceCalType =clean($_REQUEST['entranceCalType']);
	$transferCalType =clean($_REQUEST['transferCalType']);
	$trainCalType =clean($_REQUEST['trainCalType']);
	$flightCalType =clean($_REQUEST['flightCalType']);
	$restaurantCalType =clean($_REQUEST['restaurantCalType']);
	$otherCalType =clean($_REQUEST['otherCalType']); 
	   
	$checkduplicate = checkduplicate('quotationFOCRates','1 and id="'.$id.'"');
	if($checkduplicate=='no'){ 
		$namevalue ='quotationId="'.$quotationId.'",sglNORoom="'.$sglNORoom.'",dblNORoom="'.$dblNORoom.'",tplNORoom="'.$tplNORoom.'",focType="'.$focType.'",hotelCost="'.$hotelCost.'",guideCost="'.$guideCost.'",activityCost="'.$activityCost.'",entranceCost="'.$entranceCost.'",transferCost="'.$transferCost.'",trainCost="'.$trainCost.'",flightCost="'.$flightCost.'",restaurantCost="'.$restaurantCost.'",otherCost="'.$otherCost.'",hotelCalType="'.$hotelCalType.'",guideCalType="'.$guideCalType.'",activityCalType="'.$activityCalType.'",entranceCalType="'.$entranceCalType.'",transferCalType="'.$transferCalType.'",trainCalType="'.$trainCalType.'",flightCalType="'.$flightCalType.'",restaurantCalType="'.$restaurantCalType.'",otherCalType="'.$otherCalType.'"';
		$add = addlisting('quotationFOCRates',$namevalue); 
	} else{
		$namevalue ='sglNORoom="'.$sglNORoom.'",dblNORoom="'.$dblNORoom.'",tplNORoom="'.$tplNORoom.'",focType="'.$focType.'",hotelCost="'.$hotelCost.'",guideCost="'.$guideCost.'",activityCost="'.$activityCost.'",entranceCost="'.$entranceCost.'",transferCost="'.$transferCost.'",trainCost="'.$trainCost.'",flightCost="'.$flightCost.'",restaurantCost="'.$restaurantCost.'",otherCost="'.$otherCost.'",hotelCalType="'.$hotelCalType.'",guideCalType="'.$guideCalType.'",activityCalType="'.$activityCalType.'",entranceCalType="'.$entranceCalType.'",transferCalType="'.$transferCalType.'",trainCalType="'.$trainCalType.'",flightCalType="'.$flightCalType.'",restaurantCalType="'.$restaurantCalType.'",otherCalType="'.$otherCalType.'"';
		$where='id="'.$id.'"';
		$update = updatelisting('quotationFOCRates',$namevalue,$where); 
	} 
	?>
	<script> 
	alert('Data Saved'); 
	// window.location.reload()
	<?php
	if($focType == 'FE'){  ?>
		$("#focCostBox<?php echo $slabId; ?>").hide();
		$("#iconchekescort<?php echo $slabId; ?>").attr('class','fa fa-plus');
		<?php 
	}  ?>
	$("#addrow").load('loadpaxslab.php?view=1&msgShow=1&quotationId=<?php echo encode($quotationId); ?>'); 
	</script>
	<?php
	// $page = $_SERVER['PHP_SELF']; 
	// $sec = "10"; 
	// header("Location: $sec; url=$page");
}   

if($_REQUEST['deletestatus']=="yes" && $_REQUEST['id']!=''){
	deleteRecord('totalPaxSlab','id="'.$_REQUEST['id'].'"');
	deleteRecord('quotationFOCRates','quotationId="'.decode($_REQUEST['quotationId']).'" and slabId = "'.$_REQUEST['id'].'" '); 
	?>
	<script> 
	//alert('Slab Deleted Successfully');
	$("#addrow").load('loadpaxslab.php?view=1&quotationId=<?php echo $_REQUEST['quotationId']; ?>'); 
	</script>
	<?php
}

if($_REQUEST['action']=="changeFinal" && $_REQUEST['id']!='' && decode($_REQUEST['quotationId']) > 0){
 	
	$quotQuery='';
	$quotQuery=GetPageRecord('quotationType',_QUOTATION_MASTER_,'id="'.decode($_REQUEST['quotationId']).'"');
	$quotationData=mysqli_fetch_array($quotQuery);
	// if($quotationData['quotationType']==1){ 
	// 	updatelisting('totalPaxSlab','status=0',' 1 and quotationId="'.decode($_REQUEST['quotationId']).'"'); 
	// }
	$update = updatelisting('totalPaxSlab','status='.$_REQUEST['checkFinal'].'',' id="'.$_REQUEST['id'].'" and quotationId="'.decode($_REQUEST['quotationId']).'"'); 
	?>
	<script>  
	$("#addrow").load('loadpaxslab.php?view=1&quotationId=<?php echo $_REQUEST['quotationId']; ?>'); 
	</script>
	<?php
}

if($_REQUEST['view']==1){
	 
	$quotQuery='';
	$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id='.decode($_REQUEST['quotationId']).'');
	$quotationData=mysqli_fetch_array($quotQuery);

	$pax = $quotationData['adult']+$quotationData['child'];
	$quotationId = decode($_REQUEST['quotationId']);
 
	$rsQuery = '';
	$rsQuery = GetPageRecord('*', _QUERY_MASTER_, ' id="' . $quotationData['queryId'] . '"');
	$queryData=mysqli_fetch_array($rsQuery);
	$travelType = $queryData['travelType'];

	$sNo2 = 0; 
	$rs='';     
	$rs=GetPageRecord('*','totalPaxSlab','1 and quotationId ="'.decode($_REQUEST['quotationId']).'" order by id asc');
	$numOfPaxSlab = mysqli_num_rows($rs);
	while($resListing1=mysqli_fetch_array($rs)){
		//insert and delete foc rows 
		$localEscort = $resListing1['localEscort'];
		$foreignEscort = $resListing1['foreignEscort'];
		$editId = $resListing1['id'];
		$quotationId = $resListing1['quotationId'];


		$modifyDate = $dateAdded = date('Y-m-d H:i:s A');

		if ($resListing1['sglRoom']>0 || $resListing1['dblRoom']>0 || $resListing1['tplRoom']>0 || $resListing1['twinRoom']>0 || $resListing1['extraNoofBed']>0 || $resListing1['childwithNoofBed']>0 || $resListing1['childwithoutNoofBed']>0 ) {
			$sglRoom = $resListing1['sglRoom'];
			$dblRoom = $resListing1['dblRoom'];
			$twinRoom = $resListing1['twinRoom'];
			$tplRoom = $resListing1['tplRoom'];

			$quadNoofRoom = $resListing1['quadNoofRoom'];
			$sixNoofBedRoom = $resListing1['sixNoofBedRoom'];
			$eightNoofBedRoom = $resListing1['eightNoofBedRoom'];
			$tenNoofBedRoom = $resListing1['tenNoofBedRoom'];
			$teenNoofRoom = $resListing1['teenNoofRoom'];

			$extraNoofBed = $resListing1['extraNoofBed'];
			$childwithNoofBed = $resListing1['childwithNoofBed'];
			$childwithoutNoofBed = $resListing1['childwithoutNoofBed'];
		}else{
			$sglRoom = $quotationData['sglRoom'];
			$dblRoom = $quotationData['dblRoom'];
			$twinRoom = $quotationData['twinRoom'];
			$tplRoom = $quotationData['tplRoom'];

			$quadNoofRoom = $quotationData['quadNoofRoom'];
			$sixNoofBedRoom = $quotationData['sixNoofBedRoom'];
			$eightNoofBedRoom = $quotationData['eightNoofBedRoom'];
			$tenNoofBedRoom = $quotationData['tenNoofBedRoom'];
			$teenNoofRoom = $quotationData['teenNoofRoom'];

			$extraNoofBed = $quotationData['extraNoofBed'];
			$childwithNoofBed = $quotationData['childwithNoofBed'];
			$childwithoutNoofBed = $quotationData['childwithoutNoofBed'];
		}

		if ($resListing1['adult']>0 || $resListing1['child']>0) {
			$adult = $resListing1['adult'];
			$child = $resListing1['child'];
			$infant = $resListing1['infant'];
		}else{
			$adult = $quotationData['adult'];
			$child = $quotationData['child'];
			$infant = $quotationData['infant'];
		}


		$isSGL = clean($sglRoom);
		$isDBL = clean($dblRoom);
		$isTWN = clean($twinRoom);
		$isTPL = clean($tplRoom);
		$isQUAD = clean($quadNoofRoom);
		$isSIX = clean($sixNoofBedRoom);
		$isEIGHT = clean($eightNoofBedRoom);
		$isTEN = clean($tenNoofRoom);
		$isABED = clean($extraNoofBed);
		$isCBED = clean($childwithNoofBed+$childwithoutNoofBed+$teenNoofRoom);
		$isINF = clean($infant);
		

 		if( $localEscort > 0 ){
			$focDataLE='';
 			$focDataLE=GetPageRecord('*','quotationFOCRates','1 and quotationId="'.$quotationId.'" and focType="LE" and slabId="'.$editId.'"');
			$alreadyExistLE = mysqli_num_rows($focDataLE);
			if($alreadyExistLE == 0){
				$namevalue ='quotationId="'.$quotationId.'",focType="LE",slabId="'.$editId.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';
				$add = addlisting('quotationFOCRates',$namevalue); 
			}else{
				$namevalue ='dateAdded="'.$dateAdded.'",modifyBy="'.$_SESSION['userid'].'",modifyDate="'.$modifyDate.'"';
				$where='slabId="'.$editId.'" and focType="LE" and quotationId="'.$quotationId.'"';
				$update = updatelisting('quotationFOCRates',$namevalue,$where); 
			} 	
		}else{
			deleteRecord('quotationFOCRates','quotationId="'.$quotationId.'" and focType="LE" and slabId = "'.$editId.'" order by id desc'); 
		}
 		if( $foreignEscort > 0 ){
 			$focDataFE='';
  			$focDataFE=GetPageRecord('*','quotationFOCRates','1 and quotationId="'.$quotationId.'" and focType="FE" and slabId="'.$editId.'"');
			$alreadyExistFE = mysqli_num_rows($focDataFE);
 			if($alreadyExistFE == 0){
				$namevalue ='quotationId="'.$quotationId.'",focType="FE",slabId="'.$editId.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'",modifyBy="'.$_SESSION['userid'].'",modifyDate="'.$modifyDate.'"';
				$add = addlisting('quotationFOCRates',$namevalue); 
			}else{
				$namevalue ='dateAdded="'.$dateAdded.'",modifyBy="'.$_SESSION['userid'].'",modifyDate="'.$modifyDate.'"';
				$where='slabId="'.$editId.'" and focType="FE" and quotationId="'.$quotationId.'"';
				$update = updatelisting('quotationFOCRates',$namevalue,$where); 
			} 
		}else{
			deleteRecord('quotationFOCRates','quotationId="'.$quotationId.'" and focType="FE" and slabId = "'.$editId.'" order by id desc'); 
		}
		$sNo2++; 

		if($travelType == 1 ){ ?>
		<tr height="20" style="border-bottom:1px solid #ccc;">
			<td align="center"> 
				<input type="checkbox" id="checkFinal<?php echo $resListing1['id']; ?>" <?php if($numOfPaxSlab>1){ ?>onClick="changeFinal('<?php echo $resListing1['id']; ?>');"<?php }else{ ?> disabled <?php } ?><?php if($resListing1['status']==1){ ?> checked <?php } ?> style="display:block"/>
			</td>
		  	<td align="center"> 
		  		<?php if($numOfPaxSlab>1){ ?>
		  		<i class="fa fa-trash" style="font-size: 20px; color:#FF0000; cursor:pointer;" onClick="deleteRow('<?php echo $resListing1['id']; ?>');"></i>
		  		<?php } ?>
			</td>
			<td align="center"><div>
			  <input name="fromRange" type="text"  id="fromRange<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['fromRange']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
			</div></td>
		  <td align="center"><div>
			  <input name="toRange" type="text"  id="toRange<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['toRange']); ?>" onkeyup="myfunction<?php echo $resListing1['id']; ?>();" autocomplete="off"  style="width: 60px; text-align: center;">
			</div></td>
		  <td align="center"><div>
			  <input name="dividingFactor" type="text"  id="dividingFactor<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['dividingFactor']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
			</div></td>
			<script>
			function myfunction<?php echo $resListing1['id']; ?>(){
			  var x = $("#fromRange<?php echo $resListing1['id']; ?>").val();
			  $("#dividingFactor<?php echo $resListing1['id']; ?>").val(x);
			}
			</script>
			<td align="center"><div>
			  <input name="localEscort" type="text"  id="localEscort<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['localEscort']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
			</div></td>
			<td align="center"><div>
			  <input name="foreignEscort" type="text"  id="foreignEscort<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['foreignEscort']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
			</div></td> 
			<?php 
			$tmpEscort = 0;
			if($resListing1['localEscort'] > 0 || $resListing1['foreignEscort'] > 0 ){
				$tmpEscort = 1;
			}
			?>
			<td align="center">
				<div onclick="addmarkfunescort(<?php echo $resListing1['id']; ?>,<?php echo $tmpEscort; ?>);" style="cursor: pointer;overflow:hidden;width: 50%;background-color: #4285f4;border-radius: 5px;padding: 5px;color: white;display: initial;" ><i class="<?php echo ($_REQUEST['msgShow'] == 1)?'fa fa-minus':'fa fa-plus'; ?>" aria-hidden="true" id="iconchekescort<?php echo $resListing1['id']; ?>"></i>
					<span  id="iconchekescortLable<?php echo $resListing1['id']; ?>">&nbsp;Open&nbsp;Escort&nbsp;Rates </span>
				</div>
			</td> 
			 
			<td align="center"><div onClick="savetotalpaxslab(<?php echo $resListing1['id']; ?>);" style="background-color: #4285f4; color: #fff; padding: 5px 10px; border-radius: 4px; text-align: center;cursor:pointer;">Save</div></td>
		</tr>
		<tr>
			<td align="left" colspan="9" style="background-color: #233a49; color: white;">
				<!-- <h3>Slab Rooms</h3> -->
				<table cellpadding="5" cellspacing="0" width="100%" border="0" style="border-collapse:collapse;" >
					<tr>
						<td align="left"><strong>No.of&nbsp;Adult</strong></td>
						<td align="left"><strong>No.of&nbsp;Child</strong></td>
						<td align="left"><strong>No.of&nbsp;Infant</strong></td>
						<td align="left"><strong>SGL&nbsp;Room</strong></td>
						<td align="left"><strong>DBL&nbsp;Room</strong></td>
						<td align="left"><strong>TWIN&nbsp;Room</strong></td>
						<td align="left"><strong>TPL&nbsp;Room</strong></td>
						<td align="left"><strong>QUAD&nbsp;BED</strong></td>
						<td align="left"><strong>SIX&nbsp;BED</strong></td>
						<td align="left"><strong>EIGHT&nbsp;BED</strong></td>
						<td align="left"><strong>TEN&nbsp;BED</strong></td>
						<td align="left"><strong>TEEN&nbsp;BED</strong></td>
						<td align="left"><strong>E.Bed(A)</strong></td>
						<td align="left"><strong>CWBed</strong></td>
						<td align="left"><strong>CNBed</strong></td>
					</tr>
					<tr>
						<td align="left">
						<input name="adult" type="text" id="adult<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($adult); ?>" autocomplete="off"  style="width: 60px;">
						</td>
						<td align="left">
						<input name="child" type="text" id="child<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($child); ?>" autocomplete="off"  style="width: 60px;">
						</td>
						<td align="left">
						<input name="infant" type="text" id="infant<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($infant); ?>" autocomplete="off"  style="width: 60px;">
						</td>
						<td align="left">
						<input name="sglRoom" type="text" id="sglRoom<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($sglRoom); ?>" autocomplete="off"  style="width: 60px;">
						</td>
						<td align="left">
						<input name="dblRoom" type="text" id="dblRoom<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($dblRoom); ?>" autocomplete="off"  style="width: 60px;">
						</td>
						<td align="left">
						<input name="twinRoom" type="text" id="twinRoom<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($twinRoom); ?>" autocomplete="off"  style="width: 60px;">
						</td>
						<td align="left">
						<input name="tplRoom" type="text" id="tplRoom<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($tplRoom); ?>" autocomplete="off"  style="width: 60px;">
						</td>	

						<td align="left">
						<input name="quadNoofRoom" type="text" id="quadNoofRoom<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($quadNoofRoom); ?>" autocomplete="off"  style="width: 60px;">
						</td>	

						<td align="left">
						<input name="sixNoofBedRoom" type="text" id="sixNoofBedRoom<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($sixNoofBedRoom); ?>" autocomplete="off"  style="width: 60px;">
						</td>	

						<td align="left">
						<input name="eightNoofBedRoom" type="text" id="eightNoofBedRoom<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($eightNoofBedRoom); ?>" autocomplete="off"  style="width: 60px;">
						</td>	

						<td align="left">
						<input name="tenNoofBedRoom" type="text" id="tenNoofBedRoom<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($tenNoofBedRoom); ?>" autocomplete="off"  style="width: 60px;">
						</td>	

						<td align="left">
						<input name="teenNoofRoom" type="text" id="teenNoofRoom<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($teenNoofRoom); ?>" autocomplete="off"  style="width: 60px;">
						</td>
						<td align="left">
						<input name="extraNoofBed" type="text" id="extraNoofBed<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($extraNoofBed); ?>" autocomplete="off"  style="width: 60px;">
						</td>
						<td align="left">
						<input name="childwithNoofBed" type="text" id="childwithNoofBed<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($childwithNoofBed); ?>" autocomplete="off"  style="width: 60px;">
						</td>
						<td align="left">
						<input name="childwithoutNoofBed" type="text" id="childwithoutNoofBed<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($childwithoutNoofBed); ?>" autocomplete="off"  style="width: 60px;">
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php }else{  ?>
		<tr height="20" style="border-bottom:1px solid #ccc;">
			<td align="center"><input type="checkbox" id="checkFinal<?php echo $resListing1['id']; ?>" onClick="changeFinal('<?php echo $resListing1['id']; ?>');" <?php if($resListing1['status']==1){ ?> checked <?php } ?> style="display:block"/>
			</td>
			<td align="center"><div>
			  <input name="fromRange" type="text" id="fromRange<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['fromRange']); ?>" autocomplete="off"  style="width: 60px; text-align: center;border:0px solid;outline: none;" disabled > 
			  	<input name="toRange" type="hidden"  id="toRange<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['toRange']); ?>">
				<input name="localEscort" type="hidden"  id="localEscort<?php echo $resListing1['id']; ?>" value="0" >
			  	<input name="foreignEscort" type="hidden"  id="foreignEscort<?php echo $resListing1['id']; ?>" value="0" >
				</div>
			</td>

						<input name="adult" type="hidden" id="adult<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($adult); ?>" autocomplete="off"  style="width: 60px;">
						
						<input name="child" type="hidden" id="child<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($child); ?>" autocomplete="off"  style="width: 60px;">
						
						<input name="infant" type="hidden" id="infant<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($infant); ?>" autocomplete="off"  style="width: 60px;">
					

			<?php if($isSGL>0){ ?>
			<td align="center"><div>
			 	<input name="DF_SGL" type="text"  id="DF_SGL<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['DF_SGL']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
				</div>
			</td>
			<?php }if($isDBL>0){  ?>
			<td align="center"><div>
			 	<input name="DF_DBL" type="text"  id="DF_DBL<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['DF_DBL']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
				</div>
			</td>
			<?php }if($isTWN>0){  ?>
			<td align="center"><div>
			 	<input name="DF_TWN" type="text"  id="DF_TWN<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['DF_TWN']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
				</div>
			</td>
			<?php }if($isTPL>0){  ?>
			<td align="center"><div>
			 	<input name="DF_TPL" type="text"  id="DF_TPL<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['DF_TPL']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
				</div>
			</td>
			<?php }if($isQUAD>0){  ?>
			<td align="center"><div>
			 	<input name="DF_QUAD" type="text"  id="DF_QUAD<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['DF_QUAD']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
				</div>
			</td>
			<?php }if($isSIX>0){  ?>
			<td align="center"><div>
			 	<input name="DF_SIX" type="text"  id="DF_SIX<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['DF_SIX']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
				</div>
			</td>
			<?php }if($isEIGHT>0){  ?>
			<td align="center"><div>
			 	<input name="DF_EIGHT" type="text"  id="DF_EIGHT<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['DF_EIGHT']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
				</div>
			</td>
			<?php }if($isTEN>0){  ?>
			<td align="center"><div>
			 	<input name="DF_TEN" type="text"  id="DF_TEN<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['DF_TEN']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
				</div>
			</td>
			<?php }if($isABED>0){  ?>
			<td align="center">
				<div><input name="DF_ABED" type="text"  id="DF_ABED<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['DF_ABED']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
				</div>  
			</td>
			<?php }if($isCBED>0){  ?>
			<td align="center"><div>
			 	<input name="DF_CBED" type="text"  id="DF_CBED<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['DF_CBED']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
				</div>
			</td>

			<?php }if($isINF>0){  ?>
			<td align="center"><div>
			 	<input name="DF_INF" type="text"  id="DF_INF<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['DF_INF']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
				</div>
			</td>

			<td align="center"><div>
			 	<input name="discount_INF" type="text"  id="discount_INF<?php echo $resListing1['id']; ?>" value="<?php echo stripslashes($resListing1['discount_INF']); ?>" autocomplete="off"  style="width: 60px; text-align: center;">
				</div>
			</td>
			
			<?php } ?>
			<td align="center"><div onClick="savetotalpaxslab(<?php echo $resListing1['id']; ?>);" style="background-color: #4285f4; color: #fff; padding: 5px 10px; border-radius: 4px; text-align: center;cursor:pointer;">Save</div></td>
		</tr>
		<?php } 
		$focTypeQuery='';
  		$focTypeQuery=GetPageRecord('*','quotationFOCRates',' 1 and quotationId="'.$resListing1['quotationId'].'" and slabId = "'.$resListing1['id'].'" group by focType order by focType desc');
		if(mysqli_num_rows($focTypeQuery) > 0 && ( $resListing1['localEscort'] > 0 || $resListing1['foreignEscort'] > 0 ) ){
		?>
		<!--foc cost block start-->
		<tr height="20" style="border-bottom:1px solid #ccc;<?php echo ($_REQUEST['msgShow'] == 1)?'':'display:none;'; ?>" id="focCostBox<?php echo $resListing1['id']; ?>">
		<td colspan="9" style="background-color: #233a49;">
		<div>
			<?php  
			$closeCount = 0;
			while($focTypeData=mysqli_fetch_array($focTypeQuery)){ 
				if($focTypeData['focType'] == 'LE'){
				?>
				<h3 style="background: #233a49;color: #fff;">Local Escort(FOC Cost) <div style="cursor: pointer;float: right;margin: 0px 10px 10px 0;" onclick="closeEscortData('<?php echo $resListing1['id']; ?>');">Close</div></h3>
				<table border="1" cellpadding="5" cellspacing="0" bordercolor="#233a49" bgColor="#233a49" width="100%" style="color: #fff;">
				   <tr> 
					<td width="6%" align="left" ><div align="center"><strong>SGL Room</strong></div></td>
					<td width="6%" align="left" ><div align="center"><strong>DBL Room</strong></div></td>
					<!-- <td width="6%" align="left" ><div align="center"><strong>TPL Room</strong></div></td> -->
					<td width="5%" align="left" ><div align="center"><strong>Hotel</strong></div></td>
					<td width="5%" align="left" ><div align="center"><strong>Tour Escort</strong></div></td>
					<td width="5%" align="left" ><div align="center"><strong>SightSeeing</strong></div></td>
					<td width="5%" align="left" ><div align="center"><strong>Monument</strong></div></td>
					<td width="5%" align="left" ><div align="center"><strong>Transfer</strong></div></td>
					<td width="5%" align="left" ><div align="center"><strong>Train</strong></div></td>
					<td width="5%" align="left" ><div align="center"><strong>Flight</strong></div></td>
					<td width="5%" align="left" ><div align="center"><strong>Restaurant</strong></div></td>
 					<td width="5%" align="left" ><div align="center"><strong>Other</strong></div></td>  
					<td width="5%" align="left" ><div align="center"><strong>Action</strong></div></td>   
				  </tr>
				  <?php 
				  $focQLE='';
				  $focQLE=GetPageRecord('*','quotationFOCRates','1 and quotationId="'.$resListing1['quotationId'].'" and focType="LE"  and slabId = "'.$resListing1['id'].'" order by id asc');
				  while($focDataLE=mysqli_fetch_array($focQLE)){ 
				  ?>
				   <tr>
					 <td width="5%"  align="left" ><div align="center">
					  <input type="text" class="markInput digit_only" id="sglNORoom<?php echo $focDataLE['id']; ?>" value="<?php echo $focDataLE['sglNORoom']; ?>"/>
					  </div></td>
					  <td width="5%"  align="left" ><div align="center">
					  <input type="text" class="markInput digit_only" id="dblNORoom<?php echo $focDataLE['id']; ?>" value="<?php echo $focDataLE['dblNORoom']; ?>"/>
					  </div></td>
					  
					  <!-- code removed from here! -->

					  <td width="5%"  align="left" >
					  	<div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
						  <select id="hotelCalType<?php echo $focDataLE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
							<option value="1" <?php if($focDataLE['hotelCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
							<option value="2" <?php if($focDataLE['hotelCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
						  </select>
					  <input type="text" class="markInput digit_only" id="hotelCost<?php echo $focDataLE['id']; ?>" value="<?php echo $focDataLE['hotelCost']; ?>"/>
					  </div></td>
					  
					  <td width="5%"  align="left" >
					  <div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
						  <select id="guideCalType<?php echo $focDataLE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
							<option value="1" <?php if($focDataLE['guideCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
							<option value="2" <?php if($focDataLE['guideCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
						  </select>
					  <input type="text" class="markInput digit_only" id="guideCost<?php echo $focDataLE['id']; ?>" value="<?php echo $focDataLE['guideCost']; ?>"/>
					  </div></td>
					  
					   <td width="5%"  align="left" >
					   	<div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
						  <select id="activityCalType<?php echo $focDataLE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
							<option value="1" <?php if($focDataLE['activityCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
							<option value="2" <?php if($focDataLE['activityCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
						  </select>
					  <input type="text" class="markInput digit_only" id="activityCost<?php echo $focDataLE['id']; ?>" value="<?php echo $focDataLE['activityCost']; ?>"/>
					  </div></td>
					  
					   <td width="5%"  align="left" >
					   	<div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
						  <select id="entranceCalType<?php echo $focDataLE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
							<option value="1" <?php if($focDataLE['entranceCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
							<option value="2" <?php if($focDataLE['entranceCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
						  </select>
					  <input type="text" class="markInput digit_only" id="entranceCost<?php echo $focDataLE['id']; ?>" value="<?php echo $focDataLE['entranceCost']; ?>"/>
					  </div></td>
					   
						<td width="5%"  align="left" >
							<div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
						  <select id="transferCalType<?php echo $focDataLE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
							<option value="1" <?php if($focDataLE['transferCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
							<option value="2" <?php if($focDataLE['transferCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
						  </select>
					  <input type="text" class="markInput digit_only" id="transferCost<?php echo $focDataLE['id']; ?>" value="<?php echo $focDataLE['transferCost']; ?>"/>
					  </div></td>
					  
						<td width="5%"  align="left" >
						<div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
						  <select id="trainCalType<?php echo $focDataLE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
							<option value="1" <?php if($focDataLE['trainCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
							<option value="2" <?php if($focDataLE['trainCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
						  </select>	
					  <input type="text" class="markInput digit_only" id="trainCost<?php echo $focDataLE['id']; ?>" value="<?php echo $focDataLE['trainCost']; ?>"/>
					  </div></td>
					  
					   <td width="5%"  align="left" >
					   <div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
						  <select id="flightCalType<?php echo $focDataLE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
							<option value="1" <?php if($focDataLE['flightCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
							<option value="2" <?php if($focDataLE['flightCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
						  </select>	
					  <input type="text" class="markInput digit_only" id="flightCost<?php echo $focDataLE['id']; ?>" value="<?php echo $focDataLE['flightCost']; ?>"/>
					  </div></td>
					  
						<td width="5%"  align="left" >
						<div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
						  <select id="restaurantCalType<?php echo $focDataLE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
							<option value="1" <?php if($focDataLE['restaurantCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
							<option value="2" <?php if($focDataLE['restaurantCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
						  </select>	
					  <input type="text" class="markInput digit_only" id="restaurantCost<?php echo $focDataLE['id']; ?>" value="<?php echo $focDataLE['restaurantCost']; ?>"/>
					  </div></td>
					  
 				      <td width="5%"  align="left" >
 				      	<div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
						  <select id="otherCalType<?php echo $focDataLE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
							<option value="1" <?php if($focDataLE['otherCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
							<option value="2" <?php if($focDataLE['otherCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
						  </select>
					  <input type="text" class="markInput digit_only" id="otherCost<?php echo $focDataLE['id']; ?>" value="<?php echo $focDataLE['otherCost']; ?>"/>
 					  </div></td>
					  <td width="5%"  align="left" ><div onclick="saveescortdata(<?php echo $focDataLE['id']; ?>,<?php echo $resListing1['id']; ?>);" style="background-color: #4285f4;padding: 6px 10px;color: #fff;border-radius: 4px;width: 50px;text-align: center;cursor: pointer;" id="saveBtnEscort<?php echo $focDataLE['id']; ?>">Save</div> 					  
						<input type="hidden" class="markInput digit_only" id="focType<?php echo $focDataLE['id']; ?>" value="<?php echo $focDataLE['focType']; ?>"/></td>
				   </tr> 
				  <?php } ?>
				</table>
				<?php
				$closeCount = 1;
				}
 				if($focTypeData['focType'] == 'FE'){
				?>
				<h3 style="background: #233a49;color: #fff;padding-top: 10px;">Foreign Escort(FOC Cost)
					<?php if($closeCount == 0){ ?><div style="cursor: pointer;float: right;margin: 0px 10px 10px 0;" onclick="closeEscortData('<?php echo $resListing1['id']; ?>');">Close</div><?php } ?></h3>
				<table border="1" cellpadding="5" cellspacing="0" bordercolor="#233a49" bgColor="#233a49" width="100%" style="color: #fff;">
			    <tr> 
				<td width="6%" align="left" ><div align="center"><strong>SGL&nbsp;Room</strong></div></td>
				<td width="6%" align="left" ><div align="center"><strong>DBL&nbsp;Room</strong></div></td>
				<!-- <td width="6%" align="left" ><div align="center"><strong>TPL&nbsp;Room</strong></div></td> -->
				<td width="5%" align="left" ><div align="center"><strong>Hotel</strong></div></td>
				<td width="5%" align="left" ><div align="center"><strong>Guide</strong></div></td>
				<td width="5%" align="left" ><div align="center"><strong>Activity</strong></div></td>
				<td width="5%" align="left" ><div align="center"><strong>Entrance</strong></div></td>
				<td width="5%" align="left" ><div align="center"><strong>Transfer</strong></div></td>
				<td width="5%" align="left" ><div align="center"><strong>Train</strong></div></td>
				<td width="5%" align="left" ><div align="center"><strong>Flight</strong></div></td>
				<td width="5%" align="left" ><div align="center"><strong>Restaurant</strong></div></td>
				<td width="5%" align="left" ><div align="center"><strong>Other</strong></div></td>   
				<td width="5%" align="left" ><div align="center"><strong>Action</strong></div></td>   
			  </tr>
				<?php 
				$focQFE='';
 				$focQFE=GetPageRecord('*','quotationFOCRates','1 and quotationId="'.$resListing1['quotationId'].'" and focType="FE" and slabId = "'.$resListing1['id'].'" order by id asc');
				while($focDataFE=mysqli_fetch_array($focQFE)){ 
				?>
			    <tr>
				<td width="5%"  align="left" ><div align="center">
				<input type="text" class="markInput digit_only" id="sglNORoom<?php echo $focDataFE['id']; ?>" value="<?php echo $focDataFE['sglNORoom']; ?>"/>
				</div></td>
				<td width="5%"  align="left" ><div align="center">
				<input type="text" class="markInput digit_only" id="dblNORoom<?php echo $focDataFE['id']; ?>" value="<?php echo $focDataFE['dblNORoom']; ?>"/>
				</div></td>
				<!-- Code removed from here! -->

				<td width="5%"  align="left" >
			     <div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
				<select id="hotelCalType<?php echo $focDataFE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
				<option value="1" <?php if($focDataFE['hotelCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
				<option value="2" <?php if($focDataFE['hotelCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
				</select>		
				  <input type="text" class="markInput digit_only" id="hotelCost<?php echo $focDataFE['id']; ?>" value="<?php echo $focDataFE['hotelCost']; ?>"/>
				  </div></td>
				  
				  <td width="5%"  align="left" >
                <div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
				<select id="guideCalType<?php echo $focDataFE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
				<option value="1" <?php if($focDataFE['guideCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
				<option value="2" <?php if($focDataFE['guideCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
				</select>				  	
				  <input type="text" class="markInput digit_only" id="guideCost<?php echo $focDataFE['id']; ?>" value="<?php echo $focDataFE['guideCost']; ?>"/>
				  </div></td>
				  
				   <td width="5%"  align="left" >
				   <div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
				<select id="activityCalType<?php echo $focDataFE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
				<option value="1" <?php if($focDataFE['activityCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
				<option value="2" <?php if($focDataFE['activityCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
				</select>	
				  <input type="text" class="markInput digit_only" id="activityCost<?php echo $focDataFE['id']; ?>" value="<?php echo $focDataFE['activityCost']; ?>"/>
				  </div></td>
				  
				   <td width="5%"  align="left" >
				   	<div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
				<select id="entranceCalType<?php echo $focDataFE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
				<option value="1" <?php if($focDataFE['entranceCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
				<option value="2" <?php if($focDataFE['entranceCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
				</select>
				  <input type="text" class="markInput digit_only" id="entranceCost<?php echo $focDataFE['id']; ?>" value="<?php echo $focDataFE['entranceCost']; ?>"/>
				  </div></td>
				   
					<td width="5%"  align="left" >
				<div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
				<select id="transferCalType<?php echo $focDataFE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px; margin: auto;"> 
				<option value="1" <?php if($focDataFE['transferCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
				<option value="2" <?php if($focDataFE['transferCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
				</select>
				  <input type="text" class="markInput digit_only" id="transferCost<?php echo $focDataFE['id']; ?>" value="<?php echo $focDataFE['transferCost']; ?>"/>
				  </div></td>
				  
					<td width="5%"  align="left" >
						<div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
				<select id="trainCalType<?php echo $focDataFE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
				<option value="1" <?php if($focDataFE['trainCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
				<option value="2" <?php if($focDataFE['trainCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
				</select>
				  <input type="text" class="markInput digit_only" id="trainCost<?php echo $focDataFE['id']; ?>" value="<?php echo $focDataFE['trainCost']; ?>"/>
				  </div></td>
				  
				   <td width="5%"  align="left" >
				   	<div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
				<select id="flightCalType<?php echo $focDataFE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
				<option value="1" <?php if($focDataFE['flightCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
				<option value="2" <?php if($focDataFE['flightCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
				</select>
				  <input type="text" class="markInput digit_only" id="flightCost<?php echo $focDataFE['id']; ?>" value="<?php echo $focDataFE['flightCost']; ?>"/>
				  </div></td>
				  
					<td width="5%"  align="left" >
						<div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
				<select id="restaurantCalType<?php echo $focDataFE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
				<option value="1" <?php if($focDataFE['restaurantCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
				<option value="2" <?php if($focDataFE['restaurantCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
				</select>
				  <input type="text" class="markInput digit_only" id="restaurantCost<?php echo $focDataFE['id']; ?>" value="<?php echo $focDataFE['restaurantCost']; ?>"/>
				  </div></td>
				  
				  <td width="5%"  align="left" >
				  	<div align="center" style="display: grid;grid-template-columns: auto;grid-gap: 5px">
				<select id="otherCalType<?php echo $focDataFE['id']; ?>" class="gridfield" style="padding: 6px 10px;max-width: 62px;background-color: #fff;border-radius: 2px;margin: auto;"> 
				<option value="1" <?php if($focDataFE['otherCalType'] == 1){ ?> selected="selected" <?php } ?>>%</option> 
				<option value="2" <?php if($focDataFE['otherCalType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
				</select>
				  <input type="text" class="markInput digit_only" id="otherCost<?php echo $focDataFE['id']; ?>" value="<?php echo $focDataFE['otherCost']; ?>"/>
 				  </div></td> 
				  <td width="5%"  align="left" ><div onclick="saveescortdata(<?php echo $focDataFE['id']; ?>,<?php echo $resListing1['id']; ?>);" style="background-color: #4285f4;padding: 6px 10px;color: #fff;border-radius: 4px;width: 50px;text-align: center;cursor: pointer;">Save</div>
				  <input type="hidden" class="markInput digit_only" id="focType<?php echo $focDataFE['id']; ?>" value="<?php echo $focDataFE['focType']; ?>"/></td> 					  
			   </tr> 
			    <?php } ?>
				</table>
				<?php
				} 
			} ?> 
		</div>
		</td>
		</tr>
		<?php } ?>
		<tr>
		<td colspan="9">
			<div   id="loadfocCostBox"  style="display:none;"></div>
		</td>
		</tr>
		<!--foc cost block end-->
		
		<?php 
	} ?> 
	<script>
		function saveescortdata(focId,slabId){ 
			var sglNORoom =$('#sglNORoom'+focId).val(); 
			var dblNORoom =$('#dblNORoom'+focId).val(); 
			var tplNORoom =$('#tplNORoom'+focId).val(); 
			var focType =$('#focType'+focId).val();
			
			var hotelCost =$('#hotelCost'+focId).val();
			var guideCost =$('#guideCost'+focId).val();
			var activityCost =$('#activityCost'+focId).val();
			var entranceCost =$('#entranceCost'+focId).val();
			var transferCost =$('#transferCost'+focId).val();
			var ferryCost =$('#ferryCost'+focId).val();
			var trainCost =$('#trainCost'+focId).val();
			var flightCost =$('#flightCost'+focId).val();
			var restaurantCost =$('#restaurantCost'+focId).val();
			var otherCost =$('#otherCost'+focId).val();
			var hotelCalType =$('#hotelCalType'+focId).val();
			var guideCalType =$('#guideCalType'+focId).val();
			var activityCalType =$('#activityCalType'+focId).val();
			var entranceCalType =$('#entranceCalType'+focId).val();
			var transferCalType =$('#transferCalType'+focId).val();
			var ferryCalType =$('#ferryCalType'+focId).val();
			var trainCalType =$('#trainCalType'+focId).val();
			var flightCalType =$('#flightCalType'+focId).val();
			var restaurantCalType =$('#restaurantCalType'+focId).val();
			var otherCalType =$('#otherCalType'+focId).val();
			
			$('#loadfocCostBox').load('loadpaxslab.php?action=saveescortdata&id='+focId+'&slabId='+slabId+'&quotationId=<?php echo encode($quotationId); ?>&sglNORoom='+sglNORoom+'&dblNORoom='+dblNORoom+'&tplNORoom='+tplNORoom+'&focType='+focType+'&hotelCost='+hotelCost+'&guideCost='+guideCost+'&activityCost='+activityCost+'&entranceCost='+entranceCost+'&transferCost='+transferCost+'&trainCost='+trainCost+'&flightCost='+flightCost+'&restaurantCost='+restaurantCost+'&otherCost='+otherCost+'&hotelCalType='+hotelCalType+'&guideCalType='+guideCalType+'&activityCalType='+activityCalType+'&entranceCalType='+entranceCalType+'&transferCalType='+transferCalType+'&trainCalType='+trainCalType+'&flightCalType='+flightCalType+'&restaurantCalType='+restaurantCalType+'&otherCalType='+otherCalType); 			
		} 

		function closeEscortData(slabId){
		$('#focCostBox'+slabId).hide();
		}
		 
		function addmarkfunescort(slabId,tmpEscort){
			if($('#localEscort'+slabId).val() > 0 || $('#foreignEscort'+slabId).val() > 0 ){
				if(tmpEscort ==  0){
					var fromRange = encodeURI($('#fromRange'+slabId+'').val()); 
					var toRange = encodeURI($('#toRange'+slabId+'').val()); 
					var dividingFactor = encodeURI($('#dividingFactor'+slabId+'').val());  
					var localEscort = encodeURI($('#localEscort'+slabId+'').val()); 
	 				var foreignEscort = encodeURI($('#foreignEscort'+slabId+'').val()); 
					var status = encodeURI($('#status'+slabId+'').val());
					
					// pax slab block
					var adult = encodeURI($('#adult'+slabId).val());
					var child = encodeURI($('#child'+slabId).val());
					var infant = encodeURI($('#infant'+slabId).val());

					var sglRoom = encodeURI($('#sglRoom'+slabId).val());
					var dblRoom = encodeURI($('#dblRoom'+slabId).val());
					var twinRoom = encodeURI($('#twinRoom'+slabId).val());
					var tplRoom = encodeURI($('#tplRoom'+slabId).val());
					var quadNoofRoom = encodeURI($('#quadNoofRoom'+slabId).val());
					var sixNoofBedRoom = encodeURI($('#sixNoofBedRoom'+slabId).val());
					var eightNoofBedRoom = encodeURI($('#eightNoofBedRoom'+slabId).val());
					var tenNoofBedRoom = encodeURI($('#tenNoofBedRoom'+slabId).val());
					var teenNoofRoom = encodeURI($('#teenNoofRoom'+slabId).val());
					var extraNoofBed = encodeURI($('#extraNoofBed'+slabId).val());
					var childwithNoofBed = encodeURI($('#childwithNoofBed'+slabId).val());
					var childwithoutNoofBed = encodeURI($('#childwithoutNoofBed'+slabId).val());

					$('#loadfocCostBox').load('loadpaxslab.php?action=savetotalpaxslab&id='+slabId+'&quotationId=<?php echo encode($quotationId); ?>&fromRange='+fromRange+'&toRange='+toRange+'&dividingFactor='+dividingFactor+'&localEscort='+localEscort+'&foreignEscort='+foreignEscort+'&adult='+adult+'&child='+child+'&infant='+infant+'&sglRoom='+sglRoom+'&dblRoom='+dblRoom+'&twinRoom='+twinRoom+'&tplRoom='+tplRoom+'&quadNoofRoom='+quadNoofRoom+'&sixNoofBedRoom='+sixNoofBedRoom+'&eightNoofBedRoom='+eightNoofBedRoom+'&tenNoofBedRoom='+tenNoofBedRoom+'&teenNoofRoom='+teenNoofRoom+'&extraNoofBed='+extraNoofBed+'&childwithNoofBed='+childwithNoofBed+'&childwithoutNoofBed='+childwithoutNoofBed+'&msgShow=1'); 
				}else{
					setTimeout(function(){
						var className = $('#iconchekescort'+slabId).attr('class');
						if(className === 'fa fa-plus'){
							$("#iconchekescort"+slabId).removeClass("fa fa-plus");
							$("#iconchekescort"+slabId).addClass('fa fa-minus');
							$("#iconchekescortLable"+slabId).text(' Close Escort Rates'); 

							$('#focCostBox'+slabId).show();
						}
						if(className === 'fa fa-minus'){
							$("#iconchekescort"+slabId).removeClass("fa fa-minus");
							$("#iconchekescort"+slabId).addClass('fa fa-plus');
							$("#iconchekescortLable"+slabId).text(' Open Escort Rates'); 
							$('#focCostBox'+slabId).hide();
						} 
					}, 500);
				}
			}else{
				alert('Number of Escort should be greater than zero.');
				$('#localEscort'+slabId).focus();
				
			}
		} 
		<?php if($tmpEscort == 1){
		?>
		// addmarkfunescort(<?php echo $resListing1['id']; ?>,1);
		<?php
		}
		?>
		function savetotalpaxslab(slabId){ 
			var fromRange = encodeURI($('#fromRange'+slabId).val()); 
			var toRange = encodeURI($('#toRange'+slabId).val()); 
			var dividingFactor = encodeURI($('#dividingFactor'+slabId).val());  
			var DF_SGL = encodeURI($('#DF_SGL'+slabId).val()); 
			var DF_DBL = encodeURI($('#DF_DBL'+slabId).val()); 
			var DF_TWN = encodeURI($('#DF_TWN'+slabId).val()); 
			var DF_TPL = encodeURI($('#DF_TPL'+slabId).val()); 
			var DF_QUAD = encodeURI($('#DF_QUAD'+slabId).val()); 
			var DF_SIX = encodeURI($('#DF_SIX'+slabId).val()); 
			var DF_EIGHT = encodeURI($('#DF_EIGHT'+slabId).val()); 
			var DF_TEN = encodeURI($('#DF_TEN'+slabId).val()); 
			var DF_ABED = encodeURI($('#DF_ABED'+slabId).val()); 
			var DF_CBED = encodeURI($('#DF_CBED'+slabId).val()); 
			var DF_INF = encodeURI($('#DF_INF'+slabId).val()); 
			var discount_INF = encodeURI($('#discount_INF'+slabId).val()); 

			// pax slab block
			var adult = encodeURI($('#adult'+slabId).val());
			var child = encodeURI($('#child'+slabId).val());
			var infant = encodeURI($('#infant'+slabId).val());

			var sglRoom = encodeURI($('#sglRoom'+slabId).val());
			var dblRoom = encodeURI($('#dblRoom'+slabId).val());
			var twinRoom = encodeURI($('#twinRoom'+slabId).val());
			var tplRoom = encodeURI($('#tplRoom'+slabId).val());
			var quadNoofRoom = encodeURI($('#quadNoofRoom'+slabId).val());
			var sixNoofBedRoom = encodeURI($('#sixNoofBedRoom'+slabId).val());
			var eightNoofBedRoom = encodeURI($('#eightNoofBedRoom'+slabId).val());
			var tenNoofBedRoom = encodeURI($('#tenNoofBedRoom'+slabId).val());
			var teenNoofRoom = encodeURI($('#teenNoofRoom'+slabId).val());
			var extraNoofBed = encodeURI($('#extraNoofBed'+slabId).val());
			var childwithNoofBed = encodeURI($('#childwithNoofBed'+slabId).val());
			var childwithoutNoofBed = encodeURI($('#childwithoutNoofBed'+slabId).val());

			var localEscort = encodeURI($('#localEscort'+slabId).val()); 
			var foreignEscort = encodeURI($('#foreignEscort'+slabId).val()); 
			var status = encodeURI($('#status'+slabId).val());
			var checked = $('#checkFinal'+slabId).is(":checked");

			if(checked){
				$('#selectpaxslab').text('( Min Pax: '+fromRange+' | Max pax: '+toRange+' )');	
			}

			$('#loadfocCostBox').load('loadpaxslab.php?action=savetotalpaxslab&id='+slabId+'&quotationId=<?php echo encode($quotationData['id']); ?>&fromRange='+fromRange+'&toRange='+toRange+'&dividingFactor='+dividingFactor+'&DF_SGL='+DF_SGL+'&DF_DBL='+DF_DBL+'&DF_TWN='+DF_TWN+'&DF_TPL='+DF_TPL+'&DF_QUAD='+DF_QUAD+'&DF_SIX='+DF_SIX+'&DF_EIGHT='+DF_EIGHT+'&DF_TEN='+DF_TEN+'&DF_ABED='+DF_ABED+'&DF_CBED='+DF_CBED+'&DF_INF='+DF_INF+'&discount_INF='+discount_INF+'&localEscort='+localEscort+'&foreignEscort='+foreignEscort+'&status='+status+'&adult='+adult+'&child='+child+'&infant='+infant+'&sglRoom='+sglRoom+'&dblRoom='+dblRoom+'&twinRoom='+twinRoom+'&tplRoom='+tplRoom+'&quadNoofRoom='+quadNoofRoom+'&sixNoofBedRoom='+sixNoofBedRoom+'&eightNoofBedRoom='+eightNoofBedRoom+'&tenNoofBedRoom='+tenNoofBedRoom+'&teenNoofRoom='+teenNoofRoom+'&extraNoofBed='+extraNoofBed+'&childwithNoofBed='+childwithNoofBed+'&childwithoutNoofBed='+childwithoutNoofBed);

		} 
	</script>
	<?php 
	$paxSlabDataq="";  
	$paxSlabDataq=GetPageRecord('*','totalPaxSlab',' 1 and ( fromRange BETWEEN "'.$pax.'" and "'.$pax.'" OR "'.$pax.'" BETWEEN fromRange and toRange ) and quotationId="'.$quotationId.'"'); 
	if(mysqli_num_rows($paxSlabDataq) == 0 ){
		?>
		<script> 
		// alert('Please make a pax slab according to query pax.'); 
		</script>
		<?php 
	}
	if($sNo2==0){ ?>
		<tr style="padding:8px;text-align: center; width: 100%;background-color: #fafafa;">
		  <td colspan="50"><div align="center">No Pax Slabs Found.</div></td>
		</tr>
		<?php 
	} 
}
?>
