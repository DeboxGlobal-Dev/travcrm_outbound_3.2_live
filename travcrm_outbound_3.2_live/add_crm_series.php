<?php

if($addpermission!=1 && $_REQUEST['id']==''){

	header('location:'.$fullurl.'');

}

if($editpermission!=1 && $_REQUEST['id']!=''){

	header('location:'.$fullurl.'');

}

if($_REQUEST['id']==''){
	//add FD
	$wheredel='addedBy='.trim($_SESSION['userid']).' and deletestatus=1'; 
	$dateAdded=time();
	$namevalue ='deletestatus=1,moduleType=2,addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';
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

	$age1 = clean($editresult['age1']);

	$age2 = clean($editresult['age2']);

	$age3 = clean($editresult['age3']);

	$referanceno = clean($editresult['referanceno']);

	$filecode = clean($editresult['filecode']);

	$additionalInfo = clean($editresult['additionalInfo']);

	// $seriesCode = clean($editresult['seriesCode']);
	// $FDCode = clean($editresult['FDCode']);
	// $packageCode = clean($editresult['packageCode']);

	$drs=GetPageRecord('name','nationalityMaster','1 and id="'.$editresult['nationality'].'"'); 
	$nationNameD=mysqli_fetch_array($drs); 
	$nationality = $nationNameD['name'];
	$nationId = $nationNameD['id'];

	$drs=GetPageRecord('name','marketMaster','1 and id="'.$editresult['marketType'].'"'); 
	$marketNameD=mysqli_fetch_array($drs); 
	$marketType = $marketNameD['name'];
	$marketId = $marketNameD['id'];

}

if($editresult['closerDate']=='0000-00-00' || $closerDate==''){ 
	$closerDate=''; 
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

<link href="css/main.css" rel="stylesheet" type="text/css" />

<div id="waitloaddest" style="display:none; top: 0px; left: 0px; background-color: #cccccc61; z-index: 9999; position: absolute; height: 100%; width: 100%;"><div style="width: 200px; margin: auto; margin-top: 14%; text-align: center; background-color: #fff; padding: 30px; border-radius: 4px; box-shadow: 0px 0px 5px #898484;">Please wait...</div></div>

<div class="rightsectionheader">

  <table width="100%" border="0" cellpadding="0" cellspacing="0">

    <tr>

      <td>
	  	<div class="headingm" style="margin-left:20px;display:none;"><span id="topheadingmain">

        <?php if($_REQUEST['id']!=''){ ?>

        Update <?php if($_REQUEST['salesquery']==1){ echo 'Sales'; } ?>

        <?php } else { ?>

        Add <?php if($_REQUEST['salesquery']==1){ echo 'Sales'; } ?>

        <?php } ?>

        <?php echo $pageName; ?> </span></div>
		&nbsp;&nbsp;
		</td>

      <td align="right"><table border="0" cellpadding="0" cellspacing="0">

          <tr>

            <td><input name="addnewuserbtn" type="button" class="bluembutton" id="bookingdetailbtn" value="Client History" onclick="bookingdetails();"></td>

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



  <table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td width="30%" align="left" valign="top" style="padding-right:20px;">
	<div style="background-color:#f5f5f5; padding:10px; border:1px #ccc solid; cursor:pointer;" onclick="$('#showmorefield1').toggle();">General Information </div>

	<div style=" border:1px #ccc solid; padding:10px;border-top:0px; display:block; " >
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 	  	<tr><td><div class="griddiv"><label>
 		<div class="gridlable">Pax&nbsp;Type</div>
 		<select name="queryType" id="queryType"  class="gridfield"  onchange="gitcodefun();">
 			<option value="2">Series</option>
 		</select>
 		</label></div></td></tr>
	</table>
 	<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
	  <tr>
		<td colspan="2">
			<div class="griddiv">
	<label><div class="gridlable" style="margin-top: 0px;">Business Type<span class="redmind"></span></div>
	<select id="clientType" name="clientType" class="gridfield validate" displayname="Client Type" autocomplete="off">
		<?php
		$rs='';
		$rs=GetPageRecord('*','businessTypeMaster',' deletestatus=0 and status=1 order by name asc');
		while($resListing1=mysqli_fetch_array($rs)){
		?>
		<option value="<?php echo strip($resListing1['id']); ?>" <?php if($resListing1['id']==$clientType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing1['name']); ?></option>
		<?php } ?>
	</select>

	</label>

	</div>
		</td>
	  </tr>
	</table>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
	  <tr>
		<td colspan="2">
		  <div class="griddiv" id="selectclientbox" style="display:<?php if($clientType!=''){ ?>block<?php } else { ?>none<?php } ?>; overflow:visible;"><img src="images/companyicon.png" width="30" height="30" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;" onclick="openselectCompanypop();" />

			<label>

			<script>

			function openselectCompanypop(){

			var clientType1 = $('#clientType').val();

			var incoming_query_email = '<?php echo $query_email; ?>';

			var incoming_query_mobile = '<?php echo $query_mobile; ?>';

			alertspopupopen('action=selectCorporate&clientType='+clientType1+'&incoming_query_email='+incoming_query_email+'&incoming_query_mobile='+incoming_query_mobile+'','600px','auto');
		
			}

			function selectclienttypename(){

				<?php if($editresultmail['masterId']==''){ ?>



			var clientType = $('#clientType').val();

			if(clientType>0){

			$('#selectclientbox').show();

			$('#banumber').show();

			$('#baemail').show();

			if(clientType==1){

			$('#agentb2cnumber').addClass('validate');

			$('#contactpersonnamespan').text('Agent');

			$('#agentTypeDiv').text('Agent');

			$('#agentTypeemail').text('Agent Email');

			$('#agentTypemobile').text('Agent Mobile No');

			}

			if(clientType==2){

			$('#agentb2cnumber').removeClass('validate');

			$('#contactpersonnamespan').text('Contact Person');

			$('#agentTypeDiv').text('B2C');

			$('#agentTypeemail').text('B2C Email');

			$('#agentTypemobile').text('B2C Mobile No');

			}

			} else {

			$('#selectclientbox').hide();

			$('#banumber').hide();

			$('#baemail').hide();

			}

			<?php } ?>

			}

			</script>

			<?php

			if($clientType==2 && $editcompanyId!='' && $editcompanyId!='0' && $_REQUEST['incomingid']==''){

			$select2='*';

		$where2='id='.$editcompanyId.'';

		$rs2=GetPageRecord($select2,_CONTACT_MASTER_,$where2);

		$contantnamemain=mysqli_fetch_array($rs2);

		  $clientnemdisplay = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];

		  $clientnem = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];

		  $getphone =  getPrimaryPhone($contantnamemain['id'],'contacts');

		  $getemail =  getPrimaryEmail($contantnamemain['id'],'contacts');

		}

		if($clientType==1 && $editcompanyId!='' && $editcompanyId!='0' && $_REQUEST['incomingid']==''){

		$select2='*';

		$where2='id='.$editcompanyId.'';

		$rs2=GetPageRecord($select2,_CORPORATE_MASTER_,$where2);

		$contantnamemain=mysqli_fetch_array($rs2);

		 $clientnem = getCorporateCompany($editcompanyId);

		 $clientnemdisplay = getPrimaryNameCompany($editcompanyId,"corporate");

		 $getemail = getPrimaryEmailCompany($editcompanyId,"corporate");

		 $getphone = getPrimaryPhoneCompany($editcompanyId,"corporate");

		 $editcompanyId=($editcompanyId);

		}

		?>

			<div class="gridlable"><c id="agentTypeDiv">Name</c><span class="redmind"></span></div>

			<div style="width:100%; position:relative;">
  
			<input name="companyName" type="text" class="gridfield validate" id="companyName" value="<?php echo $clientnem; ?>"   displayname="Company" autocomplete="off"  onkeydown="searchcompanynamefuncCompany();" onkeyup="searchcompanynamefuncCompany();" />

			<style>

		#getcompanyName {

			position: absolute;

			background-color: #f5f5f5;

			border: 1px solid #ccc;

			z-index: 99;

			top: 39px;

			left: 0px;

			width: 100%;

			overflow: auto;

			max-height: 240px;

			box-shadow: 2px 2px 7px #0000003d;

		}

			</style>

			<div id="getcompanyName" style="display:none;">

			</div>

			</div>

			<script> 
 
			// check
				function searchcompanynamefuncCompany(){
					var searchcompanyname = encodeURIComponent($('#companyName').val());
					var clientType = encodeURIComponent($('#clientType').val());
					if(clientType!='' && clientType!='0'){
					$('#getcompanyName').load('getcompanyName.php?clientType='+clientType+'&searchcompanyname='+searchcompanyname);
					}
					$('#getcompanyName').show();
				}

				function selectCorporateCompany(name,email,phone,id,opsPerson,opsPersonId,nationality,language,salesPerson,marketType,nationId,marketId,tourType){ 
					$('#subject').val('20-10-2021 '+name); 
					$('#companyName').val(name); 
					$('#Preferredlanguage').val(language); 
					$('#nationality').val(nationality);
					$('#nationId').val(nationId); 
					$('#agentb2cmail').val(email);
					$('#marketType').val(marketType); 
					$('#marketId').val(marketId); 
					$('#tourType').val(tourType); 
					$('#agentb2cnumber').val(phone); 
					$('#companyId').val(id);
					$('#salesassignTo').val(salesPerson); 
					if(opsPerson!=''){ 
						$('#ownerName').val(opsPerson); 
						$('#assignTo').val(opsPersonId); 
					}else { 
						$('#ownerName').val(''); 
						$('#assignTo').val(''); 
					} 
					$('#getcompanyName').hide(); 

				} 
				
				// check end
			</script>

			<input name="companyId" type="hidden" id="companyId" value="<?php echo encode($editcompanyId); ?>" />
			<input name="addnewcontactmain" type="hidden" id="addnewcontactmain" value="0" />


			</label>

			</div>
		</td>
	  </tr>
	</table>
 	
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
	  <tr>
		<td colspan="2">
		<div class="griddiv" ><label>

		<div class="gridlable">Series&nbsp;Name<span class="redmind"></span></div>

		<input name="subject" type="text" class="gridfield validate"  id="subject"  value="<?php echo $editsubject; ?>" displayname="Series Name" maxlength="250"  />

		</label>

		</div>
		</td>
	  </tr>
	</table> 
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
	  <tr>
		<td colspan="2">
		<div class="griddiv"><label>

		<div class="gridlable">Series&nbsp;Code<span class="redmind"></span></div>

		<input name="seriesCode" type="text" class="gridfield validate" id="seriesCode" value="<?php echo $seriesCode; ?>"  displayname="Subject" maxlength="250" />

		</label>

		</div>
		</td>
	  </tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
		<tr>
			<td width="50%">
				<div class="griddiv">
					<label>
						<div class="gridlable">
							<c id="contactpersonnamespan">Market Type </c>
						</div>
						<input name="marketType" type="text" class="gridfield" id="marketType" readonly="" displayname="Market Type" value="<?php echo $marketType; ?>">
						<input name="marketId" type="hidden" id="marketId" value="<?php echo $marketId; ?>">
					</label>
				</div>
			</td>
			<td width="50%">
				<div class="griddiv">
					<label>
						<div class="gridlable">Nationality</div>
						<input name="nationality" type="text" class="gridfield" id="nationality" readonly="" displayname="Nationality" value="<?php echo $nationality; ?>">
						<input name="nationId" type="hidden" id="nationId" value="<?php echo $nationId; ?>">
					</label>
				</div>
			</td>
		</tr>
	</table>

   
	</div>

	</td>

    <td width="36%" align="left" valign="top" style="padding-left:0px;">

	<div style="background-color:#f5f5f5; padding:10px; border:1px #ccc solid; cursor:pointer;" onclick="$('#showmorefield2').toggle();">Series&nbsp;Plan&nbsp;Itinerary</div>

	<div style=" border:1px #ccc solid; padding:10px;border-top:0px;display:block; " >

	<table width="100%" border="0" cellpadding="0" cellspacing="0"   <?php if($_REQUEST["id"] != "" && isset($_REQUEST["id"])){ ?>  style="display:none;" <?php } ?>>
    <tr>
    <td colspan="4" align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <tr> 
		<td width="40%"><label>
		<select name="dayWise" id="dayWise"  class="gridfield" onchange="changedatetr();" style="padding:10px; width:100%; border:1px solid #ccc; box-sizing:border-box; margin-bottom:10px;">
			<option value="2" <?php if(2==$dayWise){ ?>selected="selected"<?php } ?>>Day Wise</option>
		  	<option value="1" <?php if(1==$dayWise){ ?>selected="selected"<?php } ?>>Date Wise</option>
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
	</td></tr>
	</table>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 	   
	  <tr><td colspan="2">
	  <div class="griddiv">

		<script type="text/javascript">

			function getgitorfit(){

				var adult = Number($('#adult').val());

				if(adult>8){

					alert('This is a GIT query.');

					$('#queryType').val('1');

					gitcodefun();

				}

			}



			function gitcodefun(){

				var queryType = Number($('#queryType').val());



				if(queryType==1){

					$('#gitgroupcode').show();

					$('#discountslabouter').show();

					$('#gitgroupName').show();

					$('#discountSlabs').val('');

					$('#seasonBox').hide();

					//$('#brochureCountslabBox').hide();

				}

				else if(queryType==3){

					$('#seasonBox').show();

					//$('#brochureCountslabBox').show();

					$('#gitgroupcode').hide();

					$('#discountslabouter').hide();

					$('#gitgroupName').hide();

					$('#discountSlabs').val('1');



				}

				 else {

					$('#gitgroupcode').hide();

					$('#discountslabouter').hide();

					$('#gitgroupName').hide();

					$('#discountSlabs').val('1');

					$('#seasonBox').hide();

					//$('#brochureCountslabBox').hide();

				}

			}



			jQuery(document).ready(function(){



				gitcodefun();



			});



		</script>

		<div class="griddiv" id="gitgroupcode" <?php if($queryType!=1){ ?>style="display:none;"<?php } ?>><label>

		<div class="gridlable" style="width:100%;">Group Code  </div>

		<input name="groupCode" type="text" class="gridfield" id="groupCode" value="<?php echo $editresult['groupCode']; ?>"/>

		</label>

		</div>

		<div class="griddiv" id="gitgroupName" <?php if($queryType!=1){ ?>style="display:none;"<?php } ?>><label>

		<div class="gridlable" style="width:100%;">Group Name </div>

		<input name="groupName" type="text" class="gridfield" id="groupName" value="<?php echo $editresult['groupName']; ?>"/>

		</label>

		</div>

		</div>
	  </td></tr>
	</table>

	</div>

	</td>

    <td width="33%" align="left" valign="top" style="padding-left:20px;">

	<div style="background-color:#f5f5f5; padding:10px; border:1px #ccc solid; cursor:pointer;" onclick="$('#showmorefield').toggle();">Other Information</div>

	<!--id="showmorefield"-->

	<div style=" border:1px #ccc solid; padding:10px;border-top:0px; display:block; " >

	<!--AssignTO -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
	  <tr>
		<td width="50%">
		<div class="griddiv validate " style="width: 100%;"><img src="images/userrole.png" onclick="function_assignTo();" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;"  />

		<label>

		<div class="gridlable validate" style="width:100%;">Operation Person<span class="redmind"></span></div> 
		<div id="selectOpsPerson"> 
			<input name="ownerName" type="text" class="gridfield  validate" id="ownerName" value="<?php echo getUserName($editassignToMain); ?>" readonly="true" displayname="Operation&nbsp;Person" autocomplete="off" onclick="function_assignTo();" /> 
			<input name="assignTo" type="hidden" id="assignTo" value="<?php echo encode($editassignToMain); ?>" /></div> 
		</label>
		<script type="text/javascript">

			function function_assignTo(){
				var lang = $('#language').val();
				alertspopupopen('action=selectParent&userType=1','600px','auto');
			} 
		</script>
		</div>
		</td>
		<td width="50%">
		<div class="griddiv validate " style="width: 100%;"> 
		<label> 
		<div class="gridlable validate" style="width:100%;">Sales Person<span class="redmind"></span></div> 
		<div id="selectOpsPerson"> 
		<input type="text" name="salesassignTo" id="salesassignTo" class="gridfield" value="<?php echo $editresult['salesassignTo']; ?>" readonly="" /> 
			 </div> 
		</label> 
		</div>
		</td>
	  </tr>
	</table> 
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="display:none">

	  <tr>

		<td width="50%" align="left" valign="top"><div class="griddiv">

		<label>

		<div class="gridlable">Priority</div>

		<select id="queryPriority" name="queryPriority" class="gridfield"  autocomplete="off" >

		<option value="3">High</option>

		<option value="2" selected="selected">Medium</option>

	 <option value="1">Low</option>

	</select></label>

		</div></td>

		<td width="50%" align="left" valign="top"><div class="griddiv">

		<label>

		<div class="gridlable">TAT</div>

		<select id="tat" name="tat" class="gridfield"  autocomplete="off" >

		<option >None</option>

		<option value="30" selected="selected" >30 Minutes</option>

		<option value="45" >45 Minutes</option>

		<option value="60" >1 Hour</option>

		<option value="120" >2 Hour</option>

		<option value="240" >4 Hour</option>

		<option value="360" >6 Hour</option>

		<option value="480" >8 Hour</option>

		<option value="720" >12 Hour</option><!--

		<option value="<?php echo date("Y-m-d h:i:s", strtotime("+1 day")); ?>" >1 Day</option>

		<option value="<?php echo date("Y-m-d h:i:s", strtotime("+2 day")); ?>" >2 Day</option> -->

	</select></label>

		</div></td>

	  </tr>

	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="display:none;">

	  <tr>

		<td width="50%" align="left" valign="top"><div class="griddiv" ><label>

		<div class="gridlable">Payment Mode</div>

		<select id="paymentMode" name="paymentMode" class="gridfield"  autocomplete="off" >

		  <option value="1">BTC</option>

		  <option value="2">Direct Payment</option>

		</select>

		</label>

		</div></td>

		<td width="50%" align="left" valign="top"><div class="griddiv"><label>

		<div class="gridlable" style="width:100%;">File Code </div>

		<input name="filecode" type="text" class="gridfield" id="filecode"   value="<?php echo $filecode; ?>"/>

		</label>

		</div></td>

	  </tr>

	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="display:none;">

	  <tr>

		<td colspan="2" width="100%" align="left" valign="top"><div class="griddiv"  ><label>

		<div class="gridlable" style="width:100%;">Reference No.</div>

		<input name="referanceno" type="text" class="gridfield" id="referanceno" placeholder="Referance No."   value="<?php echo $referanceno; ?>"/>

		</label>

		</div></td>

	  </tr>

	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >

	  <tr>

		<td colspan="2" width="100%" align="left" valign="top"> 
			<div class="griddiv"> 
			<label> 
			<div class="gridlable">&nbsp;&nbsp;Preferred&nbsp;Language<span class="redmind"></span></div> 
			<select id="Preferredlanguage" name="language" class="gridfield validate" displayname="Preferred Language" autocomplete="off"   >
			<?php 
			$rs=GetPageRecord('*','tbl_languagemaster',' deletestatus=0  order by name asc'); 
			while($resListing=mysqli_fetch_array($rs)){ 
			?> 
			<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']=='1'){ ?>selected="selected"<?php }else if($resListing['id']==$editlanguage && $resListing['status'] == 1){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option> 
			<?php } ?> 
			</select>
			</label>
			</div></td> 
	  </tr>

	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
	<tr> 
	<td width="50%" align="left" valign="top">
		<div class="griddiv">
		<label><div class="gridlable">Tour Type <span class="redmind"></span></div>	
		<select id="tourType" name="tourType" class="gridfield validate" displayname="Tour Type" autocomplete="off"   >
		  <?php
		$rs=GetPageRecord('*',_TOUR_TYPE_MASTER_,' deletestatus=0 and status=1 order by name asc');
		while($resListing=mysqli_fetch_array($rs)){
		?>
		<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$edittourType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
		<?php } ?>
		</select>
		</label>
		</div>
	</td>
	<td width="50%" align="left" valign="top">
		<div class="griddiv">
		<label><div class="gridlable" >Vehicle Prefrence </div>
			<select id="vehicleId" name="vehicleId" class="gridfield"  autocomplete="off"> 
				<option value="">Select Vehicle</option> 
				<?php

				$select='*';

				$where=' 1 group by model order by id asc';

				$rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where);

				while($resListing=mysqli_fetch_array($rs)){

				?>

				<option value="<?php echo $resListing['id']; ?>" <?php if($editresult['vehicleId']==$resListing['id']){ ?> selected="selected" <?php } ?>><?php echo $resListing['model']; ?></option>

				<?php } ?>

		   </select>
		</label>
		</div>
	</td>
	</tr>
	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
	<tr>
	<td width="50%" align="left" valign="top">
		<div class="griddiv"> 
		<label><div class="gridlable">Hotel&nbsp;Category<span class="redmind"></span></div>
		<select id="hotelAccommodation" name="hotelAccommodation" class="gridfield validate" displayname="Hotel Category" autocomplete="off"   >		
		 <option value="3" <?php if($hotelAccommodation=='3'){ ?>selected="selected"<?php  } ?>>3 Star</option> 
		 <option value="4" <?php if($hotelAccommodation=='4'){ ?>selected="selected"<?php  } ?>>4 Star</option> 
		 <option value="5" <?php if($hotelAccommodation=='5'){ ?>selected="selected"<?php  } ?>>5 Star</option> 
		</select>
		</label>
		</div>
	</td>
	<td width="50%" align="left" valign="top">
		<div class="griddiv"> 
		<label><div class="gridlable">Meal Plan<span class="redmind"></span></div>
			<select id="mealPlanId" name="mealPlanId" class="gridfield validate" displayname="Meal Plan" autocomplete="off"   >
			<?php
			$rs=GetPageRecord('*',_MEAL_PLAN_MASTER_,' deletestatus=0 and status=1 order by name asc');
			while($resListing=mysqli_fetch_array($rs)){
				if($editresult['mealPlanId']!=''){
					$mealPlanId = $editresult['mealPlanId'];
				}else{
					if($resListing['name'] == 'cp' || $resListing['name'] == 'CP' ){
					$mealPlanId = $resListing['id'];
					}
				}
				?>
				<option value="<?php echo strip($resListing['id']); ?>" <?php if($mealPlanId==$resListing['id']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
			<?php } ?>
			</select>
		</label>
		</div>
	</td> 
	</tr> 
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0"  style="display:none">
    <tr>
    <td width="50%"><div class="griddiv"><label>

	<div class="gridlable">Lead Source</div>

	<select id="leadsource" name="leadsource" class="gridfield"  autocomplete="off" >
	<option value="0">Select</option>
	<?php
	$rsl=GetPageRecord('*',_LEADSSOURCE_MASTER_,' status=1 order by name asc');
	while($resListingl=mysqli_fetch_array($rsl)){
	?>
    <option value="<?php echo strip($resListingl['id']); ?>" <?php if($resListingl['id']==$leadsource){ ?>selected="selected"<?php } ?>><?php echo strip($resListingl['name']); ?></option>
	<?php } ?>
    </select>
	</label>
	</div>
	</td>

    <td width="50%" align="left" valign="top"><div class="griddiv">

	<label>

	<div class="gridlable">Lead Refrence Id  </div>

	<input name="referenceId" class="gridfield" value="<?php echo clean($editresult['referenceId']); ?>" />

	</label>

	</div></td>

    </tr>
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0"  style="display:none">
	  <tr>

		<td width="50%" align="left" valign="top">
			<div class="griddiv"><label><div class="gridlable">Immediate&nbsp;Occupancy<span class="redmind"></span></div>

			<select id="earlyCheckin" style="width:100%" name="earlyCheckin" class="gridfield"  displayname="Early Checki-n" autocomplete="off"   >

			<option value="0" <?php if($earlyCheckin=='0'){ ?>selected="selected"<?php  } ?>>No</option>

			<option value="1" <?php if($earlyCheckin=='1'){ ?>selected="selected"<?php  } ?>>Yes</option>

			</select>

			</label>

			</div>
		</td>
		

	  </tr>
	</table>

	<!--Add More Emails -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"  style="display:none">
	  <tr>
		<td colspan="2">
		<div class="griddiv"><label>
		<div class="gridlable" style="width:100%;">Add More Emails  (Comma Separated Emails)   </div>
		<input name="multiemails" type="text" class="gridfield" id="multiemails" placeholder="test@example.com,test@example.com"   value="<?php echo $multiemails; ?>"/>
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
	<input type="hidden" name="moduleType" id="moduleType" value="2" />
	<input type="hidden" name="nationality" id="nationality" value="<?php echo clean($editresult['nationality']); ?>" />


</div>

	</td>

  </tr>

  <tr>

    <td colspan="4" align="left" valign="top">&nbsp;</td>

  </tr>

  	<tr align="left" valign="top">&nbsp;</tr>

	<tr>

	<td colspan="4" align="left" valign="top" id="loadQueryPackage" style="display:none;" >Loading...</td>

  	</tr>


	<tr>

  	<td colspan="4" align="left" valign="top">

	  	<div  <?php if($queryType!=1){ ?>style="display:none;"<?php } ?> id="discountslabouter">

			<h2 style=" font-size:16px;" >Discount Slabs </h2>

			<div style=" " id="discountslab"></div>

	  	</div>



		<script>

		function loadquerydiscountsslabs(){

		  $('#discountslab').load('querydiscountslab.php?qid=<?php echo $lastqueryidmain; ?>');

		}

		loadquerydiscountsslabs();



		function salesopncls(){

			var plusminus = $('#plusminus').text();

			if(plusminus=='+'){

				$('#mainsalesmodule').show();

				$('#plusminus').text('-');

			} else {

				$('#mainsalesmodule').hide();

				$('#plusminus').text('+');

			}

		}

		salesopncls();

		</script>

	</td>

	</tr>

 
	<tr>

    <td colspan="4" align="left" valign="top">

	<div class="griddiv"><label>

	<div class="gridlable">Description</div>

	<textarea name="description" rows="10" class="gridfield" id="description"><?php echo $editdescription; ?></textarea>

	</label>

	</div></td>

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
	
</style>
