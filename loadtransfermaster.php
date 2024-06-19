<?php
include "inc.php";  
if($_REQUEST['serviceid']!=''){  
	$aaaaaa=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$_REQUEST['serviceid'].'"'); 
	$transferData=mysqli_fetch_array($aaaaaa);
}

$select=''; 
$where=''; 
$rs='';  
$select='transferType,id,supplierId';    
$where='  serviceid="'.$_REQUEST['serviceid'].'" group by transferType order by transferType asc';  
$rs=GetPageRecord($select,_DMC_TRANSFER_RATE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
	?>
	<div class="topaboxlist"> 
	<?php  
	$select222=''; 
	$where222=''; 
	$rs222='';  
	$select222='*';    
	$where222=' id='.$_REQUEST['serviceid'].' order by transferName asc';  
	$rs222=GetPageRecord($select222,_PACKAGE_BUILDER_TRANSFER_MASTER,$where222); 
	$resListing222=mysqli_fetch_array($rs222); 

	$n=0;
	$select23=''; 
	$where23=''; 
	$rs23='';  
	$select23='*';    
	$where23='transferType="'.$resListing['transferType'].'" and serviceid="'.$_REQUEST['serviceid'].'" group by fromDate,toDate,supplierId order by fromDate asc';
	$rs23=GetPageRecord($select23,_DMC_TRANSFER_RATE_MASTER_,$where23); 
	while($PriceresListing=mysqli_fetch_array($rs23)){

		++$n; 

		$rs1=GetPageRecord('name',_SUPPLIERS_MASTER_,'id="'.($PriceresListing['supplierId']).'"'); 
		$editresult=mysqli_fetch_array($rs1); 

		?>
		<div style="margin-bottom:20px; font-size:25px; <?php if($n==2){ ?> margin-top:20px; <?php } ?>"><table border="0" cellpadding="0" cellspacing="0">
		<tr><td style="padding-right:15px;"><img src="images/<?php if($resListing['transferType']==1){ echo 'dmcbusicon.png'; } if($resListing['transferType']==2){ echo 'dmccaricon.png'; } ?>" /></td>
		<td colspan="2" align="left">Supplier - <?php echo clean($editresult['name']);  ?></td> 
		</tr>

		</table>
		</div>
		<div class="roompricelistmain">
		<div class="headermainprice"><span style="color: #909090;">Validity Date:</span> <?php echo date('d-m-Y', strtotime($PriceresListing['fromDate'])); ?> - <?php echo date('d-m-Y', strtotime($PriceresListing['toDate']));; ?></div>
	 
		<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#f7f7f7" class="tablesorter gridtable"> 
		<thead> 
		<tr>
		<td width="6%" align="left" bgcolor="#f7f7f7"><strong>SupplierBookingCode</strong></td>
		<td width="6%" align="left" bgcolor="#f7f7f7"><strong>Tarif&nbsp;Type</strong></td>
		<td width="6%" align="left" bgcolor="#f7f7f7"><strong>Destination</strong></td>
		<!-- <td width="6%" align="left" bgcolor="#f7f7f7"><strong>Market&nbsp;Type</strong></td> -->
		<td width="5%" align="center" bgcolor="#f7f7f7"><strong>TAX&nbsp;(%)</strong></td>
		<?php if($PriceresListing['transferType']=='1'){  ?>
		<td width="5%" align="center" bgcolor="#f7f7f7"><strong>Adult&nbsp;Cost</strong></td>
		<td width="5%" align="center" bgcolor="#f7f7f7"><strong>Child&nbsp;Cost</strong></td>
		<td width="5%" align="center" bgcolor="#f7f7f7"><strong>Infant&nbsp;Cost</strong></td>
		<?php }else{ ?>
		<td width="7%" align="left" bgcolor="#f7f7f7"><strong>Vehicle&nbsp;Type</strong></td>
		<td width="5%" align="center" bgcolor="#f7f7f7"><strong>Vehicle&nbsp;Cost</strong></td>
		<td width="4%" align="center" bgcolor="#f7f7f7"><strong>Parking</strong></td>
		<td width="5%" align="center" bgcolor="#f7f7f7"><strong>Assistance</strong></td>
		<td width="7%" align="center" bgcolor="#f7f7f7"><strong>Additional&nbsp;Allowance</strong></td>
		<td width="7%" align="center" bgcolor="#f7f7f7"><strong>InterState&nbsp;&&nbsp;Toll</strong></td>
		<td width="7%" align="center" bgcolor="#f7f7f7"><strong>Misc.&nbsp;Cost</strong></td>
		<?php } ?>
		<td width="10%" align="center" bgcolor="#f7f7f7"><strong>Rep.&nbsp;Fee</strong></td>
		<td width="10%" align="center" bgcolor="#f7f7f7"><strong>Tax&nbsp;Slab</strong></td>
		<td width="10%" align="center" bgcolor="#f7f7f7"><strong>Markup</strong></td>
		<td width="3%" align="center" bgcolor="#f7f7f7"><strong>Status</strong></td>
		<td width="16%" align="center" bgcolor="#f7f7f7"><strong>Action</strong></td>
		</tr>
		</thead>
		<tbody>
		<?php
		$select22=''; 
		$wher22=''; 
		$rs22='';  
		$select22='*';    
		$where22=' fromDate="'.$PriceresListing['fromDate'].'" and transferType='.$PriceresListing['transferType'].' and supplierId='.$PriceresListing['supplierId'].' and transferNameId='.$_REQUEST['serviceid'].' order by id asc';  
		$rs22=GetPageRecord($select22,_DMC_TRANSFER_RATE_MASTER_,$where22); 
		while($dmcroommastermain=mysqli_fetch_array($rs22)){
 
		?> 
		<tr>
    	<td align="left"><?php echo trim($dmcroommastermain['suppBookCode']);?></td> 
		<td align="left"><?php if($dmcroommastermain['tarifType']==2){ echo 'Weekend'; }else{ echo 'Normal'; } ?></td>
		<td align="left">
			<?php 
			if($dmcroommastermain['rateDestinationId']!=0){ echo getDestination($dmcroommastermain['rateDestinationId']); }else{ echo 'All'; } 
			?>
		</td>
		<!-- <td align="left"><?php if($dmcroommastermain['marketType']>0){ echo getMarketType($dmcroommastermain['marketType']); }else{ echo '_'; } ?></td> -->
		<td align="center"><?php echo getGstValueById($dmcroommastermain['gstTax']); ?>%</td>

		<?php if($PriceresListing['transferType']=='1'){  ?>
		<td align="center"><?php echo $cur.'&nbsp;'.strip($dmcroommastermain['adultCost']); ?></td>
		<td align="center"><?php echo $cur.'&nbsp;'.strip($dmcroommastermain['childCost']); ?></td>
		<td align="center"><?php echo $cur.'&nbsp;'.strip($dmcroommastermain['infantCost']); ?></td>
		<?php }else{ ?>
		<td align="left"><?php 
		// $select2='name';  
		// $where2='id='.$dmcroommastermain['currencyId'].''; 
		// $rs2=GetPageRecord($select2,_QUERY_CURRENCY_MASTER_,$where2); 
		// $editresult2=mysqli_fetch_array($rs2); 
		// $cur=clean($editresult2['name']); 
		echo getVehicleTypeName($dmcroommastermain['vehicleTypeId']); 
		?>
		<!-- &nbsp;(&nbsp;<?php echo $vehicleDetails['model']; ?>&nbsp;) -->
		</td>
		<td align="center"><?php echo $cur.'&nbsp;'.strip($dmcroommastermain['vehicleCost']); ?></td>
		<td align="center"><?php echo $cur.'&nbsp;'.strip($dmcroommastermain['parkingFee']); ?></td>
		<td align="center"><?php echo $cur.'&nbsp;'.strip($dmcroommastermain['assistance']); ?></td>
		<td align="center"><?php echo $cur.'&nbsp;'.strip($dmcroommastermain['guideAllowance']); ?></td>
		<td align="center"><?php echo $cur.'&nbsp;'.strip($dmcroommastermain['interStateAndToll']); ?></td>
		<td align="center"><?php echo $cur.'&nbsp;'.strip($dmcroommastermain['miscellaneous']); ?></td>
		<?php } ?>
		<td align="center"><?php echo $cur.'&nbsp;'.strip($dmcroommastermain['representativeEntryFee']); ?></td>
		<td align="center"><?php echo getGstSlabById($dmcroommastermain['gstTax']); ?></td>  
		<td align="center"><?php echo $dmcroommastermain['markupCost']; echo ($dmcroommastermain['markupType']==1)?'%':'Flat'; ?></td>  
		
		<td align="center"><?php if($dmcroommastermain['status']==1){echo 'Active'; } else { echo 'In Active'; }  ?></td>
		<td align="center"><a onClick="alertspopupopen('action=editdmctransferrate&sectionId=<?php echo $dmcroommastermain['id']; ?>&suppid=<?php echo $_REQUEST['id']; ?>','1200px','auto');"><i class="fa fa-pencil" aria-hidden="true" style="font-size: 15px;padding: 5px 10px;border-radius: 5px;cursor:pointer;" ></i></a>
		<!-- <a onclick="deleteTransferRatesfun<?php echo $dmcroommastermain['id']; ?>();"><i class="fa fa-trash-o" aria-hidden="true" style="font-size: 15px;color: #ff0000;padding: 5px 10px;border-radius: 5px;cursor:pointer;" ></i></a> -->
		</td>
		</tr>  
		<script>			
		function deleteTransferRatesfun<?php echo $dmcroommastermain['id']; ?>(){
		if(confirm('Are you sure want to delete?')){ $('#deleteTransferRates<?php echo $dmcroommastermain['id']; ?>').load('frmaction.php?action=deleteTransferRates&delId=<?php echo $dmcroommastermain['id']; ?>');}else{ return false; }
		}
		</script>
		<div id="deleteTransferRates<?php echo $dmcroommastermain['id']; ?>"></div>
		<?php  } ?>
		</tbody></table>

		</div>
		<?php 
	} ?>
	</div>
	<?php 
} ?>

<style>
.SIC{display:none;}
/*.PVT{display:none;}*/
</style>