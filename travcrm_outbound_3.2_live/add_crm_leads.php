<?php
if($addpermission!=1 && $_GET['id']==''){
header('location:'.$fullurl.'');
}

if($editpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}


if($_REQUEST['queryId']!=''){
$queryId=decode($_REQUEST['queryId']);
}  


if($_REQUEST['parentType']!=''){
$parentType=$_REQUEST['parentType'];
} else { 

$parentType='lead';
}

$where="id='".$_SESSION['userid']."'"; 
$rs=GetPageRecord('firstName,lastName',_USER_MASTER_,$where); 
$userResult=mysqli_fetch_array($rs);
$userassignTo=  strip($userResult['firstName'].' '.$userResult['lastName']);

if($_GET['id']==''){

$rsold=GetPageRecord('leadsource','leadManageMaster','1 and leadsource!="" order by id desc limit 1'); 
$resresult=mysqli_fetch_array($rsold);
$leadsourceold = $resresult['leadsource'];


$wheredel='addedBy='.trim($_SESSION['userid']).' and deletestatus=1 and parentId="'.decode($_GET['leadid']).'" and parentType="'.$parentType.'" and queryId="'.$queryId.'"';
deleteRecord('leadManageMaster',$wheredel);

$dateAdded=time();
$namevalue ='deletestatus=1,addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'",parentId="'.decode($_GET['leadid']).'",parentType="'.$parentType.'",queryId="'.$queryId.'"';  
$lastqueryidmain= addlistinggetlastid('leadManageMaster',$namevalue);
}
 

if($_GET['cid']!='' && $_GET['clientType']==1){ 
$select1='*';  
$where1='id='.decode($_GET['cid']).''; 
$rs1=GetPageRecord($select1,_CORPORATE_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$editassignTo=clean($editresult['assignTo']); 
$editcompanyId=clean($editresult['id']); 
$clientType=$_GET['clientType'];
} 

if($_GET['cid']!='' && $_GET['clientType']==2){ 
$select1='*';  
$where1='id='.decode($_GET['cid']).''; 
$rs1=GetPageRecord($select1,_CONTACT_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$editassignTo=clean($editresult['assignTo']); 
$editcompanyId=clean($editresult['id']); 
$clientType=$_GET['clientType'];
}



if($_GET['id']!=''){
$id=clean(decode($_GET['id']));



$select1='*';  
$where1='id='.$id.''; 

$rs1=GetPageRecord($select1,'leadManageMaster',$where1); 
$editresult=mysqli_fetch_array($rs1);

$editassignTo=clean($editresult['assignTo']); 
$editcompanyId=clean($editresult['companyId']);
$editclientType=clean($editresult['clientType']); 
$edittravelDate=clean($editresult['travelDate']);
$editfromDate=clean($editresult['fromDate']);
$edittoDate=clean($editresult['toDate']);
$editofficeBranch=clean($editresult['officeBranch']);
$destinationId=clean($editresult['destinationId']); 
$editdescription=clean($editresult['description']);  
$editInfant=clean($editresult['Infant']);
$editChild=clean($editresult['Child']);
$editnight=clean($editresult['night2']);
$editremark=clean($editresult['remark']); 
$editsubject=clean($editresult['subject']); 
$editguest1=clean($editresult['guest1']);
$editadditionalInfo=clean($editresult['additionalInfo']);
$addedBy=clean($editresult['addedBy']);
$dateAdded=clean($editresult['dateAdded']); 
$modifyBy=clean($editresult['modifyBy']);
$modifyDate=clean($editresult['modifyDate']);  
$lastId=$editresult['id']; 
$lastqueryidmain=$editresult['id']; 
$fromDate=date("d-m-Y", strtotime($editresult['fromDate']));
$toDate=date("d-m-Y", strtotime($editresult['toDate']));
$night=$editresult['night']; 
$editstarttime=$editresult['starttime'];
$isDefault=$editresult['isDefault'];
$editendtime=$editresult['endtime'];
$followupdate=$editresult['followupdate'];
$followuptime=$editresult['followuptime'];
$directiontype=$editresult['directiontype'];
$dealSize=$editresult['dealSize'];
$salesStage=$editresult['salesStage'];
$campaign=$editresult['campaign'];
$leadsource=$editresult['leadsource'];
$clientType=$editresult['clientType'];
$statusedit=$editresult['status'];


if($editclientType == 1){  
	$where2='id='.$editcompanyId.''; 
	$rs2=GetPageRecord('*',_CORPORATE_MASTER_,$where2); 
	$contantnamemain=mysqli_fetch_array($rs2);
	$agentcontactPerson = getCorporateCompany($editcompanyId);
	$getemail = getPrimaryEmailCompany($editcompanyId,"corporate");
	$getphone = getPrimaryPhoneCompany($editcompanyId,"corporate");

$where3='addressType="corporate" and addressParent="'.$editcompanyId.'" order by id asc limit 1';
$addressResult=GetPageRecord('address,countryId','addressMaster',$where3); 
$addressResultData=mysqli_fetch_array($addressResult);
$getaddress = $addressResultData['address'];
$getcountry = $addressResultData['countryId'];
}
if($editclientType == 2){
  $where2='id='.$editcompanyId.''; 
	$rs2=GetPageRecord('*',_CONTACT_MASTER_,$where2);
	$contantnamemain=mysqli_fetch_array($rs2);
  $agentcontactPerson = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];
	$getphone =  getPrimaryPhone($contantnamemain['id'],'contacts');
	$getemail =  getPrimaryEmail($contantnamemain['id'],'contacts'); 

$where3='addressType="contacts" and addressParent="'.$editcompanyId.'" order by id asc limit 1';
$addressResult=GetPageRecord('address,countryId','addressMaster',$where3); 
$addressResultData=mysqli_fetch_array($addressResult);
$getaddress = $addressResultData['address'];
$getcountry = $addressResultData['countryId'];
}
}


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
	
	
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    	<td width="7%" align="left"> <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module'];?>" /><input type="button" name="Submit22" value="Back" class="whitembutton" ></a> </td>
      <td><div class="headingm" style="margin-left:0;"><span id="topheadingmain">
        <?php if($_GET['id']!=''){ ?>
        Update 
        <?php } else {  ?>
        Add
        <?php } ?>
          <?php echo $pageName; ?> </span></div></td>
      <td align="right"><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
            <td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
             
            <td style="padding-right:20px;">
<?php if($_REQUEST['rpage']!=''){ ?>
<a href="<?php echo decode($_REQUEST['rpage']); ?>"><input type="button" name="Submit22" value="Cancel" class="whitembutton"/></a>
<?php } else { ?>
<input type="button" name="Submit22" value="Cancel" class="whitembutton" <?php if($_GET['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  />
<?php } ?>
</td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<div id="pagelisterouter" style="padding-left:0px;">
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">
 
<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="editleads" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  	<!-- <tr>
    	<td colspan="2" align="left" valign="top" >
			<div class="innerbox">
      			<h2>Lead Information</h2>
    		</div>
		</td>
	</tr> -->


  	<tr>
		<!-- left side sec -->
    	<td width="35%" align="left" valign="top" style="padding-right:20px;">
		<div style="background-color: white; padding:5px 0px 0px 20px;border: 1px #ccc solid;cursor: pointer;    border-top-right-radius: 5px;
    border-top-left-radius: 5px" onclick="$('#showmorefield1').toggle();">
	<img style="font-size: 14px;position: relative;top: 0px;height: 20px;" src="images/curriculum-dom.png"> 
	<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;color: hsl(33 95% 68% / 1);">Contact Information</span>

	</div>
	<div style=" border:1px #ccc solid; padding:10px;border-top:0px; display:block; " >
			<div  style="display: grid;grid-template-columns: 1fr 1fr;grid-gap: 10px;">	
			<div class="griddiv">
			<label>
	
			<div class="gridlable">Lead Source<span class=""></span></div>
		<select id="leadsource" name="leadsource" class="gridfield " autocomplete="off"   >  
<!-- <option>Select</option>  -->
<?php

$select='';

$where='';

$rs=''; 

$select='*';  

$where='id!="" and deletestatus=0 and status=1 order by id';

$rs=GetPageRecord($select,'leadssourceMaster',$where);

while($rest=mysqli_fetch_array($rs)){ 
	if($leadsource>0){
		$ledsourceId = $leadsource;
	}else{
		$setDefault = $rest['setDefault'];
	}
	
?>

<option value="<?php echo $rest['id']; ?>" <?php if($ledsourceId==$rest['id']){ echo "selected"; }elseif($setDefault=='1'){ echo "selected"; } ?>><?php echo $rest['name']; ?></option> 

<?php
 }
 ?>

</select>
</label>
	</div> 


	

	<!-- <div style="display: grid;grid-template-columns: 20px auto;align-items: center;margin-left: 25px;">
	<input type="checkbox" name="default" style="display: block;" onClick="defaultTypeCheck();" id="default" />
	<input type="hidden" id="isDefault" name="isDefault" value="">
	<div style="font-weight: 500;color: #8a8a8a;">Set&nbsp;as&nbsp;Default</div>
	</div> -->	
</div>
<script>
 // function defaultTypeCheck(){
 //    let def = $("#default").is(":checked");
 //    if(def){
 //    $("#isDefault").val(1);
 //    }else{
 //    $("#isDefault").val(0);	
 //    }

 //  }
</script>

<?php if($isDefault == 1){ ?>
	<script>
		$("#default").prop("checked", true);
	</script>
<?php } ?>
<?php if($clientType!=''){ ?>
<style type="text/css">
.clientshow{
display: grid;
grid-template-columns: 1fr 1fr;
grid-gap: 10px;
}	

</style>
<?php } ?>	
<div style="display: grid;grid-gap: 10px;">
	

	<!-- <div class="griddiv"> -->
	<label>	
	<div class="gridlable" style="color: #8a8a8a;">Business Type<span class="redmind"></span></div>
	

	<div class="businessTypel" style="display: flex;">
		<div class="main-div-con">
			<div class="check_boxIndiv">
			<span class="check-box-title"> </span>

			B2C <input id="clientType" name="clientType" <?php if(1==$clientType){ ?>selected="selected"<?php } ?> class="check_box_input" checked="checked" type="radio" value="2" style="accent-color: cadetblue;"/>
			</div>
		</div>
		<div class="main-div-con">
			<div class="check_boxIndiv">
			<span class="check-box-title"> </span>

			Agent <input id="clientType" name="clientType" <?php if(2==$clientType){ ?>selected="selected"<?php } ?> class="check_box_input" type="radio" value="1" style="accent-color: cadetblue;"/>
			</div>
		</div>
	</div>
		

	<!-- </div> -->

	</div>

	<div class="griddiv" id="selectclientbox" style="overflow: unset;">
		<div onclick="openselectCompanypop();" style="position: absolute;cursor: pointer;top: 188px;right: 3px;background: #1cb095;color: white;padding: 10px 15px;border-radius: 5px;z-index: 1;">+ Add</div>

	<label>
		<script>
function openselectCompanypop(){
	var clientType1 = $('#clientType').val(); 	 
	alertspopupopen('action=selectCorporate&clientType='+clientType1,'600px','auto');
	}


 $(document).ready(function() {  
$('#fromDate').Zebra_DatePicker({ 
  format: 'd-m-Y',  
}); 

$('#toDate').Zebra_DatePicker({ 
  format: 'd-m-Y',  
});  
  });
</script>
	<?php
	if($clientType==2){
	$select2='firstName,lastName';  
$where2='id='.$editcompanyId.''; 
$rs2=GetPageRecord($select2,_CONTACT_MASTER_,$where2); 
$contantnamemain=mysqli_fetch_array($rs2);
$clientnem = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];
} else { 
$clientnem = getCorporateCompany($editcompanyId);
}


?>
	<div class="gridlable"><c id="agentTypeDiv">Name</c> <img style="position: relative;top: 3px;    right: -60px;width: 25px;" src="images/id-card-dom.png"><span class="redmind"></span></div>
	<div id="getcompanyName" style="display:none;position: absolute; background-color: #f5f5f5; border: 1px solid #ccc; z-index: 99; top: 57px; left: 0px; width: 100%; overflow: auto; max-height: 240px; box-shadow: 2px 2px 7px #0000003d;"></div>
	<input name="companyName" type="text" class="gridfield validate" id="companyName" placeholder="Company, Email, Phone, Contact Person" value="<?php echo $clientnem; ?>" displayname="Company" autocomplete="off" onkeydown="searchcompanynamefuncCompany();" onkeyup="searchcompanynamefuncCompany();" />
	<input name="companyId" type="hidden" id="companyId" value="<?php echo encode($editcompanyId); ?>" />
	</label>
	
	</div>

	<script>
function selectCorporate(name,country,email,phone,id,opsPerson,opsPersonId,address,salesPerson,selesPersonId){
	$('#companyName').val(name);
	$('#agentb2cmail').val(email);
	$('#agentb2cnumber').val(phone);
	$('#companyId').val(id);
	$('#country').val(country);
	$('#agentb2caddress').val(address);
	$('#salesPerson').val(salesPerson);
	$('#assignTo').val(selesPersonId);
	

	if(opsPerson!=''){
	$('#ownerName').val(opsPerson);
	$('#OpsAssignTo').val(opsPersonId);
	}else{
	$('#ownerName').val('');
	$('#OpsAssignTo').val('');
	}
	$('#getcompanyName').hide();
	}

	function searchcompanynamefuncCompany(){

			var searchcompanyname = encodeURIComponent($('#companyName').val());

			var clientType = $('#clientType').val();

			if(clientType!='' && clientType!='0'){

			$('#getcompanyName').load('loadcorporatecompany.php?clientType='+clientType+'&searchcompanyname='+searchcompanyname);
			console.log(searchcompanyname);

			}

			$('#getcompanyName').show();

			}
	
	function selectclienttypename(){
	$('#companyName').val('');
	$('#companyId').val('');
	var clientType = $('#clientType').val();
	if(clientType==1){
	$('#agentTypeDiv').text('Agent');
	}
	else if(clientType==2){
	$('#agentTypeDiv').text('B2C');
	}else{
	$('#agentTypeDiv').text('Agent/B2C');	
	}	
	
	}
	</script>
	<div style="display: grid;grid-template-columns: 1fr 1fr;grid-gap: 10px;">
	<div class="griddiv"><label>
	<div class="gridlable" style="width: 62%;"> 
		<!-- Contact&nbsp;Person	 -->
		<c id="agentTypeDiv">Contact Person<span class="redmind"></span></c> <img style="position: relative;top: 3px;    right: -60px;width: 25px;" src="images/contact-book-dom.png">
		<span class="redmind"></span></div>
	<input name="agentb2cname" readonly="true" type="text" class="gridfield validate" id="agentb2cname" value="<?php echo $agentcontactPerson; ?>"  displayname="Contact Person Name" />
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable" style="width: 65%;">
		<!-- Mobile Number -->
		<c id="agentTypeDiv">Contact Number<span class="redmind"></span></c> <img style="position: relative;top: 3px;    right: -60px;width: 23px;" src="images/viber-dom.png">
	</div>
	<input name="agentb2cnumber" readonly="true" type="text" class="gridfield validate" id="agentb2cnumber" value="<?php echo $getphone; ?>"  displayname="Mobile Number" maxlength="13" />
	</label>
	</div>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">
		 

		 <c id="agentTypeDiv">Email&nbsp;Address<span class="redmind"></span></c> <img style="position: relative;top: 3px;    right: -60px;width: 25px;" src="images/mail-dom.png">
		</div>
			<input name="agentb2cmail" readonly="true" type="text" class="gridfield validate" id="agentb2cmail" value="<?php echo $getemail; ?>"  displayname="Address" maxlength="200" style="width: 80%;"/>
			</label>
			</div>
		<div class="griddiv" style="display: none;"><label>
			<div class="gridlable">Address</div>
			<input name="agentb2caddress" readonly="true" type="text" class="gridfield" id="agentb2caddress" value="<?php echo $getaddress  ?>"  displayname="Address" />
			</label>
			</div>

			<div class="griddiv"><label>
			<div class="gridlable">Lead Pax Name</div>
			<input name="guest1" type="text" class="gridfield" id="guest1" value="<?php echo $editguest1; ?>"  displayname="lead Pax Name" maxlength="200" />
			</label>
			</div>

			<div class="griddiv"><label>
			<div class="gridlable">Subject</div>
			<input name="subject" type="text" class="gridfield" id="subject" value="<?php echo $editsubject; ?>"  displayname="Subject" maxlength="200" />
			</label>
			</div>	
			<div class="griddiv" style=" margin-top:0px;">
		<label>
		<div class="gridlable" style="width:100%;font-size: 13px;">Additional Information</div>
		<textarea  name="additionalInfo" class="gridfield" id="additionalInfo" style="min-height: 60px;"> <?php echo $editadditionalInfo; ?></textarea>
		</label>
		</div>




	</div>
		
	</td>

	<!-- midd sec -->
	<td width="30%" valign="top" style="padding-right: 20px;">

	<div style="background-color: white; padding:5px 0px 0px 20px;border: 1px #ccc solid;cursor: pointer;    border-top-right-radius: 5px;
    border-top-left-radius: 5px" onclick="$('#showmorefield1').toggle();">
	<img style="font-size: 14px;position: relative;top: 0px;height: 20px;" src="images/itinerary-lead.png"> 
	<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;color: hsl(33 95% 68% / 1);">Travel Information</span>

	</div>
	<div style=" border:1px #ccc solid; padding:10px;border-top:0px; display:block; " >


	<div class="date-room-adult-sec" style="">
		<div class="date-select-sec" style="display:flex;">

			<div class="griddiv" style="width: 120px;"><label>
				<div class="gridlable" style="width: 65%;">From Date  <span class=""></span></div>
					<input name="fromDate2" type="text" id="fromDate2" class="gridfield calfieldicon" displayname="From Travel Date" autocomplete="off" value="<?php if($editfromDate!='1970-01-01' && $editfromDate != '' ){ echo date('d-m-Y',strtotime($editfromDate)); }else{ echo date('d-m-Y'); } ?>" readonly="readonly" style="position: relative; top: auto; right: auto; bottom: auto; left: auto;"></label>
			</div>
			<div class="griddiv" style="width: 120px;position: relative;left: 20px;"><label>
				<div class="gridlable " style="width: 65%;">To Date <span class=""></span></div>
					<input name="toDate2" type="text" id="toDate2"  class="gridfield calfieldicon" displayname="To Travel Date" autocomplete="off" value="<?php if($edittoDate!='1970-01-01' && $edittoDate != '' ){ echo date('d-m-Y',strtotime($edittoDate)); }else{ echo date('d-m-Y'); } ?>" readonly="readonly" style="position: relative; top: auto; right: auto; bottom: auto; left: auto;"></label>
			</div>
			
			<div class="griddiv" style="width: 100px;"><label style="margin-left: 40px;">
				<div class="gridlable" style="width: 76%;">Nights <span class="" style="margin-left: 40px;"></span></div>
					<input name="night2" type="text" class="gridfield  numeric" id="night2"  style="width: 52px !important;margin-left: 40px;" maxlength="3" max="99" min="1"  displayname="Night"    value="<?php  echo $editnight; ?>" onkeyup="changenights();" /></label>
			</div>

			
			<div class="griddiv" style="width: 50px;">
			<a href="#" style="font-size: 12px;background-color: #1cb095;color: #fff !important;padding: 11px 8px;margin-right: 0px;margin-top: 20px;display: block;text-align: center;margin-left: 1px;border-radius: 5px;" onclick="generateQueryDay_function();">+ Add</a>
			</div>
		</div>

		<div class="adult-select-sec">
		<table style="display: none1;" width="100%" border="0" class="griddiv" cellpadding="0" cellspacing="0" id="paxCountId">
			<tr>
				<td width="25%" align="left" valign="top"><label >
					<div class="gridlable">Adult<img style="position: relative;top: 3px;height: 15px;right: -15px;" src="images/man-dom.png"><span class=""></span></div><input name="adult" type="text" class="gridfield " style="width: 94%;" onKeyUp="numericFilter(this);" id="adult" displayname="Adult" value="<?php echo $editresult['adult']; ?>" maxlength="3" /></label><?php if($queryType ==3){ echo $rmadult; } ?></td>
					<td width="25%" align="left" valign="top"><label style=" position: relative; "> 
					<div class="gridlable">Child<img style="position: relative;top: 3px;height: 15px;right: -15px;" src="images/child-dom.png"></div> 
					
					<input name="child" type="text" style="width: 94%;" class="gridfield" id="child" onKeyUp="numericFilter(this);showcwbroom();showChildAge();" displayname="Child" value="<?php echo $editresult['Child']; ?>" maxlength="3" />
					</label><?php if($queryType ==3){ echo $editChild; } ?></td>
					<td width="25%" align="left" valign="top">
					<label>
					<div class="gridlable">Infant<img style="position: relative;top: 3px;height: 15px;right: -15px;" src="images/crawl-dom.png"></div>
					<input name="infant" type="text" style="width: 94%;" class="gridfield" id="infant" onKeyUp="numericFilter(this);" displayname="Infant" value="<?php echo $editInfant; ?>" maxlength="3" />
					</label></td>
				
			</tr>
		</table>
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
			
			<?php if(isRoomActive('quadroom')==true){ ?> 
			<td align="left" colspan="2" valign="top">Quad Room</td>
			<?php } ?>
		</tr>
		<tr>
		
			<td align="left" colspan="2" valign="top"><input style="width: 94%;" name="tplRoom" type="text" oninput="getRoomCount(4)" class="gridfield mb5 numeric" id="tplRoom" value="<?php echo $editresult['tplRoom']; ?>" maxlength="3">
				<?php if($queryType ==3){ echo $rmtplRoom; } ?>
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
		<!-- fromDate2,toDate2,night2,adult,Child,Infant,sglRoom,dblRoom,twinRoom,tplRoom,quadNoofRoom
		extraNoofBed,cwbRoom,cnbRoom -->

		<tr>
			<td align="left" colspan="2" valign="top">ExtraBed(A)</td>
			<td align="left" colspan="2" valign="top"><div class="showcwbroom">CWBed</div></td>
			<td align="left" colspan="2" valign="top"><div class="showcwbroom">CNBed</div></td>
			<?php if(isRoomActive('teenbed')==true){ ?> 
			<td align="left" colspan="2" valign="top"><div class="showcwbroom">Teen Room</div></td>
			<?php } ?>
		</tr>
		<tr>
			<td align="left" colspan="2" valign="top"><input  style="width: 94%;" name="extraNoofBed" type="text" class="gridfield mb5 numeric" id="extraNoofBed" value="<?php echo $editresult['extraNoofBed']; ?>" maxlength="3">
				<?php if($queryType ==3){ echo $rmextraNoofBed; } ?>
			</td>
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
		
	</table>
		</div>
	</div>	
	</td>

	<!-- right sec -->
    <td width="35%" align="left" valign="top" style="padding-left:0px;">
<!-- <div class="griddiv" style="border-bottom: none;">
<label>
	<div>&nbsp;</div>
	<input name="test" type="text" class="gridfield" style="border:none" disabled="disabled" />
	</label>
	</div> -->
		<div style="background-color: white; padding:5px 0px 0px 20px;border: 1px #ccc solid;cursor: pointer;    border-top-right-radius: 5px;
		border-top-left-radius: 5px" onclick="$('#showmorefield1').toggle();">
		<img style="font-size: 14px;position: relative;top: 0px;height: 20px;" src="images/user-lead.png"> 
		<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;color: hsl(33 95% 68% / 1);">Assignment</span>

		</div>
		<div style=" border:1px #ccc solid; padding:10px;border-top:0px; display:block; " >

		<div style="display: grid;grid-template-columns: 1fr 1fr;grid-gap: 10px;">
		<div class="griddiv">
		<label>
		<div class="gridlable">Sales Person<img src="images/add-user-lead.png" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;" onclick="alertspopupopen1('action=selectParent&userType=1','600px','auto');" /></div>
		<input name="salesPerson" type="text" readonly class="gridfield" id="salesPerson" value="<?php echo getUserName($editassignTo); ?>" readonly="true" displayname="Sales Person" autocomplete="off"/>
		<input name="assignTo" type="hidden" id="assignTo" value="<?php echo encode($editassignTo); ?>" /></div>
		</label>
	</div>


	<div style="display: grid;grid-template-columns: 1fr 1fr;grid-gap: 10px;">
	
		<div class="griddiv"><img src="images/add-user-lead.png" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;" onclick="alertspopupopen('action=selectParent&userType=1','600px','auto');" />
		<label>
		<div class="gridlable" style="width:70%;">Operation Person<span class=""></span></div>
		<div id="selectOpsPerson"><input name="ownerName" type="text" class="gridfield " id="ownerName" value="<?php echo getUserName($editassignTo); ?>" readonly="true" displayname="Assign To" autocomplete="off" onclick="alertspopupopen('action=selectParent&userType=2','600px','auto');" />
		<input name="OpsAssignTo" type="hidden" id="OpsAssignTo" value="<?php echo encode($editassignTo); ?>" /></div>
		</label>
		</div>


		<div class="griddiv">
			<!-- <img src="images/userrole.png" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;" onclick="alertspopupopen1('action=selectParent&userType=1','600px','auto');" /> -->
		<label>
		<div class="gridlable" style="width:70%;">Contracting Person<span class=""></span></div>
		<div id="selectOpsPerson1"><input name="ownerName1" type="text" class="gridfield " id="ownerName1" value="" readonly="true" displayname="Assign To" autocomplete="off" onclick="alertspopupopen1('action=selectParent&userType=2','600px','auto');" />
		<input name="OpsAssignTo" type="hidden" id="OpsAssignTo1" value="<?php echo encode($editassignTo); ?>" /></div>
		</label>
	</div>

	
	</div>


	
		
	
	<?php if($_GET['id'] == ''){ ?>
	<script>
		function selectOwner(name,id){
	$('#ownerName').val(name);
	$('#OpsAssignTo').val(id);
	}
		selectOwner('<?php echo $userassignTo ?>','<?php echo encode($_SESSION['userid']) ?>');
	</script>
<?php } ?>
	<div style="display: grid;grid-template-columns: 1fr 1fr;grid-gap: 10px;">
	
	<div class="griddiv" style="display:none;"><label>
	<div class="gridlable" style="width:70%;"> Contact Number</div>
	<input name="contactnumber" type="text" class="gridfield" id="contactnumber" value="<?php ?>"  displayname="Contact Number" maxlength="13" />
	</label>
	</div>	
	</div>
	<div style="display: grid;grid-template-columns: 1fr 1fr;grid-gap: 10px;display:none;"" >
	<div class="griddiv"><label>
	<div class="gridlable">Country</div>
	<select id="country" readonly="readonly" name="country" class="gridfield" displayname="Country" autocomplete="off"   > 
<option value="">Select</option>
<?php

$select='';

$where='';

$rs=''; 

$select='*';  

$where='name!="" and deletestatus=0  order by name asc';

$rs=GetPageRecord('id,name',_COUNTRY_MASTER_,$where);

while($rest=mysqli_fetch_array($rs)){ 

?>

<option value="<?php echo $rest['id']; ?>" <?php if($getcountry==$rest['id']){ ?>selected="selected"<?php } ?>><?php echo $rest['name']; ?></option> 

<?php } ?>

</select>

	</label>
	</div>
	<div class="griddiv" style="display:none;"><label>
	<div class="gridlable"> Destination </div>
	<select name="destinationId[]" multiple="multiple" class="gridfield js-example-basic-multiple" id="destinationId
"   displayname="Destination" autocomplete="off"> 

		<option value="">Select</option> 

		<?php 

		$select=''; 

		$where=''; 

		$rs='';  

		$select='*';    

		$where='1 and deletestatus = 0 order by name asc';  

		$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 

		while($resListing=mysqli_fetch_array($rs)){ 

		$destination = array_map('trim', explode(",", $editresult['destination']));

		?> 

		<option value="<?php echo strip($resListing['id']); ?>" <?php foreach($destination as $key => $value){ if($resListing['id']==$value){ echo 'selected="selected"'; } } ?> ><?php echo strip($resListing['name']); ?></option> 

		<?php } ?> 

		</select>
	</label>
	</div>	
	</div>	
<script type="text/javascript"  src="plugins/select2/select2.min.js"></script>
  <script>  

    $(document).ready(function() {

        $('.js-example-basic-multiple').select2();

    });

   

    </script> 

	<style> 

	.select2-container {

		 width:100% !important;;

	} 

  .select2-container--open{

	 z-index: 9999999999 !important;

}

  </style>
	
	</div>


	<div style="background-color: white; padding:5px 0px 0px 20px;border: 1px #ccc solid;cursor: pointer;    border-top-right-radius: 5px;
    border-top-left-radius: 5px;margin-top: 10px;" onclick="showMeetingInfo();" >
	<img style="font-size: 14px;position: relative;top: 0px;height: 20px;" src="images/meeting-lead.png" > 
	<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;color: hsl(33 95% 68% / 1);" >Meeting&nbsp;Information<img style="font-size: 14px;position: relative;top: 5px;height: 10px;float: right;margin-right: 20px;" src="images/right-arrow-lead.png"> </span>

	</div>
	<div style=" border:1px #ccc solid; padding:10px;border-top:0px; display:block; " >
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 <!-- <tr>
    <td colspan="2" align="left" valign="top" >
		<div class="innerbox" onclick="showMeetingInfo();" style="cursor:pointer;">
      		<h2>Meeting&nbsp;Information</h2>
    	</div>
	</td>
 </tr> -->

 <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	<div id="timelingInfo" style="display:none;">
<div style="display:grid;grid-template-columns: 1fr 1fr 1fr;grid-gap: 10px;">
	<div class="griddiv">
	<label>
	<div class="gridlable">Start&nbsp;Date</div>
	<input name="fromDate" type="text" id="fromDate"   class="gridfield calfieldicon"  displayname="Start Date"   autocomplete="off" value="<?php if($_GET['id'] != ''){ echo $fromDate; } else{ echo date('d-m-Y'); } ?>" />
	</label>
	</div>
<div class="griddiv">
	<label>
	<div class="gridlable">Start&nbsp;Time</div>
	<select id="starttime" name="starttime" class="gridfield" autocomplete="off"   > 

<?php

$start=strtotime('00:00');
   $end=strtotime('23:30');
    for ($i=$start;$i<=$end;$i = $i + 15*60)

    { ?>

   <option value="<?php echo date('g:i A',$i); ?>" <?php if('9:00 AM'==date('g:i A',$i) && $_REQUEST['id']==''){ ?> selected="selected"<?php } ?> <?php if($editstarttime==date('g:i A',$i)){ ?> selected="selected"<?php } ?>><?php echo date('g:i A',$i); ?></option>;

    <?php  }  ?>


</select>

 </label>
	</div>
	<div class="griddiv">
	<label>	
	<div class="gridlable">End&nbsp;Time</div>
<select id="endtime" name="endtime" class="gridfield" autocomplete="off"   > 
<option value="">Select</option>
<?php

$start=strtotime('00:00');
   $end=strtotime('23:30');
    for ($i=$start;$i<=$end;$i = $i + 15*60) { ?>

   <option value="<?php echo date('g:i A',$i); ?>" <?php if($editendtime==date('g:i A',$i)){ ?> selected="selected"<?php } ?>><?php echo date('g:i A',$i); ?></option>;

    <?php  }  ?>


</select></label>
	</div>	
</div>
<div style="display:grid;grid-template-columns: 1fr 1fr 1fr;grid-gap: 10px;">
	<div class="griddiv">
	<label>
	<div class="gridlable">Next&nbsp;Follow&nbsp;Up&nbsp;Date</div>
	<input name="followupdate" type="text" id="followupdate"   class="gridfield calfieldicon"  displayname="Next Follow Up Date"   autocomplete="off" value="<?php if($followupdate!=''){ echo date('d-m-Y',strtotime($followupdate)); }else{ echo date('d-m-Y', strtotime("+2 days")); } ?>" />
	</label>
	</div>
		<div class="griddiv">
	<label>	
	<div class="gridlable">Next&nbsp;Follow&nbsp;Up&nbsp;Time</div>
	<select id="followuptime" name="followuptime" class="gridfield" autocomplete="off"   > 

<?php

$start=strtotime('00:00');

   $end=strtotime('23:30');
    for ($i=$start;$i<=$end;$i = $i + 15*60) { ?> 

    <option value="<?php echo date('g:i A',$i); ?>" <?php if('11:00 AM'==date('g:i A',$i) && $_REQUEST['id']==''){  ?> selected="selected"<?php } ?> <?php if($followuptime==date('g:i A',$i)){ ?> selected="selected"<?php } ?>><?php echo date('g:i A',$i); ?></option>;

    <?php  }  ?>

</select>

</label>
	</div>
	<div class="griddiv">
	<label>	
	<div class="gridlable">Reminder&nbsp;Time</div>
	<select id="reminderTime" name="reminderTime" class="gridfield" autocomplete="off"   > 
<option value="15" >Before 15 Min.</option>  
   <option value="30" >Before 30 Min.</option>  
   <option value="45" >Before 45 Min.</option>  
   <option value="60" >Before 1 Hour</option>  
   <option value="120" >Before 2 Hour</option>

</select>

</label>
	</div>
</div>	
	<div style="display: grid;grid-template-columns:1fr 1fr 1fr 1fr 1fr;grid-gap: 10px;">
	<div class="griddiv">
	<label>
	<div class="gridlable">Sales&nbsp;Stage</div>
	<select id="salesStage" name="salesStage" class="gridfield" displayname="Sales Stage" autocomplete="off"  >
	 <option value="">Select</option> 

<?php 
$where='id!="" and status=1 order by id'; 
$rs=GetPageRecord('name,id','salesStageMaster',$where); 
while($rest=mysqli_fetch_array($rs)){ 

?>

<option value="<?php echo $rest['id']; ?>" <?php if($salesStage==$rest['id']){ ?>selected="selected"<?php } ?>><?php echo $rest['name']; ?></option> 

<?php } ?>
</select>
</label>
	</div>	
	
	<div class="griddiv">
	<label>
	<div class="gridlable">Meeting&nbsp;Outcome</div>
	<select id="directiontype" name="directiontype" class="gridfield" displayname="Meeting Outcome" autocomplete="off"  >
	 <option value="">Select</option> 

<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='id!="" order by id'; 
$rs=GetPageRecord($select,_MEETINGS_OUTCOME_,$where); 
while($rest=mysqli_fetch_array($rs)){ 

?>

<option value="<?php echo $rest['id']; ?>" <?php if($directiontype==$rest['id']){ ?>selected="selected"<?php } ?>><?php echo $rest['name']; ?></option> 

<?php } ?>
</select>
</label>
	</div>	
		
		<div class="griddiv"><label>
	<div class="gridlable">Deal&nbsp;Size</div>
	<input name="dealSize" type="text" class="gridfield" id="dealSize" value="<?php echo $dealSize; ?>"  displayname="Deal Size" />
	</label>
	</div>

	<div class="griddiv">
	<label>
	<div class="gridlable">Status  </div>
	 

<select id="status" name="status" class="gridfield" autocomplete="off"   > 

<?php

$select='';

$where='';

$rs=''; 

$select='*';  

$where='id!="" order by id';

$rs=GetPageRecord($select,_CALLS_STATUS_MASTER_,$where);

while($rest=mysqli_fetch_array($rs)){ 

?>

<option value="<?php echo $rest['id']; ?>" <?php if($statusedit==$rest['id']){ ?>selected="selected"<?php } ?>><?php echo $rest['name']; ?></option> 

<?php } ?>

</select>

</label>
	</div>

<div id="taskhide" onclick="alertspopupopen('action=leadAssignTask&id=<?php echo encode($lastqueryidmain); ?>','1000px','auto');" style="padding: 3px;width: 73px;height: 20px;background: #639ed1;color: white;border-radius: 3px;cursor: pointer;align-self: center;justify-self: end;">Assign Task</div>
	<div id="tasksaved" style="display: none;line-height: 40px;color: #055b05;font-weight: 500;font-size: 13px;align-self: center;justify-self: end;">Task assigned Successfuly.</div>
	</div>
	
	</div>


		</td>
		
   
  </tr>
 <?php 
 if($_GET['id'] == ''){ ?>
  <tr>
    <td colspan="2" align="left" valign="top"  >

<div id="tasksaved" style="display: none;line-height: 40px;color: #055b05;font-weight: 500;font-size: 13px;">Task assigned Successfuly.</div><br>
</td>
    </tr>
  <?php } ?>
  <tr>
    <td colspan="2" align="left" valign="top"  >

	</td>
    </tr>
</table>

	</div>
	
	 </td>

	 
  </tr>

  
 
</table>
<br><br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 

 <tr>
    		
    <td width="48%" align="left" valign="top" style="padding-left:10px;">

	<div style="background-color: white; padding:5px 0px 0px 20px;border: 1px #ccc solid;cursor: pointer;    border-top-right-radius: 5px;
    border-top-left-radius: 5px" onclick="$('#showmorefield1').toggle();">
	<img style="font-size: 14px;position: relative;top: 0px;height: 20px;" src="images/edit-info-lead.png"> 
	<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;color: hsl(33 95% 68% / 1);">Description</span>

	</div>
	<div style=" border:1px #ccc solid; padding:10px;border-top:0px; display:block; " >

	<div class="griddiv" style="border: 1px;"><label>
	<!-- <div class="gridlable">Description</div> -->
	<textarea name="description" rows="9" class="gridfield" id="description"><?php echo $editdescription; ?></textarea>
	</label>
	</div>

	</div>
	
	</td>
  </tr>
 <?php 
 if($_GET['id'] == ''){ ?>
  <tr>
    <td colspan="2" align="left" valign="top"  >

<div id="tasksaved" style="display: none;line-height: 40px;color: #055b05;font-weight: 500;font-size: 13px;">Task assigned Successfuly.</div><br>
</td>
    </tr>
  <?php } ?>
  <tr>
    <td colspan="2" align="left" valign="top"  >

	</td>
    </tr>
</table>

</div>

<script>
	function showMeetingInfo(){
			$("#timelingInfo").toggle();
	}
	

</script>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td> <input name="rpage" type="hidden" id="rpage" value="<?php echo decode($_REQUEST['rpage']); ?>" />
		<input name="editId" type="hidden" id="editId" value="<?php if($lastqueryidmain!=''){ echo encode($lastqueryidmain); } ?>" />
		<input name="leadid" type="hidden" id="leadid" value="<?php echo $_REQUEST['leadid'];   ?>" />
		<input name="queryedityes" type="hidden" id="queryedityes" value="<?php if($clientType!=''){ echo 'yes'; } else { echo 'no'; }?>" />
		 <input name="eventId" type="hidden" id="eventId" value="<?php echo $_REQUEST['queryId'];   ?>" />
		<input name="editedityes" type="hidden" id="editedityes" value="<?php if($_REQUEST['id']!=''){ echo '1'; } else { echo '0'; } ?>" />
	 
		</td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        
        <td style="padding-right:20px;"><?php if($_REQUEST['rpage']!=''){ ?>
<a href="<?php echo decode($_REQUEST['rpage']); ?>"><input type="button" name="Submit22" value="Cancel" class="whitembutton"/></a>
<?php } else { ?>
<input type="button" name="Submit22" value="Cancel" class="whitembutton" <?php if($_GET['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  />
<?php } ?>
</td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

 


</form>
 
</div>
<script>  

function changePriority(){
var adult = $('#adult').val();
if(adult>9){ 
$('#queryPriority').val('3');
} 


}

window.setInterval(function(){
changePriority()
}, 1000);



comtabopenclose('linkbox','op2');

function toTimestamp(strDate){
   var datum = Date.parse(strDate);
   return datum/1000;
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

 

function changedatefunction(){
  var fromDate = $('#fromDate').val().split("-").reverse().join("-");
  var toDate = $('#toDate').val().split("-").reverse().join("-");
   
  
  var fromDatestamp = toTimestamp(''+fromDate+'');
  var toDatestamp = toTimestamp(''+toDate+''); 
  
 if(fromDate!= '' && fromDate!= '' && fromDatestamp>= toDatestamp)
    {
    alert("Please ensure that the To Travel Date is greater than From Travel Date."); 
    $('#toDate').val(''); 
    }
  var totaldays = showDays(toDate,fromDate);
  if(totaldays!='' || totaldays!='0'){   
  $('#night').val(totaldays);
  var night = totaldays;
if(night<6){
$('#queryPriority').val('3');
}
  } 
} 




</script>

<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
    width: 100% !important;
}

.addeditpagebox .griddiv .gridlable {
    color: #8a8a8a;
    width: 50%;
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
		display: block;
	}

	#mceu_15{
		padding: 19px;
    	background: white;
	}
	#mceu_23{
		background: white;
	}
	#mceu_0,#mceu_1,#mceu_2,#mceu_3,#mceu_4,#mceu_5,#mceu_6,#mceu_7,#mceu_8,#mceu_9,#mceu_10,#mceu_11,#mceu_12,#mceu_13,#mceu_14{
		background: white;
	}

	.iframe{
		width: 100%;
    height: 171px;
    display: block;
    border: 1px solid #9c9696;
    border-radius: 5px;
	}

	#mceu_32{
		display: none;
	}



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
