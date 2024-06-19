
<?php

include "inc.php";


$rsel1=GetPageRecord('*','cruiseRateMaster','serviceId="'.$_REQUEST['serviceId'].'"  order by id desc');
if(mysqli_num_rows($rsel1)>0){
?>
<div style=" padding:5px; border:1px solid #ddd; margin-bottom:10px;   position:relative; background-color:#FFFFFF;">
<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
<thead>
<tr>
<th width="14%" align="left" bgcolor="#ddd" >Validity </th>
<th width="" align="left" bgcolor="#ddd" >Cruise&nbsp;Name</th>
<th width="" align="left" bgcolor="#ddd" >Cabin&nbsp;Type</th>
<th width="" align="left" bgcolor="#ddd">Supplier</th>
<th width="5%" align="left" bgcolor="#ddd">Duration&nbsp;</th>
<!-- <th width="10%" align="left" bgcolor="#ddd">Tariff&nbsp;Type</th> -->
<th width="" align="left" bgcolor="#ddd" >GST</th>
<th width="" align="left" bgcolor="#ddd">Adult&nbsp;Cost</th>
<th width="" align="left" bgcolor="#ddd" >Child&nbsp;Cost</th>
<th width="" align="left" bgcolor="#ddd" >Infant&nbsp;Cost</th>
<!-- <th width="" align="left" bgcolor="#ddd" >Markup&nbsp;Type</th>
<th width="" align="left" bgcolor="#ddd" >Markup&nbsp;Value</th> -->
<!-- <th width="" align="left" bgcolor="#ddd" >Remarks&nbsp;</th> -->
<th style="min-width:50px;" align="center" bgcolor="#ddd" >&nbsp;#</th>
</tr>
</thead>
<tbody>
<?php 
while($cruiseRates = mysqli_fetch_assoc($rsel1)){  ?>
<tr>
<td align="left"><strong><?php echo date('d-m-Y',strtotime($cruiseRates['fromDate'])); ?> - <?php echo date('d-m-Y',strtotime($cruiseRates['toDate'])); ?></strong></td>
<td align="left">
	<?php
	$crRs=GetPageRecord('*','cruiseNameMaster', 'id="'.$cruiseRates['cruiseNameId'].'"');
	$CrDD=mysqli_fetch_array($crRs);
	echo $CrDD['name'];
	?>
</td>
<td align="left">
	<?php
	$FerryClassN=GetPageRecord('*','cabinTypeMaster', 'id="'.$cruiseRates['cabinTypeId'].'"');
	$ferryClassName=mysqli_fetch_array($FerryClassN);
	echo $ferryClassName['name'];
	?>
</td>
<td align="left"><?php
	$rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' id="'.$cruiseRates['supplierId'].'"');
	$supplierData=mysqli_fetch_array($rs);
	echo addslashes($supplierData['name']);
?></td>
<td align="left"><?php echo $cruiseRates['duration']; ?></td>
<!-- <td align="left"><?php //if($cruiseRates['tariffType']==1){ echo 'Normal'; }else{ echo 'Weekend'; } ?></td> -->

<td align="left"><?php echo getGstValueById($cruiseRates['gstTax']).'%'; ?></td>
<td align="left"><?php echo $cur.' '.strip($cruiseRates['adultCost']); ?></td>
<td align="left"><?php echo $cur.' '.strip($cruiseRates['childCost']); ?></td>
<td align="left"><?php echo $cur.' '.strip($cruiseRates['infantCost']); ?></td>
<!-- <td align="left"><?php //echo (strip($cruiseRates['markupType']==1))? '%': 'Flat'; ?></td> -->
<!-- <td align="left"><?php //echo ($cruiseRates['markupType']==1)? strip($cruiseRates['markupCost']).'%': $cur.' '.strip($cruiseRates['markupCost']); ?></td> -->

<td width="8%" align="center" style="min-width:50px;"><a onClick="alertspopupopen('action=editCruiseMasterRate&cruiseRateId=<?php echo $cruiseRates['id']; ?>&serviceId=<?php echo $_REQUEST['serviceId']; ?>','400px','auto');">
<i class="fa fa-pencil" aria-hidden="true" style="font-size: 20px;padding: 5px;"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-trash" aria-hidden="true" style="margin-left:10px; font-size: 20px; color: #f00; cursor: pointer;" onclick="deleteFerrycost('<?php echo $cruiseRates['id']; ?>');"></i></td>
</tr>
<?php if($cruiseRates['remark']!=''){ ?>
<tr><td align="left" colspan="13"><?php  echo (strip($cruiseRates['remark'])!='')? '<strong>Remark&nbsp;:-&nbsp;&nbsp;</strong> '.$cruiseRates['remark']:''; ?></td></tr>
<?php } ?>
<?php } ?>
</tbody>
</table>
</div>


<?php
}else{ ?>

<?php } ?>