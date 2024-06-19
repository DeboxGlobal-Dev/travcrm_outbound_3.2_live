
	 <?php  
include "inc.php";
	$rs222=GetPageRecord('*','visaRateMaster','serviceid="'.$_REQUEST['serviceid'].'" order by fromDate asc'); 
	if(mysqli_num_rows($rs222) > 0){  
	?>
	
<div style=" padding:5px; border:1px solid #ddd; margin-bottom:10px;   position:relative; background-color:#FFFFFF;">   	
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable"> 
			<thead> 
			<tr>
                
			  <th width="16%" align="left" bgcolor="#ddd" >Validity </th>
			  <th width="10%" align="left" bgcolor="#ddd" >Country </th>
			  <!-- <th width="10%" align="left" bgcolor="#ddd" >Name </th> -->
				<th width="10%" align="left" bgcolor="#ddd">Visa Type</th>
				<th width="10%" align="left" bgcolor="#ddd">Entry Type</th>
				<th width="10%" align="left" bgcolor="#ddd">Validity</th>
				<th width="12%" align="left" bgcolor="#ddd">Supplier</th>
				<th width="8%" align="left" bgcolor="#ddd">TAX Slab</th>
				
				<th width="9%" align="left" bgcolor="#ddd">Adult Cost</th>
				
				<th width="9%" align="left" bgcolor="#ddd">Child Cost</th> 
			
				<th width="9%" align="left" bgcolor="#ddd">Infant Cost</th> 
				<th width="9%" align="left" bgcolor="#ddd">Markup Type</th> 
				<th width="9%" align="left" bgcolor="#ddd">Processing&nbsp;Fee</th> 
				<th width="9%" align="left" bgcolor="#ddd">Embassy&nbsp;Fee</th> 
				<th width="9%" align="left" bgcolor="#ddd">VFS&nbsp;Charges</th> 
				<th width="9%" align="left" bgcolor="#ddd" >Status</th>
				<th width="12%" align="left" bgcolor="#ddd">&nbsp;</th>
			</tr>
			</thead> 
			<tbody> 
			<?php while($visaRateData=mysqli_fetch_array($rs222)){ 

			$countryQuery=GetPageRecord('*','countryMaster','id="'.$visaRateData['countryId'].'"');
			$countryData=mysqli_fetch_array($countryQuery);

                $rs2=GetPageRecord('name',_QUERY_CURRENCY_MASTER_,'id="'.$visaRateData['currencyId'].'"'); 
                $editresult2=mysqli_fetch_array($rs2); 
                $cur=clean($editresult2['name']); 
                
                ?>
			<tr>
			  <td align="left"><strong><?php echo date('d-m-Y',strtotime($visaRateData['fromDate'])); ?> - <?php echo date('d-m-Y',strtotime($visaRateData['toDate'])); ?></strong></td> 

			  <td align="left"><?php echo $countryData['name']; ?></td>


			  <!-- <td align="left"><?php echo $visaRateData['name'] ?></td> -->

              

              <td align="left"><?php  
					$rs11=GetPageRecord('*','visaTypeMaster',' id="'.$visaRateData['visaTypeId'].'"'); 
					$visaTypeData=mysqli_fetch_array($rs11); 
					echo addslashes($visaTypeData['name']);	
				?></td>

				<td>
					<?php 
					if($visaRateData['entryType']==1){
						echo 'Single Entry';
					}else{
						echo 'Multiple Entry';
					}				
				?>
				</td>

				<td align="left"><?php echo $visaRateData['validity'] ?></td>
				

				<td align="left"><?php  
					$rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' id="'.$visaRateData['supplierId'].'"'); 
					$supplierData=mysqli_fetch_array($rs); 
					echo addslashes($supplierData['name']);	
				?></td>

				<td><?php echo getGstSlabById($visaRateData['gstTax']); ?></td>

                

				<td align="left"><?php echo $cur.' '.$visaRateData['adultCost']; ?></td>
				<td align="left"><?php echo $cur.' '.$visaRateData['childCost']; ?></td>
				<td align="left"><?php echo $cur.' '.$visaRateData['infantCost']; ?></td>
                <td align="left"><?php if($visaRateData['markupType']==1){ echo '%'; }else{ echo 'Flat'; } ?></td>
                <td align="left"><?php echo $cur.' '.$visaRateData['processingFee']; ?></td>
                <td align="left"><?php echo $cur.' '.$visaRateData['embassyFee']; ?></td>
                <td align="left"><?php echo $cur.' '.$visaRateData['vfsCharges']; ?></td>

                <td align="left"><?php if($visaRateData['status']==1){echo 'Active'; } else { echo 'Inactive'; }  ?></td>
				
				<td align="center"><a onClick="alertspopupopen('action=editVisaRate&sectionId=<?php echo $visaRateData['id']; ?>&suppid=<?php echo $visaRateData['supplierId']; ?>','400px','auto');"><i class="fa fa-pencil" aria-hidden="true" style="font-size: 20px;"></i></a></td>
			</tr>  
			 <?php } ?>
		</tbody>
	  </table> 
  </div>
<?php  
}else{  
  echo "No VISA Rate Found";
} ?>
</div> 