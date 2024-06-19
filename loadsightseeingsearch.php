<?php
include "inc.php";   
$array=explode(',',$_REQUEST['startDay']); 
$dayidstart=$array[0]; 
$datestart=$array[1]; 
$destinationstart=$array[2]; 


$arrayend=explode(',',$_REQUEST['endDay']); 
$dayidend=$arrayend[0]; 
$dateend=$arrayend[1]; 
$destinationend=$arrayend[2]; 
  
 
$destinationId = getDestination($destinationstart);
//get dest name above
    
$queryId = $_REQUEST['queryId'];
$quotationId = $_REQUEST['quotationId'];  
$startDayId=$dayidstart;
$endDayId=$dayidend;
$fromDate=date("Y-m-d", strtotime($datestart));
$fromYear=date("Y", strtotime($datestart));
$toDate=date("Y-m-d", strtotime($dateend)); 
$toYear=date("Y", strtotime($dateend));
$transferType=$_REQUEST['transferType'];
$vehicleId=$_REQUEST['vehicleId'];
	 $whereDEST=' and sightseeingNameId in ( select id from packageBuilderSightseeingMaster where sightseeingCity="'.$destinationId.'" and status=1 ) ';
 
if($fromDate!=''){
$whereSTR.=' and id in (select supplierId from '._DMC_SIGHTSEEING_RATE_MASTER_.' where status=1  and toDate>='.$fromDate.' and year(toDate)='.$fromYear.'  ) ';
}

if($queryId!=''){
	//$whereSTR.=' and id not in (select supplierId from '._QUOTATION_TRANSFER_MASTER_.' where queryId='.$queryId.') ';
	$whereSTR.='';
}

$whereSTR2='';  
if($transferType!='0'){
	$whereSTR2.=' and sightseeingType="'.$transferType.'"';
}


if($vehicleId!='0' && $transferType==2){
	$whereSTR2.=' and vehicleId='.$vehicleId.' ';
}
?>

 
 
 <div style="font-size:16px; padding:10px;" id="transfercounding">0 Sightseeing Found</div>
<?php 
 $n=1;

$select=''; 
$where=''; 
$rs='';  
$select='*';     
 $where=' supplierId in (select id from '._SUPPLIERS_MASTER_.' where  deletestatus=0 and sightseeingType=11 '.$whereSTR.') '.$whereSTR2.' '.$whereDEST.' group by sightseeingType order by id asc';  
$rs=GetPageRecord($select,_DMC_SIGHTSEEING_RATE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 
	if($destinationId!='' && $queryId!='' && $fromDate!='' && $toDate!=''){ 
	?>
	<div style="padding:10px; border:1px #e3e3e3 solid;    background-color: #fff; margin-bottom:10px;" id="trabox">  
   	<?php if($resListing['sightseeingType']==1){ ?>
		<div class="topaboxlist" id="trabox1" >
		<div style="margin-bottom:20px; font-size:25px;"><table border="0" cellpadding="0" cellspacing="0">
	  <tbody><tr><td style="padding-right:15px;"><img src="images/dmcbusicon.png"></td>
		<td colspan="2">SIC</td> 
	  </tr> 
	</tbody></table>
	</div>
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
   <thead>  
   <tr>
  <th align="left" bgcolor="#DDDDDD" >Sightseeing &nbsp;</th> 
      <th align="left" bgcolor="#DDDDDD">Sightseeing Ticket - Adult Cost</th>
      <th align="left" bgcolor="#DDDDDD">Sightseeing Ticket - Child Cost</th>
      <th align="center" bgcolor="#DDDDDD">Adult Cost</th>
      <th align="center" bgcolor="#DDDDDD">Child Cost</th>
     <th align="center" bgcolor="#DDDDDD">Infant Cost</th> 
     <th align="left" bgcolor="#DDDDDD">Information</th>
     <th align="center" bgcolor="#DDDDDD">&nbsp;</th>
   </tr>
   </thead> 
  <tbody>
 <?php

 $c1=1;
 $select1=''; 
$wher1=''; 
$rs1='';  
$select1='*';    
$where1='  supplierId in (select id from '._SUPPLIERS_MASTER_.' where  deletestatus=0 and sightseeingType=11 '.$whereSTR.')  and sightseeingType=1  '.$whereSTR2.'  and status=1 '.$whereDEST.' order by id asc';  
$rs1=GetPageRecord($select1,_DMC_SIGHTSEEING_RATE_MASTER_,$where1); 
while($dmcroommastermain=mysqli_fetch_array($rs1)){   

 
?>
  <tr>
     <td align="left">
	
	<?php 
 $select2='sightseeingName';  
$where2='id='.$dmcroommastermain['sightseeingNameId'].''; 
$rs2=GetPageRecord($select2,_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
echo clean($editresult2['sightseeingName']);  
?>	</td>

    <td align="left"><?php 
 $select2='name';  
$where2='id='.$dmcroommastermain['currencyId'].''; 
$rs2=GetPageRecord($select2,_QUERY_CURRENCY_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
$cur=clean($editresult2['name']);  
?><?php echo $cur.' '.strip($dmcroommastermain['ticketAdultCost']); ?></td>
    <td align="left"><?php echo $cur.' '.strip($dmcroommastermain['ticketchildCost']); ?></td>
    <td align="left"> <?php echo $cur.' '.strip($dmcroommastermain['adultCost']); ?></td>
    <td align="left"><?php echo $cur.' '.strip($dmcroommastermain['childCost']); ?></td>
    <td align="left"><?php echo $cur.' '.strip($dmcroommastermain['infantCost']); ?></td>
	
    <td align="left"><?php echo strip($dmcroommastermain['detail']); ?></td>
    <td align="center"><div class="editbtnselect"  onclick="addsightseeingtoquotations('<?php echo $dmcroommastermain['sightseeingNameId'];?>','<?php echo $dmcroommastermain['supplierId'];?>','<?php echo $fromDate;?>','<?php echo $toDate;?>','<?php echo $startDayId;?>','<?php echo $endDayId;?>','1');"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div></td>
  </tr> 
	
	<?php $c1++; $n++;   } ?>
</tbody></table>
	</div> 
<?php } ?> 
	<?php if($resListing['sightseeingType']==2){ ?>
<div class="topaboxlist" id="trabox2">
<div style="margin-bottom:5px; font-size:15px;"><table border="0" cellpadding="0" cellspacing="0">
  <tbody><tr><td style="padding-right:15px;"><img src="images/dmccaricon.png" ></td>
    <td colspan="2">PRIVATE</td> 
  </tr> 
</tbody></table>
</div><table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
   <thead> 
   <tr>
     <th align="left" bgcolor="#DDDDDD" >Sightseeing&nbsp;</th> 
      <th align="left" bgcolor="#DDDDDD">Sightseeing Ticket - Adult Cost</th>
      <th align="left" bgcolor="#DDDDDD">Sightseeing Ticket - Child Cost</th>
      <th align="left" bgcolor="#DDDDDD">Vehicle</th>
      <th align="center" bgcolor="#DDDDDD">Max Pax</th>
     <th align="center" bgcolor="#DDDDDD">Vehicle Cost</th> 
     <th align="left" bgcolor="#DDDDDD">Information</th>
     <th align="center" bgcolor="#DDDDDD">&nbsp;</th>
   </tr>
   </thead> 
  <tbody>
 <?php
 
 $c2=1;
 $select22=''; 
$wher22=''; 
$rs22='';  
$select22='*';  
$where22=' supplierId in (select id from '._SUPPLIERS_MASTER_.' where  deletestatus=0 and sightseeingType=11 '.$whereSTR.')   and sightseeingType=2   '.$whereSTR2.'  and status=1 '.$whereDEST.' order by id asc';  
$rs22=GetPageRecord($select22,_DMC_SIGHTSEEING_RATE_MASTER_,$where22); 
while($dmcroommastermain=mysqli_fetch_array($rs22)){  

 
?>
  <tr>
    <td align="left">
	
	<?php 
 $select2='sightseeingName';  
$where2='id='.$dmcroommastermain['sightseeingNameId'].''; 
$rs2=GetPageRecord($select2,_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
echo clean($editresult2['sightseeingName']);  
?>	</td>

    <td align="left"><?php 
 $select2='name';  
$where2='id='.$dmcroommastermain['currencyId'].''; 
$rs2=GetPageRecord($select2,_QUERY_CURRENCY_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
$cur=clean($editresult2['name']);  
?>
      <?php echo $cur.' '.strip($dmcroommastermain['ticketAdultCost']); ?></td>
    <td align="left"><?php echo $cur.' '.strip($dmcroommastermain['ticketchildCost']); ?></td>
    <td align="left"> <?php 
 $select2='name,maxpax';  
$where2='id='.$dmcroommastermain['vehicleId'].''; 
$rs2=GetPageRecord($select2,_VEHICLE_MASTER_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
echo clean($editresult2['name']);  
?></td>
    <td align="left"><?php echo clean($editresult2['maxpax']); ?></td>
    <td align="left"><?php echo $cur.' '.strip($dmcroommastermain['vehicleCost']); ?></td>

    <td align="left"><?php echo strip($dmcroommastermain['detail']); ?></td>
    <td align="center"><div class="editbtnselect" onclick="addsightseeingtoquotations('<?php echo $dmcroommastermain['sightseeingNameId'];?>','<?php echo $dmcroommastermain['supplierId'];?>','<?php echo $fromDate;?>','<?php echo $toDate;?>','<?php echo $startDayId;?>','<?php echo $endDayId;?>','2');" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div></td>
  </tr> 
	
	<?php  $c2++; $n++;} ?>
</tbody></table>
</div>

<?php if($c2==1){ ?>
<script>
$('#trabox2').hide();
</script>
<?php } ?>

<?php if($c1==1 && $c2==1){ ?>
<script>
$('#sicbox').append('<div style="text-align:center;">No Transportation Found</div>');
</script>
<?php } ?>
<?php } ?>
 	</div>
    <script>
		$('#transfercounding').text('<?php echo ($n-1); ?> Transportation Found');
	</script>
	<?php  
	} 
} ?>
 
 <?php if($n==1){ ?>
 
 <div style="text-align:center; font-size:13px;  color:#FF0000;">No Sightseeing Found</div>
 <script>
 $('#transfercounding').hide();
 </script>
 <?php } ?>
 