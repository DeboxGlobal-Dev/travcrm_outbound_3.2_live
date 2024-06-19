
	 <?php  
	include "inc.php";
	$rs222=GetPageRecord('*','insuranceRateMaster','serviceid="'.$_REQUEST['serviceid'].'" order by fromDate asc'); 
	if(mysqli_num_rows($rs222) > 0){  
	?>
	
<div style=" padding:5px; border:1px solid #ddd; margin-bottom:10px;   position:relative; background-color:#FFFFFF;">   	
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable"> 
			<thead> 
			<tr>
                
			  <th width="16%" align="left" bgcolor="#ddd" >Validity </th>
			  <th width="10%" align="left" bgcolor="#ddd" >Name </th>
				<th width="10%" align="left" bgcolor="#ddd">Insurance Type</th>
				<th width="12%" align="left" bgcolor="#ddd">Supplier</th>
				<th width="8%" align="left" bgcolor="#ddd">TAX Slab</th>
				
				<th width="9%" align="left" bgcolor="#ddd">Adult Cost</th>
				
				<th width="9%" align="left" bgcolor="#ddd">Child Cost</th> 
			
				<th width="9%" align="left" bgcolor="#ddd">Infant Cost</th> 
				<th width="9%" align="left" bgcolor="#ddd">Markup Type</th> 
				<th width="9%" align="left" bgcolor="#ddd">Processing&nbsp;Fee</th> 
				<th width="9%" align="left" bgcolor="#ddd" >Status</th>
				<th width="12%" align="left" bgcolor="#ddd">&nbsp;</th>
			</tr>
			</thead> 
			<tbody> 
			<?php while($insuranceRateData=mysqli_fetch_array($rs222)){ 

                $rs2=GetPageRecord('name',_QUERY_CURRENCY_MASTER_,'id="'.$insuranceRateData['currencyId'].'"'); 
                $editresult2=mysqli_fetch_array($rs2); 
                $cur=clean($editresult2['name']); 
                
                ?>
			<tr>
			  <td align="left"><strong><?php echo date('d-m-Y',strtotime($insuranceRateData['fromDate'])); ?> - <?php echo date('d-m-Y',strtotime($insuranceRateData['toDate'])); ?></strong></td> 

              <td align="left"><?php echo $insuranceRateData['name'] ?></td>

              <td align="left"><?php  
					$rs11=GetPageRecord('*',_INSURANCE_TYPE_MASTER_,' id="'.$insuranceRateData['insuranceTypeId'].'"'); 
					$visaTypeData=mysqli_fetch_array($rs11); 
					echo addslashes($visaTypeData['name']);	
				?></td>

				<td align="left"><?php  
					$rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' id="'.$insuranceRateData['supplierId'].'"'); 
					$supplierData=mysqli_fetch_array($rs); 
					echo addslashes($supplierData['name']);	
				?></td>

                <td><?php echo getGstSlabById($insuranceRateData['gstTax']); ?></td>

				<td align="left"><?php echo $cur.' '.$insuranceRateData['adultCost']; ?></td>
				<td align="left"><?php echo $cur.' '.$insuranceRateData['childCost']; ?></td>
				<td align="left"><?php echo $cur.' '.$insuranceRateData['infantCost']; ?></td>
                <td align="left"><?php if($insuranceRateData['markupType']==1){ echo '%'; }else{ echo 'Flat'; } ?></td>
                <td align="left"><?php echo $cur.' '.$insuranceRateData['processingFee']; ?></td>

                <td align="left"><?php if($insuranceRateData['status']==1){echo 'Active'; } else { echo 'Inactive'; }  ?></td>
				
				<td align="center"><a onClick="alertspopupopen('action=editInsuranceRate&sectionId=<?php echo $insuranceRateData['id']; ?>&suppid=<?php echo $insuranceRateData['supplierId']; ?>','400px','auto');"><i class="fa fa-pencil" aria-hidden="true" style="font-size: 20px;"></i></a></td>
			</tr>  
			 <?php } ?>
		</tbody>
	  </table> 
  </div>
<?php  
}else{  
  echo "No Insurance Rate Found";
} ?>
</div> 