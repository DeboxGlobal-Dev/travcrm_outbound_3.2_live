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
	$where1='id="'.$leadId.'" '; 
	$rs1=GetPageRecord($select1,'leadManageMaster',$where1); 
	$resultlists=mysqli_fetch_array($rs1);
	$editcompanyId=clean($resultlists['companyId']); 
	$clientType=$resultlists['clientType']; 

	$OpsAssignTo=clean($editresult['OpsAssignTo']);

	$salesPersonId=clean($editresult['salesPersonId']);
	$salesassignTo=clean($editresult['assignTo']);
	if($clientType==2){
	$select2='*';  
	$where23='id="'.$editcompanyId.'"'; 
	$rs22=GetPageRecord($select2,_CONTACT_MASTER_,$where23); 
	$contantnamemain=mysqli_fetch_array($rs22);

	$drs=GetPageRecord('name','nationalityMaster','1 and id="'.$contantnamemain['nationality'].'"'); 
	$nationName=mysqli_fetch_array($drs); 
	$nationality = $nationName['name'];

	$drs=GetPageRecord('name','marketMaster','1 and id="'.$contantnamemain['marketType'].'"'); 
	$marketName=mysqli_fetch_array($drs); 
	$marketType = $marketName['name'];

	$clientnem = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];
	$getphone =  getPrimaryPhone($contantnamemain['id'],'contacts');
	$getemail =  getPrimaryEmail($contantnamemain['id'],'contacts'); 
	}
	if($clientType!=2){ 
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

	$clientnem = getCorporateCompany($editcompanyId);
	$getemail = getPrimaryEmailCompany($editcompanyId,"corporate");
	$getphone = getPrimaryPhoneCompany($editcompanyId,"corporate");
	 
	}
}

if($_REQUEST['id']!=''){

	$id=clean(decode($_REQUEST['id']));

	$select1='*';

	$where1='id="'.$id.'"';

	$rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1);

	$editresult=mysqli_fetch_array($rs1);
 
	$OpsAssignTo=clean($editresult['assignTo']);
	$salesPersonId=clean($editresult['salesPersonId']);

	
	$salesassignTo=clean($editresult['salesassignTo']);
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
 

	$earlyCheckin=clean($editresult['earlyCheckin']);
	
	$budgetCost=clean($editresult['expectedSales']); //query for edit here

	$editqueryCloseDetails=clean($editresult['queryCloseDetails']);

	$editqueryCloseDate=clean($editresult['queryCloseDate']);

	$editmultiemails=clean($editresult['multiemails']);

	$editqueryStatus=clean($editresult['queryStatus']);

	$quotationYes=clean($editresult['quotationYes']);

	$editattachmentFileclean=($editresult['attachmentFile']);

	$editremark=clean($editresult['remark']);

	$editqueryId=clean($editresult['queryId']);

	$editsubject=clean($editresult['subject']);

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
	
	$travelType = $editresult['travelType'];

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

	$drs=GetPageRecord('*','marketMaster','1 and id="'.$editresult['marketType'].'"'); 
	$nationName=mysqli_fetch_array($drs); 
	$marketType = $nationName['name'];
	$marketId = $nationName['id'];
}

if($editresult['closerDate']=='0000-00-00' || $closerDate==''){
	$closerDate='';
}

if($_REQUEST['id']=='' && $_REQUEST['leadId']==''){
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
		$rmsglRoom = $rmdblRoom = $rmtplRoom = $rmtwinRoom = $rmextraNoofBed = '<span style="font-size:13px;color:#233a49;">0 Room Available </span>';
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
		$rmextraNoofBedN = round($editresult['extraNoofBed']-$confQuotationData['extraNoofBed']);
		$rmcwbRoomN = round($editresult['cwbRoom']-$confQuotationData['childwithNoofBed']);
		$rmcnbRoomN = round($editresult['cnbRoom']-$confQuotationData['childwithoutNoofBed']);
	
		$colorsgl = ($rmsglRoomN > 0) ?'07ab04':'ff0000';
		$colordbl = ($rmdblRoomN > 0) ?'07ab04':'ff0000';
		$colortpl = ($rmtplRoomN > 0) ?'07ab04':'ff0000';
		$colortwin = ($rmtwinRoomN > 0) ?'07ab04':'ff0000';
		$colorEB = ($rmextraNoofBedN > 0) ?'07ab04':'ff0000';
		$colorcwb = ($rmcwbRoomN > 0) ?'07ab04':'ff0000';
		$colorcnb = ($rmcnbRoomN > 0) ?'07ab04':'ff0000';

		if($confQuotationData['cnt'] > 0 && $queryType==3){  
			$rmadult = '<span style="line-height: 2; font-size:13px;color:#'.$colorsgl.';">'.$rmadultN.' Available </span>';
			$rmchild = '<span style="line-height: 2; font-size:13px;color:#'.$colorsgl.';">'.$rmchildN.' Available </span>';
			$rmsglRoom = '<span style="line-height: 2; font-size:13px;color:#'.$colorsgl.';">'.$rmsglRoomN.' Available </span>';
			$rmdblRoom = '<span style="line-height: 2; font-size:13px;color:#'.$colordbl.';">'.$rmdblRoomN.' Available </span>';
			$rmtplRoom = '<span style="line-height: 2; font-size:13px;color:#'.$colortpl.';">'.$rmtplRoomN.' Available </span>';
			$rmextraNoofBed= '<span style="line-height: 2; font-size:13px;color:#'.$colorEB.';">'.$rmextraNoofBedN.' Available </span>';
			$rmtwinRoom= '<span style="line-height: 2; font-size:13px;color:#'.$colortwin.';">'.$rmtwinRoomN.' Available </span>';
			$rmcwbRoom= '<span style="line-height: 2; font-size:13px;color:#'.$colorcwb.';">'.$rmcwbRoomN.' Available </span>';
			$rmcnbRoom= '<span style="line-height: 2; font-size:13px;color:#'.$colorcnb.';">'.$rmcnbRoomN.' Available </span>';
		}else{
			$rmadult = '<span style="line-height: 2; font-size:13px;color:#'.$colorsgl.';">'.round($editresult['adult']).' Available </span>';
			$rmchild = '<span style="line-height: 2; font-size:13px;color:#'.$colorsgl.';">'.round($editresult['child']).' Available </span>';
			$rmsglRoom = '<span style="line-height: 2; font-size:13px;color:#'.$colorsgl.';">'.round($editresult['sglRoom']).' Available </span>';
			$rmdblRoom = '<span style="line-height: 2; font-size:13px;color:#'.$colordbl.';">'.round($editresult['dblRoom']).' Available </span>';
			$rmtplRoom = '<span style="line-height: 2; font-size:13px;color:#'.$colortpl.';">'.round($editresult['tplRoom']).' Available </span>';
			$rmextraNoofBed= '<span style="line-height: 2; font-size:13px;color:#'.$colorEB.';">'.round($editresult['extraNoofBed']).' Available </span>';
			$rmtwinRoom= '<span style="line-height: 2; font-size:13px;color:#'.$colortwin.';">'.round($editresult['twinRoom']).' Available </span>';
			$rmcwbRoom= '<span style="line-height: 2; font-size:13px;color:#'.$colorcwb.';">'.round($editresult['cwbRoom']).' Available </span>';
			$rmcnbRoom= '<span style="line-height: 2; font-size:13px;color:#'.$colorcnb.';">'.round($editresult['cnbRoom']).' Available </span>';
		}
	}
} 

if($_REQUEST['email']!='' && $_REQUEST['incomingid']==1){
		// Convert to query from email
	$subject = $_REQUEST['subjectdata'];
	$editdescription=trim($_REQUEST['bodydata']);
	$incomingid=clean($_REQUEST['incomingid']);

	$incomingQeuryId=clean($editresult['id']);

	// $editdescription=imap_qprint($editdescription);

	$editdescription = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $editdescription);
    $editdescription = str_replace('span','p',$editdescription);
    $editdescription = strip_tags($editdescription,"<p><br><b><strong><img>");
     
     
     
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
		$where1='masterId="'.trim($editcompanyId['id']).'"';
		$rs1=GetPageRecord($select1,'phoneMaster',$where1);
		$editresultphone=mysqli_fetch_array($rs1);
		$getphone = $editresultphone['phoneNo'];

		$drs=GetPageRecord('*','nationalityMaster','1 and id="'.$editresultContact['nationality'].'"'); 
		$nationName=mysqli_fetch_array($drs); 
		$nationality = $nationName['name'];
		$nationId = $nationName['id'];

		$drs=GetPageRecord('*','marketMaster','1 and id="'.$editresultContact['marketType'].'"'); 
		$nationName=mysqli_fetch_array($drs); 
		$marketType = $nationName['name'];
		$marketId = $nationName['id'];

		$clientType=2;

	}else{
		// check from agent Master
		$select1='*'; 
		$where1='email="'.encode(($email)).'" '; 
		$rs1=GetPageRecord($select1,'contactPersonMaster',$where1); 
		$editresultmail=mysqli_fetch_array($rs1); 
		if($editresultmail['corporateId']!=''){
			$select1='*';
			$where1='id="'.trim($editresultmail['corporateId']).'"';
			$rs1=GetPageRecord($select1,'corporateMaster',$where1);
			$editresultCorporate=mysqli_fetch_array($rs1);

			$editcompanyId = $editresultCorporate['id'];
			$clientnem = stripslashes($editresultCorporate['name']);
			$clientnemdisplay = $editresultmail['contactPerson'];
			$getemail = decode($editresultmail['email']);
			$getphone = decode($editresultmail['phone']);

			$OpsAssignTo=clean($editresultCorporate['OpsAssignTo']);
			$salesPersonId=clean($editresultCorporate['salesPersonId']);
			
			$salesassignTo=getUserName($editresultCorporate['assignTo']);

			$clientType=1;

			$drs=GetPageRecord('*','nationalityMaster','1 and id="'.$editresultCorporate['nationality'].'"'); 
			$nationName=mysqli_fetch_array($drs); 
			$nationality = $nationName['name'];
			$nationId = $nationName['id'];

			$drs=GetPageRecord('*','marketMaster','1 and id="'.$editresultCorporate['marketType'].'"'); 
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

<link href="css/main.css" rel="stylesheet" type="text/css" />

<div id="waitloaddest" style="display:none; top: 0px; left: 0px; background-color: #cccccc61; z-index: 9999; position: absolute; height: 100%; width: 100%;"><div style="width: 200px; margin: auto; margin-top: 14%; text-align: center; background-color: #fff; padding: 30px; border-radius: 4px; box-shadow: 0px 0px 5px #898484;">Please wait...</div></div>
<div id="addAgentfromquery" style="background-image: url('images/bgpop.png'); background-repeat: repeat;">
				<div class="loadaddagentfile"></div>
				</div>
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
  <input name="action" type="hidden" id="action" value="<?php if($_REQUEST['id']!='' && $moduleType==1){ echo 'editquery';} else { echo 'addquery'; } ?>" />
  <?php if($_REQUEST['id']=='' && $_REQUEST['incomingid']!=''){ ?>
  <input name="incomingqueryId" type="hidden" id="incomingqueryId" value="<?php echo $_REQUEST['incomingid']; ?>" />
  <?php } ?>
  <input name="savenew" type="hidden" id="savenew" value="0" />



  <table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td width="30%" align="left" valign="top" style="padding-right:20px;">
	
	<div style="background-color: white; padding:5px 0px 0px 20px;border: 1px #ccc solid;cursor: pointer;    border-top-right-radius: 5px;
    border-top-left-radius: 5px" onclick="$('#showmorefield1').toggle();">
	<img style="font-size: 14px;position: relative;top: 0px;height: 20px;" src="images/curriculum-dom.png"> 
	<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;color: hsl(33 95% 68% / 1);">Contact Information</span>

</div>

	<div style=" border:1px #ccc solid; padding:10px;border-top:0px; display:block; " >
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">


	
	  <input type="hidden" name="quotationId" id="quotationId" value="<?php echo $quotationId; ?>"/>
	  <tr id="duplicateQuery" style="display: none;">
		<td colspan="2">
		<div class="griddiv" style="width:100%; position:relative;display:block; overflow:visible;"><label>
			<div class="gridlable">Query&nbsp;ID</div>
				<input type="text" id="queryDuplicate" class="gridfield" name="queryDuplicate"  onkeydown="searchForDuplicateQuery();" onkeyup="searchForDuplicateQuery();">
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
	  <input type="hidden" name="onlyTFS" id="onlyTFS" value="0" />

	  <tr id="duplicateQuery" style="display: none;">
		<td colspan="2">
		<div class="griddiv" style="width:100%; position:relative;display:block; overflow:visible;"><label>
			<div class="gridlable">Query&nbsp;ID</div>
				<input type="text" id="queryDuplicate" class="gridfield" name="queryDuplicate"  onkeydown="searchForDuplicateQuery();" onkeyup="searchForDuplicateQuery();">
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
			<input name="FDCode" type="text" class="gridfield" id="FDCode" value="<?php echo $subName; ?>" displayname="FD Code" autocomplete="off"  onkeydown="searchSubFD();" onkeyup="searchSubFD();" /> 
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
			<input name="subName" type="text" class="gridfield"  value="<?php echo $editsubject; ?>" displayname="FD&nbsp;Name" autocomplete="off" /> 
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


	<!-- Started query type sec  -->
 	<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
	  <tr>
	  <td >
	<div class="griddiv">
		<label>
			<div class="gridlable" style="margin-top: 0px;font-size: 13px;padding-left: 5px;">Business Type<span class="redmind"></span></div>
		<!-- <select id="clientType" name="clientType" class="gridfield validate" displayname="Client Type" autocomplete="off"> -->
			<?php
			$rs='';
			$rs=GetPageRecord('*','businessTypeMaster',' deletestatus=0 and status=1 order by name asc');
			?>
			<div style="display: grid;grid-template-columns: auto auto;">
			<?php
			while($resListing1=mysqli_fetch_array($rs)){
			
				if($clientType!=''){
					$clientDefault = $clientType==$resListing1['id'];
				}else{
					$clientDefault = $resListing1['id']==1;
				}
			?>
			<div class="main-div-con">
			<div class="check_boxIndiv">
			<span class="check-box-title"> <?php echo ucfirst($resListing1['name']); ?></span>

			<input id="clientType" name="clientType" <?php if($clientDefault){ echo "checked"; } ?> class="check_box_input" type="radio" value="<?php echo strip($resListing1['id']); ?>" />
			
			</div>
			</div>

			<?php } ?>

			</div>
		<!-- </select> -->
	</label>
</div>
</td>
	  </tr>
	</table>
<!-- Ended query type sec  -->



	<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
	  <tr>
		<td colspan="2">
		  <div class="griddiv" id="selectclientbox" style="display:<?php if($clientType!=''){ ?>block<?php } else { ?>none<?php } ?>; overflow:visible;"><img src="images/companyicon.png" width="30" height="30" style="position:absolute; right:0px; cursor:pointer; right:4px; top:35px;" onclick="addclientfromquery();" />

			<label>

			<script>


			// function addclientfromquery(url,poupwidth){

			// 	var clienttype = $("input[type='radio'][name='clientType']:checked").val();
			
			// 	query_alertbox('action=addAgentClienttoQuery&actionType=addserviceagentclient&clientType='+clienttype,'700px','auto')
			// }

			function openselectCompanypop(){

			// var clientType1 = $('#clientType').val();

			var clientType1 = $("input[type='radio'][name='clientType']:checked").val();

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
			// Condition changed here ====================================================================
			if($clientType==2 && $editcompanyId!='' && $editcompanyId!='0' && $_REQUEST['incomingid']==''){
				
				$select2='*';
				
				$where2='id='.$editcompanyId.'';
				
				$rs2=GetPageRecord($select2,_CONTACT_MASTER_,$where2);
				
				$contantnamemain=mysqli_fetch_array($rs2);
				
				$clientnemdisplay = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];
				
				$clientnem = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];
				
				$getphone =  getPrimaryPhone($contantnamemain['id'],'contacts');
				
				$getemail =  getPrimaryEmail($contantnamemain['id'],'contacts');
			
			}elseif($editcompanyId!='' && $editcompanyId!='0' && $_REQUEST['incomingid']==''){
			
					$select2='*';
					
					$where2='id='.$editcompanyId.'';
					
					$rs2=GetPageRecord($select2,_CORPORATE_MASTER_,$where2);
					
					$contantnamemain=mysqli_fetch_array($rs2);
					
					$clientnem = getCorporateCompany($editcompanyId);
					
					$clientnemdisplay = getPrimaryNameCompany($editcompanyId,"corporate");
					
					$getemail = getPrimaryEmailCompany($editcompanyId,"corporate");
					
					$getphone = getPrimaryPhoneCompany($editcompanyId,"corporate");
					
					$editcompanyId=($editcompanyId);
				
				// }
			}
			
			

		?>

			<div class="gridlable">
				<c id="agentTypeDiv">
				<span style="font-size: 13px;">Name</span> <img style="position: relative;top: 3px;    right: -60px;width: 25px;" src="images/id-card-dom.png">
			</c><span class="redmind"></span></div>

			<div style="width:100%; position:relative;">

			<?php if($profileeeDataaaaa['agentOption']==1){ ?>
				<div style="padding:10px; background-color:#7a96ff; color:#fff; position:absolute; right:1px; top:4px; cursor:pointer;" onclick="addclientfromquery('action=addAgentClienttoQuery&actionType=addserviceagentclient','700px');">+Add</div>
			<?php } ?>

			<style>
				
		#addAgentfromquery {
		background-color: #00000094;
		background-color: rgba(50, 61, 76, 0.91);
		width: 100%;
		height: 100%;
		overflow: auto;
		display: none;
		z-index: 9999;
		/* height: 100%; */
		 position:fixed;
		  top:0px;
		 margin-top: 55px;
    	padding-top: 30px;
		
	}
	#addAgentfromquery .loadaddagentfile {
		/* background-color: #FFFFFF; */
		max-width: 1000px;
		margin: auto; 
		margin-bottom: 200px;
		overflow: auto;
	
	}
			</style>
			   
			<script>				

			function addclientfromquery(url,poupwidth){
				// var clienttype = $("#clientType").val();
				var clienttype = $("input[type='radio'][name='clientType']:checked").val();
				$("#addAgentfromquery").show();
					$(".loadaddagentfile").load('addagentfromQuery.php?'+url+'&clientType='+clienttype);
					$('.loadaddagentfile').css('width', poupwidth);

				// $('#selectclientbox').hide();

				// $('#companyName').removeClass('validate');

				// $('#agentb2cname').addClass('validate');



				// $('#agentb2cmail').addClass('validate');

				// $('#addnewcontactmain').val('1');

				// var clientType = $('#clientType').val();

				// if(clientType==1){

				// 	$('#agentb2cnumber').addClass('validate');

				// 	$('#contactpersonnamespan').text('Agent');

				// } else {

				// $('#contactpersonnamespan').text('Contact Person');

				// }

			}

			</script>

			<input name="companyName" type="text" class="gridfield validate" id="companyName" value="<?php echo $clientnem; ?>" placeholder="Company, Email, Phone, Contact Person"  displayname="Company" autocomplete="off"  onkeydown="searchcompanynamefuncCompany();" onkeyup="searchcompanynamefuncCompany();" />
 

			<div id="getcompanyName" style="display:none;position: absolute; background-color: #f5f5f5; border: 1px solid #ccc; z-index: 99; top: 39px; left: 0px; width: 100%; overflow: auto; max-height: 240px; box-shadow: 2px 2px 7px #0000003d;"></div>

			</div>

			<script>

			function searchcompanynamefuncCompany(){

			var searchcompanyname = encodeURIComponent($('#companyName').val());

			// var clientType = encodeURIComponent($('#clientType').val());
			var clientType = $("input[type='radio'][name='clientType']:checked").val();

			if(clientType!='' && clientType!='0'){

			$('#getcompanyName').load('getcompanyName.php?clientType='+clientType+'&searchcompanyname='+searchcompanyname);

			}

			$('#getcompanyName').show();

			}

			function selectCorporateCompany(name,email,phone,id,opsPerson,opsPersonId,nationality,language,salesPerson,salesPersonId,marketType,nationId,marketId,tourType){ 
				$('#subject').val('<?php echo date('d-m-Y'); ?> '+name); 
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
				$('#salesPersonId').val(salesPersonId);
				if(opsPerson!='' ){ 
					$('#ownerName').val(opsPerson); 
					$('#assignTo').val(opsPersonId); 
				}else { 
					$('#ownerName').val(''); 
					$('#assignTo').val(''); 
				} 
				$('#getcompanyName').hide(); 

			} 
			</script>

			<input name="companyId" type="hidden" id="companyId" value="<?php echo encode($editcompanyId); ?>" />
			<input name="addnewcontactmain" type="hidden" id="addnewcontactmain" value="0" />


			</label>

			</div>
		</td>
	  </tr>
	</table>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="banumber" style="display:<?php if($clientType!=''){ ?>block<?php } else { ?>none<?php } ?>; ">
 	  <tr>

		<td width="48%"><div class="griddiv" style="width: 95%;"><label>

		<div class="gridlable" >

		  <c id="contactpersonnamespan">Contact Person <img style="position: relative;top: 2px;right: -30px;height: 20px;width: 20px;" src="images/contact-book-dom.png"> </c>

		</div>

		<input name="agentb2cname" type="text" class="gridfield" id="agentb2cname"  displayname="Contact Person"   value="<?php echo $clientnemdisplay.$clientnemdisplayfrommail; ?>" />

		</label>

		</div></td>

		<td width="48%"><div class="griddiv" ><label>

		<div class="gridlable" >Contact Number <img style="position: relative;top: 2px;right: -30px;height: 20px;width: 20px;" src="images/viber-dom.png"></div>

		<input name="agentb2cnumber" type="text" class="gridfield" id="agentb2cnumber"  displayname="Phone/Mobile" value="<?php echo $getphone;?>" />

		</label>

		</div></td>

	  </tr>
	  <tr>
		<td colspan="2">
		<div class="griddiv" id="baemail" ><label>

		<div class="gridlable" style="font-size: 13px;">Email Address<img style="position: relative;top: 2px;right: -30px;height: 15px;width: 25px;" src="images/mail-dom.png"><span class="redmind"></span></div>

		<input name="agentb2cmail" type="email" class="gridfield" id="agentb2cmail"  displayname="Email"    value="<?php echo $getemail; ?>" required />

		</label>

		</div>

		</td>
	  </tr>

	  <!--Market Type and Nationality section hide design  -->
	  <tr style="display: none;">

		<td width="50%"><div class="griddiv"><label>

		<div class="gridlable" >

		  <c id="contactpersonnamespan">Market Type </c>

		</div>

		<input name="marketType" type="text" class="gridfield" id="marketType" readonly  displayname="Market Type"   value="<?php echo $marketType ?>" />

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

		<input name="guest1" type="text" class="gridfield"  id="guest1"  value="<?php echo $editresult['leadPaxName']; ?>" maxlength="100" />

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

		<input name="subject" type="text" class="gridfield validate" id="subject" value="<?php echo $editsubject; ?>"  displayname="Subject" maxlength="250" />

		</label>

		</div>
		</td>
	  </tr>
	  <tr>
		<td colspan="2">
		<div class="griddiv"><label>
		<div class="gridlable" style="width:80%; width:100%;font-size: 13px;">Add More Emails  (Comma Separated Emails)   </div>
		<input  name="multiemails" type="text" class="gridfield" id="multiemails" placeholder="test@example.com,test@example.com"   value="<?php echo $extramails; ?>"/>
		</label>
		</div>
		</td>
		</tr>
		<tr>
		<td colspan="2">
		<div class="griddiv" style=" margin-top:10px;">
		<label>
		<div class="gridlable" style="width:100%;font-size: 13px;">Additional Information</div>
		<textarea  name="additionalInfo" class="gridfield" id="additionalInfo" style="min-height: 60px;"> <?php echo $additionalInfo; ?></textarea>
		</label>
		</div>
		</td>
	</tr>
	</table>



			


	</div>

	</td>





    <td width="36%" align="left" valign="top" style="padding-left:0px;">

	<!-- Started Query Type sec -->
	<div style="background-color: white; padding:5px 0px 0px 20px;border: 1px #ccc solid;cursor: pointer;    border-top-right-radius: 5px;
    border-top-left-radius: 5px" onclick="$('#showmorefield1').toggle();">
	<img style="font-size: 14px;position: relative;top: 0px;height: 20px;" src="images/question-dom.png"> 
	<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;color: hsl(33 95% 68% / 1);">Query Type</span>

	</div>

	<div style=" border:1px #ccc solid; padding:10px;border-top:0px;display:block; margin-bottom: 20px;" >
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="4" align="left" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr> 
							<td width="50%">
								<div class="griddiv">
									<label>
									<div class="gridlable" style="margin-bottom: 0px;font-size: 13px;padding-left: 5px;">Query&nbsp;Type</div>

									<?php
									$rs='';
									$rs=GetPageRecord('*','moduleTypeMaster','status=1 and id in("1","3","4","5","13") order by id asc');
										
									?>
									
									<div class="main-div-con" style="display: grid;grid-template-columns: auto auto;"><?php
									while($moduleTypeData=mysqli_fetch_array($rs)){ ?>
									<div class="" style="width: 100%;">
										<div class="check_boxIndiv">
											<span class="check-box-title"><?php echo strip($moduleTypeData['name']); ?></span>

											<input type="radio" name="queryType" id="queryType<?php echo $moduleTypeData['id']; ?>" onclick="gitcodefun('<?php echo strip($moduleTypeData['id']); ?>');" class="check_box_input" value="<?php echo strip($moduleTypeData['id']); ?>" <?php if($moduleTypeData['id']==$queryType){ echo "checked"; }elseif($moduleTypeData['id']==1){ echo 'checked'; } ?> ></input>
										</div>

									</div>
									<?php } ?>
									</div>
										
									<!-- </select> -->
									</label>
								</div>
							</td>
						</tr>
				</table>
			</td>
		</tr>
	</table>
	</div>
<!-- Ended Query Type sec -->


<!-- Started Service Selection sec -->
	<div id="main-service-selection">
	<div style="background-color: white; padding:5px 0px 0px 20px;border: 1px #ccc solid;cursor: pointer;    border-top-right-radius: 5px;
    border-top-left-radius: 5px" onclick="$('#showmorefield1').toggle();">
	<img style="font-size: 14px;position: relative;top: 0px;height: 20px;" src="images/customer-dom.png"> 
	<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;color: hsl(33 95% 68% / 1);">Service Selection</span>
	
	</div>
	
	<div style=" border:1px #ccc solid; padding:10px;border-top:0px;display:block; margin-bottom: 20px;" >
	<table  width="100%" border="0" cellpadding="0" cellspacing="0">

		<tr>
		<td width="15%" valign="top">
			<div class="griddiv" style="border-bottom: 0px;">
				<div class="gridlable">Flight <img class="vaddedsimg" src="images/plane-dom.png"></div>

					<div class="divboxcls">
					
						<span id="serviceLable_Flight" class="serviceLable">No</span>						
						<span class="onbtn" id="ServiceON_Flight" style="display: none;" onclick="removeService('Flight','off');">&nbsp;</span>
						<span class="offbtn" id="ServiceOFF_Flight" onclick="selecteService('Flight','on');">&nbsp;</span>
					</div>
					<input name="needFlight" id="needFlight" value="<?php echo $editresult['needFlight']; ?>" type="hidden">

		</div>
		</td>
		<td width="15%" align="left" valign="top">
			<div class="griddiv" style="border-bottom: 0px;">
				<div class="gridlable" >VISA <img class="vaddedsimg" src="images/symbols-dom.png"> </div>

				<div class="divboxcls">
					
					<span id="serviceLable_Visa" class="serviceLable">No</span>						
					<span class="onbtn" id="ServiceON_Visa" style="display: none;" onclick="removeService('Visa','off');">&nbsp;</span>
					<span class="offbtn" id="ServiceOFF_Visa" onclick="selecteService('Visa','on');">&nbsp;</span>
				</div>
					<input type="hidden" name="visaRequired" id="needVisa" value="<?php echo $editresult['needVisa']; ?>" >
			
			 </div>
		</td>

		<td width="15%" valign="top">
			<div class="griddiv" style="border-bottom: 0px;">
		
				<div class="gridlable" >Insurance <img class="vaddedsimg" style="left: 23px;" src="images/insurance-dom.png"></div>
					<div class="divboxcls" >
						<span id="serviceLable_Insurance" class="serviceLable">No</span>						
						<span class="onbtn" id="ServiceON_Insurance" style="display: none;" onclick="removeService('Insurance','off');">&nbsp;</span>
						<span class="offbtn" id="ServiceOFF_Insurance" onclick="selecteService('Insurance','on');">&nbsp;</span>
					</div>
				</div>
				<input type="hidden" name="insuranceRequired" id="needInsurance" value="<?php echo $editresult['needInsurance']; ?>" >
				
			</label>
			</div>
		</td>
		</tr>
		<tr>
		  <td width="15%" align="left" valign="top" style="display:none;">
			<div class="griddiv" style="border-bottom: 0px;">
				<div class="gridlable">Train <img class="vaddedsimg" style="left: 23px;" src="images/train-dom.png"></div>
				<div class="divboxcls" >
					<span id="serviceLable_Passport" class="serviceLable">No</span>						
					<span class="onbtn" id="ServiceON_Passport" style="display: none;" onclick="removeService('Passport','off');">&nbsp;</span>
					<span class="offbtn" id="ServiceOFF_Passport" onclick="selecteService('Passport','on');">&nbsp;</span>
				</div>
				<input type="hidden" name="passportRequired" id="needPassport" value="<?php echo $editresult['needPassport']; ?>" >
			
		
			 </div>
		</td>

		<td width="15%" align="left" valign="top">
			<div class="griddiv" style="border-bottom: 0px;">
				<div class="gridlable">Train <img class="vaddedsimg" style="left: 53px;" src="images/train-dom.png"></div>
				<div class="divboxcls" >
					<span id="serviceLable_Train" class="serviceLable">No</span>						
					<span class="onbtn" id="ServiceON_Train" style="display: none;" onclick="removeService('Train','off');">&nbsp;</span>
					<span class="offbtn" id="ServiceOFF_Train" onclick="selecteService('Train','on');">&nbsp;</span>
				</div>
				<input type="hidden" name="needTrain" id="needTrain" value="<?php echo $editresult['needTrain']; ?>" >
			
		
			 </div>
		</td>

		<td width="15%" align="left" valign="top">
			<div class="griddiv" style="border-bottom: 0px;">
				<div class="gridlable">Transfer <img class="vaddedsimg" style="left: 30px;" src="images/taxi-dom.png"></div>
				<div class="divboxcls" >
					<span id="serviceLable_Transfer" class="serviceLable">No</span>						
					<span class="onbtn" id="ServiceON_Transfer" style="display: none;" onclick="removeService('Transfer','off');">&nbsp;</span>
					<span class="offbtn" id="ServiceOFF_Transfer" onclick="selecteService('Transfer','on');">&nbsp;</span>
				</div>
				<input type="hidden" name="needTransfer" id="needTransfer" value="<?php echo $editresult['needTransfer']; ?>" >
			
			 </div>
		</td>

	
	</tr>

</table>
	</div>

	<style>
			.vaddedsimg{
				position: relative;
				top: 3px;
				height: 15px;
				left: 45px;
			}
			.serviceLable{
				display: inline-block;
				width:33px;
			}
			.divboxcls{
				border: 1px solid #ccc;
				margin-top: 2px;
				border-radius: 5px;
				padding: 5px;
				width:60%;
			}
			.onbtn{
				position: relative;
  				background-color: #21d0b6;
				display: inline-block;
				width:40px;
				border-radius: 10px;
    			margin: 2px;
				cursor:pointer;
				transition: all 0.5s;
			
				}
			.onbtn:before {
					position: absolute;
					content: "";
					height: 15px;
					width: 15px;
					right: 4px;
					bottom: 0px;
					background-color: #FFF;
					border-radius: 50px;
					}

			.offbtn{
				position: relative;
  				background-color: #b5cdb5;
				display: inline-block;
				width:40px;
				border-radius: 10px;
    			margin: 2px;
				cursor:pointer;
			
				}
			.offbtn:after {
					position: absolute;
					content: "";
					height: 15px;
					width: 15px;
					left: 4px;
					bottom: 0px;
					background-color: #FFF;
					border-radius: 50px;
					}

					
			/* .onbtn {
			-webkit-transform: translateX(26px);
			-ms-transform: translateX(26px);
			transform: translateX(26px);
			} */
					
		</style>
</div>
<br>
<!-- Ended Service Selection sec -->

<div id="tranvel_info">
<div style="background-color: white; padding:5px 0px 0px 20px;border: 1px #ccc solid;cursor: pointer;    border-top-right-radius: 5px;
    border-top-left-radius: 5px" onclick="$('#showmorefield1').toggle();">
	<img style="font-size: 14px;position: relative;top: 0px;height: 20px;" src="images/information-dom.png"> 
	<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;color: hsl(33 95% 68% / 1);">Travel Information </span>

</div>

	

	<div style=" border:1px #ccc solid; padding:10px;border-top:0px;display:block; margin-bottom: 20px;" >

	<table width="100%" border="0" cellpadding="0" cellspacing="0"  <?php if($_REQUEST["id"]!= "" && isset($_REQUEST["id"]) && $editresult["queryType"]!=5 ){ ?>  style="display:none;" <?php } ?>>

	<tr>
		<td colspan="4">
			<!-- tarvel type sec started -->
			<?php 
			$rs1=GetPageRecord('*','companySettingsMaster','id=1');
			$rescompanysetting=mysqli_fetch_array($rs1); 
			?>
			<div class="griddiv"><label>
				<div class="gridlable" style="font-size: 13px;">Travel&nbsp;Type</div>
				<!-- <select name="travelType" id="travelType"  class="gridfield" > -->
					<div class="travel_info_main">
						<div class="check_boxIndiv">
							<?php if($rescompanysetting['internationalQuery']==1){ ?>
							<span class="check-box-title">International</span>
							<input name="travelType" id="travelType" class="check_box_input" <?php if($travelType==1 || $travelType==''){ echo "checked"; } ?> type="radio" value="1" ></input>
						</div>

							<?php } 

					
						if($rescompanysetting['domesticQuery']==1){ ?>
						<div class="check_boxIndiv">
							<span class="check-box-title">Domestic</span>
							<input name="travelType" id="travelType" 
							class="check_box_input" type="radio" value="2" <?php if($travelType==2){ echo "checked"; } ?> ></input>
						</div>
						<?php } ?>

					</div>

			</label>
			</div>
			<!-- tarvel type sec ended -->


			<!-- Pax type sec started -->

								
			
				<div class="griddiv"  id="paxCodeDiv" ><label>
					<div class="gridlable" style="font-size: 13px;;">Pax&nbsp;Type</div>
					<div class="travel_info_main">
					
						<div class="check_boxIndiv">
							<span class="check-box-title">GIT</span>
							<input name="paxType" id="paxType"  class="check_box_input" type="radio" value="1" <?php if(1==$paxType){ ?>checked="checked"<?php } ?> ></input>
						</div>

						<div class="check_boxIndiv">
						<span class="check-box-title">FIT</span>
						<input name="paxType" id="paxType" class="check_box_input"  type="radio" value="2" <?php if(2==$paxType || $paxType==''){ ?>checked="checked"<?php } ?>></input>
						</div>
						
					</div>
					
					</label>
			</div>
	
			<!-- Pax type sec started -->
		</td>
	</tr>
    <tr>
    <td colspan="4" align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <tr>

	  <!-- day and date sec -->
		<td width="40%" style="display: none;"><label><select name="dayWise" id="dayWise"  class="gridfield" onchange="changedatetr();" style="padding:10px; width:100%; border:1px solid #ccc; box-sizing:border-box; margin-bottom:10px;">

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
			$starting_year  = date('Y', strtotime("now"));
			$ending_year    = 2040;
			for($starting_year; $starting_year <= $ending_year; $starting_year) {
				if(date('Y',strtotime($editresult['seasonYear'])) == $starting_year ){ $seleted = "selected"; }else{ $seleted = ""; }
				$years[] = '<option value="'.$starting_year.'" '.$seleted.' >'.$starting_year++.'</option>';
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

	<td width="17%" align="left" valign="top"><a href="#" style="font-size: 12px;background-color: #7a96ff;color: #fff !important;padding: 11px 8px;margin-right: 0px;margin-top: 20px;display: block;text-align: center;margin-left: 1px;" onclick="generateQueryDay_function();">+ Add</a></td>

</tr>


	</table>

	</div>
	

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
	var isEditable = <?php if($_REQUEST["id"]!="" && isset($_REQUEST["id"]) && $editresult["queryType"]!=5){ echo "0"; } else{ echo "1"; } ?>;
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
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 	  
	  <tr><td colspan="2">
	  <div class="griddiv">

		

		<div class="griddiv" id="gitgroupcode" style="display:none;"><label>

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



	<!-- Started Quotation/Itinerary Information -->
	<div id="pax_detail_box">
	<div style="background-color: white; padding:5px 0px 0px 20px;border: 1px #ccc solid;cursor: pointer;    border-top-right-radius: 5px;
    border-top-left-radius: 5px" onclick="$('#showmorefield1').toggle();">
	<img style="font-size: 14px;position: relative;top: 0px;height: 20px;" src="images/contact-book-dom.png"> 
	<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;color: hsl(33 95% 68% / 1);">Quotation/Itinerary Information</span>

	</div>
	<div style=" border:1px #ccc solid; padding:10px;border-top:0px;display:block; " >
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="4" align="left" valign="top">
			<table style="display: none1;" width="100%" border="0" class="griddiv" cellpadding="0" cellspacing="0" id="paxCountId">

				<tr>

				<td width="25%" align="left" valign="top"><label >
				<div class="gridlable">Adult<img style="position: relative;top: 3px;height: 15px;right: -15px;" src="images/man-dom.png"><span class="redmind"></span></div><input name="adult" type="text" class="gridfield validate" style="width: 94%;" onKeyUp="numericFilter(this);" id="adult" displayname="Adult" value="<?php echo $editresult['adult']; ?>" maxlength="3" /></label><?php if($queryType ==3){ echo $rmadult; } ?></td>

				<td width="25%" align="left" valign="top"><label style=" position: relative; "> 
				<div class="gridlable">Child<img style="position: relative;top: 3px;height: 15px;right: -15px;" src="images/child-dom.png"></div> 
				<!-- <input name="child" type="text" class="gridfield" id="child" onKeyUp="numericFilter(this);showcwbroom();showChildAge();" displayname="Child" value="<?php echo $editresult['child']; ?>" maxlength="3" />  -->
				<input name="child" type="text" style="width: 94%;" class="gridfield" id="child" onKeyUp="numericFilter(this);showcwbroom();showChildAge();" displayname="Child" value="<?php echo $editresult['child']; ?>" maxlength="3" />
				</label><?php if($queryType ==3){ echo $rmchild; } ?></td>

				<td width="25%" align="left" valign="top">
				<label>

				<div class="gridlable">Infant<img style="position: relative;top: 3px;height: 15px;right: -15px;" src="images/crawl-dom.png"></div>

				<input name="infant" type="text" style="width: 94%;" class="gridfield" id="infant" onKeyUp="numericFilter(this);" displayname="Infant" value="<?php echo $infant; ?>" maxlength="3" />

				</label></td>

				</tr>

				</table>

				<script>
			function showChildAge(){
					// $("#childAgeTable").show();
					var childNo = $("#child").val();
					$("#childAgeTable").load('searchaction.php?action=loadChildAgeTable&totalChild='+childNo);
				}
			</script>
				
				<script>
				showChildAge();
				</script>
 

			<div id="childAgeTable" style="display: block;"></div>

			

	<!--SGL Room DBL Room TWIN Room section  by design   -->
	<div >
	<table  width="100%" border="0" class="griddiv" cellpadding="0" cellspacing="0" id="roomTypeId" >
		<tr>
			<td align="left" colspan="2" valign="top">SGL Room </td>
			<td align="left" colspan="2" valign="top">DBL Room</td>
			<td align="left" colspan="2" valign="top">TWIN Room</td>
		</tr>

		<tr>

			<td align="left" colspan="2" valign="top"><input style="width: 94%;" name="sglRoom" type="text" oninput="getRoomCount(1)" class="gridfield mb5 numeric" id="sglRoom" value="<?php echo $editresult['sglRoom']; ?>" maxlength="3">
				<?php if($queryType ==3){ echo $rmsglRoom; } ?>
			</td>

			<td align="left" colspan="2" valign="top"><input style="width: 94%;" name="dblRoom" type="text" oninput="getRoomCount(2)" class="gridfield mb5 numeric" id="dblRoom" value="<?php echo $editresult['dblRoom']; ?>" maxlength="3">
				<?php if($queryType ==3){ echo $rmdblRoom; } ?>
			</td>
			<td align="left" colspan="2" valign="top"><input style="width: 94%;" name="twinRoom" type="text" oninput="getRoomCount(3)" class="gridfield mb5 numeric" id="twinRoom" value="<?php echo $editresult['twinRoom']; ?>" maxlength="3">
				<?php if($queryType ==3){ echo $rmtwinRoom; } ?>
			</td>
		</tr>
		<tr>
			
			<td align="left" colspan="2" valign="top">TPL Room</td>
			<td align="left" colspan="2" valign="top">ExtraBed(A)</td>
			<?php if(isRoomActive('quadroom')==true){ ?> 
			<td align="left" colspan="2" valign="top">Quad Room</td>
			<?php } ?>
		</tr>
		<tr>
		
			<td align="left" colspan="2" valign="top"><input style="width: 94%;" name="tplRoom" type="text" oninput="getRoomCount(4)" class="gridfield mb5 numeric" id="tplRoom" value="<?php echo $editresult['tplRoom']; ?>" maxlength="3">
				<?php if($queryType ==3){ echo $rmtplRoom; } ?>
			</td>
			<td align="left" colspan="2" valign="top"><input  style="width: 94%;" name="extraNoofBed" type="text" class="gridfield mb5 numeric" id="extraNoofBed" value="<?php echo $editresult['extraNoofBed']; ?>" maxlength="3">
				<?php if($queryType ==3){ echo $rmextraNoofBed; } ?>
			</td>
			<?php if(isRoomActive('quadroom')==true){ ?>  
			<td align="left" colspan="2" valign="top">
				<input name="quadNoofRoom" type="text" style="width: 94%;" class="gridfield mb5 numeric" oninput="getRoomCount(6)" id="quadNoofRoom" value="<?php echo $editresult['quadNoofRoom']; ?>" maxlength="3">
			</td>
			<?php } ?>
		</tr>
		<tr>
			<?php if(isRoomActive('sixbedroom')==true){ ?> 
			<td align="left" colspan="2" valign="top">Six Bed Room</td>
			<?php } if(isRoomActive('eightbedroom')==true){ ?>
			<td align="left" colspan="2" valign="top">Eight Bed Room</td>
			<?php } if(isRoomActive('tenbedroom')==true){ ?>
			<td align="left" colspan="2" valign="top">Ten Bed Room</td>
			<?php } ?>
		</tr>
		<tr>
			<?php if(isRoomActive('sixbedroom')==true){ ?> 
			<td align="left" colspan="2" valign="top">
				<input name="sixNoofBedRoom" type="text" style="width: 94%;" oninput="getRoomCount(7)" class="gridfield mb5 numeric" id="sixNoofBedRoom" value="<?php echo $editresult['sixNoofBedRoom']; ?>" maxlength="3">
				<?php if($queryType ==3){ echo $rmtplRoom; } ?>
			</td>
			<?php } if(isRoomActive('eightbedroom')==true){ ?>
			<td align="left" colspan="2" valign="top">
				<input name="eightNoofBedRoom" type="text" style="width: 94%;" oninput="getRoomCount(8)" class="gridfield mb5 numeric" id="eightNoofBedRoom" value="<?php echo $editresult['eightNoofBedRoom']; ?>" maxlength="3">
				<?php if($queryType ==3){ echo $rmtplRoom; } ?>
			</td>
			<?php } if(isRoomActive('tenbedroom')==true){ ?>
			<td align="left" colspan="2" valign="top">
				<input name="tenNoofBedRoom" type="text" style="width: 94%;" oninput="getRoomCount(9)" class="gridfield mb5 numeric" id="tenNoofBedRoom" value="<?php echo $editresult['tenNoofBedRoom']; ?>" maxlength="3">
				<?php if($queryType ==3){ echo $rmextraNoofBed; } ?>
			</td> 
			<?php } ?>
		</tr>

		<tr>
			<td align="left" colspan="2" valign="top"><div class="showcwbroom">CWBed</div></td>
			<td align="left" colspan="2" valign="top"><div class="showcwbroom">CNBed</div></td>
			<?php if(isRoomActive('teenbed')==true){ ?> 
			<td align="left" colspan="2" valign="top"><div class="showcwbroom">Teen Room</div></td>
			<?php } ?>
		</tr>
		<tr>
			<td align="left" colspan="2" valign="top">
				<!-- onkeyup="balanceCWB(this.value)" -->
				<div class="showcwbroom"><input name="cwbRoom" style="width: 94%;" type="text" class="gridfield mb5 numeric" id="cwbRoom" value="<?php echo $editresult['cwbRoom']; ?>" maxlength="3" >
					<?php if($queryType ==3){ echo $rmcwbRoom; } ?>
				</div></td>
			<td align="left" colspan="2" valign="top">
				<div class="showcwbroom">
					<input name="cnbRoom" type="text" style="width: 94%;" class="gridfield mb5 numeric" id="cnbRoom" value="<?php echo $editresult['cnbRoom']; ?>" maxlength="3" >
					<!-- onkeyup="balanceCNB(this.value)" -->
					<?php if($queryType ==3){ echo $rmcnbRoom; } ?>
				</div>
				</td>
				<?php if(isRoomActive('teenbed')==true){ ?> 
				<td align="left" colspan="2" valign="top">
				<div class="showcwbroom">
					<input name="teenNoofRoom" type="text"  style="width: 94%;" oninput="getRoomCount(10)" class="gridfield mb5 numeric" id="teenNoofRoom" value="<?php echo $editresult['teenNoofRoom']; ?>" maxlength="3" >
					<!-- onkeyup="balanceTeen(this.value);" -->
					
				</div>
				</td>
				<?php } ?>
		</tr>

		<br>
		<br>
		<tr>
			<td colspan="4" style="margin-top:10px;"> <div style="display: inline-block;width: 104px;font-size: 15px;font-weight: 500;padding: 5px;color: #fff;background-color: green;">Total Rooms:- </div><input id="totalrooms" readonly name="totalrooms" value="0" style="display: inline-block;font-size: 15px;font-weight: 500;padding: 5px;border:none !important; width:60px;"></td>
		</tr>
		
	</table>
	</div>
	</div>
	<script>
	function getRoomCount(){
		
		// cwb cnb and extra bed a not included
		var sglRoom = Number($("#sglRoom").val());
		var dblRoom = Number($("#dblRoom").val());
		var twinRoom = Number($("#twinRoom").val());
		var tplRoom = Number($("#tplRoom").val());
		// var extraNoofBed = Number($("#extraNoofBed").val());
		// var cwbRoom = Number($("#cwbRoom").val());
		// var child = Number($("#child").val());
		// var cnbRoom = Number($("#cnbRoom").val());
		var quadNoofRoom = Number($("#quadNoofRoom").val());
		var sixNoofBedRoom = Number($("#sixNoofBedRoom").val());
		var eightNoofBedRoom = Number($("#eightNoofBedRoom").val());
		var tenNoofBedRoom = Number($("#tenNoofBedRoom").val());
		var teenNoofRoom = Number($("#teenNoofRoom").val());

		if(quadNoofRoom>0){
			quadNoofRoom=quadNoofRoom;
		}else{
			quadNoofRoom=0;
		}
		if(sixNoofBedRoom>0){
			sixNoofBedRoom=sixNoofBedRoom;
		}else{
			sixNoofBedRoom=0;
		}

		if(eightNoofBedRoom>0){
			eightNoofBedRoom=eightNoofBedRoom;
		}else{
			eightNoofBedRoom=0;
		}

		if(tenNoofBedRoom>0){
			tenNoofBedRoom=tenNoofBedRoom;
		}else{
			tenNoofBedRoom=0;
		}

		if(teenNoofRoom>0){
			teenNoofRoom=teenNoofRoom;
		}else{
			teenNoofRoom=0;
		}

		var totalRooms = sglRoom+dblRoom+twinRoom+tplRoom+quadNoofRoom+sixNoofBedRoom+eightNoofBedRoom+tenNoofBedRoom+teenNoofRoom;
		// cwbRoom+cnbRoom+
		$('#totalrooms').val(totalRooms)
		// console.log(quadNoofRoom)
	}
	</script>

<table width="100%" border="0" cellpadding="4" cellspacing="0"  id="childfielddiv" style="display:none; ">
	<tr> 
		<script>
		  	function showcwbroom(){
				
		  		var child = $('#child').val();
				
		  		if(child == 0 || child == ''){
					$('.showcwbroom').css("display","block");
					// child section by default show  code
		  		//   $('.showcwbroom').css("display","none");
		  		}else{
					<?php if($editresult['id']==""){ ?>
						// this box is show automatically value show chil with bed room sec.
		  			$('#cwbRoom').val(0);
					  <?php } ?>
		  			$('.showcwbroom').css("display","block");
		  		}
		  	}
		  	showcwbroom();

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

			</td>
		</tr>
	</table>
	</div>


	<!-- Ended Quotation/Itinerary Information -->
	

	</td>

		
	


    <td width="33%" align="left" valign="top" style="padding-left:20px;">
	<div style="background-color: white; padding:5px 0px 0px 20px;border: 1px #ccc solid;cursor: pointer;    border-top-right-radius: 5px;
    border-top-left-radius: 5px" onclick="$('#showmorefield1').toggle();">
	<img style="font-size: 14px;position: relative;top: 0px;height: 20px;" src="images/user-dom.png"> 
	<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;color: hsl(33 95% 68% / 1);">Assignment</span>

	</div>

	

	<div style=" border:1px #ccc solid; padding:10px;border-top:0px; display:block;margin-bottom: 20px; " >

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="50%">
		<div class="griddiv  " style="width: 100%;"> 
			<label> 
				<div class="gridlable " style="width:100%;">Sales Person<span class=""></span></div> 
				<div id="selectOpsPerson"> 
				<input type="text" name="salesassignTo" id="salesassignTo" class="gridfield" value="<?php echo $salesassignTo; ?>" readonly="" /> 
				<input type="hidden" name="salesPersonId" id="salesPersonId" class="gridfield" value="<?php echo encode($salesPersonId); ?>" readonly="" /> 
				</div> 
			</label> 
		</div>
		</td>	
	  </tr>
	  <tr>
		<td width="48%">
		<div class="griddiv validate " style="width: 96%;"><img src="images/add-user-dom.png" onclick="function_assignTo();" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;"  />
		<label>
		<div class="gridlable validate" style="width:100%;">Operation Person<span class="redmind"></span></div> 
		<div id="selectOpsPerson"> 
			<input name="ownerName" type="text" class="gridfield validate" id="ownerName" value="<?php if($OpsAssignTo!=''){ echo getUserName($OpsAssignTo); } ?>" readonly="true" displayname="Operation&nbsp;Person" autocomplete="off" onclick="function_assignTo();" /> 
			<input name="assignTo" type="hidden" id="assignTo" value="<?php echo encode($OpsAssignTo); ?>" />
		</div> 
		</label>
		<script type="text/javascript"> 
			function function_assignTo(){
				var lang = $('#language').val();
				alertspopupopen('action=selectParent&userType=1','600px','auto');
			} 
		</script>
		</div>
		</td>
		<td width="48%">
		<div class="griddiv  " style="width: 96%;"><img src="images/add-user-dom.png" onclick="" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;"  />
		<label>
		<div class="gridlable " style="width:100%;">Contracting Person<span class=""></span></div> 
		<div id="selectOpsPerson"> 
			<input disabled name="ownerName2" type="text" class="gridfield " id="ownerName2" value="" readonly="true" displayname="" autocomplete="off"/> 
			<input name="assignTo1" type="hidden" id="assignTo1" value="" />
		</div> 
		</label>
		
		</div>
		</td>
	  </tr>
	  
	</table>
	
	</div>
	

	<div style="background-color: white; padding:5px 0px 0px 20px;border: 1px #ccc solid;cursor: pointer;    border-top-right-radius: 5px;
    border-top-left-radius: 5px" onclick="$('#showmorefield1').toggle();">
	<img style="font-size: 14px;position: relative;top: 0px;height: 20px;" src="images/preferences-dom.png"> 
	<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;color: hsl(33 95% 68% / 1);">Preference</span>

	</div>

	<div style=" border:1px #ccc solid; padding:10px;border-top:0px; display:block; " >
	<div id="show-info" class="" style="display:none1">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
<td width="100%" align="left" valign="top">
<div class="griddiv" style="margin-bottom: 5px;">
<label>
<!-- set priority for query normal by default -->
<div class="gridlable">Priority</div>
<div class="main-div-con" style="display: grid;grid-template-columns: auto auto auto;">

<div class="check_boxIndiv" class="">
	<span class="check-box-title" >Normal</span>	
	<input name="queryPriority" id="queryPriority" class="check_box_input" type="radio" value="1" selected="selected"></input>
</div>

<div class="check_boxIndiv">
	<span class="check-box-title">Medium</span>
	<input name="queryPriority" class="check_box_input" id="queryPriority" type="radio" value="2"  checked></input>

</div>

<div class="check_boxIndiv">
	<!-- <select id="queryPriority" name="queryPriority" class="gridfield"  autocomplete="off" > -->
	<span class="check-box-title">High</span>
	<input name="queryPriority" class="check_box_input" id="queryPriority" type="radio" value="3">
	</input>
</div>

</div>
</div>
</label>
</div></td>

</tr>

<tr>
<td width="100%" align="left" valign="top"><div class="griddiv" style="margin-bottom: 5px;">
<label>
<div class="gridlable">TAT</div>
<div class="main-div-con" style="display: grid;grid-template-columns: auto auto auto;">

	<div class="check_boxIndiv">
		<span class="check-box-title">24 Hours</span>
		<input name="tat" id="tat" class="check_box_input" type="radio" value="24" selected="selected" checked></input>
	</div>

	<div class="check_boxIndiv">
		<span class="check-box-title">48 Hours</span>
		<input name="tat" id="tat" class="check_box_input" type="radio" value="48" ></input>
	</div>

	<div class="check_boxIndiv">
		<span class="check-box-title">72 Hours</span>
		<input name="tat" id="tat" class="check_box_input" type="radio" value="72" ></input>
	</div>

	<!-- </select> -->
</div>

</label>
</div></td>
</tr>

<tr id="hotel_category">
<td width="100%" align="left" valign="top"><div class="griddiv" style="margin-bottom: 5px;">
<label><div class="gridlable">Hotel Category  </div>

<div class="main-div-con" style="display: grid;grid-template-columns: auto auto auto auto;">
	<div class="check_boxIndiv">
		<span class="check-box-title">All</span>
		<input name="hotelAccommodation" id="hotelAccommodation" class="check_box_input" type="radio" value="0" checked></input>
	</div>

				<?php
$hotelCatQuery='';
$hotelCatQuery=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,'  deletestatus=0 and status=1 order by hotelCategory asc');
while($hotelCategoryData=mysqli_fetch_array($hotelCatQuery)){
?>


	<div class="main-div-con" style="width: 100%;">
		<div class="check_boxIndiv">
			<span class="check-box-title"><?php echo strip($hotelCategoryData['hotelCategory']).' Star'; ?></span>
				<input name="hotelAccommodation" id="hotelAccommodation" class="check_box_input" type="radio" value="<?php echo strip($hotelCategoryData['hotelCategory']); ?>">
				</input>
		</div>

	</div>


<?php } ?>

</div>

<!-- </select> -->
</label>

</div></td>


</tr>
<tr id="hotel_type">




<!-- Hotel Type code started -->

<td width="100%" align="left" valign="top"><div class="griddiv" style="width: 200px;"><label>
	<div class="gridlable" >Hotel&nbsp;Type</div>
 	<select style="border-radius: 5px;margin: 10px 0px;border: 1px solid #ccc;" id="hotelTypeId" name="hotelTypeId" class="gridfield" autocomplete="off"  displayname="Hotel Type"  > 
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

	<tr id="tour_type">
	
<!-- Tour Type sec -->

<td width="50%" align="left" valign="top"><div class="griddiv"><label><div class="gridlable">
Tour Type</div>




<!-- <select id="tourType" name="tourType" class="gridfield " displayname="Tour Type" autocomplete="off"   > -->
<div class="main-div-con" style="display: grid;grid-template-columns: auto auto;">
<?php
$rs=GetPageRecord('*',_TOUR_TYPE_MASTER_,'deletestatus=0 and status=1 order by name asc');
while($resListing=mysqli_fetch_array($rs)){
?>
<div class="" style="width: 100%;">
		<div class="check_boxIndiv">
			<span class="check-box-title"><?php echo strip($resListing['name']); ?></span>
			<input id="tourType" name="tourType" class="check_box_input" type="radio" value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$edittourType){ ?>selected="selected"<?php } ?>></input>

		</div>
</div>
<?php } ?>
</div>


<!-- </select> -->
</label>
</div></td>
</tr>

	
	
	</table>
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0" id="meal_plan_box">
    <tr>
	<!-- Meal Plan code sec started -->

	<td width="50%" align="left" valign="top">
		<div class="griddiv"><label><div class="gridlable">Meal Plan</div>
			<div style="display: grid;grid-template-columns: auto auto auto auto; width: 100%;">
		<?php
			$rs=GetPageRecord('*',_MEAL_PLAN_MASTER_,'name!="" and deletestatus=0 and status=1 order by name asc');
				while($resListing=mysqli_fetch_array($rs)){
				if($editresult['mealPlanId']!=''){
					$mealPlanId = $editresult['mealPlanId'];
				}else{
					if($resListing['name'] == 'cp' || $resListing['name'] == 'CP' ){
						$mealPlanId = $resListing['id'];
					}
				}
		?>

		<div class="check_boxIndiv">
			<span class="check-box-title"><?php echo strip($resListing['name']); ?></span>
			<input id="mealPlanId" name="mealPlanId" class="check_box_input" type="radio" value="<?php echo strip($resListing['id']); ?>" <?php if($editresult['mealPlanId']==$resListing['id']){ ?>selected="selected"<?php } ?> ></input>

		</div>

<?php } ?>
</div>
<!-- </select> -->
</label>
</div></td>
		
	</tr>
	

	</table>


	<table width="100%" border="0" cellpadding="0" cellspacing="0">

		<!--Add More Emails -->
			<tr>
				<td width="48%"><div class="griddiv"  style="width: 96%;margin-bottom:5px;"><label>
				<div class="gridlable">Lead Source</div>
			
				<select style="border-radius: 5px;margin: 5px 0px;border: 1px solid #ccc;" id="leadsource" name="leadsource" class="gridfield"  autocomplete="off" >
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
				<td width="48%" align="left" valign="top"><div class="griddiv" style="width: 96%; margin-bottom:5px;">
				<label>
				<div class="gridlable">Lead Refrence Id  </div>
				<input style="border-radius: 5px; margin: 5px 0px;border: 1px solid #ccc;" name="referenceId" class="gridfield" value="<?php echo clean($editresult['referenceId']); ?>" />
				</label>
				</div></td>
			</tr>

	</table>

	</div>

	<!--hidden input s-->
	<input type="hidden" name="quotationYes" value="2"/>
	<input type="hidden" name="moduleType" value="1"/>
	<input type="hidden" name="attachitinerary" value="1"/>
	<input type="hidden" name="calculationType" value="1"/>


</div>


	</td>
	
	

	
  </tr>
					
	<tr id="service_selection_box" style="width: 68%;position: relative;bottom: 270px;display:none;">
			<td style="position:relative; z-index:-2;">&nbsp;</td>
		<td colspan="2" >
			
				<div style="background-color: white; padding:5px 0px 0px 20px;border: 1px #ccc solid;cursor: pointer;   border-top-right-radius: 5px;border-top-left-radius: 5px" onclick="$('#showmorefield1').toggle();">
					<img style="font-size: 14px;position: relative;top: 0px;height: 20px;" src="images/information-dom.png"> 
					<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;color: hsl(33 95% 68% / 1);">Travel Information</span>
				</div>
				<div style="border:1px #ccc solid; padding:10px;border-top:0px; display:block;">
					<table width="50%" cellpadding="5" callspacing="0">
					<tr>

					<td width="20%" align="left" valign="top">
					<div class="griddiv"><label>
					<div class="gridlable">Adult<img style="position: relative;top: 3px;height: 15px;right: -15px;" src="images/man-dom.png"><span class="redmind"></span></div>

					<input name="serviceAdult" type="text" class="gridfield" style="width: 94%;" onKeyUp="numericFilter(this);" id="serviceAdult" displayname="Service Adult" value="<?php echo $editresult['adult']; ?>" maxlength="3" /></label>
					</div>
					</td>

					<td width="20%" align="left" valign="top"><div class="griddiv"><label style=" position: relative; "> 
					<div class="gridlable">Child<img style="position: relative;top: 3px;height: 15px;right: -15px;" src="images/child-dom.png"></div> 
				
					<input name="serviceChild" type="text" style="width: 94%;" class="gridfield" id="serviceChild" onKeyUp="numericFilter(this);showcwbroom();showChildAge();" displayname="Child" value="<?php echo $editresult['child']; ?>" maxlength="3" />
					</label>
					</div>	
					</td>

					<td width="20%" align="left" valign="top">
					<div class="griddiv">
					<label>
					<div class="gridlable">Infant<img style="position: relative;top: 3px;height: 15px;right: -15px;" src="images/crawl-dom.png"></div>

					<input name="serviceInfant" type="text" style="width: 94%;" class="gridfield" id="serviceInfant" onKeyUp="numericFilter(this);" displayname="Infant" value="<?php echo $infant; ?>" maxlength="3" />
					</label>
					</div>
					</td>


				
					</tr>
					</table>
					<!-- Flight Service Box -->
					<div id="flight_container" style="display: none;">
					<div class="serviceTitles">Flight&nbsp;Service</div>
					<?php 
  						$countNum=1;

						$rsFQ = GetPageRecord('*','flightQueryMaster','status=1 and deletestatus=0 and queryId="'.$editresult['id'].'" order by multipleNo asc');
						if($num=mysqli_num_rows($rsFQ)>0){
							
						while($flightDATA = mysqli_fetch_assoc($rsFQ)){
							
							?>
						<div id="loadedservicesFlight<?php echo $countNum; ?>" class="flight_services">
						
						<input type="hidden" name="flightEditId<?php echo $countNum; ?>" id="flightEditId<?php echo $countNum; ?>" value="<?php echo $flightDATA['id']; ?>">

						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">Date<span class="redmind"></span></div>
						<?php } ?>
							<input name="flightDate<?php echo $countNum; ?>" readonly type="text" class="gridfield calfieldicon" id="flightDate<?php echo $countNum; ?>" displayname="Flight Date" value="<?php if($flightDATA['fromDate']!='0000-00-00'){ echo  date('d-m-Y',strtotime($flightDATA['fromDate'])); } ?>" /></label>
						</div>
						<script>
							$('#flightDate<?php echo $countNum; ?>').Zebra_DatePicker({
  								format: 'd-m-Y',
							});

						</script>
						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">From&nbsp;Destination<span class="redmind"></span></div>
						<?php } ?>
							<select name="flightDestination<?php echo $countNum; ?>" class="gridfield" id="flightDestination<?php echo $countNum; ?>" displayname="Flight Destination" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id',_DESTINATION_MASTER_,'status=1 and deletestatus=0 and name!="" ');
								while($fromDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $fromDest['id']; ?>" <?php if($flightDATA['fromDestination']==$fromDest['id']){ echo 'selected'; } ?> ><?php echo ucfirst($fromDest['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">To&nbsp;Destination<span class="redmind"></span></div>
						<?php } ?>
							<select name="flightToDestination<?php echo $countNum; ?>" class="gridfield" id="flightToDestination<?php echo $countNum; ?>" displayname="Flight To Destination" style="padding: 9.5px;">
								<option value="">Select</option>
								
								<?php
								$rsA = GetPageRecord('name,id',_DESTINATION_MASTER_,'status=1 and deletestatus=0 and name!="" ');
								while($toDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $toDest['id']; ?>" <?php if($flightDATA['toDestination']==$toDest['id']){ echo 'selected'; } ?>><?php echo ucfirst($toDest['name']); ?></option>
								<?php }
								
								?>

							</select>
						</label>
						</div>
						<?php if($countNum==1){ ?>
						<div class="addbtn"><input type="button" name="" class="multiservicebtn" id="" value="+Add" onclick="loadAddMultipleServices('Flight');"></div>

						<div class="addbtn"><i class="fa fa-trash-o multiservicebtn" aria-hidden="true" onclick="removeMultipleServices('<?php echo $flightDATA['id']; ?>','<?php echo $countNum; ?>','Flight');"></i></div>
						<?php }else{
							?>
						<div class="addbtn" style="margin-top: 6px;"><i class="fa fa-trash-o multiservicebtn" aria-hidden="true" onclick="removeMultipleServices('<?php echo $flightDATA['id']; ?>','<?php echo $countNum; ?>','Flight');"></i></div>
							<?php
						} ?>
					</div>
					
					<?php
						$countNum++;
						}
						?>
						<input type="hidden" name="countFlightNum" id="countFlightNum" value="<?php echo $countNum-1; ?>">
						<?php
					}else{

   					?>
					<div class="flight_services">
						
						<div class="griddiv"><label>
						<div class="gridlable">Date<span class="redmind"></span></div>

							<input name="flightDate<?php echo $countNum; ?>" type="date" class="gridfield" id="flightDate<?php echo $countNum; ?>" displayname="Flight Date" value="<?= date('Y-m-d',strtotime('now')); ?>" /></label>
						</div>
						<!-- ($editresult['fromDate']!='0000-00-00'){ } -->
						<div class="griddiv"><label>
						<div class="gridlable">From&nbsp;Destination<span class="redmind"></span></div>

							<select name="flightDestination<?php echo $countNum; ?>" class="gridfield" id="flightDestination<?php echo $countNum; ?>" displayname="Flight Destination" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id',_DESTINATION_MASTER_,'status=1 and deletestatus=0 and name!="" ');
								while($fromDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $fromDest['id']; ?>" ><?php echo ucfirst($fromDest['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<div class="gridlable">To&nbsp;Destination<span class="redmind"></span></div>

							<select name="flightToDestination<?php echo $countNum; ?>" class="gridfield" id="flightToDestination<?php echo $countNum; ?>" displayname="Flight To Destination" style="padding: 9.5px;">
								<option value="">Select</option>
								
								<?php
								$rsA = GetPageRecord('name,id',_DESTINATION_MASTER_,'status=1 and deletestatus=0 and name!="" ');
								while($toDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $toDest['id']; ?>"><?php echo ucfirst($toDest['name']); ?></option>
								<?php }
								
								?>

							</select>
						</label>
						</div>
						<div class="addbtn"><input type="button" name="" class="multiservicebtn" id="" value="+Add" onclick="loadAddMultipleServices('Flight');"></div>
					</div>
					<input type="hidden" name="countNumFlight" id="countNumFlight" value="<?php if($countNum==1){
						echo '1';}else{ echo $countNum; } ?>">
					<?php } ?>

					<div id="addmultipleFlight"></div>

					
					</div>
					<!-- Flight Service box end -->

					<!-- Visa Service box -->

					<div id="visa_container" style="display: none;">
					<div class="serviceTitles">Visa&nbsp;Service</div>
					<?php 
  						$countNum=1;

						$rsVQ = GetPageRecord('*','visaQueryMaster','status=1 and deletestatus=0 and queryId="'.$editresult['id'].'" order by multipleNo asc');
						if($num=mysqli_num_rows($rsVQ)>0){
							
						while($visaDATA = mysqli_fetch_assoc($rsVQ)){
							
							?>
						<div id="loadedservicesVisa<?php echo $countNum; ?>" class="visa_services">
						
						<input type="hidden" name="visaEditId<?php echo $countNum; ?>" id="visaEditId<?php echo $countNum; ?>" value="<?php echo $visaDATA['id']; ?>">

						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">Date<span class="redmind"></span></div>
						<?php } ?>
							<input name="visaDate<?php echo $countNum; ?>" readonly type="text" class="gridfield  calfieldicon" id="visaDate<?php echo $countNum; ?>" displayname="Flight Date" value="<?php if($visaDATA['fromDate']!='0000-00-00'){ echo  date('d-m-Y',strtotime($visaDATA['fromDate'])); } ?>" /></label>
						</div>
						<script>
							$('#visaDate<?php echo $countNum; ?>').Zebra_DatePicker({
  								format: 'd-m-Y',
							});

						</script>
						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">Country<span class="redmind"></span></div>
						<?php } ?>
							<select name="visaDestination<?php echo $countNum; ?>" class="gridfield" id="visaDestination<?php echo $countNum; ?>" displayname="Visa Destination" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id',_COUNTRY_MASTER_,'status=1 and deletestatus=0 and name!="" ');
								while($fromDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $fromDest['id']; ?>" <?php if($visaDATA['destinationId']==$fromDest['id']){ echo 'selected'; } ?> ><?php echo ucfirst($fromDest['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">Visa&nbsp;Name<span class="redmind"></span></div>
						<?php } ?>
							<select name="visaNameId<?php echo $countNum; ?>" class="gridfield" id="visaNameId<?php echo $countNum; ?>" displayname="Visa Destination" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id','visaCostMaster','status=1 and deletestatus=0 and name!="" ');
								while($visaName = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $visaName['id']; ?>" <?php if($visaDATA['visaNameId']==$visaName['id']){ echo 'selected'; } ?> ><?php echo ucfirst($visaName['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">Visa&nbsp;Type<span class="redmind"></span></div>
						<?php } ?>
							<select name="visaTypeId<?php echo $countNum; ?>" class="gridfield" id="visaTypeId<?php echo $countNum; ?>" displayname="Visa Type" style="padding: 9.5px;">
								<option value="">Select</option>
								
								<?php
								$rsA = GetPageRecord('name,id','visaTypeMaster','status=1 and deletestatus=0 and name!="" ');
								while($visaType = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $visaType['id']; ?>" <?php if($visaDATA['visaTypeId']==$visaType['id']){ echo 'selected'; } ?>><?php echo ucfirst($visaType['name']); ?></option>
								<?php }
								
								?>

							</select>
						</label>
						</div>


						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">Validity<span class="redmind"></span></div>
						<?php } ?>
							<input name="visaValidity<?php echo $countNum; ?>" type="text" class="gridfield" id="visaValidity<?php echo $countNum; ?>" displayname="Validity" value="<?php echo $visaDATA['visaValidity']; ?>" placeholder="Validity" style="padding: 9px;" /></label>
						</div>

						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">Entry Type<span class="redmind"></span></div>
						<?php } ?>
							<select name="entryType<?php echo $countNum; ?>" class="gridfield" id="entryType<?php echo $countNum; ?>" displayname="Entry Type" style="padding: 9.5px;">
								<option value="">Select</option>
								<option value="1" <?php if($visaDATA['entryType']==1){ echo 'selected'; } ?> >Single Entry</option>
								<option value="2" <?php if($visaDATA['entryType']==2){ echo 'selected'; } ?> >Multiple Entry</option>
	
							</select>
						</label>
						</div>

						<?php if($countNum==1){ ?>
						<div class="addbtn"><input type="button" name="" class="multiservicebtn" id="" value="+Add" onclick="loadAddMultipleServices('Visa');"></div>

						<div class="addbtn"><i class="fa fa-trash-o multiservicebtn" aria-hidden="true" onclick="removeMultipleServices('<?php echo $visaDATA['id']; ?>','<?php echo $countNum; ?>','Visa');"></i></div>
						<?php }else{
							?>
							<div class="addbtn" style="margin-top: 6px;"><i class="fa fa-trash-o multiservicebtn" aria-hidden="true" onclick="removeMultipleServices('<?php echo $visaDATA['id']; ?>','<?php echo $countNum; ?>','Visa');"></i></div>
							<?php
						} ?>
					</div>
					
					<?php
						$countNum++;
						}
						?>
						<input type="hidden" name="countNumVisa" id="countNumVisa" value="<?php echo $countNum-1; ?>">
						<?php
					}else{

   					?>
					<div class="visa_services">
						
						<div class="griddiv"><label>
						<div class="gridlable">Date<span class="redmind"></span></div>

							<input name="visaDate<?php echo $countNum; ?>" type="date" class="gridfield" onKeyUp="numericFilter(this);" id="visaDate<?php echo $countNum; ?>" displayname="Visa Date" value="<?= date('Y-m-d',strtotime('now')); ?>" /></label>
						</div>
					
						<div class="griddiv"><label>
						<div class="gridlable">Country<span class="redmind"></span></div>

							<select name="visaDestination<?php echo $countNum; ?>" class="gridfield" id="visaDestination<?php echo $countNum; ?>" displayname="Visa Destination" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id',_COUNTRY_MASTER_,'status=1 and deletestatus=0 and name!="" ');
								while($fromDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $fromDest['id']; ?>" ><?php echo ucfirst($fromDest['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

						<div class="griddiv"><label>
					
						<div class="gridlable">Visa&nbsp;Name<span class="redmind"></span></div>
						
							<select name="visaNameId<?php echo $countNum; ?>" class="gridfield" id="visaNameId<?php echo $countNum; ?>" displayname="Visa Name" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsV = GetPageRecord('name,id','visaCostMaster','status=1 and deletestatus=0 and name!="" ');
								while($visaName = mysqli_fetch_assoc($rsV)){ ?>
								<option value="<?php echo $visaName['id']; ?>" ><?php echo ucfirst($visaName['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<div class="gridlable">Visa&nbsp;Type<span class="redmind"></span></div>

							<select name="visaTypeId<?php echo $countNum; ?>" class="gridfield" id="visaTypeId<?php echo $countNum; ?>" displayname="Visa Type" style="padding: 9.5px;">
								<option value="">Select</option>
								
								<?php
								$rsA = GetPageRecord('name,id','visaTypeMaster','status=1 and deletestatus=0 and name!="" ');
								while($visaType = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $visaType['id']; ?>"><?php echo ucfirst($visaType['name']); ?></option>
								<?php }
								
								?>

							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<div class="gridlable">Validity<span class="redmind"></span></div>

							<input name="visaValidity<?php echo $countNum; ?>" type="text" class="gridfield" id="visaValidity<?php echo $countNum; ?>" displayname="Validity" value="" placeholder="Validity" style="padding: 9px;" /></label>
						</div>

						<div class="griddiv"><label>
						<div class="gridlable">Entry Type<span class="redmind"></span></div>
							
							<select name="entryType<?php echo $countNum; ?>" class="gridfield" id="entryType<?php echo $countNum; ?>" displayname="Entry Type" style="padding: 9.5px;">
								<option value="">Select</option>
								<option value="1">Single Entry</option>
								<option value="2">Multiple Entry</option>
	
							</select>
						</label>
						</div>


						<div class="addbtn"><input type="button" name="" class="multiservicebtn" id="" value="+Add" onclick="loadAddMultipleServices('Visa');"></div>
					</div>
					<input type="hidden" name="countNumVisa" id="countNumVisa" value="<?php if($countNum==1){
						echo '1';}else{ echo $countNum; } ?>">
					<?php } ?>

					<div id="addmultipleVisa"></div>

					
					</div>


					<!-- Visa Service box End -->

					<!-- Insurance Service box -->

					<div id="insurance_container" style="display: none;">
					<div class="serviceTitles">Insurance&nbsp;Service</div>
					<?php 
  						$countNum=1;

						$rsIQ = GetPageRecord('*','insuranceQueryMaster','status=1 and deletestatus=0 and queryId="'.$editresult['id'].'" order by multipleNo asc');
						if($num=mysqli_num_rows($rsIQ)>0){
							
						while($insuranceDATA = mysqli_fetch_assoc($rsIQ)){
							
							?>
						<div id="loadedservicesInsurance<?php echo $countNum; ?>" class="insurance_services">
						
						<input type="hidden" name="insuranceEditId<?php echo $countNum; ?>" id="insuranceEditId<?php echo $countNum; ?>" value="<?php echo $insuranceDATA['id']; ?>">

						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">From&nbsp;Date<span class="redmind"></span></div>
						<?php } ?>
							<input name="insuranceFromDate<?php echo $countNum; ?>" readonly type="text" class="gridfield  calfieldicon" id="insuranceFromDate<?php echo $countNum; ?>" displayname="Insurance From Date" value="<?php if($insuranceDATA['fromDate']!='0000-00-00'){ echo  date('d-m-Y',strtotime($insuranceDATA['fromDate'])); } ?>" /></label>
						</div>
						<script>
							$('#insuranceFromDate<?php echo $countNum; ?>').Zebra_DatePicker({
  								format: 'd-m-Y',
							});

						</script>

					<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">To&nbsp;Date<span class="redmind"></span></div>
						<?php } ?>
							<input name="insuranceToDate<?php echo $countNum; ?>" readonly type="text" class="gridfield  calfieldicon" id="insuranceToDate<?php echo $countNum; ?>" displayname="Insurance To Date" value="<?php if($insuranceDATA['toDate']!='0000-00-00'){ echo  date('d-m-Y',strtotime($insuranceDATA['toDate'])); } ?>" /></label>
						</div>
						<script>
							$('#insuranceToDate<?php echo $countNum; ?>').Zebra_DatePicker({
  								format: 'd-m-Y',
							});

						</script>

						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">Insurance&nbsp;Type<span class="redmind"></span></div>
						<?php } ?>
						<select name="insuranceTypeId<?php echo $countNum; ?>" class="gridfield" id="insuranceTypeId<?php echo $countNum; ?>" displayname="Insurance Type" style="padding: 9.5px;">
								<option value="">Select</option>
								
								<?php
								$rsA = GetPageRecord('name,id','InsuranceTypeMaster','status=1 and deletestatus=0 and name!="" order by name asc');
								while($insType = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $insType['id']; ?>" <?php if($insType['id']==$insuranceDATA['insuranceTypeId']){ echo 'selected'; } ?> ><?php echo ucfirst($insType['name']); ?></option>
								<?php }
								
								?>

							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">Tranvelling&nbsp;Country<span class="redmind"></span></div>
						<?php } ?>
						
						<select name="insuranceDestination<?php echo $countNum; ?>" class="gridfield" id="insuranceDestination<?php echo $countNum; ?>" displayname="Travelling Country" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id',_COUNTRY_MASTER_,'status=1 and deletestatus=0 and name!="" order by name asc');
								while($countryDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $countryDest['id']; ?>" <?php if($countryDest['id']==$insuranceDATA['destinationId']){ echo 'selected'; } ?> ><?php echo ucfirst($countryDest['name']); ?></option>
								<?php }
								
								?>
							</select>

						</label>
						</div>
						
						<?php if($countNum==1){ ?>
						<div class="addbtn"><input type="button" name="" class="multiservicebtn" id="" value="+Add" onclick="loadAddMultipleServices('Insurance');"></div>

						<div class="addbtn"><i class="fa fa-trash-o multiservicebtn" aria-hidden="true" onclick="removeMultipleServices('<?php echo $insuranceDATA['id']; ?>','<?php echo $countNum; ?>','Insurance');"></i></div>
						<?php }else{
							?>
							<div class="addbtn" style="margin-top: 6px;"><i class="fa fa-trash-o multiservicebtn" aria-hidden="true" onclick="removeMultipleServices('<?php echo $insuranceDATA['id']; ?>','<?php echo $countNum; ?>','Insurance');"></i></div>
							<?php
						} ?>
					</div>
					
					<?php
						$countNum++;
						}
						?>
						<input type="hidden" name="countNumInsurance" id="countNumInsurance" value="<?php echo $countNum-1; ?>">
						<?php
					}else{

   					?>
					<div class="insurance_services">
						
						<div class="griddiv"><label>
						<div class="gridlable">From&nbsp;Date<span class="redmind"></span></div>

							<input name="insuranceFromDate<?php echo $countNum; ?>" type="date" class="gridfield" id="insuranceFromDate<?php echo $countNum; ?>" displayname="Insurance From Date" value="<?= date('Y-m-d',strtotime('now')); ?>" /></label>
						</div>

						<div class="griddiv"><label>
						<div class="gridlable">To&nbsp;Date<span class="redmind"></span></div>

							<input name="insuranceToDate<?php echo $countNum; ?>" type="date" class="gridfield" id="insuranceToDate<?php echo $countNum; ?>" displayname="Insurance To Date" value="<?= date('Y-m-d',strtotime('now')); ?>" /></label>
						</div>

						
						<div class="griddiv"><label>
						<div class="gridlable">Insurance&nbsp;Type<span class="redmind"></span></div>

							<select name="insuranceTypeId<?php echo $countNum; ?>" class="gridfield" id="insuranceTypeId<?php echo $countNum; ?>" displayname="Insurance Type" style="padding: 9.5px;">
								<option value="">Select</option>
								
								<?php
								$rsA = GetPageRecord('name,id','InsuranceTypeMaster','status=1 and deletestatus=0 and name!="" order by name asc');
								while($insType = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $insType['id']; ?>"><?php echo ucfirst($insType['name']); ?></option>
								<?php }
								
								?>

							</select>
						</label>
						</div>
					
						<div class="griddiv"><label>
						<div class="gridlable">Tranvelling&nbsp;Country<span class="redmind"></span></div>

							<select name="insuranceDestination<?php echo $countNum; ?>" class="gridfield" id="insuranceDestination<?php echo $countNum; ?>" displayname="Travelling Country" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id',_COUNTRY_MASTER_,'status=1 and deletestatus=0 and name!="" order by name asc');
								while($countryDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $countryDest['id']; ?>" ><?php echo ucfirst($countryDest['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

						<div class="addbtn"><input type="button" name="" class="multiservicebtn" id="" value="+Add" onclick="loadAddMultipleServices('Insurance');"></div>
					</div>
					<input type="hidden" name="countNumInsurance" id="countNumInsurance" value="<?php if($countNum==1){
						echo '1';}else{ echo $countNum; } ?>">
					<?php } ?>

					<div id="addmultipleInsurance"></div>

					
					</div>

					<!-- Insurance Service box End -->

					<!-- Train Service Code -->

					<div id="train_container" style="display: none;">
					<div class="serviceTitles">Train&nbsp;Service</div>
					<?php 
  						$countNum=1;

						$rsIQ = GetPageRecord('*','trainQueryMaster','status=1 and deletestatus=0 and queryId="'.$editresult['id'].'" order by multipleNo asc');
						if($num=mysqli_num_rows($rsIQ)>0){
							
						while($trainDATA = mysqli_fetch_assoc($rsIQ)){
							
							?>
						<div id="loadedservicesTrain<?php echo $countNum; ?>" class="train_services">
						
						<input type="hidden" name="trainEditId<?php echo $countNum; ?>" id="trainEditId<?php echo $countNum; ?>" value="<?php echo $trainDATA['id']; ?>">

						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">Date<span class="redmind"></span></div>
						<?php } ?>
							
							<input name="trainDate<?php echo $countNum; ?>" readonly type="text" class="gridfield  calfieldicon" id="trainDate<?php echo $countNum; ?>" displayname="Train Date" value="<?php if($trainDATA['fromDate']!='0000-00-00'){ echo  date('d-m-Y',strtotime($trainDATA['fromDate'])); } ?>" /></label>
						</div>
						<script>
							$('#trainDate<?php echo $countNum; ?>').Zebra_DatePicker({
  								format: 'd-m-Y',
							});

						</script>
						
						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">From&nbsp;Destination<span class="redmind"></span></div>
						<?php } ?>
							<select name="trainDestination<?php echo $countNum; ?>" class="gridfield" id="trainDestination<?php echo $countNum; ?>" displayname="Train Destination" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id',_DESTINATION_MASTER_,'status=1 and deletestatus=0 and name!="" ');
								while($fromDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $fromDest['id']; ?>" <?php if($trainDATA['fromDestination']==$fromDest['id']){ echo 'selected'; } ?> ><?php echo ucfirst($fromDest['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">To&nbsp;Destination<span class="redmind"></span></div>
						<?php } ?>
							<select name="trainToDestination<?php echo $countNum; ?>" class="gridfield" id="trainToDestination<?php echo $countNum; ?>" displayname="Train To Destination" style="padding: 9.5px;">
								<option value="">Select</option>
								
								<?php
								$rsA = GetPageRecord('name,id',_DESTINATION_MASTER_,'status=1 and deletestatus=0 and name!="" ');
								while($traintoDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $traintoDest['id']; ?>" <?php if($trainDATA['toDestination']==$traintoDest['id']){ echo 'selected'; } ?> ><?php echo ucfirst($traintoDest['name']); ?></option>
								<?php }
								
								?>

							</select>
						</label>
						</div>
					
						
						<?php if($countNum==1){ ?>
						<div class="addbtn"><input type="button" name="" class="multiservicebtn" id="" value="+Add" onclick="loadAddMultipleServices('Train');"></div>

						<div class="addbtn"><i class="fa fa-trash-o multiservicebtn" aria-hidden="true" onclick="removeMultipleServices('<?php echo $insuranceDATA['id']; ?>','<?php echo $countNum; ?>','Train');"></i></div>
						<?php }else{
							?>
							<div class="addbtn" style="margin-top: 6px;"><i class="fa fa-trash-o multiservicebtn" aria-hidden="true" onclick="removeMultipleServices('<?php echo $insuranceDATA['id']; ?>','<?php echo $countNum; ?>','Train');"></i></div>
							<?php
						} ?>
					</div>
					
					<?php
						$countNum++;
						}
						?>
						<input type="hidden" name="countNumTrain" id="countNumTrain" value="<?php echo $countNum-1; ?>">
						<?php
					}else{

   					?>
					<div class="train_services">
						
					<div class="griddiv"><label>
						<div class="gridlable">Date<span class="redmind"></span></div>

							<input name="trainDate<?php echo $countNum; ?>" type="date" class="gridfield" id="trainDate<?php echo $countNum; ?>" displayname="Train Date" value="<?= date('Y-m-d',strtotime('now')); ?>" /></label>
						</div>
						<!-- ($editresult['fromDate']!='0000-00-00'){ } -->
						<div class="griddiv"><label>
						<div class="gridlable">From&nbsp;Destination<span class="redmind"></span></div>

							<select name="trainDestination<?php echo $countNum; ?>" class="gridfield" id="trainDestination<?php echo $countNum; ?>" displayname="Train Destination" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id',_DESTINATION_MASTER_,'status=1 and deletestatus=0 and name!="" ');
								while($fromDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $fromDest['id']; ?>" ><?php echo ucfirst($fromDest['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<div class="gridlable">To&nbsp;Destination<span class="redmind"></span></div>

							<select name="trainToDestination<?php echo $countNum; ?>" class="gridfield" id="trainToDestination<?php echo $countNum; ?>" displayname="Train To Destination" style="padding: 9.5px;">
								<option value="">Select</option>
								
								<?php
								$rsA = GetPageRecord('name,id',_DESTINATION_MASTER_,'status=1 and deletestatus=0 and name!="" ');
								while($toDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $toDest['id']; ?>"><?php echo ucfirst($toDest['name']); ?></option>
								<?php }
								
								?>

							</select>
						</label>
						</div>

					<div class="addbtn"><input type="button" name="" class="multiservicebtn" id="" value="+Add" onclick="loadAddMultipleServices('Train');"></div>
					</div>
					<input type="hidden" name="countNumTrain" id="countNumTrain" value="<?php if($countNum==1){
						echo '1';}else{ echo $countNum; } ?>">
					<?php } ?>

					<div id="addmultipleTrain"></div>

					</div>

					<!-- Train Service Code End -->

					<!-- Transfer Service code -->

					<div id="transfer_container" style="display: none;">
					<div class="serviceTitles">Transfer&nbsp;Service</div>
					<?php 
  						$countNum=1;

						$rsTQ = GetPageRecord('*','transferQueryMaster','status=1 and deletestatus=0 and queryId="'.$editresult['id'].'" order by multipleNo asc');
						if($num=mysqli_num_rows($rsTQ)>0){
							
						while($transferDATA = mysqli_fetch_assoc($rsTQ)){
							
							?>
						<div id="loadedservicesTransfer<?php echo $countNum; ?>" class="transfer_services">
						
						<input type="hidden" name="trnasferEditId<?php echo $countNum; ?>" id="trnasferEditId<?php echo $countNum; ?>" value="<?php echo $transferDATA['id']; ?>">

						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">Date<span class="redmind"></span></div>
						<?php } ?>

							<input name="transferDate<?php echo $countNum; ?>" readonly type="text" class="gridfield" id="transferDate<?php echo $countNum; ?>" displayname="Transfer Date" value="<?php if($transferDATA['fromDate']!='0000-00-00'){ echo  date('d-m-Y',strtotime($transferDATA['fromDate'])); } ?>" /></label>

						</div>
						<script>
							$('#transferDate<?php echo $countNum; ?>').Zebra_DatePicker({
  								format: 'd-m-Y',
							});

						</script>
					

						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">Destination<span class="redmind"></span></div>
						<?php } ?>
							<select name="transferDestination<?php echo $countNum; ?>" class="gridfield" id="transferDestination<?php echo $countNum; ?>" displayname="Transfer Destination" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id',_DESTINATION_MASTER_,'status=1 and deletestatus=0 and name!="" order by name asc');
								while($tptDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $tptDest['id']; ?>" <?php if($transferDATA['destinationId']==$tptDest['id']){ echo "selected"; } ?> ><?php echo ucfirst($tptDest['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">Transfer&nbsp;Type<span class="redmind"></span></div>
						<?php } ?>
							<select name="transferTypeId<?php echo $countNum; ?>" class="gridfield" id="transferTypeId<?php echo $countNum; ?>" onchange="getDestinationWiseTransfers<?php echo $countNum; ?>('<?php echo $countNum; ?>');" displayname="Transfer Type" style="padding: 9.5px;">
								<?php 
								$rsQ = GetPageRecord('*','transferTypeMaster','status=1 and name!="" order by name asc');
								while($tptTypeData = mysqli_fetch_assoc($rsQ)){
									?>
									<option value="<?php echo $tptTypeData['id']; ?>" <?php if($transferDATA['transferTypeId']==$tptTypeData['id']){ echo "selected"; } ?> > <?php echo $tptTypeData['name']; ?> </option>
									<?php
								}
								?>
							</select>
							</label>
						</div>

						<div class="griddiv"><label>
						<?php if($countNum==1){ ?>
						<div class="gridlable">Transfer&nbsp;Name<span class="redmind"></span></div>
						<?php } ?>
							<select name="transferNameId<?php echo $countNum; ?>" class="gridfield" id="transferNameId<?php echo $countNum; ?>" onchange="getTransferType<?php echo $countNum; ?>('<?php echo $countNum; ?>');" displayname="Transfer Name" style="padding: 9.5px;">
								
							</select>
						</label>
						</div>

						<script>
							function getDestinationWiseTransfers<?php echo $countNum; ?>(){
								var transferDestination = $("#transferDestination<?php echo $countNum; ?>").val();
								var transferTypeId = $("#transferTypeId<?php echo $countNum; ?>").val();

								$("#transferNameId<?php echo $countNum; ?>").load(`searchaction.php?action=getDestinationWiseTransfersforQuery&destinationId=${transferDestination}&transferTypeId=${transferTypeId}&transferNameId=<?php echo $transferDATA['transferNameId']; ?>`);
							}

							getDestinationWiseTransfers<?php echo $countNum; ?>();
						</script>
						
						<?php if($countNum==1){ ?>
						<div class="addbtn"><input type="button" name="" class="multiservicebtn" id="" value="+Add" onclick="loadAddMultipleServices('Transfer');"></div>

						<div class="addbtn"><i class="fa fa-trash-o multiservicebtn" aria-hidden="true" onclick="removeMultipleServices('<?php echo $insuranceDATA['id']; ?>','<?php echo $countNum; ?>','Insurance');"></i></div>
						<?php }else{
							?>
							<div class="addbtn" style="margin-top: 6px;"><i class="fa fa-trash-o multiservicebtn" aria-hidden="true" onclick="removeMultipleServices('<?php echo $insuranceDATA['id']; ?>','<?php echo $countNum; ?>','Transfer');"></i></div>
							<?php
						} ?>
					</div>
					
					<?php
						$countNum++;
						}
						?>
						<input type="hidden" name="countNumTransfer" id="countNumTransfer" value="<?php echo $countNum-1; ?>">
						<?php
					}else{

   					?>
					<div class="transfer_services">
						
						<div class="griddiv"><label>
						<div class="gridlable">Date<span class="redmind"></span></div>

							<input name="transferDate<?php echo $countNum; ?>" type="date" class="gridfield" id="transferDate<?php echo $countNum; ?>" displayname="Transfer Date" value="<?= date('Y-m-d',strtotime('now')); ?>" /></label>
						</div>

						<div class="griddiv"><label>
						<div class="gridlable">Destination<span class="redmind"></span></div>

							<select name="transferDestination<?php echo $countNum; ?>" class="gridfield" id="transferDestination<?php echo $countNum; ?>" displayname="Transfer Destination" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id',_DESTINATION_MASTER_,'status=1 and deletestatus=0 and name!="" order by name asc');
								while($countryDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $countryDest['id']; ?>" ><?php echo ucfirst($countryDest['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<div class="gridlable">Transfer&nbsp;Type<span class="redmind"></span></div>
							<select name="transferTypeId<?php echo $countNum; ?>" class="gridfield" id="transferTypeId<?php echo $countNum; ?>" onchange="getDestinationWiseTransfers<?php echo $countNum; ?>('<?php echo $countNum; ?>');" displayname="Transfer Type" style="padding: 9.5px;">
							<option value="">Select</option>
								<?php 
								$rsQ = GetPageRecord('*','transferTypeMaster','status=1 and name!="" order by name asc');
								while($tptTypeData = mysqli_fetch_assoc($rsQ)){
									?>
									<option value="<?php echo $tptTypeData['id']; ?>"> <?php echo $tptTypeData['name']; ?> </option>
									<?php
								}
								?>
							</select>
							</label>
						</div>

						<div class="griddiv"><label>
						<div class="gridlable">Transfer&nbsp;Name<span class="redmind"></span></div>

							<select name="transferNameId<?php echo $countNum; ?>" class="gridfield" id="transferNameId<?php echo $countNum; ?>" onchange="getTransferType<?php echo $countNum; ?>('<?php echo $countNum; ?>');" displayname="Transfer Name" style="padding: 9.5px;">
								
							</select>
						</label>
						</div>

						<script>
							function getDestinationWiseTransfers<?php echo $countNum; ?>(){
								var transferDestination = $("#transferDestination<?php echo $countNum; ?>").val();
								var transferTypeId = $("#transferTypeId<?php echo $countNum; ?>").val();

								$("#transferNameId<?php echo $countNum; ?>").load(`searchaction.php?action=getDestinationWiseTransfersforQuery&destinationId=${transferDestination}&transferTypeId=${transferTypeId}`);
							}

						
						</script>

						<div class="addbtn"><input type="button" name="" class="multiservicebtn" id="" value="+Add" onclick="loadAddMultipleServices('Transfer');"></div>
					</div>
					<input type="hidden" name="countNumTransfer" id="countNumTransfer" value="<?php if($countNum==1){
						echo '1';}else{ echo $countNum; } ?>">
					<?php } ?>

					<div id="addmultipleTransfer"></div>

					
					</div>

					<!-- Transfer Service code End -->

			</div>
	
		</td>
		<div id="deleteServiceRecord" style="display: none;"></div>

	</tr>


	<script>
		function loadAddMultipleServices(serviceType){
			var counNumService = $("#countNum"+serviceType).val();
			counNumService = Number(counNumService)+1;
			$.get(`searchaction.php?action=loadAppendMultiServices&id=${counNumService}&serviceType=${serviceType}`, function(data){
				$("#addmultiple"+serviceType).append(data);
			});
			$("#countNum"+serviceType).val(counNumService);
		}

		function removeMultipleServices(id,countNum,serviceType){
				var response = confirm('Are you Sure! You want to Delete This Service!');
				if(response==true){
					$("#loadedservices"+serviceType+countNum).remove();
					$("#deleteServiceRecord").load(`final_frmaction.php?action=deleteQueryMultipleservices&id=${id}&countNum=${countNum}&serviceType=${serviceType}`);
				}
		}
	</script>
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

	    <input name="mailId" type="hidden" id="mailId" value="<?php echo $incomingid; ?>" />

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
<!-- show hide section js -->
<script>
	function showHide1(){
		var show = document.getElementById("show-info");
		if(show.style.display=="none") {
			show.style.display = "block";
		}else{
			show.style.display = "none";
		}
	}
</script>

</form>

</div>


<script type="text/javascript">
				
			function gitcodefun(queryType){ 
				
				// var queryType = Number($('#queryType').val()); 
				// console.log(queryType);
				if(queryType==1){
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

					$('#roomTypeId').show();
					$('#onlyTFS').val('0');
					$('#totalrooms').val('0');

					$("#main-service-selection").show();
					$("#tranvel_info").show();
					$("#pax_detail_box").show();
					$("#hotel_category").show();
					$("#hotel_type").show();
					$("#tour_type").show();
					$("#meal_plan_box").show();
					$("#service_selection_box").hide();
					$('#night2').addClass('validate');
					$('#adult').addClass('validate');
					$('#serviceAdult').removeClass('validate');
					 
				}else if(queryType==2){
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
					
					$('#roomTypeId').show();
					$('#onlyTFS').val('0');
					$('#totalrooms').val('0');
					$("#main-service-selection").show();
					$("#tranvel_info").show();
					$("#pax_detail_box").show();
					$("#hotel_category").show();
					$("#hotel_type").show();
					$("#tour_type").show();
					$("#meal_plan_box").show();
					$("#service_selection_box").hide();
					$('#night2').addClass('validate');
					$('#adult').addClass('validate');
					$('#serviceAdult').removeClass('validate');
				}else if(queryType==3){
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
					
					$('#roomTypeId').show();
					$('#totalrooms').val('0');
					$('#onlyTFS').val('0');
					$("#main-service-selection").show();
					$("#tranvel_info").show();
					$("#pax_detail_box").show();
					$("#hotel_category").show();
					$("#hotel_type").show();
					$("#tour_type").show();
					$("#meal_plan_box").show();
					$("#service_selection_box").hide();
					$('#night2').addClass('validate');
					$('#adult').addClass('validate');
					$('#serviceAdult').removeClass('validate');
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
					
					$('#roomTypeId').show();
					
					$('#onlyTFS').val('0');
					$('#totalrooms').val('0');
					$("#main-service-selection").show();
					$("#tranvel_info").show();
					$("#pax_detail_box").show();
					$("#hotel_category").show();
					$("#hotel_type").show();
					$("#tour_type").show();
					$("#meal_plan_box").show();
					$("#service_selection_box").hide();
					$('#night2').addClass('validate');
					$('#adult').addClass('validate');
					$('#serviceAdult').removeClass('validate');
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
					
					$('#roomTypeId').show();
					
					$('#onlyTFS').val('0');
					$('#totalrooms').val('0');
					$("#main-service-selection").show();
					$("#tranvel_info").show();
					$("#pax_detail_box").show();
					$("#hotel_category").show();
					$("#hotel_type").show();
					$("#tour_type").show();
					$("#meal_plan_box").show();
					$("#service_selection_box").hide();

					$('#night2').addClass('validate');
					$('#adult').addClass('validate');
					$('#serviceAdult').removeClass('validate');
				}else if(queryType==6 || queryType==7 || queryType==8 || queryType==9 || queryType==10 || queryType==11 ){
					
					$('#roomTypeId').hide();
					
					$('#onlyTFS').val('1');
					$('#totalrooms').val('1');
					queryType = $("#queryType").val();

					if(queryType == 9){
						$("#visaRequired").html('<option value="1" selected="selected">Yes</option>');
						
					}
					if(queryType == 10){
						$("#insuranceRequired").html('<option value="1" selected="selected">Yes</option>');
						
					}
					if(queryType == 11){
						$("#passportRequired").html('<option value="1" selected="selected">Yes</option>');
						
					}
					
				}else if(queryType == 13){
					// $("#main-service-selection").hide();
					$("#tranvel_info").hide();
					$("#pax_detail_box").hide();
					$("#hotel_category").hide();
					$("#hotel_type").hide();
					$("#tour_type").hide();
					$("#meal_plan_box").hide();
					$("#service_selection_box").show();

					$('#night2').removeClass('validate');
					$('#adult').removeClass('validate');
					$('#totalrooms').val('1');

					$('#serviceAdult').addClass('validate');

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
				}else{
					
					$('#roomTypeId').show();
					$('#onlyTFS').val('0');
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
					$("#main-service-selection").show();
					$("#tranvel_info").show();
					$("#pax_detail_box").show();
					$("#hotel_category").show();
					$("#hotel_type").show();
					$("#tour_type").show();
					$("#meal_plan_box").show();
					$("#service_selection_box").hide();

					$('#night2').addClass('validate');
					$('#adult').addClass('validate');
					$('#serviceAdult').removeClass('validate');

				}
			}
				<?php if($queryType>0){ $queryType2=$queryType; }else{  $queryType2=1; } ?>
				gitcodefun('<?php echo $queryType2; ?>');  
		 

		</script>

<script>
			
			function selecteService(serviceName,btnType){
				
				var queryType = $("input[type='radio'][name='queryType']:checked").val();
				// var clienttype = $("input[type='radio'][name='clientType']:checked").val();
				if(btnType=="on"){
					$("#ServiceON_"+serviceName).css('display','inline-block');
					$("#serviceLable_"+serviceName).text('Yes');
					$("#need"+serviceName).val('1');
					$("#ServiceOFF_"+serviceName).hide();

					if(queryType==13){
					if(serviceName=="Flight"){
					$("#flight_container").show();

					$("#flightDate1").addClass('validate');
					$("#flightDestination1").addClass('validate');
					$("#flightToDestination1").addClass('validate');

					}
					if(serviceName=="Visa"){
					$("#visa_container").show();
					$("#visaDate1").addClass('validate');
					$("#visaDestination1").addClass('validate');
					$("#visaNameId1").addClass('validate');
					$("#visaTypeId1").addClass('validate');
					$("#visaValidity1").addClass('validate');
					$("#entryType1").addClass('validate');
					
					}

					if(serviceName=="Insurance"){
					$("#insurance_container").show();
					$("#insuranceFromDate1").addClass('validate');
					$("#insuranceToDate1").addClass('validate');
					$("#insuranceTypeId1").addClass('validate');
					$("#insuranceDestination1").addClass('validate');

					}

					if(serviceName=="Train"){
					$("#train_container").show();
					$("#trainDate1").addClass('validate');
					$("#trainDestination1").addClass('validate');
					$("#trainToDestination1").addClass('validate');

					}

					if(serviceName=="Transfer"){
					$("#transfer_container").show();

					$("#transferDate1").addClass('validate');
					$("#transferDestination1").addClass('validate');
					$("#transferTypeId1").addClass('validate');
					$("#transferNameId1").addClass('validate');
	
					}
				}
					
				}

				
			}

			function removeService(serviceName,btnType){
				if(btnType=="off"){
					$("#serviceLable_"+serviceName).text('No');
					$("#need"+serviceName).val('0');
					$("#ServiceOFF_"+serviceName).css('display','inline-block');
					$("#ServiceON_"+serviceName).hide();

					if(serviceName=="Flight"){
					$("#flight_container").hide();
					$("#flightDate1").removeClass('validate');
					$("#flightDestination1").removeClass('validate');
					$("#flightToDestination1").removeClass('validate');
					
					}

					if(serviceName=="Visa"){
					$("#visa_container").hide();

					$("#visaDate1").removeClass('validate');
					$("#visaDestination1").removeClass('validate');
					$("#visaNameId1").removeClass('validate');
					$("#visaTypeId1").removeClass('validate');
					$("#visaValidity1").removeClass('validate');
					$("#entryType1").removeClass('validate');
					}

					if(serviceName=="Insurance"){
					$("#insurance_container").hide();

					$("#insuranceFromDate1").removeClass('validate');
					$("#insuranceToDate1").removeClass('validate');
					$("#insuranceTypeId1").removeClass('validate');
					$("#insuranceDestination1").removeClass('validate');
					
					}

					if(serviceName=="Train"){
					$("#train_container").hide();
					$("#trainDate1").removeClass('validate');
					$("#trainDestination1").removeClass('validate');
					$("#trainToDestination1").removeClass('validate');
					
					}

					if(serviceName=="Transfer"){
					$("#transfer_container").hide();
					
					$("#transferDate1").removeClass('validate');
					$("#transferDestination1").removeClass('validate');
					$("#transferTypeId1").removeClass('validate');
					$("#transferNameId1").removeClass('validate');
					
					}
				}
			}

			

			<?php 
			if($editresult['needFlight']==1){
			?>
		
			selecteService('Flight','on');
	
			<?php
			}

			if($editresult['needVisa']==1){
			?>
	
			selecteService('Visa','on');

			<?php
			}

			if($editresult['needInsurance']==1){
			?>
		
			selecteService('Insurance','on');
	
			<?php
			}
		
			if($editresult['needTrain']==1){
			?>
	
			selecteService('Train','on');

			<?php
			}
			if($editresult['needTransfer']==1){
				?>
			selecteService('Transfer','on');
				<?php
			}
		
		if($editresult['needFlight']==0 || $editresult['needFlight']==''){
			?>
			removeService('Flight','off');
			<?php
		}

		if($editresult['needVisa']==0 || $editresult['needVisa']==''){
			?>
			removeService('Visa','off');
			<?php
		}

		if($editresult['needInsurance']==0 || $editresult['needInsurance']==''){
			?>
		
			removeService('Insurance','off');
	
			<?php
			}
			if($editresult['needTrain']==0 || $editresult['needTrain']==''){
			?>
		
			removeService('Train','off');
	
			<?php
			}
			if($editresult['needTransfer']==0 || $editresult['needTransfer']==''){
			?>
			removeService('Transfer','off');
			<?php
			}

	?>

	</script>



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
.mb5{
	margin-bottom: 5px!important;
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
	.travel_info_main{
		display:grid; grid-template-columns:1fr 1fr;
	}
	.serviceTitles{
		font-weight: 500;
    	font-size: 13px;
    	padding-bottom: 10px;
	}
	.multiservicebtn{
		background-color: #21d0b6;
		padding: 8px 16px;
    	font-weight: 500;
    	font-size: 15px;
    	border-radius: 5px;
    	border:1px solid #21d0b6;
		color: #FFF;
		cursor: pointer;
	}

	.addbtn{
		margin-top: 20px;
	}

	.flight_services{
		display: grid;
		grid-template-columns: 15% 15% 15% 8% 5%;
		grid-gap: 10px;
	}

	.visa_services{
		display: grid;
		grid-template-columns: 15% 14% 14% 10% 8% 12% 8% 5%;
		grid-gap: 10px;
	}
	.insurance_services{
		display: grid;
		grid-template-columns: 15% 15% 15% 15% 8% 5%;
		grid-gap: 10px;
	}

	.train_services{
		display: grid;
		grid-template-columns: 15% 15% 15% 8% 5%;
		grid-gap: 10px;
	}

	.transfer_services{
		display: grid;
		grid-template-columns: 15% 15% 15% 15% 8% 5%;
		grid-gap: 10px;
	}

</style>
