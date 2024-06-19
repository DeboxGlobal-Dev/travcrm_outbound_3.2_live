<?php 

include "inc.php";
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
     $datewhere='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';
  }
 // echo 'driverId="'.$_GET['driverId'].'" '.$datewhere.'';
  $c=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'driverId="'.$_GET['driverId'].'" '.$datewhere.''); 
  $transferQuotData=mysqli_fetch_array($c);

  $rs=GetPageRecord('*',_DRIVER_MASTER_MASTER_,' 1 and id="'.$_GET['driverId'].'" order by name'); 
  $resultlists=mysqli_fetch_array($rs);
  // echo 'transferQuoteId="'.$transferQuotData['id'].'" and quotationId="'.$transferQuotData['quotationId'].'"';
  $cdri=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferQuotData['id'].'" and quotationId="'.$transferQuotData['quotationId'].'"');

  $countrows = mysqli_num_rows($c);

?>
<div style="border: 1px solid #80808069;">
  <div style="background-color: #57a0a4;color: #ffffff;border: 1px solid #57a0a4;text-align: center;margin-bottom: 12px;padding: 5px;"><strong>Booking Details&nbsp;-&nbsp;<?php if($_REQUEST['fromDate']!=''){ echo date('d-m-Y',strtotime($_REQUEST['fromDate'])); } ?></strong></div>
  <div style="margin-bottom: 12px;">
   <form> 
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="58%"></td>
                 <td width="15%" style="padding:0px 0px 0px 10px;"><input type="date" class="gridfield" id="fromDate" name="fromDate" style="text-align:left;width: 122px;
    border: 1px solid #ccc;padding: 3px!important;border-radius: 2px;" value="<?php if($_REQUEST['fromDate']!=''){ echo date('Y-m-d',strtotime($_REQUEST['fromDate']));} ?>"></td>
                <td width="1%"></td>
                 
                  <td width="15%" style="padding:0px 0px 0px 10px;"><input type="date" class="gridfield" id="toDate" name="toDate" style="text-align:left;width: 122px;
    border: 1px solid #ccc;padding: 3px!important;border-radius: 2px;" value="<?php if($_REQUEST['toDate']!=''){ echo date('Y-m-d',strtotime($_REQUEST['toDate']));} ?>"></td>
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
        <th width="20%" align="left" style="background-color: #80808029;">Pick Up Time</th>
        <th width="20%" align="left" style="background-color: #80808029;">Drop Time</th>
        <th width="20%" align="left" style="background-color: #80808029;">Pick Up Address</th>
        <th width="10%" align="left" style="background-color: #80808029;">Drop Address</th>
        <th width="10%" align="left" style="background-color: #80808029;">Arrival From</th>
        <th width="20%" align="left" style="background-color: #80808029;"> Booking Date</th>
      </tr>
     </thead>
     <tbody id="bookingDetails">
<?php 
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
<?php }  ?>    
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

  </table>
  </div>
  </div> 

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>



  $(function() {



  $('input[name="daterange"]').daterangepicker({



  "autoApply": true,



    opens: 'right',



  locale: {



            format: 'DD-MM-YYYY'



        }



  



  }, function(start, end, label) { 



     



  });



   



});

function bookingdes() {
    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    var driverId = '<?php echo $_GET['driverId']; ?>';
    $('#bookingDetails').load('loadbookingdetails.php?fromDate='+fromDate+'&toDate='+toDate+'&driverId='+driverId);
  }  



</script>

