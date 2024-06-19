<?php
include "inc.php"; 
$rs2=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.($_REQUEST['quotationId']).'" '); 
$quotationData=mysqli_fetch_array($rs2); 

 	$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationData['id'].'" and queryId="'.$quotationData['queryId'].'" and serviceType="transportation" order by srn asc,id desc');
	if( mysqli_num_rows($b1)>0){		
	?>	
<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;"> 
	<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
		<thead>
		<tr>
		<th align="left" bgcolor="#ddd">Transportation&nbsp;Name</th> 
 		<th align="left" bgcolor="#ddd">Vehicle Type </th>
		<th align="left" bgcolor="#ddd">Vehicle Cost</th> 
		<th align="right" bgcolor="#ddd">&nbsp;</th>
		</tr>
		</thead>
		<tbody class="ui-sortable">
		<?php 
 		$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationData['id'].'" and queryId="'.$quotationData['queryId'].'" and serviceType="transportation" order by srn asc,id desc');
		if( mysqli_num_rows($b1) == 1 ){
			$quoteQuery = 'isTransport=1';
			$edit = updatelisting(_QUOTATION_MASTER_,$quoteQuery,'id="'.($_REQUEST['quotationId']).'"');
		}
 		while($sorting1=mysqli_fetch_array($b1)){ 
			
			$c=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$sorting1['quotationId'].'" and id="'.$sorting1['serviceId'].'"'); 
			$resListing=mysqli_fetch_array($c);
			// hotel data
			$d=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$resListing['transferNameId'].'"');   
			$transferData1=mysqli_fetch_array($d); 
			if($resListing['transferName'] == '' || strlen($resListing['transferName']) < 1){
				$transferName =  $transferData1['transferName'];
			}else{
				$transferName =  $resListing['transferName'];
			}
			  
			$select2='carType,model';  
			$where2=' id="'.$resListing['vehicleModelId'].'"'; 
			$rs2=GetPageRecord($select2,_VEHICLE_MASTER_MASTER_,$where2); 
			$editresult2=mysqli_fetch_array($rs2);
		?> 
		<tr id="tpt<?php echo $resListing['id'];?>">
		<td align="left">
			<div id="transportNameIdText<?php echo ($resListing['id']); ?>">
			<?php echo trim($transferName); ?>
			</div>
			<div id="transportNameId<?php echo ($resListing['id']); ?>" style="display:none;">
			<input type="text" id="transportNameIdInput<?php echo ($resListing['id']); ?>"  value="<?php echo strip($transferName); ?>">
			</div>	 
		</td>
		 
		<td align="left">
			<div id="transportvehicleModelIdText<?php echo ($resListing['id']); ?>">
			<?php echo $editresult2['model']; ?>					
			</div>
			<div id="transportvehicleModelId<?php echo ($resListing['id']); ?>" style="display:none;">
			<select id="transportvehicleModelIdInput<?php echo ($resListing['id']); ?>"  class="selectbox">
				<option value="">Select Model</option> 
				<?php 
				$select='*';    
				$where=' 1  order by id asc';  
				$rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where); 
				while($resListing2=mysqli_fetch_array($rs)){  
				?>
					<option value="<?php echo $resListing2['id']; ?>" <?php if($resListing2['id'] == $resListing['vehicleModelId']){ ?> selected="selected" <?php } ?>><?php echo $resListing2['model']; ?></option>
				<?php } ?>
			</select> 
			</div> 
		</td>
		<td align="left">
		<div id="transportvehicleCostText<?php echo ($resListing['id']); ?>"><?php echo  strip($resListing['vehicleCost']); ?></div>
		<div id="transportvehicleCost<?php echo ($resListing['id']); ?>" style="display:none;">
		<input type="text" id="transportvehicleCostInput<?php echo ($resListing['id']); ?>"  value="<?php echo  strip($resListing['vehicleCost']); ?>">
		</div> 
		</td>
		<td align="right">
			<div class="deleteBtn" style="display: inline-flex;" onclick="if(confirm('Are you sure you want delete this transfer?')) deleteBrochureTransport('<?php echo $resListing['id'];?>','deleteTransport'); $('#tpt<?php echo $resListing['id'];?>').remove();"><i class="fa fa-trash" aria-hidden="true"></i></div>
			
			<div class="editBtn" id="transporteditBtn<?php echo $resListing['id'];?>" style="display: inline-flex;" onclick="editBrochureTransport('<?php echo $resListing['id'];?>','editQuotationTransfer');"><i class="fa fa-pencil" aria-hidden="true"></i></div>	
			
			<div class="saveBtn" id="transportsaveBtn<?php echo ($resListing['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveBrochureTransport('<?php echo $resListing['id'];?>','saveQuotationTransfer');"><i class="fa fa-save" aria-hidden="true"></i></div>
		</td>
		</tr>  
		<?php } ?>		
		
	</tbody>
	</table>
	
	
</div>
<?php } ?>