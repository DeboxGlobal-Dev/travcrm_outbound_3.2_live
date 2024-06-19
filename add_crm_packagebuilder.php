<?php

if($addpermission!=1 && $_REQUEST['id']==''){

	header('location:'.$fullurl.'');

}

if($editpermission!=1 && $_REQUEST['id']!=''){

	header('location:'.$fullurl.'');

}

if($_REQUEST['id']==''){
	//add package
	$wheredel='addedBy='.trim($_SESSION['userid']).' and deletestatus=1'; 
	$dateAdded=time();
	$namevalue ='deletestatus=1,moduleType=4,addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';
	$lastqueryidmain= addlistinggetlastid(_QUERY_MASTER_,$namevalue);

}

/*--------------------------------------------------------LEAD SECTION START------------------------------------------------------------*/

$filecode=decode($_REQUEST['leadId']); 
$filecode=trim($filecode); 
$multiemails=trim(decode($_REQUEST['salesEmail']));

if($filecode!='' && $filecode>0){

	$select1='*';

	$where1='id='.$filecode.' ';

	$rs1=GetPageRecord($select1,_SALES_QUERY_MASTER_,$where1);

	$resultlists=mysqli_fetch_array($rs1);

	$clientType = $resultlists['clientType'];

	$editcompanyId=trim($resultlists['companyId']);

	$destinationId=trim($resultlists['destinationId']);

	$leadsource=$resultlists['leadsource'];

	$fromDate=date('d-m-Y');

	$toDate=date('d-m-Y');

	$editnight=1;

	$editsubject=$resultlists['subject'];

	$expectedSales=clean($resultlists['expectedSales']);

	$closerDate=showdate(($resultlists['closerDate']));

	$campaign=$resultlists['campaign'];

}

 /*--------------------------------------------------------LEAD SECTION END------------------------------------------------------------*/

if($_REQUEST['id']!=''){

	$id=clean(decode($_REQUEST['id']));

	$select1='*';

	$where1='id='.$id.'';

	$rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1);

	$editresult=mysqli_fetch_array($rs1);
 
	 $editassignToMain=clean($editresult['assignTo']);

	$editcompanyId=clean($editresult['companyId']);

	$edittravelDate=clean($editresult['travelDate']);

	if($editresult['fromDate']!='1970-01-01' && $editresult['fromDate'] != '0000-00-00' ){
		$editfromDate = clean($editresult['fromDate']);
	}else{
		$rs11=GetPageRecord('*','packageQueryDays','queryId="'.$id.'" order by srdate asc');
		$packageQueryData1=mysqli_fetch_array($rs11);
		$editfromDate = clean($packageQueryData1['srdate']);
	}

	if($editresult['toDate']!='1970-01-01' && $editresult['toDate'] != '0000-00-00' ){
		$edittoDate = clean($editresult['toDate']);
	}else{
		$rs12=GetPageRecord('*','packageQueryDays','queryId="'.$id.'" order by srdate desc');
		$packageQueryData1=mysqli_fetch_array($rs12);
		$edittoDate = clean($packageQueryData1['srdate']);
	}

	$objec=date_diff(date_create($editfromDate),date_create($edittoDate));
	$editnight = $objec->format("%a");

 	$editofficeBranch=clean($editresult['officeBranch']);

	$destinationId=clean($editresult['destinationId']);

	$dayWise=clean($editresult['dayWise']);

	$editadult=clean($editresult['adult']);

	$editchild=clean($editresult['child']);


	$edittourType=clean($editresult['tourType']);

	$editdescription=stripslashes($editresult['description']);

	$editguest1=clean($editresult['guest1']);

	$editguest2=clean($editresult['guest2']);


	$editcategoryId=clean($editresult['categoryId']);

	$needFlight=clean($editresult['needFlight']);

	$earlyCheckin=clean($editresult['earlyCheckin']);



	$editqueryCloseDetails=clean($editresult['queryCloseDetails']);

	$editqueryCloseDate=clean($editresult['queryCloseDate']);

	$editmultiemails=clean($editresult['multiemails']);

	$editqueryStatus=clean($editresult['queryStatus']);

	$quotationYes=clean($editresult['quotationYes']);

	$editattachmentFileclean=($editresult['attachmentFile']);

	$editremark=clean($editresult['remark']);

	$editqueryId=clean($editresult['queryId']);
	
	$editsubject=clean($editresult['subject']);
	
	$seriesCode=clean($editresult['seriesCode']);
	
	$FDCode=clean($editresult['FDCode']);

	$packageCode=clean($editresult['packageCode']);

	$editsupplierId =clean($editresult['packageSupplier']);
	
	$hotelAccommodation=clean($editresult['hotelAccommodation']);
	
	$needFlight=clean($editresult['needFlight']);

	$hotelCategory=clean($editresult['hotelCategory']);

	$cabforLocal=clean($editresult['cabforLocal']);

	$fromdestinationId=clean($editresult['fromdestinationId']);

	$addedBy=clean($editresult['addedBy']);

	$dateAdded=clean($editresult['dateAdded']);

	$guest1phone=clean($editresult['guest1phone']);

	$guest1email=clean($editresult['guest1email']);

	$modifyBy=clean($editresult['modifyBy']);

	$modifyDate=clean($editresult['modifyDate']);

	$lastId=$editresult['id'];

	$clientType=$editresult['clientType'];

	$seasonType = $editresult['seasonType'];

	$lastqueryidmain=$editresult['id'];

	$fromDate=date("d-m-Y", strtotime($editresult['fromDate']));

	$toDate=date("d-m-Y", strtotime($editresult['toDate']));

	$closerDate=date("d-m-Y", strtotime($editresult['closerDate']));

 	$multiemails=$editresult['multiemails'];

	$occupancyType=$editresult['occupancyType'];

	$editcalculationType=$editresult['calculationType'];
	$editcurrencyId=$editresult['currencyId'];

	$rooms=$editresult['rooms'];

	$edithotelBudget=$editresult['hotelBudget'];

	$expectedSales=$editresult['expectedSales'];

	$leadsource=$editresult['leadsource'];

	$campaign=$editresult['campaign'];

	$competitor=$editresult['competitor'];

	$subDestination=$editresult['subDestination'];

	$single=$editresult['single'];

	$doubleocp=$editresult['doubleocp'];

	$triple=$editresult['triple'];

	$infant = $editresult['infant'];

	$queryType = $editresult['queryType'];
	$travelType = $editresult['travelType'];

	$age1 = clean($editresult['age1']);

	$age2 = clean($editresult['age2']);

	$age3 = clean($editresult['age3']);

	$referanceno = clean($editresult['referanceno']);

	$filecode = clean($editresult['filecode']);

	$additionalInfo = clean($editresult['additionalInfo']);

}

if($editresult['closerDate']=='0000-00-00' || $closerDate==''){ 
	$closerDate=''; 
}
if($editresult['expire_date']=='0000-00-00' || $editresult['expire_date']=='' || $editresult['expire_date']=='1970-01-01'){ 
	$expire_date = ''; 
}else{
	 $expire_date = date('d-m-Y',strtotime($editresult['expire_date']));
}

if($_REQUEST['id']==''){

	$clientType='1';

} 
$editassignTo=$_SESSION['userid'];

?>

<script src="tinymce/tinymce.min.js"></script>

<script type="text/javascript">

    tinymce.init({

        selector: "#description",

        themes: "modern",

        plugins: [

            "advlist autolink lists link image charmap print preview anchor",

            "searchreplace visualblocks code fullscreen"

        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

    });
    </script>

	<style>

.gridlable{width:100% !important;}

</style>



<div id="waitloaddest" style="display:none; top: 0px; left: 0px; background-color: #cccccc61; z-index: 9999; position: absolute; height: 100%; width: 100%;"><div style="width: 200px; margin: auto; margin-top: 14%; text-align: center; background-color: #fff; padding: 30px; border-radius: 4px; box-shadow: 0px 0px 5px #898484;">Please wait...</div></div>

<div class="rightsectionheader">

  <table width="100%" border="0" cellpadding="0" cellspacing="0">

    <tr>

      <td>
	  	<div class="headingm" style="margin-left:20px;display:nones;"><span id="topheadingmain">

        <?php if($_REQUEST['id']!=''){ ?>

        Update <?php if($_REQUEST['salesquery']==1){ echo 'Sales'; } ?>

        <?php } else { ?>

        Add <?php if($_REQUEST['salesquery']==1){ echo 'Sales'; } ?>

        <?php } ?>

        <?php echo $pageName; ?> </span></div> 
		</td>

      <td align="right"><table border="0" cellpadding="0" cellspacing="0">

          <tr>

            <td><input style="display:none;" name="addnewuserbtn" type="button" class="bluembutton" id="bookingdetailbtn" value="Client History" onclick="bookingdetails();"></td>

<script type="text/javascript">

function bookingdetails(){

var companyId=$("#companyId").val();

masters_alertspopupopen("action=view_bookingdetails&companyId="+companyId,'900px','auto');

}

</script>

            <td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Save" onclick="$('#loadQueryPackage').html('');formValidation('addeditquery','submitbtn','0');" /></td>

            <td><input type="button" name="Submit3" value="Save and New" class="whitembutton submitbtn"onclick="$('#loadQueryPackage').html('');formValidation('addeditquery','submitbtn','1');"/></td>

            <td style="padding-right:20px;">

<?php if($_REQUEST['salesquery']==1){ ?>

<a href="showpage.crm?module=leads"><input type="button" name="Submit22" value="Cancel" class="whitembutton"  /></a>

<?php } else { ?>

<input type="button" name="Submit22" value="Cancel" class="whitembutton" <?php if($_REQUEST['id']!=''){ ?>onclick="view('<?php echo $_REQUEST['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  />

<?php } ?>

</td>

          </tr>

      </table></td>

    </tr>

  </table>

</div>

<div id="pagelisterouter" style="padding-left:0px;margin-top: -20px;">

<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditquery" target="actoinfrm" id="addeditquery">

<div class="addeditpagebox">

  <!--hidden input s-->
  <input name="action" type="hidden" id="action" value="<?php if($_REQUEST['id']!=''){ echo 'editquery';} else { echo 'addquery'; } ?>" />
  <?php if($_REQUEST['id']=='' && $_REQUEST['incomingid']!=''){ ?>
  <input name="incomingqueryId" type="hidden" id="incomingqueryId" value="<?php echo $_REQUEST['incomingid']; ?>" />
  <?php } ?>
  <input name="savenew" type="hidden" id="savenew" value="0" />
  <input name="saveSeries" type="hidden" id="saveSeries" value="1" />
  <input name="travelType" type="hidden" id="travelType" value="1" />

  <table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td width="30%" align="left" valign="top" style="padding-right:20px;">
	<div style="background-color:#f5f5f5; padding:10px; border:1px #ccc solid; cursor:pointer;" onclick="$('#showmorefield1').toggle();">General Information </div>

	<div style=" border:1px #ccc solid; padding:10px;border-top:0px; display:block; " >
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
		  <tr>
			<td colspan="2">
			<div class="griddiv" ><label>
			<div class="gridlable">Package&nbsp;Name<span class="redmind"></span></div>
			<input name="subject" type="text" class="gridfield validate"  id="subject"  value="<?php echo $editsubject; ?>" displayname="Package Name" maxlength="250"  />
			</label>
			</div>
			</td>
		  </tr>
		</table>
	 
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
		  <tr>
			<td colspan="2">
			<div class="griddiv"><label>
			<div class="gridlable">Package&nbsp;Code<span class="redmind"></span></div>
			<input name="packageCode" type="text" class="gridfield validate" id="packageCode" value="<?php echo $packageCode; ?>"  displayname="Package Code" maxlength="250" />
			</label>
			</div>
			</td>
		  </tr>
		</table>  
	</div>

	</td>
  <td width="36%" align="left" valign="top" style="padding-left:0px;">

	<div style="background-color:#f5f5f5; padding:10px; border:1px #ccc solid; cursor:pointer;" onclick="$('#showmorefield2').toggle();">Package&nbsp;Plan&nbsp;Itinerary</div>

	<div style=" border:1px #ccc solid; padding:10px;border-top:0px;display:block; " >

	<table width="100%" border="0" cellpadding="0" cellspacing="0"   <?php if($_REQUEST["id"] != "" && isset($_REQUEST["id"])){ ?>  style="display:none;" <?php } ?>>
    <tr>
    <td colspan="4" align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <tr> 
		<td width="40%"><label>
		<select name="dayWise" id="dayWise"  class="gridfield" onchange="changedatetr();" style="padding:10px; width:100%; border:1px solid #ccc; box-sizing:border-box; margin-bottom:10px;">
			<option value="1" <?php if(1==$dayWise){ ?>selected="selected"<?php } ?>>Date Wise</option>
			<option value="2" <?php if(2==$dayWise){ ?>selected="selected"<?php } ?>>Day Wise</option>
		  	
		</select> </label></td> 
		<td width="30%"><label  class="sesonshow">

			<select name="seasonType" id="seasonType"  class="gridfield" style="padding:10px; width:100%; border:1px solid #ccc; box-sizing:border-box; margin-bottom:10px;">

			<option value="1" <?php if(1==$seasonType){ ?>selected="selected"<?php } ?>>Summer</option>

			<option value="2" <?php if(2==$seasonType){ ?>selected="selected"<?php } ?>>Winter</option>

			<option value="3" >Both Season</option>

			</select>

			</label> </td>
		<td width="30%"><label class="sesonshow">
			<?php
			$starting_year  = 2020;
			$ending_year    = 2040;
			for($starting_year; $starting_year <= $ending_year; $starting_year++) {
				if(date('Y') == $starting_year ){ $seleted = "selected"; }else{ $seleted = ""; }
				$years[] = '<option value="'.$starting_year.'" '.$seleted.' >'.$starting_year.'</option>';
			}
			?>
			<select name="seasonYear" id="seasonYear"  class="gridfield" style="padding:10px; width:100%; border:1px solid #ccc; box-sizing:border-box; margin-bottom:10px;">

			 <?php echo implode("\n\r", $years);  ?>

			</select>

			</label> </td>
	  </tr>

	</table>
 	</td>
	</tr>
	<tr> 
    <td align="left" valign="top" class="datetr" <?php if($dayWise==1){ ?> style="display:block;"<?php }else{ ?>style="display:none;"<?php } ?>>
	<div class="griddiv">

	<style>

	.adddest{color: #fff !important;

	background-color: #4CAF50;

	display: block;

	float: left;

	text-decoration: none;

	padding: 6px;

	margin-top: 48px;

	margin-left: 2px;

	text-align: center;

	border-radius: 9px;}

	</style>

	<div class="gridlable">From Date  <span class="redmind"></span></div>

	<input name="fromDate2" type="text" id="fromDate2" class="gridfield calfieldicon" displayname="From Travel Date" autocomplete="off" value="<?php if($editfromDate!='1970-01-01' && $editfromDate != '' ){ echo date('d-m-Y',strtotime($editfromDate)); }else{ echo date('d-m-Y'); } ?>" readonly="readonly" style="position: relative; top: auto; right: auto; bottom: auto; left: auto;">

	</div>

	</td> 
    <td width="33%" align="left" valign="top" class="datetr"  <?php if($dayWise==1){ ?> style="display:block;"<?php }else{ ?>style="display:none;"<?php } ?>>
	<div class="griddiv">

	<label>

	<div class="gridlable">To Date <span class="redmind"></span></div>

<input name="toDate2" type="text" id="toDate2"  class="gridfield calfieldicon" displayname="To Travel Date" autocomplete="off" value="<?php if($edittoDate!='1970-01-01' && $edittoDate != '' ){ echo date('d-m-Y',strtotime($edittoDate)); }else{ echo date('d-m-Y'); } ?>" readonly="readonly" style="position: relative; top: auto; right: auto; bottom: auto; left: auto;">

</label>

	</div></td> 
 	<td width="16%" align="left" valign="top"><div class="griddiv" style="width: 84px !important ;"><label>

	<div class="gridlable">Total Nights <span class="redmind"></span></div>

	<input name="night2" type="text" class="gridfield validate numeric" id="night2"  style="width: 84px !important ;" maxlength="3" max="99" min="1"  displayname="Night"    value="<?php  echo $editnight; ?>" onkeyup="changenights();" />

	</label>

	</div>

	</td>



	<td width="17%" align="left" valign="top"><a href="#" style="font-size: 12px;background-color: #4CAF50;color: #fff !important;padding: 11px 8px;margin-right: 0px;margin-top: 20px;display: block;text-align: center;margin-left: 1px;" onclick="generateQueryDay_function();">+ Add</a></td>

</tr>


	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
	<tr><td>
	<div id="generateQueryDays"></div>
	<div style="border: 1px #e0e0e0 solid; padding:0px; text-align:right; margin-bottom:10px;" id="adddatedistinationdiv"></div>
	<script type="text/javascript">

	function generateQueryDay_function(){
		var fromDate = $('#fromDate2').val();
		var toDate = $('#toDate2').val();
		var dayWise = $('#dayWise').val();
		var seasonYear = $('#seasonYear').val();
		var seasonType = $('#seasonType').val();
		var nights = $('#night2').val();
		var isEditable = <?php if($_REQUEST["id"] != "" && isset($_REQUEST["id"])){ echo "0"; } else{ echo "1"; } ?>;
		if( ( fromDate != toDate &&  dayWise == 1 ) || ( dayWise == 2 && nights > 0) ){
		$('#generateQueryDays').load('generateQueryDays.php?action=generateQueryDays&queryId=<?php echo $lastqueryidmain;?>&seasonYear='+seasonYear+'&seasonType='+seasonType+'&nights='+nights+'&isEditable='+isEditable+'&dayWise='+dayWise+'&fromDate='+fromDate+'&toDate='+toDate);
		}

	} 
	generateQueryDay_function();
	comtabopenclose('linkbox','op2');

	function changePriority(){

		var adult = $('#adult').val();

		if(adult>9){

		$('#queryPriority').val('3');

		}

	}

	window.setInterval(function(){

		changePriority()

	}, 1000);

	function changenights(){

		var f = $('#fromDate2').val();
		if(f == '' || f == undefined){
			$('#fromDate2').val('<?php echo date('d-m-Y'); ?>');
			var someDate = new Date('<?php echo date('Y-m-d'); ?>');
		}else{
			var date_string = f.split("-").reverse().join("-");
			var someDate = new Date(date_string);

		}

		var night = Number($('#night2').val());
		someDate.setDate(someDate.getDate() + night);
		someDate.setTime(someDate.getTime() + (330 * 60 * 1000));
		var dateFormated = someDate.toISOString().substr(0,10);
		var findate = dateFormated.split("-").reverse().join("-");
		$('#toDate2').val(findate);
		$('#counttnights').val(night);
	}

	function showDays(firstDate,secondDate){

		var startDay = new Date(firstDate);

		var endDay = new Date(secondDate);

		var millisecondsPerDay = 1000 * 60 * 60 * 24;

		var millisBetween = startDay.getTime() - endDay.getTime();

		var days = millisBetween / millisecondsPerDay;

		// Round down.

		return ( Math.floor(days));

	}

	function toTimestamp(strDate){
	   var datum = Date.parse(strDate);
	   return datum/1000;
	}
	$('#toDate2').Zebra_DatePicker({
		format: 'd-m-Y',
		onSelect: function (dateStr) {
			var fromDate = $('#fromDate2').val().split("-").reverse().join("-");
			var toDate = $('#toDate2').val().split("-").reverse().join("-");
			var totaldays = showDays(toDate,fromDate);
			if(totaldays > 0){
	    		$('#night2').val(totaldays);
			}
	    }
	});
	$('#fromDate2').Zebra_DatePicker({
	  direction: true,
	  format: 'd-m-Y',
	  pair: $('#toDate2')
	});


	function addDayToDate(no_of_days,date_string){
		var someDate = new Date(date_string).toLocaleString("en-US", {timeZone: "Asia/Kolkata"});
		var someDate = new Date(someDate.setDate(someDate.getDate() + no_of_days));
		return someDate;
	}

	function changedatetr(){

		var dayWise = $('#dayWise').val();

		if(dayWise==2){

			$('.datetr').hide();

			$('#counttnightBox').show();

			$('.sesonshow').show();

		}else{

			$('#counttnightBox').hide();

			$('.datetr').show();

			$('.sesonshow').hide();

			$('#fromDate2').val('<?php if($editresult['fromDate']!='1970-01-01' && $editresult['fromDate'] != '' ){ echo date('d-m-Y',strtotime($editresult['fromDate'])); }else{ echo date('d-m-Y'); } ?>');

	 		$('#toDate2').val('<?php if($editresult['toDate']!='1970-01-01' && $editresult['toDate'] != '' ){ echo date('d-m-Y',strtotime($editresult['toDate'])); }else{ echo date('d-m-Y'); } ?>');

		}
	}

	changedatetr();


	</script>
	</td>
	</tr>
	</table>
 

	</div>

	</td>

    <td width="33%" align="left" valign="top" style="padding-left:20px;">

	<div style="background-color:#f5f5f5; padding:10px; border:1px #ccc solid; cursor:pointer;" onclick="$('#showmorefield').toggle();">Other Information</div>

	<!--id="showmorefield"-->

	<div style=" border:1px #ccc solid; padding:10px;border-top:0px; display:block; " >

		<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		  <tr>
			<td colspan="2" width="50%" align="left" valign="top"><div class="griddiv"  ><label>
			<div class="gridlable" style="width:100%;">Package Validity Date</div>
			<input name="expire_date" type="text" class="gridfield " id="expirydate" placeholder="Expiry Date" displayname="Package  Date" value="<?php echo $expire_date; ?>"/>
			</label>
			<script src="js/zebra_datepicker.js?id=<?php echo time(); ?>"></script>
			<script type="text/javascript">
				$(document).ready(function(){
					$('#expirydate').Zebra_DatePicker();
				});
			</script>
			</div>
			</td>
			
			<td colspan="2" width="50%" align="left" valign="top"><div class="griddiv"  ><label>
			<!-- Pax type sec started -->

								
		<div class="gridlable" style="font-size: 13px;color: gray;margin-top: 3px;">Pax&nbsp;Type</div>
		<div  style="display: grid;grid-template-columns: auto auto; width:100%;">
		
		
			<div class="main-div-con" style="width:85%" >
				<div class="check_boxIndiv" style="display: flex; width:80%">

					<div style="width:50%;text-align: left;" >
						GIT
					</div>
					<div style="width:50%;text-align: right;" class="check-box-title" >
					<input name="paxType" id="paxType" class="check_box_input"  type="radio" value="1" <?php if(1==$paxType || $paxType==''){ ?>checked="checked"<?php } ?> ></input>
					</div>
					
				</div>
			</div>


			<div class="main-div-con" style="width: 76%; margin-left: 16px;" >
				<div class="check_boxIndiv" style="display: flex; width:80%">

					<div style="width:50%;text-align: left;" >
						FIT
					</div>
					<div style="width:50%;text-align: right;" class="check-box-title" >
					<input name="paxType" id="paxType"  class="check_box_input" type="radio" value="2" <?php if(2==$paxType){ ?>checked="checked"<?php } ?> checked="checked"></input>
					</div>
					
				</div>
			</div>
			
		</div>
	
			<!-- Pax type sec started -->
			</td>





		  </tr>
		</table>

		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="display:none;"> 
			<tr>
				<td width="50%" align="left" valign="top" >
					<div class="griddiv"> 
					<label>
						<div class="gridlable">Calculation&nbsp;Type<span class="redmind"></span></div>
						<select id="calculationType" name="calculationType" class="gridfield validate" displayname="Calculation Type" autocomplete="off" onchange="if($(this).val()==2){ $('#packageWiseCosting').show(); }else{ $('#packageWiseCosting').hide(); }">		
							<option value="1" <?php if($editcalculationType==1){ ?>selected="selected"<?php  } ?>>Service Wise</option> 
							<!-- <option value="2" <?php if($editcalculationType==2){ ?>selected="selected"<?php  } ?>>Package Wise</option>  -->
						</select>
					</label>
					</div>
				</td>
			<td width="50%" align="left" valign="top">
				<div class="griddiv">
					<label> 
						<div class="gridlable">Currency<span class="redmind"></span></div> 
						<select id="currencyId" name="currencyId" class="gridfield validate" displayname="Currency" autocomplete="off" >  
						<?php    
						$rs=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' status=1 and deletestatus=0 order by setDefault desc');  
						while($currencyD=mysqli_fetch_array($rs)){   
						?> 
						<option value="<?php echo strip($currencyD['id']); ?>" <?php if($currencyD['id']==$editcurrencyId){ ?>selected="selected"<?php } ?>><?php echo strip($currencyD['name']); ?></option> 
						<?php } ?> 
						</select> 
					</label>  
				</div>
			</td> 
			</tr> 
		</table>
  
		<!--Additional Information-->
		<table width="100%" border="0" cellspacing="0" cellpadding="0" >
		  <tr>
			<td colspan="2">
				<div class="griddiv" style=" margin-top:10px;">
					<label>
						<div class="gridlable" style="width:100%;">Additional Information</div>
						<textarea name="additionalInfo" class="gridfield" id="additionalInfo" style="min-height: 60px;"> <?php echo $additionalInfo; ?></textarea>
					</label>
				</div>
			</td>
		  </tr>
		</table>

		<!--hidden input s-->
		<input type="hidden" name="quotationYes" value="2"/>
		<input type="hidden" name="attachitinerary" value="1"/>
		<input type="hidden" name="moduleType" id="moduleType" value="4"/>
		<input type="hidden" name="queryType" id="queryType" value="4"/>
		<input type="hidden" name="totalrooms" id="totalrooms" value="1"/>
		<input type="hidden" name="nationality" id="nationality" value="<?php echo clean($editresult['nationality']); ?>" />


</div>

	</td>

  </tr>
 
</table>

</div>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td align="right"><table border="0" cellpadding="0" cellspacing="0">

      <tr>

        <td>

		<input name="editId" type="hidden" id="editId" value="<?php if($lastqueryidmain!=''){ echo encode($lastqueryidmain); } ?>" />

		<input name="salesquery" type="hidden" id="salesquery" value="<?php echo $_REQUEST['salesquery']; ?>" />

		<input name="queryedityes" type="hidden" id="queryedityes" value="<?php if($clientType!=''){ echo 'yes'; } else { echo 'no'; }?>" />

		<input name="editedityes" type="hidden" id="editedityes" value="1" /><input name="action2" type="hidden" id="action2" value="addQueryCost" />

	    <input name="mailId" type="hidden" id="mailId" value="<?php echo decode($_REQUEST['incomingid']); ?>" />

		</td>

        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="$('#loadQueryPackage').html('');formValidation('addeditquery','submitbtn','0');" />

		<input name="totalQueryCost" type="hidden" id="totalQueryCost" value="0" />

		</td>

        <td><input type="button" name="Submit" value="Save and New" class="whitembutton submitbtn"onclick="$('#loadQueryPackage').html('');formValidation('addeditquery','submitbtn','1');"/></td>

        <td style="padding-right:20px;"><?php if($_REQUEST['salesquery']==1){ ?>

<a href="showpage.crm?module=leads"><input type="button" name="Submit22" value="Cancel" class="whitembutton"  /></a>

<?php } else { ?>

<input type="button" name="Submit22" value="Cancel" class="whitembutton" <?php if($_REQUEST['id']!=''){ ?>onclick="view('<?php echo $_REQUEST['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  />

<?php } ?></td>

      </tr>

    </table></td>

  </tr>

</table>

</div>

</form>

</div>


<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="dist/js/adminlte.js"></script>

<script src="plugins/select2/select2.full.min.js"></script>

<script>

  $(document).on("input", ".numeric", function() {

    this.value = this.value.replace(/\D/g,'');

 });

  </script>

<style>
.addeditpagebox{
	padding:20px!important;
}
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

    width: 100% !important;

}


.check_boxIndiv{
		height: 16px;
		border: 1px solid #ccc;
		padding: 10px;
		font-size: 13px;
		font-weight: 500;
		border-radius: 5px;
		margin: 0 2px 10px 2px;
	}
	.main-div-con{
		width: 100%;
	}
	.check_box_input{
		display: inline-block !important;
	    float: right;
		height: 16px;
		width:16px;
		position: relative;
    	bottom: 3px;
	}
	.check-box-title{
		display: inline-block ;

	}
	
</style>
