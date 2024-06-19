<?php include 'tableSorting.php'; 
$queryId=decode($_REQUEST['queryId']);  
$quotationId=decode($_REQUEST['quotationId']);
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
   <td width="7%">
       <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster" /><input type="button" name="Submit22" value="Back" class="whitembutton" > </a>    
   </td>    
  <!--<td >
    <button name="addnewuserbtn" type="button"  style="background-color:#fff!important;border:2px solid gray;border-radius:50%;color:#000;padding:7px;width:50px;margin-left:10px;cursor:pointer"  class="" onclick=" window.history.back();" /><i class="fa fa-arrow-left" style="font-size:24px"></i>
        </button>    
  </td>-->
    <td><div class="headingm" style="margin-left:10px;">
        <span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Cancel Voucher" onclick="masters_alertspopupopen('action=voucherCancellation&name=CancelVoucher','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="deletecancelvoucher" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable">

   <thead>

   <tr>
      <th width="2%" align="left" class="header">Sr</th> 
      <th width="2%" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" /><?php } ?>
    <label for="checkAll"><span></span>&nbsp;</label></th> 
     <th align="left" class="header" >Service Name </th>
	 <th align="left" class="header" >Status</th>
	 </tr>
   </thead>

 


 

  <tbody>
  <?php
$no=1; 
$limit=clean($_GET['records']);

if($_GET['keyword']!=''){
$wheresearch="and name like '%".$_GET['keyword']."%'";
    
}


if($_REQUEST['status']!=''){

	$wheresearch2 = " and status ='".clean($_REQUEST['status'])."' ";

}
$where='where  name!=""  '.$wheresearch2.' '.$wheresearch.' and deletestatus=0  order by name asc'; 



$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 

$DataQuery="";
$DataQuery="Select Id,ServiceID,QueryID,Srn,DayID,QuotationID, ServiceType, StartDate,ServiceName,serviceImage,StartTime,ServiceDescription,CancelVoucher from ";
$DataQuery .= " ( ";
// get the List of Hotels
$DataQuery .= "Select QI.id AS Id,QI.cancelVoucher AS CancelVoucher,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, 'Accommodation' AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime,PBHM.hotelName AS ServiceName,PBHM.hotelImage AS serviceImage,PBHM.hoteldetail AS ServiceDescription";
$DataQuery .= " From quotationItinerary QI inner join quotationHotelMaster QHM on QI.serviceId = QHM.id inner join packageBuilderHotelMaster PBHM on PBHM.id = QHM.supplierId inner join  hotelCategoryMaster HCAT on HCAT.id = QHM.categoryId inner join roomTypeMaster RTM on RTM.id = QHM.roomType LEFT join mealPlanMaster MPM on  QHM.mealPlan = MPM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType = 'hotel'";
$DataQuery .= " UNION  " ;
// get the list of Transfer and Transportation
$DataQuery .= "Select QI.id AS Id,QI.cancelVoucher AS CancelVoucher,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID,QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime,PBTM.transferName As ServiceName,VM.image AS serviceImage,PBTM.transferDetail AS ServiceDescription";
$DataQuery .= " From quotationItinerary QI inner JOIN quotationTransferMaster QTM on QI.serviceId= QTM.id inner join packageBuilderTransportMaster PBTM on QTM.transferNameId = PBTM.id inner join vehicleTypeMaster VTM on VTM.id = QTM.vehicleType inner join vehicleMaster VM on QTM.vehicleModelId = VM.id inner Join vehicleTypeMaster VTPM on VTPM.id =VM.carType where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('transfer','transportation')";
$DataQuery .= " UNION  " ;
// Get the List of enroutes
$DataQuery .= "Select QI.id AS Id,QI.cancelVoucher AS CancelVoucher,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime,PBAM.enrouteName As ServiceName,PBAM.enrouteImage AS serviceImage,PBAM.enrouteDetail AS ServiceDescription From quotationItinerary QI inner JOIN quotationEnrouteMaster QAM on QI.serviceId = QAM.id inner join packageBuilderEnrouteMaster PBAM on QAM.enrouteId = PBAM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('enroutes')";
$DataQuery .= " UNION  " ;
// Get the List of entrance
$DataQuery .= "Select QI.id AS Id,QI.cancelVoucher AS CancelVoucher,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime,PBEM.entranceName As ServiceName,PBEM.entranceImage AS serviceImage,PBEM.entranceDetail AS ServiceDescription From quotationItinerary QI inner JOIN quotationEntranceMaster QEM on QI.serviceId = QEM.id inner join packageBuilderEntranceMaster PBEM on QEM.entranceNameId = PBEM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('entrance') ";
$DataQuery .= " UNION  " ;
// Get the List of activity
$DataQuery .= "Select QI.id AS Id,QI.cancelVoucher AS CancelVoucher,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime,PBOAM.otherActivityName As ServiceName,PBOAM.otherActivityImage AS serviceImage,PBOAM.otherActivityDetail AS ServiceDescription From quotationItinerary QI inner JOIN quotationOtherActivitymaster QOAM on QI.serviceId = QOAM.id inner join packageBuilderotherActivityMaster PBOAM on PBOAM.id=QOAM.otherActivityName where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('activity') ";
$DataQuery .= " UNION  " ;
// Get the List of train
$DataQuery .= "Select QI.id AS Id,QI.cancelVoucher AS CancelVoucher,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime,PBTM.trainName  As ServiceName,PBTM.trainImage AS serviceImage,'' AS ServiceDescription From quotationItinerary QI inner JOIN quotationTrainsMaster QOAM on QI.serviceId = QOAM.id inner join packageBuilderTrainsMaster PBTM on PBTM.id=QOAM.trainId  inner join packageBuilderotherActivityMaster PBOAM on PBOAM.id=QOAM.trainId where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('train') ";
$DataQuery .= " UNION  " ;
//get list of flight
$DataQuery .= "Select QI.id AS Id,QI.cancelVoucher AS CancelVoucher,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime,PBFM.flightName As ServiceName,PBFM.flightImage AS serviceImage,'' AS packageBuilderAirlinesMaster From quotationItinerary QI inner JOIN quotationFlightMaster QFM on QI.serviceId=QFM.id inner join packageBuilderAirlinesMaster PBFM on QFM.flightId=PBFM.id ";
$DataQuery .= " INNER join destinationMaster DM on DM.id = QFM.departureFrom where 1=1 and QI.quotationId =~QID and QI.serviceType in ('flight')";

$DataQuery .= " ) MyTable order by DayID,Srn,StartTime ";

$sqlQueryDaysNew = str_replace ("~QID", $quotationId ,$DataQuery);
$DayWiseDataq=mysqli_query(db(),$sqlQueryDaysNew) or die(mysqli_error(db()));

while($DayWiseData=mysqli_fetch_array($DayWiseDataq)){

$ServiceType=ucwords($DayWiseData['ServiceType']);
$ServiceName=ucwords($DayWiseData['ServiceName']);

?>
  <tr>
    <td width="1%" align="left"><?= $no; ?></td>
    <td width="1%" align="center" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($DayWiseData['Id']); ?>"/>
    <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?></td>
	 <td width="8%" align="left"><strong><?php echo $ServiceType;  ?>:&nbsp;</strong>&nbsp;&nbsp;<?php echo $ServiceName;  ?>&nbsp;</td>
	 <?php if($DayWiseData['CancelVoucher']==1){ ?>
	 <td width="2%" align="left" style="color:red;"><?php echo "Cancelled"; ?></td> 
	 <?php }else{ ?><td width="2%" align="left" style="color:green;"><?php echo "Assigned"; ?></td><?php } ?>
</tr> 
	
	<?php $no++; } ?>
</tbody></table>
<?php if($no==1){ ?>
<div class="norec">No <?php echo $pageName; ?></div>
<?php } ?>

<div class="pagingdiv">

		

		<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tbody><tr>

    <td><table border="0" cellpadding="0" cellspacing="0">
  <!--<tr>
    <td style="padding-right:20px;"><?php echo $totalentry; ?> entries</td>
    <td><select name="records" id="records" onchange="this.form.submit();" class="lightgrayfield" >
                    <option value="25" <?php if($_GET['records']=='25'){ ?> selected="selected"<?php } ?>>25 Records Per Page</option>
                    <option value="50" <?php if($_GET['records']=='50'){ ?> selected="selected"<?php } ?>>50 Records Per Page</option>
                    <option value="100" <?php if($_GET['records']=='100'){ ?> selected="selected"<?php } ?>>100 Records Per Page</option>
                    <option value="200" <?php if($_GET['records']=='200'){ ?> selected="selected"<?php } ?>>200 Records Per Page</option>
                    <option value="300" <?php if($_GET['records']=='300'){ ?> selected="selected"<?php } ?>>300 Records Per Page</option>
                  </select></td>
  </tr>-->
  
</table></td>

    <!--<td align="right"><div class="pagingnumbers"><?php echo $paging; ?></div></td>-->

  </tr>
</tbody></table>
	</div>
</div></form>	</td>
  </tr>
</table>

<script> 
window.setInterval(function(){ 
    //   checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
	  checked = $("#listform td input[type=checkbox]:checked").length;	
      if(!checked) { 
	  $("#deactivatebtn").hide();
	  $("#topheadingmain").show();
      } else {
	  $("#deactivatebtn").show();
	  $("#topheadingmain").hide();
	  } 
}, 100);




comtabopenclose('linkbox','op2');
$(document).ready(function() {
     $('#mainsectiontable').DataTable( {
        "paging":   false,
        "ordering": true,
        "info":     true,
        "searching": false
    } );
} );
</script>