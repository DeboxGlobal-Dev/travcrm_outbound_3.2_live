	<?php
	include "inc.php"; 
	// include "config/logincheck.php";
	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.trim($_REQUEST['dayId']).'"');
	$dayData = mysqli_fetch_array($dayQuery);

	$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$dayData['quotationId'].'"');
	$quotationData=mysqli_fetch_array($rs1);
	$pax = $quotationData['adult']+$quotationData['child'];

	$cityId = trim($_REQUEST['destinationId']);
	$activityName = trim($_REQUEST['activityName']);
	$defaultWise = trim($_REQUEST['defaultWise']);
	$destinationId = getDestination(trim($_REQUEST['destinationId']));
	//get dest name above

	$queryId = $dayData['queryId'];
	$quotationId = $dayData['quotationId'];
	$dayId=$dayData['id'];
	$fromDate=date("Y-m-d", strtotime($dayData['srdate']));
	$fromYear=date("Y", strtotime($fromDate));
	$toDate=date("Y-m-d", strtotime($fromDate));
	$toYear=date("Y", strtotime($fromDate));

	$marketTypeId = getQueryMaketType($queryId);
	$whereMarket = '  and marketType=1';
	if($marketTypeId>0){
		$whereMarket = ' and marketType="'.$marketTypeId.'"';
	}

	if($defaultWise == 2){
	$isDefault = '';
    }
    if($defaultWise == 1){
	$isDefault = ' and isDefault=1';
   }


	$whereDate = " and '".$fromDate."' BETWEEN fromDate and toDate ";
	$whereSupp = " and supplierId in ( select id from suppliersMaster where 1 and ( activityType=3 or activityType=1 ) and deletestatus=0 )";
	
	?>
	<div style="font-size:16px; padding:10px;position:relative" >
		<span id="activitycounding" > 0 Monument Found </span>
		<div class="addBtn1"  onclick="openinboundpop('action=addactivitiestomaster&dayId=<?php echo $dayId; ?>&cityId=<?php echo $cityId; ?>','800px');">+&nbsp;Add New</div>
    </div>
    <div style="padding:10px; border:1px #e3e3e3 solid; background-color: #fff; margin-bottom:10px;" id="sicbox">	
	    <div class="topaboxlist"  style="max-height: 300px;overflow: auto;">
			<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#E6E6E6" class="tablesorter gridtable" id="entrancesicTable">
				<thead>
				<tr style="border: 1px solid #fff;
    border-bottom: 1px solid #E6E6E6;">
					<th align="left">&nbsp;&nbsp;Name</th>	
					<th align="center">Supplier</th>
					<th align="center"> SightSeeing&nbsp;Cost </th>
					<th align="center"> Pax&nbsp;Range</th> 
					<th align="center"> PerPax&nbsp;Cost</th> 
					<th align="center">&nbsp;</th>
				</tr>
				</thead>  
				<tbody>
				<?php
				$c1=1;
				$where='';
				$rs=''; 
				$where=' otherActivityCity = "'.getDestination($_REQUEST['destinationId']).'" '.$isDefault.' and otherActivityName LIKE "%'.$activityName.'%" and status=1 order by otherActivityName asc'; 
				$rsw=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,$where);
				while($resListing=mysqli_fetch_array($rsw)){
					$otherActivityId = $resListing['id'];
 					//$rs121=GetPageRecord('id',_QUOTATION_OTHER_ACTIVITY_MASTER_,'otherActivityName="'.$resListing['id'].'" and quotationId="'.$quotationData['id'].'"');	
					//$isAlreadyAdded=mysqli_num_rows($rs121);						
					//if($isAlreadyAdded == 0){
					// and maxpax <= "'.$pax.'"
					$where1=' otherActivityNameId = "'.$resListing['id'].'" and supplierId>0  '.$whereMarket.' '.$whereSupp.' '.$whereDate.'  and status=1 order by maxpax asc'; 
					$rs11=GetPageRecord('*','dmcotherActivityRate',$where1);
					if(mysqli_num_rows($rs11)>0){
					while($dmcroommastermain=mysqli_fetch_array($rs11)){ 
					?>
 					<tr> 
					<td align="left"><?php echo strip($resListing['otherActivityName']); ?></td>
					<td align="center"><?php echo getsupplierCompany($dmcroommastermain['supplierId']); ?> - (&nbsp;<?php echo getMaketTypeName($queryId); ?>&nbsp;)</td>
					<td align="center"><?php echo  getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.strip($dmcroommastermain['activityCost']); ?></td>
					<td align="center">Upto&nbsp;<?php echo strip($dmcroommastermain['maxpax']); ?>&nbsp;Pax</td>
					<td align="center"><?php echo getCurrencyName($dmcroommastermain['currencyId']).'&nbsp;'.strip($dmcroommastermain['perPaxCost']); ?></td>
						<?php  
		            $rs21=GetPageRecord('*','hoteloperationRestriction',' otheractivityId="'.$otherActivityId.'" and ( "'.$fromDate.'" BETWEEN startDate and endDate or startDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" )'); 
		            ?>
		           	<td align="center" valign="middle">
					
		           	 <?php 
        			$msgOpr = '';
        			if(mysqli_num_rows($rs21) > 0){ 
        			$oprResData=mysqli_fetch_array($rs21);
        			$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));
        			?> <div style="width: fit-content !important; padding: 8px !important;" class="editbtnselect"  onclick="if(confirm('<?php echo strip($resListing['otherActivityName']); ?> - SightSeeing restriction! \nReason:&nbsp;<?php echo strip($oprResData['reason']); ?> \nPeriod:<?php echo strip($period); ?> \nDo you still want to select?')){ addactivitytoquotationsNull('<?php echo urlencode($resListing['id']); ?>');selectthis(this); }; " ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
        			
        			<?php } else { ?>  
        			<div style="width: fit-content !important; padding: 8px !important;" class="editbtnselect"onclick="addactivitytoquotations('<?php echo urlencode($dmcroommastermain['id']); ?>','<?php echo urlencode($dmcroommastermain['activityCost']); ?>','<?php echo urlencode($dmcroommastermain['maxpax']); ?>','<?php echo urlencode($dmcroommastermain['perPaxCost']); ?>','<?php echo urlencode($dmcroommastermain['currencyId']); ?>');selectthis(this);"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div> 
        		
        			<?php  } ?></td> 
				</tr>
				<?php } }else{ ?>
				    <tr> 
						<td align="left"><?php echo strip($resListing['otherActivityName']); ?></td>
						<td><select style="width:150px;text-align:left;" id="supplierIdSearchPage<?php echo urlencode($resListing['id']); ?>" name="supplierIdSearchPage" class="newbox" displayname="Supplier" autocomplete="off" > <option value="">Select Supplier</option>
						<?php     
						$rs1a=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and name!="" and activityType=3  order by name asc'); 
						while($supplierData=mysqli_fetch_array($rs1a)){   
						?>
						<option value="<?php echo strip($supplierData['id']); ?>" ><?php echo strip($supplierData['name']); ?></option>
						<?php } ?>
						</select></td>
						<td align="center">INR&nbsp;
					      <input style="width:55px" name="activityCostSearchPage" type="text" class="newbox numeric " id="activityCostSearchPage<?php echo urlencode($resListing['id']); ?>" value="0" onkeyup="getPerPaxCostSearchPage<?php echo urlencode($resListing['id']); ?>();" /></td>
						<td align="center"><div>Upto&nbsp;<input name="maxPaxSearchPage" type="text" class="newbox numeric " id="maxPaxSearchPage<?php echo urlencode($resListing['id']); ?>" value="1" onkeyup="getPerPaxCostSearchPage<?php echo urlencode($resListing['id']); ?>();" style="width:30px;"/>&nbsp;Pax</div></td>
						<td align="center">INR&nbsp;
					  <input style="width:55px" name="perPaxCostSearchPage" type="text" class="newbox numeric " readonly="" id="perPaxCostSearchPage<?php echo urlencode($resListing['id']); ?>" value="0" /></td> 
						<td align="center" valign="middle">
						<?php  
		           		 $rs21=GetPageRecord('*','hoteloperationRestriction',' otheractivityId="'.$otherActivityId.'" and ( "'.$fromDate.'" BETWEEN startDate and endDate or startDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" )'); 
		            
						$msgOpr = '';
						if(mysqli_num_rows($rs21) > 0){ 
						$oprResData=mysqli_fetch_array($rs21);
						$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));
						?> <div style="width: fit-content !important; padding: 8px !important;" class="editbtnselect" onclick="if(confirm('<?php echo strip($resListing['otherActivityName']); ?> - SightSeeing restriction! \nReason:&nbsp;<?php echo strip($oprResData['reason']); ?> \nPeriod:<?php echo strip($period); ?> \nDo you still want to select?')){ addactivitytoquotationsNull('<?php echo urlencode($resListing['id']); ?>');selectthis(this); }; " ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
						
						<?php } else { ?>  
						<div style="width: fit-content !important; padding: 8px !important;" class="editbtnselect" onclick="addactivitytoquotationsNull('<?php echo urlencode($resListing['id']); ?>');selectthis(this);"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
					
						<?php  } ?>
						</td> 

					</tr>
					<script>
    				function getPerPaxCostSearchPage<?php echo urlencode($resListing['id']); ?>(){ 
    				    
        				var activityCost = $('#activityCostSearchPage<?php echo urlencode($resListing['id']); ?>').val();
        				var maxpax = $('#maxPaxSearchPage<?php echo urlencode($resListing['id']); ?>').val();  
        				var ppCost = Math.round(activityCost/maxpax);
         				if(ppCost == 'NaN' || ppCost== Infinity){
        			    	$('#perPaxCostSearchPage<?php echo urlencode($resListing['id']); ?>').val(activityCost);
        				}else{
        			    	$('#perPaxCostSearchPage<?php echo urlencode($resListing['id']); ?>').val(ppCost);
        				}
        			 
    				
    				}
				</script>
				 <?php }  $c1++; }?>
				<tr ><td colspan="6"> 

	 				<div style="text-align:end;">   <button class="whitembutton" onClick="window.location.reload();">close</button></div>

	 			</td>
 			</tr>
 		</tbody>
</table>
</div>
<?php if($c1==1){ ?>
<script>
$('#sicbox').hide();
</script>
<?php } ?>

<?php if($c1==1 ){ ?>
<script>
$('#sicbox').append('<div style="text-align:center;">No SightSeeing Found</div>');
</script>
<?php } ?>
</div>
<script>
$('#activitycounding').text('<?php echo $c1-1;?> SightSeeing Found');
</script>
 <style>
	.editbtnselect2{    border: 1px solid;
    padding: 8px 15px;
    text-align: center;
    font-size: 13px;
    border-radius: 3px;
    background-color: #4caf50;
    cursor: pointer;
    color: #fff;}
	</style>