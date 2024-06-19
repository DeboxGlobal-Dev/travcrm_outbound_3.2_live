<?php 
include "inc.php";  
function dateDiffInDays($date1, $date2){ 
	// Calulating the difference in timestamps 
	$diff = strtotime($date2) - strtotime($date1); 
	// 1 day = 24 hours 
	// 24 * 60 * 60 = 86400 seconds 
	return abs(round($diff / 86400)); 
}

$rs2=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_GET['id']).'" '); 
$quotationData=mysqli_fetch_array($rs2); 
$quotword = ($quotationData['status'] == 1)? "Itinerary" : "Proposal"; // itinerary proposal
$rs3=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'" '); 
$queryData=mysqli_fetch_array($rs3); 


$quotationId = $quotationData['id'];
$queryId = $quotationData['queryId'];
$queryTypeId = $quotationData['queryType'];
$gitQuo = $queryData['paxType'];
if(strlen(trim($quotationData['quotationSubject'])) < 1 ){
	$quotationSubject = $queryData['subject'];
}else{
	$quotationSubject = $quotationData['quotationSubject'];
}

$quotPreviewId = makeQueryId($queryData['id']).'-'.$quotationData['quotationNo'];

$rsn=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' deletestatus=0 and country!=0 and status=1 and setDefault= 1'); 
$resListingnn=mysqli_fetch_array($rsn);
if($resListingnn['id'] == '' || $resListingnn['id'] == 0){
	$defaultCurr = 1;
	$roe = 1;
}else{
	$roe = $resListingnn['currencyValue'];
	$currencyName = $resListingnn['name'];
	$defaultCurr = $resListingnn['id'];
}
if($quotationData['currencyId'] == '' && $quotationData['currencyId'] == 0 ){
	$newCurr = $defaultCurr;
}else{
	$newCurr = $quotationData['currencyId'];
}

$rscs=GetPageRecord('*','companySettingsMaster','companyName!=""');  
$companyresult=mysqli_fetch_array($rscs);
if(!empty($companyresult)){
  $rsfs=GetPageRecord('*','componyFinanceSetting','companySettingId="'.$companyresult['id'].'"');  
  $financeresult=mysqli_fetch_array($rsfs);	
}

?>
<style type="text/css">

.style1 {font-weight: bold}

</style>  
<div id="loadallDays"></div>
<script> 
function loadquotationmainfile(){
$('#loadallDays').load('loadProposalDays.php?id=<?php echo $_GET['id']; ?>');
}

function dragDropfun(id){
	$("#stbl"+id+" tbody").sortable({
		handle: '.editButton',
		stop: function( event, ui ) { 
			var obj={};
			var len=$("#stbl"+id+" tbody > div").length;
			for(var i=0;i<len;i++){
				obj[i]=$("#stbl"+id+" tbody > div").eq(i).find('li').attr('id');
			}
			 $('#addeditquery'+id+'').submit();
		}
	});
	
}

</script>

<?php 
$resM1 = GetPageRecord('*','moduleMaster','moduleName!="" and url="visacostmaster" and disableStatus="1"');
$num1 = mysqli_num_rows($resM1);

$resM2 = GetPageRecord('*','moduleMaster','moduleName!="" and url="insurancecostmaster" and disableStatus="1"');
$num2 = mysqli_num_rows($resM2);
$resM3 = GetPageRecord('*','moduleMaster','moduleName!="" and url="passportCostMaster" and disableStatus="1"');
$num3 = mysqli_num_rows($resM3);
if($quotationData['calculationType']==3 || $num3==0 || $num2==0 || $num1==0 || $queryTypeId==13 || $quotationData['isPackage']==1){
	// echo $quotationData['flightRequired'];
	if($quotationData['isPackage']==1 || ($quotationData['insuranceRequired']==1 || $quotationData['insuranceRequired']==2) || $quotationData['calculationType']==3 || $quotationData['visaRequired']==1 || $quotationData['visaRequired']==2 || ($queryTypeId==13 && $quotationData['flightRequired']==2 || $quotationData['flightRequired']==1 || $quotationData['trainRequired']==1 || $quotationData['trainRequired']==2 || $quotationData['transferRequired']==1 || $quotationData['transferRequired']==2)){ 		?>
	<div style="border-bottom: 1px solid #ccc;background-color:#FFFFFF;margin-bottom: 0;position:relative;" >
	<div style="background-color: #fafafa; padding: 10px; color: #000; font-weight: 500; cursor: pointer; font-size: 14px; overflow:hidden; border-bottom: 1px solid #ddd;">Value Added Services
		<div>
			<?php if($quotationData['calculationType']==3 || ($queryTypeId==13 && ($quotationData['flightRequired']==1 || $quotationData['flightRequired']==2))){ ?>
			<span ><input type="checkbox" name="flightRequired" id="flightRequired" onchange="needValueAddedServices('flightRequirementAct');" value="<?php echo $quotationData['flightRequired']; ?>" <?php if($quotationData['flightRequired']==2){ ?> checked="checked" <?php } ?> style="display: inline-block;cursor:pointer;">&nbsp;Flight&nbsp;&nbsp;&nbsp;</span>

			<?php } if(($queryTypeId==13 && ($quotationData['trainRequired']==1 || $quotationData['trainRequired']==2))){ ?>
			<span ><input type="checkbox" name="trainRequired" id="trainRequired" onchange="needValueAddedServices('trainRequirementAct');" value="<?php echo $quotationData['trainRequired']; ?>" <?php if($quotationData['trainRequired']==2){ ?> checked="checked" <?php } ?> style="display: inline-block;cursor:pointer;">&nbsp;Train&nbsp;&nbsp;&nbsp;</span>

			<?php } if(($queryTypeId==13 && ($quotationData['transferRequired']==1 || $quotationData['transferRequired']==2))){ ?>
			<span ><input type="checkbox" name="transferRequired" id="transferRequired" onchange="needValueAddedServices('transferRequirementAct');" value="<?php echo $quotationData['transferRequired']; ?>" <?php if($quotationData['transferRequired']==2){ ?> checked="checked" <?php } ?> style="display: inline-block;cursor:pointer;">&nbsp;Transfer&nbsp;&nbsp;&nbsp;</span>

			<?php } if($quotationData['calculationType']==3 || $quotationData['isPackage']==1 || $quotationData['visaRequired']==1 || $quotationData['visaRequired']==2){ ?>
			<span <?php echo isHideMster('visacostmaster'); ?>><input type="checkbox" name="visaRequired" id="visaRequired" onchange="needValueAddedServices('visaRequirementAct');" value="<?php echo $quotationData['visaRequired']; ?>" <?php if($quotationData['visaRequired']==2){ ?> checked="checked" <?php } ?> style="display: inline-block;cursor:pointer;">&nbsp;VISA&nbsp;&nbsp;&nbsp;</span>
			
			<?php } if($quotationData['passportRequired']==1 || $quotationData['passportRequired']==2){ ?>
			<span <?php echo isHideMster('passportCostMaster'); ?>><input type="checkbox"  name="passportRequired" id="passportRequired" onchange="needValueAddedServices('passportRequirementAct');" value="<?php echo $quotationData['passportRequired']; ?>" <?php if($quotationData['passportRequired']==2){ ?> checked="checked" <?php } ?> style="display: inline-block;cursor:pointer;">&nbsp;Passport&nbsp;&nbsp;&nbsp;</span>
			
			<?php } if($quotationData['calculationType']==3 || $quotationData['isPackage']==1 || $quotationData['insuranceRequired']==1 || $quotationData['insuranceRequired']==2){ ?>
			<span <?php echo isHideMster('insurancecostmaster'); ?>><input type="checkbox" name="insuranceRequired" id="insuranceRequired" onchange="needValueAddedServices('insuranceRequirementAct');" value="<?php echo $quotationData['insuranceRequired']; ?>" <?php if($quotationData['insuranceRequired']==2){ ?> checked="checked" <?php } ?> style="display: inline-block;cursor:pointer;">&nbsp;Insurance&nbsp;&nbsp;&nbsp;</span>
			
			<?php } if($quotationData['forexRequired']==1 || $quotationData['forexRequired']==2){ ?>
			<input type="checkbox" name="forexRequired" id="forexRequired" value="<?php echo $quotationData['forexRequired']; ?>" onchange="needValueAddedServices('forexRequirementAct');" <?php if($quotationData['forexRequired']==2){ ?> checked="checked" <?php } ?> style="display: inline-block;cursor:pointer;">&nbsp;Forex
			<?php } ?>
		</div>
	</div>
	
	<!-- load action divs -->
	<div id="loadValueAddedServices4"></div>
	<div id="loadValueAddedServices5"></div>
	<div id="loadValueAddedServices6"></div>
	<div id="loadValueAddedServices1"></div>
	<div id="loadValueAddedServices2"></div>
	<div id="loadValueAddedServices3"></div>
		
	<!-- delete action div  -->
	<div id="deletepassportrate1"></div>
	<div id="deletevisarate2"></div>
	<div id="deleteinsrate3"></div>
	<div id="deleteflightrate4"></div>
	<div id="deletetrainrate4"></div>
	<div id="deletetransferrate4"></div>
  	
	<script>
		function needValueAddedServices(action){
			var flightRequired = 0;
			var visaRequired = 0;
			var insuranceRequired = 0;
			var forexRequired = 0;
			var passportRequired = 0;
			if(action=="flightRequirementAct"){

				if($("#flightRequired").is(':checked')){
					flightRequired = 2;
				}else{
					flightRequired = 1;
				}

				// if(flightRequired==2){
				// 	document.querySelectorAll("#flightCostInclude")[0].classList.add("flightCostIncludeClass");
				// 	document.querySelectorAll("#flightCostInclude")[0].classList.remove("flightCostIncludeClass2");
				// 	document.querySelectorAll("#flightCostInclude")[1].classList.add("flightCostIncludeClass");
				// 	document.querySelectorAll("#flightCostInclude")[1].classList.remove("flightCostIncludeClass2");
				// }
				// if(flightRequired==1){
				// 	document.querySelectorAll("#flightCostInclude")[0].classList.remove("flightCostIncludeClass");
				// 	document.querySelectorAll("#flightCostInclude")[0].classList.add("flightCostIncludeClass2");
				// 	document.querySelectorAll("#flightCostInclude")[1].classList.remove("flightCostIncludeClass");
				// 	document.querySelectorAll("#flightCostInclude")[1].classList.add("flightCostIncludeClass2");
				// }

				$('#loadValueAddedServices4').load('loadAddtionalData.php?action='+action+'&flightRequired='+flightRequired+'&quotationId=<?php echo $quotationData['id']; ?>&queryId=<?php echo $quotationData['queryId']; ?>');
			}

			if(action=="trainRequirementAct"){

			if($("#trainRequired").is(':checked')){
				trainRequired = 2;
			}else{
				trainRequired = 1;
			}


			$('#loadValueAddedServices5').load('loadAddtionalData.php?action='+action+'&trainRequired='+trainRequired+'&quotationId=<?php echo $quotationData['id']; ?>&queryId=<?php echo $quotationData['queryId']; ?>');
			}

			if(action=="transferRequirementAct"){

			if($("#transferRequired").is(':checked')){
				transferRequired = 2;
			}else{
				transferRequired = 1;
			}


			$('#loadValueAddedServices6').load('loadAddtionalData.php?action='+action+'&transferRequired='+transferRequired+'&quotationId=<?php echo $quotationData['id']; ?>&queryId=<?php echo $quotationData['queryId']; ?>');
			}

			if(action=="visaRequirementAct"){
				if($("#visaRequired").is(':checked')){
					visaRequired = 2;
				}else{
					visaRequired = 1;
				}

				if(visaRequired==2){
					document.querySelectorAll("#visaCostInclude")[0].classList.add("visaCostIncludeClass");
					document.querySelectorAll("#visaCostInclude")[0].classList.remove("visaCostIncludeClass2");
					document.querySelectorAll("#visaCostInclude")[1].classList.add("visaCostIncludeClass");
					document.querySelectorAll("#visaCostInclude")[1].classList.remove("visaCostIncludeClass2");
				}
				if(visaRequired==1){
					document.querySelectorAll("#visaCostInclude")[0].classList.remove("visaCostIncludeClass");
					document.querySelectorAll("#visaCostInclude")[0].classList.add("visaCostIncludeClass2");
					document.querySelectorAll("#visaCostInclude")[1].classList.remove("visaCostIncludeClass");
					document.querySelectorAll("#visaCostInclude")[1].classList.add("visaCostIncludeClass2");
				}

				$('#loadValueAddedServices1').load('loadAddtionalData.php?action='+action+'&visaRequired='+visaRequired+'&quotationId=<?php echo $quotationData['id']; ?>&queryId=<?php echo $quotationData['queryId']; ?>');
			}

			if(action=="passportRequirementAct"){
				if($("#passportRequired").is(':checked')){
					passportRequired = 2;
				}else{
					passportRequired = 1;
				}
				if(passportRequired==2){
					document.querySelectorAll("#passportCostInclude")[0].classList.add("passportCostIncludeClass");
					document.querySelectorAll("#passportCostInclude")[0].classList.remove("passportCostIncludeClass2");
					document.querySelectorAll("#passportCostInclude")[1].classList.add("passportCostIncludeClass");
					document.querySelectorAll("#passportCostInclude")[1].classList.remove("passportCostIncludeClass2");
				}

				if(passportRequired==1){
					document.querySelectorAll("#passportCostInclude")[0].classList.remove("passportCostIncludeClass");
					document.querySelectorAll("#passportCostInclude")[0].classList.add("passportCostIncludeClass2");
					document.querySelectorAll("#passportCostInclude")[1].classList.remove("passportCostIncludeClass");
					document.querySelectorAll("#passportCostInclude")[1].classList.add("passportCostIncludeClass2");
				}

				$('#loadValueAddedServices2').load('loadAddtionalData.php?action='+action+'&passportRequired='+passportRequired+'&quotationId=<?php echo $quotationData['id']; ?>&queryId=<?php echo $quotationData['queryId']; ?>');
			}

			if(action=="insuranceRequirementAct"){
				if($("#insuranceRequired").is(':checked')){
					insuranceRequired = 2;
				}else{
					insuranceRequired = 1;
				}

				if(insuranceRequired==2){
					document.querySelectorAll("#insuranceCostInclude")[0].classList.add("insuranceCostIncludeClass");
					document.querySelectorAll("#insuranceCostInclude")[0].classList.remove("insuranceCostIncludeClass2");
					document.querySelectorAll("#insuranceCostInclude")[1].classList.add("insuranceCostIncludeClass");
					document.querySelectorAll("#insuranceCostInclude")[1].classList.remove("insuranceCostIncludeClass2");
				}
				if(insuranceRequired==1){
					document.querySelectorAll("#insuranceCostInclude")[0].classList.remove("insuranceCostIncludeClass");
					document.querySelectorAll("#insuranceCostInclude")[0].classList.add("insuranceCostIncludeClass2");
					document.querySelectorAll("#insuranceCostInclude")[1].classList.remove("insuranceCostIncludeClass");
					document.querySelectorAll("#insuranceCostInclude")[1].classList.add("insuranceCostIncludeClass2");
				}
				$('#loadValueAddedServices3').load('loadAddtionalData.php?action='+action+'&insuranceRequired='+insuranceRequired+'&quotationId=<?php echo $quotationData['id']; ?>&queryId=<?php echo $quotationData['queryId']; ?>');
			  
			}

			if(action=="forexRequirementAct"){
				if($("#forexRequired").is(':checked')){
					forexRequired = 2;
				}else{
					forexRequired = 1;
				}
			}
		} 
	 	<?php 
	  if($quotationData['visaRequired']==2){ ?>
			needValueAddedServices('visaRequirementAct');
			<?php
	  }
	  if($quotationData['passportRequired']==2){ ?>
			needValueAddedServices('passportRequirementAct');
			<?php
	  }
	  if($quotationData['insuranceRequired']==2){ ?>
			needValueAddedServices('insuranceRequirementAct');
			<?php
	  }
	  if($quotationData['trainRequired']==2){ ?>
			needValueAddedServices('trainRequirementAct');
			<?php
	  }
	  if($quotationData['transferRequired']==2 ){ ?>
		needValueAddedServices('transferRequirementAct');
		<?php
  	 }
	  if($quotationData['flightRequired']==2){ ?>
			needValueAddedServices('flightRequirementAct');
			<?php
	  }
	  if($quotationData['forexRequired']==2){ ?>
			needValueAddedServices('forexRequirementAct');
		<?php
	  }
	 	?>
	 	// loadquotationmainfile();
	 	function editFlightQuotationCost(id,quotationId,action,rateAdded){
			$('#loadValueAddedServices4').load('loadAddtionalData.php?action='+action+'&rateId='+id+'&rateAdded='+rateAdded+'&quotationId='+quotationId);
	 	}
	 	function editVisaQuotationCost(id,quotationId,action,rateAdded){
			$('#loadValueAddedServices1').load('loadAddtionalData.php?action='+action+'&rateId='+id+'&rateAdded='+rateAdded+'&quotationId='+quotationId);
	 	}	 	
		function deletePassQuotationRate(rateId,quotationId,action,delId){
			if(rateId!=''){
				event.preventDefault()
				$('#deletepassportrate1').load('inboundpop.php?action='+action+'&quotationId='+quotationId+'&quoteRateId='+rateId+'&deleteId='+delId);
			}
		}
		function deleteVisaQuotationRate(rateId,quotationId,action,delId){
			if(rateId!=''){
				event.preventDefault()
				$('#deletevisarate2').load('inboundpop.php?action='+action+'&quotationId='+quotationId+'&quoteRateId='+rateId+'&deleteId='+delId);
			}
		}
		function deleteInsuranceQuotationRate(rateId,quotationId,action,delId){
			if(rateId!=''){
				event.preventDefault()
				$('#deleteinsrate3').load('inboundpop.php?action='+action+'&quotationId='+quotationId+'&quoteRateId='+rateId+'&deleteId='+delId);
			}
		}
		function deleteFlightQuotationRate(rateId,quotationId,action,delId){
			if(rateId!=''){
				event.preventDefault()
				$('#deleteflightrate4').load('inboundpop.php?action='+action+'&quotationId='+quotationId+'&quoteRateId='+rateId+'&deleteId='+delId);
				
			}
		}

		function deleteTrainQuotationRate(rateId,quotationId,action,delId){
			if(rateId!=''){
				event.preventDefault()
				$('#deletetrainrate4').load('inboundpop.php?action='+action+'&quotationId='+quotationId+'&quoteRateId='+rateId+'&deleteId='+delId);
				
			}
		}

		function deleteTransferQuotationRate(rateId,quotationId,action,delId){
			if(rateId!=''){
				event.preventDefault()
				$('#deletetransferrate4').load('inboundpop.php?action='+action+'&quotationId='+quotationId+'&quoteRateId='+rateId+'&deleteId='+delId);
				
			}
		}
	</script>
	</div>

		<style>
		.insuranceCostIncludeClass{
			display: inline-block !important;
			width: 11%;
		}
		.passportCostIncludeClass{
			display: inline-block !important;
			/* margin-right: 73px; */
			width: 11%;
		}
		.passportCostIncludeClass2{
			display: none !important;
			margin-right: 0px;
		}
		.visaCostIncludeClass{
			display: inline-block !important;
			/* margin-right: 73px; */
			width: 11%;
		}
		.visaCostIncludeClass2{
			display: none !important;
			margin-right: 0px;
		}
		.flightCostIncludeClass{
			display: inline-block !important;
			/* margin-right: 73px; */
			width: 11%;
		}
		.flightCostIncludeClass2{
			display: none !important;
			margin-right: 0px;
		}
		</style>
		<?php 
	}
}
?>

<?php if($queryData['travelType']=='1'){ ?>
<div style="border-bottom: 1px solid #ccc;background-color:#FFFFFF;margin-bottom: 0;position:relative;">
	<div style="background-color: #fafafa; padding: 10px; color: #000; font-weight: 500; cursor: pointer; font-size: 14px; overflow:hidden; border-bottom: 1px solid #ddd;" >
 		<div style="float:left;"> 
			<label>
			<input type="checkbox" name="isAddExp" id="isAddExp" <?php if($quotationData['isAddExp'] == 1){ ?> checked <?php } ?> style="display:inline-block;">&nbsp;Additional&nbsp;Experiences&nbsp;(Suppliment)</label>
		</div>
	</div>
	<div style="padding:10px; background-color:#FFFFFF; <?php if($quotationData['isAddExp'] != 1){ ?> display:none;<?php } ?>" id="tbbodyAddExp">
		<table border="0" cellpadding="6" cellspacing="0"  width="100%">
			<tr>
				<td width="25%" align="left"><div class="griddiv" style="position:static;">
					<label> <div>Select&nbsp;Destination</div>
						<select id="destAddWise" name="destAddWise" class="gridfield selectizeSupp" onChange="getdestAddWise();" autocomplete="off" style="width: 100%;">
						<option value="1">Selected Destination</option>
						<option value="2">All Destinations</option>
						</select>
					</label>
				
					</div>
				</td>
			  <td width="25%" >
					<div class="griddiv" style="position:static;">
							<label>
							<div>Destination </div>  
							<select id="supplimentDestinationId" name="supplimentDestinationId" class="gridfield " displayname="Select Destination" autocomplete="off" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;">  
							<?php  
							$rs=GetPageRecord('*',_DESTINATION_MASTER_,' id in ( select cityId from newQuotationDays where queryId="'.$quotationData['queryId'].'" group by cityId order by id asc ) order by id asc');  
							while($resListing=mysqli_fetch_array($rs)){   
							?>
							<option value="<?php echo $resListing['id']; ?>"><?php echo $resListing['name']; ?></option>
							<?php } ?>
							</select>
							</label> 
					</div>
				</td>

				<script>
						  function getdestAddWise(){
							if($('#destAddWise').val()==2){
								$('#supplimentDestinationId').load('loadAllAddDestinations.php');
							}

							if($('#destAddWise').val()==1){
								$('#supplimentDestinationId').load('loadAllAddDestinations.php?id=<?php echo $quotationData['queryId'] ?>');
							}

						  }
						  </script>
						  
			  <td width="25%" >
			  	<div class="griddiv" style="position:static;">
					<label> <div>Service Type</div>  
					<select id="supplimentServiceType" name="supplimentServiceType" class="gridfield " autocomplete="off" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" >	  
					<option value="1">Activity</option>		 							
					<option value="2">Guide</option>							
					<option value="3">Entrance</option>	 					
					</select> 
					</label> 
					</div>
				</td>    
				<td width="45%"> 
					<input type="button" value="Search" class="bluembutton" style="background-color: #75c38d !important; margin-left:0px; border: 1px #75c38d solid !important; margin-top:15px; margin-right:0px;"  onClick="searchServicefun();"/>
					<a id="clickFun2" style=" display:none;"></a>
					<div id="loadadditionalIdCost" style="display:none"></div>
				</td>
			</tr>
		</table>
		<div id="loadAddtionalData"></div>
		<script type="text/javascript">
			function loadAddtionalDatafun(){
			$('#loadAddtionalData').load('loadAddtionalData.php?action=additionalExperiences&quotationId=<?php echo $quotationData['id']; ?>');
			} 
			loadAddtionalDatafun(); 
			function searchServicefun(){
			var isAddExp = 0;
			if($("#isAddExp").is(':checked')){
			isAddExp = 1;
			}
			var supplimentDestinationId = $('#supplimentDestinationId').val();
			var supplimentServiceType = $('#supplimentServiceType').val();  
			var url = '&destinationId='+supplimentDestinationId+'&serviceType='+supplimentServiceType+'&quotationId=<?php echo $quotationData['id']; ?>&isAddExp='+isAddExp;  
			$('#clickFun2').attr('onclick', "openinboundpop('action=supplimentServiceType"+url+"','1000px');"); 
			$('#clickFun2').trigger('click'); 
			}
		</script>
	</div>
</div> 
<?php } ?>

	<div style="border-bottom: 1px solid #ccc;background-color:#FFFFFF;margin-bottom: 0;position:relative;">
		<div style="background-color: #fafafa; padding: 10px; color: #000; font-weight: 500; cursor: pointer; font-size: 14px; overflow:hidden; border-bottom: 1px solid #ddd;" >
			<!---->
			<div style="float:left;"> 
				<label>
				<input type="checkbox" name="isInc_exc" id="isInc_exc" <?php if($quotationData['isInc_exc'] == 1){ ?> checked <?php } ?> style="display:inline-block;" >
				Overview/&nbsp;Inc&Exc/&nbsp;T&C </label>
			</div>
		</div>
		<div style="padding:10px;background-color:#FFFFFF;<?php if($quotationData['isInc_exc'] != 1){ ?>display:none;<?php } ?>" id="tbbodyinc_exc"></div>
		<script type="text/javascript">
			//id="loadQuotationIncExc"
			function loadQuotationIncExc(){
				$('#tbbodyinc_exc').load('loadQuotationIncExc.php?quotationId=<?php echo $quotationData['id'];?>');
			}
			<?php if($quotationData['isInc_exc'] == 1){ ?>
			setTimeout(function(){ loadQuotationIncExc(); }, 1000);
			<?php } ?>
		</script>
	</div>

<div style="border-bottom: 1px solid #ccc;background-color:#FFFFFF;margin-bottom: 0;position:relative; display:none;">
	
	<div style="background-color: #fafafa; padding: 10px; color: #000; font-weight: 500; cursor: pointer; font-size: 14px; overflow:hidden; border-bottom: 1px solid #ddd;" >
 		<div style="float:left;"> 
			<label>
			<input type="checkbox" name="isOtherLocation" id="isOtherLocation" <?php if($quotationData['isOtherLocation'] == 1){ ?> checked <?php } ?> style="display:inline-block;"> Add other location cost?</label>
		</div>
	</div>

	<div style="padding:10px;background-color:#FFFFFF;<?php if($quotationData['isOtherLocation'] != 1){ ?>display:none;<?php } ?>" id="OtherLocationBox">
	 	<table border="0" cellpadding="6" cellspacing="0" width="100%"  >
	  <tr>
		<td colspan="2">Other&nbsp;Location<br />
		  <select id="otherLocation" name="otherLocation" class="gridfield validate" style="padding: 8px; border: 1px #ccc solid; width: 150px;"  >
				<?php  
				$destQuery=GetPageRecord('*',_DESTINATION_MASTER_,' deletestatus=0 and otherlocation = 1 order by name asc'); 
				while($destData=mysqli_fetch_array($destQuery)){  
					?><option value="<?php echo strip($destData['id']); ?>" <?php if($destData['id'] == $quotationData['otherLocation']){ ?>selected="selected" <?php } ?> ><?php echo strip($destData['name']); ?></option><?php 
				} ?>
		  </select>
		</td>
		<td width="86%" colspan="2">Cost<br />
			<input type="text" name="otherLocationCost" id="otherLocationCost" value="<?php echo $quotationData['otherLocationCost']; ?>" style="padding: 8px;border:1px #ccc solid;width:80px;padding-top: 7px;">		
		</td>
	  </tr>
  	</table>
	</div>
</div>

<div style="border-bottom: 1px solid #ccc;background-color:#FFFFFF;margin-bottom: 0;position:relative; display:none;">
	
	<div style="background-color: #fafafa; padding: 10px; color: #000; font-weight: 500; cursor: pointer; font-size: 14px; overflow:hidden; border-bottom: 1px solid #ddd;" >
 		<div style="float:left;"> 
			 <label>
			 <input type="checkbox" name="isSupp_TRR" id="isSupp_TRR" <?php if($quotationData['isSupp_TRR'] == 1){ ?> checked <?php } ?> style="display:inline-block;">Show Single Supplement / Triple Rate Reduction in Proposal</label>
		</div>
	</div>
</div>

<?php 
$foreinlocal = GetPageRecord('*','totalPaxSlab','quotationId="'.$quotationData['id'].'"');
$escortres = mysqli_fetch_assoc($foreinlocal);
if($escortres['localEscort']>0 || $escortres['foreignEscort']>0){ ?>
	<div  style="border-bottom: 1px solid #ccc; background-color:#FFFFFF; margin-bottom: 0; position:relative;">
		<div style="background-color: #fafafa; padding: 10px 16px; color: #000; font-weight: 500; cursor: pointer; font-size: 14px; overflow:hidden; border-bottom: 1px solid #ddd;" >
	 		<div style="float:left;"> 
				<label>FOC&nbsp;Cost&nbsp;Type</label>
				<label><input type="radio" name="costType" id="focCost" style="display:inline-block;" <?php if($quotationData['costType'] == 1){ echo 'checked'; }elseif($quotationData['costType'] != 2){ echo 'checked'; } ?>>&nbsp;Cost</label>
				<label><input type="radio" name="costType" id="focSale" style="display:inline-block;" <?php if($quotationData['costType'] == 2){ echo ' checked'; } ?>>&nbsp;Sale</label>
			</div>
		</div> 
	</div>
	<?php 
} ?>

<!-- start package wise cost div -->
<?php if($quotationData['calculationType']==2){ ?>
<div  style="border-bottom: 1px solid #ccc; background-color:#FFFFFF; margin-bottom: 0; position:relative;">
	<div style="background-color: #fafafa;padding: 10px 15px;color: #000;font-weight: 500;cursor: pointer;font-size: 14px; overflow:hidden;border-bottom: 1px solid #ccc;">
			<label>
 				<div style=" border-width: 7px 7px 6px 6px; border-color: #0075ff; border-style: solid; width: 0; height: 0; display: inline-block; float: left; border-radius: 2px; "></div>&nbsp;&nbsp;Package&nbsp;Wise&nbsp;Costing
			</label>
	</div>  
  <div  class="packageCostDiv " id="showmorefield4">
		<?php 
		$checkPackageRateQuery="";
		$checkPackageRateQuery=GetPageRecord('*','packageWiseRateMaster',' queryId="'.$queryId.'"');
		if(mysqli_num_rows($checkPackageRateQuery) > 0){
			$getPackageRateData=mysqli_fetch_array($checkPackageRateQuery); 
			$editId = $getPackageRateData['id'];

			$editsingleCost = clean($getPackageRateData['singleCost']);
			$editdoubleCost = clean($getPackageRateData['doubleCost']);
			$edittripleCost = clean($getPackageRateData['tripleCost']);
			$editquadCost = clean($getPackageRateData['quadCost']);
			$editsixBedCost = clean($getPackageRateData['sixBedCost']);
			$editeightBedCost = clean($getPackageRateData['eightBedCost']);
			$edittenBedCost = clean($getPackageRateData['tenBedCost']);
			$editextraBedACost = clean($getPackageRateData['extraBedACost']);
			$editchildwithbedCost = clean($getPackageRateData['childwithbedCost']);
			$editchildwithoutbedCost = clean($getPackageRateData['childwithoutbedCost']);

			$editguideACost = clean($getPackageRateData['guideA']);
			$editactivityACost = clean($getPackageRateData['activityA']);
			$editentranceACost = clean($getPackageRateData['entranceA']);
			$edittransferACost = clean($getPackageRateData['transferA']);
			$edittrainACost = clean($getPackageRateData['trainA']);
			$editflightACost = clean($getPackageRateData['flightA']);
			$editrestaurantACost = clean($getPackageRateData['restaurantA']);
			$editotherACost = clean($getPackageRateData['otherA']);

			$editguideCCost = clean($getPackageRateData['guideC']);
			$editactivityCCost = clean($getPackageRateData['activityC']);
			$editentranceCCost = clean($getPackageRateData['entranceC']);
			$edittransferCCost = clean($getPackageRateData['transferC']);
			$edittrainCCost = clean($getPackageRateData['trainC']);
			$editflightCCost = clean($getPackageRateData['flightC']);
			$editrestaurantCCost = clean($getPackageRateData['restaurantC']);
			$editotherCCost = clean($getPackageRateData['otherC']);

			$editsingleBasis = clean($getPackageRateData['singleBasis']);
			$editdoubleBasis = clean($getPackageRateData['doubleBasis']);
			$edittripleBasis = clean($getPackageRateData['tripleBasis']);
			$editquadBasis = clean($getPackageRateData['quadBasis']);
			$editsixBedBasis = clean($getPackageRateData['sixBedBasis']);
			$editeightBedBasis = clean($getPackageRateData['eightBedBasis']);
			$edittenBedBasis = clean($getPackageRateData['tenBedBasis']);
			$editextraBedABasis = clean($getPackageRateData['extraBedABasis']);
			$editchildwithbedBasis = clean($getPackageRateData['childwithbedBasis']);
			$editchildwithoutbedBasis = clean($getPackageRateData['childwithoutbedBasis']);
		}
		?>
		<div class="griddiv">
			<label>
				<div class="gridlable">Hotel Cost( Per Bed/Pax )</div>
				<table border="1" cellspacing="0" cellpadding="4" >
					<tr>
						<td>Single</td>
						<td>Double</td>
						<td>Triple</td>
						<td>Quad</td>
						<td>6&nbsp;Room&nbsp;Villa</td>
						<td>8&nbsp;Room&nbsp;Villa</td>
						<td>10&nbsp;Room&nbsp;Villa</td>
						<td>Extra&nbsp;Bed(A)</td>
						<td>Extra&nbsp;Bed(C)</td>
						<td>No&nbsp;Bed&nbsp;Child</td>
					</tr>
					<tr>
						<td><input type="number" name="singleCost" id="singleCost" value="<?php echo $editsingleCost; ?>"></td>
						<td><input type="number" name="doubleCost" id="doubleCost" value="<?php echo $editdoubleCost; ?>"></td>
						<td><input type="number" name="tripleCost" id="tripleCost" value="<?php echo $edittripleCost; ?>"></td>
						<td><input type="number" name="quadCost" id="quadCost" value="<?php echo $editquadCost; ?>"></td>
						<td><input type="number" name="sixBedCost" id="sixBedCost" value="<?php echo $editsixBedCost; ?>"></td>
						<td><input type="number" name="eightBedCost" id="eightBedCost" value="<?php echo $editeightBedCost; ?>"></td>
						<td><input type="number" name="tenBedCost" id="tenBedCost" value="<?php echo $edittenBedCost; ?>"></td>
						<td><input type="number" name="extraBedACost" id="extraBedACost" value="<?php echo $editextraBedACost; ?>"></td>
						<td><input type="number" name="childwithbedCost" id="childwithbedCost" value="<?php echo $editchildwithbedCost; ?>"></td>
						<td><input type="number" name="childwithoutbedCost" id="childwithoutbedCost" value="<?php echo $editchildwithoutbedCost; ?>"></td>
					</tr>
				</table>
			</label>
		</div>
		<div class="griddiv">
			<label>
				<div class="gridlable">Land Arrangement Price ( Per Person )</div>
				<table border="1" cellspacing="0" cellpadding="4">
					<tr>
						<td>Guide</td>
						<td>Activity</td>
						<td>Entrance</td>
						<td>Transfer</td>
						<td>Train</td>
						<td>Flight</td>
						<td>Restaurant</td>
						<td>Other</td>
					</tr>
					<tr>
						<td><input type="number" name="guideACost" id="guideACost" value="<?php echo $editguideACost; ?>"></td>
						<td><input type="number" name="activityACost" id="activityACost" value="<?php echo $editactivityACost; ?>"></td>
						<td><input type="number" name="entranceACost" id="entranceACost" value="<?php echo $editentranceACost; ?>"></td>
						<td><input type="number" name="transferACost" id="transferACost" value="<?php echo $edittransferACost; ?>"></td>
						<td><input type="number" name="trainACost" id="trainACost" value="<?php echo $edittrainACost; ?>"></td>
						<td><input type="number" name="flightACost" id="flightACost" value="<?php echo $editflightACost; ?>"></td>
						<td><input type="number" name="restaurantACost" id="restaurantACost" value="<?php echo $editrestaurantACost; ?>"></td>
						<td><input type="number" name="otherACost" id="otherACost" value="<?php echo $editotherACost; ?>"></td>
					</tr>
				</table>
			</label>
		</div>
		<div class="griddiv">
			<label>
				<div class="gridlable">Land Arrangement Price ( Per Child )</div>
				<table border="1" cellspacing="0" cellpadding="4">
					<tr>
						<td>Guide</td>
						<td>Activity</td>
						<td>Entrance</td>
						<td>Transfer</td>
						<td>Train</td>
						<td>Flight</td>
						<td>Restaurant</td>
						<td>Other</td>
					</tr>
					<tr>
						<td><input type="number" name="guideCCost" id="guideCCost" value="<?php echo $editguideCCost; ?>"></td>
						<td><input type="number" name="activityCCost" id="activityCCost" value="<?php echo $editactivityCCost; ?>"></td>
						<td><input type="number" name="entranceCCost" id="entranceCCost" value="<?php echo $editentranceCCost; ?>"></td>
						<td><input type="number" name="transferCCost" id="transferCCost" value="<?php echo $edittransferCCost; ?>"></td>
						<td><input type="number" name="trainCCost" id="trainCCost" value="<?php echo $edittrainCCost; ?>"></td>
						<td><input type="number" name="flightCCost" id="flightCCost" value="<?php echo $editflightCCost; ?>"></td>
						<td><input type="number" name="restaurantCCost" id="restaurantCCost" value="<?php echo $editrestaurantCCost; ?>"></td>
						<td><input type="number" name="otherCCost" id="otherCCost" value="<?php echo $editotherCCost; ?>"></td>
					</tr>
				</table>
			</label>
		</div>
		<div class="griddiv">
			<label>
				<input name="calcPPCostBtn" type="button" class="whitebutton " id="calcPPCostBtn" value=" Save & Calculate Per Person Basis " onclick="calcPPCost();">
			</label>
			<label id="showCalcPPCostMSG" class="alertMsg" >Data Saved !</label>
		</div>
		<div class="perPaxCostDiv">
			<div style="padding:10px;border-bottom: 1px #ccc solid;cursor:pointer;">QUOTATION PRICE ( PER PERSON BASIS ) </div>
			<div class="griddiv">
				<label  id="perPaxCostDiv" >
					<table width="100%" border="1" cellspacing="0" cellpadding="4">
						<tr>
							<th bgcolor="#ddd" >Single&nbsp;Basis</th>
							<th bgcolor="#ddd" >Double&nbsp;Basis</th>
							<th bgcolor="#ddd" >Triple&nbsp;Basis</th>
							<?php if(isRoomActive('quadroom')==true){ ?>
							<th bgcolor="#ddd" >Quad&nbsp;Basis</th>
							<?php } if(isRoomActive('sixbedroom')==true){ ?>
							<th bgcolor="#ddd" >SixBed&nbsp;Basis</th>
							<?php } if(isRoomActive('eightbedroom')==true){ ?>
							<th bgcolor="#ddd" >EightBed&nbsp;Basis</th>
							<?php } if(isRoomActive('tenbedroom')==true){ ?>
							<th bgcolor="#ddd" >TenBed&nbsp;Basis</th> 
							<?php } if(isRoomActive('teenbed')==true){ ?>
							<th bgcolor="#ddd" >TeenBed&nbsp;Basis</th> 
							<?php } ?>
							<th bgcolor="#ddd" >ExtraBed(A)</th>
							<th bgcolor="#ddd" >ExtraBed(C)</th> 
							<th bgcolor="#ddd" >Childwithoutbed</th>
							
						</tr>
						<tr>
							<td><input type="number" name="singleBasis" id="singleBasis" value="<?php echo $editsingleBasis; ?>"></td>
							<td><input type="number" name="doubleBasis" id="doubleBasis" value="<?php echo $editdoubleBasis; ?>"></td>
							<td><input type="number" name="tripleBasis" id="tripleBasis" value="<?php echo $edittripleBasis; ?>"></td>
							<?php if(isRoomActive('quadroom')==true){ ?>
							<td><input type="number" name="quadBasis" id="quadBasis" value="<?php echo $editquadBasis; ?>"></td>
							<?php } if(isRoomActive('sixbedroom')==true){ ?>
							<td><input type="number" name="sixBedBasis" id="sixBedBasis" value="<?php echo $editsixBedBasis; ?>"></td>
							<?php } if(isRoomActive('eightbedroom')==true){ ?>
							<td><input type="number" name="eightBedBasis" id="eightBedBasis" value="<?php echo $editeightBedBasis; ?>"></td>
							<?php } if(isRoomActive('tenbedroom')==true){ ?>
							<td><input type="number" name="tenBedBasis" id="tenBedBasis" value="<?php echo $edittenBedBasis; ?>"></td> 
							<?php } if(isRoomActive('teenbed')==true){ ?>
							<td><input type="number" name="teenBedBasis" id="teenBedBasis" value="<?php echo $editteenBedBasis; ?>"></td> 
							<?php } ?>
							<td><input type="number" name="extraBedABasis" id="extraBedABasis" value="<?php echo $editextraBedABasis; ?>"></td>

							<td><input type="number" name="childwithbedBasis" id="childwithbedBasis" value="<?php echo $editchildwithbedBasis; ?>"></td>

							<td><input type="number" name="childwithoutbedBasis" id="childwithoutbedBasis" value="<?php echo $editchildwithoutbedBasis; ?>"></td>
						</tr>
					</table> 
				</label>
			</div>
		</div> 
  	<script type="text/javascript">
  		function calcPPCost(){ 
  			var singleCost = $('#singleCost').val();
				var doubleCost = $('#doubleCost').val();
				var tripleCost = $('#tripleCost').val();
				
				var quadCost = $('#quadCost').val();
				var sixBedCost = $('#sixBedCost').val();
				var eightBedCost = $('#eightBedCost').val();
				var tenBedCost = $('#tenBedCost').val();
				var teenBedCost = $('#teenBedCost').val();

				var extraBedACost = $('#extraBedACost').val();
				var childwithbedCost = $('#childwithbedCost').val();
				var childwithoutbedCost = $('#childwithoutbedCost').val();
				var guideACost = $('#guideACost').val();
				var activityACost = $('#activityACost').val();
				var entranceACost = $('#entranceACost').val();
				var transferACost = $('#transferACost').val();
				var trainACost = $('#trainACost').val();
				var flightACost = $('#flightACost').val();
				var restaurantACost = $('#restaurantACost').val();
				var otherACost = $('#otherACost').val();
				var guideCCost = $('#guideCCost').val();
				var activityCCost = $('#activityCCost').val();
				var entranceCCost = $('#entranceCCost').val();
				var transferCCost = $('#transferCCost').val();
				var trainCCost = $('#trainCCost').val();
				var flightCCost = $('#flightCCost').val();
				var restaurantCCost = $('#restaurantCCost').val();
				var otherCCost = $('#otherCCost').val();

				$('#perPaxCostDiv').load('loadPackageWiseCost.php?action=calcPPCost&queryId=<?php echo encode($queryId); ?>&singleCost='+singleCost+'&doubleCost='+doubleCost+'&tripleCost='+tripleCost+'&quadCost='+quadCost+'&sixBedCost='+sixBedCost+'&eightBedCost='+eightBedCost+'&tenBedCost='+tenBedCost+'&teenBedCost='+teenBedCost+'&extraBedACost='+extraBedACost+'&childwithbedCost='+childwithbedCost+'&guideACost='+guideACost+'&activityACost='+activityACost+'&entranceACost='+entranceACost+'&transferACost='+transferACost+'&trainACost='+trainACost+'&flightACost='+flightACost+'&restaurantACost='+restaurantACost+'&otherACost='+otherACost+'&guideCCost='+guideCCost+'&activityCCost='+activityCCost+'&entranceCCost='+entranceCCost+'&transferCCost='+transferCCost+'&trainCCost='+trainCCost+'&flightCCost='+flightCCost+'&restaurantCCost='+restaurantCCost+'&otherCCost='+otherCCost);

				$('#showCalcPPCostMSG').show();
				setTimeout(function(){
					$('#showCalcPPCostMSG').hide();
				},1000)
  		}
  	</script>
	</div>
</div>
<?php } ?>

<!-- start complete package wise cost div -->
<?php if($quotationData['calculationType']==3){ ?>
<div  style="border-bottom: 1px solid #ccc; background-color:#FFFFFF; margin-bottom: 0; position:relative;">
	<div style="background-color: #fafafa;padding: 10px 15px;color: #000;font-weight: 500;cursor: pointer;font-size: 14px; overflow:hidden;border-bottom: 1px solid #ccc;">
			<label>
 				<div style=" border-width: 7px 7px 6px 6px; border-color: #0075ff; border-style: solid; width: 0; height: 0; display: inline-block; float: left; border-radius: 2px; "></div>&nbsp;&nbsp;Cost&nbsp;Type:-&nbsp;Complete&nbsp;Package&nbsp;Cost( Per Pax Basis )
			</label>
			<a target="_blank" onclick="alertspopupopen('action=sendSupplierQuotationRequest&quotationId=<?php echo ($quotationId); ?>','900px','auto');" class="sendbtn2">
				<span><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Send Supplier Quotation Request</span>
			</a>
			<style type="text/css">
				.sendbtn2{
					color: #ffffff!important;
					background-color: #233a49;
					padding: 2px 10px;
					border-radius: 3px;
					font-size: 14px;
					font-weight: 300;
				}
			</style>
	</div>  
  <div  class="packageCostDiv " id="showmorefield5">
	
		<div class="griddiv" style="display: inline-block;">
			<table border="1" cellspacing="0" cellpadding="4">
				<tr>	
				<th bgcolor="#ddd" >Supplier</th>
					<th bgcolor="#ddd" >Service&nbsp;Type</th>
					<th bgcolor="#ddd" >Service&nbsp;Name</th>
				
					<?php if($quotationData['quotationType']==2 || $quotationData['quotationType']==3){ ?>
					<th bgcolor="#ddd"><?php if($quotationData['quotationType']==2){ echo 'Package Category';}elseif($quotationData['quotationType']==3){ echo 'Package Category';} ?></th>
					<?php } ?>
					<th bgcolor="#ddd" >Markup&nbsp;Type</th>
					<th bgcolor="#ddd" >Value</th>
					<th bgcolor="#ddd" >Tax&nbsp;Slab</th>
					<th bgcolor="#ddd" >Currency</th>
					<th bgcolor="#ddd" >ROE</th>
					<th bgcolor="#ddd" class="additionalCost" style="display: none;">Cost&nbsp;Type</th>
				</tr>
				
					
					<tr>
					<td>
						<select name="supplierId" id="supplierId" class="packageCostDiv_selectbox">
							<option disabled value="">Select Supplier</option>
							<?php 
							$supplierQuery = GetPageRecord('id,name',_SUPPLIERS_MASTER_,' 1 and name!="" and deletestatus=0 and status=1 order by name asc');
							while($supplierData = mysqli_fetch_array($supplierQuery)){ ?>
							<option value="<?php echo $supplierData['id']; ?>"><?php echo $supplierData['name']; ?></option>
							<?php } ?>
						</select>
					</td>
					<td>
						<select name="serviceTypeID" id="serviceTypeID" onchange="showAdditionalCost();" class="packageCostDiv_selectbox">
							<option value="1">Land Package</option>
							<option value="2">Additional</option>
						</select>
					</td>
					
					<td><input type="text" name="serviceName" id="serviceName" value="" style="padding: 3px;"></td>
					<?php if($quotationData['quotationType']==2 || $quotationData['quotationType']==3){ ?>
					<td>
					<?php if($quotationData['quotationType']==2){ ?>
						<select name="hotelCategoryId" id="hotelCategoryId1" class="packageCostDiv_selectbox">
							<option value="">Select Category</option>
							<?php 
							$hotelCategory = explode(',',$quotationData['hotCategory']);
							foreach($hotelCategory as $val){
							$HQuery = GetPageRecord('id,hotelCategory',_HOTEL_CATEGORY_MASTER_,' 1 and deletestatus=0 and status=1 and id="'.$val.'" order by hotelCategory asc');
							$hotelCategoryData = mysqli_fetch_array($HQuery); ?>
							<option value="<?php echo $hotelCategoryData['id']; ?>" ><?php echo $hotelCategoryData['hotelCategory'].' Star'; ?></option>
							<?php } ?>
						</select>
						<?php } ?>

						<?php if($quotationData['quotationType']==3){ ?>
						<select name="hotelTypeId" id="hotelTypeId1" class="packageCostDiv_selectbox">
							<option value="">Select Category</option>
							<?php 
							$hotelType = explode(',',$quotationData['hotelType']);
							foreach($hotelType as $val2){
							$HQuery = GetPageRecord('id,name','hotelTypeMaster',' 1 and deletestatus=0 and status=1 and id="'.$val2.'" order by name asc');
							$hotelTypeData = mysqli_fetch_array($HQuery); ?>
							<option value="<?php echo $hotelTypeData['id']; ?>"><?php echo $hotelTypeData['name']; ?></option>
							<?php } ?>
						</select>
						<?php } ?>
					</td>
					<?php } ?>

					<td align="left"  >
						<select name="markupType" id="markupType" class="gridfield1 validate" style="padding: 6px !important;width: 70px !important;">
								<option value="1">%</option>
								<option value="2">Flat(PP)</option>
						</select>
					</td> 
	
					<td align="left"  >
						<input type="text" name="markupValue" id="markupValue" class="gridfield1" displayname="Processing Fee" style="width: 60px !important;">
					</td> 
					<td>
						<select id="serviceTaxId" name="serviceTaxId" class="gridfield" displayname="GST" autocomplete="off" style="padding: 6px !important;width:120px">
							<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Hotel" and status=1'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>"><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
					
					</td>

					<td>
						<select name="currencyId" id="currencyId" class="packageCostDiv_selectbox" onchange="getROE(this.value,'currencyIdVal');" style="width: 70px;">
							<option disabled value="">Select Currency</option>
							<?php 
							$currencyId = ($quotationData['currencyId']>0)?$quotationData['currencyId']:$baseCurrencyId;
							$dayroe = ($quotationData['currencyValue']>0)?$quotationData['currencyValue']:getCurrencyVal($currencyId);

							$currencyQuery = GetPageRecord('id,name',_CURRENCY_MASTER_,' 1  and name!="" and deletestatus=0 and status=1 order by setDefault desc');
							while($currencyData = mysqli_fetch_array($currencyQuery)){ ?>
							<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyData['id']==$currencyId){ echo "selected"; } ?>><?php echo $currencyData['name']; ?></option>
							<?php } ?>
						</select>
					</td>
					<td><input type="text" name="dayroe" id="currencyIdVal" value="<?php echo $dayroe; ?>" style="width: 74px; padding: 4px;"></td>
					<td>
						<select name="costTypeId" id="costTypeId" onchange="getGroupCost();" class="additionalCost packageCostDiv_selectbox" style="display: none;">
							<option value="1">Per Person Cost</option>
							<option value="2">Group Cost</option>
						</select>
					</td>
					</tr>
					<tr class="costrow">
					<th bgcolor="#ddd" >Single&nbsp;Basis</th>
					<th bgcolor="#ddd" >Double&nbsp;Basis</th>
					<!-- <th bgcolor="#ddd" >Twin&nbsp;Basis</th> -->
					<th bgcolor="#ddd" >Triple&nbsp;Basis</th>
					<?php if(isRoomActive('quadroom')==true){ ?>
					<th bgcolor="#ddd" >Quad&nbsp;Basis</th>
					<?php } if(isRoomActive('sixbedroom')==true){ ?>
					<th bgcolor="#ddd" >SixBed&nbsp;Basis</th>
					<?php } if(isRoomActive('eightbedroom')==true){ ?>
					<th bgcolor="#ddd" >EightBed&nbsp;Basis</th>
					<?php } if(isRoomActive('tenbedroom')==true){ ?>
					<th bgcolor="#ddd" >TenBed&nbsp;Basis</th> 
					<?php } if(isRoomActive('teenbed')==true){ ?>
					<th bgcolor="#ddd" >TeenBed&nbsp;Basis</th> 
					<?php } ?>
					<th bgcolor="#ddd" >ExtraBed(A)</th>
					<th bgcolor="#ddd" >ExtraBed(C)</th>
					<th bgcolor="#ddd" >Childwithoutbed</th>
					<th bgcolor="#ddd" >Infant&nbsp;Basis</th>
				</tr>
					<tr class="costrow">
					<td><input type="number" name="singleBasis" id="singleBasis" value=""></td>
					<td><input type="number" name="doubleBasis" id="doubleBasis" value=""></td>
					<!-- <td><input type="number" name="twinBasis" id="twinBasis" value=""></td> -->
					<td><input type="number" name="tripleBasis" id="tripleBasis" value=""></td>
					<?php if(isRoomActive('quadroom')==true){ ?>
					<td><input type="number" name="quadBasis" id="quadBasis" value=""></td>
					<?php } if(isRoomActive('sixbedroom')==true){ ?>
					<td><input type="number" name="sixBedBasis" id="sixBedBasis" value=""></td>
					<?php } if(isRoomActive('eightbedroom')==true){ ?>
					<td><input type="number" name="eightBedBasis" id="eightBedBasis" value=""></td>
					<?php } if(isRoomActive('tenbedroom')==true){ ?>
					<td><input type="number" name="tenBedBasis" id="tenBedBasis" value=""></td> 
					<?php } if(isRoomActive('teenbed')==true){ ?>
					<td><input type="number" name="teenBedBasis" id="teenBedBasis" value=""></td> 
					<?php } ?>
					<td><input type="number" name="extraBedABasis" id="extraBedABasis" value=""></td>
					<td><input type="number" name="childwithbedBasis" id="childwithbedBasis" value=""></td>
					<td><input type="number" name="childwithoutbedBasis" id="childwithoutbedBasis" value=""></td>
					<td><input type="number" name="infantBasisCost" id="infantBasisCost" value=""></td>
				</tr>
				<tr class="groupCostRow" style="display: none;">
				<th bgcolor="#ddd" >Group&nbsp;Cost</th>
				<th bgcolor="#ddd" >Total&nbsp;Pax</th>
				</tr>
				<tr class="additionalrow" style="display: none;">
					<th bgcolor="#ddd" >Adult&nbsp;Cost</th>
					<th bgcolor="#ddd" >Pax(A)</th>
					<th bgcolor="#ddd" >Child&nbsp;Cost</th>
					<th bgcolor="#ddd" >Pax(C)</th>
					<th bgcolor="#ddd" >Infant&nbsp;Cost</th>
					<th bgcolor="#ddd" >Pax(I)</th>
				</tr>
				<tr class="groupCostRow" style="display: none;">
				<td><input type="number" name="adultCost" id="groupCostPK" placeholder="Group Cost" value=""></td>
				<td><input type="number" name="adultCost" id="groupPaxPK" placeholder="Group Cost" value="<?php echo $pax = ($quotationData['adult']+$quotationData['infant']+$quotationData['child']); ?>"></td>
				</tr>
				<tr class="additionalrow" style="display: none;">
					
					<td><input type="number" name="adultCost" id="adultCostPK" placeholder="Adult Cost" value=""></td>
					<td><input type="number" name="adultPax" id="adultPax" placeholder="Adult Pax" value="<?php echo $quotationData['adult'] ?>"></td>
					<td><input type="number" name="ChildCost" id="ChildCostPK" placeholder="Child Cost" value=""></td>
					<td><input type="number" name="ChildPax" id="ChildPax" placeholder="Child Pax" value="<?php echo $quotationData['child'] ?>"></td>
					<td><input type="number" name="infantCost" id="infantCostPK" placeholder="Infant Cost" value=""></td>
					<td><input type="number" name="infantPax" id="infantPax" placeholder="Infant Pax" value="<?php echo $quotationData['infant'] ?>"></td>
				</tr>
				
				<?php //} ?>
				<tr id="loadrate" style="border: 1px solid #fff;border-top: 1px solid #ccc;">
        			<td colspan="11" id="addmultiplerate" >
					</td>
				</tr>
			</table>
		
		</div>
		
		<div class="griddiv" style="display: inline-block;vertical-align: top;margin-left: -4px;margin-top: 50px;">
			<input type="button" class="whitebutton" value="Save" style="background: green;
    		color: #fff !important;" onclick="cp_PPCost();">
			<label id="cp_PPCostMSG" class="alertMsg" >Complete package cost has been updated!</label>
		</div> 
		
		<div id="loadpackagerates" style="display: block;padding-left: 14px;padding-right: 14px;margin-bottom: 15px;"></div>
		<div id="deletePackageRates" style="display: block;padding-left: 14px;"></div>
		<script type="text/javascript">

		// 	function loadMultipleRate(){
			
		// 	var counNumService = $("#countNum").val();
		// 	var rateNum = $("#rateNum").val();
			
		// 	counNumService = Number(counNumService)+1;
		// 	rateNum = Number(rateNum)+1;
			
		// 	$.get(`searchaction.php?action=loadAppendMultiCategoryRates&id=${counNumService}&rateNum=${rateNum}&quotationType=<?php echo $quotationData['quotationType']; ?>&hotelCategory=<?php echo $quotationData['hotCategory']; ?>&hotelType=<?php echo $quotationData['hotelType']; ?>`, function(data){
		// 		$("#addmultiplerate").append(data);
		// 	});
		// 	$("#countNum").val(counNumService);
		// 	$("#rateNum").val(rateNum);
			
		// 	$("#loadrate").css('border','1px solid #ccc');
		// 	}

		// function RemoveRate(countNum,editId){
		// 	var response = confirm('Are you Sure! You want to Delete This Service!');
		// 		if(response==true){
		// 			$("#removeId"+countNum).remove();
		// 			$("#removeIcon"+countNum).remove();
		// 			$("#deleteServiceRecord").load(`final_frmaction.php?action=deleteCompletePackageWiseRates&id=${editId}&countNum=${countNum}`);
		// 			var counNumService = $("#countNum").val();
		// 			counNumService = Number(counNumService)-1;
		// 			$("#countNum").val(counNumService);
		// 		}
		// }
		function loadPackageRates(){
			$("#loadpackagerates").load(`searchaction.php?action=loadCompletePackageWiseRates&quotationId=<?php echo $quotationId; ?>`);
		}
		loadPackageRates();

		function deleteCompletePackageCost(id,quotationId,action){
			$("#deletePackageRates").load(`final_frmaction.php?action=${action}&id=${id}&quotationId=${quotationId}`);
		}

  		function cp_PPCost(){ 
			// var counNumService = $("#countNum").val();
			// let loop =1;
			// for(let i=1; i<=counNumService; i++){
  				var supplierId = $('#supplierId').val();
  				var currencyId = $('#currencyId').val();
  				var singleBasis = $('#singleBasis').val();
				var doubleBasis = $('#doubleBasis').val();
				var twinBasis = $('#twinBasis').val();
				var tripleBasis = $('#tripleBasis').val();

				var quadBasis = $('#quadBasis').val();
				var sixBedBasis = $('#sixBedBasis').val();
				var eightBedBasis = $('#eightBedBasis').val();
				var tenBedBasis = $('#tenBedBasis').val();

				var extraBedABasis = $('#extraBedABasis').val();
				var childwithbedBasis = $('#childwithbedBasis').val();
				var childwithoutbedBasis = $('#childwithoutbedBasis').val();
				var infantBasisCost = $('#infantBasisCost').val();
				var teenBedBasis = $('#teenBedBasis').val();
				var hotelCategoryId = $('#hotelCategoryId').val();
				var hotelTypeId = $('#hotelTypeId').val();
				var loopNum = $('#loopNum').val();
				var rateNumloop = $('#rateNumloop').val();
				var serviceTypeID = $('#serviceTypeID').val();
			
				var serviceName = $('#serviceName').val();
				var markupType = $('#markupType').val();
				var markupValue = $('#markupValue').val();
				var serviceTaxId = $('#serviceTaxId').val();
				var currencyIdVal = $('#currencyIdVal').val();
				var costTypeId = $('#costTypeId').val();

				var groupCost = $('#groupCostPK').val();
				var adultCost = $('#adultCostPK').val();
				var adultPax = $('#adultPax').val();
				var ChildCost = $('#ChildCostPK').val();
				var ChildPax = $('#ChildPax').val();
				var infantCost = $('#infantCostPK').val();
				var infantPax = $('#infantPax').val();
				var groupPax = $('#groupPaxPK').val();
				
				if(supplierId>0 && serviceName!=''){
				$('#cp_PPCostMSG').load('loadPackageWiseCost.php?action=cp_PPCost&calculationType=3&quotationId=<?php echo encode($quotationId); ?>&supplierId='+supplierId+'&currencyId='+currencyId+'&singleBasis='+singleBasis+'&doubleBasis='+doubleBasis+'&twinBasis='+twinBasis+'&tripleBasis='+tripleBasis+'&quadBasis='+quadBasis+'&sixBedBasis='+sixBedBasis+'&eightBedBasis='+eightBedBasis+'&tenBedBasis='+tenBedBasis+'&extraBedABasis='+extraBedABasis+'&childwithbedBasis='+childwithbedBasis+'&childwithoutbedBasis='+childwithoutbedBasis+'&infantBasisCost='+infantBasisCost+'&teenBedBasis='+teenBedBasis+'&hotelCategoryId='+hotelCategoryId+'&hotelTypeId='+hotelTypeId+'&loop='+rateNumloop+'&loopNum='+loopNum+'&serviceTypeID='+serviceTypeID+'&serviceName='+encodeURI(serviceName)+'&markupType='+markupType+'&markupValue='+markupValue+'&serviceTax='+serviceTaxId+'&currencyIdVal='+currencyIdVal+'&costTypeId='+costTypeId+'&adultCost='+adultCost+'&adultPax='+adultPax+'&ChildCost='+ChildCost+'&ChildPax='+ChildPax+'&infantCost='+infantCost+'&infantPax='+infantPax+'&groupCost='+groupCost+'&groupPax='+groupPax);
				}else{
					alert('Supplier and service name is mandatory!');
				}
				// loop++;
			// }
			
				// $('#cp_PPCostMSG').show();
				// $('#cp_costsheet').show();
				// setTimeout(function(){
				// 	$('#cp_PPCostMSG').hide();
				// },2000)
  		}
		
		function showAdditionalCost(){
			var serviceType = $("#serviceTypeID").val();
			if(serviceType==2){
				$(".additionalCost").show();
				$(".additionalCost").show();
				$(".costrow").hide();
				$(".additionalrow").show();
			}else{
				$(".costrow").show();
				$(".additionalCost").hide();
				$(".additionalrow").hide();
			}
		}
		function getGroupCost(){
			var costType = $("#costTypeId").val();
			console.log(costType)
			if(costType==1){
				$(".additionalrow").show();
				$(".groupCostRow").hide();
			}
			if(costType==2){
				$(".groupCostRow").show();
				$(".additionalrow").hide();
			}
		}
		
  	</script>  
	</div>
</div>
<?php } ?>

<?php 
if($quotationData['calculationType']==2 || $quotationData['calculationType']==3){ ?>
	<style type="text/css" >
	.packageCostDiv{
		display: block;
		background-color:#FFFFFF;
		position: relative;
	}
	.packageCostDiv table{
		width: auto;
		border-collapse: collapse;
		border-color: #ccc;
		width: min-content;
	}	
	.packageCostDiv table th {
		background-color: #ddd;
		color: #000;
		text-align: left;
	}
	.packageCostDiv input[type='number']{
		border: 0;
		border: none;
		outline: 0;
		outline: none;
		width: 100%;
		min-width: 80px;
		padding: 2px;
	}
	.packageCostDiv select.packageCostDiv_selectbox{
		max-width: 150px;
		border: 1px solid #ccc;
		padding: 5px;
	}
	.packageCostDiv input[type='button'].whitebutton{
		margin: 0px!important;
    background-color: #fafafa;
    border: 1px solid #9f9f9f;
    padding: 6px 8px;
    border-radius: 20px;
    font-size: 14px;
    color: #484848!important;
    text-decoration: none!important;
    outline: 0px!important;
    cursor: pointer;
	}
	.packageCostDiv .gridlable{
		color: #000!important;
		padding: 4px 0!important;
	}
	.packageCostDiv .griddiv{
		margin: 15px;
	}
	.packageCostDiv .perPaxCostDiv{
		border-top: 1px solid #ccc; 
	}
	.alertMsg{
		color: #3c63f5;
		padding: 6px 10px;
		display:none
	}
	</style>
	<?php 
} ?>
<!-- start package markup and tax div -->
<?php if($queryData['moduleType']==4){ ?>
<div  style="border-bottom: 1px solid #ccc; background-color:#FFFFFF; margin-bottom: 0; position:relative;">
	<div style="background-color: #fafafa;padding: 10px 15px;color: #000;font-weight: 500;cursor: pointer;font-size: 14px; overflow:hidden;border-bottom: 1px solid #ccc;">
			<label>
 				<div style=" border-width: 7px 7px 6px 6px; border-color: #0075ff; border-style: solid; width: 0; height: 0; display: inline-block; float: left; border-radius: 2px; "></div>&nbsp;&nbsp;Add&nbsp;Management&nbsp;Fee&nbsp;&&nbsp;TAX 
			</label>
	</div>  
  <div style="padding:10px 16px; background-color:#FFFFFF; " >
    <table border="1" cellpadding="5" cellspacing="0" bordercolor="#ccc" bgColor="#fafafa" style="width:min-content;border-collapse: collapse;">
      <tr>
		 		<!-- <td><strong>Type</strong></td>
		 		<td><strong>&nbsp;Universal&nbsp;Markup</strong></td>
		 		<td><strong>&nbsp;TaxType</strong></td> -->
		 		<!-- <td><strong>&nbsp;Tax(%)</strong></td> -->
	 	 		<?php if($quotationData['travelType']==1 && $financeresult['taxType'] == 1){ ?>
		 		<td><strong>&nbsp;TCS(%)</strong></td>
	 	 		<?php } ?>
      		</tr>
	   	<tr>
				<!-- <td>
					<select id="uniMarkupType" class="gridfield" style="padding: 6px 10px;max-width: 65px;background-color: #ffffff;border: 1px solid #ccc;border-radius: 2px;">
						<option value="1" <?php if($quotationData['markupType'] == 1){ ?> selected="selected" <?php } ?>>%</option>  
						<option value="2" <?php if($quotationData['markupType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
					</select>
	 	 		</td> -->
	 	 		<!-- <td>
	  			<input type="text" class="markInput digit_only" id="uniMarkupInput" value="<?php if($quotationData['markup']>0){ echo $quotationData['markup']; }else{ echo 0; } ?>" />
	 	 		</td> -->
	 	 		<!-- <td >
				<select id="gstType" class="gridfield " displayname="Gst Type" autocomplete="off"  style="padding: 8px; border: 1px #ccc solid; width: 100px;"  >
					<?php if($companyresult['sameOtherSTax']==1){ ?>
					<option value="1" <?php if($quotationData['gstType'] == 1){ ?> selected="selected" <?php } ?>>Same State</option>  
					<option value="2" <?php if($quotationData['gstType'] == 2){ ?> selected="selected" <?php } ?>>Other State</option>
					<?php }else{ ?>
					<option value="3" <?php if($quotationData['gstType'] == 3){ ?> selected="selected" <?php } ?>>Tax Only</option>
					<?php }  ?>
				</select>
				</td>  -->
	 	 		<!-- <td>
			 	 	<select id="serviceTax" class="gridfield" style="width: 100px;" >
						<?php 
						$rs2="";
						$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Invoice" and status=1 order by gstValue asc'); 
						while($gstSlabData=mysqli_fetch_array($rs2)){
						?>
						<option value="<?php echo $gstSlabData['gstValue'];?>" <?php if($quotationData['serviceTax']==$gstSlabData['gstValue']){ echo 'selected="selected"'; } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
						<?php
						} 
						?> 
					</select>
	 	 		</td> -->
	 	 		<?php if($quotationData['travelType']==1 && $financeresult['taxType'] == 1){ ?>
	 	 		 <td>
	  			<select id="tcsTax" name="tcsTax" class="gridfield "  style="width: 100px;"  >
						<option value="0">None</option>
						<?php 
						$rs2="";
						$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="TCS" and status=1 order by gstValue asc'); 
						while($tcsSlabData=mysqli_fetch_array($rs2)){
						?>
						<option value="<?php echo $tcsSlabData['gstValue'];?>" <?php if($quotationData['tcs']==$tcsSlabData['gstValue']){ echo 'selected="selected"'; } ?>><?php echo $tcsSlabData['gstSlabName'];?>&nbsp;(<?php echo $tcsSlabData['gstValue'];?>)</option>
						<?php
						} 
						?> 
				</select>
	 	 		</td>
	 	 		<?php } ?>
				<input type="hidden" name="curren" id="curren" value="<?php echo ($baseCurrencyId>0)?$baseCurrencyId:1; ?>">
				<input type="hidden" name="dayroe" id="dayroe" value="<?php echo ($baseCurrencyVal>0)?$baseCurrencyVal:1; ?>">
				<input type="hidden" name="discountType" id="discountType" value="1">
				<input type="hidden" name="discount" id="discount" value="0">
				<input type="hidden" name="asOnDate" id="asOnDate" value="<?php echo date('Y-m-d'); ?>">
				<input type="hidden" name="flightcosttype" id="flightcosttype" value="0">
				<input type="hidden" name="visacosttype" id="visacosttype" value="0">
				<input type="hidden" name="passportcosttype" id="passportcosttype" value="0">
				<input type="hidden" name="insurancecosttype" id="insurancecosttype" value="0">
				
      </tr>
    </table>
  </div>
</div>
<?php } ?>
<!-- end package markup and tax div -->
<?php //if($queryData['moduleType']!=4 && $queryData['queryType']!=4){ ?>
<!-- MARKUP WINDOW --> 
<div  style="border-bottom: 1px solid #ccc; background-color:#FFFFFF; margin-bottom: 0; position:relative;">
	<div style="background-color: #fafafa; padding: 10px 16px; color: #000; font-weight: 500; cursor: pointer; font-size: 14px; overflow:hidden; border-bottom: 1px solid #ddd;" >
 		<div style="float:left;"> 
			<label>
			<div style=" border-width: 7px 7px 6px 6px; border-color: #0075ff; border-style: solid; width: 0; height: 0; display: inline-block; border-radius: 2px; "></div>
			<?php 
			if($queryData['queryType']==4 || $quotationData['calculationType']==3){
			echo 'Select Markup Type ';
			}elseif($queryData['travelType']==2){ 
			echo 'Domestic&nbsp;Markup'; 
			}else{
			echo 'Select&nbsp;Markup'; 
			} ?>
			</label>
			<?php 
			//if($queryData['queryType']<>4){ ?><br>
					<label style="<?php if($quotationData['calculationType']==3){ ?>display:none;<?php } ?>"><input type="radio" name="selectMarkupType" id="isSer_Mark" style="display:inline-block;margin: 0px;" <?php if($quotationData['isSer_Mark'] == 1 && $quotationData['isUni_Mark'] == 0){ echo 'checked'; } ?>>&nbsp;Service&nbsp;Wise&nbsp;<?php if($financeresult['markupSerType']=='1'){ echo 'Markup'; }if($financeresult['markupSerType']=='2'){ echo 'Service Charge'; }?></label>
  				
					<?php //if($quotationData['calculationType']==3){ ?>
					<label style="<?php if($quotationData['calculationType']==3){ ?>display:none;<?php } ?>"><input type="radio" name="selectMarkupType" id="isUni_Mark" style="display:inline-block;"<?php if(($quotationData['isUni_Mark'] == 0 && $quotationData['isSer_Mark'] == 0) || $quotationData['isUni_Mark'] == 1 && $quotationData['calculationType']<>3){ echo ' checked'; } ?>>&nbsp;Universal&nbsp;<?php if($financeresult['markupSerType']=='1'){ echo 'Markup'; }if($financeresult['markupSerType']=='2'){ echo 'Service Charge'; }?>
					</label>
					<?php //} ?>

				<?php  
		//} ?>
		</div>
	</div>
	
  <div style="padding:10px 16px; background-color:#FFFFFF; <?php if($quotationData['isSer_Mark']<>1){ ?> display:none;<?php } ?>" id="tbbodySer_Mark">
  	<?php if($queryData['travelType']==1){ ?>
     <table border="1" cellpadding="5" cellspacing="0" bordercolor="#2c343f" bgColor="#fafafa">
      <tr>
				<?php  
				$c12=GetPageRecord('*','quotationServiceMarkup',' quotationId="'.$quotationData['id'].'" '); 
				if( mysqli_num_rows($c12) == 0){
					$marSerAmount =  $financeresult['marSerAmount'];

					$namevalue ='package="'.$marSerAmount.'",hotel="'.$marSerAmount.'",guide="'.$marSerAmount.'",activity="'.$marSerAmount.'",entrance="'.$marSerAmount.'",transfer="'.$marSerAmount.'",ferry="'.$marSerAmount.'",cruise="'.$marSerAmount.'",train="'.$marSerAmount.'",flight="'.$marSerAmount.'",restaurant="'.$marSerAmount.'",visa="'.$marSerAmount.'",passport="'.$marSerAmount.'",insurance="'.$marSerAmount.'",other="'.$marSerAmount.'",packageMarkupType=1,hotelMarkupType=1,guideMarkupType=1,activityMarkupType=1,entranceMarkupType=1,transferMarkupType=1,ferryMarkupType=1, cruiseMarkupType=1,trainMarkupType=1,flightMarkupType=1,restaurantMarkupType=1,visaMarkupType=1,passportMarkupType=1,insuranceMarkupType=1,otherMarkupType=1,status=1,quotationId="'.$quotationData['id'].'"';
					$add=addlistinggetlastid('quotationServiceMarkup',$namevalue);

					updatelisting(_QUOTATION_MASTER_,'isUni_Mark=1',' id="'.$quotationData['id'].'"');
				}

				$c13=GetPageRecord('*','quotationServiceMarkup',' quotationId="'.$quotationData['id'].'" '); 
				$serviceMarkup = mysqli_fetch_array($c13); 

				if($quotationData['calculationType']==3){
				?> 
       			<td width="5%" align="center" ><strong>Package</strong></td>
				<?php } ?>
        		<td width="5%" align="center" ><strong>Hotel</strong></td>
				<td width="5%" align="center" ><strong>Guide</strong></td>
				<td width="5%" align="center" ><strong>Activity</strong></td>
				<td width="5%" align="center" ><strong>Entrance</strong></td>
				<td width="5%" align="center" ><strong>Transfer</strong></td>
				<td width="5%" align="center" <?php echo isHideMster('ferryMaster'); ?>><strong>Ferry</strong></td>
				<td width="5%" align="center" ><strong>Cruise</strong></td>
				<td width="5%" align="center" ><strong>Train</strong></td>
				<td width="5%" align="center" ><strong>Flight</strong></td>
				<td width="5%" align="center" ><strong>Restaurant</strong></td>
				<td width="5%" align="center" <?php echo isHideMster('visacostmaster'); ?>><strong>Visa</strong></td>
				<!-- <td width="5%" align="center" <?php echo isHideMster('passportCostMaster'); ?>><strong>Passport</strong></td> -->
				<td width="5%" align="center" <?php echo isHideMster('insurancecostmaster'); ?>><strong>Insurance</strong></td>
				<td width="5%" align="center" ><strong>Other</strong></td> 
      </tr>
	   	<tr>
			<?php
		   if($quotationData['calculationType']==3){
				?> 
				<td width="5%"  align="left" >
					<div align="center" class="markupdiv">
						<select id="packageMarkupType" class="gridfield x_markupType "> 
						<option value="1" <?php if($serviceMarkup['packageMarkupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
						<option value="2" <?php if($serviceMarkup['packageMarkupType']==2){ ?>selected="selected"<?php } ?> >Flat</option>
						</select>
						<input type="text" class="markInput digit_only x_markup" id="serMarkup_package" value="<?php echo $serviceMarkup['package']; ?>">
					</div>
				</td>
				<?php
		   		}
				?> 
				<td width="5%"  align="left" >
					<div align="center" class="markupdiv">
						<select id="hotelMarkupType" class="gridfield x_markupType "> 
						<option value="1" <?php if($serviceMarkup['hotelMarkupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
						<option value="2" <?php if($serviceMarkup['hotelMarkupType']==2){ ?>selected="selected"<?php } ?> >Flat</option>
						</select>
						<input type="text" class="markInput digit_only x_markup" id="serMarkup_hotel" value="<?php echo $serviceMarkup['hotel']; ?>">
					</div>
				</td>
				<td width="5%"  align="left" >
					<div align="center" class="markupdiv">
						<select id="guideMarkupType" class="gridfield x_markupType" > 
						<option value="1" <?php if($serviceMarkup['guideMarkupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
						<option value="2" <?php if($serviceMarkup['guideMarkupType']==2){ ?>selected="selected"<?php } ?> >Flat</option>
						</select>
						<input type="text" class="markInput digit_only x_markup" id="serMarkup_guide" value="<?php echo $serviceMarkup['guide']; ?>">
					</div>
				</td>
				<td width="5%"  align="left" >
					<div align="center" class="markupdiv">
						<select id="activityMarkupType" class="gridfield x_markupType" > 
						<option value="1" <?php if($serviceMarkup['activityMarkupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
						<option value="2" <?php if($serviceMarkup['activityMarkupType']==2){ ?>selected="selected"<?php } ?> >Flat</option>
						</select>
						<input type="text" class="markInput digit_only x_markup" id="serMarkup_activity" value="<?php echo $serviceMarkup['activity']; ?>">
					</div>
				</td>
				<td width="5%"  align="left" >
					<div align="center" class="markupdiv">
						<select id="entranceMarkupType" class="gridfield x_markupType" > 
						<option value="1" <?php if($serviceMarkup['entranceMarkupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
						<option value="2" <?php if($serviceMarkup['entranceMarkupType']==2){ ?>selected="selected"<?php } ?> >Flat</option>
						</select>
						<input type="text" class="markInput digit_only x_markup" id="serMarkup_entrance" value="<?php echo $serviceMarkup['entrance']; ?>">
					</div>
				</td>
				<td width="5%"  align="left" >
					<div align="center" class="markupdiv">
						<select id="transferMarkupType" class="gridfield x_markupType" > 
						<option value="1" <?php if($serviceMarkup['transferMarkupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
						<option value="2" <?php if($serviceMarkup['transferMarkupType']==2){ ?>selected="selected"<?php } ?> >Flat</option>
						</select>
						<input type="text" class="markInput digit_only x_markup" id="serMarkup_transfer" value="<?php echo $serviceMarkup['transfer']; ?>">
					</div>
				</td>
				<td width="5%"  align="left" <?php echo isHideMster('ferryMaster'); ?>>
					<div align="center" class="markupdiv">
						<select id="ferryMarkupType" class="gridfield x_markupType" > 
						<option value="1" <?php if($serviceMarkup['ferryMarkupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
						<option value="2" <?php if($serviceMarkup['ferryMarkupType']==2){ ?>selected="selected"<?php } ?> >Flat</option>
						</select>
						<input type="text" class="markInput digit_only x_markup" id="serMarkup_ferry" value="<?php echo $serviceMarkup['ferry']; ?>">
					</div>
				</td>
				<td width="5%"  align="left">
					<div align="center" class="markupdiv">
						<select id="cruiseMarkupType" class="gridfield x_markupType" > 
						<option value="1" <?php if($serviceMarkup['cruiseMarkupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
						<option value="2" <?php if($serviceMarkup['cruiseMarkupType']==2){ ?>selected="selected"<?php } ?> >Flat</option>
						</select>
						<input type="text" class="markInput digit_only x_markup" id="serMarkup_cruise" value="<?php echo $serviceMarkup['cruise']; ?>">
					</div>
				</td>
				<td width="5%"  align="left" >
					<div align="center" class="markupdiv">
						<select id="trainMarkupType" class="gridfield x_markupType" > 
						<option value="1" <?php if($serviceMarkup['trainMarkupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
						<option value="2" <?php if($serviceMarkup['trainMarkupType']==2){ ?>selected="selected"<?php } ?> >Flat</option>
						</select>
						<input type="text" class="markInput digit_only x_markup" id="serMarkup_train" value="<?php echo $serviceMarkup['train']; ?>">
					</div>
				</td>
				<td width="5%"  align="left" >
					<div align="center" class="markupdiv">
						<select id="flightMarkupType" class="gridfield x_markupType" > 
						<option value="1" <?php if($serviceMarkup['flightMarkupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
						<option value="2" <?php if($serviceMarkup['flightMarkupType']==2){ ?>selected="selected"<?php } ?> >Flat</option>
						</select>
						<input type="text" class="markInput digit_only x_markup" id="serMarkup_flight" value="<?php echo $serviceMarkup['flight']; ?>">
					</div>
				</td>
				<td width="5%"  align="left" >
					<div align="center" class="markupdiv">
						<select id="restaurantMarkupType" class="gridfield x_markupType" > 
						<option value="1" <?php if($serviceMarkup['restaurantMarkupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
						<option value="2" <?php if($serviceMarkup['restaurantMarkupType']==2){ ?>selected="selected"<?php } ?> >Flat</option>
						</select>
						<input type="text" class="markInput digit_only x_markup" id="serMarkup_restaurant" value="<?php echo $serviceMarkup['restaurant']; ?>">
					</div>
				</td>
				<td width="5%"  align="left" <?php echo isHideMster('visacostmaster'); ?>>
					<div align="center" class="markupdiv">
						<select id="visaMarkupType" class="gridfield x_markupType" > 
						<option value="1" <?php if($serviceMarkup['visaMarkupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
						<option value="2" <?php if($serviceMarkup['visaMarkupType']==2){ ?>selected="selected"<?php } ?> >Flat</option>
						</select>
						<input type="text" class="markInput digit_only x_markup" id="serMarkup_visa" value="<?php echo $serviceMarkup['visa']; ?>">
					</div>
				</td>
				<!-- <td width="5%"  align="left" <?php echo isHideMster('passportCostMaster'); ?>>
					<div align="center" class="markupdiv">
						<select id="passportMarkupType" class="gridfield x_markupType" > 
						<option value="1" <?php if($serviceMarkup['passportMarkupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
						<option value="2" <?php if($serviceMarkup['passportMarkupType']==2){ ?>selected="selected"<?php } ?> >Flat</option>
						</select>
						<input type="text" class="markInput digit_only x_markup" id="serMarkup_passport" value="<?php echo $serviceMarkup['passport']; ?>">
					</div>
				</td> -->
				<td width="5%"  align="left" <?php echo isHideMster('insurancecostmaster'); ?>>
					<div align="center" class="markupdiv">
						<select id="insuranceMarkupType" class="gridfield x_markupType" > 
						<option value="1" <?php if($serviceMarkup['insuranceMarkupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
						<option value="2" <?php if($serviceMarkup['insuranceMarkupType']==2){ ?>selected="selected"<?php } ?> >Flat</option>
						</select>
						<input type="text" class="markInput digit_only x_markup" id="serMarkup_insurance" value="<?php echo $serviceMarkup['insurance']; ?>">
					</div>
				</td>
				<td width="5%"  align="left" >
					<div align="center" class="markupdiv">
						<select id="otherMarkupType" class="gridfield x_markupType" > 
						<option value="1" <?php if($serviceMarkup['otherMarkupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
						<option value="2" <?php if($serviceMarkup['otherMarkupType']==2){ ?>selected="selected"<?php } ?> >Flat</option>
						</select>
						<input type="text" class="markInput digit_only x_markup" id="serMarkup_other" value="<?php echo $serviceMarkup['other']; ?>">
					</div>
				</td>
      </tr>
    </table>
  	<?php } if($queryData['travelType']==2){ ?>
  	<label><input type="button" value="Service&nbsp;Wise&nbsp;<?php if($financeresult['markupSerType']=='1'){ echo 'Markup'; }else{ echo 'Charge'; }?>" class="bluembutton" onclick="openinboundpop('action=addServiceWiseMarkup&quotationId=<?php echo encode($quotationData['id']); ?>','1200px');"  style="margin-left:0px!important;"></label>
     <?php } ?>
  </div>
 
  <div style="padding:10px 16px; background-color:#FFFFFF; <?php if($quotationData['isUni_Mark']<>1 || $quotationData['calculationType']==3){ ?> display:none;<?php } ?>" id="tbbodyUni_Mark">
  	<?php if($queryData['travelType']==2){ ?>
  	<label><strong style="font-size: 14px;color: #000;">Universal&nbsp;Markup</strong></label>
  	<?php } ?>
    <table border="1" cellpadding="5" cellspacing="0" bordercolor="#2c343f" bgColor="#fafafa" width="190px">
      <tr> 
      	<td width="20%" align="left" >
      		<strong>
      		<?php if($financeresult['markupSerType']=='1'){ echo 'Mark&nbsp;Up'; } 
      		if($financeresult['markupSerType']=='2'){ echo "Service&nbsp;Charge"; } 
      		?>&nbsp;Type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      		</strong>
      	</td>
	 			<td><strong><?php if($financeresult['markupSerType']=='1'){ echo 'Mark&nbsp;Up'; } if($financeresult['markupSerType']=='2'){ echo "Service&nbsp;Charge"; } ?></strong></td>
      </tr>
	   <tr>
        <td width="20%"  align="left" >
					<select id="uniMarkupType" class="gridfield x_markupType " style="max-width: 100px!important;"> 
					<option value="1" <?php if($quotationData['markupType']==1){ ?>selected="selected"<?php } ?> >%</option> 
					<option value="2" <?php if($quotationData['markupType']==2){ ?>selected="selected"<?php } ?> >Flat(PP)</option>
				
					</select>
				</td>
				<td>
					<div align="center" class="markupdiv">
						<input type="text" class="markInput digit_only x_markup" id="uniMarkupInput" name="uniMarkupInput" value="<?php if($quotationData['markup']<1){ echo $financeresult['marSerAmount']; }else{ echo $quotationData['markup']; } ?>">
					</div>
		 	 	</td>
				
      </tr>
    </table>
  </div>
</div> 
<!-- END OF THE MARKUP WINDOW  -->
<script>
	function addmarkfun(){
		var className = $('#iconchek').attr('class');
		if(className === 'fa fa-plus'){
		$("#iconchek").removeClass("fa fa-plus");
		$("#iconchek").addClass('fa fa-minus');
		}
		if(className === 'fa fa-minus'){
		$("#iconchek").removeClass("fa fa-minus");
		$("#iconchek").addClass('fa fa-plus');
		}
		$('#loadmarkupType').toggle();
	}
</script>
<?php //} ?>

<!-- Value Added services block start-->
<div  style="border-bottom: 1px solid #ccc; background-color:#FFFFFF; margin-bottom: 0; position:relative;">
	<div style="background-color: #fafafa;padding: 10px 15px;color: #000;font-weight: 500;cursor: pointer;font-size: 14px; overflow:hidden;border-bottom: 1px solid #ccc;">
			<label>
 				<div style=" border-width: 7px 7px 6px 6px; border-color: #0075ff; border-style: solid; width: 0; height: 0; display: inline-block; float: left; border-radius: 2px; "></div>&nbsp;&nbsp;Flight&nbsp;&&nbsp;Value&nbsp;Added&nbsp;Services
			</label>
	</div>  
  <div style="padding:10px 16px; background-color:#FFFFFF; " >
    <table border="1" cellpadding="5" cellspacing="0" bordercolor="#ccc" bgColor="#fafafa" style="border-collapse: collapse !important;">
      <tr> 
		 		<td align="center" <?php if($quotationData['calculationType']==3){ ?>id="flightCostInclude" <?php } ?> style="<?php if($quotationData['calculationType']==3){ ?>display:none;<?php } ?>width:150px;padding: 11px 5px;border-top: none;border-left: none;border-bottom: none;" ><strong>Flight&nbsp;Cost.</strong></td>
				<td align="center" id="visaCostInclude"  style="display:none;width:150px;padding: 11px 5px;border-top: none;border-left: none;border-bottom: none;"><strong> Visa&nbsp;Cost</strong></td>
				<!-- <td align="center" id="passportCostInclude" style="display:none;width:150px;padding: 11px 5px;border-top: none;border-left: none;border-bottom: none;"><strong>Passport&nbsp;Cost</strong></td> -->
				<td align="center" id="insuranceCostInclude" style="display:none;width:150px;padding: 11px 5px;border-top: none;border-left: none;border-bottom: none;"><strong>Insurance&nbsp;Cost</strong></td>
      </tr>

	   	<tr> 
				<td align="center" <?php if($quotationData['calculationType']==3){ ?> id="flightCostInclude" <?php } ?> style="<?php if($quotationData['calculationType']==3){ ?>display:none;<?php } ?>width:150px;border-left: none;border-bottom: none;">
					<select id="flightcosttype" name="flightcosttype" class="gridfield validate" displayname="Flight Cost Type" autocomplete="off"  style="padding: 8px; border: 1px #ccc solid;width: 150px;">
						<option value="0" <?php if($quotationData['flightCostType']=='0'){ ?> selected="selected" <?php } ?> >Package Cost</option>
						<option value="1" <?php if($quotationData['flightCostType']=='1'){ ?> selected="selected" <?php } ?> >Supplement Cost</option>
					</select>		
				</td>
				<td align="center" id="visaCostInclude" style="display:none;width:150px;border-left: none;border-bottom: none;">
					<select id="visacosttype" name="visacosttype" class="gridfield validate" displayname="Visa Cost Type" autocomplete="off"  style="padding: 8px; border: 1px #ccc solid; width: 150px;">
					<option value="1" <?php if($quotationData['visaCostType']==1){ ?> selected="selected" <?php } ?> >Package Cost</option>	
					<option value="2" <?php if($quotationData['visaCostType']==2){ ?> selected="selected" <?php } ?> >Supplement Cost</option>
					</select>		
				</td>
				
				<!-- <td align="center" id="passportCostInclude" style="display:none;width:150px;border-left: none;
		    		border-bottom: none;">
					<select id="passportcosttype" name="passportcosttype" class="gridfield validate" displayname="Passport Cost Type" autocomplete="off"  style="padding: 8px; border: 1px #ccc solid; width: 150px;">
					<option value="1" <?php if($quotationData['passportCostType']==1){ ?> selected="selected" <?php } ?> >Package Cost</option>	
					<option value="2" <?php if($quotationData['passportCostType']==2){ ?> selected="selected" <?php } ?> >Supplement Cost</option>
					</select>		
				</td> -->
				
				<td align="center" id="insuranceCostInclude" style="display:none;width:150px;border-left: none;
		    		border-bottom: none;">
					<select id="insurancecosttype" name="insurancecosttype" class="gridfield validate" displayname="Insurance Cost Type" autocomplete="off"  style="padding: 8px; border: 1px #ccc solid; width: 150px;">
					<option value="1" <?php if($quotationData['insuranceCostType']==1){ ?> selected="selected" <?php } ?> >Package Cost</option>	
					<option value="2" <?php if($quotationData['insuranceCostType']==2){ ?> selected="selected" <?php } ?> >Supplement Cost</option>
					</select>		
				</td>
				<td style="display:none;">&nbsp;</td>
      </tr>
    </table>
  </div>
</div>
<!-- Value Added services block end -->

<div style="padding:15px; background-color:#FFFFFF; padding-left:10px; display:none1;" id="markupdiv">
	<table border="0" cellpadding="5" cellspacing="0" width="auto" >
	   <tr>
		<?php 
		$showingStyle="";
		if(($queryData['moduleType']=="3" && $quotationData['isFD'] == 1) || ($queryData['moduleType']=="1" && $quotationData['queryType'] == 4) || ($queryData['moduleType']=="2" && $quotationData['isSeries'] == 1) || ( $queryData['moduleType']=="1" && $quotationData['queryType'] == 3) ){
			$showingStyle="style='display:none;'";
		}
		?>
		<?php if($queryData['moduleType']!=4){ 
			if($quotationData['calculationType']<>3){
			?> 

			<td width="60px" >Price&nbsp;Sensitivity(%)<br />
				<input type="text" id="priceSenValue" name="priceSenValue" placeholder="0" class="digit_only" value="<?php echo trim($quotationData['priceSenValue']); ?>" style="padding: 8px;border:1px #ccc solid;width:80%;padding-top: 7px;" required>
			</td>

			<td>
				<?php if($financeresult['taxType'] == 1){ echo 'GST'; }elseif($financeresult['taxType'] == 2){ echo 'VAT'; }else{ echo 'Tax'; } ?>&nbsp;Type<br /> 
			 	<select id="gstType" class="gridfield "  autocomplete="off"  style="padding: 8px; border: 1px #ccc solid; width: 80px;" >
		 		<?php 
					if($companyresult['sameOtherSTax']==1){ ?>
					<option value="1" <?php if($quotationData['gstType'] == 1){ ?> selected="selected" <?php } ?>>Same State</option>  
					<option value="2" <?php if($quotationData['gstType'] == 2){ ?> selected="selected" <?php } ?>>Other State</option>
					<?php }else{ ?>
					<option value="3" <?php if($quotationData['gstType'] == 3){ ?> selected="selected" <?php } ?>>Tax Only</option>
						<?php 
					}  
				  ?>
				</select>
			</td> 

			<td width="110px" <?php if($quotationData['travelType']==2){ ?> class="uniMarkupGST" <?php } ?>><?php if($financeresult['taxType'] == 1){ echo 'GST'; }elseif($financeresult['taxType'] == 2){ echo 'VAT'; }else{ echo 'Tax'; } ?>&nbsp;Slab(%)<br /> 
				<select id="serviceTax" class="gridfield " <?php if($_SESSION['userid'] == 37){ ?> name="serviceTax" <?php } else{ ?> readonly="readonly" <?php } ?>  style="padding: 8px; border: 1px #ccc solid; width: 100%;" >
					<?php 
						$rs2="";
						$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Invoice" and status=1 order by gstValue asc'); 
						while($gstSlabData=mysqli_fetch_array($rs2)){
						?>
						<option value="<?php echo $gstSlabData['gstValue'];?>" <?php if($quotationData['serviceTax']==$gstSlabData['gstValue']){ echo 'selected="selected"'; } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
						<?php
						} ?>
				</select>
			</td> 
			<?php } if($financeresult['taxType'] == 2){ ?>
			<td width="60px" >On&nbsp;Tour&nbsp;Value(%)<br />
				<input type="text" id="serviceTaxDivident" name="serviceTaxDivident" class="digit_only" value="<?php echo ($quotationData['serviceTaxDivident']>0)?round($quotationData['serviceTaxDivident']):100; ?>" style="padding: 8px;border:1px #ccc solid;width:70%;padding-top: 7px;" required>
			</td>
			<?php } ?>

			<?php if($quotationData['travelType']==1 && $financeresult['taxType'] == 1){ ?> 
			<td width="110px" class="uniMarkupGST22" >TCS(%)<br /> 
				<select id="tcsTax" name="tcsTax" class="gridfield " autocomplete="off"  style="width: 100px;"  >
					<option value="0">None</option>
					<?php 
						$rs2="";
						$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="TCS" and status=1 order by gstValue asc'); 
						while($tcsSlabData=mysqli_fetch_array($rs2)){
						?>
						<option value="<?php echo $tcsSlabData['gstValue'];?>" <?php if($quotationData['tcs']==$tcsSlabData['gstValue']){ echo 'selected="selected"'; } ?>><?php echo $tcsSlabData['gstSlabName'];?>&nbsp;(<?php echo $tcsSlabData['gstValue'];?>)</option>
						<?php
						} 
					?> 
				</select>
			</td>  
		<?php } } ?>
		<?php if($queryData['moduleType']!=4){ ?>
		<td style="display:none;">
				Language<br />
				<select id="languageType2" name="languageType2" class="gridfield" autocomplete="off"  >
				<?php 
				$rs=GetPageRecord('id,name','tbl_languagemaster','1 and status=1 and deletestatus=0');
		$totalrow = mysqli_num_rows($rs);
		while($languageDetails=mysqli_fetch_array($rs)){
			?>
			<option value="<?php echo $languageDetails['id']; ?>" <?php if($languageDetails['id'] == $quotationData['languageId']){ echo "selected"; } ?>><?php echo $languageDetails['name']; ?></option>
		<?php } ?> 
			</select> 
		</td> 
		 <td width="90px">Discount&nbsp;Type<br />
		 <select id="discountType" class="gridfield " autocomplete="off"  style="padding: 8px; border: 1px #ccc solid; width: 100%;"  >
			<option value="1" <?php if($quotationData['discountType'] == 1){ ?> selected="selected" <?php } ?>>%</option>  
			<option value="2" <?php if($quotationData['discountType'] == 2){ ?> selected="selected" <?php } ?>>Flat(PP)</option>
			</select>
		</td> 
		<td width="60px" >Discount<br />
			<input type="text" id="discount" name="discount" class="digit_only" value="<?php echo trim($quotationData['discount']); ?>" style="padding: 8px;border:1px #ccc solid;width:70%;padding-top: 7px;" required>
		</td>
	
		<?php //if($queryData['queryType']!=4){ ?>
		<td width="60">Currency<br />	
		 	<select id="curren" name="curren" class="gridfield validate" displayname="Currency To" autocomplete="off"  style="padding:8px; border:1px #ccc solid; width:70px;" onchange="getROE(this.value,'dayroe');" >
        <?php  
        $select=''; 
        $where=''; 
        $rs='';  
        $select='*';    
        $where=' deletestatus=0 and country!=0 and status=1 order by name asc';  
        $rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
        while($resListing=mysqli_fetch_array($rs)){  
        ?>
        <option value="<?php echo strip($resListing['id']); ?>" <?php if($quotationData['currencyId'] == $resListing['id']){ echo "selected='selected'";  } else if($resListing['setDefault']==1 && $quotationData['currencyId'] == 0){ echo "selected='selected'"; }else{ echo ''; } ?> ><?php echo strip($resListing['name']); ?></option>
        <?php } ?>
      </select>
			<?php
			$rs="";
			$cuurencyQuery="";
			if($quotationData['currencyId']!='' && $quotationData['currencyId']!=0){
				$cuurencyQuery=" and id='".$quotationData['currencyId']."'";
			}else{ 
				$cuurencyQuery=" and setDefault=1 and status=1 ";
			}
			$rs=GetPageRecord('*','queryCurrencyRateMaster',' 1 and currencyId in ( select id from '._QUERY_CURRENCY_MASTER_.' where 1 '.$cuurencyQuery.' and country!=0 ) and date = "'.date('Y-m-d').'"'); 
      $currencyRateData=mysqli_fetch_array($rs);
			
			if($quotationData['dayroe'] !='' && $quotationData['dayroe'] !=0 ){
				$roeVal = $quotationData['dayroe'];
				$asOnDate = date('Y-m-d',strtotime($quotationData['asOnDate']));
			}else{
				$roeVal = $currencyRateData['currencyValue'];
				$asOnDate = date('Y-m-d',strtotime($currencyRateData['date']));
			}
			if($asOnDate == '1970-01-01'){
				$asOnDate = date('Y-m-d');
			} 

			if($roeVal == 0){
				$roeVal = 1;
			} 
			?>
		</td>   
		<td>
			<span style="position: relative;top: -7px;">ROE(For <b>1 <?php echo getCurrencyName($defaultCurr); ?></b>)&nbsp;<br>As&nbsp;on&nbsp;:<span id="as_on_roe"><?php echo date('d/m/y',strtotime($asOnDate)); ?></span></span><br />
			<input type="text" id="dayroe" name="dayroe" class="digit_only" value="<?php echo trim($roeVal); ?>" style="padding: 8px;border:1px #ccc solid;padding-top: 7px;position: relative;top: -7px;width: 75px;" required>
			<input type="hidden" name="asOnDate" id="asOnDate" value="<?php echo trim($asOnDate); ?>">	    
		</td>
		<?php //} ?>
		
	
		<!-- <td width="43%" >&nbsp;</td> -->
		<?php } ?>
		</tr>		
		<tr><td></td></tr>
	</table>
	
	<table border="0" cellpadding="6" cellspacing="0"  class="contentdiv" > 
			<tr>   
				<td width="5%" >
					<!--multHotCatValidateionFun(); its cal to undefined-->
					<input type="button" name="Submit" value="Save" class="blackbutton" onclick="loadmainboxquotation(1);" style="margin-left:0px!important;"/>	    
				</td>
				<td width="5%" >
						<a class="whitebutton"  href="showpage.crm?module=query&view=yes&id=<?php echo encode($quotationData['queryId']); ?><?php if($quotationData['isTourEx']==1){ ?>&tourextension=1<?php }else{ ?>&b2bquotation=1&qtype=1<?php } ?>">Back</a>    
				</td>  
				<?php if($_REQUEST['package']!='yes'){ ?> 
				<td width="13%" id="CostsheetPreview" style="display:none;">

					<?php if($quotationData['queryType']==13){ ?>

					<a class="whitebutton" onclick="alertspopupopen('action=addCostSheet_MultiServices&quotationId=<?php echo $quotationId; ?>','1260px','auto');" >  CostSheet&nbsp;Preview </a>

					<?php }else{ if($quotationData['calculationType']==2){ ?>
					<a class="whitebutton" onclick="alertspopupopen('action=addCostSheet_packagewise&quotationId=<?php echo $quotationId; ?>','1260px','auto');" >  CostSheet&nbsp;Preview </a>
					<?php }elseif($quotationData['calculationType']==3){ ?>
					<a class="whitebutton" onclick="alertspopupopen('action=addCostSheet_completepackage&quotationId=<?php echo $quotationId; ?>&package=<?php echo $_REQUEST['package']; ?>&hotelCategory=<?php echo $quotationData['hotCategory']; ?>&hotelType=<?php echo $quotationData['hotelType']; ?>&quotationType=<?php echo $quotationData['quotationType']; ?>','1200px','auto');" >  CostSheet&nbsp;Preview </a>
					<?php }else{ ?>
					<a class="whitebutton" onclick="<?php if(($quotationData['quotationType'] == 2 || $quotationData['quotationType'] == 3) && $quotationData['status']!=1){ ?>alertspopupopen('action=selectCostSheet&quotationId=<?php echo $quotationId; ?>','400px','auto');<?php } else{ ?>alertspopupopen('action=addCostSheet&quotationId=<?php echo $quotationId; ?>','1260px','auto');<?php } ?>" >  CostSheet&nbsp;Preview  </a>
					<?php } } ?>

				</td>  
			
					<td width="10%" > 
					<?php if($quotationData['queryType']==13){ ?>
						<a  id="pdfItineraryBtn" class="whitebutton" href="<?php echo $fullurl; ?>PreviewFiles/crm_proposal.php?propNum=<?php if($quotationData['quotationType']==2){ echo "6"; }else{ echo "6";} ?>&q_token=<?php echo trim($quotationData['q_token']);?>&id=<?php echo encode($quotationData['id']);?>" target="_blank"  style="display:none;">  Preview&nbsp;<?php echo $quotword; ?>  </a>
						<?php }else{ ?>
						<a  id="pdfItineraryBtn" class="whitebutton" href="<?php echo $fullurl; ?>PreviewFiles/crm_proposal.php?propNum=<?php if($quotationData['quotationType']==2){ echo "6"; }else{ echo "6";} ?>&q_token=<?php echo trim($quotationData['q_token']);?>&id=<?php echo encode($quotationData['id']);?>" target="_blank"  style="display:none;">  Preview&nbsp;<?php echo $quotword; ?>  </a>
						<?php } ?>
					</td>

					<td width="13%" width="13%" id="HotelAvailability" style="display:none;">

						<?php if($quotationData['queryType']==13){ ?>
							<a class="whitebutton" onClick="alertspopupopen('action=queryHotelAvailability&queryId=<?php echo encode($quotationData['queryId']); ?>&quotationId=<?php echo encode($quotationId); ?>','1050px','auto');" >  Hotel&nbsp;Availability  </a>

						<?php }else{ if($quotationData['calculationType']==2){ ?>
							<a class="whitebutton" onClick="alertspopupopen('action=queryHotelAvailability&queryId=<?php echo encode($quotationData['queryId']); ?>&quotationId=<?php echo encode($quotationId); ?>','1050px','auto');" >  Hotel&nbsp;Availability  </a>

						<?php }elseif($quotationData['calculationType']==3){ ?>
							<a class="whitebutton" onClick="alertspopupopen('action=queryHotelAvailability&queryId=<?php echo encode($quotationData['queryId']); ?>&quotationId=<?php echo encode($quotationId); ?>','1050px','auto');" >  Hotel&nbsp;Availability  </a>

						<?php }else{ ?>
							<a class="whitebutton" onClick="alertspopupopen('action=queryHotelAvailability&queryId=<?php echo encode($quotationData['queryId']); ?>&quotationId=<?php echo encode($quotationId); ?>','1050px','auto');" >  Hotel&nbsp;Availability  </a>


					<?php } } ?>

				</td>

				<td width="13%" width="13%" id="MakeFinal" style="display:none;">

					<?php if($quotationData['queryType']==13){ ?>

						<a class="whitebutton" <?php if ($resultpage['queryStatus'] != 3) { ?> onClick="alertspopupopen('action=chooseSupplimentServices&status=1&queryId=<?php echo $quotationData['queryId']; ?>&quotationId=<?php echo $quotationId; ?>','800px','auto');" <?php } ?> class="saveasbtn2">Make&nbsp;Final</a>

					<?php }else{ if($quotationData['calculationType']==2){ ?>
						<a class="whitebutton" <?php if ($resultpage['queryStatus'] != 3) { ?> onClick="alertspopupopen('action=chooseSupplimentServices&status=1&queryId=<?php echo $quotationData['queryId']; ?>&quotationId=<?php echo $quotationId; ?>','800px','auto');" <?php } ?> class="saveasbtn2">Make&nbsp;Final</a>
					<?php }elseif($quotationData['calculationType']==3){ 
						if ($quotationData['quotationType'] == 1) {
							?>
						<a class="whitebutton" <?php if ($resultpage['queryStatus'] != 3) { ?> onClick="alertspopupopen('action=chooseSupplimentServices&status=1&queryId=<?php echo $quotationData['queryId']; ?>&quotationId=<?php echo $quotationId; ?>','800px','auto');" <?php } ?> class="saveasbtn2">Make&nbsp;Final</a> 
						<?php }else{ ?>

							<a class="whitebutton" <?php if ($resultpage['queryStatus'] != 3) { ?> onClick="alertspopupopen('action=finalQuotation&status=1&queryId=<?php echo $resultpage['id']; ?>&id=<?php echo $quotationData['id']; ?>','800px','auto');" <?php } ?> class="saveasbtn2">Make&nbsp;Final</a> 
							
						<?php } ?>
					<?php }else{ ?>

						<?php 
							$haveFinalQuery = GetPageRecord('*', _QUOTATION_MASTER_, 'queryId=' .$quotationData['queryId']. ' and status=1 and deletestatus=0');

							if ($resultlists['status'] == 2 && mysqli_num_rows($haveFinalQuery) > 0) 
							{ ?>
								<a><i class="fa fa-check-circle" aria-hidden="true" style="font-size: 30px;"></i></a>

							<?php }
							if (mysqli_num_rows($haveFinalQuery) < 1) {
						?>
						<a class="whitebutton" <?php if ($resultpage['queryStatus'] != 3) { ?> onClick="alertspopupopen('action=chooseSupplimentServices&status=1&queryId=<?php echo $quotationData['queryId']; ?>&quotationId=<?php echo $quotationId; ?>','800px','auto');" <?php } ?> class="saveasbtn2">Make&nbsp;Final</a>

						<?php } ?>

					<?php } } ?>

				</td>
				
				
				<?php } ?> 
				
				
				<td align="left" valign="middle">
					<div id="savemarkupBox" style=" display:none;"> </div> 
					<div id="showaddmarkup" style="color:#CC0000; display:none;">Quotation Updated Successfully.</div>
				</td>
	  </tr>
	</table>
</div>
 
<div id="saveproposaltype" style="display:none;"></div> 
<div id="loadhotelTypealert" style="display:none;transition: 1s all;"></div> 
<div id="languagechange" style="display:none;"></div> 
<script src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
	// insertlanguage(<?php echo $quotationData['languageId'] ?>);
	// function insertlanguage(id){
	// 	$('#languagechange').load('frmaction.php?action=quotationlanguagechange&id=<?php echo encode($quotationData['id']);?>&languageId='+id);
	// } 
	window.setInterval(function(){
		$('#showaddmarkup').hide();
	}, 10000);  
//jQuery(document).ready(function($){	
	$('input[name=isOtherLocation]').change(function () {
		if($(this).prop('checked') == true){
			$('#OtherLocationBox').show();
		}else{
			$('#OtherLocationBox').hide();
		}
	});
		
	$('input[name=isInc_exc]').change(function () {
		if($(this).prop('checked') == true){
			$('#tbbodyinc_exc').show();
			loadQuotationIncExc();
		}else{
			$('#tbbodyinc_exc').hide();
		}
	});
 
	
	$('#isSer_Mark').change(function () {
		if($('#isSer_Mark').prop('checked') == true){
			$('#tbbodySer_Mark').show();
			$('#isUni_Mark').prop('checked',false);
			$('#tbbodyUni_Mark').hide();
			$('.uniMarkupGST').hide();
		}else{
			$('#tbbodySer_Mark').hide();
			$('#isUni_Mark').prop('checked',true);
			$('#tbbodyUni_Mark').show();
			$('.uniMarkupGST').show();

		}
	});
	
	$('#isUni_Mark').change(function () {
		if($('#isUni_Mark').prop('checked') == true){
			$('#tbbodyUni_Mark').show();
			$('#isSer_Mark').prop('checked',false);
			$('#tbbodySer_Mark').hide();
			$('.uniMarkupGST').show();
		}else{
			$('#tbbodyUni_Mark').hide();
			$('#isSer_Mark').prop('checked',true);
			$('#tbbodySer_Mark').show();
			$('.uniMarkupGST').hide();
		}
	});
	 
	$('input[name=isAddExp]').change(function () {
		if($(this).prop('checked') == true){
			$('#tbbodyAddExp').show();
    	$('.selectizeSupp').selectize();
		}else{
			$('#tbbodyAddExp').hide();
		}
	});
	 
	// SAVE SERVICE TYPE MARKUP
	function addAdditionalExperience(){
		if($("#isAddExp").is(':checked')){
			var isAddExp = 1;
		}	 
		var additionalId = $('#additionalId').val();
		var adultCost = $('#actadultCost').val(); 
		var childCost = $('#actchildCost').val(); 
		var infantCost = $('#actinfantCost').val(); 
		if(isAddExp==1){
			startloadin`g`();
			$('#pageloading').hide();
			$('#pageloader').hide(); 
			$('#savemarkupBox').load('inboundpop.php?action=addAdditionalExperience&quotationId=<?php echo encode($quotationId); ?>&isAddExp='+encodeURI(isAddExp)+'&additionalId='+encodeURI(additionalId)+'&adultCost='+encodeURI(adultCost)+'&childCost='+encodeURI(childCost)+'&infantCost='+encodeURI(infantCost));
		}
	}
	
	function getActivityCost(){
		var additionalId = $('#additionalId').val(); 
		$('#loadadditionalIdCost').load('loadsaveOtherActivity.php?action=loadotherActivityCost2&otherActivityId='+additionalId);
	}
	
	function deleteServiceMarkup(serviceMarkId,action){
		if(serviceMarkId!=''){
			startloading();
			$('#pageloading').hide();
			$('#pageloader').hide(); 
			//$('#savemarkupBox').load('inboundpop.php?action='+action+'&quotationId=<?php echo encode($quotationId); ?>&serviceMarkId='+encodeURI(serviceMarkId));
			 
		}
	} 
	
	function deleteAdditionalExperience(additionalId,action){
		if(additionalId!=''){
			startloading();
			$('#pageloading').hide();
			$('#pageloader').hide(); 
			$('#savemarkupBox').load('inboundpop.php?action='+action+'&quotationId=<?php echo ($quotationId); ?>&additionalId='+encodeURI(additionalId));
			 
		}
	}  


	// LOAD QUOTAITON PDF
	function loadmainboxquotation(viewQuotation){
		<?php 
		if($quotationData['quotationType']==3){
			?>
		$("#loadhotelTypealert").load(`final_frmaction.php?action=loadcodetocheckhoteltype&quotationId=<?php echo $quotationId; ?>&queryId=<?php echo $queryId; ?>&hotelType=<?php echo $quotationData['hotelType']; ?>`)
			<?php
		}
			?>
			
			
			
		if($("#isOtherLocation").is(':checked')){
			var isOtherLocation = 1;
		}else{
			var isOtherLocation = 0;
		}
		
		if($("#isSupp_TRR").is(':checked')){
			var isSupp_TRR = 1;
		}else{
			var isSupp_TRR = 0;
		} 
		
		var serviceTaxDivident = $("#serviceTaxDivident").val();
		if (serviceTaxDivident === undefined || serviceTaxDivident === null || serviceTaxDivident === "") {
		    serviceTaxDivident = 100;
		}
		
		var priceSenValue = $("#priceSenValue").val();
		if (priceSenValue === undefined || priceSenValue === null || priceSenValue === "") {
		    priceSenValue = 0;
		}
		
		var tcsTax = $("#tcsTax").val();
		if (tcsTax === undefined || tcsTax === null || tcsTax === "") {
		    tcsTax = 0;
		}
		
		if($("#focCost").is(':checked')){
			var costType = 1;
		}else if($("#focSale").is(':checked')){
			var costType = 2;
		}else{
			var costType = 1;
		}


		// UNIVERSAL MARKUP AND SERVICE MARKUP CHOOSE
		if($("#isUni_Mark").is(':checked')){
			var isUni_Mark = 1;
			var isSer_Mark = 0;
		}else if($("#isSer_Mark").is(':checked')){
			var isUni_Mark = 0;
			var isSer_Mark = 1;
		}else{
			var isUni_Mark = 1;
			var isSer_Mark = 0;
		}
		
		var languageType = $('#languageType2').val();
		var otherLocation = $('#otherLocation').val();
		var otherLocationCost = $('#otherLocationCost').val();
		
		if($("#isInc_exc").is(':checked')){
			var isInc_exc = 1;
	
			
			// serviceupgradationText,optionaltourText
			var overviewText1 = tinymce.get("overviewText").getContent();
			var highlightsText1 = tinymce.get("highlightsText").getContent();
			var itineraryintrText1 = tinymce.get("itineraryintrText").getContent();
			var itinerarysummText1 = tinymce.get("itinerarysummText").getContent();
			var inclusionText1 = tinymce.get("inclusionText").getContent();
			var serviceupgradationText1 = tinymce.get("serviceupgradationText").getContent();
			var optionaltourText1 = tinymce.get("optionaltourText").getContent();
			var paymentpolicy1 = tinymce.get("paymentpolicyText").getContent();
			var remarks1 = tinymce.get("remarksText").getContent();
			var exclusionText1 = tinymce.get("exclusionText").getContent();
			var tncText1 = tinymce.get("termsconditionText").getContent();
			var specialText1 = tinymce.get("cancelationText").getContent(); 

		}else{
			var isInc_exc = 0;

			var overviewText1 = '';
			var itineraryintrText1 = '';
			var itinerarysummText1 = '';
			var highlightsText1 = '';
			var inclusionText1 = '';
			var serviceupgradationText1 = '';
			var optionaltourText1 = '';
			var paymentpolicy1 = '';
			var remarks1 = '';
			var exclusionText1 = '';
			var tncText1 = '';
			var specialText1 = '';
		} 
		var overviewText = overviewText1.replace(/&nbsp;/g, ' ')
		var itineraryintrText = itineraryintrText1.replace(/&nbsp;/g, ' ')
		var itinerarysummText = itinerarysummText1.replace(/&nbsp;/g, ' ')
		var highlightsText = highlightsText1.replace(/&nbsp;/g, ' ')
		var inclusionText = inclusionText1.replace(/&nbsp;/g, ' ')
		var serviceupgradationText = serviceupgradationText1.replace(/&nbsp;/g, ' ')
		var optionaltourText = optionaltourText1.replace(/&nbsp;/g, ' ')
		var paymentpolicy = paymentpolicy1.replace(/&nbsp;/g, ' ')
		var remarks = remarks1.replace(/&nbsp;/g, ' ')
		var exclusionText = exclusionText1.replace(/&nbsp;/g, ' ')
		var tncText = tncText1.replace(/&nbsp;/g, ' ')
		var specialText = specialText1.replace(/&nbsp;/g, ' ')
			// alert(remarks);

		var markup = $('#uniMarkupInput').val();
	
		var markupType = $('#uniMarkupType').val();
		var discountType = $('#discountType').val();
		var discount = $('#discount').val();
		
		var gstType= $('#gstType').val();  
		var serviceTax= $('#serviceTax').val(); 
		var flightcosttype= $('#flightcosttype').val();
		var visacosttype= $('#visacosttype').val();
		var passportcosttype= $('#passportcosttype').val();
		var insurancecosttype= $('#insurancecosttype').val();
		var fitincexNameId= $('#fitincexNameId').val();
		var gitincexNameId= $('#gitincexNameId').val();
		var overviewNameId= $('#overviewNameId').val();
		
		var dayroe = $('#dayroe').val(); 
		var asOnDate = $('#asOnDate').val(); 
		var curren = $('#curren').val();
		if(discount > 100 && discountType == 1){
			alert('Invalid Discount Value!.');
		}else{
			if(dayroe > 0 && curren > 0){
				startloading();
				$('#sendquationbtn').show();
				$('#pdfItineraryBtn').show();
				$('#markupdiv').show();
				$('#backbtn').show();
				
				$('#sendquationbtn').attr('href','showpage.crm?module=query&view=yes&id=<?php echo encode($quotationData['queryId']); ?>&quotationId=<?php echo encode($quotationId); ?>&curren='+encodeURI(curren)+'&quotation=1&viewQuotation='+encodeURI(viewQuotation));
				$('#showaddmarkup').show();
				addServiceTypeMarkup();
				$('#downquationbtnDoc').show(); 
				$('#CostsheetPreview').show();
				$('#HotelAvailability').show();
				$('#MakeFinal').show();
				
				$('#pageloading').hide();
				$('#pageloader').hide(); 
				
				// inclusion , exclusion,termscondition,cancelation,paymentpolicy,remarks
				var form_data = new FormData();
				form_data.append('action', 'saveQuotationDetails');
				form_data.append('quotationId', ('<?php echo encode($quotationId); ?>'));
				form_data.append('overviewText', encodeURIComponent(overviewText));
				form_data.append('itineraryintrText', encodeURIComponent(itineraryintrText));
				form_data.append('itinerarysummText', encodeURIComponent(itinerarysummText));
				form_data.append('itineraryintrText', encodeURIComponent(itineraryintrText));
				form_data.append('itinerarysummText', encodeURIComponent(itinerarysummText));
				form_data.append('highlightsText', encodeURIComponent(highlightsText));
				form_data.append('termsconditionText', encodeURIComponent(tncText));
				form_data.append('cancelationText', encodeURIComponent(specialText));
				form_data.append('inclusionText', encodeURIComponent(inclusionText));
				form_data.append('serviceupgradationText', encodeURIComponent(serviceupgradationText));
				form_data.append('optionaltourText', encodeURIComponent(optionaltourText));
				form_data.append('paymentpolicyText', encodeURIComponent(paymentpolicy));
				form_data.append('remarksText', encodeURIComponent(remarks));
				form_data.append('exclusionText', encodeURIComponent(exclusionText));
				form_data.append('isInc_exc', (isInc_exc));
				form_data.append('isSer_Mark', (isSer_Mark)); 
				form_data.append('languageType', (languageType));
				form_data.append('otherLocation', (otherLocation));
				form_data.append('otherLocationCost', (otherLocationCost));
				form_data.append('isOtherLocation', (isOtherLocation));
				form_data.append('isUni_Mark', (isUni_Mark));
				form_data.append('isSupp_TRR', (isSupp_TRR));
				form_data.append('markup', (markup));
				form_data.append('markupType', (markupType));
				form_data.append('discountType', (discountType));
				form_data.append('discount', (discount));
				form_data.append('curren', (curren));
				form_data.append('dayroe', (dayroe));
				form_data.append('asOnDate', (asOnDate));
				form_data.append('gstType', (gstType));
				form_data.append('serviceTax', (serviceTax));
				form_data.append('serviceTaxDivident', (serviceTaxDivident));
				form_data.append('priceSenValue', (priceSenValue));
				form_data.append('tcsTax', (tcsTax));
				form_data.append('viewQuotation', (viewQuotation));
				form_data.append('flightcosttype', (flightcosttype));
				form_data.append('visacosttype', (visacosttype));
				form_data.append('passportcosttype', (passportcosttype));
				form_data.append('insurancecosttype', (insurancecosttype));
				form_data.append('fitincexNameId', (fitincexNameId));
				form_data.append('gitincexNameId', (gitincexNameId));
				form_data.append('overviewNameId', (overviewNameId));

				form_data.append('costType', (costType));
	
				$.ajax({
					url: "inboundpop.php",
					type: "POST",
					data: form_data,
					contentType: false,
					cache: false,
					processData:false,  
					success: function(data) { 
						//$('#savemarkupBox').html(data);
					}
				});  
			} else{
				alert('ROE is Required.');
			} 
		}
	} 

	
	// function loadQuotationPreview(viewQuotation){
	// 	//git preview
	// 	var markup = $('#markup').val();
	// 	var markupType = $('#markupType').val();
	// 	var serviceTax= $('#serviceTax').val();
	// 	var flightcosttype= $('#flightcosttype').val();
		
	// 	var dayroe = $('#dayroe').val(); 
	// 	var curren = $('#curren').val();
	// 	if(serviceTax!=''){
	// 		$('#loadnewquotationfile').load('loadquotatoinpdf.php?id=<?php echo encode($quotationId); ?>&markup='+markup+'&curren='+curren+'&serviceTax='+serviceTax+'&markupType='+markupType+'&viewQuotation='+viewQuotation+'&quotation=2');
	// 	}	
	// }
	
	
	
	//getROE();
	// function getROE(){
	// 	var currencyId = $('#curren').val();
	 
	// 	$.ajax({
	// 		url: "loadcurrency.php",
	// 		type: "POST",
	// 		data: { 'action' : 'getROE_action', 'currencyId' : currencyId },			
	// 		dataType: 'json',
	// 		cache: false,
	// 		success: function(data) { 
	// 			// alert(dayroe);
	// 			$('#dayroe').val(data.dayroe);
	// 			$('#asOnDate').val(data.asOnDate);
	// 			$('#as_on_roe').text(data.asOnDate);
	// 		}
	// 	});	
	// }
				  
	//upload voucher
	// function upload_quotBanner(){  
	// 	//var file_data = $("#upload_quotBanner").prop('files')[0];
	// 	var name = document.getElementById("upload_quotBanner").files[0].name;
	// 	var form_data = new FormData();
	// 	var ext = name.split('.').pop().toLowerCase();
	// 	if(jQuery.inArray(ext, ['png','jpg','jpeg']) == -1)  {
	// 		alert("Invalid Image File");
	// 	} 
	// 	var oFReader = new FileReader();
	// 	oFReader.readAsDataURL(document.getElementById("upload_quotBanner").files[0]);
	// 	var f = document.getElementById("upload_quotBanner").files[0];
	// 	var fsize = f.size||f.fileSize;
	// 	if(fsize > 1000000) {
	// 		// 1 mb
	// 		alert("Image File Size is very big");
	// 	}
	// 	else{           
	// 		form_data.append('action', 'upload_quotBannerAction');
	// 		form_data.append('file', document.getElementById('upload_quotBanner').files[0]); 
	// 		form_data.append('quotationId', <?php echo ($quotationId); ?>);
	// 		//alert('test');
	// 		$.ajax({
	// 			url: "inboundpop.php",
	// 			type: "POST",
	// 			data: form_data,
	// 			contentType: false,
	// 			cache: false,
	// 			processData:false,  
	// 			success: function(data) { 
	// 				$('#savemarkupBox').html(data);
	// 			}
	// 		});
	// 	}
	// }
	
	// SAVE SERVICE TYPE MARKUP
	function addServiceTypeMarkup(){

		if($("#isUni_Mark").is(':checked')){
			var isUni_Mark = 1;
			var isSer_Mark = 0;
		}else if($("#isSer_Mark").is(':checked')){
			var isUni_Mark = 0;
			var isSer_Mark = 1;
		}else{
			var isUni_Mark = 1;
			var isSer_Mark = 0;
		}

		
		var markup = $('#uniMarkupInput').val();
		var markupType = $('#uniMarkupType').val();

		// markup
		if( isSer_Mark == 1){
			var serMarkup_package = $('#serMarkup_package').val();
			var packageMarkupType = $('#packageMarkupType').val();
			var serMarkup_hotel = $('#serMarkup_hotel').val();
			var hotelMarkupType = $('#hotelMarkupType').val();
			var serMarkup_guide = $('#serMarkup_guide').val();
			var guideMarkupType = $('#guideMarkupType').val();
			var serMarkup_activity = $('#serMarkup_activity').val();
			var activityMarkupType = $('#activityMarkupType').val();
			var serMarkup_entrance = $('#serMarkup_entrance').val();
			var entranceMarkupType = $('#entranceMarkupType').val();
			var serMarkup_transfer = $('#serMarkup_transfer').val();
			var transferMarkupType = $('#transferMarkupType').val();
			var ferryMarkupType = $('#ferryMarkupType').val();
			var serMarkup_ferry = $('#serMarkup_ferry').val();
			var cruiseMarkupType = $('#cruiseMarkupType').val();
			var serMarkup_cruise = $('#serMarkup_cruise').val();
			var serMarkup_train = $('#serMarkup_train').val();
			var trainMarkupType = $('#trainMarkupType').val();
			var serMarkup_flight = $('#serMarkup_flight').val();
			var flightMarkupType = $('#flightMarkupType').val();
			var serMarkup_restaurant = $('#serMarkup_restaurant').val();
			var restaurantMarkupType = $('#restaurantMarkupType').val();
			var serMarkup_visa = $('#serMarkup_visa').val();
			var serMarkup_passport = $('#serMarkup_passport').val();
			var serMarkup_insurance = $('#serMarkup_insurance').val();
			var visaMarkupType = $('#visaMarkupType').val();
			var passportMarkupType = $('#passportMarkupType').val();
			var insuranceMarkupType = $('#insuranceMarkupType').val();
			var serMarkup_other = $('#serMarkup_other').val(); 
			var otherMarkupType = $('#otherMarkupType').val(); 
		}else{
			var uniMarkupType = $('#uniMarkupType').val();
			var uniMarkupInput = $('#uniMarkupInput').val();
			if(uniMarkupInput==0 || uniMarkupInput==''){
				uniMarkupInput=0;
			}else{
				uniMarkupInput=uniMarkupInput;
			}
			var serMarkup_package = uniMarkupInput;
			var packageMarkupType = uniMarkupType;

			var serMarkup_hotel = uniMarkupInput;
			var hotelMarkupType = uniMarkupType;
			
			var serMarkup_guide = uniMarkupInput;
			var guideMarkupType = uniMarkupType;
			var serMarkup_activity = uniMarkupInput;
			var activityMarkupType = uniMarkupType;
			var serMarkup_entrance = uniMarkupInput;
			var entranceMarkupType = uniMarkupType;
			var serMarkup_transfer = uniMarkupInput;
			var transferMarkupType = uniMarkupType;
			var serMarkup_ferry = uniMarkupInput;
			var ferryMarkupType = uniMarkupType;
			var serMarkup_cruise = uniMarkupInput;
			var cruiseMarkupType = uniMarkupType;
			var serMarkup_train = uniMarkupInput;
			var trainMarkupType = uniMarkupType;
			var serMarkup_flight = uniMarkupInput;
			var flightMarkupType = uniMarkupType;
			var serMarkup_restaurant = uniMarkupInput;
			var restaurantMarkupType = uniMarkupType;
			var serMarkup_other = uniMarkupInput; 
			var otherMarkupType = uniMarkupType; 
			var serMarkup_visa = uniMarkupInput; 
			var visaMarkupType = uniMarkupType; 
			var serMarkup_passport = uniMarkupInput; 
			var passportMarkupType = uniMarkupType; 
			var serMarkup_insurance = uniMarkupInput; 
			var insuranceMarkupType = uniMarkupType; 
		
		}

		if( isSer_Mark == 1 || isUni_Mark == 1 ){
			startloading();
			$('#pageloading').hide();
			$('#pageloader').hide(); 
			//alert();
			var form_data1 = new FormData();
			form_data1.append('action', 'addServiceTypeMarkup');
			form_data1.append('isSer_Mark', isSer_Mark);
			form_data1.append('isUni_Mark', isUni_Mark);

			form_data1.append('markup', markup);
			form_data1.append('markupType', markupType);

			form_data1.append('quotationId','<?php echo encode($quotationId); ?>');

			form_data1.append('serMarkup_package', (serMarkup_package)); 
			form_data1.append('packageMarkupType', (packageMarkupType)); 

			form_data1.append('serMarkup_hotel', (serMarkup_hotel)); 
			form_data1.append('hotelMarkupType', (hotelMarkupType)); 

			form_data1.append('serMarkup_guide', (serMarkup_guide)); 
			form_data1.append('guideMarkupType', (guideMarkupType)); 
			form_data1.append('serMarkup_activity', (serMarkup_activity)); 
			form_data1.append('activityMarkupType', (activityMarkupType)); 
			form_data1.append('serMarkup_entrance', (serMarkup_entrance)); 
			form_data1.append('entranceMarkupType', (entranceMarkupType)); 
			form_data1.append('serMarkup_transfer', (serMarkup_transfer)); 
			form_data1.append('transferMarkupType', (transferMarkupType)); 
			form_data1.append('serMarkup_ferry', (serMarkup_ferry)); 
			form_data1.append('ferryMarkupType', (ferryMarkupType)); 
			form_data1.append('serMarkup_cruise', (serMarkup_cruise)); 
			form_data1.append('cruiseMarkupType', (cruiseMarkupType)); 
			form_data1.append('serMarkup_train', (serMarkup_train)); 
			form_data1.append('trainMarkupType', (trainMarkupType)); 
			form_data1.append('serMarkup_flight', (serMarkup_flight)); 
			form_data1.append('flightMarkupType', (flightMarkupType)); 
			form_data1.append('serMarkup_restaurant', (serMarkup_restaurant)); 
			form_data1.append('restaurantMarkupType', (restaurantMarkupType)); 
			form_data1.append('serMarkup_other', (serMarkup_other)); 
			form_data1.append('otherMarkupType', (otherMarkupType)); 
			form_data1.append('serMarkup_visa', (serMarkup_visa)); 
			form_data1.append('visaMarkupType', (visaMarkupType)); 
			form_data1.append('serMarkup_passport', (serMarkup_passport)); 
			form_data1.append('passportMarkupType', (passportMarkupType)); 
			form_data1.append('serMarkup_insurance', (serMarkup_insurance)); 
			form_data1.append('insuranceMarkupType', (insuranceMarkupType)); 

			$.ajax({
				url: "inboundpop.php",
				type: "POST",
				data: form_data1,
				contentType: false,
				cache: false,
				processData:false,  
				success: function(data) {  
				//$('#savemarkupBox').html(data);
				}
			});  
		}
	} 
//});

	<?php if ($hotelNotinclude == 1){ ?>			
	function multHotCatValidateionFun(){
		alert('Please select services.');
		return false;
	}
	<?php } ?> 
	function openclosetabs(id){
		$('#tbbody'+id).toggle();
	}
	 loadquotationmainfile();
	   
  jQuery(document).ready(function($){
		//called when key is pressed in textbox
 		$(".digit_only").keypress(function (e) {
			//if the letter is not digit then display error and don't type anything
			var digitValue = this.value;  
			if (e.which != 8 && e.which != 0 && ( e.which < 46 || e.which > 111) ) {
				//display error message
				$(this).css("border-color","red");
				alert('Value cannot be negative.'); 
				return false;
			} else{
				$(this).css("border-color","#2c343f");
			}
		}).on("blur",function(e){
		
			if(isNaN(this.value+""+String.fromCharCode(e.charCode)) && this.value < 0) {
				$(this).css("border-color","red");
 				alert('Markup cannot be zero or less than zero.');
				this.value = 5;
				return false; 
			}
		}).on("cut copy paste",function(e){
			e.preventDefault();
		}); 
	});
</script> 

<style type="text/css">
	.hoteldlt {
		position: absolute;
		right: 23px;
		top: -2px;
	}
	.hoteledit{
		position: absolute;
		right: 62px;
		top: -2px;
	}
	.hotelsave{
		position: absolute;
		right: 75px;
		top: 9px;
	}
	#mainquationboxload .gridtable td {
		min-width:70px;
	}
	.deleteBtn{
		font-size: 16px;
		color: red;  
		cursor: pointer; 
		padding: 5px 7px;
		border: 0px solid #ddd;
		border-radius: 2px;
		box-shadow: 2px 2px 7px -3px #006699;
	}

	.hotelbox{
		border: 1px solid #50ac35;
		border-radius: 4px;
		max-width: 300px;
		overflow: hidden;
		display: block;
		position: relative;
	}
	.buttonlists a{    padding: 2px 5px;
		float: right;
		margin-right: 10px;
		
		border: 1px solid #ddd;
		font-size: 11px;
		font-weight: 500;
		/*bg-eee,
		font-color:#5e5e5e
		*/
		color: #fff !important;
		background-color: #d88319; cursor:pointer;}
		
	.buttonlists{ 	
		float: right;
		position: absolute;
		right: 0px; 
		top: 10px;
	} 
	
	.editBtn{ 
		font-size: 16px!important;
		color: #006699; 
		cursor: pointer; 
		padding: 5px 7px;
		border: 0px solid #ddd;
		border-radius: 1px;
		box-shadow: -2px 3px 4px -3px black;
	} 
	.addBtn{ 
		font-size: 16px!important;
		color: #006699; 
		cursor: pointer; 
		padding: 5px 7px;
		border: 0px solid #ddd;
		border-radius: 1px;
		box-shadow: -2px 3px 4px -3px black;
	} 
	.saveBtn{
		font-size: 16px!important;
		color: #006699;
		cursor: pointer;
		float: right;
		display: flex;
		padding: 5px 7px;
		border: 0px solid #ddd;
		border-radius: 1px;
		box-shadow: -2px 3px 4px -3px black;
	}
	.gridtable td {
		padding: 6px 6px !important; 
	} 
	
	.editbtn{
		border: 1px solid;
		padding: 2px 4px;
		border-radius: 3px;
		background-color: #fff;  cursor:pointer;
	}
	.ui-sortable input{
		
	} 
	.hotelds .ui-sortable input{
		width: 80%;
		border: 1px solid #d5d5d5;
		padding: 2px 10px;
		width: 93%;
		min-width: 40px;
		background-color: #f8f8f8;
	}
	.trains .ui-sortable input{
		width: 85%;
		border: 1px solid #d5d5d5;
		padding: 2px 10px;
		width: 93%;
		min-width: 40px;
		background-color: #f8f8f8;
	}
	.selectbox {
		width: 100%;
		min-width: 80px;
		border-radius: 1px;
		padding: 2px 8px;
		background-color: #f8f8f8;
	}
	.incexc{
		display: inline-flex!important;
		width: 12px!important;
		height: 12px;
		margin: 0;
		min-width: 20px!important;
	}
	.lunch_dinner_included{ 
		display: inline-flex;
		background-color: #f4f4f4;
		padding: 0px 5px;
		margin-right: 160px;
		float: right;
	}

	.supplement_included{ 
		display: inline-flex;
		background-color: #f4f4f4;
		padding: 0px 5px;
		margin-right: -10px;
		float: right;
	}
	.supplement_included label, .supplement_included{
		font-size: 12px!important;
	}
	.lunch_dinner_included label, .lunch_dinner_included{
		font-size: 12px!important;
	}
	.tablesorter .ui-sortable tr:hover input{
		background-color: #FFFFFF !important;
	}
	.upload_quotBanner{
	    display: inline-block;
        width: 110px;
        text-align: center;
        height: 20px;
	}
	.bluembutton2 {
		margin-left: 0px;
		margin-right: 0px!important;
		font-weight: normal!important;
		background-color: white!important;
		color: #333333!important;
		border-bottom: 1px solid #ccc!important;
		border: 1px solid #ccc!important;
		font-size: 14px!important;
		padding: 7px 15px!important;
		cursor: pointer;
	}
	.file_hidden{
		opacity: 0;
		position: absolute;
		right: -2px;
		top: 0px;
		padding: 6px 15px !important;
		width: 100px;
	}

	.upload_quotBanner, .bluembutton{
		padding: 5px 8px!important;
    font-size: 20px!important;
    color: #FFFFFF!important;
    margin-right: 10px!important;
    background-color: #1a1919!important;
    border: 1px solid #7a96ff!important;
    border-bottom: 2px solid #fdbd0e!important;
    text-decoration: none!important;
    font-weight: 500!important;
    border-radius: 5px!important;
	}
	</style>
