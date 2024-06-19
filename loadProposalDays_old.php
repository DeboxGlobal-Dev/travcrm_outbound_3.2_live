<?php
include "inc.php";
function dateDiffInDays($date1, $date2){
	// Calulating the difference in timestamps
	$diff = strtotime($date2) - strtotime($date1);
	// 1 day = 24 hours
	// 24 * 60 * 60 = 86400 seconds
	return abs(round($diff / 86400));
}

$rs2=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_REQUEST['id']).'"');
$quotationData=mysqli_fetch_array($rs2);
$quotword = ($quotationData['status'] == 1)? "Itinerary" : "Proposal"; // itinerary proposal
$rs3=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'" ');
$queryData=mysqli_fetch_array($rs3);
$gitQuo=$queryData['queryType'];
$earlyCheckin = $queryData['earlyCheckin'];
$moduleType = $queryData['moduleType'];
$rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_REQUEST['id']).'"');
$resultpageQuotation=mysqli_fetch_array($rsp);
$quotationType=$quotationData['quotationType'];
$quotationType=$quotationData['quotationType'];


$quotationId=$quotationData['id'];
$queryId=$quotationData['id'];
$QueryDaysQuery1=GetPageRecord(' min(srdate) as fromDate ','newQuotationDays',' quotationId="'.$quotationData['id'].'" and addstatus=0 and deletestatus=0 ');
$newQuotData1 = mysqli_fetch_array($QueryDaysQuery1);
$newQuotData1['fromDate'];
if( $newQuotData1['fromDate'] <> $quotationData['fromDate'] && $quotationData['isRegenerated']==1){
?>
<script type="text/javascript">
	//make an alert to regenerate quote
	query_alertbox('action=askToRegenrateQuotation&quotationId=<?php echo $_REQUEST['id']; ?>','450px','auto');
</script>
<?php
}
?>
<style type="text/css">
 
.lunchdinner{
/* box-shadow: 0px 0px 5px 1px #24609e; */
display: inline-flex;  font-size: 14px !important; padding: 2px 5px; border: 1px solid #fff; border-radius: 3px; color: #24609e;
}
.hoteldescription{
/* box-shadow: 0px 0px 5px 1px #24609e; */
display: inline-flex;  font-size: 14px !important; padding: 2px 5px; border: 1px solid #fff; border-radius: 3px; color: #24609e;
}
.pdy{border: 1px solid #ea6b6b;
margin-left: 10px;
padding: 2px;
color: #ffffff;
border-radius: 3px;
background-color: #ea6b6b; }
.wnd{border: 1px solid #fa8017;
margin-left: 10px;
padding: 2px;
color: #ffffff;
border-radius: 3px;
background-color: #fa8017; }
.alld{border: 1px solid #5aac5c;
margin-left: 10px;
padding: 2px;
color: #ffffff;
border-radius: 3px;
background-color: #5aac5c; }
.room-alignm-ser{
	width: 1106px;
    overflow-y: auto;
}
</style>
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<div style="border-bottom: 1px solid #eee;" id="mainquationboxload">
<?php
$hotelNotinclude = 0;
$day=1;
$dateno = 0;
// delete all addstatus unwanted
$sql_check=GetPageRecord('*','newQuotationDays','  addstatus=1 ');
if(mysqli_num_rows($sql_check) > 0){
	$sql_del = "delete from newQuotationDays where addstatus=1";
	mysqli_query(db(),$sql_del) or die(mysqli_error(db()));
}
//cleaned
$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" and addstatus=0 and deletestatus=0  order by srdate asc');
while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){
	$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
	$srdate2 = date('Y-m-d', strtotime('+'.$dateno.' day', strtotime($quotationData['fromDate'])));
	if($dayDate != $srdate2 && $quotationData['isRegenerated']!=1){
	updatelisting('newQuotationDays','srdate="'.$srdate2.'"','id="'.$QueryDaysData['id'].'"');
	}
	$cityId = $QueryDaysData['cityId'];
	$dayId = $QueryDaysData['id'];
	$destname = getDestination($QueryDaysData['cityId']);
?> 
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditquery<?php echo $daylisting['id']; ?>" target="actoinfrm" id="addeditquery<?php echo $QueryDaysData['id']; ?>">	
<input name="action" type="hidden" value="sortingservice">
<div style="border:1px solid #aaa; background-color:#FFFFFF; margin-bottom:10px; position:relative;">
<div style="background-color: #fafafa; padding: 10px; color: #000; font-weight: 500; cursor: pointer; font-size: 14px; overflow:hidden; border-bottom: 1px solid #aaa;" onClick="openclosetabs('<?php echo ($QueryDaysData['id']);?>');">


<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="3%">Day&nbsp;<?php echo $day; ?>&nbsp;|&nbsp;</td>
	<td width="97%" align="left"><?php echo $destname; ?><?php if($queryData['dayWise']==1 || $quotationData['isSeries'] == 1 || $quotationData['isFD'] == 1){ ?>&nbsp;|&nbsp;<nobr><?php echo date('d-m-Y/D', strtotime($dayDate)); } ?></nobr></td>
</tr>
</table>
</div>
<div  class="buttonlists">
<a name="Additional<?php echo $day; ?>" onClick="openinboundpop('action=addServiceAdditional&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','800px');">+ Additional</a>
<a name="Restaurant<?php echo $day; ?>" onClick="openinboundpop('action=addServiceMealPlan&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','950px');">+ Restaurant</a>
<?php
$modeSql=GetPageRecord('*','quotationModeMaster',' 1 and quotationId="'.$quotationData['id'].'" and dayId ="'.$QueryDaysData['id'].'"');
$modeData=mysqli_fetch_array($modeSql);
if($modeData['name'] == 'surface'){ ?>
<a name="Cruise<?php echo $day; ?>" onClick="openinboundpop('action=addServiceCruise&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','800px');">+ Cruise</a>
<?php } ?>
<a name="Mode<?php echo $day; ?>" onClick="openinboundpop('action=addtransferMode&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','300px');">+ Mode </a>
<?php
if($modeData['name'] == 'train'){ ?>
<a name="Train<?php echo $day; ?>" onClick="openinboundpop('action=addServiceTrains&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1200px');">+ Train</a>
<?php } if($modeData['name'] == 'flight'){ ?>
<a name="Flight<?php echo $day; ?>" onClick="openinboundpop('action=addServiceFlight&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1200px');">+ Flight</a>
<?php } ?>
<a name="Transportation<?php echo $day; ?>" onClick="openinboundpop('action=addServiceTransportation&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1200px');">+ Transport</a>
<a name="Ferry<?php echo $day; ?>" onClick="openinboundpop('action=addServiceFerry&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1200px');">+ Ferry</a>
<a name="Transfer<?php echo $day; ?>" onClick="openinboundpop('action=addServiceTransfer&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1200px');">+ Transfer</a>
<a name="Entrance<?php echo $day; ?>" onClick="openinboundpop('action=addServiceEntrance&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1200px');">+ Monument</a>
<a name="Activity<?php echo $day; ?>" onClick="openinboundpop('action=addServiceActivity&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','800px');">+ SightSeeing</a>
<a name="Guide<?php echo $day; ?>" onClick="openinboundpop('action=addServiceGuide&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','800px');">+ Tour Escort</a>
 
<?php
//check for local escort
$focQLE="";
$focQLE=GetPageRecord('*','totalPaxSlab',' 1 and status=1 and quotationId="'.$quotationData['id'].'" and localEscort>0 and quotationId in ( select quotationId from quotationHotelMaster where  quotationId="'.$quotationData['id'].'" and isLocalEscort=1 and fromDate="'.$dayDate.'" ) ');
//check for foreign escort
$focQFE="";
$focQFE=GetPageRecord('*','totalPaxSlab',' 1 and status=1 and quotationId="'.$quotationData['id'].'" and foreignEscort>0 and quotationId in ( select quotationId from quotationHotelMaster where  quotationId="'.$quotationData['id'].'" and isForeignEscort=1 and fromDate="'.$dayDate.'" ) ');
// check supplement hotel
$mainsuppCheck="";
$mainsuppCheck=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationData['id'].'" and isHotelSupplement=1 and fromDate="'.$dayDate.'"');

// check normal guest hotel
$mainCheck="";
$mainCheck=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationData['id'].'" and isGuestType=1 and fromDate="'.$dayDate.'"');

//check  early arrival guest hotel status 
$earlyArrivalDate = date("Y-m-d", strtotime("-1 days", strtotime($dayDate)));
$earlymainCheck="";
$earlymainCheck=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationData['id'].'" and isGuestType=1 and fromDate="'.$earlyArrivalDate.'"');

if( ( mysqli_num_rows($earlymainCheck) == 0 && $day == 1 && $earlyCheckin == 1 ) || mysqli_num_rows($mainCheck) == 0 || mysqli_num_rows($mainsuppCheck) == 0 || mysqli_num_rows($focQLE) == 0 || mysqli_num_rows($focQFE) == 0 || $quotationType==2){ 
	// if($quotationData['queryType']!=6 && $quotationData['queryType']!=7 && $quotationData['queryType']!=8){
	?>
<a name="Hotel<?php echo $day; ?>" onClick="openinboundpop('action=addServiceHotel&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>&day=<?php echo $day; ?>','1200px');">+&nbsp;Hotel</a>
<?php } //} ?>
<a name="ItineraryInfo<?php echo $day; ?>" onClick="openinboundpop('action=additinerary_plan&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1200px');" >+ Itinerary&nbsp;Info</a>
</div>
</div>
		
<div style="padding:10px; background-color:#FFFFFF; display:noned;" id="tbbody<?php echo ($QueryDaysData['id']);?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  id="stbl<?php echo $QueryDaysData['id']; ?>" onclick="dragDropfun('<?php echo $QueryDaysData['id']; ?>');">
<tbody>
<?php
$iti_subject=preg_replace('/\\\\/', '',urldecode($QueryDaysData['title']));
$iti_description=preg_replace('/\\\\/', '',urldecode($QueryDaysData['description']));

if($iti_subject!='' || $iti_description!=''){ 
	?>
	<tr>
	<td>
	<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;position:relative; background-color:#FFFFFF;">
	<table width="100%" border="0" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
		<tbody>
			<tr>
				<td align="left"><div><?php echo strip($iti_subject);?></div></td>
			</tr>
			<tr>
				<td align="left"><div><?php echo strip($iti_description);?></div></td>
			</tr>
		</tbody>
		</table>
	</div>
	</td>
	</tr>
	<?php
}
 

$dateQuery = '';
if($earlyCheckin ==1 && $day == 1){
	$dayDate2 = date("Y-m-d", strtotime("-1 days", strtotime($dayDate)));
	$dateQuery = ' and ( startDate="'.$dayDate2.'" or startDate="'.$dayDate.'" )';
}else{
	$dayDate = date("Y-m-d", strtotime($dayDate));
	$dateQuery = ' and startDate="'.$dayDate.'" ';
}
// normal services start without hotel
$b=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationData['id'].'" and queryId="'.$quotationData['queryId'].'" '.$dateQuery.' order by srn asc,id desc');
$htservice=1;

while($sorting=mysqli_fetch_array($b)){
	
	if($sorting['serviceType'] == 'hotel'){

		// NORMAL HOTEL 
		// quotation hotel data
		
		$startDate = date("Y-m-d", strtotime($sorting['startDate']));
		$earlyCheckQuery = '';
		$earlyCheckQuery = ' and supplierId="'.$sorting['serviceId'].'" and fromDate="'.$startDate.'" ';

		$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" '.$earlyCheckQuery.' group by supplierId,fromDate,dayId order by fromDate asc');
		if(mysqli_num_rows($c)>0){
			while($hotelQuotData=mysqli_fetch_array($c)){

			// hotel data
			$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$sorting['serviceId'].'"');
			$hotelData=mysqli_fetch_array($d);

	
	?>
	<tr>
	<td align="left" valign="top">
	<input name="serviceids[]" type="hidden"  value="<?php echo $sorting['id']; ?>">
	<div style="padding:5px;border: 1px solid #006699;margin-bottom:10px;padding-right:40px;position:relative;background-color: #dddddd;"><div class="editButton" style="width:30px; height:100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;z-index: 77;" ></div>
	<table width="100%" border="0" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="tablesorter gridtable">
	<thead>
	<tr>
	<th   align="left" bgcolor="#ddd"><?php if($hotelQuotData['isEarlyCheckin']==1){ echo 'Early Checkin'; } ?> Hotel</th>
	</tr>
	</thead>
	<tbody>
	<tr>  
	<td width="100%" align="left" valign="top" style="padding-left:10px; padding-right:37px; position:relative;">
		<div style="font-size:15px;font-weight:500;margin: 3px 0 10px 0;"><?php echo strip($hotelData['hotelName']);  ?>&nbsp;|&nbsp;<?php
			$rs231=GetPageRecord('*','hotelCategoryMaster','id="'.$hotelData['hotelCategoryId'].'"');
			$hotelCatNam=mysqli_fetch_array($rs231);
			echo $hotelCatNam['hotelCategory']; ?>&nbsp;Star&nbsp;|&nbsp;<input type="checkbox" id="hoteldetails<?php echo ($hotelQuotData['id']); ?>" style="display: inline-block;" value="1" <?php if($hotelQuotData['hotelDescription']==1){ ?> checked="checked" <?php } ?>  onchange="hoteldetails('<?php echo ($hotelQuotData['id']); ?>','<?php echo $hotelData['id']; ?>','<?php echo ($hotelQuotData['supplierId']); ?>')">Hotel Description&nbsp;&nbsp;|&nbsp;<span class="bluelink" onclick="openinboundpop('action=addhoteldetails&&hotelId=<?php echo $hotelData['id']; ?>','1000px');" style="font-size: 15px;">T&C</span>
			<div id="savehotelDescription<?php echo ($hotelQuotData['id']); ?>" style="display:none;"></div> 

		</div>
		<script type="text/javascript">
			function hoteldetails(quotId,hotelId,supplierId) {
			var hoteldetails = $('#hoteldetails'+quotId).val();

			if($('#hoteldetails'+quotId).is(":checked")){
			$("#displayhoteldetails"+quotId).show();
			var hoteldetails = 1;
			}else{
			$("#displayhoteldetails"+quotId).hide();
			var hoteldetails = 0;
			}
			$("#savehotelDescription"+quotId).load('frmaction.php?action=savehoteldescription&quotationId=<?php echo ($quotationData['id']); ?>&supplierId='+supplierId+'&hoteldetails='+hoteldetails+'&quoteId='+quotId);
			}
		</script>

	<div style="margin-bottom:10px; font-size:12px;border: 1px solid #5aac5c61;background-color: #5aac5c14;padding: 10px;display:<?php if($hotelQuotData['hotelDescription']==1){ echo 'block'; }else{ echo 'none'; } ?>;" id="displayhoteldetails<?php echo ($hotelQuotData['id']); ?>"><?php echo strip($hotelData['hoteldetail']);  ?></div>
	<div class="">
	<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="hotelds tablesorter gridtable" >
	<?php
	// hotel rate data new code start
	$qhQuery='';
	$qhQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and supplierId="'.$sorting['serviceId'].'" and dayId="'.$sorting['dayId'].'"  order by rand_color asc');
	if(mysqli_num_rows($qhQuery)>0){
		$NORate = 1;
		while($qhData=mysqli_fetch_array($qhQuery)){
		 
			if($NORate == 1){ ?>
			<tr>
				<th width="80" align="center" bgcolor="#F4F4F4">#</th>
				<th width="80" align="left" bgcolor="#F4F4F4">Service&nbsp;Type</th>
				<th width="80" align="left" bgcolor="#F4F4F4">Tariff&nbsp;Type </th>
				<th width="" align="left" bgcolor="#F4F4F4">Room&nbsp;Type </th>
				<th width="70" align="left" bgcolor="#F4F4F4">Meal&nbsp;Plan </th>

				<?php if($quotationData['sglRoom']>0){ ?>
				<th width="6%" align="left" bgcolor="#F4F4F4">Single</th>
				<?php } if($quotationData['dblRoom']>0){ ?>
				<th width="6%" align="left" bgcolor="#F4F4F4">Double</th>
				<?php } if($quotationData['twinRoom']>0){ ?>
				<th width="12%" align="left" bgcolor="#F4F4F4">Twin</th>
				<?php } if($quotationData['tplRoom']>0){ ?>
				<th width="12%" align="left" bgcolor="#F4F4F4">Triple</th>
				<?php } if($quotationData['quadNoofRoom']>0){ ?>
				<th width="6%" align="left" bgcolor="#F4F4F4">Quad Room</th>
				<?php } if($quotationData['sixNoofBedRoom']>0){ ?>
				<th width="6%" align="left" bgcolor="#F4F4F4">Six Bed Room</th>
				<?php } if($quotationData['eightNoofBedRoom']>0){?>
				<th width="6%" align="left" bgcolor="#F4F4F4">Eight Bed Room</th>
				<?php } if($quotationData['tenNoofBedRoom']>0){ ?>
				<th width="6%" align="left" bgcolor="#F4F4F4">Ten Bed Room</th>
				<?php } if($quotationData['teenNoofRoom']>0){ ?>
				<th width="6%" align="left" bgcolor="#F4F4F4">Teen Room</th>
				<?php } if($quotationData['extraNoofBed']>0){ ?>
				<th width="12%" align="left" bgcolor="#F4F4F4">E.Bed(A)</th>
				<?php } if($quotationData['childwithNoofBed']>0){ ?>
				<th width="12%" align="left" bgcolor="#F4F4F4">CWB</th>
				<?php } if($quotationData['childwithoutNoofBed']>0){ ?>
				<th width="6%" align="left" bgcolor="#F4F4F4">CNB</th>
				<?php } if($qhData['complimentaryBreakfast']==1){ $isbreakfast=1; ?>
				<th width="8%" align="left" bgcolor="#F4F4F4">Breakfast(A)</th>
				<?php } if($qhData['complimentaryLunch']==1){ $islunch=1; ?>
				<th width="8%" align="left" bgcolor="#F4F4F4">Lunch(A)</th>
				<?php } if($qhData['complimentaryDinner']==1){ $isdinner=1; ?>
				<th width="8%" align="left" bgcolor="#F4F4F4">Dinner(A)</th>
				<?php } if($qhData['isChildBreakfast']==1){ $isChildBreakfast=1; ?>
				<th width="8%" align="left" bgcolor="#F4F4F4">Breakfast(C)</th>
				<?php } if($qhData['isChildLunch']==1){ $isChildLunch=1; ?>
				<th width="8%" align="left" bgcolor="#F4F4F4">Lunch(C)</th>
				<?php } if($qhData['isChildDinner']==1){ $isChildDinner=1; ?>
				<th width="8%" align="left" bgcolor="#F4F4F4">Dinner(C)</th>
				<?php } ?> 
			</tr>
			<?php } ?>
			<tr>
				<td width="80" align="left">
					<div class="viewMoreBtn" onclick="showlinkBox('#linkBox<?php echo $qhData['id'];?>');">&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;More</div>
					<div class="linkBox" id="linkBox<?php echo $qhData['id'];?>">

						<div class="dltBtn links" onclick="if(confirm('Are you sure you want delete this hotel?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $qhData['id'].'_'.$qhData['supplierId'];?>','deleteQuotationHotel');" style="color: red;"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</div>
						 
						<!-- onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $qhData['id'];?>','editQuotationHotel');" -->
						<div class="edtBtn links" id="editBtn<?php echo ($qhData['id']); ?>"  style="color: #006699;" onclick="openinboundpop('action=editQuotationHotelRate&hotelQuoteId=<?php echo $qhData['id']; ?>','1000px');"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</div>
							
						<div class="edtBtn links" id="editBtn<?php echo ($qhData['id']); ?>"  style="color: #006699;" onClick="openinboundpop('action=selectAdultChildMeal&dayId=<?php echo $QueryDaysData['id']; ?>&hotelQuoteId=<?php echo $qhData['id'];?>&roomTariffId=<?php echo $qhData['roomTariffId'];?>&quotationId=<?php echo $quotationId; ?>','400px');" ><i class="fa fa-cutlery" aria-hidden="true"></i>&nbsp;Meals</div>
						
						<div class="adBtn links" id="saveBtn<?php echo ($qhData['id']); ?>"  style="color: #006699;" onClick="openinboundpop('action=addHotelAdditionalService&dayId=<?php echo $QueryDaysData['id']; ?>&hotelQuoteId=<?php echo $qhData['id'];?>&roomTariffId=<?php echo $qhData['roomTariffId'];?>','1000px');"><i class="fa fa-adn" aria-hidden="true"></i>&nbsp;Additional</div>

						<?php if($qhData['isRoomSupplement']!=1 && $qhData['isHotelSupplement']!=1){ ?>
						<div class="adBtn links" title="Room&nbsp;Supplement" id="saveBtn<?php echo ($qhData['id']); ?>" style="color: #006699;" onClick="openinboundpop('action=addServiceHotel&stype=roomSupplement&dayId=<?php echo $QueryDaysData['id']; ?>&hotelQuoteId=<?php echo $qhData['id'];?>','1300px');"><i class="fa fa-hotel" aria-hidden="true"></i>&nbsp;Room&nbsp;Supplement</div>
						 
						<div class="adBtn links" title="Room&nbsp;Supplement" id="saveBtn<?php echo ($qhData['id']); ?>" style="color: #006699;" onClick="openinboundpop('action=addServiceHotel&stype=hotelSupplement&dayId=<?php echo $QueryDaysData['id']; ?>&hotelQuoteId=<?php echo $qhData['id'];?>','1300px');"><i class="fa fa-hotel" aria-hidden="true"></i>&nbsp;Hotel&nbsp;Supplement</div>
						<?php } ?>
					</div>
				</td>
				<td width="80" align="left" bgcolor="<?php echo $qhData['rand_color']; ?>"><?php

					$headingName='';
					if($qhData['isHotelSupplement']==1){ $headingName .= 'Hotel Supplement ,'; }
					elseif($qhData['isRoomSupplement']==1){ $headingName .= 'Room Supplement ,'; }
					else{
						if($qhData['isGuestType']==1){ $headingName .= 'Guest ,'; }
						if($qhData['isLocalEscort']==1){ $headingName .= 'Local Escort ,'; }
						if($qhData['isForeignEscort']==1){ $headingName .= 'Foreign Escort ,'; }
					}
					echo rtrim($headingName,' ,'). " ";

					?>
				</td>
				<td width="80" align="left">
					<?php if($qhData['tariffType']==1){ echo getTariffType($qhData['tariffType']); } ?>
					<?php if($qhData['tariffType']==2){ echo getTariffType($qhData['tariffType']); } ?>
					<?php if($qhData['tariffType']==3){ echo getTariffType($qhData['tariffType']); } ?>
					<?php if($qhData['supplementCostAdded']==1){ ?>
						<!--  onclick="openinboundpop('action=vewsupplementcostofHotel&id=<?php echo $supplementCostc['id']; ?>&hotelQuoteId=<?php echo $hotelQuotData['id']; ?>','1200px');"  -->
						<a title="Supplement&nbsp;Cost&nbsp;Applied" onclick="alert('Supplement Cost Applied on this rate.');" style="color: #006699 !important;"><i class="fa fa-info-circle"></i></a> 
					<?php } ?>	
				</td>
				<td align="left">
					<?php
					$select12='*';
					$where12='id='.$qhData['roomType'].'';
					$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12);
					$editresult2=mysqli_fetch_array($rs12);
					echo str_replace(' ', '&nbsp;', $editresult2['name']);
					// echo $editresult2['id'];
					?>
					<br>
					<!-- room info add code started -->
					<span class="bluelink" onclick="openinboundpop('action=addroomdetails&&roomId=<?php echo $editresult2['id']; ?>','1000px');" style="font-size: 12px;">Room Info.</span>
				</td>
				<td width="70" align="left">
					<?php
					$select2='name';
					$where2='id='.$qhData['mealPlan'].'';
					$rs2=GetPageRecord($select2,_MEAL_PLAN_MASTER_,$where2);
					$editresult2=mysqli_fetch_array($rs2);
					echo strtoupper($editresult2['name']);
					?>
				</td>
				<?php if($quotationData['sglRoom']>0){ ?> 
				<td width="6%" align="left">
					<?php  echo ($qhData['singleNoofRoom']>0)? getCurrencyName($qhData['currencyId']).'&nbsp;'.strip($qhData['singleoccupancy']).'x'.strip($qhData['singleNoofRoom']):' ' ;?> 
				</td>
				<?php } if($quotationData['dblRoom']>0){ ?> 
				<td width="6%" align="left">
					<?php  echo ($qhData['doubleNoofRoom']>0)? getCurrencyName($qhData['currencyId']).'&nbsp;'.strip($qhData['doubleoccupancy']).'x'.strip($qhData['doubleNoofRoom']):'';  ?>
				</td> 
				<?php } if($quotationData['twinRoom']>0){ ?> 
				<td width="12%" align="left">
					<?php  echo ($qhData['twinNoofRoom']>0)? getCurrencyName($qhData['currencyId']).'&nbsp;'.strip($qhData['twinoccupancy']).'x'.strip($qhData['twinNoofRoom']):'';  ?>
				</td> 
				<?php } if($quotationData['tplRoom']>0){ ?> 
				<td width="12%" align="left">
					<?php  echo ($qhData['tripleNoofRoom']>0)? getCurrencyName($qhData['currencyId']).'&nbsp;'.strip($qhData['tripleoccupancy']).'x'.strip($qhData['tripleNoofRoom']):'';  ?>
				</td> 
				<?php } if($quotationData['quadNoofRoom']>0){ ?>
				<td width="6%" align="left">
					<?php  echo ($qhData['quadNoofRoom']>0)? getCurrencyName($qhData['currencyId']).'&nbsp;'.strip($qhData['quadRoom']).'x'.strip($qhData['quadNoofRoom']):'';  ?>
				</td>
				<?php } if($quotationData['sixNoofBedRoom']>0){ ?>
				<td width="6%" align="left">
					<?php  echo ($qhData['sixNoofBedRoom']>0)? getCurrencyName($qhData['currencyId']).'&nbsp;'.strip($qhData['sixBedRoom']).'x'.strip($qhData['sixNoofBedRoom']):'';  ?>
				</td>
				<?php }  if($quotationData['eightNoofBedRoom']>0){ ?>
				<td width="6%" align="left">
					<?php  echo ($qhData['eightNoofBedRoom']>0)? getCurrencyName($qhData['currencyId']).'&nbsp;'.strip($qhData['eightBedRoom']).'x'.strip($qhData['eightNoofBedRoom']):'';  ?>
				</td>
				<?php } if($quotationData['tenNoofBedRoom']>0){ ?>
				<td width="6%" align="left">
					<?php  echo ($qhData['tenNoofBedRoom']>0)? getCurrencyName($qhData['currencyId']).'&nbsp;'.strip($qhData['tenBedRoom']).'x'.strip($qhData['tenNoofBedRoom']):'';  ?>
				</td>
				<?php } if($quotationData['teenNoofRoom']>0){ ?>
				<td width="6%" align="left">
					<?php  echo ($qhData['teenNoofRoom']>0)? getCurrencyName($qhData['currencyId']).'&nbsp;'.strip($qhData['teenRoom']).'x'.strip($qhData['teenNoofRoom']):'';  ?>
				</td>
				<?php } if($quotationData['extraNoofBed']>0){ ?> 
				<td width="12%" align="left">
					<?php echo ($qhData['extraNoofBed']>0)? getCurrencyName($qhData['currencyId']).'&nbsp;'.strip($qhData['extraBed']).'x'.strip($qhData['extraNoofBed']):''; ?>
				</td>
				<?php }  if($quotationData['childwithNoofBed']>0){ ?> 
				<td width="12%" align="left">
					<?php echo ($qhData['childwithNoofBed']>0)? getCurrencyName($qhData['currencyId']).'&nbsp;'.strip($qhData['childwithbed']).'x'.strip($qhData['childwithNoofBed']):''; ?>
				</td>
				<?php }  if($quotationData['childwithoutNoofBed']>0){ ?> 
				<td width="6%" align="left">
					<?php  echo ($qhData['childwithoutNoofBed']>0)? getCurrencyName($qhData['currencyId']).'&nbsp;'.strip($qhData['childwithoutbed']).'x'.strip($qhData['childwithoutNoofBed']):'';  ?>
				</td>
				<?php } if($qhData['complimentaryBreakfast']==1){ ?>
				<td width="8%" align="left">
					<?php echo getCurrencyName($qhData['currencyId']).' '.strip($qhData['breakfast']); ?>
				</td>  
				<?php } if($qhData['complimentaryLunch']==1){ ?>
				<td width="8%" align="left">
					<?php echo getCurrencyName($qhData['currencyId']).' '.strip($qhData['lunch']); ?>
				</td>
				<?php } if($qhData['complimentaryDinner']==1){ ?>
				<td width="8%" align="left">
					<?php echo getCurrencyName($qhData['currencyId']).' '.strip($qhData['dinner']); ?>
				</td>
				<?php } if($qhData['isChildBreakfast']==1){ ?>
				<td width="8%" align="left">
					<?php echo getCurrencyName($qhData['currencyId']).' '.strip($qhData['childBreakfast']); ?>
				</td>  
				<?php } if($qhData['isChildLunch']==1){ ?>
				<td width="8%" align="left">
					<?php echo getCurrencyName($qhData['currencyId']).' '.strip($qhData['childLunch']); ?>
				</td>
				<?php } if($qhData['isChildDinner']==1){ ?>
				<td width="8%" align="left">
					<?php echo getCurrencyName($qhData['currencyId']).' '.strip($qhData['childDinner']); ?>
				</td>
				<?php } ?> 
			</tr> 
			<?php
			// start hotel additional requirenment
			$c2 = "";
			$c2=GetPageRecord('*','quotationHotelAdditionalMaster',' hotelQuotId="'.$hotelQuotData['id'].'" and quotationId="'.$hotelQuotData['quotationId'].'"');
			if(mysqli_num_rows($c2) > 0){
				?>
				<tr><td colspan="7">
				<table cellpadding="0" cellspacing="0" border="1" width="100%">
				<thead style="font-weight:500;">
					<tr>
					<th colspan="<?php echo 9+$isdinner+$isdinner; ?>" align="left" style="color:#fa8017;">Hotel&nbsp;Additionals</th>
					</tr>
					<tr>
						<th align="left" >Name</th>
						<th align="left" >GST </th>
						<th align="left" >Cost Type</th>
						<th align="left" >Cost( Per Pax )</th>
						<th colspan="<?php echo 5+$isdinner+$isdinner; ?>" align="left" ></th>
					</tr>
				</thead>
				<tbody>
					<?php
					while($hotelAdditionalData=mysqli_fetch_array($c2)){
						?>
						<tr>
							<td align="left">
								<div id="SupproomTypeText<?php echo ($hotelAdditionalData['id']); ?>">
									<?php echo $hotelAdditionalData['name']; ?>
								</div>
							</td>
							<td align="left">
								<div id="SuppmealPlanText<?php echo ($hotelAdditionalData['id']); ?>">
									<?php   echo getGstSlabById($hotelAdditionalData['gstTax']); ?> 
								</div>
							</td> 
							<td align="left">
								<div id="SuppsingleoccupancyText<?php echo ($hotelAdditionalData['id']); ?>">
								<?php 
								if($hotelAdditionalData['costType']=='2'){ echo "Group Cost"; }else{ echo "Per Person Cost"; } 
								?>
								</div>
							</td>
							<td align="left">
								<div id="SuppsingleoccupancyText<?php echo ($hotelAdditionalData['id']); ?>">
								<?php echo getCurrencyName($hotelAdditionalData['currencyId']); ?>&nbsp;<?php echo $hotelAdditionalData['additionalCost']; ?>
								</div>
							</td>
							<td align="left" colspan="<?php echo 5+$isdinner+$isdinner; ?>" >
								<div class="deleteBtn hoteldlt" onclick="if(confirm('Are you sure you want delete this hotel additional?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $hotelAdditionalData['id'];?>','deleteQuotationHotelAdditional');"><i class="fa fa-trash" aria-hidden="true"></i></div>
								
								<!-- <div class="editBtn hoteledit" id="SuppeditBtn<?php echo ($hotelAdditionalData['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $hotelAdditionalData['id'];?>','editQuotationRoomSupplement');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
								
								<div class="saveBtn hoteledit" id="SuppsaveBtn<?php echo ($hotelAdditionalData['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $hotelAdditionalData['id'];?>','saveQuotationRoomSupplement');"><i class="fa fa-save" aria-hidden="true"></i></div> -->
							</td>
						</tr>
						<?php
					}
					?>
				</tbody>
				</table>
				</td></tr>
				<?php
			}
			// end hotel additional requirenment
			?>
				
			<?php if(mysqli_num_rows($qhQuery) != $NORate){ ?>
			<tr style="border:1px dashed #fa8017;width: 100%;height: 7px;"></tr>
			<?php }  
			$NORate++;
		}
	}
	// end new code
	?> 
	</table>
	</div>
	</td>
	</tr>
	</tbody>
	</table>
	</div>
	</td>
	</tr>
	<?php
	}
		}
		$htservice++;
	} 

	if($sorting['serviceType'] == 'transfer' ){
		// quotation hotel data
		$c=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and id="'.$sorting['serviceId'].'"');
		if(mysqli_num_rows($c)>0){
		while($transferData=mysqli_fetch_array($c)){
		?>
		<tr> <td>
		<input name="serviceids[]" type="hidden"  value="<?php echo $sorting['id']; ?>">
		<input id="transferTypeInput<?php echo ($transferData['id']); ?>" type="hidden"  value="<?php echo $transferData['transferType']; ?>">
		<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;"><div class="editButton" style="width:30px;height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
		<thead>
			<tr>
			<th align="left" bgcolor="#ddd">Transfer&nbsp;Name</th>
			<?php if($transferData['transferType'] == 2){ ?>
			<th align="left" bgcolor="#ddd" style="display:none;">Vehicle Type</th>
			<th align="left" bgcolor="#ddd" >Vehicle Name </th>
			<th align="left" bgcolor="#ddd" >Vehicle Cost</th>
			<th align="left" bgcolor="#ddd" >No.&nbsp;of&nbsp;Vehicle</th>
			<th align="left" bgcolor="#ddd" >Total&nbsp;Cost</th>
			<?php }else{ ?>
			<th align="left" bgcolor="#ddd" >Adult&nbsp;Cost</th>
			<th align="left" bgcolor="#ddd" >Child&nbsp;Cost</th>
			<th align="left" bgcolor="#ddd" >Infant&nbsp;Cost</th>
			<?php } ?>
			<th align="left" bgcolor="#ddd" >Pax&nbsp;Slab</th>
			<th align="right" bgcolor="#ddd">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		// hotel data
		$d=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$transferData['transferNameId'].'"');
		$transferData1=mysqli_fetch_array($d);
		if($transferData['transferName'] == '' || strlen($transferData['transferName']) < 3){
			$transferName =  $transferData1['transferName'];
		}else{
			$transferName =  $transferData['transferName'];
		}
		?>
		<tr>
		<td align="left">
			<div id="transferNameIdText<?php echo ($transferData['id']); ?>">
			<?php echo trim($transferName); ?>					</div>
			<div id="transferNameId<?php echo ($transferData['id']); ?>" style="display:none;">
			<input type="text" id="transferNameIdInput<?php echo ($transferData['id']); ?>"  value="<?php echo  strip($transferName); ?>">
			</div>					
		</td>
		<?php if($transferData['transferType'] == 2){ ?>
		<td align="left" style="display:none;">
			<div id="vehicleTypeText<?php echo ($transferData['id']); ?>">
			<?php
			$select2='carType,model';
			$where2='id="'.$transferData['vehicleModelId'].'"';
			$rs2=GetPageRecord($select2,_VEHICLE_MASTER_MASTER_,$where2);
			$editresult2=mysqli_fetch_array($rs2);
			echo getVehicleTypeName($editresult2['carType']);
			?>
			</div>
			<div id="vehicleType<?php echo ($transferData['id']); ?>" style="display:none;">
			<select id="vehicleTypeInput<?php echo ($transferData['id']); ?>"  class="selectbox"  onchange="getVehicleModel<?php echo ($transferData['id']); ?>('<?php echo ($transferData['id']); ?>')">
			<?php
			$rsaa=GetPageRecord('name,id','vehicleTypeMaster',' 1 order by name asc');
			while($transferDataass=mysqli_fetch_array($rsaa)){
			?>
			<option value="<?php echo strip($transferDataass['id']); ?>" <?php if($editresult2['carType'] == strip($transferDataass['id'])){ ?> selected="selected" <?php } ?>><?php echo strip($transferDataass['name']); ?></option>
			<?php } ?>
			</select>
			</div>					
		</td>
		<td align="left">
			<div id="vehicleModelIdText<?php echo ($transferData['id']); ?>">
			<?php echo $editresult2['model']; ?>					</div>
			<div id="vehicleModelId<?php echo ($transferData['id']); ?>" style="display:none;">
			<select id="vehicleModelIdInput<?php echo ($transferData['id']); ?>"  class="selectbox">
			<option value="">Select Model</option>
			<?php
			$select='*';
			$where=' 1  order by id asc';
			$rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where);
			while($transferData2=mysqli_fetch_array($rs)){
			?>
			<option value="<?php echo $transferData2['id']; ?>" <?php if($transferData2['id'] == $transferData['vehicleModelId']){ ?> selected="selected" <?php } ?>><?php echo $transferData2['model']; ?></option>
			<?php } ?>
			</select>
			</div>
			<script type="text/javascript">
			function getVehicleModel<?php echo ($transferData['id']); ?>(id) {
			var vehicleType = $('#vehicleTypeInput'+id).val();
			$("#vehicleModelIdInput"+id).load('loadvehiclemodel.php?vehicleTypeId='+vehicleType);
			}
			</script>					
		</td>
		<td align="left">
			<div id="vehicleCostText<?php echo ($transferData['id']); ?>"><?php echo  strip($transferData['vehicleCost']); ?></div>
			<div id="vehicleCost<?php echo ($transferData['id']); ?>" style="display:none;">
			<input type="text" id="vehicleCostInput<?php echo ($transferData['id']); ?>"  value="<?php echo  strip($transferData['vehicleCost']); ?>">
			</div>					
		</td>
		<td align="left">
			<div id="noOfVehiclesText<?php echo ($transferData['id']); ?>"><?php echo  strip($transferData['noOfVehicles']); ?></div>
			<div id="noOfVehicles<?php echo ($transferData['id']); ?>" style="display:none;">
				<input type="text" id="noOfVehiclesInput<?php echo ($transferData['id']); ?>"  value="<?php echo  strip($transferData['noOfVehicles']); ?>">
			</div>					
		</td>
		<td align="left">
			<div ><?php echo  round($transferData['vehicleCost']*$transferData['noOfVehicles']); ?></div>					 
		</td>
		<?php }else{ ?>
		<td align="left">
			<div id="adultCostText<?php echo ($transferData['id']); ?>"><?php echo  strip($transferData['adultCost']); ?></div>
			<div id="adultCost<?php echo ($transferData['id']); ?>" style="display:none;">
			<input type="text" id="adultCostInput<?php echo ($transferData['id']); ?>"  value="<?php echo  strip($transferData['adultCost']); ?>">
			</div>					
		</td>
		<td align="left">
			<div id="childCostText<?php echo ($transferData['id']); ?>"><?php echo  strip($transferData['childCost']); ?></div>
			<div id="childCost<?php echo ($transferData['id']); ?>" style="display:none;">
			<input type="text" id="childCostInput<?php echo ($transferData['id']); ?>"  value="<?php echo  strip($transferData['childCost']); ?>">
			</div>					
		</td>
		<td align="left">
			<div id="infantCostText<?php echo ($transferData['id']); ?>"><?php echo  strip($transferData['infantCost']); ?></div>
			<div id="infantCost<?php echo ($transferData['id']); ?>" style="display:none;">
			<input type="text" id="infantCostInput<?php echo ($transferData['id']); ?>"  value="<?php echo  strip($transferData['infantCost']); ?>">
			</div>					
		</td>
		<?php } ?>
		<td align="left">
			<?php
			$tpxQ="";
			$tpxQ=GetPageRecord('*','totalPaxSlab',' 1 and id="'.$transferData['totalPax'].'"');
			$slabsData =  mysqli_fetch_array($tpxQ);
			if($slabsData['fromRange'] == $slabsData['toRange'] || $slabsData['toRange']==0){
				$paxrange = $slabsData['fromRange'];
			}else{
				$paxrange = $slabsData['fromRange'].'-'.$slabsData['toRange'];
			}
			?>
			<div id="paxSlabText<?php echo ($transferData['id']); ?>"><?php echo  strip($paxrange.'&nbsp;Pax'); ?></div>
			<div id="paxSlab<?php echo ($transferData['id']); ?>" style="display:none;">
				<select id="paxSlabInput<?php echo ($transferData['id']); ?>"  class="selectbox">
					<option value="">Select Model</option>
					<?php
					$tpxQ2='';
					$tpxQ2=GetPageRecord('*','totalPaxSlab',' 1 and quotationId="'.$quotationData['id'].'" and status=1 ');
					while($totalPaxSlabD=mysqli_fetch_array($tpxQ2)){
						if($totalPaxSlabD['fromRange'] == $totalPaxSlabD['toRange'] || $totalPaxSlabD['toRange']==0){
							$paxrange2 = $totalPaxSlabD['fromRange'];
						}else{
							$paxrange2 = $totalPaxSlabD['fromRange'].'-'.$totalPaxSlabD['toRange'];
						}
					?>
					<option value="<?php echo $totalPaxSlabD['id']; ?>" <?php if($totalPaxSlabD['id'] == $transferData['totalPax']){ ?> selected="selected" <?php } ?>><?php echo  strip($paxrange2.'&nbsp;Pax'); ?></option>
					<?php } ?>
				</select>
			</div>				
		</td>
		<td align="right">
			<div class="addBtn " id="editBtn<?php echo ($transferData['id']); ?>" style="display: inline-flex;" onclick="openinboundpop('action=addTransferTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&transferQuoteId=<?php echo $transferData['id'];?>','1000px');" ><i class="fa fa-plus" aria-hidden="true"></i></div>
			
			<div class="editBtn" id="editBtn<?php echo ($transferData['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $transferData['id'];?>','editQuotationTransfer');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
			
			<div class="saveBtn" id="saveBtn<?php echo ($transferData['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $transferData['id'];?>','saveQuotationTransfer');"><i class="fa fa-save" aria-hidden="true"></i></div>		
			
			<div class="deleteBtn" style="display: inline-flex;"  onclick="if(confirm('Are you sure you want delete this transfer?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $transferData['id']; ?>','deleteQuotationTransfer');" ><i class="fa fa-trash" aria-hidden="true"></i></div>
		</td>
		</tr> 
		<!-- remarks section code started -->
		<tr><td colspan="8">Remarks: <?php echo $transferData['detail'];?></td></tr>
		<!-- remarks section code ended -->  
		</tbody>
		</table>
		</div>
		</td>
		</tr>
		<?php
		}
		}
	}
	if($sorting['serviceType'] == 'transportation' ){
		// quotation hotel data
		$c="";
		$c=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and id="'.$sorting['serviceId'].'"');
		if(mysqli_num_rows($c)>0){
		while($transportData=mysqli_fetch_array($c)){
	?>
	<tr> <td>
	<input name="serviceids[]" type="hidden"  value="<?php echo $sorting['id']; ?>">
	<input id="transferTypeInput<?php echo ($transportData['id']); ?>" type="hidden"  value="<?php echo $transportData['transferType']; ?>">
	<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;"><div class="editButton" style="width:30px;     height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
	<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">

	<thead>

	<tr>
	<th align="left" bgcolor="#ddd"  >Transport&nbsp;Name</th>
	<th align="left" bgcolor="#ddd" width="10%"style="display:none;">Vehicle Type</th>
	<th align="left" bgcolor="#ddd" width="10%">Vehicle Name </th>
	<th align="left" bgcolor="#ddd" width="10%">Vehicle Cost</th>
	<th align="left" bgcolor="#ddd" >No.&nbsp;of&nbsp;Vehicle</th>
	<th align="left" bgcolor="#ddd" >Total&nbsp;Cost</th>
	<th align="left" bgcolor="#ddd" >Pax&nbsp;Range</th>
	<th align="left" bgcolor="#ddd" width="10%" <?php if($transportData['costType']==2){ ?> style="display:none;" <?php } ?>>Days</th>
	<th align="right" bgcolor="#ddd" width="10%" >&nbsp;</th>
	</tr>
	</thead>

	<tbody>
	<?php
	$d=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$transportData['transferNameId'].'"');
	$transferData1=mysqli_fetch_array($d);
	if($transportData['transferName'] == '' || strlen($transportData['transferName']) < 1){
	$transferName =  $transferData1['transferName'];
	}else{
	$transferName =  $transportData['transferName'];
	}

	?>
	<tr>

	<td align="left">
	<div id="transferNameIdText<?php echo ($transportData['id']); ?>">
	<?php
	echo trim($transferName);
	?>
	</div>
	<div id="transferNameId<?php echo ($transportData['id']); ?>" style="display:none;">
	<input type="text" id="transferNameIdInput<?php echo ($transportData['id']); ?>"  value="<?php echo  strip($transferName); ?>">
	</div>					</td>
	<td align="left" style="display:none;">
	<div id="vehicleTypeText<?php echo ($transportData['id']); ?>">
	<?php
	//$select2='carType,model';
	$where2='id="'.$transportData['vehicleModelId'].'"';
	$rs2=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,$where2);
	$editresult2=mysqli_fetch_array($rs2);
	echo getVehicleTypeName($editresult2['carType']); ?>
	</div>
	<div id="vehicleType<?php echo ($transportData['id']); ?>" style="display:none;">
	<select id="vehicleTypeInput<?php echo ($transportData['id']); ?>"  class="selectbox"  onchange="getVehicleModel('<?php echo ($transportData['id']); ?>')">
	<?php
	$rs=GetPageRecord('name,id','vehicleTypeMaster',' 1 order by name asc');
	while($transportDatasd=mysqli_fetch_array($rs)){
	?>
	<option value="<?php echo strip($transportDatasd['id']); ?>" <?php if($editresult2['carType'] == strip($transportDatasd['id'])){ ?> selected="selected" <?php } ?>><?php echo strip($transportDatasd['name']); ?></option>
	<?php } ?>
	</select>
	</div>
	</td>
	<td align="left">
	<div id="vehicleModelIdText<?php echo ($transportData['id']); ?>"><?php echo $editresult2['model']; ?>	</div>
	<div id="vehicleModelId<?php echo ($transportData['id']); ?>" style="display:none;">
	<select id="vehicleModelIdInput<?php echo ($transportData['id']); ?>"  class="selectbox">
	<option value="">Select Model</option>
	<?php
	$select='*';
	$where=' 1 order by id asc';
	$rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where);
	while($transportData2=mysqli_fetch_array($rs)){
	?>
	<option value="<?php echo $transportData2['id']; ?>" <?php if($transportData2['id'] == $transportData['vehicleModelId']){ ?> selected="selected" <?php } ?>><?php echo $transportData2['model']; ?></option>
	<?php } ?>
	</select>
	</div>
	<script type="text/javascript">
	function getVehicleModel(id) {
	var vehicleType = $('#vehicleTypeInput'+id).val();
	$("#vehicleModelIdInput"+id).load('loadvehiclemodel.php?vehicleTypeId='+vehicleType);
	}
	</script>				    </td>
	<td align="left">
	<div id="vehicleCostText<?php echo ($transportData['id']); ?>"><?php echo  strip($transportData['vehicleCost']); ?></div>
	<div id="vehicleCost<?php echo ($transportData['id']); ?>" style="display:none;">
	<input type="text" id="vehicleCostInput<?php echo ($transportData['id']); ?>"  value="<?php echo  strip($transportData['vehicleCost']); ?>">
	</div> </td>
	<td align="left">
	<div id="noOfVehiclesText<?php echo ($transportData['id']); ?>"><?php echo  strip($transportData['noOfVehicles']); ?></div>
	<div id="noOfVehicles<?php echo ($transportData['id']); ?>" style="display:none;">
	<input type="text" id="noOfVehiclesInput<?php echo ($transportData['id']); ?>"  value="<?php echo  strip($transportData['noOfVehicles']); ?>">
	</div>
	</td>
	<td align="left">
	<div ><?php echo  round($transportData['vehicleCost']*$transportData['noOfVehicles']); ?></div>					 </td>
	<td align="left">
		<?php
		$tpxQ="";
		$tpxQ=GetPageRecord('*','totalPaxSlab',' 1 and id="'.$transportData['totalPax'].'"');
		$slabsData =  mysqli_fetch_array($tpxQ);
		if($slabsData['fromRange'] == $slabsData['toRange'] || $slabsData['toRange']==0){
			$paxrange = $slabsData['fromRange'];
		}else{
			$paxrange = $slabsData['fromRange'].'-'.$slabsData['toRange'];
		}
		?>
		<div id="paxSlabText<?php echo ($transportData['id']); ?>"><?php echo  strip($paxrange.'&nbsp;Pax'); ?></div>
		<div id="paxSlab<?php echo ($transportData['id']); ?>" style="display:none;">
			<select id="paxSlabInput<?php echo ($transportData['id']); ?>"  class="selectbox">
				<option value="">Select Model</option>
				<?php
				$tpxQ2='';
				$tpxQ2=GetPageRecord('*','totalPaxSlab',' 1 and quotationId="'.$quotationData['id'].'" and status=1 ');
				while($totalPaxSlabD=mysqli_fetch_array($tpxQ2)){
					if($totalPaxSlabD['fromRange'] == $totalPaxSlabD['toRange'] || $totalPaxSlabD['toRange']==0){
						$paxrange2 = $totalPaxSlabD['fromRange'];
					}else{
						$paxrange2 = $totalPaxSlabD['fromRange'].'-'.$totalPaxSlabD['toRange'];
					}
				?>
				<option value="<?php echo $totalPaxSlabD['id']; ?>" <?php if($totalPaxSlabD['id'] == $transportData['totalPax']){ ?> selected="selected" <?php } ?>><?php echo  strip($paxrange2.'&nbsp;Pax'); ?></option>
				<?php } ?>
			</select>
		</div>				
	</td>




	<td align="left" <?php if($transportData['costType']==2){ ?> style="display:none;" <?php } ?>><?php echo  strip($transportData['noOfDays']); ?> Days</td>
	<td align="right">
	<div class="addBtn " id="editBtn<?php echo ($transportData['id']); ?>" style="display: inline-flex;" onclick="openinboundpop('action=addTransferTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&transferQuoteId=<?php echo $transportData['id'];?>','1000px');" ><i class="fa fa-plus" aria-hidden="true"></i></div>

	<div class="editBtn" id="editBtn<?php echo ($transportData['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $transportData['id'];?>','editQuotationTransfer');"><i class="fa fa-pencil" aria-hidden="true"></i></div>

	<div class="saveBtn" id="saveBtn<?php echo ($transportData['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $transportData['id'];?>','saveQuotationTransfer');"><i class="fa fa-save" aria-hidden="true"></i></div>	
	
	<div class="deleteBtn" style="display: inline-flex;"  onclick="if(confirm('Are you sure you want delete this transfer?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $transportData['id']; ?>','deleteQuotationTransfer');" ><i class="fa fa-trash" aria-hidden="true"></i></div>

	</td>
	</tr>
 
		<?php if($transportData['detail']!='' && strlen(trim($transportData['detail']))>2){  ?>
		<tr>
			<td colspan="8">	
				Remarks: <?php echo $transportData['detail'];?>
			</td>
		</tr>
		<?php } ?>
		
	</tbody>
	</table>
	</div>

	</td>
	</tr>
	<?php
	}
		}	
	}
	if($sorting['serviceType'] == 'ferry' ){
		// quotation hotel data
		$rs1='';
		$rs1=GetPageRecord('*',_QUOTATION_FERRY_MASTER_,' quotationId="'.$quotationId.'" and id="'.$sorting['serviceId'].'"');
		if(mysqli_num_rows($rs1)>0){
		while($quotationFerryData=mysqli_fetch_array($rs1)){
			
		$d=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,' id="'.$quotationFerryData['serviceid'].'"');
		$ferryData=mysqli_fetch_array($d);
		?>
		<tr> <td>
		<input name="serviceids[]" type="hidden"  value="<?php echo $sorting['id']; ?>">
		<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;"><div class="editButton" style="width:30px;height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
		<thead>
			<tr>
			<th align="left" bgcolor="#ddd" >Ferry&nbsp;Service</th> 
			<th align="left" bgcolor="#ddd" >Ferry&nbsp;Name</th>
			<th align="left" bgcolor="#ddd" >Ferry&nbsp;Class</th>
			<th align="left" bgcolor="#ddd" >Adult&nbsp;Cost</th>
			<th align="left" bgcolor="#ddd" >Child&nbsp;Cost</th>
			<th align="left" bgcolor="#ddd" >Infant&nbsp;Cost</th>
			<th align="left" bgcolor="#ddd" >Proc.&nbsp;Fee</th>
			<th align="left" bgcolor="#ddd" >Misc.&nbsp;Cost</th>
			<th align="right" bgcolor="#ddd">&nbsp;</th>
			</tr>
		</thead>
		<tbody> 
		<tr>
		<td align="left"><?php echo trim($ferryData['name']); ?></td>
		<td align="left">
			<div id="ferryNameIdText<?php echo ($quotationFerryData['id']); ?>">
			<?php
			$ferryNamQuery1='';
			$ferryNamQuery1=GetPageRecord('name',_FERRY_NAME_MASTER_,'id="'.$quotationFerryData['ferryNameId'].'"');
			$ferryNamD1=mysqli_fetch_array($ferryNamQuery1);
			echo trim($ferryNamD1['name']);
			?>
			</div>
			<div id="ferryNameId<?php echo ($quotationFerryData['id']); ?>" style="display:none;">
			<select id="ferryNameIdInput<?php echo ($quotationFerryData['id']); ?>"  class="selectbox" >
			<?php
			$ferryNamQuery=GetPageRecord('name,id',_FERRY_NAME_MASTER_,' 1 order by name asc');
			while($ferryNamD=mysqli_fetch_array($ferryNamQuery)){
			?>
			<option value="<?php echo strip($ferryNamD['id']); ?>" <?php if($quotationFerryData['ferryNameId'] == strip($ferryNamD['id'])){ ?> selected="selected" <?php } ?>><?php echo strip($ferryNamD['name']); ?></option>
			<?php } ?>
			</select>
			</div>					
		</td>
		<td align="left">
			<div id="ferryClassText<?php echo ($quotationFerryData['id']); ?>">
			<?php
			$ferryClassQuery1='';
			$ferryClassQuery1=GetPageRecord('name',_FERRY_CLASS_MASTER_,'id="'.$quotationFerryData['ferryClass'].'"');
			$ferryClassD1=mysqli_fetch_array($ferryClassQuery1);
			echo trim($ferryClassD1['name']);
			?>
			</div>
			<div id="ferryClass<?php echo ($quotationFerryData['id']); ?>" style="display:none;">
			<select id="ferryClassInput<?php echo ($quotationFerryData['id']); ?>"  class="selectbox" >
			<?php
			$ferryClassQuery=GetPageRecord('name,id',_FERRY_CLASS_MASTER_,' 1 order by name asc');
			while($ferryClassD=mysqli_fetch_array($ferryClassQuery)){
			?>
			<option value="<?php echo strip($ferryClassD['id']); ?>" <?php if($quotationFerryData['ferryClass'] == strip($ferryClassD['id'])){ ?> selected="selected" <?php } ?>><?php echo strip($ferryClassD['name']); ?></option>
			<?php } ?>
			</select>
			</div>					
		</td>
		<td align="left">
			<div id="adultCostText<?php echo ($quotationFerryData['id']); ?>"><?php echo  strip($quotationFerryData['adultCost']); ?></div>
			<div id="adultCost<?php echo ($quotationFerryData['id']); ?>" style="display:none;">
				<input type="text" id="adultCostInput<?php echo ($quotationFerryData['id']); ?>"  value="<?php echo  strip($quotationFerryData['adultCost']); ?>">
			</div>					
		</td>
		<td align="left">
			<div id="childCostText<?php echo ($quotationFerryData['id']); ?>"><?php echo  strip($quotationFerryData['childCost']); ?></div>
			<div id="childCost<?php echo ($quotationFerryData['id']); ?>" style="display:none;">
				<input type="text" id="childCostInput<?php echo ($quotationFerryData['id']); ?>"  value="<?php echo  strip($quotationFerryData['childCost']); ?>">
			</div>					
		</td>
		<td align="left">
			<div id="infantCostText<?php echo ($quotationFerryData['id']); ?>"><?php echo  strip($quotationFerryData['infantCost']); ?></div>
			<div id="infantCost<?php echo ($quotationFerryData['id']); ?>" style="display:none;">
				<input type="text" id="infantCostInput<?php echo ($quotationFerryData['id']); ?>"  value="<?php echo  strip($quotationFerryData['infantCost']); ?>">
			</div>					
		</td>
		<td align="left">
			<div id="processingfeeText<?php echo ($quotationFerryData['id']); ?>"><?php echo  strip($quotationFerryData['processingfee']); ?></div>
			<div id="processingfee<?php echo ($quotationFerryData['id']); ?>" style="display:none;">
				<input type="text" id="processingfeeInput<?php echo ($quotationFerryData['id']); ?>" 
				value="<?php echo strip($quotationFerryData['processingfee']); ?>">
			</div>					
		</td>
		<td align="left">
			<div id="miscCostText<?php echo ($quotationFerryData['id']); ?>"><?php echo  strip($quotationFerryData['miscCost']); ?></div>
			<div id="miscCost<?php echo ($quotationFerryData['id']); ?>" style="display:none;">
				<input type="text" id="miscCostInput<?php echo ($quotationFerryData['id']); ?>"  value="<?php echo  strip($quotationFerryData['miscCost']); ?>">
			</div>					
		</td>

		<td align="right">
			<!-- <div class="addBtn " id="editBtn<?php echo ($quotationFerryData['id']); ?>" style="display: inline-flex;" onclick="openinboundpop('action=addTransferTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&transferQuoteId=<?php echo $quotationFerryData['id'];?>','1000px');" ><i class="fa fa-plus" aria-hidden="true"></i></div> -->
			
			<div class="editBtn" id="editBtn<?php echo ($quotationFerryData['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationFerryData['id'];?>','editQuotationFerry');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
			
			<div class="saveBtn" id="saveBtn<?php echo ($quotationFerryData['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationFerryData['id'];?>','saveQuotationFerry');"><i class="fa fa-save" aria-hidden="true"></i></div>		
		
			<div class="deleteBtn" style="display: inline-flex;"  onclick="if(confirm('Are you sure you want delete this transfer?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationFerryData['id']; ?>','deleteQuotationFerry');" ><i class="fa fa-trash" aria-hidden="true"></i></div>	
		</td>
		</tr>
		</tbody>
		</table>
		</div>
		</td>
		</tr>
		<?php
		}
		}
	}
	if($sorting['serviceType'] == 'guide'){
		
		$where1='';
		$where1=' queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'" and isGuestType=1 and id="'.$sorting['serviceId'].'" ';
		$rs1=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,$where1);
		if(mysqli_num_rows($rs1)>0){
		while($quotationGuideData=mysqli_fetch_array($rs1)){ ?>
		<tr><td>
		<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;">
		<div class="editButton" style="width:30px;height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
		<input name="serviceids[]" type="hidden" value="<?php echo $sorting['id']; ?>">
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
		<thead>
		<tr>
			<?php 
			$rs5='';
			$rs5=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$quotationGuideData['guideId'].'"');
			$GuideData5=mysqli_fetch_array($rs5);

			if(trim($quotationGuideData['dayType']) == 'fullday'){
				$dayType = "Full Day";
			}else{
				$dayType = "Half Day";
			}	
			 
			?>
			<th align="left" bgcolor="#ddd"><div style="font-size:15px;font-weight:500;margin: 3px 0 10px 0;"><strong><?php if($quotationGuideData['serviceType'] == 1 ){ echo "Porter"; }else{ echo "Tour Escort"; } ?></strong> - <?php 	echo strip($GuideData5['name']); ?></div></th>
		</tr>
		</thead>
		<tbody>
		<tr><td> 
			<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
				<thead>
				<tr>
				<th align="left" width="110"bgcolor="#ddd">Service Type</th>
				<th align="left" bgcolor="#ddd">Day Type</th>
				<?php if($quotationGuideData['serviceType'] == 0 ){ ?>
				<th align="left" bgcolor="#ddd">Pax&nbsp;Range</th>
				<?php } ?>
				<th align="left" bgcolor="#ddd">Pax&nbsp;Slab</th>
				<th align="left" bgcolor="#ddd">Total Days </th>
				<th align="left" bgcolor="#ddd">Per Day Cost </th>
				<th align="left" bgcolor="#ddd">Total Cost</th>
				<th align="center" width="110" bgcolor="#ddd">#</th>
				<th align="left" width="100" bgcolor="#ddd">&nbsp;</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					
					<td align="left">Normal</td>
					<td align="left"><?php  echo trim($dayType); ?></td>
					<?php if($quotationGuideData['serviceType'] == 0 ){ ?>
					<td align="left">
					<?php  if (strip($quotationGuideData['paxRange'])==0){ echo "All"; }else{ echo str_replace('_',' to ',$quotationGuideData['paxRange']);  } ?>
					</td>
					<?php } ?>
					<td align="left">
						<?php
						$tpxQ="";
						$tpxQ=GetPageRecord('*','totalPaxSlab',' 1 and id="'.$quotationGuideData['slabId'].'"');
						$slabsData =  mysqli_fetch_array($tpxQ);
						if($slabsData['fromRange'] == $slabsData['toRange'] || $slabsData['toRange']==0){
							$paxrange = $slabsData['fromRange'];
						}else{
							$paxrange = $slabsData['fromRange'].'-'.$slabsData['toRange'];
						}
						?>
						<div id="paxSlabText<?php echo ($quotationGuideData['id']); ?>"><?php echo  strip($paxrange.'&nbsp;Pax'); ?></div>
						<div id="paxSlab<?php echo ($quotationGuideData['id']); ?>" style="display:none;">
							<select id="paxSlabInput<?php echo ($quotationGuideData['id']); ?>"  class="selectbox">
							<option value="">Select Model</option>
							<?php
							$tpxQ2='';
							$tpxQ2=GetPageRecord('*','totalPaxSlab',' 1 and quotationId="'.$quotationData['id'].'" and status=1 ');
							while($totalPaxSlabD=mysqli_fetch_array($tpxQ2)){
								if($totalPaxSlabD['fromRange'] == $totalPaxSlabD['toRange'] || $totalPaxSlabD['toRange']==0){
									$paxrange2 = $totalPaxSlabD['fromRange'];
								}else{
									$paxrange2 = $totalPaxSlabD['fromRange'].'-'.$totalPaxSlabD['toRange'];
								}
								?>
								<option value="<?php echo $totalPaxSlabD['id']; ?>" <?php if($totalPaxSlabD['id'] == $quotationGuideData['slabId']){ ?> selected="selected" <?php } ?>><?php echo  strip($paxrange2.'&nbsp;Pax'); ?></option>
							<?php 
							} ?>
							</select>
						</div>				
					</td>
					<td align="left">
						<?php echo $quotationGuideData['totalDays']; ?> 
						<input type="hidden" id="totalDaysInput<?php echo ($quotationGuideData['id']); ?>" value="<?php echo $quotationGuideData['totalDays']; ?>" />
					</td>
					<td align="left">
						<div id="perDaycostText<?php echo ($quotationGuideData['id']); ?>"><?php echo  getCurrencyName($quotationGuideData['currencyId'])." ".strip($quotationGuideData['perDaycost']); ?></div>
						<div id="perDaycost<?php echo ($quotationGuideData['id']); ?>" style="display:none;">
						<input type="text" id="perDaycostInput<?php echo ($quotationGuideData['id']); ?>"  value="<?php echo  strip($quotationGuideData['perDaycost']); ?>">
						</div>					
					</td>
					<td align="left" ><span id="priceText<?php echo ($quotationGuideData['id']); ?>"><?php echo  getCurrencyName($quotationGuideData['currencyId'])." ".$quotationGuideData['price']; ?></span></td>
					<td align="left">
						<div class="viewMoreBtn" style="float:none;" title="Supplement" onClick="openinboundpop('action=addServiceGuide&stype=guideSupplement&dayId=<?php echo $QueryDaysData['id']; ?>&guideQuoteId=<?php echo $quotationGuideData['id'];?>','800px');">&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Supplement</div>
					</td>

					<td align="right">
						

						<div class="editBtn" id="editBtn<?php echo ($quotationGuideData['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationGuideData['id'];?>','editGuideQuotation');"><i class="fa fa-pencil" aria-hidden="true"></i></div>

						<div class="saveBtn" id="saveBtn<?php echo ($quotationGuideData['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationGuideData['id'];?>','saveGuideQuotation');"><i class="fa fa-save" aria-hidden="true"></i></div>		
						
						<div class="deleteBtn" style="display: inline-flex;" onclick="if(confirm('Are you sure you want delete this Tour Escort rule?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationGuideData['id']; ?>','deleteGuideQuotation');" ><i class="fa fa-trash" aria-hidden="true"></i></div>
					</td>
				</tr>
				<?php 
				$where12='';
				$guideQuoteId = $quotationGuideData['id'];
				$where12=' guideQuoteId="'.$guideQuoteId.'" and quotationId="'.$quotationId.'" and isSupplement=1 ';
				$rs12=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,$where12);
				while($quotationGuideSuppData=mysqli_fetch_array($rs12)){
				?>
				<tr>
					<td align="left"><?php echo ($quotationGuideSuppData['isGuestType']==1 && $quotationGuideSuppData['isSelectedFinal']==1 && $quotationGuideSuppData['isSupplement']==0 )?'Normal':'Supplement'; ?></td>
					<td align="left"><?php  echo ($dayType); ?></td>
					<?php if($quotationGuideSuppData['serviceType'] == 0 ){ ?>
					<td align="left">
					<?php  if (strip($quotationGuideSuppData['paxRange'])==0){ echo "All"; }else{ echo str_replace('_',' to ',$quotationGuideSuppData['paxRange']);  } ?>
					</td>
					<?php } ?>
					<td align="left">
						<?php
						$tpxQ="";
						$tpxQ=GetPageRecord('*','totalPaxSlab',' 1 and id="'.$quotationGuideSuppData['slabId'].'"');
						$slabsData =  mysqli_fetch_array($tpxQ);
						if($slabsData['fromRange'] == $slabsData['toRange'] || $slabsData['toRange']==0){
							$paxrange = $slabsData['fromRange'];
						}else{
							$paxrange = $slabsData['fromRange'].'-'.$slabsData['toRange'];
						}
						?>
						<div id="paxSlabText<?php echo ($quotationGuideSuppData['id']); ?>"><?php echo  strip($paxrange.'&nbsp;Pax'); ?></div>
						<div id="paxSlab<?php echo ($quotationGuideSuppData['id']); ?>" style="display:none;">
							<select id="paxSlabInput<?php echo ($quotationGuideSuppData['id']); ?>"  class="selectbox">
							<option value="">Select Model</option>
							<?php
							$tpxQ2='';
							$tpxQ2=GetPageRecord('*','totalPaxSlab',' 1 and quotationId="'.$quotationData['id'].'" and status=1 ');
							while($totalPaxSlabD=mysqli_fetch_array($tpxQ2)){
								if($totalPaxSlabD['fromRange'] == $totalPaxSlabD['toRange'] || $totalPaxSlabD['toRange']==0){
									$paxrange2 = $totalPaxSlabD['fromRange'];
								}else{
									$paxrange2 = $totalPaxSlabD['fromRange'].'-'.$totalPaxSlabD['toRange'];
								}
								?>
								<option value="<?php echo $totalPaxSlabD['id']; ?>" <?php if($totalPaxSlabD['id'] == $quotationGuideSuppData['slabId']){ ?> selected="selected" <?php } ?>><?php echo  strip($paxrange2.'&nbsp;Pax'); ?></option>
							<?php 
							} ?>
							</select>
						</div>				
					</td>
					<td align="left">
						<?php echo $quotationGuideSuppData['totalDays']; ?> 
						<input type="hidden" id="totalDaysInput<?php echo ($quotationGuideSuppData['id']); ?>" value="<?php echo $quotationGuideSuppData['totalDays']; ?>" />
					</td>
					<td align="left">
						<div id="perDaycostText<?php echo ($quotationGuideSuppData['id']); ?>"><?php echo  getCurrencyName($quotationGuideSuppData['currencyId'])." ".strip($quotationGuideSuppData['perDaycost']); ?></div>
						<div id="perDaycost<?php echo ($quotationGuideSuppData['id']); ?>" style="display:none;">
						<input type="text" id="perDaycostInput<?php echo ($quotationGuideSuppData['id']); ?>"  value="<?php echo  strip($quotationGuideSuppData['perDaycost']); ?>">
						</div>					
					</td>
					<td align="left" ><span id="priceText<?php echo ($quotationGuideSuppData['id']); ?>"><?php echo  getCurrencyName($quotationGuideSuppData['currencyId'])." ".$quotationGuideSuppData['price']; ?></span></td>
					<td align="left"></td>
					<td align="right">
						

						<div class="editBtn" id="editBtn<?php echo ($quotationGuideSuppData['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationGuideSuppData['id'];?>','editGuideQuotation');"><i class="fa fa-pencil" aria-hidden="true"></i></div>

						<div class="saveBtn" id="saveBtn<?php echo ($quotationGuideSuppData['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationGuideSuppData['id'];?>','saveGuideQuotation');"><i class="fa fa-save" aria-hidden="true"></i></div>	
						
						<div class="deleteBtn" style="display: inline-flex;" onclick="if(confirm('Are you sure you want delete this Tour Escort rule?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationGuideSuppData['id']; ?>','deleteGuideQuotation');" ><i class="fa fa-trash" aria-hidden="true"></i></div>
					</td>
				</tr>
				<?php	
				}	
				?>
				</tbody>
			</table>
		</td></tr>
		</tbody>
		</table>
		
		</div>
		</td></tr>
		<?php
		$n++;
		}
		}
	}
	if($sorting['serviceType'] == 'activity'){  
		$where1='';
		$where1=' queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'"  and id="'.$sorting['serviceId'].'"';
		$rs1=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where1);
		if(mysqli_num_rows($rs1)>0){
			while($quotationActivityData=mysqli_fetch_array($rs1)){

			$otherActivitySql=GetPageRecord('*','packageBuilderotherActivityMaster',' id ="'.$quotationActivityData['otherActivityName'].'" ');
			$ActivityData=mysqli_fetch_array($otherActivitySql);
			?>
			<tr>
			<td>

			<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;">
			<div class="editButton" style="width:30px;     height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
			<input name="serviceids[]" type="hidden"  value="<?php echo $sorting['id']; ?>">
			<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
			<thead>
			<tr> 
			<th align="left" bgcolor="#ddd">Sightseeing&nbsp;Name</th>
			<th align="left" bgcolor="#ddd">Total&nbsp;Sightseeing&nbsp;Cost </th>
			<th align="left" bgcolor="#ddd">Max&nbsp;Pax</th>
			<th align="left" bgcolor="#ddd">PerPax&nbsp;Cost</th>
			<th align="left" bgcolor="#ddd">Start/End Time</th>
			<th align="left" bgcolor="#ddd">&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			<tr> 
			<td align="left"><span class="style1">  <?php echo strip($ActivityData['otherActivityName']); ?></span></td>
			<td align="left">
			<div id="activityCostText<?php echo ($quotationActivityData['id']); ?>"><?php echo getCurrencyName($quotationActivityData['currencyId']).' '.strip($quotationActivityData['activityCost']); ?></div>
			<div id="activityCost<?php echo ($quotationActivityData['id']); ?>" style="display:none;">
			<input type="text" id="activityCostInput<?php echo ($quotationActivityData['id']); ?>"  value="<?php echo strip($quotationActivityData['activityCost']); ?>">
			</div>
			</td>

			<td align="left">
			<?php echo  strip($quotationActivityData['maxpax']); ?>
			<input type="hidden" id="maxpaxInput<?php echo ($quotationActivityData['id']); ?>" value="<?php echo strip($quotationActivityData['maxpax']); ?>">
			</td>

			<td align="left"> <?php echo  getCurrencyName($quotationActivityData['currencyId']).' '.strip($quotationActivityData['perPaxCost']); ?></td>
			<td align="left"> <?php
				$c="";
				$c=GetPageRecord('*','quotationActivityTimelineDetails',' hotelQuoteId="'.$quotationActivityData['id'].'" and quotationId="'.$quotationActivityData['quotationId'].'"');
				if(mysqli_num_rows($c)>0){
					$activityTimLData=mysqli_fetch_array($c);
					echo $startTime = date('H:i:s', strtotime($activityTimLData['startTime']));
					echo "/";
					echo $endTime = date('H:i:s', strtotime($activityTimLData['endTime']));
					
				}
			?></td>

			<td align="right">
			<div class="addBtn fa fa-plus" id="editBtn<?php echo ($quotationActivityData['id']); ?>" style="display: inline-flex;" onclick="openinboundpop('action=addActivityTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&activityQuoteId=<?php echo $quotationActivityData['id'];?>','1000px');" ></div>

			<div class="editBtn fa fa-pencil" id="editBtn<?php echo ($quotationActivityData['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationActivityData['id'];?>','editActivityQuotation');"></div>

			<div class="saveBtn fa fa-save" id="saveBtn<?php echo ($quotationActivityData['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationActivityData['id'];?>','saveActivityQuotation');"></div>					
			
			<div class="deleteBtn fa fa-trash" style="display: inline-flex;" onclick="if(confirm('Are you sure you want delete this activity?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationActivityData['id']; ?>','deleteActivityQuotation');" ></div>	
		
		</td>
			</tr>

			<?php if($transportData['detail']!='' && strlen(trim($transportData['detail']))>2){  ?>
			<tr>
				<td colspan="7">	
					Remarks: <?php echo $hotelQuotData['remark'];?>
				</td>
			</tr>
			<?php } ?>

			</tbody>
			</table>

			</div>
			</td>
			</tr>
			<?php
			$n++; }
		}
	} 
	if($sorting['serviceType'] == 'entrance'){
		$where1='';
		$where1=' queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'" and id="'.$sorting['serviceId'].'" ';
		$rs1=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,$where1); 
		if(mysqli_num_rows($rs1)>0){
			while($quotationEntranceData=mysqli_fetch_array($rs1)){

				$transferType = $quotationEntranceData['transferType'];
				$cur = getCurrencyName($quotationEntranceData['currencyId']);

				$where2=' id="'.$quotationEntranceData['entranceNameId'].'"';
				$rs2=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,$where2);
				$editresult2 = mysqli_fetch_array($rs2);
				?>
				<tr>
				<td>
				<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;"><div class="editButton" style="width:30px; height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
				<input name="serviceids[]" type="hidden"  value="<?php echo $sorting['id']; ?>">
				<input id="transferTypeInput<?php echo ($quotationEntranceData['id']); ?>" type="hidden"  value="<?php echo $transferType; ?>">
				<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
					<thead>
					<tr> 
					<th align="left" bgcolor="#ddd" width="200">Monument&nbsp;Name</th>
					<th align="left" bgcolor="#ddd">Ticket&nbsp;Adult</th>
					<th align="left" bgcolor="#ddd">Ticket&nbsp;Child</th>
					<th align="left" bgcolor="#ddd">Ticket&nbsp;Infant</th>
					<?php if($transferType ==1){ ?>
					<th align="left" bgcolor="#ddd">Transfer&nbsp;Adult</th>
					<th align="left" bgcolor="#ddd">Transfer&nbsp;Child</th>
					<th align="left" bgcolor="#ddd">Transfer&nbsp;Infant</th>
					<?php }else{ ?>
					<th align="left" bgcolor="#ddd">vehicle&nbsp;Name</th>
					<th align="left" bgcolor="#ddd">Vehicle&nbsp;Cost</th>
					<?php } ?>
					<th align="left" bgcolor="#ddd">Rep.&nbsp;Cost</th>
					<th align="left" bgcolor="#ddd">Start/End&nbsp;Time</th>
					<th align="left" bgcolor="#ddd">&nbsp; </th>
					</tr>
					</thead>
					<tbody>
					<tr> 
					<td align="left"><?php echo clean($editresult2['entranceName']); ?> </td>
					<td align="left">
						<div id="ticketAdultCostText<?php echo ($quotationEntranceData['id']); ?>"><?php echo $cur.' '.strip($quotationEntranceData['ticketAdultCost']); ?></div>
						<div id="ticketAdultCost<?php echo ($quotationEntranceData['id']); ?>" style="display:none;">
							<input style="width:92%" type="text" id="ticketAdultCostInput<?php echo ($quotationEntranceData['id']); ?>" value="<?php echo strip($quotationEntranceData['ticketAdultCost']);?>">
						</div>
					</td>
					<td align="left">
						<div id="ticketchildCostText<?php echo ($quotationEntranceData['id']); ?>"><?php echo $cur.' '.strip($quotationEntranceData['ticketchildCost']); ?></div>
						<div id="ticketchildCost<?php echo ($quotationEntranceData['id']); ?>" style="display:none;">
							<input style="width:92%" type="text" id="ticketchildCostInput<?php echo ($quotationEntranceData['id']); ?>" value="<?php echo strip($quotationEntranceData['ticketchildCost']);?>">
						</div>
					</td>
					<td align="left">
						<div id="ticketinfantCostText<?php echo ($quotationEntranceData['id']); ?>"><?php echo $cur.' '.strip($quotationEntranceData['ticketinfantCost']); ?></div>
						<div id="ticketinfantCost<?php echo ($quotationEntranceData['id']); ?>" style="display:none;">
							<input style="width:92%" type="text" id="ticketinfantCostInput<?php echo ($quotationEntranceData['id']); ?>" value="<?php echo strip($quotationEntranceData['ticketinfantCost']);?>">
						</div>
					</td>
					<?php if($transferType ==1){ ?>
					<td align="left">
						<div id="adultTransferCostText<?php echo ($quotationEntranceData['id']); ?>"><?php echo $cur.' '.strip($quotationEntranceData['adultCost']); ?></div>
						<div id="adultTransferCost<?php echo ($quotationEntranceData['id']); ?>" style="display:none;">
							<input style="width:92%" type="text" id="adultTransferCostInput<?php echo ($quotationEntranceData['id']); ?>" value="<?php echo strip($quotationEntranceData['adultCost']);?>">
						</div>
					</td>
					<td align="left">
						<div id="childTransferCostText<?php echo ($quotationEntranceData['id']); ?>"><?php echo $cur.' '.strip($quotationEntranceData['childCost']); ?></div>
						<div id="childTransferCost<?php echo ($quotationEntranceData['id']); ?>" style="display:none;">
							<input style="width:92%" type="text" id="childTransferCostInput<?php echo ($quotationEntranceData['id']); ?>" value="<?php echo strip($quotationEntranceData['childCost']);?>">
						</div>
					</td>
					<td align="left">
						<div id="infantTransferCostText<?php echo ($quotationEntranceData['id']); ?>"><?php echo $cur.' '.strip($quotationEntranceData['infantCost']); ?></div>
						<div id="infantTransferCost<?php echo ($quotationEntranceData['id']); ?>" style="display:none;">
							<input style="width:92%" type="text" id="infantTransferCostInput<?php echo ($quotationEntranceData['id']); ?>" value="<?php echo strip($quotationEntranceData['infantCost']);?>">
						</div>
					</td>
					<?php }else{ ?>
					<td align="left">
						<div id="vehicleIdText<?php echo ($quotationEntranceData['id']); ?>">
						<?php
						$vehicleIdQuery1='';
						$vehicleIdQuery1=GetPageRecord('model,carType',_VEHICLE_MASTER_MASTER_,'id="'.$quotationEntranceData['vehicleId'].'"');
						$vehicleIdD1=mysqli_fetch_array($vehicleIdQuery1);
						echo getVehicleTypeName($vehicleIdD1['carType']) . "( " . ucfirst($vehicleIdD1['model']).')';
						?>
						</div>
						<div id="vehicleId<?php echo ($quotationEntranceData['id']); ?>" style="display:none;">
						<select id="vehicleIdInput<?php echo ($quotationEntranceData['id']); ?>"  class="selectbox" >
						<?php
						$vehicleIdQuery=GetPageRecord('model,id,carType',_VEHICLE_MASTER_MASTER_,' 1 and model!="" and carType!="" order by model asc ');
						while($vehicleIdD=mysqli_fetch_array($vehicleIdQuery)){
						?>
						<option value="<?php echo strip($vehicleIdD['id']); ?>" <?php if($quotationEntranceData['vehicleId'] == strip($vehicleIdD['id'])){ ?> selected="selected" <?php } ?>><?php echo getVehicleTypeName($vehicleIdD['carType']) . "( " . ucfirst($vehicleIdD['model']).')';?> </option>
						<?php } ?>
						</select>
						</div>	
					</td>
					<td align="left">
						<div id="vehicleCostText<?php echo ($quotationEntranceData['id']); ?>"><?php echo $cur.' '.strip($quotationEntranceData['vehicleCost']); ?></div>
						<div id="vehicleCost<?php echo ($quotationEntranceData['id']); ?>" style="display:none;">
							<input style="width:92%" type="text" id="vehicleCostInput<?php echo ($quotationEntranceData['id']); ?>" value="<?php echo strip($quotationEntranceData['vehicleCost']);?>">
						</div>
					</td>
					<?php } ?>
					<td align="left">
						<div id="repCostText<?php echo ($quotationEntranceData['id']); ?>"><?php echo $cur.' '.strip($quotationEntranceData['repCost']); ?></div>
						<div id="repCost<?php echo ($quotationEntranceData['id']); ?>" style="display:none;">
							<input style="width:92%" type="text" id="repCostInput<?php echo ($quotationEntranceData['id']); ?>" value="<?php echo strip($quotationEntranceData['repCost']);?>">
						</div>
					</td>
					<td align="left"> <?php
						$c="";
						$c=GetPageRecord('*','quotationEntranceTimelineDetails',' hotelQuoteId="'.$quotationEntranceData['id'].'" and quotationId="'.$quotationEntranceData['quotationId'].'"');
						if(mysqli_num_rows($c)>0){
							$entranceTimLData=mysqli_fetch_array($c);
							echo $startTime = date('H:i:s', strtotime($entranceTimLData['startTime']));
							echo "/";
							echo $endTime = date('H:i:s', strtotime($entranceTimLData['endTime']));
						}
						?>
					</td>

					<td align="right">
						<div class="addBtn " id="editBtn<?php echo ($quotationEntranceData['id']); ?>" style="display: inline-flex;" onclick="openinboundpop('action=addEntranceTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&entranceQuoteId=<?php echo $quotationEntranceData['id'];?>','1000px');" ><i class="fa fa-plus" aria-hidden="true"></i></div>

						<div class="editBtn" id="editBtn<?php echo ($quotationEntranceData['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationEntranceData['id'];?>','editEntranceQuotation');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
						
						<div class="saveBtn" id="saveBtn<?php echo ($quotationEntranceData['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationEntranceData['id'];?>','saveEntranceQuotation');"><i class="fa fa-save" aria-hidden="true"></i></div>	
						
						<div class="deleteBtn" style="display: inline-flex;" onclick="if(confirm('Are you sure you want delete this Monument?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationEntranceData['id']; ?>','deleteEntranceQuotation');" ><i class="fa fa-trash" aria-hidden="true"></i></div>
					</td>
					</tr>
					<?php if($quotationEntranceData['detail']!='' && strlen(trim($quotationEntranceData['detail']))>2){  ?>
					<tr>
						<td colspan="8">	
							Remarks: <?php echo $quotationEntranceData['detail'];?>
						</td>
					</tr>
					<?php } ?>
					</tbody>
				</table> 
				</div>
				</td>
				</tr>
				<?php
				$n++; 
			}
		}
	}
	if($sorting['serviceType'] == 'mealplan'){
		$where1='';
		$where1=' queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'" and id="'.$sorting['serviceId'].'"';
		$rs1=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where1);
		if(mysqli_num_rows($rs1)>0){
		while($dmcroommastermain=mysqli_fetch_array($rs1)){

			$restmeal = GetPageRecord('*','restaurantsMealPlanMaster','id="'.$dmcroommastermain['mealType'].'"');
			$restmealData = mysqli_fetch_assoc($restmeal);
		?>
		<tr>
		<td>
		<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;"><div class="editButton" style="width:30px;     height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
		<input name="serviceids[]" type="hidden"  value="<?php echo $sorting['id']; ?>">
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
		<thead>
			<tr>
				<th align="left" bgcolor="#ddd">Restaurant</th>
				<th align="left" bgcolor="#ddd">Meal&nbsp;Type</th>
				<th align="left" bgcolor="#ddd">Per&nbsp;Pax&nbsp;Cost</th>
				<th align="left" bgcolor="#ddd">&nbsp;</th>
			</tr>
		</thead>
		
		<tbody>
			<tr>
				<td align="left"><span class="style1">  <?php echo strip($dmcroommastermain['mealPlanName']); ?></span></td>
				<td align="left"><?php echo $restmealData['name']; ?></td>
				<td align="left">
					<div id="adultCostText<?php echo ($dmcroommastermain['id']); ?>"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.strip($dmcroommastermain['adultCost']); ?></div>
					<div id="adultCost<?php echo ($dmcroommastermain['id']); ?>" style="display:none;">
						<input type="text" id="adultCostInput<?php echo ($dmcroommastermain['id']); ?>"  value="<?php echo strip($dmcroommastermain['adultCost']); ?>">
					</div>							</td>
					<td align="right">
						
						<div class="editBtn" id="editBtn<?php echo ($dmcroommastermain['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $dmcroommastermain['id'];?>','editMealPlanQuotation');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
						
						<div class="saveBtn" id="saveBtn<?php echo ($dmcroommastermain['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $dmcroommastermain['id'];?>','saveMealPlanQuotation');"><i class="fa fa-save" aria-hidden="true"></i></div>	
					
						<div class="deleteBtn" style="display: inline-flex;" onclick="if(confirm('Are you sure you want delete this Restaurant?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $dmcroommastermain['id']; ?>','deleteMealPlanQuotation');" ><i class="fa fa-trash" aria-hidden="true"></i></div>
					
					</td>
					</tr>
				</tbody>
			</table>
		</div>
		</td>
		</tr>
		<?php
		$n++; }
		}
	}
	if($sorting['serviceType'] == 'flight'){
		$where1='';
		$where1=' queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'" and id="'.$sorting['serviceId'].'"';
		$rs1=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where1);
		if(mysqli_num_rows($rs1)>0){
		?>
		<tr><td>
			<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;" ><div class="editButton" style="width:30px;     height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
				<input name="serviceids[]" type="hidden" value="<?php echo $sorting['id']; ?>">
				<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="trains tablesorter gridtable">
				<thead>
				<tr>
				<th width="15%" align="left" bgcolor="#ddd">Flight&nbsp;Name</th>
				<th width="10%" align="left" bgcolor="#ddd">Flight&nbsp;Number</th>
				<th width="10%" align="left" bgcolor="#ddd">Flight&nbsp;Class</th>
				<th width="18%" align="left" bgcolor="#ddd">From&nbsp;-&nbsp;To</th>
				<th width="10%" align="left" bgcolor="#ddd">Adult&nbsp;Cost</th>
				<th width="10%" align="left" bgcolor="#ddd">Child&nbsp;Cost</th>
				<th width="10%" align="left" bgcolor="#ddd">Infant&nbsp;Cost</th>
				<th width="16%" align="left" bgcolor="#ddd">Flight&nbsp;Date/&nbsp;Time</th>
				<th width="6%" align="left" bgcolor="#ddd">&nbsp;&nbsp;&nbsp;</th>
				</tr>
				</thead>
				<tbody>
				<?php 
				while($quotationFlightData=mysqli_fetch_array($rs1)){

				$flightTypeLable ="";
				if($quotationFlightData['isLocalEscort']==1){
			        $flightTypeLable .= "Local,";
			    }
			    if($quotationFlightData['isForeignEscort']==1){
			        $flightTypeLable .= "Foreign,";
			    }
			    if($quotationFlightData['isGuestType']==1){
			        $flightTypeLable .= "Guest,";
			    }
			    $curr = getCurrencyName($quotationFlightData['currencyId']);

				$aF = GetPageRecord('*','flightTimeLineMaster','quotationId="'.$quotationFlightData['quotationId'].'" and flightQuoteId="'.$quotationFlightData['id'].'" and flightId="'.$quotationFlightData['flightId'].'" and dayId="'.$QueryDaysData['id'].'"');
				$timeData = mysqli_fetch_assoc($aF);
				    ?>
				<tr>
					<td align="left">
						<span class="style1">  
						<?php
						$rs5=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$quotationFlightData['flightId'].'"');
						$GuideData5=mysqli_fetch_array($rs5);
						echo strip($GuideData5['flightName']);
						?>(<?php echo rtrim($flightTypeLable,',');?>) </span>
					</td>
					<td align="left">
						<div id="flightNumberText<?php echo ($quotationFlightData['id']); ?>"><?php echo strip($quotationFlightData['flightNumber']); ?></div>
						<div id="flightNumber<?php echo ($quotationFlightData['id']); ?>" style="display:none;">
							<input type="text" id="flightNumberInput<?php echo ($quotationFlightData['id']); ?>"  value="<?php echo strip($quotationFlightData['flightNumber']); ?>">
						</div>							
					</td>
					
					<td align="left">
						<div id="flightClassText<?php echo ($quotationFlightData['id']); ?>">
						<?php echo $quotationFlightData['flightClass']; ?>								
						</div>
						<div id="flightClass<?php echo ($quotationFlightData['id']); ?>" style="display:none;">
							
							<select id="flightClassInput<?php echo ($quotationFlightData['id']); ?>" class="selectbox" >
								<option value="First_Class" <?php if($quotationFlightData['flightClass'] == 'First_Class'){ ?>selected="selected"<?php } ?>>First Class</option>
								<option value="Business_Class" <?php if($quotationFlightData['flightClass'] == 'Business_Class'){ ?>selected="selected"<?php } ?>>Business Class</option>
								<option value="Economy_Class" <?php if($quotationFlightData['flightClass'] == 'Economy_Class'){ ?>selected="selected"<?php } ?>>Economy Class</option>
								<option value="Premium_Economy_Class" <?php if($quotationFlightData['flightClass'] == 'Premium_Economy_Class'){ ?>selected="selected"<?php } ?>>Premium Economy Class</option>
							</select>
						</div>							
					</td>
						
					<td align="left">
						<div style="text-align: center;">
						<div id="departureFromText<?php echo ($quotationFlightData['id']); ?>"> <?php
							echo getDestination($quotationFlightData['departureFrom']);
						?> </div>
						<div class="hideto<?php echo ($quotationFlightData['id']); ?>">to</div>
						<div id="arrivalToText<?php echo ($quotationFlightData['id']); ?>"> <?php
							echo getDestination($quotationFlightData['arrivalTo']);?> </div>
					</div>
					<div style="display: grid;grid-template-columns: auto auto;grid-gap: 10px;">
						<div id="departureFrom<?php echo ($quotationFlightData['id']); ?>" style="display:none;">
							<select id="departureFromInput<?php echo ($quotationFlightData['id']); ?>" class="selectbox"   >
								<?php
								$a11=GetPageRecord('*',_DESTINATION_MASTER_,' 1 and deletestatus=0 and status=1');
								while($destData1=mysqli_fetch_array($a11)){
								?>
								<option value="<?php echo strip($destData1['id']); ?>" <?php if($quotationFlightData['departureFrom'] == $destData1['id']){ ?>selected="selected"<?php } ?> ><?php echo strip($destData1['name']);?></option>
								<?php
								} ?>
							</select>
						</div> 	
						<div id="arrivalTo<?php echo ($quotationFlightData['id']); ?>" style="display:none;">
							<select id="arrivalToInput<?php echo ($quotationFlightData['id']); ?>" class="selectbox"   >
								<?php
								$a22=GetPageRecord('*',_DESTINATION_MASTER_,' 1 and deletestatus=0 and status=1');
								while($cityI2=mysqli_fetch_array($a22)){
								?>
								<option value="<?php echo strip($cityI2['id']); ?>" <?php if($quotationFlightData['arrivalTo'] == $cityI2['id']){ ?>selected="selected"<?php } ?> ><?php echo strip($cityI2['name']);?></option>
								<?php
								} ?>
							</select>
						</div>
						</div>						
					</td>
						
						
					<td align="left">
						<div id="adultCostText<?php echo ($quotationFlightData['id']); ?>"><?php echo $curr.' '.strip($quotationFlightData['adultCost']); ?></div>
						<div id="adultCost<?php echo ($quotationFlightData['id']); ?>" style="display:none;">
							<input type="text" id="adultCostInput<?php echo ($quotationFlightData['id']); ?>"  value="<?php echo strip($quotationFlightData['adultCost']); ?>">
						</div>							
					</td>
					<td align="left">
						<div id="childCostText<?php echo ($quotationFlightData['id']); ?>"><?php echo $curr.' '.strip($quotationFlightData['childCost']); ?></div>
						<div id="childCost<?php echo ($quotationFlightData['id']); ?>" style="display:none;">
							<input type="text" id="childCostInput<?php echo ($quotationFlightData['id']); ?>"  value="<?php echo strip($quotationFlightData['childCost']); ?>">
						</div>							
					</td>
					<td align="left">
						<div id="infantCostText<?php echo ($quotationFlightData['id']); ?>"><?php echo $curr.' '.strip($quotationFlightData['infantCost']); ?></div>
						<div id="infantCost<?php echo ($quotationFlightData['id']); ?>" style="display:none;">
							<input type="text" id="infantCostInput<?php echo ($quotationFlightData['id']); ?>"  value="<?php echo strip($quotationFlightData['infantCost']); ?>">
						</div>							
					</td>

					<td align="left">
						<?php if($timeData['flightId']!='' && $timeData['quotationId']!='' && $timeData['flightQuoteId']!=''){ ?> 
						<div id="arrivalDate<?php echo ($timeData['id']); ?>"><?php echo date('d-m-Y',strtotime($timeData['departureDate'])).'<br>'.date('H:i:s',strtotime($timeData['departureTime'])); ?></div>
						<?php } ?>				
					</td>
					<td align="right">
						
						<div class="addBtn " id="editBtn<?php echo ($quotationFlightData['id']); ?>" style="display: inline-flex;" onclick="openinboundpop('action=addFlightTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&flightQuoteId=<?php echo $quotationFlightData['id'];?>&flightId=<?php echo $quotationFlightData['flightId']; ?>','1000px');" ><i class="fa fa-plus" aria-hidden="true"></i></div>

						<div class="editBtn" id="editBtn<?php echo ($quotationFlightData['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationFlightData['id'];?>','editFlightQuotation');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
						
						<div class="saveBtn" id="saveBtn<?php echo ($quotationFlightData['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationFlightData['id'];?>','saveFlightQuotation');"><i class="fa fa-save" aria-hidden="true"></i></div>	

						<div class="deleteBtn" style="display: inline-flex;" onclick="if(confirm('Are you sure you want delete this Flight?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationFlightData['id']; ?>','deleteFlightQuotation');" ><i class="fa fa-trash" aria-hidden="true"></i></div>					
					</td>
				</tr>
				<?php  $n++; 
				} 
				?>
				</tbody>
				</table>
				</div>
			</td>
		</tr>
		<?php 
		}
	}
	if($sorting['serviceType'] == 'train'){
		$where1='';
		$where1=' queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'" and id="'.$sorting['serviceId'].'"';
		$rs1=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where1);
		if(mysqli_num_rows($rs1)>0){
			?>
			<tr><td><div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;"><div class="editButton" style="width:30px;     height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>

			<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="trains tablesorter gridtable">
			<?php
			while($quotationTrainData=mysqli_fetch_array($rs1)){
				$trainTypeLable ="";
				if($quotationTrainData['isLocalEscort']==1){
			        $trainTypeLable .= "Local,";
			    }
			    if($quotationTrainData['isForeignEscort']==1){
			        $trainTypeLable .= "Foreign,";
			    }
			    if($quotationTrainData['isGuestType']==1){
			        $trainTypeLable .= "Guest,";
			    }
				// echo $n;
			    // if($n == 1){
				    ?>
					<thead>
					<tr>
					<th width="16%" align="left" bgcolor="#ddd">Train&nbsp;Name(<?php echo rtrim($trainTypeLable,',');?>)</th> 
					<th width="13%" align="left" bgcolor="#ddd">Train&nbsp;Number</th>
					<th width="11%" align="left" bgcolor="#ddd">Train&nbsp;Class</th>
					<th width="18%" align="left" bgcolor="#ddd">Departure&nbsp;Arrival</th>
					<th width="16%" align="left" bgcolor="#ddd">Departure&nbsp;Arrival Time</th>
					<th width="13%" align="left" bgcolor="#ddd">Adult&nbsp;Cost</th>
					<th width="13%" align="left" bgcolor="#ddd">Child&nbsp;Cost</th>
					<th width="13%" align="left" bgcolor="#ddd">Infant&nbsp;Cost</th>
					<th width="6%" align="left" bgcolor="#ddd">&nbsp;&nbsp;&nbsp;</th>
					</tr>
					</thead>
					<tbody>
				    <?php
			    // }
			?>
			<tr>
				<td align="left">
					<input name="serviceids[]" type="hidden"  value="<?php echo $sorting['id']; ?>">
					<span class="style1">  
					<?php
					$rs5=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$quotationTrainData['trainId'].'"');
					$GuideData5=mysqli_fetch_array($rs5);
					echo strip($GuideData5['trainName']);
					?></span><br>{<?php
					if($quotationTrainData['journeyType'] == 'overnight_journey'){ echo "Overnight"; }else{ echo "Day Journey"; } ?>}
				</td> 
				<td align="left">
					<div id="trainNumberText<?php echo ($quotationTrainData['id']); ?>"><?php echo strip($quotationTrainData['trainNumber']); ?></div>
					<div id="trainNumber<?php echo ($quotationTrainData['id']); ?>" style="display:none;">
						<input type="text" id="trainNumberInput<?php echo ($quotationTrainData['id']); ?>"  value="<?php echo strip($quotationTrainData['trainNumber']); ?>">
					</div>							
				</td>
					
				<td align="left">
					<div id="trainClassText<?php echo ($quotationTrainData['id']); ?>">
						<?php echo $quotationTrainData['trainClass']; ?>								
					</div>
					<div id="trainClass<?php echo ($quotationTrainData['id']); ?>" style="display:none;">
						
						<select id="trainClassInput<?php echo ($quotationTrainData['id']); ?>" class="selectbox" >
							<option value="">All</option>
							<option value="AC First Class" <?php if($quotationTrainData['trainClass'] == 'AC First Class'){ ?>selected="selected"<?php } ?>>AC First Class</option>
							<option value="AC 2-Tier" <?php if($quotationTrainData['trainClass'] == 'AC 2-Tier'){ ?>selected="selected"<?php } ?>>AC 2-Tier</option>
							<option value="AC 3-Tier" <?php if($quotationTrainData['trainClass'] == 'AC 3-Tier'){ ?>selected="selected"<?php } ?>>AC 3-Tier	</option>
							<option value="First Class" <?php if($quotationTrainData['trainClass'] == 'First Class'){ ?>selected="selected"<?php } ?>>First Class	</option>
							<option value="AC Chair Car" <?php if($quotationTrainData['trainClass'] == 'AC Chair Car'){ ?>selected="selected"<?php } ?>>AC Chair Car</option>
							<option value="Sleeper" <?php if($quotationTrainData['trainClass'] == 'Sleeper'){ ?>selected="selected"<?php } ?>>Sleeper</option>
							<option value="Second Sitting" <?php if($quotationTrainData['trainClass'] == 'Second Sitting'){ ?>selected="selected"<?php } ?>>Second Sitting</option>
						</select>
					</div>							
				</td>
				
				<td align="left">
					<div style="text-align: center;">
						<div id="departureFromText<?php echo ($quotationTrainData['id']); ?>"> <?php 
							echo getDestination($quotationTrainData['departureFrom']);
						?> </div>
						<div class="hideto<?php echo ($quotationTrainData['id']); ?>"> To </div>
						<div id="arrivalToText<?php echo ($quotationTrainData['id']); ?>"> <?php
							echo getDestination($quotationTrainData['arrivalTo']);
						?> </div>
					</div>
					<div style="display: grid;grid-template-columns: auto auto;grid-gap: 10px;">
						<div id="departureFrom<?php echo ($quotationTrainData['id']); ?>" style="display:none;">
							<select id="departureFromInput<?php echo ($quotationTrainData['id']); ?>" class="selectbox"   >
								<?php
								$a11=GetPageRecord('*',_DESTINATION_MASTER_,' 1 and deletestatus=0 and status=1');
								while($destData1=mysqli_fetch_array($a11)){
								?>
								<option value="<?php echo strip($destData1['id']); ?>" <?php if($quotationTrainData['departureFrom'] == $destData1['id']){ ?>selected="selected"<?php } ?> ><?php echo strip($destData1['name']);?></option>
								<?php
								} ?>
							</select>
						</div> 	
						<div id="arrivalTo<?php echo ($quotationTrainData['id']); ?>" style="display:none;">
							<select id="arrivalToInput<?php echo ($quotationTrainData['id']); ?>" class="selectbox"   >
								<?php
								$a22=GetPageRecord('*',_DESTINATION_MASTER_,' 1 and deletestatus=0 and status=1');
								while($cityI2=mysqli_fetch_array($a22)){
								?>
								<option value="<?php echo strip($cityI2['id']); ?>" <?php if($quotationTrainData['arrivalTo'] == $cityI2['id']){ ?>selected="selected"<?php } ?> ><?php echo strip($cityI2['name']);?></option>
								<?php
								} ?>
							</select>
						</div>
					</div>						
				</td>
					
				<td align="left">
				<div style="text-align: center;">
					<div id="departureFromTime<?php echo ($quotationTrainData['id']); ?>"> <?php
						echo $quotationTrainData['departureTime'];
					?> </div>
					<div class="hideto<?php echo ($quotationTrainData['id']); ?>"> To </div>
					<div id="arrivalToTime<?php echo ($quotationTrainData['id']); ?>"> <?php
						echo $quotationTrainData['arrivalTime'];
					?> </div>
				</div>
				<div style="display: grid;grid-template-columns: auto auto;grid-gap: 10px;">
					<div id="departureTrainTime<?php echo ($quotationTrainData['id']); ?>" style="display:none;">
						<input type="text" id="departureTimeInput<?php echo ($quotationTrainData['id']); ?>" name="departureTime" style="text-align:left;width:90%;padding: 3px;
		    border: 1px solid #ccc;border-radius: 2px;" class="gridfield  timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true"value="<?php echo date('H:i', strtotime($quotationTrainData['departureTime'])); ?>" />
						
					</div> 	
					<div id="arrivalTrainTime<?php echo ($quotationTrainData['id']); ?>" style="display:none;">
						<input type="text" id="arrivalTimeInput<?php echo ($quotationTrainData['id']); ?>" name="arrivalTime" style="text-align:left;width:90%;padding: 3px;
		    border: 1px solid #ccc;border-radius: 2px;" class="gridfield  timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo date('H:i', strtotime($quotationTrainData['arrivalTime'])); ?>" />
					</div>
					</div>		
					<script type="text/javascript" src="js/jquery.timepicker.js"></script> 
			<script src="plugins/select2/select2.full.min.js"></script> 
		 	<script type="text/javascript">
				$(document).ready(function(){
					 $('.timepicker2').timepicker();	
					$('.select2').select2(); 
				 
				});  
			</script>								
				</td>
					
					
				<td align="left">
					<div id="adultCostText<?php echo ($quotationTrainData['id']); ?>"><?php echo strip($quotationTrainData['adultCost']); ?></div>
					<div id="adultCost<?php echo ($quotationTrainData['id']); ?>" style="display:none;">
						<input type="text" id="adultCostInput<?php echo ($quotationTrainData['id']); ?>"  value="<?php echo strip($quotationTrainData['adultCost']); ?>">
					</div>							
				</td>
				<td align="left">
					<div id="childCostText<?php echo ($quotationTrainData['id']); ?>"><?php echo strip($quotationTrainData['childCost']); ?></div>
					<div id="childCost<?php echo ($quotationTrainData['id']); ?>" style="display:none;">
						<input type="text" id="childCostInput<?php echo ($quotationTrainData['id']); ?>"  value="<?php echo strip($quotationTrainData['childCost']); ?>">
					</div>							
				</td>
				<td align="left">
					<div id="infantCostText<?php echo ($quotationTrainData['id']); ?>"><?php echo strip($quotationTrainData['infantCost']); ?></div>
					<div id="infantCost<?php echo ($quotationTrainData['id']); ?>" style="display:none;">
						<input type="text" id="infantCostInput<?php echo ($quotationTrainData['id']); ?>"  value="<?php echo strip($quotationTrainData['infantCost']); ?>">
					</div>							
				</td>
				<td align="right">
					
				

					<div class="editBtn" id="editBtn<?php echo ($quotationTrainData['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationTrainData['id'];?>','editTrainQuotation');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
					
					<div class="saveBtn" id="saveBtn<?php echo ($quotationTrainData['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationTrainData['id'];?>','saveTrainQuotation');"><i class="fa fa-save" aria-hidden="true"></i></div>
					
					<div class="deleteBtn" style="display: inline-flex;" onclick="if(confirm('Are you sure you want delete this Train?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationTrainData['id']; ?>','deleteTrainQuotation');" ><i class="fa fa-trash" aria-hidden="true"></i></div>
				</td>
			</tr>
			<?php  $n++;
			} ?>
		</tbody>
		</table>

		</div>
		</td>
		</tr>
		<?php 
		}
	}
	if($sorting['serviceType'] == 'additional'){
		$where1='';
		$where1=' queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'"  and id="'.$sorting['serviceId'].'" ';
		$rs1=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$where1);
		if(mysqli_num_rows($rs1)>0){
			while($quotationExtraData2=mysqli_fetch_array($rs1)){ 

				$rs1=GetPageRecord('*','extraQuotation','id="'.$quotationExtraData2['additionalId'].'"');
				$extraData=mysqli_fetch_array($rs1);

		?>
		<tr>
		<td>
		<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;">
		<div class="editButton" style="width:30px;     height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
		<input name="serviceids[]" type="hidden"  value="<?php echo $sorting['id']; ?>">
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
			<thead>
				<tr>
					<th align="left" bgcolor="#ddd">Additional</th>
					<?php if($quotationExtraData2['adultCost']>0){ ?>
					<th align="left" bgcolor="#ddd">Per&nbsp;Pax&nbsp;Cost</th>
					<?php } if($quotationExtraData2['groupCost']>0){ ?>
					<th align="left" bgcolor="#ddd">Group&nbsp;Cost</th>
					<?php } ?>	
					<th align="left" bgcolor="#ddd">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td align="left"><span class="style1">
						<?php
							echo clean($extraData['name']);
						?>
						</span>
					</td>
					<?php if($quotationExtraData2['adultCost']>0){ ?>
					<td align="left">
						<div id="adultCostText<?php echo ($quotationExtraData2['id']); ?>"><?php echo getCurrencyName($quotationExtraData2['currencyId']).' '.strip($quotationExtraData2['adultCost']); ?></div>
						<div id="adultCost<?php echo ($quotationExtraData2['id']); ?>" style="display:none;">
							<input name="text" type="text" id="adultCostInput<?php echo ($quotationExtraData2['id']); ?>"  value="<?php echo strip($quotationExtraData2['adultCost']); ?>">
						</div>
					</td>
					<?php } if($quotationExtraData2['groupCost']>0){ ?>
					<td align="left"><div id="groupCostText<?php echo ($quotationExtraData2['id']); ?>"><?php echo  getCurrencyName($quotationExtraData2['currencyId']).' '.strip($quotationExtraData2['groupCost']); ?></div>
						<div id="groupCost<?php echo ($quotationExtraData2['id']); ?>" style="display:none;">
							<input name="text" type="text" id="groupCostInput<?php echo ($quotationExtraData2['id']); ?>"  value="<?php echo  strip($quotationExtraData2['groupCost']); ?>">
						</div>
					</td>
					<?php } ?>	
					<td align="right">
						
						<div class="editBtn" id="editBtn<?php echo ($quotationExtraData2['id']); ?>"  style="display: inline-flex;" onClick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationExtraData2['id'];?>','editAdditionalQuotation');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
						
						<div class="saveBtn" id="saveBtn<?php echo ($quotationExtraData2['id']); ?>"  style="display: inline-flex;display:none;" onClick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationExtraData2['id'];?>','saveAdditionalQuotation');"><i class="fa fa-save" aria-hidden="true"></i></div>

						<div class="deleteBtn" style="display: inline-flex;" onClick="if(confirm('Are you sure you want delete this Additional?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationExtraData2['id']; ?>','deleteAdditionalQuotation');" ><i class="fa fa-trash" aria-hidden="true"></i></div>
					</td>
				</tr>
			</tbody>
			</table>
		</div>
		</td>
		</tr>
		<?php
		$n++;
			}
		}
	}
}
?>
</tbody>
</table>
																																
<script>
function deleteQuotationService<?php echo ($QueryDaysData['id']);?>(serviceId,action){
	$('#hoteldivHiddens<?php echo ($QueryDaysData['id']);?>').load('inboundpop.php?action='+action+'&quotationId=<?php echo $quotationId;?>&serviceId='+serviceId);
}
//editQuotationService('96','editAdditionalQuotation');
function editQuotationService<?php echo ($QueryDaysData['id']);?>(serviceId,action){
	if(action=="editQuotationHotel"){
		//mealPlan roomType
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #singleoccupancyText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #doubleoccupancyText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childwithoutbedText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #roomGSTText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childwithbedText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #breakfastText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #mealPlanText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #extraBedText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #roomTypeText'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #sixBedRoomText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #eightBedRoomText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #tenBedRoomText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #quadRoomText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #teenRoomText'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #complimentaryLunchText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #complimentaryDinnerText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #editBtn'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childbreakfastText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childdinnerText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childlunchText'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #singleoccupancy'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #doubleoccupancy'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childwithoutbed'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #roomGST'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #lunch'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #dinner'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childwithbed'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #breakfast'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #extraBed'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #mealPlan'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #roomType'+serviceId).show();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #sixBedRoom'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #eightBedRoom'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #tenBedRoom'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #quadRoom'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #teenRoom'+serviceId).show();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #complimentaryLunch'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #complimentaryDinner'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #saveBtn'+serviceId).show();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childbreakfast'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childlunch'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childdinner'+serviceId).show();
	}
	if(action=="editQuotationRoomSupplement"){
		//mealPlan roomType
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppsingleoccupancyText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppdoubleoccupancyText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppchildwithoutbedText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppchildwithbedText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppbreakfastText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppmealPlanText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppextraBedText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppcomplimentaryLunchText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppcomplimentaryDinnerText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SupproomTypeText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppeditBtn'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppchildbreakfastText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppchildlunchText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppchilddinnerText'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppSixBedRoomText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppEightBedRoomText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppTenBedRoomText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppTeenRoomText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppQuadRoomText'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #Suppsingleoccupancy'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #Suppdoubleoccupancy'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #Suppchildwithoutbed'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #Suppchildwithbed'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #Suppbreakfast'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppextraBed'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppmealPlan'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SupproomType'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppcomplimentaryLunch'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppcomplimentaryDinner'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppsaveBtn'+serviceId).show();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppchildbreakfast'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppchildlunch'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppchilddinner'+serviceId).show();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppSixBedRoom'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppEightBedRoom'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppTenBedRoom'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppTeenRoom'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #suppQuadRoom'+serviceId).show();
	}
	if(action=="editTrainQuotation"){
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #trainClassText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #trainNumberText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #departureFromText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #arrivalToText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #departureFromTime'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #arrivalToTime'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> .hideto'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #infantCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #editBtn'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #trainClass'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #trainNumber'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #departureFrom'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #arrivalTo'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #departureTrainTime'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #arrivalTrainTime'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #infantCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #saveBtn'+serviceId).show();
	}
	if(action=="editFlightQuotation"){
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #flightClassText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #flightNumberText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #departureFromText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #arrivalToText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #departureFromTime'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #arrivalToTime'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> .hideto'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #infantCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #editBtn'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #flightClass'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #flightNumber'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #departureFrom'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #arrivalTo'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #departureFlightTime'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #arrivalFlightTime'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #infantCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #saveBtn'+serviceId).show();
	}
	
	if(action=="editQuotationTransfer"){
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #transferNameIdText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleTypeText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleModelIdText'+serviceId).hide();
		
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #infantCostText'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #editBtn'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #noOfVehiclesText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #paxSlabText'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #transferNameId'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleType'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleModelId'+serviceId).show();
		
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #infantCost'+serviceId).show();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #noOfVehicles'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #paxSlab'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #saveBtn'+serviceId).show();
	}
	if(action=="editQuotationFerry"){
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #ferryNameIdText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #ferryClassText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #processingfeeText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #miscCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #editBtn'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #ferryNameId'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #ferryClass'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #processingfee'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #miscCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #saveBtn'+serviceId).show();
	}
	if(action=="editGuideQuotation"){
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #perDaycostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #editBtn'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #paxSlabText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #paxSlab'+serviceId).show();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #perDaycost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #saveBtn'+serviceId).show();
	}
	if(action=="editActivityQuotation"){
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #activityCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #maxpaxText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #perPaxCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #editBtn'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #activityCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #maxpax'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #perPaxCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #saveBtn'+serviceId).show();
	}
	if(action=="editEntranceQuotation"){
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #ticketAdultCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #ticketchildCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #ticketinfantCostText'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #adultTransferCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childTransferCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #infantTransferCostText'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleIdText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleCostText'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #repCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #editBtn'+serviceId).hide();


		$('#tbbody<?php echo ($QueryDaysData['id']);?> #ticketAdultCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #ticketchildCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #ticketinfantCost'+serviceId).show();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #adultTransferCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childTransferCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #infantTransferCost'+serviceId).show();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleId'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleCost'+serviceId).show();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #repCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #saveBtn'+serviceId).show();
	}
	if(action=="editMealPlanQuotation" || action=="editAdditionalQuotation"){
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #groupCostText'+serviceId).hide();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #editBtn'+serviceId).hide();

		$('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #childCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #groupCost'+serviceId).show();
		$('#tbbody<?php echo ($QueryDaysData['id']);?> #saveBtn'+serviceId).show();
	}
}
// save service data
function saveQuotationService<?php echo ($QueryDaysData['id']);?>(serviceId,action){
//alert('samaydin');
if(action=="saveFlightQuotation"){
	var flightClass = $('#tbbody<?php echo ($QueryDaysData['id']);?> #flightClassInput'+serviceId).val();
	var flightNumber = $('#tbbody<?php echo ($QueryDaysData['id']);?> #flightNumberInput'+serviceId).val();
	var departureFrom = $('#tbbody<?php echo ($QueryDaysData['id']);?> #departureFromInput'+serviceId).val();
	var arrivalTo = $('#tbbody<?php echo ($QueryDaysData['id']);?> #arrivalToInput'+serviceId).val();
	var flightNumber = $('#tbbody<?php echo ($QueryDaysData['id']);?> #flightNumberInput'+serviceId).val();
	var departureTime = $('#tbbody<?php echo ($QueryDaysData['id']);?> #departureTimeInput'+serviceId).val();
	var arrivalTime = $('#tbbody<?php echo ($QueryDaysData['id']);?> #arrivalTimeInput'+serviceId).val();
	var adultCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCostInput'+serviceId).val();
	var childCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #childCostInput'+serviceId).val();
	var infantCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #infantCostInput'+serviceId).val();

	$('#hoteldivHiddens<?php echo ($QueryDaysData['id']);?>').load('inboundpop.php?action='+encodeURI(action)+'&flightClass='+encodeURI(flightClass)+'&flightNumber='+encodeURI(flightNumber)+'&departureFrom='+encodeURI(departureFrom)+'&arrivalTo='+encodeURI(arrivalTo)+'&adultCost='+encodeURI(adultCost)+'&childCost='+encodeURI(childCost)+'&infantCost='+encodeURI(infantCost)+'&serviceId='+encodeURI(serviceId)+'&departureTime='+encodeURI(departureTime)+'&arrivalTime='+encodeURI(arrivalTime));
}
if(action=="saveTrainQuotation"){
	var trainClass = $('#tbbody<?php echo ($QueryDaysData['id']);?> #trainClassInput'+serviceId).val();
	var trainNumber = $('#tbbody<?php echo ($QueryDaysData['id']);?> #trainNumberInput'+serviceId).val();
	var departureFrom = $('#tbbody<?php echo ($QueryDaysData['id']);?> #departureFromInput'+serviceId).val();
	var arrivalTo = $('#tbbody<?php echo ($QueryDaysData['id']);?> #arrivalToInput'+serviceId).val();
	var adultCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCostInput'+serviceId).val();
	var childCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #childCostInput'+serviceId).val();
	var infantCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #infantCostInput'+serviceId).val();
	var departureTime = $('#tbbody<?php echo ($QueryDaysData['id']);?> #departureTimeInput'+serviceId).val();
	var arrivalTime = $('#tbbody<?php echo ($QueryDaysData['id']);?> #arrivalTimeInput'+serviceId).val();

	$('#hoteldivHiddens<?php echo ($QueryDaysData['id']);?>').load('inboundpop.php?action='+encodeURI(action)+'&trainClass='+encodeURI(trainClass)+'&trainNumber='+encodeURI(trainNumber)+'&departureFrom='+encodeURI(departureFrom)+'&arrivalTo='+encodeURI(arrivalTo)+'&adultCost='+encodeURI(adultCost)+'&childCost='+encodeURI(childCost)+'&infantCost='+encodeURI(infantCost)+'&serviceId='+encodeURI(serviceId)+'&departureTime='+encodeURI(departureTime)+'&arrivalTime='+encodeURI(arrivalTime));
}
if(action=="saveQuotationHotel"){
	var singleoccupancy = $('#tbbody<?php echo ($QueryDaysData['id']);?> #singleoccupancyInput'+serviceId).val();
	var doubleoccupancy = $('#tbbody<?php echo ($QueryDaysData['id']);?> #doubleoccupancyInput'+serviceId).val();
	var childwithoutbed = $('#tbbody<?php echo ($QueryDaysData['id']);?> #childwithoutbedInput'+serviceId).val();
	var lunch = $('#tbbody<?php echo ($QueryDaysData['id']);?> #complimentaryLunchInput'+serviceId).val();
	var dinner = $('#tbbody<?php echo ($QueryDaysData['id']);?> #complimentaryDinnerInput'+serviceId).val();
	var childwithbed = $('#tbbody<?php echo ($QueryDaysData['id']);?> #childwithbedInput'+serviceId).val();
	var breakfast = $('#tbbody<?php echo ($QueryDaysData['id']);?> #breakfastInput'+serviceId).val();

	var childbreakfastInput = $('#tbbody<?php echo ($QueryDaysData['id']);?> #childbreakfastInput'+serviceId).val();
	var childlunchInput = $('#tbbody<?php echo ($QueryDaysData['id']);?> #childlunchInput'+serviceId).val();
	var childdinnerInput = $('#tbbody<?php echo ($QueryDaysData['id']);?> #childdinnerInput'+serviceId).val();
	//alert(breakfast);
	var extraBed = $('#tbbody<?php echo ($QueryDaysData['id']);?> #extraBedInput'+serviceId).val();
	var mealPlan = $('#tbbody<?php echo ($QueryDaysData['id']);?> #mealPlanInput'+serviceId).val();
	var roomType = $('#tbbody<?php echo ($QueryDaysData['id']);?> #roomTypeInput'+serviceId).val();

	var sixBedRoom = $('#tbbody<?php echo ($QueryDaysData['id']);?> #sixBedRoomInput'+serviceId).val();
	var eightBedRoom = $('#tbbody<?php echo ($QueryDaysData['id']);?> #eightBedRoomInput'+serviceId).val();
	var tenBedRoom = $('#tbbody<?php echo ($QueryDaysData['id']);?> #tenBedRoomInput'+serviceId).val();
	var quadRoom = $('#tbbody<?php echo ($QueryDaysData['id']);?> #quadRoomInput'+serviceId).val();
	var teenRoom = $('#tbbody<?php echo ($QueryDaysData['id']);?> #teenRoomInput'+serviceId).val();

	$('#hoteldivHiddens<?php echo ($QueryDaysData['id']);?>').load('inboundpop.php?action='+encodeURI(action)+'&singleoccupancy='+encodeURI(singleoccupancy)+'&doubleoccupancy='+encodeURI(doubleoccupancy)+'&childwithoutbed='+encodeURI(childwithoutbed)+'&lunch='+encodeURI(lunch)+'&dinner='+encodeURI(dinner)+'&childwithbed='+encodeURI(childwithbed)+'&breakfast='+encodeURI(breakfast)+'&extraBed='+encodeURI(extraBed)+'&mealPlan='+encodeURI(mealPlan)+'&roomType='+encodeURI(roomType)+'&serviceId='+encodeURI(serviceId)+'&sixBedRoomCost='+encodeURI(sixBedRoom)+'&eightBedRoomCost='+encodeURI(eightBedRoom)+'&tenBedRoomCost='+encodeURI(tenBedRoom)+'&quadRoomCost='+encodeURI(quadRoom)+'&teenRoomCost='+encodeURI(teenRoom)+'&childbreakfastc='+encodeURI(childbreakfastInput)+'&childlunchc='+encodeURI(childlunchInput)+'&childdinnerc='+encodeURI(childdinnerInput));
}
 
if(action=="saveQuotationTransfer"){

	var transferNameId = $('#tbbody<?php echo ($QueryDaysData['id']);?> #transferNameIdInput'+serviceId).val();
	
	var transferType = $('#tbbody<?php echo ($QueryDaysData['id']);?> #transferTypeInput'+serviceId).val();
	var adultCost=childCost=vehicleModelId=vehicleType=vehicleCost=noOfVehicles= 0;
	if(transferType == 1 ){
		adultCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCostInput'+serviceId).val();
		childCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #childCostInput'+serviceId).val();
		infantCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #infantCostInput'+serviceId).val();
	}else{
		vehicleType = $('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleTypeInput'+serviceId).val();
		vehicleModelId = $('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleModelIdInput'+serviceId).val();
		vehicleCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleCostInput'+serviceId).val();
		noOfVehicles = $('#tbbody<?php echo ($QueryDaysData['id']);?> #noOfVehiclesInput'+serviceId).val();
	}

	var paxSlab = $('#tbbody<?php echo ($QueryDaysData['id']);?> #paxSlabInput'+serviceId).val();
	$('#hoteldivHiddens<?php echo ($QueryDaysData['id']);?>').load('inboundpop.php?action='+encodeURI(action)+'&transferNameId='+encodeURI(transferNameId)+'&vehicleModelId='+encodeURI(vehicleModelId)+'&noOfVehicles='+encodeURI(noOfVehicles)+'&paxSlab='+encodeURI(paxSlab)+'&vehicleType='+encodeURI(vehicleType)+'&vehicleCost='+encodeURI(vehicleCost)+'&adultCost='+encodeURI(adultCost)+'&childCost='+encodeURI(childCost)+'&infantCost='+encodeURI(infantCost)+'&transferType='+encodeURI(transferType)+'&serviceId='+encodeURI(serviceId));
}
if(action=="saveQuotationFerry"){
	var ferryNameId = $('#tbbody<?php echo ($QueryDaysData['id']);?> #ferryNameIdInput'+serviceId).val();
	var ferryClass = $('#tbbody<?php echo ($QueryDaysData['id']);?> #ferryClassInput'+serviceId).val();
	var adultCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCostInput'+serviceId).val();
	var childCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #childCostInput'+serviceId).val();
	var infantCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #infantCostInput'+serviceId).val();
	var processingfee = $('#tbbody<?php echo ($QueryDaysData['id']);?> #processingfeeInput'+serviceId).val();
	var miscCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #miscCostInput'+serviceId).val();
	$('#hoteldivHiddens<?php echo ($QueryDaysData['id']);?>').load('inboundpop.php?action='+encodeURI(action)+'&ferryClass='+encodeURI(ferryClass)+'&ferryNameId='+encodeURI(ferryNameId)+'&adultCost='+encodeURI(adultCost)+'&childCost='+encodeURI(childCost)+'&infantCost='+encodeURI(infantCost)+'&processingfee='+encodeURI(processingfee)+'&miscCost='+encodeURI(miscCost)+'&serviceId='+encodeURI(serviceId));
}
if(action=="saveActivityQuotation"){
	var activityCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #activityCostInput'+serviceId).val();
	var maxpax = $('#tbbody<?php echo ($QueryDaysData['id']);?> #maxpaxInput'+serviceId).val();
	var perPaxCost = Number(activityCost/maxpax).toFixed(2)
	$('#hoteldivHiddens<?php echo ($QueryDaysData['id']);?>').load('inboundpop.php?action='+encodeURI(action)+'&activityCost='+encodeURI(activityCost)+'&maxpax='+encodeURI(maxpax)+'&perPaxCost='+encodeURI(perPaxCost)+'&serviceId='+encodeURI(serviceId));
}

if(action=="saveEntranceQuotation"){
	var ticketAdultCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #ticketAdultCostInput'+serviceId).val();
	var ticketchildCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #ticketchildCostInput'+serviceId).val();
	var ticketinfantCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #ticketinfantCostInput'+serviceId).val();
	var transferType = $('#tbbody<?php echo ($QueryDaysData['id']);?> #transferTypeInput'+serviceId).val();
	var adultTransferCost=childTransferCost=infantTransferCost=vehicleId=vehicleCost = 0;
	if(transferType == 1 ){
		adultTransferCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #adultTransferCostInput'+serviceId).val();
		childTransferCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #childTransferCostInput'+serviceId).val();
		infantTransferCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #infantTransferCostInput'+serviceId).val();
	}else{
		vehicleId = $('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleIdInput'+serviceId).val();
		vehicleCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleCostInput'+serviceId).val();
	}

	var repCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #repCostInput'+serviceId).val();

	$('#hoteldivHiddens<?php echo ($QueryDaysData['id']);?>').load('inboundpop.php?action='+encodeURI(action)+'&ticketAdultCost='+encodeURI(ticketAdultCost)+'&ticketchildCost='+encodeURI(ticketchildCost)+'&ticketinfantCost='+encodeURI(ticketinfantCost)+'&adultTransferCost='+encodeURI(adultTransferCost)+'&childTransferCost='+encodeURI(childTransferCost)+'&infantTransferCost='+encodeURI(infantTransferCost)+'&vehicleId='+encodeURI(vehicleId)+'&vehicleCost='+encodeURI(vehicleCost)+'&repCost='+encodeURI(repCost)+'&serviceId='+encodeURI(serviceId));
}
if(action=="saveMealPlanQuotation" || action=="saveAdditionalQuotation"){
	var adultCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCostInput'+serviceId).val();
	var childCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #childCostInput'+serviceId).val();
	var groupCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #groupCostInput'+serviceId).val();
	$('#hoteldivHiddens<?php echo ($QueryDaysData['id']);?>').load('inboundpop.php?action='+encodeURI(action)+'&adultCost='+encodeURI(adultCost)+'&groupCost='+encodeURI(groupCost)+'&childCost='+encodeURI(childCost)+'&serviceId='+encodeURI(serviceId));
}
if(action=="saveGuideQuotation"){
	var perDaycost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #perDaycostInput'+serviceId).val();
	var totalDays = $('#tbbody<?php echo ($QueryDaysData['id']);?> #totalDaysInput'+serviceId).val();
	var slabId = $('#tbbody<?php echo ($QueryDaysData['id']);?> #paxSlabInput'+serviceId).val();
	var price = (parseInt(perDaycost)*parseInt(totalDays));
	$('#hoteldivHiddens<?php echo ($QueryDaysData['id']);?>').load('inboundpop.php?action='+encodeURI(action)+'&slabId='+encodeURI(slabId)+'&perDaycost='+encodeURI(perDaycost)+'&price='+encodeURI(price)+'&serviceId='+encodeURI(serviceId));
}

}
function hoteltcinfo(hotelId) {
	$('#viewinfo').show();
	$('#loadhotelInfo').load('loadhoteltcinfo.php?hotelId='+hotelId);
}

</script>
<!-- hoteldlt hoteledit -->
<style type="text/css">
	.viewMoreBtn{ 
		font-size: 14px!important;
		color: #d88319; 
		cursor: pointer; 
		padding: 5px 0px;
		border: 0px solid #ddd;
		border-radius: 1px;
		box-shadow: -2px 3px 4px -3px black;
	} 
	.linkBox{
		display: none;
		background-color: #fff;
	}
	.linkBox{
       	position: absolute;
	    width: 150px;
	    border: 0px solid #000;
	    z-index: 99;
	    box-shadow: -4px 6px 13px -5px black;
	}
	.viewMoreBtn:hover{
		background-color: #d88319;
		color: #fff;
	}
	.linkBox .links:hover{
		color: #d88319!important;
		text-decoration: underline;
	}
	.linkBox .dltBtn ,.linkBox .edtBtn ,.linkBox .adBtn {
	    font-size: 14px;
	    cursor: pointer;
	    padding: 5px 7px;
	}
</style>
<script type="text/javascript">
	function showlinkBox(listbox){
		$(listbox).toggle();
	}
</script>
</div>
</div>
</form>
<div id="hoteldivHiddens<?php echo ($QueryDaysData['id']);?>"></div>
<?php $day++; $dateno++;
}
?>
</div>