<?php 
  include "inc.php";

  if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
    $datewhere='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';
  }
  // echo 'vehicleModelId="'.$_REQUEST['vehicleId'].'" '.$datewhere.'';
  $c1=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'vehicleModelId="'.$_REQUEST['vehicleId'].'" '.$datewhere.'');
  $transferQuotData1=mysqli_fetch_array($c1);

  $selvehd='*';
  $wherevehd='id="'.$transferQuotData1['vehicleModelId'].'"';
  $rsvehd=GetPageRecord($selvehd,_VEHICLE_MASTER_MASTER_,$wherevehd);
  $vehicalnamed=mysqli_fetch_array($rsvehd);
  

  $c12=GetPageRecord('*','quotationTransferTimelineDetails',' transferQuoteId="'.$transferQuotData1['id'].'" and quotationId="'.$transferQuotData1['quotationId'].'"');
   $dtime=mysqli_fetch_array($c12);

   $rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$transferQuotData1['driverId'].'"  order by name');
   $driverData=mysqli_fetch_array($rsDv);

   $countrows = mysqli_num_rows($c1);

 ?>
  <div style="border: 1px solid #80808069;">
  <div style="background-color: #57a0a4;color: #ffffff;border: 1px solid #57a0a4;text-align: center;margin-bottom: 12px;padding: 5px;"><strong>Booking Details&nbsp;-&nbsp;<?php if($_REQUEST['fromDate']!=''){ echo date('d-m-Y',strtotime($_REQUEST['fromDate'])); } ?></strong></div>
  <div style="margin-bottom: 12px;">
   <form> 
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="58%"></td>
                 <td width="15%" style="padding:0px 0px 0px 10px;"><input type="date" class="gridfield" id="fromDate12" name="fromDate12" style="text-align:left;width: 120px;
    border: 1px solid #ccc;padding: 3px!important;border-radius: 2px;" value="<?php if($_REQUEST['fromDate']!=''){ echo date('Y-m-d',strtotime($_REQUEST['fromDate'])); }?>"></td>
                <td width="1%"></td>
                 
                  <td width="15%" style="padding:0px 0px 0px 10px;"><input type="date" class="gridfield" id="toDate12" name="toDate12" style="text-align:left;width: 120px;
    border: 1px solid #ccc;padding: 3px!important;border-radius: 2px;" value="<?php if($_REQUEST['toDate']!=''){ echo date('Y-m-d',strtotime($_REQUEST['toDate'])); } ?>"></td>
                <td width="1%"></td>
                 <td width="10%" style="padding:0px 0px 0px 10px;"><input type="button" name="Submit2" value="Search" class="inptSearcpd" onclick="bookingdes()" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 5px; text-align: center; border-radius: 2px;margin-right: 7px;cursor:pointer;"></td>
               </tr>
           </table>
    </form>       
  </div>
  <div style="margin-bottom: 0px;">        
  <table width="100%"  border="1" cellpadding="4" cellspacing="0" bordercolor="#ccc"  class="tablesorter gridtable">
     <thead>
        <tr>
        <th width="20%" align="left" style="background-color: #80808029;">Vehicle Name</th>
        <th width="20%" align="left" style="background-color: #80808029;">Registration No.</th>
        <th width="20%" align="left" style="background-color: #80808029;">Driver Name</th>
        <th width="10%" align="left" style="background-color: #80808029;">Pick Up Time</th>
        <th width="10%" align="left" style="background-color: #80808029;">Drop Time</th>
        <th width="20%" align="left" style="background-color: #80808029;"> Booking Date</th>
      </tr>
     </thead>
     <tbody id="bookingDetails">
    <?php
  // echo 'vehicleModelId="'.$vehicalnamed1['id'].'" '.$datewhere.'';
  $fromdate = date('Y-m-d',strtotime($_GET['qfromDate']));
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
   
     </tbody>

  <style>
  .selectParentList2{
  border: 1px solid;
    padding: 3px 15px;
    text-align: center;
    font-size: 13px;
    border-radius: 3px;
    background-color:#4caf50;
    cursor: pointer;
    color: #fff;

  }
  </style>
<script type="text/javascript">
	function bookingdes() {
    var fromDate = $('#fromDate12').val();
    var toDate = $('#toDate12').val();
    var vehicleId = '<?php echo $_REQUEST['vehicleId']; ?>';
    $('#bookingDetails').load('loadbookingdetailsv.php?fromDate='+fromDate+'&toDate='+toDate+'&vehicleId='+vehicleId);
  }  

</script>
  </table>
  </div>
  </div> 
