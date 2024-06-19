<?php 
include "inc.php";

  if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
    $datewhere='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';
  }
 $c1=GetPageRecord('*','driverAllocationDetails',' driverId="'.$_GET['driverId'].'" '.$datewhere.'');
  $countno = mysqli_num_rows($c1);
  if($countno>0){
  while ($transferQuotData1=mysqli_fetch_array($c1)) {

   $c12=GetPageRecord('*','quotationTransferTimelineDetails',' transferQuoteId="'.$transferQuotData1['transferQuotId'].'" and quotationId="'.$transferQuotData1['quotationId'].'"'); 
   $dtime=mysqli_fetch_array($c12);
   
 ?>       
        <tr>
          <td align="left"><?php if($dtime['pickupTime']!=''){ echo $dtime['pickupTime']; }else{ echo '--'; } ?></td>
          <td align="left"><?php if($dtime['dropTime']!='') { echo $dtime['dropTime']; }else{ echo '--'; } ?></td>
          <td align="left"><?php if($dtime['pickupAddress']!='') { echo $dtime['pickupAddress']; }else{ echo '--'; }  ?></td>
          <td align="left"><?php if($dtime['dropAddress']!=''){ echo $dtime['dropAddress']; }else{ echo '--'; } ?></td>
          <td align="left"><?php if($dtime['arrivalFrom']!=''){ echo $dtime['arrivalFrom']; }else{ echo '--'; }?></td>
          <td align="left"><?php echo date('d-m-Y',strtotime($transferQuotData1['fromDate'])); ?></td>
    </tr>
<?php }}else{?>
    <tr>
          <td align="center" colspan="6">No Record Found..</td>
    </tr>
<?php } ?> 