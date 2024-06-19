<?php
if($addpermission!=1 && $_REQUEST['id']==''){
	header('location:'.$fullurl.'');
}
if($editpermission!=1 && $_REQUEST['id']!=''){
	header('location:'.$fullurl.'');
}
if($_REQUEST['id']==''){
	$wheredel='addedBy='.trim($_SESSION['userid']).' and deletestatus=1';
	// deleteRecord(_QUERY_MASTER_,$wheredel);
	$dateAdded=time();
	$namevalue ='deletestatus=1,moduleType=1,addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';
	$lastqueryidmain = addlistinggetlastid(_QUERY_MASTER_,$namevalue);
}
if($_REQUEST['leadId']!=''){
	$leadId = decode($_REQUEST['leadId']);
	$select1='*';
	$where1='id='.$leadId.' ';
	$rs1=GetPageRecord($select1,'leadManageMaster',$where1);
	$resultlists=mysqli_fetch_array($rs1);
	$editcompanyId=clean($resultlists['companyId']);
	$editcontactPId=clean($resultlists['contactPId']);
	$clientType=clean($resultlists['companyId']);
	if($clientType==2){
		$select2='*';
		$where2='id="'.$editcompanyId.'"';
		$rs2=GetPageRecord($select2,_CONTACT_MASTER_,$where2);
		$contantnamemain=mysqli_fetch_array($rs2);
		$drs=GetPageRecord('name','nationalityMaster','1 and id="'.$contantnamemain['nationality'].'"');
		$nationName=mysqli_fetch_array($drs);
		$nationality = $nationName['name'];
		$drs=GetPageRecord('name','marketMaster','1 and id="'.$contantnamemain['marketType'].'"');
		$marketName=mysqli_fetch_array($drs);
		$marketType = $marketName['name'];
		$clientnem = $clientnemdisplay = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];
		$getphone =  getContactPersonPhone($contantnamemain['id'],'contacts');
		$getemail =  getContactPersonEmail($contantnamemain['id'],'contacts');
	} else {
		$select2='*';
		$where2='id="'.$editcompanyId.'"';
		$rs2=GetPageRecord($select2,_CORPORATE_MASTER_,$where2);
		$contantnamemain=mysqli_fetch_array($rs2);

		$drs1=GetPageRecord('name','nationalityMaster','1 and id="'.$contantnamemain['nationality'].'"');
		$nationName=mysqli_fetch_array($drs1);
		$nationality = $nationName['name'];

		$drs=GetPageRecord('name','marketMaster','1 and id="'.$contantnamemain['marketType'].'"');
		$marketName=mysqli_fetch_array($drs);
		$marketType = $marketName['name'];

		$contQuery=GetPageRecord('email,phone','contactPersonMaster',' corporateId="'.$contantnamemain['id'].'" order by primaryvalue desc limit 1');
		$contData=mysqli_fetch_array($contQuery);
		$marketType = $contData['email'];
		$marketType = $contData['email'];
		
		$clientnem = getCorporateCompany($editcompanyId);
		$clientnemdisplay = getContactPersonName($editcontactPId,"corporate"); 
		$getemail = getContactPersonEmail($editcontactPId,"corporate"); 
		$getphone = getContactPersonPhone($editcontactPId,"corporate"); 
		
	}
}
if($_REQUEST['id']!=''){
	$id=clean(decode($_REQUEST['id']));
	$select1='*';
	$where1='id='.$id.'';
	$rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1);
	$editresult=mysqli_fetch_array($rs1);
	$deletestatus = clean($editresult['deletestatus']);
	$editassignToMain=clean($editresult['assignTo']);
	$editcompanyId=clean($editresult['companyId']);
	$editcontactPId=clean($editresult['contactPId']);

	
	$salesassignTo=clean($editresult['salesassignTo']);
	

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
	$destinationId=clean($editresult['destinationId']);
	$dayWise=clean($editresult['dayWise']);
	$editadult=clean($editresult['adult']);
	$editchild=clean($editresult['child']);
	$edittourType=clean($editresult['tourType']);
	$editdescription=stripslashes($editresult['description']);

	$editguest1=clean($editresult['guest1']); 
	$guest1phone=clean($editresult['guest1phone']);
	$guest1email=clean($editresult['guest1email']);

	$editleadPaxName=clean($editresult['leadPaxName']);

	$editcategoryId=clean($editresult['categoryId']);
	$earlyCheckin=clean($editresult['earlyCheckin']);
	$budgetCost=clean($editresult['expectedSales']); //query for edit here

	$editpreferredLang=clean($editresult['preferredLang']);
	$editqueryCloseDetails=clean($editresult['queryCloseDetails']);
	$editqueryCloseDate=clean($editresult['queryCloseDate']);
	$editmultiemails=clean($editresult['multiemails']);
	$editqueryStatus=clean($editresult['queryStatus']);
	$quotationYes=clean($editresult['quotationYes']);
	$editattachmentFileclean=($editresult['attachmentFile']);
	// remark related code
	$editremark=clean($editresult['remark']);
	$editqueryId=clean($editresult['queryId']);
	$editsubject=clean($editresult['subject']);
	$hotelAccommodation=clean($editresult['hotelAccommodation']);
	$hotelCategory=clean($editresult['hotelCategory']);
	$cabforLocal=clean($editresult['cabforLocal']);
	$fromdestinationId=clean($editresult['fromdestinationId']);
	$addedBy=clean($editresult['addedBy']);
	$dateAdded=clean($editresult['dateAdded']);
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
	$paxType=$editresult['paxType'];
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
	
	$moduleType = clean($editresult['moduleType']);
	
	$seriesCode = clean($editresult['seriesCode']);
	$FDCode = clean($editresult['FDCode']);
	$packageCode = clean($editresult['packageCode']);
	$drs=GetPageRecord('*','nationalityMaster','1 and id="'.$editresult['nationality'].'"');
	$nationName=mysqli_fetch_array($drs);
	$nationality = $nationName['name'];
	$nationId = $nationName['id'];

	$drs=GetPageRecord('*','marketMaster',' 1 and id="'.$editresult['marketType'].'"');
	$nationName=mysqli_fetch_array($drs);
	$marketType = $nationName['name'];
	$marketId = $nationName['id'];
	
}
if($editresult['closerDate']=='0000-00-00' || $closerDate==''){
	$closerDate='';
}
if($_REQUEST['id']==''){
	$clientType='1';
}
if(isset($_REQUEST['quotationId'])){
	$quotSql="";
	$quotSql=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_REQUEST['quotationId']).'" order by id asc');
	if(mysqli_num_rows($quotSql)>0 ){
		$quotationData=mysqli_fetch_array($quotSql);
		$subName = $quotationData['subName'];
		$quotationSubject = $quotationData['quotationSubject'];
		$quotationId = encode($quotationData['id']);
		
		
		
		//confirmed fd for this
		$rmsglRoom = $rmdblRoom = $rmtplRoom = $rmtwinRoom = '<span style="font-size:10px;color:#233a49;">0 Room Available </span>';
		$confQuotSql="";
		//echo ' quotationId="'.$quotationData['id'].'" and status=1 ';
		$confQuotSql=GetPageRecord('sum(sglRoom) as sglRoom, sum(dblRoom) as dblRoom, sum(tplRoom) as tplRoom, sum(twinRoom) as twinRoom, sum(childwithNoofBed) as childwithNoofBed,  sum(adult) as adult,  sum(child) as child , count(id) as cnt',_QUOTATION_MASTER_,' quotationId="'.$quotationData['id'].'" and status=1 ');
		$confQuotationData=mysqli_fetch_array($confQuotSql);
		
		$rmadultN = round($editresult['adult']-$confQuotationData['adult']);
		$rmchildN = round($editresult['child']-$confQuotationData['child']);
		$rmsglRoomN = round($editresult['sglRoom']-$confQuotationData['sglRoom']);
		$rmdblRoomN = round($editresult['dblRoom']-$confQuotationData['dblRoom']);
		$rmtplRoomN = round($editresult['tplRoom']-$confQuotationData['tplRoom']);
		$rmtwinRoomN = round($editresult['twinRoom']-$confQuotationData['twinRoom']);
		$rmcwbRoomN = round($editresult['cwbRoom']-$confQuotationData['childwithNoofBed']);
	
		$colorsgl = ($rmsglRoomN > 0) ?'233a49':'ff0000';
		$colordbl = ($rmdblRoomN > 0) ?'233a49':'ff0000';
		$colortpl = ($rmtplRoomN > 0) ?'233a49':'ff0000';
		$colortwin = ($rmtwinRoomN > 0) ?'233a49':'ff0000';
		$colorcwb = ($rmcwbRoomN > 0) ?'233a49':'ff0000';
		if($confQuotationData['cnt'] > 0 && $queryType==3){
			$rmadult = '<span style="font-size:10px;color:#'.$colorsgl.';">'.$rmadultN.' Available </span>';
			$rmchild = '<span style="font-size:10px;color:#'.$colorsgl.';">'.$rmchildN.' Available </span>';
			$rmsglRoom = '<span style="font-size:10px;color:#'.$colorsgl.';">'.$rmsglRoomN.' Available </span>';
			$rmdblRoom = '<span style="font-size:10px;color:#'.$colordbl.';">'.$rmdblRoomN.' Available </span>';
			$rmtplRoom = '<span style="font-size:10px;color:#'.$colortpl.';">'.$rmtplRoomN.' Available </span>';
			$rmtwinRoom= '<span style="font-size:10px;color:#'.$colortwin.';">'.$rmtwinRoomN.' Available </span>';
			$rmtwinRoom= '<span style="font-size:10px;color:#'.$colorcwb.';">'.$rmtwinRoomN.' Available </span>';
		}else{
			$rmadult = '<span style="font-size:10px;color:#'.$colorsgl.';">'.round($editresult['adult']).' Available </span>';
			$rmchild = '<span style="font-size:10px;color:#'.$colorsgl.';">'.round($editresult['child']).' Available </span>';
			$rmsglRoom = '<span style="font-size:10px;color:#'.$colorsgl.';">'.round($editresult['sglRoom']).' Available </span>';
			$rmdblRoom = '<span style="font-size:10px;color:#'.$colordbl.';">'.round($editresult['dblRoom']).' Available </span>';
			$rmtplRoom = '<span style="font-size:10px;color:#'.$colortpl.';">'.round($editresult['tplRoom']).' Available </span>';
			$rmtwinRoom= '<span style="font-size:10px;color:#'.$colortwin.';">'.round($editresult['twinRoom']).' Available </span>';
			$rmtwinRoom= '<span style="font-size:10px;color:#'.$colorcwb.';">'.round($editresult['cwbRoom']).' Available </span>';
		}
	}
}
if($_REQUEST['email']!=''){
	$subject = $_REQUEST['subjectdata'];
	$editdescription=trim($_REQUEST['bodydata']);
	$incomingid=clean($_REQUEST['incomingid']);
	$incomingQeuryId=clean($editresult['id']);

	$editdescription = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $editdescription);
    $editdescription = str_replace('span','p',$editdescription);
    $editdescription = strip_tags($editdescription,"<p><br><b><strong><img>");
     

     
	// $editdescription=imap_qprint($editdescription);
	$editsubject=stripslashes($subject);
	$date = date('d-m-Y',strtotime($editresult['mailDate']));
	$array = explode(',', $_REQUEST['email']);
	$email= $array[0];
	$select1='*';
	$where1='email="'.trim(($email)).'" and sectionType="contacts"';
	$rs1=GetPageRecord($select1,'emailMaster',$where1);
	$editresultmail=mysqli_fetch_array($rs1);
	if($editresultmail['masterId']!=''){
		$select1='*';
		$where1='id="'.trim($editresultmail['masterId']).'"';
		$rs1=GetPageRecord($select1,'contactsMaster',$where1);
		$editresultContact=mysqli_fetch_array($rs1);
		$editcompanyId = $editresultContact['id'];
		$clientnem = stripslashes($editresultContact['firstName'].' '.$editresultContact['lastName']);
		$clientnemdisplayfrommail = $clientnem;
		$getemail = $editresultmail['email'];
		$select1='*';
		$where1='masterId="'.trim($editcompanyId).'"';
		$rs1=GetPageRecord($select1,'phoneMaster',$where1);
		$editresultphone=mysqli_fetch_array($rs1);
		$getphone = $editresultphone['phoneNo'];
		$mailId=stripslashes($editresult['id']);
		$drs=GetPageRecord('name','nationalityMaster','1 and id="'.$editresultContact['nationality'].'"');
		$nationName=mysqli_fetch_array($drs);
		$nationality = $nationName['name'];
		$nationId = $nationName['id'];
		$drs=GetPageRecord('name','marketMaster','1 and id="'.$editresultContact['marketType'].'"');
		$nationName=mysqli_fetch_array($drs);
		$marketType = $nationName['name'];
		$marketId = $nationName['id'];
		$clientType=2;
	}

	if($editresultmail['email']==''){

		$contQuery=GetPageRecord('*','contactPersonMaster','email="'.encode(($email)).'" ');
		$editresultmail=mysqli_fetch_array($contQuery);


		$officeQuery=GetPageRecord('*',_ADDRESS_MASTER_,' id = "'.$editresultmail['officeName'].'"');
		$officeData=mysqli_fetch_array($officeQuery);

		$mailId=stripslashes($editresult['id']);
		if($editresultmail['corporateId']!=''){
			$select1='*';
			$where1='id="'.trim($editresultmail['corporateId']).'"';
			$rs1=GetPageRecord($select1,'corporateMaster',$where1);
			$editresultCorporate=mysqli_fetch_array($rs1);
			$editcompanyId = $editresultCorporate['id'];


			$clientnem = stripslashes($editresultCorporate['name']);
			$clientnemdisplay = $editresultmail['firstName'].' '.$editresultmail['lastName'];
			$getemail = decode($editresultmail['email']);
			$getphone = decode($editresultmail['phone']);
			$mailId=stripslashes($editresult['id']);
			$clientType=1;
			$drs=GetPageRecord('name','nationalityMaster','1 and id="'.$editresultCorporate['nationality'].'"');
			$nationName=mysqli_fetch_array($drs);
			$nationality = $nationName['name'];
			$nationId = $nationName['id'];

			$drs=GetPageRecord('name','marketMaster','1 and id="'.$editresultCorporate['marketType'].'"');
			$nationName=mysqli_fetch_array($drs);
			$marketType = $nationName['name'];
			$marketId = $nationName['id'];
		}
	}
	$subject = date('d-m-Y').' '.$clientnem;
	$editsubject=stripslashes($subject);
}
$hotelCategory='6';
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
	<?php
	if($_REQUEST['id']!='' && isset($_REQUEST['id'])){
		$pageUrlId = '&id='.$_REQUEST['id'];
		if($_REQUEST['quotationId']!='' && isset($_REQUEST['quotationId'])){
			$pageUrlquotationId = '&quotationId='.$_REQUEST['quotationId'];
		}
		$url = $pageUrlId.$pageUrlquotationId;
	}
	
	
	?>
	<tr>
		<td><div class="headingm" style="margin-left:20px;display:none;"><span id="topheadingmain">
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
				<input type="button" name="Submit22" value="Cancel" class="whitembutton" <?php if($_REQUEST['id']!='' && $deletestatus!=1){ ?>onclick="view('<?php echo $_REQUEST['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  />
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
	<input name="action" type="hidden" id="action" value="<?php if($_REQUEST['id']!='' && $moduleType==1){ echo 'editquery';} else { echo 'addquery'; } ?>" />
	<?php if($_REQUEST['id']=='' && $_REQUEST['incomingid']!=''){ ?>
	<input name="incomingqueryId" type="hidden" id="incomingqueryId" value="<?php echo $_REQUEST['incomingid']; ?>" />
	<?php } ?>

	<input name="savenew" type="hidden" id="savenew" value="0" />
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="30%" align="left" valign="top" style="padding-right:20px;">
				<div style="background-color:#f5f5f5; padding:10px; border:1px #ccc solid; cursor:pointer;" onclick="$('#showmorefield1').toggle();">General Information </div>
				<div style=" border:1px #ccc solid; padding:10px;border-top:0px; display:block; " >
					<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
						<tr>
							<td colspan="2">
								<div class="griddiv"><label>
									<div class="gridlable">Query&nbsp;Type</div>
									<select name="queryType" id="queryType"  class="gridfield" onchange="gitcodefun();">
										<?php
										$rs='';
										$rs=GetPageRecord('*','moduleTypeMaster',' status=1 order by id asc');
										while($moduleTypeData=mysqli_fetch_array($rs)){
										?>
										<option value="<?php echo strip($moduleTypeData['id']); ?>" <?php if($moduleTypeData['id']==$queryType){ ?>selected="selected"<?php } ?>><?php echo strip($moduleTypeData['name']); ?></option>
										<?php } ?>
									</select>
								</label></div>
							</td>
							<td>
								<div class="griddiv"  id="paxCodeDiv" ><label>
									<div class="gridlable">Pax&nbsp;Type</div>
									<select name="paxType" id="paxType"  class="gridfield"  >
										<option value="2" <?php if(2==$paxType){ ?>selected="selected"<?php } ?>>FIT</option>
										<option value="1" <?php if(1==$paxType){ ?>selected="selected"<?php } ?>>GIT</option>
									</select>
								</select>
							</label></div>
						</td>
					</tr>
					<input type="hidden" name="isDuplicate" id="isDuplicate" value="<?php echo $editresult['isDuplicate']; ?>">
				<tr id="duplicateQuery" style="display: none;">
				<td colspan="3">
				<div class="griddiv" style="width:100%; position:relative;display:block; overflow:visible;"><label>
					<div class="gridlable">Query&nbsp;ID</div>
						<input type="text" id="queryDuplicate" class="gridfield" name="queryDuplicate" onclick="searchForDuplicateQuery();" onkeydown="searchForDuplicateQuery();" onkeyup="searchForDuplicateQuery();">
					</label>
					<div id="getQueryDuplicate" style="display:none;position: absolute;background-color: rgb(245, 245, 245);border: 0px solid rgb(204, 204, 204);z-index: 99;top: 55px;left: 0px;width: 100%;overflow: auto;max-height: 240px;box-shadow: inset rgb(216 210 210) 0px 0px 0px 1px;"></div>
				</div>
				</td>
				<script>
					function searchForDuplicateQuery(queryId){
						var queryDup = encodeURIComponent($("#queryDuplicate").val());
						$("#getQueryDuplicate").load('searchaction.php?action=makeDuplicateModule&displayId='+queryDup+'&queryId=<?php echo $lastqueryidmain; ?>');
						$('#getQueryDuplicate').show();
					}
				</script>
			</tr>
					<!--SERIES_BLOCK-->
					<input type="hidden" name="quotationId" id="quotationId" value="<?php echo $quotationId; ?>"/>
					
					<tr id="seriesCodeDiv" style="display:none">
						<td colspan="2">
							<div class="griddiv" style="width:100%; position:relative;display:block; overflow:visible;">
								<label><div class="gridlable" style="margin-top: 0px;">Series&nbsp;Code<span class="redmind"></span></div>
								<input name="seriesCode" type="text" class="gridfield" id="seriesCode" value="<?php echo $seriesCode; ?>" displayname="Series Code" autocomplete="off"  onkeydown="searchSubSeries();" onkeyup="searchSubSeries();" />
							</label>
							<div id="getSubSeries" style="display:none;position: absolute;background-color: rgb(245, 245, 245);border: 0px solid rgb(204, 204, 204);z-index: 99;top: 55px;left: 0px;width: 100%;overflow: auto;max-height: 240px;box-shadow: inset rgb(216 210 210) 0px 0px 0px 1px;"></div>
							<script>
							function searchSubSeries(){
								var seriesCode = encodeURIComponent($('#seriesCode').val());
								$('#getSubSeries').load('getSubSeriesList.php?seriesCode='+seriesCode);
								$('#getSubSeries').show();
							}
							</script>
						</div>
					</td>
				</tr>
				<tr id="seriesNameDiv" style="display:none">
					<?php if(strlen(trim($subName)) > 2) { ?>
					<td colspan="2">
						<div class="griddiv" style="width:100%; position:relative;display:block; overflow:visible;">
							<label><div class="gridlable" style="margin-top: 0px;">Series&nbsp;Name<span class="redmind"></span></div>
							<input name="subName" type="text" class="gridfield" id="subName" value="<?php echo $subName; ?>" displayname="Series&nbsp;Name" autocomplete="off" />
						</label>
					</div>
				</td>
				
				<?php } ?>
			</tr>
			<!--FD_BLOCK-->
			<tr id="FDCodeDiv" style="display:none">
				<td colspan="2">
					<div class="griddiv" style="width:100%; position:relative;display:block; overflow:visible;">
						<label><div class="gridlable" style="margin-top: 0px;">Fixed&nbsp;Departure&nbsp;Code<span class="redmind"></span></div>
						<input name="FDCode" type="text" class="gridfield" id="FDCode" value="<?php echo $FDCode; ?>" displayname="FD Code" autocomplete="off"  onkeydown="searchSubFD();" onkeyup="searchSubFD();" />
					</label>
					<div id="getSubFD" style="display:none;position: absolute;background-color: rgb(245, 245, 245);border: 0px solid rgb(204, 204, 204);z-index: 99;top: 55px;left: 0px;width: 100%;overflow: auto;max-height: 240px;box-shadow: inset rgb(216 210 210) 0px 0px 0px 1px;"></div>
					<script>
					function searchSubFD(){
						var FDCode = encodeURIComponent($('#FDCode').val());
						$('#getSubFD').load('getSubFDList.php?FDCode='+FDCode);
						$('#getSubFD').show();
					}
					</script>
				</div>
			</td>
		</tr>
		<tr id="FDNameDiv" style="display:none">
			<?php if(strlen(trim($subName)) > 2) { ?>
			<td colspan="2">
				<div class="griddiv" style="width:100%; position:relative;display:block; overflow:visible;">
					<label><div class="gridlable" style="margin-top: 0px;">Fixed&nbsp;Departure&nbsp;Name<span class="redmind"></span></div>
					<input name="subName" type="text" class="gridfield"  value="<?php echo $subName; ?>" displayname="FD&nbsp;Name" autocomplete="off" />
				</label>
			</div>
		</td>
		<?php } ?>
	</tr>
	<!--PACKAGE_BLOCK-->
	<tr id="PackageCodeDiv" style="display:none">
		<td colspan="2">
			<div class="griddiv" style="width:100%; position:relative;display:block; overflow:visible;">
				<label><div class="gridlable" style="margin-top: 0px;">Package&nbsp;Code<span class="redmind"></span></div>
				<input name="packageCode" type="text" class="gridfield" id="packageCode" value="<?php echo $packageCode; ?>" displayname="Package Code" autocomplete="off"  onkeydown="searchSubPackage();" onkeyup="searchSubPackage();" />
			</label>
			<div id="getSubPackage" style="display:none;position: absolute;background-color: rgb(245, 245, 245);border: 0px solid rgb(204, 204, 204);z-index: 99;top: 55px;left: 0px;width: 100%;overflow: auto;max-height: 240px;box-shadow: inset rgb(216 210 210) 0px 0px 0px 1px;"></div>
			<script>
			function searchSubPackage(){
				var keyword = encodeURIComponent($('#packageCode').val());
				$('#getSubPackage').load('getSubPackageList.php?keyword='+keyword);
				$('#getSubPackage').show();
			}
			</script>
		</div>
	</td>
</tr>
<tr id="PackageNameDiv" style="display:none">
	<td colspan="2">
		<div class="griddiv" style="width:100%; position:relative;display:block; overflow:visible;">
			<label><div class="gridlable" style="margin-top: 0px;">Package&nbsp;Name<span class="redmind"></span></div>
			<input name="subName" type="text" class="gridfield"  value="<?php echo $quotationSubject; ?>" displayname="Package&nbsp;Name" autocomplete="off" />
		</label>
	</div>
</td>
</tr>

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
<div class="griddiv" id="selectclientbox" style="display:<?php if($clientType!=''){ ?>block<?php } else { ?>none<?php } ?>; overflow:visible;"><img src="images/companyicon.png" width="30" height="30" class="selectCompanypop" onclick="addclientfromquery();" />
	<label>
		<script>

		function addclientfromquery(url,poupwidth){
			var clienttype = $("#clientType").val();
			query_alertbox('action=addAgentClienttoQuery&actionType=addserviceagentclient&clientType='+clienttype,'700px','auto')
		}

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
				if(clientType==2){
					$('#agentb2cnumber').removeClass('validate');
					$('#contactpersonnamespan').text('Contact Person');
					$('#agentTypeDiv').text('B2C');
					$('#agentTypeemail').text('B2C Email');
					$('#agentTypemobile').text('B2C Mobile No');
				}else{
					// condition changed here ================================
					// if(clientType==1){
					$('#agentb2cnumber').addClass('validate');
					$('#contactpersonnamespan').text('Agent');
					$('#agentTypeDiv').text('Agent');
					$('#agentTypeemail').text('Agent Email');
					$('#agentTypemobile').text('Agent Mobile No');
					// }
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
		// Condition changed here ============== 
		if($clientType==2 && $editcompanyId!='' && $editcompanyId!='0' && $_REQUEST['incomingid']==''){ 
			$select2='*'; 
			$where2='id="'.$editcompanyId.'"'; 
			$rs2=GetPageRecord($select2,_CONTACT_MASTER_,$where2); 
			$contantnamemain=mysqli_fetch_array($rs2); 
			$clientnemdisplay = $contantnamemain['firstName'].' '.$contantnamemain['lastName']; 
			$clientnem = $contantnamemain['firstName'].' '.$contantnamemain['lastName']; 
			$getphone =  getContactPersonPhone($contantnamemain['id'],'contacts'); 
			$getemail =  getContactPersonEmail($contantnamemain['id'],'contacts');
		}elseif($editcompanyId!='' && $editcompanyId!='0' && $_REQUEST['incomingid']==''){ 
			$select2='*'; 
			$where2='id="'.$editcompanyId.'"'; 
			$rs2=GetPageRecord($select2,_CORPORATE_MASTER_,$where2); 
			$contantnamemain=mysqli_fetch_array($rs2); 
			$clientnem = getCorporateCompany($editcompanyId); 
			$clientnemdisplay = getContactPersonName($contantnamemain['id'],"corporate"); 
			$getemail = getContactPersonEmail($contantnamemain['id'],"corporate"); 
			$getphone = getContactPersonPhone($contantnamemain['id'],"corporate"); 
			$editcompanyId=($editcompanyId);
		}else{

		}
		?>
		<div class="gridlable"><c id="agentTypeDiv">Name</c><span class="redmind"></span></div>
		<div style="width:100%; position:relative;">
			<input name="companyName" placeholder="Company, Email, Phone, Contact Person" type="text" class="gridfield validate" id="companyName" value="<?php echo $clientnem; ?>" displayname="Company" autocomplete="off"  onkeydown="searchcompanynamefuncCompany();" onkeyup="searchcompanynamefuncCompany();" />
			<div id="getcompanyName" class="mainSearchBox"></div>
		</div>
		<script>
		function searchcompanynamefuncCompany(){
			var searchcompanyname = encodeURIComponent($('#companyName').val());
			var clientType = encodeURIComponent($('#clientType').val());
			if(clientType!='' && clientType!='0'){
				$('#getcompanyName').load('getcompanyName.php?clientType='+clientType+'&searchcompanyname='+searchcompanyname);
			}
			$('#getcompanyName').show();
		}
		function selectCorporateCompany(name,contactPId,b2cname,email,phone,id,opsPerson,opsPersonId,salesPerson,language,marketType,marketId,nationality,nationId,tourTypeId,ISOId,consortiaId){
			$('#subject').val('<?php echo date('d-m-Y'); ?> '+name);
			$('#companyName').val(name);
			$('#contactPId').val(contactPId);
			$('#agentb2cname').val(b2cname);
			$('#Preferredlanguage').val(language);
			$('#nationality').val(nationality);
			$('#nationId').val(nationId);
			$('#agentb2cmail').val(email);
			$('#marketType').val(marketType);
			$('#marketId').val(marketId);
			$('#tourType').val(tourTypeId);
			$('#agentb2cnumber').val(phone);
			$('#companyId').val(id);
			$('#salesassignTo').val(salesPerson);
			$('#ISOId').val(ISOId);
			$('#consortiaId').val(consortiaId);

			if(opsPerson!=''){
				$('#ownerName').val(opsPerson);
				$('#assignTo').val(opsPersonId);
			}else {
				$('#ownerName').val('');
				$('#assignTo').val('');
			}
			$('#getcompanyName').hide();
		}
		//ned to hide if clicked out of the box
		$(document).mouseup(function (e){
		    var container = $(".mainSearchBox");
		    // ... if the target of the click isn't a link ...
	        // ... or the container ...
	        // ... or a descendant of the container
		    if (!$("a").is(e.target) && !container.is(e.target) && container.has(e.target).length === 0){
		        container.hide();
		    }
		});
		</script>
		<input name="companyId" type="hidden" id="companyId" value="<?php echo encode($editcompanyId); ?>" />
		<input type="hidden" name="contactPId" id="contactPId" value="<?php echo $editcontactPId; ?>">
		<input name="addnewcontactmain" type="hidden" id="addnewcontactmain" value="0" />
	</label>
</div>
</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="banumber" style="display:<?php if($clientType!=''){ ?>block<?php } else { ?>none<?php } ?>; ">
<tr>
<td width="50%"><div class="griddiv"><label>
<div class="gridlable" >
	<c id="contactpersonnamespan">Contact Person </c>
</div>
<input name="agentb2cname" type="text" class="gridfield" id="agentb2cname"  displayname="Contact Person" value="<?php echo $clientnemdisplay.$clientnemdisplayfrommail; ?>" />
</label>
</div></td>
<td width="50%"><div class="griddiv" ><label>
<div class="gridlable" >Phone/Mobile Number</div>
<input name="agentb2cnumber" type="text" class="gridfield" id="agentb2cnumber"  displayname="Phone/Mobile" value="<?php echo $getphone;  ?>" />
</label>
</div></td>
</tr>
<tr>
<td colspan="2">
<div class="griddiv" id="baemail" ><label>
<div class="gridlable" >Email Address<span class="redmind"></span></div>
<input name="agentb2cmail" type="email" class="gridfield" id="agentb2cmail"  displayname="Email" value="<?php echo $getemail; ?>" required />
</label>
</div>
</td>
</tr>
<tr>
<td width="50%"><div class="griddiv"><label>
<div class="gridlable" >
<c id="contactpersonnamespan">Market Type </c>
</div>
<input name="marketType" type="text" class="gridfield" id="marketType" readonly  displayname="Market Type"   value="<?php echo $marketType; ?>" />
<input name="marketId" type="hidden" id="marketId" value="<?php echo $marketId; ?>" />
</label>
</div></td>
<td width="50%"><div class="griddiv" ><label>
<div class="gridlable" >Nationality</div>
<input name="nationality" type="text" class="gridfield" id="nationality" readonly displayname="Nationality"  value="<?php echo $nationality; ?>" />
<input name="nationId" type="hidden" id="nationId" value="<?php echo $nationId; ?>" />
</label>
</div></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
<tr>
<td colspan="2">
<div class="griddiv" ><label>
<div class="gridlable">Lead&nbsp;Pax&nbsp;Name</div>
<input 23>
</label>
</div>
</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
<tr>
<td colspan="2">
<div class="griddiv"><label>
<div class="gridlable">Subject <span class="redmind"></span></div>
<input name="subject" type="text" class="gridfield validate" id="subject" value="<?php echo $editsubject; echo ($subName!='')? " | ".$subName :''; ?>"  displayname="Subject" maxlength="250" />
</label>
</div>
</td>
</tr>
</table>
<table width="100%" border="0" class="griddiv" cellpadding="0" cellspacing="0" style=" " id="paxCountId">
<tr>
<td width="25%" align="left" valign="top"><label >
<div class="gridlable">Adult<span class="redmind"></span></div><input name="adult" type="text" class="gridfield validate" onKeyUp="numericFilter(this);" id="adult" displayname="Adult" value="<?php echo $editresult['adult']; ?>" maxlength="3"   /></label><?php if($queryType ==3){ echo $rmadult; } ?></td>
<td width="25%" align="left" valign="top"><label style=" position: relative; ">
<div class="gridlable">Child</div>
<input name="child" type="text" class="gridfield" id="child" onKeyUp="numericFilter(this);showcwbroom();" displayname="Child" value="<?php echo $editresult['child']; ?>" maxlength="3" /> </label><?php if($queryType ==3){ echo $rmchild; } ?></td>
<td width="25%" align="left" valign="top">
<label style="display:none">
<div class="gridlable">Infant</div>
<input name="infant" type="text" class="gridfield" id="infant" onKeyUp="numericFilter(this);" displayname="Infant" value="<?php echo $infant; ?>" maxlength="3" />
</label></td>
</tr>
</table>

<table width="100%" border="0" class="griddiv" cellpadding="0" cellspacing="0" style=" " id="roomTypeId">
	<tr>
		<td align="left" colspan="3" valign="top">SGL Room </td>
		<td align="left" colspan="3" valign="top">DBL Room</td>
	</tr>
	<tr>
		<td align="left" colspan="3" valign="top"><input name="sglRoom" type="text" class="gridfield mb5 numeric" id="sglRoom" value="<?php echo $editresult['sglRoom']; ?>" maxlength="3">
			<?php if($queryType ==3){ echo $rmsglRoom; } ?>
		</td>
		<td align="left" colspan="3" valign="top"><input name="dblRoom" type="text" class="gridfield mb5 numeric" id="dblRoom" value="<?php echo $editresult['dblRoom']; ?>" maxlength="3">
			<?php if($queryType ==3){ echo $rmdblRoom; } ?>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="2" valign="top">TWIN Room</td>
		<td align="left" colspan="2" valign="top">TPL Room</td>
		<td align="left" colspan="2" valign="top">ExtraBed(A)</td>
	</tr>
	<tr>
		<td align="left" colspan="2" valign="top"><input name="twinRoom" type="text" class="gridfield mb5 numeric" id="twinRoom" value="<?php echo $editresult['twinRoom']; ?>" maxlength="3">
			<?php if($queryType ==3){ echo $rmtwinRoom; } ?>
		</td>
		<td align="left" colspan="2" valign="top"><input name="tplRoom" type="text" class="gridfield mb5 numeric" id="tplRoom" value="<?php echo $editresult['tplRoom']; ?>" maxlength="3">
			<?php if($queryType ==3){ echo $rmtplRoom; } ?>
		</td>
		<td align="left" colspan="2" valign="top"><input name="extraNoofBed" type="text" class="gridfield mb5 numeric" id="extraNoofBed" value="<?php echo $editresult['extraNoofBed']; ?>" maxlength="3">
			<?php if($queryType ==3){ echo $rmextraNoofBed; } ?>
		</td> 
	</tr>
	<tr>
		<td align="left" colspan="3" valign="top"><div class="showcwbroom">CWBed</div></td>
		<td align="left" colspan="3" valign="top"><div class="showcwbroom">CNBed</div></td>
	</tr>
	<tr>
			<td align="left" colspan="3" valign="top">
				<div class="showcwbroom"><input name="cwbRoom" type="text" class="gridfield mb5 numeric" id="cwbRoom" value="<?php echo $editresult['cwbRoom']; ?>" maxlength="3" onkeyup="balanceCWB(this.value)">
					<?php if($queryType ==3){ echo $rmcwbRoom; } ?>
				</div></td>
			<td align="left" colspan="3" valign="top">
				<div class="showcwbroom">
					<input name="cnbRoom" type="text" class="gridfield mb5 numeric" id="cnbRoom" value="<?php echo $editresult['cnbRoom']; ?>" maxlength="3" onkeyup="balanceCNB(this.value)">
					<?php if($queryType ==3){ echo $rmcnbRoom; } ?>
				</div>
				</td>
		</tr>
</table>
<table width="100%" border="0" cellpadding="4" cellspacing="0"  id="childfielddiv" style="display:none; ">
	<tr> 
	<script>
	  	function showcwbroom(){
	  		var child = $('#child').val();
	  		if(child == 0 || child == ''){
	  		  $('.showcwbroom').css("display","none");
	  		}else{
	  			// appendchildage(0);
	  			$('#cwbRoom').val(child);
	  			$('.showcwbroom').css("display","block");
	  		}
	  	}
	  	showcwbroom();

	  	function balanceCWB(child){
	  		var totalChild = parseInt($('#child').val());
	  		if(totalChild < child){
	  			alert('Max limit is '+totalChild);
	  			$('#cwbRoom').val(totalChild);
	  			$('#cnbRoom').val(0);
	  		}else{
	  			$('#cnbRoom').val(totalChild-child);
	  		}
	  	}
	  	function balanceCNB(child){
	  		var totalChild = parseInt($('#child').val());
	  		if(totalChild < child){
	  			alert('Max limit is '+totalChild);
	  			$('#cnbRoom').val(totalChild);
	  			$('#cwbRoom').val(0);
	  		}else{
	  			$('#cwbRoom').val(totalChild-child);
	  		}
	  	}

		var childnumber=1;
		function appendchildage(no){
		   	$('.childagedivchilds').html('');
			var child=$('#child').val();
			if(child>0){
				$('#childfielddiv').show();
			}else{
				$('#childfielddiv').hide();

			}
			for(c=1;c<=child; c++){
		  		$('#childagediv').append('<div style="float:left; margin-right:5px;margin-bottom:8px; width:24%;"><label><div class="gridlable" style="width:100%;">Child '+c+' Age</div><input name="childrensage[]" type="text" class="gridfield childage" id="childrensage'+c+'"  displayname="Child'+c+' Age"  onKeyUp="numericFilter(this);calculateage('+c+');"  maxlength="2" value="<?php echo $age1; ?>" placeholder="Max Age 12 Years"/></label></div>');

			}
	  		childnumber++; 
		}

	  function calculateage(id){

	  var childrensage = $('#childrensage'+id).val();

	  if(childrensage>12){

	  alert('Child age should not be greater than 12 years');

	  $('#childrensage'+id).val('');

	  }

	  }

	  </script>

		<td style="padding-left:0px;" id="childagediv" class="childagedivchilds">	</td>

	  </tr>

</table>

</div>
</td>
<td width="36%" align="left" valign="top" style="padding-left:0px;">
<div style="background-color:#f5f5f5; padding:10px; border:1px #ccc solid; cursor:pointer;" onclick="$('#showmorefield2').toggle();">Query Plan Itinerary </div>
<div style=" border:1px #ccc solid; padding:10px;border-top:0px;display:block; " >
<table width="100%" border="0" cellpadding="0" cellspacing="0"   <?php if($_REQUEST["id"] != "" && isset($_REQUEST["id"])){ ?>  style="display:none;" <?php } ?>>
<tr>
<td colspan="4" align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="40%"><label><select name="dayWise" id="dayWise"  class="gridfield" onchange="changedatetr();" style="padding:10px; width:100%; border:1px solid #ccc; box-sizing:border-box; margin-bottom:10px;">
<option value="1" <?php if(1==$dayWise){ ?>selected="selected"<?php } ?>>Date Wise</option>
<option value="2" <?php if(2==$dayWise){ ?>selected="selected"<?php } ?>>Day Wise</option>
</select> </label></td>
<td width="30%"><label style="display:none;" class="sesonshow">
<select name="seasonType" id="seasonType"  class="gridfield" style="padding:10px; width:100%; border:1px solid #ccc; box-sizing:border-box; margin-bottom:10px;">
<option value="1" <?php if(1==$seasonType){ ?>selected="selected"<?php } ?>>Summer</option>
<option value="2" <?php if(2==$seasonType){ ?>selected="selected"<?php } ?>>Winter</option>
<option value="3" >Both Season</option>
</select>
</label> </td>
<td width="30%"><label style="display:none;" class="sesonshow">
<?php
$starting_year  = date('Y');
$ending_year    = 2040;
for($starting_year; $starting_year <= $ending_year; $starting_year++) {
if(date('Y',strtotime($editresult['seasonYear'])) == $starting_year ){ $seleted = "selected"; }else{ $seleted = ""; }
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
<td align="left" valign="top" class="datetr" <?php if($dayWise==2){ ?> style="display:none;"<?php } ?>><div class="griddiv">
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
<td width="33%" align="left" valign="top" class="datetr"  <?php if($dayWise==2){ ?> style="display:none;"<?php } ?>><div class="griddiv">
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
var quotationId = $('#quotationId').val();
var isEditable = <?php if($_REQUEST["id"] != "" && isset($_REQUEST["id"])){ echo "0"; } else{ echo "1"; } ?>;
if( ( fromDate != toDate &&  dayWise == 1 ) || ( dayWise == 2 && nights > 0) ){
$('#generateQueryDays').load('generateQueryDays.php?action=generateQueryDays&queryId=<?php echo $lastqueryidmain;?>&seasonYear='+seasonYear+'&seasonType='+seasonType+'&nights='+nights+'&isEditable='+isEditable+'&dayWise='+dayWise+'&quotationId='+quotationId+'&fromDate='+fromDate+'&toDate='+toDate);
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
	// direction: true,
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
// function getgitorfit(){
	// 	var adult = Number($('#adult').val());
	// 	var child = Number($('#child').val());
	// 	var totalPax = adult+child;
	// 	var queryType = $('#queryType').val();
	// 	if(totalPax>8){
		// 		alert('This is a GIT query.');
		// 		// $('#paxType').val('1');
		// 		gitcodefun();
	// 	}
	// 	if(adult>20){
		// 		alert('Maximum Limit is 20');
		// 		$('#adult').val('20');
	// 	}
// }
// gitcodefun();
function gitcodefun(){
	var queryType = Number($('#queryType').val());
	if(queryType==1){
		// alert(queryType);
		// document.getElementById('gitgroupcode').style.display='none';
		$('#gitgroupcode').hide();
		$('#discountslabouter').hide();
		$('#gitgroupName').hide();
		$('#discountSlabs').val('');
		//SERIES BLOCK
		$('#seriesCodeDiv').hide();
		$('#seriesNameDiv').hide();
		$('#seriesCode').removeClass('validate');
		$('#subSeriesName').removeClass('validate');
		//FD BLOCK
		$('#FDCodeDiv').hide();
		$('#FDNameDiv').hide();
		$('#FDCode').removeClass('validate');
		$('#subFDName').removeClass('validate');
		//Package BLOCK
		$('#PackageCodeDiv').hide();
		$('#PackageNameDiv').hide();
		$('#PackageCode').removeClass('validate');
		$('#subPackageName').removeClass('validate');
		$('#duplicateQuery').hide();
		//paxType
		$('#paxCodeDiv').show();
	} else if(queryType==2){
		//SERIES BLOCK
		$('#seriesCode').addClass('validate');
		$('#subSeriesName').addClass('validate');
		$('#seriesNameDiv').show();
		$('#seriesCodeDiv').show();
		//FD BLOCK
		$('#FDCodeDiv').hide();
		$('#FDNameDiv').hide();
		$('#FDCode').removeClass('validate');
		$('#subFDName').removeClass('validate');
		
		//Package BLOCK
		$('#PackageCodeDiv').hide();
		$('#PackageNameDiv').hide();
		$('#PackageCode').removeClass('validate');
		$('#subPackageName').removeClass('validate');
		
		$('#gitgroupcode').hide();
		$('#discountslabouter').hide();
		$('#gitgroupName').hide();
		$('#discountSlabs').val('1');
		$('#duplicateQuery').hide();

		$('#paxCodeDiv').hide();
	} else if(queryType==3){
		//SERIES BLOCK
		$('#seriesCode').removeClass('validate');
		$('#subSeriesName').removeClass('validate');
		$('#seriesNameDiv').hide();
		$('#seriesCodeDiv').hide();
		//FD BLOCK
		$('#FDCodeDiv').show();
		$('#FDNameDiv').show();
		$('#FDCode').addClass('validate');
		$('#subFDName').addClass('validate');
		
		//Package BLOCK
		$('#PackageCodeDiv').hide();
		$('#PackageNameDiv').hide();
		$('#PackageCode').removeClass('validate');
		$('#subPackageName').removeClass('validate');
		
		$('#gitgroupcode').hide();
		$('#discountslabouter').hide();
		$('#gitgroupName').hide();
		$('#discountSlabs').val('1');
		$('#duplicateQuery').hide();

		$('#paxCodeDiv').hide();
	} else if(queryType==4){
		//SERIES BLOCK
		$('#seriesCode').removeClass('validate');
		$('#subSeriesName').removeClass('validate');
		$('#seriesNameDiv').hide();
		$('#seriesCodeDiv').hide();
		//FD BLOCK
		$('#FDCodeDiv').hide();
		$('#FDNameDiv').hide();
		$('#FDCode').removeClass('validate');
		$('#subFDName').removeClass('validate');
		
		//Package BLOCK
		$('#PackageCodeDiv').show();
		$('#PackageNameDiv').show();
		$('#PackageCode').addClass('validate');
		$('#subPackageName').addClass('validate');
		
		$('#gitgroupcode').hide();
		$('#discountslabouter').hide();
		$('#gitgroupName').hide();
		$('#discountSlabs').val('1');
		$('#duplicateQuery').hide();

		$('#paxCodeDiv').hide();
	}else if(queryType==5){
		$('#duplicateQuery').show();
		$('#gitgroupcode').hide();
		$('#discountslabouter').hide();
		$('#gitgroupName').hide();
		$('#discountSlabs').val('');
		//SERIES BLOCK
		$('#seriesCodeDiv').hide();
		$('#seriesNameDiv').hide();
		$('#seriesCode').removeClass('validate');
		$('#subSeriesName').removeClass('validate');
		//FD BLOCK
		$('#FDCodeDiv').hide();
		$('#FDNameDiv').hide();
		$('#FDCode').removeClass('validate');
		$('#subFDName').removeClass('validate');
		//Package BLOCK
		$('#PackageCodeDiv').hide();
		$('#PackageNameDiv').hide();
		$('#PackageCode').removeClass('validate');
		$('#subPackageName').removeClass('validate');
		
		//paxType
		$('#paxCodeDiv').show();
		}else {
		//SERIES BLOCK
		$('#seriesCode').removeClass('validate');
		$('#subSeriesName').removeClass('validate');
		$('#seriesCodeDiv').hide();
		$('#seriesNameDiv').hide();
		//FD BLOCK
		$('#FDCodeDiv').hide();
		$('#FDNameDiv').hide();
		$('#FDCode').removeClass('validate');
		$('#subFDName').removeClass('validate');
		
		//Package BLOCK
		$('#PackageCodeDiv').hide();
		$('#PackageNameDiv').hide();
		$('#PackageCode').removeClass('validate');
		$('#subPackageName').removeClass('validate');
		
		$('#gitgroupcode').hide();
		$('#discountslabouter').hide();
		$('#gitgroupName').hide();
		$('#discountSlabs').val('1');
		
		$('#paxCodeDiv').hide();
	}
}

</script>


<div class="griddiv" id="gitgroupcode"  style="display:none;" ><label>
<div class="gridlable" style="width:100%;">Group Code  </div>
<input name="groupCode" type="text" class="gridfield" id="groupCode" value="<?php echo $editresult['groupCode']; ?>"/>
</label>
</div>
<div class="griddiv" id="gitgroupName"  style="display:none;" ><label>
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

<!-- Entered Code Here need to Make dynamic-->
<td style="padding-top:14px ;" width="50%"><div class="griddiv"><label>
<div class="gridlable" >
<c id="budget">Budget </c>
</div>
<input name="budget" type="number" class="gridfield" id="budget"  displayname="Budget"   value="<?php echo $budgetCost; ?>" />
</label>
</div></td>
<!-- Entered code here ends by me -->

<td width="50%" align="left" valign="top"><div class="griddiv" style="margin-top: 14px;"><label><div class="gridlable">&nbsp;&nbsp;Preferred&nbsp;Language</div>
<select id="preferredLang" name="preferredLang" class="gridfield" displayname="Preferred Language" autocomplete="off"   >
<?php
$rs='';
$rs=GetPageRecord('*','tbl_languagemaster',' deletestatus=0  order by name asc');
while($resListing=mysqli_fetch_array($rs)){
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editpreferredLang){ ?>selected="selected"<?php }else if($resListing['id']=='1'){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select>
</label>
</div></td>


</tr>
<tr id="isoandsonsortiarow">
	<td>
		<div class="griddiv">
			<label>
				<div class="gridlable w100">ISO</div>
				<div id="selectOpsPerson">
					<select id="ISOId" name="ISOId" class="gridfield "  displayname=" ISO"  autocomplete="off"  style="padding: 9px; height: 37px;">
						<option value="">Select ISO</option>
						<?php
						
						$wherei='status="1" and deletestatus="0" and type="iso" and bussinessType="21"'; 
						$rsiso=GetPageRecord('*',_CORPORATE_MASTER_,$wherei);
						while($isoresult=mysqli_fetch_array($rsiso)){
						?>
						<option value="<?php echo strip($isoresult['id']); ?>" <?php if($isoresult['id']==$editresult['ISOId']){ ?>selected="selected"<?php } ?>><?php echo strip($isoresult['name']); ?></option>
						<?php } ?>
					</select>
				</div>
			</label>
		</div>
	</td>
	<td >
		<div class="griddiv"><label>
		<div class="gridlable w100">Consortia</div>
		<select id="consortiaId" name="consortiaId" class="gridfield"  displayname="Cosortia"  autocomplete="off"  style="padding: 9px; height: 37px;"> 
			<option value="">Select Consortia</option>
			<?php   

			$whereC='status="1" and deletestatus="0" and type="consortia" and bussinessType="22"'; 
			$cosortia=GetPageRecord('*',_CORPORATE_MASTER_,$whereC); 
			while($cosortiares=mysqli_fetch_array($cosortia)){  
			?>
	      	<option value="<?php echo $cosortiares['id']; ?>" <?php if($cosortiares['id']==$editresult['consortiaId']){ ?>selected="selected"<?php } ?>><?php echo strip($cosortiares['name']); ?></option>
	      <?php } ?>
	    </select></label>
		</div>
	</td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">

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
<tr>


<td width="50%" align="left" valign="top"><div class="griddiv">
<label>
	<!-- set priority for query normal by default -->
<div class="gridlable">Priority</div>
<select id="queryPriority" name="queryPriority" class="gridfield"  autocomplete="off" >
<option value="3">High</option>
<option value="2" >Medium</option>
<option value="1" selected="selected">Normal</option>
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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>

<td width="50%" align="left" valign="top"><div class="griddiv"><label><div class="gridlable">Tour Type <span class="redmind"></span></div>

<select id="tourType" name="tourType" class="gridfield validate" displayname="Tour Type" autocomplete="off"   >
<?php
$rs=GetPageRecord('*',_TOUR_TYPE_MASTER_,' deletestatus=0 and status=1 order by name asc');
while($resListing=mysqli_fetch_array($rs)){
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$edittourType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
</div></td>
<td width="50%" align="left" valign="top"><div class="griddiv">
<label><div class="gridlable">Hotel Category  </div>

<select id="hotelAccommodation" name="hotelAccommodation" class="gridfield" displayname="Hotel Category" autocomplete="off"   >
<option value="0" >All</option>
<?php
$hotelCatQuery='';
$hotelCatQuery=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,'  deletestatus=0 and status=1 order by hotelCategory asc');
while($hotelCategoryData=mysqli_fetch_array($hotelCatQuery)){
?>
<option value="<?php echo strip($hotelCategoryData['id']); ?>" <?php if($hotelCategoryData['id']==$editresult['hotelAccommodation']){ ?> selected="selected" <?php } ?> ><?php echo strip($hotelCategoryData['hotelCategory']); ?> Star</option>
<?php } ?>

</select></label>

</div></td>


</tr>

</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>


<td width="50%" align="left" valign="top"><div class="griddiv"><label><div class="gridlable">Meal Plan<span class="redmind"></span></div>

<select id="mealPlanId" name="mealPlanId" class="gridfield " displayname="Meal Plan" autocomplete="off"   >
<option value="0" >All</option>
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
<option value="<?php echo strip($resListing['id']); ?>" <?php if($editresult['mealPlanId']==$resListing['id']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
</div></td>

<!-- Hotel Type code started -->

<td width="50%" align="left" valign="top"><div class="griddiv"><label>
	<div class="gridlable">Hotel&nbsp;Type</div>
 	<select id="hotelTypeId" name="hotelTypeId" class="gridfield" autocomplete="off"  displayname="Hotel Type"  > 
		<option value="0">All</option>
	<?php 
	$rs3=''; 
	$rs3=GetPageRecord('*','hotelTypeMaster',' 1 and deletestatus=0 and status=1 order by name asc');  
	while($hotelTypeData=mysqli_fetch_array($rs3)){
	?>
	<option value="<?php echo $hotelTypeData['id'];?>" <?php if($hotelTypeData['id']==$editresult['hotelTypeId']){ ?>selected="selected"<?php } ?>>
	<?php echo $hotelTypeData['name'];?></option> 
	<?php 
	} 
	?>
	</select>
	</label>
	</div></td>
<!-- Hotel Type code ended -->

</tr>

</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
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
<td width="50%" align="left" valign="top">
<div class="griddiv"><label><div class="gridlable" style="margin-left: 10px !important;">Vehicle Prefrence </div>
<select id="vehicleId" style="width:100%"  name="vehicleId" class="gridfield"  autocomplete="off">
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
<!--Add More Emails -->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
<tr>

<!-- flight requered code started -->
<td colspan="2">
<div class="griddiv" style="margin-top: 14px;"><label>
<div class="gridlable" style="width:20%;">Flight Required</div>
<input name="flight" type="text" class="gridfield" id="flight" placeholder=""   value="No"/>
</label>
</div>
</td>
<!-- flight requered code ended -->

<td colspan="2">
<div class="griddiv"><label>
<div class="gridlable" style="width:80%;">Add More Emails  (Comma Separated Emails)   </div>
<input name="multiemails" type="text" class="gridfield" id="multiemails" placeholder="test@example.com,test@example.com"   value="<?php echo $multiemails; ?>"/>
</label>
</div>
</td>
</tr>
</table>
<!--Additional Information-->
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
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
<input type="hidden" name="moduleType" value="1"/>
<input type="hidden" name="attachitinerary" value="1"/>
<input type="hidden" name="calculationType" value="1"/>
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
<div style="display:none;" id="discountslabouter">
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