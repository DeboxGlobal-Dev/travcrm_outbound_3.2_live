<?php 
include "inc.php";

 if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
    $datewhere='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';
  }
  
  $c1=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'vehicleModelId="'.$_REQUEST['vehicleId'].'" '.$datewhere.'');
  $countno = mysqli_num_rows($c1);
  if($countno>0){
  while ($transferQuotData=mysqli_fetch_array($c1)) {
  
  $selvehd1='*';
  $wherevehd1='id="'.$transferQuotData['vehicleModelId'].'"';
  $rsvehd1=GetPageRecord($selvehd1,_VEHICLE_MASTER_MASTER_,$wherevehd1);
  $vehicalnamed1=mysqli_fetch_array($rsvehd1);

  $c12=GetPageRecord('*','quotationTransferTimelineDetails',' transferQuoteId="'.$transferQuotData['id'].'" and quotationId="'.$transferQuotData['quotationId'].'"');
   $dtime=mysqli_fetch_array($c12);

   $rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$transferQuotData['driverId'].'"  order by name');
$driverData=mysqli_fetch_array($rsDv);
?> 
<tr>
  <td align="left"><?php if($vehicalnamed1['model']!=''){ echo $vehicalnamed1['model'];}else{ echo '--';} ?></td>
    <td align="left"><?php if($vehicalnamed1['registrationNo']!='') { echo $vehicalnamed1['registrationNo']; }else{ echo '--'; } ?></td>
  <td align="left"> <?php if($driverData['name']!=''){ echo $driverData['name']; }else{ echo '--';} ?></td>
    <td align="left"><?php if($dtime['pickupTime']!=''){ echo $dtime['pickupTime'];}else{ echo '--';} ?></td>
  <td align="left"><?php if($dtime['pickupTime']!=''){ echo $dtime['pickupTime'];}else{ echo '--';} ?></td>
  <td align="left"><?php echo date('d-m-Y',strtotime($transferQuotData['fromDate'])); ?></td>
    </tr>

<?php }}else{?>

   <tr>
          <td align="center" colspan="6">No Record Found..</td>
    </tr>

<?php } ?>