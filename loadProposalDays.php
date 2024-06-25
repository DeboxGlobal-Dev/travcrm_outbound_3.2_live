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
$calculationType=$quotationData['calculationType'];


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

// checking var for no of room 
$hotelCheckRooms = '';
$isErrorInfo = 0;

//cleaned
$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" and addstatus=0 and deletestatus=0  order by srdate asc');
while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){
	$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
	$srdate2 = date('Y-m-d', strtotime('+'.$dateno.' day', strtotime($quotationData['fromDate'])));
	if($dayDate != $srdate2 && $quotationData['isRegenerated']!=1){
		updatelisting('newQuotationDays','srdate="'.$srdate2.'"','id="'.$QueryDaysData['id'].'"');
		$dayDate = $srdate2;
	}
	$cityId = $QueryDaysData['cityId'];
	$dayId = $QueryDaysData['id'];
	$destname = getDestination($QueryDaysData['cityId']);
?> 
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditquery<?php echo $daylisting['id']; ?>" target="actoinfrm" id="addeditquery<?php echo $QueryDaysData['id']; ?>">	
<input name="action" type="hidden" value="sortingservice">
<div style="border:1px solid #ccc; background-color:#FFFFFF; margin-bottom:10px; position:relative;">
<div style="background-color: #fafafa; padding: 10px; color: #000; font-weight: 500; cursor: pointer; font-size: 14px; overflow:hidden; border-bottom: 1px solid #ddd;" onClick="openclosetabs('<?php echo ($QueryDaysData['id']);?>');">


<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="left" width="3%">Day&nbsp;<?php echo $day; ?>&nbsp;|&nbsp;</td>
<td width="97%" align="left" valign="top" >&nbsp;<?php if($quotationData['dayWise']==1 || $quotationData['isSeries'] == 1 || $quotationData['isFD'] == 1){ ?><nobr><?php if($quotationData['dayWise']!=2){ echo date('d-m-Y/D', strtotime($dayDate)); } } ?>&nbsp;|&nbsp;<?php echo $destname; ?></nobr>

</td>
</tr>
</table>
</div>
<div  class="buttonlists">
<a name="Additional<?php echo $day; ?>" onClick="openinboundpop('action=addServiceAdditional&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','900px');">+ Additional</a>
<a name="Restaurant<?php echo $day; ?>" onClick="openinboundpop('action=addServiceMealPlan&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','800px');">+ Restaurant</a>
<?php
$modeSql=GetPageRecord('*','quotationModeMaster',' 1 and quotationId="'.$quotationData['id'].'" and dayId ="'.$QueryDaysData['id'].'"');
$modeData=mysqli_fetch_array($modeSql);
if($modeData['name'] == 'surface'){ ?>
<!-- <a name="Enroute<?php echo $day; ?>" onClick="openinboundpop('action=addServiceEnroute&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','800px');">+ Enroute</a> -->
<?php } ?>  
<a name="Cruise<?php echo $day; ?>" onClick="openinboundpop('action=addServiceCruise&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1200px');">+ Cruise</a>
<a name="Train<?php echo $day; ?>" onClick="openinboundpop('action=addServiceTrains&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1200px');">+ Train</a>
<a name="Flight<?php echo $day; ?>" onClick="openinboundpop('action=addServiceFlight&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1200px');">+ Flight</a>
<a name="Entrance<?php echo $day; ?>" onClick="openinboundpop('action=addServiceEntrance&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1200px');">+ Monument</a>
<a name="SightSeeing<?php echo $day; ?>" onClick="openinboundpop('action=addServiceActivity&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1100px');">+ SightSeeing</a>
<a name="Ferry<?php echo $day; ?>" <?php echo isHideMster('ferryMaster'); ?> onClick="openinboundpop('action=addServiceFerry&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1200px');">+ Ferry</a>
<a name="Transportation<?php echo $day; ?>" onClick="openinboundpop('action=addServiceTransportation&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1200px');">+ TPT</a>
<a name="Transfer<?php echo $day; ?>" onClick="openinboundpop('action=addServiceTransfer&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1200px');">+ Transfer</a>
<a name="Guide<?php echo $day; ?>" onClick="openinboundpop('action=addServiceGuide&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1100px');">+ Tour&nbsp;Escort</a>
 
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
if($quotationData['queryType']<>14){
if( ( mysqli_num_rows($earlymainCheck) == 0 && $day == 1 && $earlyCheckin == 1 ) || mysqli_num_rows($mainCheck) == 0 || mysqli_num_rows($mainsuppCheck) == 0 || mysqli_num_rows($focQLE) == 0 || mysqli_num_rows($focQFE) == 0 || $quotationType==2 ){ ?>
<a name="Hotel<?php echo $day; ?>" onClick="openinboundpop('action=addServiceHotel&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>&day=<?php echo $day; ?>','1200px');">+&nbsp;Hotel</a>
<?php } } ?>
 

<a name="ItineraryInfo<?php echo $day; ?>" onClick="openinboundpop('action=additinerary_plan&dayId=<?php echo $QueryDaysData['id']; ?>&cityId=<?php echo $cityId; ?>','1200px');" >+ Itinerary&nbsp;Info</a>
</div>
</div>
		
<div style="padding:10px; background-color:#FFFFFF; display:noned;" id="tbbody<?php echo ($QueryDaysData['id']);?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="stbl<?php echo $QueryDaysData['id']; ?>" onclick="dragDropfun('<?php echo $QueryDaysData['id']; ?>');">
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
				<td align="left">
					<div id="iti_subjectText<?php echo ($QueryDaysData['id']); ?>"><?php echo strip($iti_subject);?></div>

					<div id="iti_subject<?php echo ($QueryDaysData['id']); ?>" style="display:none;">
						<input name="iti_subjectInput<?php echo ($QueryDaysData['id']); ?>" type="text"  id="iti_subjectInput<?php echo ($QueryDaysData['id']); ?>"  value="<?php echo strip($iti_subject); ?>" style="width: 100%;padding: 3px;">
					</div>
				</td>
			</tr>
			<tr>
				<td align="left">
					<div id="iti_descriptionText<?php echo ($QueryDaysData['id']); ?>"><?php echo strip($iti_description);?></div>

					<div id="iti_description<?php echo ($QueryDaysData['id']); ?>" style="display:none;">

						<textarea name="iti_descriptionInput<?php echo ($QueryDaysData['id']); ?>" id="iti_descriptionInput<?php echo ($QueryDaysData['id']); ?>" style="width: 100%;height: 90px; padding: 5px;">
						<?php echo strip_tags(nl2br(trim($iti_description))); ?>
						</textarea>
					</div>
				</td>

				<!-- Edit and delete save buttons code -->
				<td align="right" width="8%">
					<div class="saveBtn" id="saveBtn<?php echo ($QueryDaysData['id']); ?>"  style="display: inline-flex;display:none;float: left;" onClick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $QueryDaysData['id'];?>','saveItineraryQuotation');"><i class="fa fa-save" aria-hidden="true"></i></div>	
				
					<div class="editBtn" id="editBtn<?php echo ($QueryDaysData['id']); ?>"  style="display: inline-flex;" onClick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $QueryDaysData['id'];?>','editItineraryQuotation');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
					
				
					<div class="deleteBtn" style="display: inline-flex;" onClick="if(confirm('Are you sure you want delete this Itenary Info?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $QueryDaysData['id']; ?>','deleteItineraryQuotation');" ><i class="fa fa-trash" aria-hidden="true"></i></div>

				</td>
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

$htservice=1;
// normal services start without hotel
$b=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationData['id'].'" and queryId="'.$quotationData['queryId'].'" '.$dateQuery.' order by srn asc,id desc');
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
	<th   align="left" bgcolor="#ddd"><?php if($hotelQuotData['isEarlyCheckin']==1){ echo 'Early Checkin'; } ?> <div style="font-size:15px;font-weight:500;margin: 3px 0 10px 0;">Hotel</div></th>
	</tr>
	</thead>
	<tbody>
	<tr>  
	<td width="100%" align="left" valign="top" style="padding-left:10px; padding-right:37px; position:relative;">
		<div style="font-size:15px;font-weight:500;margin: 3px 0 10px 0;"><?php echo strip($hotelData['hotelName']);  ?>&nbsp;|&nbsp;<?php
			$rs231=GetPageRecord('*','hotelCategoryMaster','id="'.$hotelData['hotelCategoryId'].'"');
			$hotelCatNam=mysqli_fetch_array($rs231);

			$rsHoType=GetPageRecord('*','hotelTypeMaster','id="'.$hotelData['hotelTypeId'].'"');
			$hotelCatNamTy=mysqli_fetch_array($rsHoType);

		    if($quotationType==2 || $quotationType==1){
			echo $hotelCatNam['hotelCategory']; ?>&nbsp;Star &nbsp;<?php } if($quotationType==3){ ?> &nbsp;<?php  echo $hotelCatNamTy['name']; } ?>&nbsp;&nbsp;<input type="checkbox" id="hoteldetails<?php echo ($hotelQuotData['id']); ?>" style="display: inline-block;" value="1" <?php if($hotelQuotData['hotelDescription']==1){ ?> checked="checked" <?php } ?>  onchange="hoteldetails('<?php echo ($hotelQuotData['id']); ?>','<?php echo $hotelData['id']; ?>','<?php echo ($hotelQuotData['supplierId']); ?>')">Hotel Description&nbsp;&nbsp;|&nbsp;<span class="bluelink" onclick="openinboundpop('action=addhoteldetails&&hotelId=<?php echo $hotelData['id']; ?>','1000px');" style="font-size: 15px;">T&C</span>

			<?php if($hotelData['verified']==1){?>
			<span class="bluelink" onclick="openinboundpop('action=addhoteldetailsInternalNote&&hotelId=<?php echo $hotelData['id']; ?>','1000px');" style="font-size: 15px;font-size: 15px;color: black !important; font-weight: bold;margin-left: 20px;"><img src="<?php echo $fullurl.'images/verified.png'; ?>" width="20" height="20" style="position: relative;top: 5px;"/> Verified</span>
			<?php } ?>
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
	$qhQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and supplierId="'.$sorting['serviceId'].'" and dayId="'.$sorting['dayId'].'" order by rand_color asc');
	if(mysqli_num_rows($qhQuery)>0){
		$NORate = 1;
		while($qhData=mysqli_fetch_array($qhQuery)){
		 
			if($NORate == 1){ ?>
			<tr>
				<th width="80" align="left" bgcolor="#F4F4F4">Service&nbsp;Type</th>
				<th width="80" align="left" bgcolor="#F4F4F4">Tariff&nbsp;Type </th>
				<th width="" align="left" bgcolor="#F4F4F4">Room&nbsp;Type </th>
				<th width="70" align="left" bgcolor="#F4F4F4">Meal&nbsp;Plan </th>
				<?php 
				if($calculationType != 3){ ?>
				<?php if($qhData['singleNoofRoom']>0){ ?>
				<th width="6%" align="left" bgcolor="#F4F4F4">Single</th>
				<?php } if($qhData['doubleNoofRoom']>0){ ?>
				<th width="6%" align="left" bgcolor="#F4F4F4">Double</th>
				<?php } if($qhData['twinNoofRoom']>0){ ?>
				<th width="12%" align="left" bgcolor="#F4F4F4">Twin</th>
				<?php } if($qhData['tripleNoofRoom']>0){ ?>
				<th width="12%" align="left" bgcolor="#F4F4F4">Triple</th>
				<?php } if($qhData['extraNoofBed']>0){ ?>
				<th width="12%" align="left" bgcolor="#F4F4F4">E.Bed(A)</th>
				<?php } if($qhData['childwithNoofBed']>0){ ?>
				<th width="12%" align="left" bgcolor="#F4F4F4">CWB</th>
				<?php } if($qhData['childwithoutNoofBed']>0){ ?>
				<th width="6%" align="left" bgcolor="#F4F4F4">CNB</th>
				<?php } if($qhData['complimentaryBreakfast']==1){ $isbreakfast=1; ?>
				<th width="8%" align="left" bgcolor="#F4F4F4">Breakfast(A)</th>
				<?php } if($qhData['complimentaryLunch']==1){ $islunch=1; ?>
				<th width="8%" align="left" bgcolor="#F4F4F4">Lunch(A)</th>
				<?php } if($qhData['complimentaryDinner']==1){ $isdinner=1; ?>
				<th width="8%" align="left" bgcolor="#F4F4F4">Dinner(A)</th>
				<?php } 
				} ?>
				<th width="80" align="center" bgcolor="#F4F4F4">Action</th>
			</tr>
			<?php } ?>
			<tr>
				<!-- bgcolor="<?php echo $qhData['rand_color']; ?>" -->
				<td width="80" align="left" >
					<div style="color:<?php echo $qhData['rand_color']; ?>;border-left: 5px solid <?php echo $qhData['rand_color']; ?>;"><?php
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
					</div>
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
				<?php if($calculationType != 3){ ?>

						<?php if($qhData['singleNoofRoom']>0){ ?> 
						<td width="6%" align="left">
							<?php  echo  getCurrencyName($qhData['currencyId']).'&nbsp;'.round(getCostWithGSTID_Markup($qhData['singleoccupancy'],$qhData['roomGST'],$qhData['markupCost'],$qhData['markupType'],$qhData['roomTAC'],$qhData['TACType'])).'x'.strip($qhData['singleNoofRoom']); ?>
						</td>
						<?php } if($qhData['doubleNoofRoom']>0){ ?> 
						<td width="6%" align="left">
							<?php  echo getCurrencyName($qhData['currencyId']).'&nbsp;'.round(getCostWithGSTID_Markup($qhData['doubleoccupancy'],$qhData['roomGST'],$qhData['markupCost'],$qhData['markupType'],$qhData['roomTAC'],$qhData['TACType'])).'x'.strip($qhData['doubleNoofRoom']);  ?>
						</td> 
						<?php } if($qhData['twinNoofRoom']>0){ ?> 
						<td width="12%" align="left">
							<?php  echo getCurrencyName($qhData['currencyId']).'&nbsp;'.round(getCostWithGSTID_Markup($qhData['twinoccupancy'],$qhData['roomGST'],$qhData['markupCost'],$qhData['markupType'],$qhData['roomTAC'],$qhData['TACType'])).'x'.strip($qhData['twinNoofRoom']);  ?>
						</td> 
						<?php } if($qhData['tripleNoofRoom']>0){ ?> 
						<td width="12%" align="left">
							<?php  echo getCurrencyName($qhData['currencyId']).'&nbsp;'.round(getCostWithGSTID_Markup($qhData['tripleoccupancy'],$qhData['roomGST'],$qhData['markupCost'],$qhData['markupType'],$qhData['roomTAC'],$qhData['TACType'])).'x'.strip($qhData['tripleNoofRoom']);  ?>
						</td> 
						<?php } if($qhData['extraNoofBed']>0){ ?> 
						<td width="12%" align="left">
							<?php echo getCurrencyName($qhData['currencyId']).'&nbsp;'.round(getCostWithGSTID_Markup($qhData['extraBed'],$qhData['roomGST'],$qhData['markupCost'],$qhData['markupType'],$qhData['roomTAC'],$qhData['TACType'])).'x'.strip($qhData['extraNoofBed']); ?>
						</td>
						<?php }  if($qhData['childwithNoofBed']>0){ ?> 
						<td width="12%" align="left">
							<?php echo  getCurrencyName($qhData['currencyId']).'&nbsp;'.round(getCostWithGSTID_Markup($qhData['childwithbed'],$qhData['roomGST'],$qhData['markupCost'],$qhData['markupType'],$qhData['roomTAC'],$qhData['TACType'])).'x'.strip($qhData['childwithNoofBed']); ?>
						</td>
						<?php }  if($qhData['childwithoutNoofBed']>0){ ?> 
						<td width="6%" align="left">
							<?php  echo getCurrencyName($qhData['currencyId']).'&nbsp;'.round(getCostWithGSTID_Markup($qhData['childwithoutbed'],$qhData['roomGST'],$qhData['markupCost'],$qhData['markupType'],$qhData['roomTAC'],$qhData['TACType'])).'x'.strip($qhData['childwithoutNoofBed']);  ?>
						</td>
						<?php } if($qhData['complimentaryBreakfast']==1){ ?>
						<td width="8%" align="left">
							<?php echo getCurrencyName($qhData['currencyId']).' '.round(getCostWithGSTID_Markup($qhData['breakfast'],$qhData['mealGST'],$qhData['markupCost'],$qhData['markupType'])); ?>
						</td>  
						<?php } if($qhData['complimentaryLunch']==1){ ?>
						<td width="8%" align="left">
							<?php echo getCurrencyName($qhData['currencyId']).' '.round(getCostWithGSTID_Markup($qhData['lunch'],$qhData['mealGST'],$qhData['markupCost'],$qhData['markupType'])); ?>
						</td>
						<?php } if($qhData['complimentaryDinner']==1){ ?>
						<td width="8%" align="left">
							<?php echo getCurrencyName($qhData['currencyId']).' '.round(getCostWithGSTID_Markup($qhData['dinner'],$qhData['mealGST'],$qhData['markupCost'],$qhData['markupType'])); ?>
						</td>
						<?php } ?> 
						<?php 
				} ?> 

				<td width="80" align="left">
					<div class="viewMoreBtn fa fa-plus" onclick="showlinkBox('#linkBox<?php echo $qhData['id'];?>');">&nbsp;&nbsp;More</div>
					<div class="linkBox" id="linkBox<?php echo $qhData['id'];?>">

						<div class="dltBtn links" onclick="if(confirm('Are you sure you want delete this hotel?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $qhData['id'].'_'.$qhData['supplierId'];?>','deleteQuotationHotel');" style="color: red;"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</div>
						 
						<!-- onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $qhData['id'];?>','editQuotationHotel');" -->
						<div class="edtBtn links" id="editBtn<?php echo ($qhData['id']); ?>"  style="color: #006699;" onclick="openinboundpop('action=editQuotationHotelRate&hotelQuoteId=<?php echo $qhData['id']; ?>','1000px');"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</div>
							
					<?php if($calculationType != 3){ ?>
						<div class="edtBtn links" id="editBtn<?php echo ($qhData['id']); ?>"  style="color: #006699;" onClick="openinboundpop('action=selectAdultChildMeal&dayId=<?php echo $QueryDaysData['id']; ?>&hotelQuoteId=<?php echo $qhData['id'];?>&roomTariffId=<?php echo $qhData['roomTariffId'];?>&quotationId=<?php echo $quotationId; ?>','400px');" ><i class="fa fa-cutlery" aria-hidden="true"></i>&nbsp;Meals</div>

						<?php if($qhData['isRoomSupplement']!=1 && $qhData['isHotelSupplement']!=1){ ?>
						<div class="adBtn links" title="Room&nbsp;Supplement" id="saveBtn<?php echo ($qhData['id']); ?>" style="color: #006699;" onClick="openinboundpop('action=addServiceHotel&stype=roomSupplement&dayId=<?php echo $QueryDaysData['id']; ?>&hotelQuoteId=<?php echo $qhData['id'];?>','1300px');"><i class="fa fa-hotel" aria-hidden="true"></i>&nbsp;Room&nbsp;Supplement</div>
						 
						<div class="adBtn links" title="Room&nbsp;Supplement" id="saveBtn<?php echo ($qhData['id']); ?>" style="color: #006699;" onClick="openinboundpop('action=addServiceHotel&stype=hotelSupplement&dayId=<?php echo $QueryDaysData['id']; ?>&hotelQuoteId=<?php echo $qhData['id'];?>','1300px');"><i class="fa fa-hotel" aria-hidden="true"></i>&nbsp;Hotel&nbsp;Supplement</div>

						

						<div class="adBtn links" title="Hotel&nbsp;Additional" id="saveBtn<?php echo ($qhData['id']); ?>" style="color: #006699;" onClick="openinboundpop('action=addHotelAdditionalService&dayId=<?php echo $QueryDaysData['id']; ?>&hotelQuoteId=<?php echo $qhData['id'];?>&roomTariffId=<?php echo $qhData['roomTariffId'];?>','1000px');">
						<i class="fa fa-hotel" aria-hidden="true"></i>&nbsp;Hotel&nbsp;Additional</div>


						<?php } ?>
					<?php } ?>
					</div>
				</td>
			</tr>  
			<?php if(mysqli_num_rows($qhQuery) != $NORate){ ?>
			<tr style="border:1px dashed #fa8017;width: 100%;height: 7px;"></tr>
			<?php }  
			$NORate++;
		}

	// start hotel additional requirenment
	$c2 = "";
	$c2=GetPageRecord('*','quotationHotelAdditionalMaster',' hotelQuotId="'.$hotelQuotData['id'].'" and quotationId="'.$hotelQuotData['quotationId'].'"');
	if(mysqli_num_rows($c2) > 0){
	?>
	<br><br>
	<table border="1">
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
	<?php
	}
	// end hotel additional requirenment

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
		$c=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and id="'.$sorting['serviceId'].'" and dayId>0 and isTransferTaken=""');
		if(mysqli_num_rows($c)>0){
		while($qTransferD=mysqli_fetch_array($c)){
			$vehicleCost = strip($qTransferD['vehicleCost'])+strip($qTransferD['parkingFee'])+strip($qTransferD['representativeEntryFee'])+strip($qTransferD['assistance'])+strip($qTransferD['guideAllowance'])+strip($qTransferD['interStateAndToll'])+strip($qTransferD['miscellaneous']); 
		?>
		<tr> <td>
		<input name="serviceids[]" type="hidden"  value="<?php echo $sorting['id']; ?>">
		<input id="transferTypeInput<?php echo ($qTransferD['id']); ?>" type="hidden"  value="<?php echo $qTransferD['transferType']; ?>">
		<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;"><div class="editButton" style="width:30px;height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
		<thead>
			<tr>
			<th align="left" bgcolor="#ddd">Transfer&nbsp;Name</th>
			<?php if($calculationType != 3){ ?>
			<?php if($qTransferD['transferType'] == 2){ ?>
			<th align="left" bgcolor="#ddd" style="display:none1;">Vehicle Type</th>
			<!-- <th align="left" bgcolor="#ddd" >Vehicle Name </th> -->
			<th align="left" bgcolor="#ddd" >Vehicle Cost</th>
			<th align="left" bgcolor="#ddd" >No.&nbsp;of&nbsp;Vehicle</th>
			<th align="left" bgcolor="#ddd" >Total&nbsp;Cost</th>
			<?php }else{ ?>
			<th align="left" bgcolor="#ddd" >Adult&nbsp;Cost</th>
			<th align="left" bgcolor="#ddd" >Child&nbsp;Cost</th>
			<th align="left" bgcolor="#ddd" >Infant&nbsp;Cost</th>
			<?php } ?>
			<?php } ?>
			<th align="left" bgcolor="#ddd" >Pax&nbsp;Slab</th>
			<th align="right" bgcolor="#ddd">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		// hotel data
		$d=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$qTransferD['transferNameId'].'"');
		$transferD=mysqli_fetch_array($d);
		if($qTransferD['transferName'] == '' || strlen($qTransferD['transferName']) < 3){
			$transferName =  $transferD['transferName'];
		}else{
			$transferName =  $qTransferD['transferName'];
		}
		$curr = getCurrencyName($qTransferD['currencyId']);
		?>
		<tr>
		<td align="left">
			<div id="transferNameIdText<?php echo ($qTransferD['id']); ?>">
			<?php echo trim($transferName); ?>					</div>
			<div id="transferNameId<?php echo ($qTransferD['id']); ?>" style="display:none;">
			<input type="text" id="transferNameIdInput<?php echo ($qTransferD['id']); ?>"  value="<?php echo  strip($transferName); ?>">
			</div>					
		</td>
		<?php if($calculationType != 3){ ?>

		<?php if($qTransferD['transferType'] == 2){ ?>
		<td align="left" style="display:none1;">
			<div id="vehicleTypeText<?php echo ($qTransferD['id']); ?>">
			<?php
		
			$rs2=GetPageRecord('*','vehicleTypeMaster','id="'.$qTransferD['vehicleType'].'"');
			$editresult2=mysqli_fetch_array($rs2);
			echo $editresult2['name'];
			?>
			</div>
			<div id="vehicleType<?php echo ($qTransferD['id']); ?>" style="display:none;">
			<select id="vehicleTypeInput<?php echo ($qTransferD['id']); ?>"  class="selectbox"  onchange="getVehicleModel<?php echo ($qTransferD['id']); ?>('<?php echo ($qTransferD['id']); ?>')">
			<?php
			$rsaa=GetPageRecord('name,id','vehicleTypeMaster','status=1 and deletestatus=0 order by name asc');
			while($qTransferDass=mysqli_fetch_array($rsaa)){
			?>
			<option value="<?php echo strip($qTransferDass['id']); ?>" <?php if($qTransferD['vehicleType']== strip($qTransferDass['id'])){ ?> selected="selected" <?php } ?>><?php echo strip($qTransferDass['name']); ?></option>
			<?php } ?>
			</select>
			</div>					
		</td>
		<!-- <td align="left" >
			<div id="vehicleModelIdText<?php echo ($qTransferD['id']); ?>">
			<?php echo $editresult2['model']; ?>					</div>
			<div id="vehicleModelId<?php echo ($qTransferD['id']); ?>" style="display:none;">
			<select id="vehicleModelIdInput<?php echo ($qTransferD['id']); ?>"  class="selectbox">
			<option value="">Select Model</option>
			<?php
			// $select='*';
			// $where=' 1  order by id asc';
			// $rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where);
			// while($vmmData=mysqli_fetch_array($rs)){
			?>
			<option value="<?php echo $vmmData['id']; ?>" <?php if($vmmData['id'] == $qTransferD['vehicleModelId']){ ?> selected="selected" <?php } ?>><?php echo $vmmData['model']; ?></option>
			<?php //} ?>
			</select>
			</div>
			<script type="text/javascript">
			function getVehicleModel<?php echo ($qTransferD['id']); ?>(id) {
			var vehicleType = $('#vehicleTypeInput'+id).val();
			$("#vehicleModelIdInput"+id).load('loadvehiclemodel.php?vehicleTypeId='+vehicleType);
			}
			</script>					
		</td> -->
		<td align="left">
			<div id="vehicleCostText<?php echo ($qTransferD['id']); ?>"><?php echo $curr.' '.getCostWithGSTID_Markup($vehicleCost,$qTransferD['gstTax'],$qTransferD['markupCost'],$qTransferD['markupType']); ?></div>
			<div id="vehicleCost<?php echo ($qTransferD['id']); ?>" style="display:none;">
			<input type="text" id="vehicleCostInput<?php echo ($qTransferD['id']); ?>"  value="<?php echo  strip($qTransferD['vehicleCost']); ?>">
			</div>					
		</td>
		<td align="left">
			<div id="noOfVehiclesText<?php echo ($qTransferD['id']); ?>"><?php echo  strip($qTransferD['noOfVehicles']); ?></div>
			<div id="noOfVehicles<?php echo ($qTransferD['id']); ?>" style="display:none;">
				<input type="text" id="noOfVehiclesInput<?php echo ($qTransferD['id']); ?>"  value="<?php echo  strip($qTransferD['noOfVehicles']); ?>">
			</div>					
		</td>
		<td align="left">
			<div ><?php echo  getCostWithGSTID_Markup($vehicleCost,$qTransferD['gstTax'],$qTransferD['markupCost'],$qTransferD['markupType'])*$qTransferD['noOfVehicles']; ?></div>					 
		</td>
		<?php }else{ ?>
		<td align="left">
			<div id="adultCostText<?php echo ($qTransferD['id']); ?>"><?php echo $curr.' '.getCostWithGSTID_Markup($qTransferD['adultCost'],$qTransferD['gstTax'],$qTransferD['markupCost'],$qTransferD['markupType']); ?></div>
			<div id="adultCost<?php echo ($qTransferD['id']); ?>" style="display:none;">
			<input type="text" id="adultCostInput<?php echo ($qTransferD['id']); ?>"  value="<?php echo  strip($qTransferD['adultCost']); ?>">
			</div>					
		</td>
		<td align="left">
			<div id="childCostText<?php echo ($qTransferD['id']); ?>"><?php echo $curr.' '.getCostWithGSTID_Markup($qTransferD['childCost'],$qTransferD['gstTax'],$qTransferD['markupCost'],$qTransferD['markupType']); ?></div>
			<div id="childCost<?php echo ($qTransferD['id']); ?>" style="display:none;">
			<input type="text" id="childCostInput<?php echo ($qTransferD['id']); ?>"  value="<?php echo  strip($qTransferD['childCost']); ?>">
			</div>					
		</td>
		<td align="left">
			<div id="infantCostText<?php echo ($qTransferD['id']); ?>"><?php echo $curr.' '.getCostWithGSTID_Markup($qTransferD['infantCost'],$qTransferD['gstTax'],$qTransferD['markupCost'],$qTransferD['markupType']); ?></div>
			<div id="infantCost<?php echo ($qTransferD['id']); ?>" style="display:none;">
			<input type="text" id="infantCostInput<?php echo ($qTransferD['id']); ?>"  value="<?php echo  strip($qTransferD['infantCost']); ?>">
			</div>					
		</td>
		<?php } ?>
		<?php } ?>

		<td align="left">
			<?php
			$tpxQ="";
			$tpxQ=GetPageRecord('*','totalPaxSlab',' 1 and id="'.$qTransferD['totalPax'].'"');
			$slabsData =  mysqli_fetch_array($tpxQ);
			if($slabsData['fromRange'] == $slabsData['toRange'] || $slabsData['toRange']==0){
				$paxrange = $slabsData['fromRange'];
			}else{
				$paxrange = $slabsData['fromRange'].'-'.$slabsData['toRange'];
			}
			?>
			<div id="paxSlabText<?php echo ($qTransferD['id']); ?>"><?php echo  strip($paxrange.'&nbsp;Pax'); ?></div>
			<div id="paxSlab<?php echo ($qTransferD['id']); ?>" style="display:none;">
				<select id="paxSlabInput<?php echo ($qTransferD['id']); ?>"  class="selectbox">
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
					<option value="<?php echo $totalPaxSlabD['id']; ?>" <?php if($totalPaxSlabD['id'] == $qTransferD['totalPax']){ ?> selected="selected" <?php } ?>><?php echo  strip($paxrange2.'&nbsp;Pax'); ?></option>
					<?php } ?>
				</select>
			</div>				
		</td>
		<td align="right" style="display: flex;">
			<div class="addBtn " id="editBtn<?php echo ($qTransferD['id']); ?>" style="display: inline-flex;" onclick="openinboundpop('action=addTransferTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&transferQuoteId=<?php echo $qTransferD['id'];?>','1000px');" ><i class="fa fa-plus" aria-hidden="true"></i></div>
		
			
			<div class="deleteBtn" style="display: inline-flex;"  onclick="if(confirm('Are you sure you want delete this transfer?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $qTransferD['id']; ?>','deleteQuotationTransfer');" ><i class="fa fa-trash" aria-hidden="true"></i></div>
			
			<!-- <div class="editBtn" id="editBtn<?php echo ($qTransferD['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $qTransferD['id'];?>','editQuotationTransfer');"><i class="fa fa-pencil" aria-hidden="true"></i></div> -->

			<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=editQuotationTransferRate&amp;transferQuoteId=<?php echo ($qTransferD['id']);?>','1200px');"><i class="fa fa-pencil" aria-hidden="true" style="font-size: 18px;position: relative;top: 5px;left: 10px;cursor:pointer;"></i></div>



			
			<div class="saveBtn" id="saveBtn<?php echo ($qTransferD['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $qTransferD['id'];?>','saveQuotationTransfer');"><i class="fa fa-save" aria-hidden="true"></i></div>			</td>
		</tr> 
		
	
		<!-- remarks section code started -->
		<!-- <tr><td colspan="8">Remarks: <?php echo $qTransferD['detail'];?></td></tr> -->
		<!-- remarks section code ended -->  
		</tbody>
		</table>
		<?php 
		
		$c1=GetPageRecord('*','quotationTransferTimelineDetails',' transferQuoteId="'.$qTransferD['id'].'" and quotationId="'.$qTransferD['quotationId'].'"');
		if(mysqli_num_rows($c1)>0){
		$transferTimelineData=mysqli_fetch_array($c1);
		
		if($transferTimelineData['arrivalTime']!='' && $transferTimelineData['arrivalTime']!='00:00:00'){
			$arrivalTime = date('H:i',strtotime($transferTimelineData['arrivalTime']));
		}else{
			$arrivalTime = '';
		}

		if($transferTimelineData['pickupTime']!='' && $transferTimelineData['pickupTime']!='00:00:00'){
			$pickupTime = date('H:i',strtotime($transferTimelineData['pickupTime']));
		}else{
			$pickupTime = '';
		}

		if($transferTimelineData['dropTime']!='' && $transferTimelineData['dropTime']!='00:00:00'){
			$dropTime = date('H:i',strtotime($transferTimelineData['dropTime']));
		}else{
			$dropTime = '';
		}

		if($transferTimelineData['mode']=='flight'){
			$transfername = $transferTimelineData['flightName'];
		}elseif($transferTimelineData['mode']=='train'){
			$transfername = $transferTimelineData['trainName'];
		}

		if($transferTimelineData['mode']=='flight'){
			$transferNumber = $transferTimelineData['flightNumber'];
		}elseif($transferTimelineData['mode']=='train'){
			$transferNumber = $transferTimelineData['trainNumber'];
		}


	
	?>

		<table  width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="tablesorter gridtable">
		<tr style="background:#ddd;">
						<th align="left">Mode</th>
						<?php if($transferTimelineData['mode']=='Local'){ ?>
						<th align="left">Date</th>
						<?php } if($transferTimelineData['mode']=='flight' || $transferTimelineData['mode']=='train'){ ?>
						<th align="left">Arrival&nbsp;From</th>
						<th align="left">Arrival&nbsp;Time</th>

						<th align="left">
							<?php if($transferTimelineData['mode']=='flight'){ echo 'Flight&nbsp;Name'; }else{ echo 'Train&nbsp;Name'; } ?>
						</th>
				
						<th align="left">
							<?php if($transferTimelineData['mode']=='flight'){ echo 'Flight&nbsp;Number'; }else{ echo 'Train&nbsp;Number'; } ?>
						</th>
					<?php } ?>

					<?php if($transferTimelineData['mode']=='flight'){ ?> 
						<th align="left">Airport&nbsp;Name</th>
					<?php } ?>

						<th align="left">Pickup&nbsp;Time</th>
						<th align="left">Drop&nbsp;Time</th>
						<th align="left">pickup&nbsp;Address</th>
						<th align="left">Drop&nbsp;Address</th>
					</tr>
					<tr>
						<td><?php echo ucfirst($transferTimelineData['mode']); ?></td>
						<?php if($transferTimelineData['mode']=='Local'){ ?>
						<td><?php echo date('d-m-Y',strtotime($transferTimelineData['departureDate'])); ?></td>

					<?php } if($transferTimelineData['mode']=='flight' || $transferTimelineData['mode']=='train'){ ?> 
						<td><?php echo $transferTimelineData['arrivalFrom']; ?></td>
						<td><?php echo $arrivalTime; ?></td>
						
						<td><?php echo $transfername; ?></td>
						<td><?php echo $transferNumber; ?></td>
						<?php } ?>	
						<?php if($transferTimelineData['mode']=='flight'){ ?> 
						<td align="left">
							<?php echo $transferTimelineData['airportName']; ?>
						</td>
					<?php } ?>

						<td><?php echo $pickupTime; ?></td>
						<td><?php echo $dropTime; ?></td>
						<td><?php echo $transferTimelineData['pickupAddress']; ?></td>
						<td><?php echo $transferTimelineData['dropAddress']; ?></td>
					</tr>
		</table>
		<?php } ?>
		</div>
		</td>
		</tr>
		<?php
		}
		}
	}
	if($sorting['serviceType'] == 'transportation'){
		
		$whereTransportSql='';
		$whereTransportSql=' queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'" and isGuestType=1 and id="'.$sorting['serviceId'].'" ';
		$whereTransportQuery=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,$whereTransportSql);
		if(mysqli_num_rows($whereTransportQuery)>0){
		?>
		<tr><td>
		<div style="padding:5px;border: 1px solid #006699;margin-bottom:10px;padding-right:40px;position:relative;background-color: #dddddd;">
		<div class="editButton" style="width:30px;height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
		<input name="serviceids[]" type="hidden" value="<?php echo $sorting['id']; ?>">
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="tablesorter gridtable">
		<thead>
		<tr> 
			<th align="left" bgcolor="#ddd"><div style="font-size:15px;font-weight:500;margin: 3px 0 10px 0;"><strong>Transportation</strong></div></th>
		</tr>
		</thead>
		<tbody>
		<tr><td> 
			<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class=" gridtable">
				
			<?php  
			$cnttpt = 1;
			while($qTransportData=mysqli_fetch_array($whereTransportQuery)){  
				if($cnttpt == 1){ ?>
					<tr>
					<th align="left" width="110"bgcolor="#ddd">Service Name</th>
					<th align="left" width="110"bgcolor="#ddd">Service Type</th>
					<?php if($calculationType!=3){ ?>
					<th align="left" bgcolor="#ddd" width="10%"style="display:none1;">Vehicle Type</th>
					<!-- <th align="left" bgcolor="#ddd" width="10%">Vehicle Name </th> -->
					<?php if($qTransportData['costType'] == 3) { ?>
					<th align="left" bgcolor="#ddd" width="10%">Per KM Cost</th>
					<th align="left" bgcolor="#ddd" width="10%">Distance</th>
					<?php }elseif($qTransportData['costType'] == 1){  ?>
					<th align="left" bgcolor="#ddd" width="10%">Per Day Cost</th>
					<?php }else{  ?>
					<th align="left" bgcolor="#ddd" width="10%">Vehicle Cost</th>
					<?php } ?>
					<th align="left" bgcolor="#ddd" >No.&nbsp;of Vehicle</th>
					<th align="left" bgcolor="#ddd" >Total&nbsp;Cost</th>
					<?php } ?>
					<th align="left" bgcolor="#ddd" >Pax&nbsp;Range</th> 
					<!-- <th align="left" bgcolor="#ddd" width="7%">Days</th> -->
					<th align="left" bgcolor="#ddd" width="13%">Duration</th>
					<th align="center" width="110" bgcolor="#ddd">#</th>
					<th align="left" width="100" bgcolor="#ddd">&nbsp;</th>
					</tr>	
					<?php 
				}
				
				$curr = getCurrencyName($qTransportData['currencyId']);

				$rs5='';
				$rs5=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$qTransportData['transferNameId'].'"');
				$transportD=mysqli_fetch_array($rs5);

				if($qTransportData['transferName'] == '' || $qTransportData['transferName'] == 'undefined' || strlen($qTransportData['transferName']) < 1){
					$transferName =  $transportD['transferName'];
				}else{
					$transferName =  $qTransportData['transferName'];
				}

				$vehicleCostTPT = strip($qTransportData['vehicleCost'])+strip($qTransportData['parkingFee'])+strip($qTransportData['representativeEntryFee'])+strip($qTransportData['assistance'])+strip($qTransportData['guideAllowance'])+strip($qTransportData['interStateAndToll'])+strip($qTransportData['miscellaneous']); 
				?>
				<tr>
					<td align="left"><?php 	echo strip($transferName); ?></td>
					<td align="left">Normal</td>
					<?php if($calculationType != 3){ ?>
					<td align="left" style="display:none1;">
						<div id="vehicleTypeText<?php echo ($qTransportData['id']); ?>">
						<?php
						//$select2='carType,model';
						$rs2=GetPageRecord('*','vehicleTypeMaster','id="'.$qTransportData['vehicleType'].'"');
						$editresult2=mysqli_fetch_array($rs2);
						echo $editresult2['name'];?>
						</div>
						<div id="vehicleType<?php echo ($qTransportData['id']); ?>" style="display:none;">
						<select id="vehicleTypeInput<?php echo ($qTransportData['id']); ?>"  class="selectbox"  onchange="getVehicleModel('<?php echo ($qTransportData['id']); ?>')">
						<?php
						$rs=GetPageRecord('name,id','vehicleTypeMaster',' 1 order by name asc');
						while($qTransportDatasd=mysqli_fetch_array($rs)){
						?>
						<option value="<?php echo strip($qTransportDatasd['id']); ?>" <?php if($qTransportData['vehicleType'] == strip($qTransportDatasd['id'])){ ?> selected="selected" <?php } ?>><?php echo strip($qTransportDatasd['name']); ?></option>
						<?php } ?>
						</select>
						</div>
					</td>
					
					<td align="left">
						<div id="vehicleCostText<?php echo ($qTransportData['id']); ?>"><?php echo $curr.' '.round(getCostWithGSTID_Markup($vehicleCostTPT,$qTransportData['gstTax'],$qTransportData['markupCost'],$qTransportData['markupType'])); ?></div>
						<div id="vehicleCost<?php echo ($qTransportData['id']); ?>" style="display:none;">
						<input type="text" id="vehicleCostInput<?php echo ($qTransportData['id']); ?>"  value="<?php echo  strip($qTransportData['vehicleCost']); ?>">
						</div> 
					</td>
					
					<td align="left" <?php if ($qTransportData['costType'] != 3) { ?>style="display:none;"<?php } ?>>
						<div id="distanceText<?php echo ($qTransportData['id']); ?>"><?php echo strip($qTransportData['distance']); ?> KM</div>
						<div id="distance<?php echo ($qTransportData['id']); ?>" style="display:none;">
						<input type="text" id="distanceInput<?php echo ($qTransportData['id']); ?>"  value="<?php echo  strip($qTransportData['distance']); ?>">
						</div> 
					</td>
					

					<td align="left">
						<div id="noOfVehiclesText<?php echo ($qTransportData['id']); ?>"><?php echo  strip($qTransportData['noOfVehicles']); ?></div>
						<div id="noOfVehicles<?php echo ($qTransportData['id']); ?>" style="display:none;">
						<input type="text" id="noOfVehiclesInput<?php echo ($qTransportData['id']); ?>"  value="<?php echo  strip($qTransportData['noOfVehicles']); ?>">
						</div>
					</td>
					<td align="left">
					<?php if ($qTransportData['costType'] == 3) { ?>
						<div ><?php echo $curr.' '.round(getCostWithGSTID_Markup($vehicleCostTPT,$qTransportData['gstTax'],$qTransportData['markupCost'],$qTransportData['markupType'])*$qTransportData['noOfVehicles']*$qTransportData['distance']); ?></div>
					<?php }else{  ?>
						<div ><?php echo $curr.' '.round(getCostWithGSTID_Markup($vehicleCostTPT,$qTransportData['gstTax'],$qTransportData['markupCost'],$qTransportData['markupType'])*$qTransportData['noOfVehicles']); ?></div>
					<?php } ?>
					</td>
					<?php } ?>
					<td align="left">
						<?php
						$tpxQ="";
						$tpxQ=GetPageRecord('*','totalPaxSlab',' 1 and id="'.$qTransportData['totalPax'].'"');
						$slabsData =  mysqli_fetch_array($tpxQ);
						if($slabsData['fromRange'] == $slabsData['toRange'] || $slabsData['toRange']==0){
							$paxrange = $slabsData['fromRange'];
						}else{
							$paxrange = $slabsData['fromRange'].'-'.$slabsData['toRange'];
						}
						?>
						<div id="paxSlabText<?php echo ($qTransportData['id']); ?>"><?php echo  strip($paxrange.'&nbsp;Pax'); ?></div>
						<div id="paxSlab<?php echo ($qTransportData['id']); ?>" style="display:none;">
							<select id="paxSlabInput<?php echo ($qTransportData['id']); ?>"  class="selectbox">
								<option value="">Select Model</option>
								<?php
								$tpxQ2='';
								$tpxQ2=GetPageRecord('*','totalPaxSlab',' 1 and quotationId="'.$quotationData['id'].'" ');
								while($totalPaxSlabD=mysqli_fetch_array($tpxQ2)){
									if($totalPaxSlabD['fromRange'] == $totalPaxSlabD['toRange'] || $totalPaxSlabD['toRange']==0){
										$paxrange2 = $totalPaxSlabD['fromRange'];
									}else{
										$paxrange2 = $totalPaxSlabD['fromRange'].'-'.$totalPaxSlabD['toRange'];
									}
								?>
								<option value="<?php echo $totalPaxSlabD['id']; ?>" <?php if($totalPaxSlabD['id'] == $qTransportData['totalPax']){ ?> selected="selected" <?php } ?>><?php echo  strip($paxrange2.'&nbsp;Pax'); ?></option>
								<?php } ?>
							</select>
						</div>	

					</td>
					
					<!-- <td align="left" ><?php if($qTransportData['costType']==2){ ?> 1 <?php }else{ echo strip($qTransportData['noOfDays']); } ?> Days</td> -->

					<td style="min-width: 85px;"><?php echo 'Day '.$qTransportData['startDay'].' - '.'Day '.$qTransportData['endDay']; ?></td>

					<td align="left">
						<div class="viewMoreBtn fa fa-plus" style="float:none;" title="Supplement" onClick="openinboundpop('action=addServiceTransportation&stype=transferSupplement&dayId=<?php echo $QueryDaysData['id']; ?>&transferQuoteId=<?php echo $qTransportData['id'];?>','1000px');">&nbsp;Supplement</div>
					</td>
				
					<td align="right"  style="    display: flex;">
						<!-- <div class="addRSP hotelsave" id="editBtn<?php echo ($qTransportData['id']); ?>" style="display: inline-flex;padding: 2px 7px !important;" onclick="openinboundpop('action=addTransferTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&transferQuoteId=<?php echo $qTransportData['id'];?>','1000px');" ><i class="fa fa-plus" aria-hidden="true"></i></div> -->

						<div class="addBtn " id="editBtn<?php echo ($qTransportData['id']); ?>" style="display: inline-flex;" onclick="openinboundpop('action=addTransferTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&transferQuoteId=<?php echo $qTransportData['id'];?>','1000px');" ><i class="fa fa-plus" aria-hidden="true"></i></div>
		
						

						<!-- <div class="editBtn" id="editBtn<?php echo ($qTransportData['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $qTransportData['id'];?>','editQuotationTransport');"><i class="fa fa-pencil" aria-hidden="true"></i></div> -->


						<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=editQuotationTransportRate&amp;transportQuoteId=<?php echo ($qTransportData['id']);?>','1200px');"><i class="fa fa-pencil" aria-hidden="true" style="font-size: 18px;position: relative;top: 3px;left: 3px;cursor:pointer;"></i></div>



						<div class="saveBtn" id="saveBtn<?php echo ($qTransportData['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $qTransportData['id'];?>','saveQuotationTransport');"><i class="fa fa-save" aria-hidden="true"></i></div>	
						
						<div class="deleteBtn" style="display: inline-flex;"  onclick="if(confirm('Are you sure you want delete this transfer?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $qTransportData['id']; ?>','deleteQuotationTransport');" ><i class="fa fa-trash" aria-hidden="true"></i></div>
					</td> 
				</tr>

				<?php 
				$where12='';
				$transferQuoteId = $qTransportData['id'];
				$where12=' transferQuoteId="'.$transferQuoteId.'" and quotationId="'.$quotationId.'" and isSupplement=1 ';
				$rs12=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,$where12);
				while($qTransportSuppData=mysqli_fetch_array($rs12)){

					$rs5='';
					$rs5=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$qTransportSuppData['transferNameId'].'"');
					$transferSuppData2=mysqli_fetch_array($rs5);

					$transferName =  '';
					if($qTransportSuppData['transferName'] == '' || strlen($qTransportSuppData['transferName']) < 1){
						$transferName =  $transferSuppData2['transferName'];
					}else{
						$transferName =  $qTransportSuppData['transferName'];
					}

					$curr = getCurrencyName($qTransportSuppData['currencyId']);

					?>
				<tr>
					<td align="left"><?php 	echo strip($transferName); ?></td>
					<td align="left"><?php echo ($qTransportSuppData['isGuestType']==1 && $qTransportSuppData['isSelectedFinal']==1 && $qTransportSuppData['isSupplement']==0 )?'Normal':'Supplement'; ?></td>

					<td align="left" style="display:none;">
						<div id="vehicleTypeText<?php echo ($qTransportSuppData['id']); ?>">
						<?php
						//$select2='carType,model';
						$where2='id="'.$qTransportSuppData['vehicleModelId'].'"';
						$rs2=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,$where2);
						$editresult2=mysqli_fetch_array($rs2);
						echo getVehicleTypeName($editresult2['carType']); ?>
						</div>
						<div id="vehicleType<?php echo ($qTransportSuppData['id']); ?>" style="display:none;">
						<select id="vehicleTypeInput<?php echo ($qTransportSuppData['id']); ?>"  class="selectbox"  onchange="getVehicleModel('<?php echo ($qTransportSuppData['id']); ?>')">
						<?php
						$rs=GetPageRecord('name,id','vehicleTypeMaster',' 1 order by name asc');
						while($qTransportSuppDatasd=mysqli_fetch_array($rs)){
						?>
						<option value="<?php echo strip($qTransportSuppDatasd['id']); ?>" <?php if($editresult2['carType'] == strip($qTransportSuppDatasd['id'])){ ?> selected="selected" <?php } ?>><?php echo strip($qTransportSuppDatasd['name']); ?></option>
						<?php } ?>
						</select>
						</div>
					</td>
					<td align="left">
						<div id="vehicleModelIdText<?php echo ($qTransportSuppData['id']); ?>"><?php echo $editresult2['model']; ?>	</div>
						<div id="vehicleModelId<?php echo ($qTransportSuppData['id']); ?>" style="display:none;">
						<select id="vehicleModelIdInput<?php echo ($qTransportSuppData['id']); ?>"  class="selectbox">
						<option value="">Select Model</option>
						<?php
						$select='*';
						$where=' 1 order by id asc';
						$rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where);
						while($qTransportSuppData2=mysqli_fetch_array($rs)){
						?>
						<option value="<?php echo $qTransportSuppData2['id']; ?>" <?php if($qTransportSuppData2['id'] == $qTransportSuppData['vehicleModelId']){ ?> selected="selected" <?php } ?>><?php echo $qTransportSuppData2['model']; ?></option>
						<?php } ?>
						</select>
						</div>
						<script type="text/javascript">
						function getVehicleModel(id) {
						var vehicleType = $('#vehicleTypeInput'+id).val();
						$("#vehicleModelIdInput"+id).load('loadvehiclemodel.php?vehicleTypeId='+vehicleType);
						}
						</script>				    
					</td>
					<td align="left">
						<div id="vehicleCostText<?php echo ($qTransportSuppData['id']); ?>"><?php echo  strip($qTransportSuppData['vehicleCost']); ?></div>
						<div id="vehicleCost<?php echo ($qTransportSuppData['id']); ?>" style="display:none;">
						<input type="text" id="vehicleCostInput<?php echo ($qTransportSuppData['id']); ?>"  value="<?php echo $curr.' '.strip($qTransportSuppData['vehicleCost']); ?>">
						</div> 
					</td>
					<td align="left">
						<div id="noOfVehiclesText<?php echo ($qTransportSuppData['id']); ?>"><?php echo  strip($qTransportSuppData['noOfVehicles']); ?></div>
						<div id="noOfVehicles<?php echo ($qTransportSuppData['id']); ?>" style="display:none;">
						<input type="text" id="noOfVehiclesInput<?php echo ($qTransportSuppData['id']); ?>"  value="<?php echo  strip($qTransportSuppData['noOfVehicles']); ?>">
						</div>
					</td>
					<td align="left">
						<div ><?php echo  round($qTransportSuppData['vehicleCost']*$qTransportSuppData['noOfVehicles']); ?></div>
					</td>
					<td align="left">
						<?php
						$tpxQ="";
						$tpxQ=GetPageRecord('*','totalPaxSlab',' 1 and id="'.$qTransportSuppData['totalPax'].'"');
						$slabsData =  mysqli_fetch_array($tpxQ);
						if($slabsData['fromRange'] == $slabsData['toRange'] || $slabsData['toRange']==0){
							$paxrange = $slabsData['fromRange'];
						}else{
							$paxrange = $slabsData['fromRange'].'-'.$slabsData['toRange'];
						}
						?>
						<div id="paxSlabText<?php echo ($qTransportSuppData['id']); ?>"><?php echo  strip($paxrange.'&nbsp;Pax'); ?></div>
						<div id="paxSlab<?php echo ($qTransportSuppData['id']); ?>" style="display:none;">
							<select id="paxSlabInput<?php echo ($qTransportSuppData['id']); ?>"  class="selectbox">
								<option value="">Select Model</option>
								<?php
								$tpxQ2='';
								$tpxQ2=GetPageRecord('*','totalPaxSlab',' 1 and quotationId="'.$quotationData['id'].'" ');
								while($totalPaxSlabD=mysqli_fetch_array($tpxQ2)){
									if($totalPaxSlabD['fromRange'] == $totalPaxSlabD['toRange'] || $totalPaxSlabD['toRange']==0){
										$paxrange2 = $totalPaxSlabD['fromRange'];
									}else{
										$paxrange2 = $totalPaxSlabD['fromRange'].'-'.$totalPaxSlabD['toRange'];
									}
								?>
								<option value="<?php echo $totalPaxSlabD['id']; ?>" <?php if($totalPaxSlabD['id'] == $qTransportSuppData['totalPax']){ ?> selected="selected" <?php } ?>><?php echo  strip($paxrange2.'&nbsp;Pax'); ?></option>
								<?php } ?>
							</select>
						</div>				
					</td> 
					<td align="left" ><?php if($qTransportSuppData['costType']==2){ ?> 1 <?php }else{ echo strip($qTransportSuppData['noOfDays']); } ?> Days</td>
					<td align="left">
					</td>
					<td align="right">
						<div class="addRSP hotelsave" id="editBtn<?php echo ($qTransportSuppData['id']); ?>" style="display: inline-flex;padding: 2px 7px !important;" onclick="openinboundpop('action=addTransferTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&transferQuoteId=<?php echo $qTransportSuppData['id'];?>','1000px');" ><i class="fa fa-plus" aria-hidden="true"></i></div>


						<div class="deleteBtn" style="display: inline-flex;"  onclick="if(confirm('Are you sure you want delete this transfer?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $qTransportSuppData['id']; ?>','deleteQuotationTransport');" ><i class="fa fa-trash" aria-hidden="true"></i></div>

						<div class="editBtn" id="editBtn<?php echo ($qTransportSuppData['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $qTransportSuppData['id'];?>','editQuotationTransport');"><i class="fa fa-pencil" aria-hidden="true"></i></div>

						<div class="saveBtn" id="saveBtn<?php echo ($qTransportSuppData['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $qTransportSuppData['id'];?>','saveQuotationTransport');"><i class="fa fa-save" aria-hidden="true"></i></div>			
					</td> 
				</tr>
				<?php
				}	
						
				$c1=GetPageRecord('*','quotationTransferTimelineDetails',' transferQuoteId="'.$qTransportData['id'].'" and quotationId="'.$qTransportData['quotationId'].'"');
				if(mysqli_num_rows($c1)>0){
				$transferTimelineData=mysqli_fetch_array($c1);
				
				if($transferTimelineData['arrivalTime']!='' && $transferTimelineData['arrivalTime']!='00:00:00'){
					$arrivalTime = date('H:i',strtotime($transferTimelineData['arrivalTime']));
				}else{
					$arrivalTime = '';
				}

				if($transferTimelineData['pickupTime']!='' && $transferTimelineData['pickupTime']!='00:00:00'){
					$pickupTime = date('H:i',strtotime($transferTimelineData['pickupTime']));
				}else{
					$pickupTime = '';
				}

				if($transferTimelineData['dropTime']!='' && $transferTimelineData['dropTime']!='00:00:00'){
					$dropTime = date('H:i',strtotime($transferTimelineData['dropTime']));
				}else{
					$dropTime = '';
				}

				if($transferTimelineData['mode']=='flight'){
					$transfername = $transferTimelineData['flightName'];
				}elseif($transferTimelineData['mode']=='train'){
					$transfername = $transferTimelineData['trainName'];
				}

				if($transferTimelineData['mode']=='flight'){
					$transferNumber = $transferTimelineData['flightNumber'];
				}elseif($transferTimelineData['mode']=='train'){
					$transferNumber = $transferTimelineData['trainNumber'];
				}


			
				?>

				<table  width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="tablesorter gridtable">
				<tr style="background:#ddd;">
					<th align="left">Mode</th>
					<?php if($transferTimelineData['mode']=='Local'){ ?>
					<th align="left">Date</th>
					<?php } if($transferTimelineData['mode']=='flight' || $transferTimelineData['mode']=='train'){ ?>
					<th align="left">Arrival&nbsp;From</th>
					<th align="left">Arrival&nbsp;Time</th>

					<th align="left">
						<?php if($transferTimelineData['mode']=='flight'){ echo 'Flight&nbsp;Name'; }else{ echo 'Train&nbsp;Name'; } ?>
					</th>

					<th align="left">
						<?php if($transferTimelineData['mode']=='flight'){ echo 'Flight&nbsp;Number'; }else{ echo 'Train&nbsp;Number'; } ?>
					</th>
				<?php } ?>

				<?php if($transferTimelineData['mode']=='flight'){ ?> 
					<th align="left">Airport&nbsp;Name</th>
				<?php } ?>

					<th align="left">Pickup&nbsp;Time</th>
					<th align="left">Drop&nbsp;Time</th>
					<th align="left">pickup&nbsp;Address</th>
					<th align="left">Drop&nbsp;Address</th>
				</tr>
				<tr>
					<td><?php echo ucfirst($transferTimelineData['mode']); ?></td>
					<?php if($transferTimelineData['mode']=='Local'){ ?>
					<td><?php echo date('d-m-Y',strtotime($transferTimelineData['departureDate'])); ?></td>

				<?php } if($transferTimelineData['mode']=='flight' || $transferTimelineData['mode']=='train'){ ?> 
					<td><?php echo $transferTimelineData['arrivalFrom']; ?></td>
					<td><?php echo $arrivalTime; ?></td>
					
					<td><?php echo $transfername; ?></td>
					<td><?php echo $transferNumber; ?></td>
					<?php } ?>	
					<?php if($transferTimelineData['mode']=='flight'){ ?> 
					<td align="left">
						<?php echo $transferTimelineData['airportName']; ?>
					</td>
				<?php } ?>

					<td><?php echo $pickupTime; ?></td>
					<td><?php echo $dropTime; ?></td>
					<td><?php echo $transferTimelineData['pickupAddress']; ?></td>
					<td><?php echo $transferTimelineData['dropAddress']; ?></td>
				</tr>
				</table>
				<?php 
				} 

				$cnttpt++;	
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
	if($sorting['serviceType'] == 'guide'){
		
		$where1='';
		$where1=' queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'" and isGuestType=1 and id="'.$sorting['serviceId'].'" ';
		$rs1=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,$where1);
		if(mysqli_num_rows($rs1)>0){ ?>
		<tr><td>
		<div style="padding:5px;border: 1px solid #006699;margin-bottom:10px;padding-right:40px;position:relative;background-color: #dddddd;">
			<div class="editButton" style="width:30px;height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
			<input name="serviceids[]" type="hidden" value="<?php echo $sorting['id']; ?>">
			<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="tablesorter gridtable">
			<thead><tr><th align="left" bgcolor="#ddd">
				<div style="font-size:15px;font-weight:500;margin: 3px 0 10px 0;"><strong>Guide/Tour&nbsp;Escort</strong></div>
			</th></tr></thead>
			<tbody><tr><td> 
			<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class=" gridtable">
				<thead>
				<tr>
				<th align="left" width="250"bgcolor="#ddd">Service&nbsp;Name</th>
				<th align="left" width="110"bgcolor="#ddd">Service&nbsp;Type</th>
				<th align="left" bgcolor="#ddd">Day&nbsp;Type</th> 
				<th align="left" bgcolor="#ddd">Pax&nbsp;Range</th>
				<th align="left" bgcolor="#ddd">Pax&nbsp;Slab</th>
				<th align="left" bgcolor="#ddd">Total&nbsp;Days </th>
				<?php if($calculationType!=3){  ?>
				<th align="left" bgcolor="#ddd">Per&nbsp;Day&nbsp;Cost </th>
				<th align="left" bgcolor="#ddd">Total&nbsp;Cost</th>
				<?php } ?>
				<th align="center" width="110" bgcolor="#ddd">#</th>
				<th align="left" width="80" bgcolor="#ddd">&nbsp;</th>
				</tr>
				</thead>
				<tbody>
				<?php 
				while($quotationGuideData=mysqli_fetch_array($rs1)){  

					$rs5='';
					$rs5=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$quotationGuideData['guideId'].'"');
					$GuideData5=mysqli_fetch_array($rs5);

					if(trim($quotationGuideData['dayType']) == 'fullday'){
						$dayType = "Full Day";
					}else{
						$dayType = "Half Day";
					}	
					$totalGuideCost = ($quotationGuideData['price']+$quotationGuideData['otherCost']+$quotationGuideData['languageAllowance']);
				
					?>
					<tr>
						
						<td align="left"><?php echo strip($GuideData5['name']); ?></td>
						<td align="left">Normal</td>
						<td align="left"><?php  echo trim($dayType); ?></td> 
						<td align="left">
						<?php  if (strip($quotationGuideData['paxRange'])==0){ echo "All"; }else{ echo str_replace('_',' to ',$quotationGuideData['paxRange']);  } ?>
						</td> 
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

						<?php if($calculationType!=3){  ?>
						<td align="left">
							<div id="perDaycostText<?php echo ($quotationGuideData['id']); ?>"><?php echo  getCurrencyName($quotationGuideData['currencyId'])." ".getCostWithGSTID_Markup(($totalGuideCost),$quotationGuideData['gstTax'],$quotationGuideData['markupCost'],$quotationGuideData['markupType']); ?></div>

							<div id="perDaycost<?php echo ($quotationGuideData['id']); ?>" style="display:none;">
							<input type="text" id="perDaycostInput<?php echo ($quotationGuideData['id']); ?>"  value="<?php echo  strip($quotationGuideData['perDaycost']); ?>">
							</div>					
						</td>
						<td align="left" ><span id="priceText<?php echo ($quotationGuideData['id']); ?>"><?php echo  getCurrencyName($quotationGuideData['currencyId'])." ".getCostWithGSTID_Markup(($totalGuideCost*$quotationGuideData['totalDays']),$quotationGuideData['gstTax'],$quotationGuideData['markupCost'],$quotationGuideData['markupType']); ?></span></td>
						<?php } ?>
						<td align="left">
							<div class="viewMoreBtn fa fa-plus" style="float:none;" title="Supplement" onClick="openinboundpop('action=addServiceGuide&stype=guideSupplement&dayId=<?php echo $QueryDaysData['id']; ?>&guideQuoteId=<?php echo $quotationGuideData['id'];?>','1000px');">&nbsp;Supplement</div>
						</td>

						<td align="right" style="display: flex;">
							<div class="deleteBtn" style="display: inline-flex;" onclick="if(confirm('Are you sure you want delete this Tour Escort rule?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationGuideData['id']; ?>','deleteGuideQuotation');" ><i class="fa fa-trash" aria-hidden="true"></i></div>
							
							<!-- 
							<div class="editBtn" id="editBtn<?php echo ($quotationGuideData['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationGuideData['id'];?>','editGuideQuotation');"><i class="fa fa-pencil" aria-hidden="true"></i></div> -->


							<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=editQuotationGuideRate&amp;GuideQuoteId=<?php echo ($quotationGuideData['id']);?>','1200px');"><i class="fa fa-pencil" aria-hidden="true" style="font-size: 17px;position: relative;left: 10px;top: 5px;cursor:pointer;"></i></div>




							<div class="saveBtn" id="saveBtn<?php echo ($quotationGuideData['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationGuideData['id'];?>','saveGuideQuotation');"><i class="fa fa-save" aria-hidden="true"></i></div>					
						</td>
					</tr>
					<?php 
					$where12='';
					$guideQuoteId = $quotationGuideData['id'];
					$where12=' guideQuoteId="'.$guideQuoteId.'" and quotationId="'.$quotationId.'" and isSupplement=1 ';
					$rs12=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,$where12);
					while($quotationGuideSuppData=mysqli_fetch_array($rs12)){
						$rs5='';
						$rs5=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$quotationGuideSuppData['guideId'].'"');
						$GuideData52=mysqli_fetch_array($rs5);

						if(trim($quotationGuideSuppData['dayType']) == 'fullday'){
							$dayType = "Full Day";
						}else{
							$dayType = "Half Day";
						}	
						 
						?>
						<tr>
							
							<td align="left"><?php echo strip($GuideData52['name']); ?></td>

							<td align="left"><?php echo ($quotationGuideSuppData['isGuestType']==1 && $quotationGuideSuppData['isSelectedFinal']==1 && $quotationGuideSuppData['isSupplement']==0 )?'Normal':'Supplement'; ?></td>
							<td align="left"><?php  echo ($dayType); ?></td> 
							<td align="left">
							<?php  if (strip($quotationGuideSuppData['paxRange'])==0){ echo "All"; }else{ echo str_replace('_',' to ',$quotationGuideSuppData['paxRange']);  } ?>
							</td> 
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
							<?php if($calculationType!=3){  ?>
							<td align="left">
								<div id="perDaycostText<?php echo ($quotationGuideSuppData['id']); ?>"><?php echo  getCurrencyName($quotationGuideSuppData['currencyId'])." ".strip($quotationGuideSuppData['perDaycost']); ?></div>
								<div id="perDaycost<?php echo ($quotationGuideSuppData['id']); ?>" style="display:none;">
								<input type="text" id="perDaycostInput<?php echo ($quotationGuideSuppData['id']); ?>"  value="<?php echo  strip($quotationGuideSuppData['perDaycost']); ?>">
								</div>					
							</td>
							<td align="left" ><span id="priceText<?php echo ($quotationGuideSuppData['id']); ?>"><?php echo  getCurrencyName($quotationGuideSuppData['currencyId'])." ".$quotationGuideSuppData['price']; ?></span></td>
							<?php } ?>
							<td align="left"></td>
							<td align="right">
								<div class="deleteBtn" style="display: inline-flex;" onclick="if(confirm('Are you sure you want delete this Tour Escort rule?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationGuideSuppData['id']; ?>','deleteGuideQuotation');" ><i class="fa fa-trash" aria-hidden="true"></i></div>

								<div class="editBtn" id="editBtn<?php echo ($quotationGuideSuppData['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationGuideSuppData['id'];?>','editGuideQuotation');"><i class="fa fa-pencil" aria-hidden="true"></i></div>

								<div class="saveBtn" id="saveBtn<?php echo ($quotationGuideSuppData['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationGuideSuppData['id'];?>','saveGuideQuotation');"><i class="fa fa-save" aria-hidden="true"></i></div>					
							</td>
						</tr>
						<?php	
					}
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
	if($sorting['serviceType'] == 'ferry' ){
		// quotation hotel data
		$rs1='';
		$rs1=GetPageRecord('*',_QUOTATION_FERRY_MASTER_,' quotationId="'.$quotationId.'" and id="'.$sorting['serviceId'].'"');
		if(mysqli_num_rows($rs1)>0){
		while($quotationFerryData=mysqli_fetch_array($rs1)){
			
		$d=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,' id="'.$quotationFerryData['serviceid'].'"');
		$ferryData=mysqli_fetch_array($d);

		$curr = getCurrencyName($quotationFerryData['currencyId']);
		$miscCost = $quotationFerryData['miscCost'];
		?>
		<tr> <td>
		<input name="serviceids[]" type="hidden"  value="<?php echo $sorting['id']; ?>">
		<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;"><div class="editButton" style="width:30px;height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
		
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
		<thead>
			<tr>
			
			<th align="left" bgcolor="#ddd" >From&nbsp;Destination</th> 
			<th align="left" bgcolor="#ddd" >To&nbsp;Destination</th> 


			<th align="left" bgcolor="#ddd" >Ferry&nbsp;Service</th> 
			<th align="left" bgcolor="#ddd" >Ferry&nbsp;Name</th>
			<th align="left" bgcolor="#ddd" >Ferry&nbsp;Class</th>
			<th align="left" bgcolor="#ddd" >Departure<br>Date/Time</th>
			<th align="left" bgcolor="#ddd" >Arrival<br>Date/Time</th>
			<?php if($calculationType != 3){ ?>
			<th align="left" bgcolor="#ddd" >Adult&nbsp;Cost</th>
			<th align="left" bgcolor="#ddd" >Child&nbsp;Cost</th>
			<th align="left" bgcolor="#ddd" >Infant&nbsp;Cost</th>
			<!-- <th align="left" bgcolor="#ddd" >Proc.&nbsp;Fee</th> -->
			<!-- <th align="left" bgcolor="#ddd" >Misc.&nbsp;Cost</th> -->
			<?php } ?>
			<th align="right" bgcolor="#ddd">&nbsp;</th>
			</tr>
		</thead>
		<tbody> 
		<tr>

		<td align="left"><?php echo getDestination($quotationFerryData['destinationId']); ?></td>
		<td align="left"><?php echo getDestination($quotationFerryData['todestination']); ?></td>


		<td align="left"><?php echo trim($ferryData['name']); ?></td>
		<td align="left"><?php
			$ferryNamQuery1='';
			$ferryNamQuery1=GetPageRecord('name',_FERRY_NAME_MASTER_,'id="'.$quotationFerryData['ferryNameId'].'"');
			$ferryNamD1=mysqli_fetch_array($ferryNamQuery1);
			echo trim($ferryNamD1['name']);
			?></td>
		<td align="left"><?php
			$ferryClassQuery1='';
			$ferryClassQuery1=GetPageRecord('name',_FERRY_CLASS_MASTER_,'id="'.$quotationFerryData['ferryClass'].'"');
			$ferryClassD1=mysqli_fetch_array($ferryClassQuery1);
			echo trim($ferryClassD1['name']);
			?></td>
			<td align="left"><?php echo date('d-m-Y',strtotime($quotationFerryData['fromDate'])).'<br>'.$quotationFerryData['dropTime']; ?></td>
			<td align="left"><?php echo date('d-m-Y',strtotime($quotationFerryData['fromDate'])).'<br>'.$quotationFerryData['pickupTime']; ?></td>
		<?php if($calculationType != 3){ ?>
		<td align="left"><?php echo  $curr.' '.getCostWithGSTID_Markup(($quotationFerryData['adultCost']+$miscCost),$quotationFerryData['gstTax'],$quotationFerryData['markupCost'],$quotationFerryData['markupType']); ?></td>
		<td align="left"><?php echo  $curr.' '.getCostWithGSTID_Markup(($quotationFerryData['childCost']+$miscCost),$quotationFerryData['gstTax'],$quotationFerryData['markupCost'],$quotationFerryData['markupType']); ?></td>
		<td align="left"><?php echo  $curr.' '.getCostWithGSTID_Markup(($quotationFerryData['infantCost']+$miscCost),$quotationFerryData['gstTax'],$quotationFerryData['markupCost'],$quotationFerryData['markupType']); ?></td>
		<!-- <td align="left"><?php //echo  $curr.' '.getCostWithGSTID_Markup($quotationFerryData['processingfee'],$quotationFerryData['gstTax'],$quotationFerryData['markupCost'],$quotationFerryData['markupType']); ?></td> -->
		<!-- <td align="left"><?php //echo  $curr.' '.$quotationFerryData['miscCost']; ?></td> -->
		<?php } ?> 
		<td width="80" align="left">
			<div class="viewMoreBtn fa fa-plus" onclick="showlinkBox('#linkBox_ferry<?php echo ($sorting['id']); ?>');">&nbsp;&nbsp;More</div>
			<div class="linkBox" id="linkBox_ferry<?php echo ($sorting['id']); ?>" style="display: none;">
				<div class="dltBtn links" onclick="if(confirm('Are you sure you want delete this Ferry?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationFerryData['id']; ?>','deleteQuotationFerry');"  style="color: red;"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</div>
				<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=editQuotationFerryRate&amp;ferryQuoteId=<?php echo ($quotationFerryData['id']);?>','700px');"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</div>
				<!-- <div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=addFlightTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&ferryQuoteId=<?php echo $quotationFerryData['id'];?>&flightId=<?php echo $quotationFerryData['flightId'];?>','800px');"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;Timing</div> -->
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
	}

	if($sorting['serviceType'] == 'cruise'){
		$n=1;
		$rs1=GetPageRecord('*',_QUOTATION_CRUISE_MASTER_,' queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'"and id="'.$sorting['serviceId'].'"  order by id asc');
		if(mysqli_num_rows($rs1)>0){
		while($quotationCruiseData = mysqli_fetch_array($rs1)){
			$cruiseSql=GetPageRecord('*',_CRUISE_MASTER_,' id="'.$quotationCruiseData['serviceId'].'" and status=1');
			$cruiseData=mysqli_fetch_array($cruiseSql);

			$cruiseNamQuery=GetPageRecord('*',_CRUISE_NAME_MASTER_,' id="'.$quotationCruiseData['cruiseNameId'].'"'); 
			$cruiseNamD=mysqli_fetch_array($cruiseNamQuery); 

            $cabinTypeQuery=GetPageRecord('*',_CABIN_TYPE_,' id="'.$quotationCruiseData['cabinTypeId'].'"'); 
			$cabinNamD=mysqli_fetch_array($cabinTypeQuery); 
			
			?>
			<tr>
			<td>
				<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;">
					<div class="editButton" style="width:30px;height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
					<input name="serviceids[]" type="hidden"  value="<?php echo $sorting['id']; ?>">
					<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
						<thead>
							<tr>
								<th align="left" bgcolor="#ddd" width="25%">Cruise&nbsp;Package&nbsp;Name </th>
								<th align="left" bgcolor="#ddd"width="10%">Cruise&nbsp;City</th>
								
								<th align="left" bgcolor="#ddd" width="15%">Cruise&nbsp;Name</th>
								<th align="left" bgcolor="#ddd" width="15%">Cabin&nbsp;Type</th>
								<th align="left" bgcolor="#ddd"width="14%">Departure&nbsp;Date</th>
								<?php if($calculationType!= 3){ ?>	
								<th align="left" bgcolor="#ddd">Adult&nbsp;Cost</th>
								<th align="left" bgcolor="#ddd">Child&nbsp;Cost</th>
								<th align="left" bgcolor="#ddd">Infant&nbsp;Cost</th>
								
								<?php } ?>	
								<th align="left" bgcolor="#ddd">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td align="left"><span class="style1">  <?php echo ucfirst($cruiseData['cruiseName']); ?></span></td>
								
								<td align="left"><span class="style1">  <?php echo getDestination($quotationCruiseData['destinationId']); ?></span></td>

								<td align="left">
								<div id="cruiseNameId<?php echo ($quotationCruiseData['id']); ?>"class="style1"><?php echo ucfirst($cruiseNamD['name']); ?></div>

									<div id="cruiseNameText<?php echo $quotationCruiseData['id']; ?>" class="style1" style="display:none" >
										<select name="cruiseNameSelect<?php echo $quotationCruiseData['id']; ?>" id="cruiseNameSelect<?php echo $quotationCruiseData['id']; ?>" style="width:130px;">
											<?php 
											$cruiseQuery1=GetPageRecord('*',_CRUISE_NAME_MASTER_,' status=1 and name!="" order by name asc'); 
											while($cruiseNamD1=mysqli_fetch_array($cruiseQuery1)){
												?>
												<option value="<?php echo $cruiseNamD1['id']; ?>" <?php if($cruiseNamD1['id']==$quotationCruiseData['cruiseNameId']){ echo 'selected'; } ?> > <?php echo $cruiseNamD1['name']; ?></option>
												<?php
											}; 
											?>
											
										</select>
									</div>
							</td>

								<td align="left">
									<div id="cabinTypeId<?php echo ($quotationCruiseData['id']); ?>"class="style1"><?php echo ucfirst($cabinNamD['name']); ?></div>

									<div id="cabinTypeText<?php echo $quotationCruiseData['id']; ?>" class="style1" style="display:none;">
										<select name="cabinTypeSelect<?php echo $quotationCruiseData['id']; ?>" id="cabinTypeSelect<?php echo $quotationCruiseData['id']; ?>" style="width:130px;">
											<?php 
											 $cabinTypeQuery1=GetPageRecord('*',_CABIN_TYPE_,' status=1 and name!="" order by name asc'); 
											 while($cabinNamD1=mysqli_fetch_array($cabinTypeQuery1)){
												?>
												<option value="<?php echo $cabinNamD1['id']; ?>" <?php if($cabinNamD1['id']==$quotationCruiseData['cabinTypeId']){ echo 'selected'; } ?> > <?php echo $cabinNamD1['name']; ?></option>
												<?php
											 }; 
											?>
											
										</select>
									</div>
								</td>

								<td align="left"> 
									<?php 
									echo date('d-m-Y',strtotime($quotationCruiseData['departureDate'])).'<br>';
									echo 'Duration - '.$cruiseData['duration'].' Days';
									?>
								</td>
								
								
								<?php if($calculationType != 3){ ?>	
								<td align="left">
									<div id="cruiseadultCost<?php echo ($quotationCruiseData['id']); ?>"><?php echo  getCurrencyName($quotationCruiseData['currencyId'])." ".getCostWithGSTID_Markup($quotationCruiseData['adultCost'],$quotationCruiseData['gstTax'],$quotationCruiseData['markupCost'],$quotationCruiseData['markupType']); ?></div>
									
									<div id="cruiseadultCostText<?php echo ($quotationCruiseData['id']); ?>" style="display:none;">
										<input type="text" id="cruiseadultCostInput<?php echo ($quotationCruiseData['id']); ?>"  value="<?php echo strip($quotationCruiseData['adultCost']); ?>" style="width:100px;">
									</div>
								</td>
								<td align="left">
									<div id="cruisechildCost<?php echo ($quotationCruiseData['id']); ?>"><?php echo  getCurrencyName($quotationCruiseData['currencyId'])." ".getCostWithGSTID_Markup($quotationCruiseData['childCost'],$quotationCruiseData['gstTax'],$quotationCruiseData['markupCost'],$quotationCruiseData['markupType']);; ?></div>
									
									<div id="cruisechildCostText<?php echo ($quotationCruiseData['id']); ?>" style="display:none;">
										<input type="text" id="cruisechildCostInput<?php echo ($quotationCruiseData['id']); ?>"  value="<?php echo strip($quotationCruiseData['childCost']); ?>" style="width:100px;">
									</div>
								</td>

								<td align="left">
									<div id="cruiseinfantCost<?php echo ($quotationCruiseData['id']); ?>"><?php echo  getCurrencyName($quotationCruiseData['currencyId'])." ".getCostWithGSTID_Markup($quotationCruiseData['infantCost'],$quotationCruiseData['gstTax'],$quotationCruiseData['markupCost'],$quotationCruiseData['markupType']);; ?></div>
									
									<div id="cruiseinfantCostText<?php echo ($quotationCruiseData['id']); ?>" style="display:none;">
										<input type="text" id="cruiseinfantCostInput<?php echo ($quotationCruiseData['id']); ?>"  value="<?php echo strip($quotationCruiseData['infantCost']); ?>" style="width:100px;">
									</div>
								</td>
								<?php } ?>	

								<td width="80" align="left">
									<div class="viewMoreBtn fa fa-plus" onclick="showlinkBox('#linkBox_flight<?php echo ($quotationCruiseData['id']); ?>');">&nbsp;&nbsp;More</div>
									<div class="linkBox" id="linkBox_flight<?php echo ($quotationCruiseData['id']); ?>" style="display: none;">
										<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=editQuotationCruiseRate&amp;cruiseQuoteId=<?php echo ($quotationCruiseData['id']);?>','800px');"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</div>
										<div class="dltBtn links" onclick="if(confirm('Are you sure you want delete this Cruise?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationCruiseData['id']; ?>','deleteCruiseQuotation');"  style="color: red;"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</div>
										<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=addCruiseTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&cruiseQuoteId=<?php echo $quotationCruiseData['id'];?>','800px');"><i class="fa fa-cutlery" aria-hidden="true"></i>&nbsp;Timing</div>
									</div>
								</td>
								

							</tr>
							<?php if($cruiseData['otherDetail']!=''){ ?> 
							<tr><td colspan="8"><strong>Cruise Tour Details:-&nbsp;</strong><br><?php echo nl2br($cruiseData['otherDetail']); ?></td></tr>
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

	if($sorting['serviceType'] == 'activity'){
		$n=1;
		$where1=' queryId="'.$quotationData['queryId'].'"   and quotationId="'.$quotationId.'"  and id="'.$sorting['serviceId'].'"';
		$rs1=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where1);
		if(mysqli_num_rows($rs1)>0){
			$quotationActivityData=mysqli_fetch_array($rs1);
			$otherActivitySql=GetPageRecord('*','packageBuilderotherActivityMaster',' id ="'.$quotationActivityData['otherActivityName'].'" ');
			$ActivityData=mysqli_fetch_array($otherActivitySql);

			$rs44='';
		    $rs44=GetPageRecord('*','imageGallery',' parentId = "'.$ActivityData['id'].'" and galleryType="activity" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" )  order by id desc');
		    $resListing44=mysqli_fetch_array($rs44);

			$transferType = $quotationActivityData['transferType'];
			$noOfVehicles = $quotationActivityData['noOfVehicles'];

			if($quotationActivityData['transferType']!=2 && $quotationActivityData['transferType']!=3){
				$markupCostAct = $quotationActivityData['markupCost'];
				$markupTypeAct = $quotationActivityData['markupType'];
			}
			?>
			<tr>
			<td>
			<div style="padding:5px;border:1px solid #ddd;margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;">
			<div class="editButton" style="width:30px;     height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
			<input name="serviceids[]" type="hidden"  value="<?php echo $sorting['id']; ?>">
			<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
			<thead>
			<tr>
				<!-- <th align="left" bgcolor="#ddd">SightSeeing&nbsp;Image </th> -->
				<th align="left" bgcolor="#ddd">SightSeeing&nbsp;Name</th>
				<?php if($calculationType != 3){ ?>
					<th align="left" bgcolor="#ddd">Ticket&nbsp;Adult</th>
					<th align="left" bgcolor="#ddd">Ticket&nbsp;Child</th>
					<th align="left" bgcolor="#ddd">Ticket&nbsp;Infant</th>
					<?php if($transferType ==1){ ?>
					<th align="left" bgcolor="#ddd">Transfer&nbsp;Adult</th>
					<th align="left" bgcolor="#ddd">Transfer&nbsp;Child</th>
					<th align="left" bgcolor="#ddd">Transfer&nbsp;Infant</th>
					<?php }elseif($transferType ==2 || $transferType ==3){ ?>
					<th align="left" bgcolor="#ddd">vehicle&nbsp;Type</th>
					<th align="left" bgcolor="#ddd">Vehicle&nbsp;Cost</th>
					<th align="left" bgcolor="#ddd">No.&nbsp;Of&nbsp;Vehicle</th>
					<th align="left" bgcolor="#ddd">total&nbsp;Cost</th>
					<?php } if($transferType!=4){ ?>
					<th align="left" bgcolor="#ddd">Rep.&nbsp;Cost</th>
					<?php } ?>
					<th align="left" bgcolor="#ddd">Start\End&nbsp;Time</th>
					<th align="left" bgcolor="#ddd">Action</th>
					<?php } ?>
				</tr>
				</thead>
				<tbody>
				<tr>
				<!-- <td align="left">
				<?php if($resListing44['fileId']!=''){?>
					<img src="<?php echo geDocFileSrc($resListing44['fileId']); ?>" width="100" height="50" />
				<?php }else{ ?>
					<img src="<?php echo $fullurl.'images/transferthumbpackage.png'; ?>" width="100" height="50"/>
				<?php } ?>
				</td> -->
				<td align="left"><?php echo strip($ActivityData['otherActivityName']).'('; if($transferType==1){ echo 'SIC'; }elseif($transferType==2){ echo 'PVT'; }if($transferType==3){ echo 'VIP'; } echo ')'; ?></td>
				<input id="ActtransferTypeInput<?php echo ($quotationActivityData['id']); ?>" type="hidden"  value="<?php echo $transferType; ?>">
				<?php if($calculationType != 3){ ?>

					<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationActivityData['ticketAdultCost'],$quotationActivityData['gstTax'],$markupCostAct,$markupTypeAct); ?></td>
					<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationActivityData['ticketchildCost'],$quotationActivityData['gstTax'],$markupCostAct,$markupTypeAct); ?></td>
					<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationActivityData['ticketinfantCost'],$quotationActivityData['gstTax'],$markupCostAct,$markupTypeAct); ?></td>
					
					<?php if($transferType ==1){ ?>
					<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationActivityData['adultCost'],$quotationActivityData['gstTax'],$markupCostAct,$markupTypeAct); ?></td>
					<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationActivityData['childCost'],$quotationActivityData['gstTax'],$markupCostAct,$markupTypeAct); ?></td>
					<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationActivityData['infantCost'],$quotationActivityData['gstTax'],$markupCostAct,$markupTypeAct); ?></td>
					<?php }elseif($transferType ==2 || $transferType ==3){ ?>
					<td align="left"><?php
						$vehicleIdQuery1='';
						$vehicleIdQuery1=GetPageRecord('name,capacity','vehicleTypeMaster','id="'.$quotationActivityData['vehicleId'].'"');
						$vehicleIdD1=mysqli_fetch_array($vehicleIdQuery1);
						echo ucfirst($vehicleIdD1['name']) . "( " . ucfirst($vehicleIdD1['capacity']).')'; ?>
					</td>
					<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationActivityData['vehicleCost'],$quotationActivityData['gstTax'],$quotationActivityData['markupCost'],$quotationActivityData['markupType']); ?></td>
					<td><?php echo $noOfVehicles; ?></td>
					<td align="left"><?php echo $cur.' '.(getCostWithGSTID_Markup($quotationActivityData['vehicleCost'],$quotationActivityData['gstTax'],$quotationActivityData['markupCost'],$quotationActivityData['markupType'])*$noOfVehicles); ?></td>

					<?php } if($transferType!=4){?>
					<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationActivityData['repCost'],$quotationActivityData['gstTax'],$quotationActivityData['markupCost'],$quotationActivityData['markupType']); ?></td>
					<?php } } ?>
				<td align="left"> 
					<?php
					$c="";
					$c=GetPageRecord('*','quotationActivityTimelineDetails',' hotelQuoteId="'.$quotationActivityData['id'].'" and quotationId="'.$quotationActivityData['quotationId'].'"');
					if(mysqli_num_rows($c)>0){
						$activityTimLData=mysqli_fetch_array($c);
						echo ''.$startTime = date('H:i:s', strtotime($activityTimLData['startTime']));
						echo "/";
						echo $endTime = date('H:i:s', strtotime($activityTimLData['endTime']));
					}
				?></td> 
				<td width="80" align="left">
					<div class="viewMoreBtn fa fa-plus" onclick="showlinkBox('#linkBox_activity<?php echo ($sorting['id']); ?>');">&nbsp;&nbsp;More</div>
					<div class="linkBox" id="linkBox_activity<?php echo ($sorting['id']); ?>" style="display: none;">
						<div class="dltBtn links" onclick="if(confirm('Are you sure you want delete this Activity?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationActivityData['id']; ?>','deleteActivityQuotation');"  style="color: red;"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</div>
						<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=editQuotationActivityRate&amp;activityQuoteId=<?php echo ($quotationActivityData['id']);?>','600px');"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</div>
						<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=addActivityTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&activityQuoteId=<?php echo $quotationActivityData['id'];?>','600px');"><i class="fa fa-cutlery" aria-hidden="true"></i>&nbsp;Timing</div>
					</div>
				</td> 
			</tr>

			<?php if(strlen(trim($quotationActivityData['remark']))>2){ ?>
			<tr><td colspan="10">	 
				<div >
					Remarks: <?php echo $quotationActivityData['remark'];?>
				</div>
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
	if($sorting['serviceType'] == 'enroute'){
		$n=1;
		$rs1=GetPageRecord('*',_QUOTATION_ENROUTE_MASTER_,' queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'"and id="'.$sorting['serviceId'].'"  order by id asc');
		if(mysqli_num_rows($rs1)>0){
		while($quotationEnrouteData = mysqli_fetch_array($rs1)){
			$enrouteSql=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,' id="'.$quotationEnrouteData['enrouteId'].'" and status=1');
			$enrouteData=mysqli_fetch_array($enrouteSql);

			$rs44='';
		    $rs44=GetPageRecord('*','imageGallery',' parentId = "'.$ActivityData['id'].'" and galleryType="enroute" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" )  order by id desc');
		    $resListing44=mysqli_fetch_array($rs44);
			?>
			<tr>
			<td>
				<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;">
					<div class="editButton" style="width:30px;height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
					<input name="serviceids[]" type="hidden"  value="<?php echo $sorting['id']; ?>">
					<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
						<thead>
							<tr>
								<th align="left" bgcolor="#ddd" width="10%">Enroute&nbsp;Image </th>
								<th align="left" bgcolor="#ddd"width="10%">Enroute&nbsp;City</th>
								<th align="left" bgcolor="#ddd" width="60%">Enroute&nbsp;Name</th>
								<?php if($calculationType != 3){ ?>	
								<th align="left" bgcolor="#ddd">Per&nbsp;Pax&nbsp;Cost</th>
								<?php } ?>	
								<th align="left" bgcolor="#ddd">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td align="left">
								<?php if($resListing44['fileId']!=''){?>
									<img src="<?php echo geDocFileSrc($resListing44['fileId']); ?>" width="100" height="50" />
								<?php }else{ ?>
									<img src="<?php echo $fullurl.'images/transferthumbpackage.png'; ?>" width="100" height="50"/>
								<?php } ?>
								</td>
								<td align="left"><span class="style1">  <?php echo getDestination($quotationEnrouteData['destinationId']); ?></span></td>
								<td align="left"><span class="style1">  <?php echo ucfirst($enrouteData['enrouteName']); ?></span></td>
								<?php if($calculationType != 3){ ?>	
								<td align="left">
									<div id="adultCostText<?php echo ($quotationEnrouteData['id']); ?>"><?php echo  getCurrencyName($quotationEnrouteData['currencyId'])." ".strip($quotationEnrouteData['adultCost']); ?></div>
									<div id="adultCost<?php echo ($quotationEnrouteData['id']); ?>" style="display:none;">
										<input type="text" id="adultCostInput<?php echo ($quotationEnrouteData['id']); ?>"  value="<?php echo strip($quotationEnrouteData['adultCost']); ?>">
									</div>
								</td>
								<?php } ?>	
								<td align="right">
								<div class="deleteBtn" style="display: inline-flex;float: right;" onclick="if(confirm('Are you sure you want delete this enroute?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationEnrouteData['id']; ?>','deleteEnrouteQuotation');" ><i class="fa fa-trash" aria-hidden="true"></i></div>
								<div class="editBtn" id="editBtn<?php echo ($quotationEnrouteData['id']); ?>"  style="display: inline-flex;" onclick="editQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationEnrouteData['id'];?>','editEnrouteQuotation');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
								
								<div class="saveBtn" id="saveBtn<?php echo ($quotationEnrouteData['id']); ?>"  style="display: inline-flex;display:none;" onclick="saveQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationEnrouteData['id'];?>','saveEnrouteQuotation');"><i class="fa fa-save" aria-hidden="true"></i></div>							</td>
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

				if($transferType!=2){
					$markupCostEnt = $quotationEntranceData['markupCost'];
					$markupTypeEnt = $quotationEntranceData['markupType'];
				}
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
					<?php if($calculationType!= 3){ ?>
					<th align="left" bgcolor="#ddd">Ticket&nbsp;Adult</th>
					<th align="left" bgcolor="#ddd">Ticket&nbsp;Child</th>
					<th align="left" bgcolor="#ddd">Ticket&nbsp;Infant</th>
					<?php if($transferType ==1){ ?>
					<th align="left" bgcolor="#ddd">Transfer&nbsp;Adult</th>
					<th align="left" bgcolor="#ddd">Transfer&nbsp;Child</th>
					<th align="left" bgcolor="#ddd">Transfer&nbsp;Infant</th>
					<?php }elseif($transferType ==2){ ?>
					<th align="left" bgcolor="#ddd">vehicle&nbsp;Type</th>
					<th align="left" bgcolor="#ddd">Vehicle&nbsp;Cost</th>
					<th align="left" bgcolor="#ddd">Vehicles</th>
					<?php } if($transferType ==2 || $transferType ==1){?>
					<th align="left" bgcolor="#ddd">Rep.&nbsp;Cost</th>
					<?php } } ?>
					<!-- <th align="left" bgcolor="#ddd">Start/End&nbsp;Time</th> -->
					<th align="left" bgcolor="#ddd">&nbsp; </th>
					</tr>
					</thead>
					<tbody>
					<tr> 
						<td align="left"><?php echo clean($editresult2['entranceName']); ?> </td>
						<?php if($calculationType != 3){ ?>
						<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationEntranceData['ticketAdultCost'],$quotationEntranceData['gstTax'],$markupCostEnt,$markupTypeEnt); ?></td>
						<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationEntranceData['ticketchildCost'],$quotationEntranceData['gstTax'],$markupCostEnt,$markupTypeEnt); ?></td>
						<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationEntranceData['ticketinfantCost'],$quotationEntranceData['gstTax'],$markupCostEnt,$markupTypeEnt); ?></td>
						<?php if($transferType ==1){ ?>
						<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationEntranceData['adultCost'],$quotationEntranceData['gstTax'],$markupCostEnt,$markupTypeEnt); ?></td>
						<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationEntranceData['childCost'],$quotationEntranceData['gstTax'],$markupCostEnt,$markupTypeEnt); ?></td>
						<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationEntranceData['infantCost'],$quotationEntranceData['gstTax'],$markupCostEnt,$markupTypeEnt); ?></td>
						<?php }elseif($transferType ==2){ ?>
						<td align="left">
							<?php
							$vehicleIdQuery1='';
							$vehicleIdQuery1=GetPageRecord('name,capacity','vehicleTypeMaster','id="'.$quotationEntranceData['vehicleId'].'"');
							$vehicleIdD1=mysqli_fetch_array($vehicleIdQuery1);
							echo $vehicleIdD1['name']. "( " .$vehicleIdD1['capacity'].')';
							?>
						</td>

						<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationEntranceData['vehicleCost'],$quotationEntranceData['gstTax'],$quotationEntranceData['markupCost'],$quotationEntranceData['markupType']); ?></td>
						<td><?php echo $quotationEntranceData['noOfVehicles']; ?></td>
						<?php } if($transferType ==2 || $transferType ==1){ ?>
						<td align="left"><?php echo $cur.' '.getCostWithGSTID_Markup($quotationEntranceData['repCost'],$quotationEntranceData['gstTax'],$quotationEntranceData['markupCost'],$quotationEntranceData['markupType']); ?></td>
						<?php } } ?>
					 
						<td width="80" align="left">
							<div class="viewMoreBtn fa fa-plus" onclick="showlinkBox('#linkBox_entrance<?php echo ($sorting['id']); ?>');">&nbsp;&nbsp;More</div>
							<div class="linkBox" id="linkBox_entrance<?php echo ($sorting['id']); ?>" style="display: none;">
								<div class="dltBtn links" onclick="if(confirm('Are you sure you want delete this Monument?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationEntranceData['id']; ?>','deleteEntranceQuotation');"  style="color: red;"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</div>
								<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=editQuotationEntranceRate&amp;entranceQuoteId=<?php echo ($quotationEntranceData['id']);?>','600px');"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</div>

								<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=addEntranceTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&entranceQuoteId=<?php echo $quotationEntranceData['id'];?>','600px');"><i class="fa fa-cutlery" aria-hidden="true"></i>&nbsp;Timing</div>
							</div>
						</td>	 

					</tr>
					<?php
					$c="";
					$c=GetPageRecord('*','quotationEntranceTimelineDetails',' hotelQuoteId="'.$quotationEntranceData['id'].'" and quotationId="'.$quotationEntranceData['quotationId'].'" ');
					if(mysqli_num_rows($c)>0){
						$entranceTimLData=mysqli_fetch_array($c);
						if($entranceTimLData['startTime']!='' && $entranceTimLData['startTime']!='00:00:00'){
							$startTime = date('H:i:s', strtotime($entranceTimLData['startTime']));
						}else{
							$startTime = '';
						}
					
						if($entranceTimLData['endTime']!='' && $entranceTimLData['endTime']!='00:00:00'){
							$endTime = date('H:i:s', strtotime($entranceTimLData['endTime']));
						}else{
							$endTime = '';
						}

						if($entranceTimLData['pickupTime']!='' && $entranceTimLData['pickupTime']!='00:00:00'){
							$pickupTime = date('H:i:s', strtotime($entranceTimLData['pickupTime']));
						}else{
							$pickupTime = '';
						}

						if($entranceTimLData['dropTime']!='' && $entranceTimLData['dropTime']!='00:00:00'){
							$dropTime = date('H:i:s', strtotime($entranceTimLData['dropTime']));
						}else{
							$dropTime = '';
						}

						?>
					<tr>
						<td colspan="13">
							<table width="100%" border="1" bordercolor="#cc" cellpadding="0" cellspacing="0"> 
								<tr style="background:#ddd;">
									<th align="left">Date</th>
									<th align="left">Start&nbsp;Time</th>
									<th align="left">End&nbsp;Time</th>
									<th align="left">Pickup&nbsp;Time</th>
									<th align="left">Drop&nbsp;Time</th>
									<th align="left" colspan="2">pickup&nbsp;Address</th>
									<th align="left"  colspan="2">Drop&nbsp;Address</th>
								</tr>
								<tr>
									
									<td><?php echo date('d-m-Y',strtotime($entranceTimLData['departureDate'])); ?></td>
									<td><?php echo $startTime; ?></td>
									<td><?php echo $endTime; ?></td>
									<td><?php echo $pickupTime; ?></td>
									<td><?php echo $dropTime; ?></td>
									<td colspan="2"><?php echo $entranceTimLData['pickupAddress']; ?></td>
									<td colspan="2"><?php echo $entranceTimLData['dropAddress']; ?></td>
								</tr>
							</table>
						</td>
					</tr>
					<?php } ?>

					<?php if($quotationEntranceData['detail']!='' && strlen(trim($quotationEntranceData['detail']))>2){  ?>
					<tr>
						<td colspan="13">	
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
		$n=1;
		$where1=' queryId="'.$quotationData['queryId'].'"   and quotationId="'.$quotationId.'"  and id="'.$sorting['serviceId'].'"';
		$rs1=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where1);
		if(mysqli_num_rows($rs1)>0){
			while($quotationRestaurantData=mysqli_fetch_array($rs1)){

				$where2=' id="'.$quotationRestaurantData['mealPlanId'].'" order by id asc';
				$rs2=GetPageRecord('*','inboundmealplanmaster',$where2);
				$mealplanData=mysqli_fetch_array($rs2);

				$resrestmeal = GetPageRecord('*','restaurantsMealPlanMaster','id="'.$quotationRestaurantData['mealType'].'"');
				$resmealres = mysqli_fetch_assoc($resrestmeal);
				?>
				<tr>
				<td>
				<div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;"><div class="editButton" style="width:30px;     height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
				<input name="serviceids[]" type="hidden"  value="<?php echo $sorting['id']; ?>">
				<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
				<thead>
					<tr>
						<!-- <th align="left" bgcolor="#ddd">Restaurant Image</th> -->
						<th align="left" bgcolor="#ddd">Restaurant</th>
						<th align="left" bgcolor="#ddd">Meal&nbsp;Type</th>
						<?php if($calculationType != 3){ ?>
						<th align="left" bgcolor="#ddd">Adult&nbsp;Cost</th>
						<th align="left" bgcolor="#ddd">Child&nbsp;Cost</th>
						<th align="left" bgcolor="#ddd">Infant&nbsp;Cost</th>
						<?php } ?>
						<th align="left" bgcolor="#ddd">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<!-- <td align="left">
						<?php if($mealplanData['mealPlanImage']!=''){ ?>
						<img src="packageimages/<?php echo str_replace(' ','%20',strip($mealplanData['mealPlanImage']));  ?>" width="100" height="50" />
						<?php  }else{ ?>
						<img src="images/transferthumbpackage.png" width="100" height="50" />
						<?php } ?>							
						</td> -->
						<td align="left"><span class="style1">  <?php echo strip($quotationRestaurantData['mealPlanName']); ?></span></td>
						<td align="left"><?php echo $resmealres['name']; ?></td>
						<?php if($calculationType != 3){ ?>
						<td align="left"><?php echo getCurrencyName($quotationRestaurantData['currencyId']).' '.getCostWithGSTID_Markup($quotationRestaurantData['adultCost'],$quotationRestaurantData['gstTax'],$quotationRestaurantData['markupCost'],$quotationRestaurantData['markupType']); ?></td>
						<td align="left"><?php echo getCurrencyName($quotationRestaurantData['currencyId']).' '.getCostWithGSTID_Markup($quotationRestaurantData['childCost'],$quotationRestaurantData['gstTax'],$quotationRestaurantData['markupCost'],$quotationRestaurantData['markupType']); ?></td>
						<td align="left"><?php echo getCurrencyName($quotationRestaurantData['currencyId']).' '.getCostWithGSTID_Markup($quotationRestaurantData['infantCost'],$quotationRestaurantData['gstTax'],$quotationRestaurantData['markupCost'],$quotationRestaurantData['markupType']); ?></td>
						<?php } ?>
						<td width="80" align="left">
							<div class="viewMoreBtn fa fa-plus" onclick="showlinkBox('#linkBox_restaurant<?php echo ($sorting['id']); ?>');">&nbsp;&nbsp;More</div>
							<div class="linkBox" id="linkBox_restaurant<?php echo ($sorting['id']); ?>" style="display: none;">

								<div class="dltBtn links" onclick="if(confirm('Are you sure you want delete this Restaurant?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationRestaurantData['id']; ?>','deleteMealPlanQuotation');"  style="color: red;"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</div>

								<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=editQuotationRestaurantRate&amp;restaurantQuoteId=<?php echo ($quotationRestaurantData['id']);?>','600px');"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</div>

								<div class="adBtn links" title="Room&nbsp;Supplement" id="saveBtn<?php echo ($qhData['id']); ?>" style="color: #006699;" onClick="openinboundpop('action=addServiceMealPlan&stype=restaurtantSupplement&dayId=<?php echo $QueryDaysData['id']; ?>&restaurantQuoteId=<?php echo $quotationRestaurantData['id'];?>','1300px');"><i class="fa fa-hotel" aria-hidden="true"></i>&nbsp;Supplement</div>
							</div>
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
	if($sorting['serviceType'] == 'flight'){
		$n=1;
		$where1=' queryId="'.$quotationData['queryId'].'"  and quotationId="'.$quotationId.'" and id="'.$sorting['serviceId'].'" and dayId>0 and isFlightTaken!="yes"order by id asc';
		$rs1=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where1);
		if(mysqli_num_rows($rs1)>0){
		?>
		<tr><td><div style="padding:5px; border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;" ><div class="editButton" style="width:30px;height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>
		<input name="serviceids[]" type="hidden" value="<?php echo $sorting['id']; ?>">

		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="trains tablesorter gridtable">
		<?php
		while($dmcFlightD=mysqli_fetch_array($rs1)){

			$flightTypeLable ="";
			if($dmcFlightD['isLocalEscort']==1){
		        $flightTypeLable .= "Local,";
		    }
		    if($dmcFlightD['isForeignEscort']==1){
		        $flightTypeLable .= "Foreign,";
		    }
		    if($dmcFlightD['isGuestType']==1){
		        $flightTypeLable .= "Guest,";
		    }

			$aF = GetPageRecord('*','flightTimeLineMaster','quotationId="'.$dmcFlightD['quotationId'].'" and flightQuoteId="'.$dmcFlightD['id'].'" and flightId="'.$dmcFlightD['flightId'].'" and dayId="'.$QueryDaysData['id'].'"');
			$timeData = mysqli_fetch_assoc($aF);
			$via = $timeData['via'];

		    if($n == 1){
			    ?>
				<thead>
				<tr> 
				<th width="16%" align="left" bgcolor="#ddd">Flight&nbsp;Name(<?php echo rtrim($flightTypeLable,',');?>)</th>
				<th width="13%" align="left" bgcolor="#ddd">Flight&nbsp;Number</th>
				<th width="11%" align="left" bgcolor="#ddd">Flight&nbsp;Class</th>
				<th align="left" bgcolor="#ddd" style="min-width: 150px;text-align: center;">Departure-Arrival</th>
				<th width="16%" align="left" bgcolor="#ddd">Departure<br>Date/Time</th>
				<th width="16%" align="left" bgcolor="#ddd">Arrival<br>Date/Time</th>
				<?php if($calculationType != 3){ ?>	
				<th width="13%" align="left" bgcolor="#ddd">Adult&nbsp;Cost</th>
				<th width="13%" align="left" bgcolor="#ddd">Child&nbsp;Cost</th>
				<th width="13%" align="left" bgcolor="#ddd">Infant&nbsp;Cost</th>
				<?php } ?>       
				
				<th width="6%" align="left" bgcolor="#ddd">&nbsp;&nbsp;&nbsp;</th>
				</tr>
				</thead>
				<tbody>
			    <?php
		    }
			?>
			<tr> 
				<td align="left"><?php
					$rs5=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$dmcFlightD['flightId'].'"');
					$GuideData5=mysqli_fetch_array($rs5);
					echo strip($GuideData5['flightName']);
					?></td>
				<td align="left"><?php echo strip($dmcFlightD['flightNumber']); ?></td>
				<td align="left"><?php echo $dmcFlightD['flightClass']; ?></td>
				<td align="left">
					<div >
						<?php echo getDestination($dmcFlightD['departureFrom']); ?> - 
						<?php echo getDestination($dmcFlightD['arrivalTo']); ?> 
					</div> 
				</td> 
				<td align="left"> 
					<?php 
					if($timeData['flightId']!='' && $timeData['quotationId']!='' && $timeData['flightQuoteId']!=''){ echo date('d-m-Y',strtotime($timeData['departureDate'])).'<br>'.date('H:i:s',strtotime($timeData['departureTime'])); 
					} ?>				
				</td>
				<td align="left">
					<?php if($timeData['flightId']!='' && $timeData['quotationId']!='' && $timeData['flightQuoteId']!=''){
						echo date('d-m-Y',strtotime($timeData['arrivalDate'])).'<br>'.date('H:i:s',strtotime($timeData['arrivalTime'])); 
					} ?>				
				</td>
				<?php if($calculationType!= 3){ ?>	
				<td align="left"><?php echo $curr.' '.getCostWithGSTID_Markup($dmcFlightD['adultCost'],$dmcFlightD['gstTax'],$dmcFlightD['markupCost'],$dmcFlightD['markupType']); ?></td>
				<td align="left"><?php echo $curr.' '.getCostWithGSTID_Markup($dmcFlightD['childCost'],$dmcFlightD['gstTax'],$dmcFlightD['markupCost'],$dmcFlightD['markupType']); ?></td>
				<td align="left"><?php echo $curr.' '.getCostWithGSTID_Markup($dmcFlightD['infantCost'],$dmcFlightD['gstTax'],$dmcFlightD['markupCost'],$dmcFlightD['markupType']); ?></td>
				<?php } ?>
				


				<td width="80" align="left">
					<div class="viewMoreBtn fa fa-plus" onclick="showlinkBox('#linkBox_flight<?php echo ($sorting['id']); ?>');">&nbsp;&nbsp;More</div>
					<div class="linkBox" id="linkBox_flight<?php echo ($sorting['id']); ?>" style="display: none;">
						<div class="dltBtn links" onclick="if(confirm('Are you sure you want delete this Flight?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $dmcFlightD['id']; ?>','deleteFlightQuotation');"  style="color: red;"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</div>
						<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=editQuotationFlightRate&amp;flightQuoteId=<?php echo ($dmcFlightD['id']);?>','700px');"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</div>
						<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=addFlightTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&flightQuoteId=<?php echo $dmcFlightD['id'];?>&flightId=<?php echo $dmcFlightD['flightId'];?>','800px');"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;Timing</div>
					</div>
				</td> 

			</tr>
			<?php  
			$n++; 
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
		$n=1;
		$where1=' queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'" and id="'.$sorting['serviceId'].'" order by id asc';
		$rs1=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where1);
			if(mysqli_num_rows($rs1)>0){
			?>
			<tr>
				<td>
				<div style="padding:5px;border:1px solid #ddd; margin-bottom:10px;padding-right:40px; position:relative; background-color:#FFFFFF;">
					<div class="editButton" style="width:30px;height: 100%; position:absolute; right:0px; top:0px; background-color:#006699; cursor:pointer;"></div>

					<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="trains tablesorter gridtable">
					<?php
					while($dmcTrainD=mysqli_fetch_array($rs1)){
						$trainTypeLable ="";
						if($dmcTrainD['isLocalEscort']==1){
					        $trainTypeLable .= "Local,";
					    }
					    if($dmcTrainD['isForeignEscort']==1){
					        $trainTypeLable .= "Foreign,";
					    }
					    if($dmcTrainD['isGuestType']==1){
					        $trainTypeLable .= "Guest,";
					    }

					    $curr = getCurrencyName($dmcTrainD['currencyId']);

						$aT = GetPageRecord('*','trainTimeLineMaster','quotationId="'.$dmcTrainD['quotationId'].'" and trainQuoteId="'.$dmcTrainD['id'].'" and trainId="'.$dmcTrainD['trainId'].'" and dayId="'.$QueryDaysData['id'].'"');
						$timeData = mysqli_fetch_assoc($aT);
					    if($n == 1){
						    ?>
							<thead>
							<tr>
							<th width="16%" align="left" bgcolor="#ddd">Train&nbsp;Name(<?php echo rtrim($trainTypeLable,',');?>)</th>
							<th width="16%" align="left" bgcolor="#ddd">Journey&nbsp;Type</th>
							<th width="13%" align="left" bgcolor="#ddd">Train&nbsp;Number</th>
							<th width="11%" align="left" bgcolor="#ddd">Train&nbsp;Class</th>
							<th width="18%" align="left" bgcolor="#ddd">Departure-Arrival</th>
							<th width="16%" align="left" bgcolor="#ddd">Departure<br>Date/Time</th>
							<th width="16%" align="left" bgcolor="#ddd">Arrival<br>Date/Time</th>
							<?php if($calculationType != 3){ ?>	
							<th width="13%" align="left" bgcolor="#ddd">Adult&nbsp;Cost</th>
							<th width="13%" align="left" bgcolor="#ddd">Child&nbsp;Cost</th>
							<th width="13%" align="left" bgcolor="#ddd">Infant&nbsp;Cost</th>
							<?php } ?>
							
							<th width="6%" align="left" bgcolor="#ddd">&nbsp;&nbsp;&nbsp;</th>
							</tr>
							</thead>
							<tbody>
						    <?php
					    }
					?>
					<tr>
						<td align="left"><?php
							$rs5=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$dmcTrainD['trainId'].'"');
							$GuideData5=mysqli_fetch_array($rs5);
							echo ucfirst($GuideData5['trainName']);
							?>
						</td>
						<td align="left"><?php if($dmcTrainD['journeyType'] == 'overnight_journey'){ echo "Overnight"; }else{ echo "Day Journey"; } ?></td>
						<td align="left"><?php echo strip($dmcTrainD['trainNumber']); ?></td>
						<td align="left"><?php echo $dmcTrainD['trainClass']; ?></td>
						<td align="left">
							<div >
								<?php echo getDestination($dmcTrainD['departureFrom']); ?> To 
								<?php echo getDestination($dmcTrainD['arrivalTo']); ?> 
							</div> 
						</td> 
						<td align="left"> 
							<?php 
							if($timeData['trainId']!='' && $timeData['quotationId']!='' && $timeData['trainQuoteId']!=''){ echo date('d-m-Y',strtotime($timeData['departureDate'])).'<br>'.date('H:i:s',strtotime($timeData['departureTime'])); 
							} ?>				
						</td>

						<td align="left">
							<?php if($timeData['trainId']!='' && $timeData['quotationId']!='' && $timeData['trainQuoteId']!=''){
								echo date('d-m-Y',strtotime($timeData['arrivalDate'])).'<br>'.date('H:i:s',strtotime($timeData['arrivalTime'])); 
							} ?>				
						</td>
						<?php if($calculationType!= 3){ ?>	
						<td align="left"><?php echo $curr.' '.getCostWithGSTID_Markup($dmcTrainD['adultCost'],$dmcTrainD['gstTax'],$dmcTrainD['markupCost'],$dmcTrainD['markupType']); ?></td>
						<td align="left"><?php echo $curr.' '.getCostWithGSTID_Markup($dmcTrainD['childCost'],$dmcTrainD['gstTax'],$dmcTrainD['markupCost'],$dmcTrainD['markupType']); ?></td>
						<td align="left"><?php echo $curr.' '.getCostWithGSTID_Markup($dmcTrainD['infantCost'],$dmcTrainD['gstTax'],$dmcTrainD['markupCost'],$dmcTrainD['markupType']); ?></td>
						<?php } ?>
						
						 
						<td width="80" align="left">
							<div class="viewMoreBtn fa fa-plus" onclick="showlinkBox('#linkBox_train<?php echo ($sorting['id']); ?>');">&nbsp;&nbsp;More</div>
							<div class="linkBox" id="linkBox_train<?php echo ($sorting['id']); ?>" style="display: none;">
							
								<div class="dltBtn links" onclick="if(confirm('Are you sure you want delete this Train?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $dmcTrainD['id']; ?>','deleteTrainQuotation');"  style="color: red;"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</div>
								<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=addTrainTimeDetails&dayId=<?php echo $QueryDaysData['id']; ?>&trainQuoteId=<?php echo $dmcTrainD['id'];?>&trainId=<?php echo $dmcTrainD['trainId']; ?>','800px');"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;Timing</div>

								<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=editQuotationTrainRate&amp;trainQuoteId=<?php echo ($dmcTrainD['id']);?>','700px');"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</div>
							</div>
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
		$n=1;
		$where1=' queryId="'.$quotationData['queryId'].'"   and quotationId="'.$quotationId.'"  and id="'.$sorting['serviceId'].'" ';
		$rs1=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$where1);
		if(mysqli_num_rows($rs1)>0){
		$quotationExtraData2=mysqli_fetch_array($rs1);

		$rs1=GetPageRecord('*','extraQuotation','id="'.$quotationExtraData2['additionalId'].'"');
		$extraData=mysqli_fetch_array($rs1);
		$rs2=GetPageRecord('name','queryCurrencyMaster','id="'.$extraData['currencyId'].'"');
		$currencyData=mysqli_fetch_array($rs2);

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
					<?php if($calculationType != 3){ ?>	
					<?php if($quotationExtraData2['costType']==1){ ?>
					<th align="left" bgcolor="#ddd">Adult&nbsp;Cost</th>
					<th align="left" bgcolor="#ddd">Child&nbsp;Cost</th>
					<th align="left" bgcolor="#ddd">Infant&nbsp;Cost</th>
					<?php } if($quotationExtraData2['costType']==2){ ?>
					<th align="left" bgcolor="#ddd">Group&nbsp;Cost</th>
					<?php } ?>	
					<?php } ?>
					<th align="left" bgcolor="#ddd">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td align="left"><span class="style"> <?php echo clean($quotationExtraData2['name']); ?></span></td>
					<?php if($calculationType != 3){ ?>	
						<?php if($quotationExtraData2['costType']==1){ ?>
							<td align="left"><?php echo getCurrencyName($quotationExtraData2['currencyId']).' '.getCostWithGSTID_Markup($quotationExtraData2['adultCost'],$quotationExtraData2['gstTax'],$quotationExtraData2['markupCost'],$quotationExtraData2['markupType']); ?></td>
							<td align="left"><?php echo getCurrencyName($quotationExtraData2['currencyId']).' '.getCostWithGSTID_Markup($quotationExtraData2['childCost'],$quotationExtraData2['gstTax'],$quotationExtraData2['markupCost'],$quotationExtraData2['markupType']); ?></td>
							<td align="left"><?php echo getCurrencyName($quotationExtraData2['currencyId']).' '.getCostWithGSTID_Markup($quotationExtraData2['infantCost'],$quotationExtraData2['gstTax'],$quotationExtraData2['markupCost'],$quotationExtraData2['markupType']); ?></td>
						<?php } if($quotationExtraData2['costType']==2){ ?>
							<td align="left"><?php echo getCurrencyName($quotationExtraData2['currencyId']).' '.getCostWithGSTID_Markup($quotationExtraData2['groupCost'],$quotationExtraData2['gstTax'],$quotationExtraData2['markupCost'],$quotationExtraData2['markupType']); ?></td>
						<?php } ?>	
					<?php } ?>
					<td width="80" align="left">
						<div class="viewMoreBtn fa fa-plus" onclick="showlinkBox('#linkBox_additional<?php echo ($sorting['id']); ?>');">&nbsp;&nbsp;More</div>
						<div class="linkBox" id="linkBox_additional<?php echo ($sorting['id']); ?>" style="display: none;">
							<div class="dltBtn links" onclick="if(confirm('Are you sure you want delete this Additional?')) deleteQuotationService<?php echo ($QueryDaysData['id']);?>('<?php echo $quotationExtraData2['id']; ?>','deleteAdditionalQuotation');"  style="color: red;"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</div>
							<div class="edtBtn links" style="color: #006699;" onclick="openinboundpop('action=editQuotationAdditionalRate&amp;additionalQuoteId=<?php echo ($quotationExtraData2['id']);?>','600px');"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</div>
						</div>
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
?>
</tbody>
</table>

<script type="text/javascript">

	function deleteQuotationService<?php echo ($QueryDaysData['id']);?>(serviceId,action){
		$('#hoteldivHiddens<?php echo ($QueryDaysData['id']);?>').load('inboundpop.php?action='+action+'&quotationId=<?php echo $quotationId;?>&serviceId='+serviceId);
	}

	function editQuotationService<?php echo ($QueryDaysData['id']);?>(serviceId,action){

		if(action=="editQuotationRoomSupplement"){
			//mealPlan roomType
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppsingleoccupancyText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppdoubleoccupancyText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SupptwinoccupancyText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppchildwithbedText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppchildwithoutbedText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppextraBedText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppbreakfastText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppcomplimentaryLunchText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppcomplimentaryDinnerText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppmealPlanText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SupproomTypeText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppeditBtn'+serviceId).hide();

			$('#tbbody<?php echo ($QueryDaysData['id']);?> #Suppsingleoccupancy'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #Suppdoubleoccupancy'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #Supptwinoccupancy'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #Suppchildwithbed'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #Suppchildwithoutbed'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppextraBed'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #Suppbreakfast'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppcomplimentaryLunch'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppcomplimentaryDinner'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppmealPlan'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SupproomType'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #SuppsaveBtn'+serviceId).show();
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

		if(action=="editQuotationTransport"){
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #transferNameIdText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleTypeText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleModelIdText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleCostText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #editBtn'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #noOfVehiclesText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #paxSlabText'+serviceId).hide();

			$('#tbbody<?php echo ($QueryDaysData['id']);?> #transferNameId'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleType'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleModelId'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleCost'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #noOfVehicles'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #paxSlab'+serviceId).show();
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
	 
		if( action=="editEnrouteQuotation" ){
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCostText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #childCostText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #groupCostText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #editBtn'+serviceId).hide();

			$('#tbbody<?php echo ($QueryDaysData['id']);?> #adultCost'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #childCost'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #groupCost'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #saveBtn'+serviceId).show();
		}

		if(action=="editItineraryQuotation"){
			
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #iti_subjectText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #iti_descriptionText'+serviceId).hide();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #editBtn'+serviceId).hide();

			$('#tbbody<?php echo ($QueryDaysData['id']);?> #iti_subject'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #iti_description'+serviceId).show();
			$('#tbbody<?php echo ($QueryDaysData['id']);?> #saveBtn'+serviceId).show();
		}
		
	}

	// save service data
	function saveQuotationService<?php echo ($QueryDaysData['id']);?>(serviceId,action){
	 
		if(action=="saveQuotationTransfer"){

			var transferNameId = $('#tbbody<?php echo ($QueryDaysData['id']);?> #transferNameIdInput'+serviceId).val();

			var transferType = $('#tbbody<?php echo ($QueryDaysData['id']);?> #transferTypeInput'+serviceId).val();
			var adultCost = 0; var childCost = 0; var infantCost = 0; var vehicleModelId = 0; var vehicleType = 0; var vehicleCost = 0; var noOfVehicles = 0;
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

		if(action=="saveQuotationTransport"){

			var transferNameId = $('#tbbody<?php echo ($QueryDaysData['id']);?> #transferNameIdInput'+serviceId).val();
			var vehicleType = $('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleTypeInput'+serviceId).val();
			var vehicleModelId = $('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleModelIdInput'+serviceId).val();
			var vehicleCost = $('#tbbody<?php echo ($QueryDaysData['id']);?> #vehicleCostInput'+serviceId).val();
			var distance = $('#tbbody<?php echo ($QueryDaysData['id']);?> #distanceInput'+serviceId).val();
			var noOfVehicles = $('#tbbody<?php echo ($QueryDaysData['id']);?> #noOfVehiclesInput'+serviceId).val();
			var paxSlab = $('#tbbody<?php echo ($QueryDaysData['id']);?> #paxSlabInput'+serviceId).val();
			//alert(vehicleModelId);
			$('#hoteldivHiddens<?php echo ($QueryDaysData['id']);?>').load('inboundpop.php?action='+encodeURI(action)+'&transferNameId='+encodeURI(transferNameId)+'&vehicleModelId='+encodeURI(vehicleModelId)+'&noOfVehicles='+encodeURI(noOfVehicles)+'&paxSlab='+encodeURI(paxSlab)+'&vehicleType='+encodeURI(vehicleType)+'&vehicleCost='+encodeURI(vehicleCost)+'&distance='+encodeURI(distance)+'&serviceId='+encodeURI(serviceId));
		}
		 
		if( action=="saveEnrouteQuotation" ){
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

		if(action=="saveItineraryQuotation"){
			
			var iti_subjectInput = $('#tbbody<?php echo ($QueryDaysData['id']);?> #iti_subjectInput'+serviceId).val();
			var iti_descriptionInput = $('#tbbody<?php echo ($QueryDaysData['id']);?> #iti_descriptionInput'+serviceId).val();
			
			$('#hoteldivHiddens<?php echo ($QueryDaysData['id']);?>').load('inboundpop.php?action='+encodeURI(action)+'&subjectTitle='+encodeURIComponent(iti_subjectInput)+'&description='+encodeURIComponent(iti_descriptionInput)+'&serviceId='+encodeURI(serviceId));
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
			padding: 5px 10px;
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
		    width: 160px;
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
<div id="hoteldivHiddens<?php echo ($QueryDaysData['id']);?>"  ></div>
<?php $day++; $dateno++;
}
?>
</div>
<input type="hidden" id="isErrorInfo" value="<?php echo $isErrorInfo; ?>" style="position: absolute;bottom: -1000px;">
<?php if($isErrorInfo==1){ ?>
<script type="text/javascript">
function errorInfo() {
	parent.query_alertbox('action=quotationInfo&quotationId=<?php echo encode($quotationId); ?>','500px','auto');
	setTimeout( function(){
		parent.$('#quotationInfoBox').html("<?php echo addslashes($hotelCheckRooms); ?>");
	}  , 1000 );
	// parent.$('#pageloading').hide();
	// parent.$('#pageloader').hide(); 
}
</script> 
<?php } ?>