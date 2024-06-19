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


if($_GET['id']==''){

$wheredel='addedBy='.trim($_SESSION['userid']).' and deletestatus=1 and parentId="'.decode($_GET['leadid']).'" and parentType="'.$parentType.'" and queryId="'.$queryId.'"';
deleteRecord(_TASKS_MASTER_,$wheredel);

$dateAdded=time();
$namevalue ='deletestatus=1,addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'",parentId="'.decode($_GET['leadid']).'",parentType="'.$parentType.'",queryId="'.$queryId.'"';  
$lastqueryidmain= addlistinggetlastid(_TASKS_MASTER_,$namevalue);
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

$rs1=GetPageRecord($select1,_TASKS_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$editassignTo=clean($editresult['assignTo']); 
$editcompanyId=clean($editresult['companyId']); 
$edittravelDate=clean($editresult['travelDate']);
$editfromDate=clean($editresult['fromDate']);
$edittoDate=clean($editresult['toDate']);
$editofficeBranch=clean($editresult['officeBranch']);
$destinationId=clean($editresult['destinationId']); 
$editdescription=clean($editresult['description']);  
$editremark=clean($editresult['remark']); 
$editsubject=clean($editresult['subject']); 
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
$editendtime=$editresult['endtime'];
$followupdate=$editresult['followupdate'];
$followuptime=$editresult['followuptime'];
$directiontype=$editresult['directiontype'];
$campaign=$editresult['campaign'];
$leadsource=$editresult['leadsource'];
$clientType=$editresult['clientType'];
$statusedit=$editresult['status'];


$where2='corporateId='.$editcompanyId.' order by id asc limit 1'; 
$rs2=GetPageRecord('*','contactPersonMaster',$where2); 
$editresult2=mysqli_fetch_array($rs2);
$agentemail=decode($editresult2['email']);
$agentphone=decode($editresult2['phone']);
$agentcontactPerson=$editresult2['contactPerson'];
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
<div id="addAgentfromquery" style="background-image: url('images/bgpop.png'); background-repeat: repeat;">
				<div class="loadaddagentfile"></div>
				</div>
<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="edittasks" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Information</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	
<div class="griddiv">
	<label>
	
	<div class="gridlable">Lead Source<span class="redmind"></span></div>
	<select id="leadsource" name="leadsource" class="gridfield validate" autocomplete="off"   >  
<option>Select</option> 
<?php

$select='';

$where='';

$rs=''; 

$select='*';  

$where='id!="" and deletestatus=0 and status=1 order by id';

$rs=GetPageRecord($select,'leadssourceMaster',$where);

while($rest=mysqli_fetch_array($rs)){ 

?>

<option value="<?php echo $rest['id']; ?>" <?php if($leadsource==$rest['id']){ ?>selected="selected"<?php } ?>><?php echo $rest['name']; ?></option> 

<?php } ?>

</select>
</label>
	</div>

<div style="display: grid;grid-template-columns: 1fr 1fr;grid-gap: 10px;">
	<div class="griddiv">
	<label>	
	<div class="gridlable">Business Type<span class="redmind"></span></div>
	<select id="clientType" name="clientType" class="gridfield validate" displayname="Client Type" autocomplete="off" onchange="selectclienttypename();"    >
	 <!-- <option value="">Select</option>  -->
<option value="1" <?php if(1==$clientType){ ?>selected="selected"<?php } ?>>Agent</option> 
<option value="2" <?php if(2==$clientType){ ?>selected="selected"<?php } ?>>B2C</option> 
<option value="10" <?php if(10==$clientType){ ?>selected="selected"<?php } ?>>My Task</option> 
</select></label>

	</div>
	<div class="griddiv" id="selectclientbox" style="overflow: unset;">
		<div onclick="openselectCompanypop('action=addAgentClienttoQuery&actionType=addserviceagentclient&addTo=tasks','700px');" style="position: absolute;cursor: pointer;top: 22px;right: 3px;background: #233a49;color: white;padding: 8px 5px;">Add New</div>

	<label>
	<script>
	function selectCorporate(name,country,email,phone,id,opsPerson,opsPersonId,address){
	$('#companyName').val(name);
	$('#agentb2cmail').val(email);
	$('#agentb2cnumber').val(phone);
	$('#companyId').val(id);
	$('#country').val(country);
	$('#agentb2caddress').val(address);
	if(opsPerson!=''){
	$('#ownerName').val(opsPerson);
	$('#assignTo').val(opsPersonId);
	}else {
	$('#ownerName').val('');
	$('#assignTo').val('');
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
			function openselectCompanypop(url,poupwidth){
			var clientType1 = $('#clientType').val(); 	 
	
				$("#addAgentfromquery").show();
				$(".loadaddagentfile").load('addagentfromQuery.php?'+url+'&clientType='+clientType1);
				$('.loadaddagentfile').css('width', poupwidth);
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
	<div class="gridlable"><c id="agentTypeDiv">Agent / B2C</c><span class="redmind"></span></div>
	<div id="getcompanyName" style="display:none;position: absolute; background-color: #f5f5f5; border: 1px solid #ccc; z-index: 99; top: 57px; left: 0px; width: 100%; overflow: auto; max-height: 240px; box-shadow: 2px 2px 7px #0000003d;"></div>
	<input name="companyName" type="text" class="gridfield validate" id="companyName" value="<?php echo $clientnem; ?>" displayname="Company" autocomplete="off" onkeydown="searchcompanynamefuncCompany();" onkeyup="searchcompanynamefuncCompany();" />
	<input name="companyId" type="hidden" id="companyId" value="<?php echo encode($editcompanyId); ?>" />
	</label>
	</div>
	</div>
	<div style="display: grid;grid-template-columns: 1fr 1fr;grid-gap: 10px;">
	<div class="griddiv"><label>
	<div class="gridlable">Contact&nbsp;Person&nbsp;Name<span class="redmind"></span></div>
	<input name="agentb2cname" type="text" class="gridfield validate" id="agentb2cname" value="<?php echo $agentcontactPerson; ?>"  displayname="Contact Person Name" />
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable"> Email&nbsp;Address <span class="redmind"></span></div>
	<input name="agentb2cmail" type="text" class="gridfield validate" id="agentb2cmail" value="<?php echo $agentemail; ?>"  displayname="Address" maxlength="200" />
	</label>
	</div>	
	</div>

	<div style="display: grid;grid-template-columns: 1fr 1fr;grid-gap: 10px;">
	<div class="griddiv"><label>
	<div class="gridlable">Country <span class="redmind"></span></div>
	<select id="country" name="country" class="gridfield validate" displayname="Country" autocomplete="off"   > 
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

<option value="<?php echo $rest['id']; ?>" <?php if($editresult['country']==$rest['id']){ ?>selected="selected"<?php } ?>><?php echo $rest['name']; ?></option> 

<?php } ?>

</select>

	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable"> Destination <span class="redmind"></span></div>
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
		</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">
<div class="griddiv" style="border-bottom: none;">
<label>
	<div>&nbsp;</div>
	<input name="test" type="text" class="gridfield" style="border:none" disabled="disabled" />
	</label>
	</div>
		<div class="griddiv"><img src="images/userrole.png" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;" onclick="alertspopupopen('action=selectParent&userType=1','600px','auto');" />
	<label>
	<div class="gridlable">Sales Person<span class="redmind"></span></div>
	<div id="selectOpsPerson"><input name="ownerName" type="text" class="gridfield validate" id="ownerName" value="<?php echo getUserName($editassignTo); ?>" readonly="true" displayname="Assign To" autocomplete="off" onclick="alertspopupopen('action=selectParent&userType=2','600px','auto');" />
	<input name="assignTo" type="hidden" id="assignTo" value="<?php echo encode($editassignTo); ?>" /></div>
	</label>
	</div>	
	<div style="display: grid;grid-template-columns: 1fr 1fr;grid-gap: 10px;">
	<div class="griddiv"><label>
	<div class="gridlable">Mobile Number<span class="redmind"></span></div>
	<input name="agentb2cnumber" type="text" class="gridfield validate" id="agentb2cnumber" value="<?php echo $agentphone; ?>"  displayname="Mobile Number" maxlength="13" />
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable"> Contact Number</div>
	<input name="contactnumber" type="text" class="gridfield" id="contactnumber" value="<?php ?>"  displayname="Contact Number" maxlength="13" />
	</label>
	</div>	
	</div>
	 
	 </td>
  </tr>
  <tr>
   
    </tr>
</table>
<br><br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Task&nbsp;Information</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
<div style="display:grid;grid-template-columns: 1fr 1fr 1fr 1fr;grid-gap: 10px;">
	<div class="griddiv">
	<label>
	<div class="gridlable">Start&nbsp;Date<span class="redmind"></span></div>
	<input name="fromDate" type="text" id="fromDate"   class="gridfield calfieldicon validate"  displayname="Start Date"   autocomplete="off" value="<?php echo $fromDate; ?>" />
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
	<div class="gridlable">Task&nbsp;Duration</div>
	<select id="timeDuration" name="duration" class="gridfield validate" displayname="Task Duration" autocomplete="off" onchange="setendtime(this.value);" > 
<option value="">Select</option>
<?php

    for ($i=5;$i<=300;$i = $i + 5) { ?>

   <option value="<?php echo $i; ?>" <?php if($i == $editresult['duration']){ echo 'selected';  } ?>><?php echo $i." minutes"; ?></option>;

    <?php  }  ?>

</select>

 </label>
	</div>
	<div class="griddiv">
	<label>	
	<div class="gridlable">End&nbsp;Time</div>
<input name="endtime" type="text" class="gridfield validate" id="endtime" value="<?php echo $editendtime; ?>" />
</label>
	</div>	
</div>

<script>
	function setendtime(id){
		var starttime = $("#starttime").val();
			var timeSplit = starttime.split(':');
			var hours = timeSplit['0'];
			var minutesPrem = timeSplit['1'];

			var splitMin = minutesPrem.split(' ');
			minutes = splitMin['0'];
			var meditr = splitMin['1'];

		var timeDuration = $("#timeDuration").val();
			var totalMinutes = Number(timeDuration)+Number(minutes);
		var remainderM = totalMinutes%60;	
		var remainderH = Math.trunc(totalMinutes/60);
		// 
		var totalHours = Number(remainderH)+Number(hours);
		var endminutes = Number(remainderM);
		if(endminutes=='' || endminutes==0){
			endminutes=0;
		}else{
			endminutes=endminutes;
		}

		if(meditr=="AM"){
			if(totalHours<12 && (endminutes<=59 || endminutes==0)){
				var Meditr = 'AM';
				var endHours = totalHours;
		}else if(totalHours>=12 && endminutes>=0){
			var Meditr = 'PM';
			var endHours = totalHours % 12;
			console.log(endHours);
			if(endHours==0){
				endHours =12;
			}else{
				endHours=endHours;
			}
		}
	}

		if(meditr=="PM"){
			if(totalHours<12 && (endminutes<=59 || endminutes==0)){
				var Meditr = 'PM';
				var endHours = totalHours;
		}else if(totalHours>=12 && endminutes>=0){
			var Meditr = 'AM';
			var endHours = totalHours % 12;
		
			if(endHours==0){
				endHours = 12;
			}else{
				endHours=endHours;
			}
		}

		}
		if(endminutes==0){
			endminutes = '00'
		}else{
			endminutes = endminutes;
		}

		var endTime = endHours+':'+endminutes+' '+Meditr;
		$('#endtime').val(endTime);
		// console.log(endTime);
		
		
	}
	
</script>



<div style="display:grid;grid-template-columns: 1fr 1fr 1fr;grid-gap: 10px;">
	<div class="griddiv">
	<label>
	<div class="gridlable">Next&nbsp;Follow&nbsp;Up&nbsp;Date<span class="redmind"></span></div>
	<input name="followupdate" type="text" id="followupdate"   class="gridfield calfieldicon validate"  displayname="Next Follow Up Date"   autocomplete="off" value="<?php if($followupdate!=''){ echo date('d-m-Y',strtotime($followupdate)); }else{ echo date('d-m-Y'); } ?>" />
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
	<div style="display: grid;grid-template-columns: 1fr 1fr;grid-gap: 10px;">
	<div class="griddiv">
	<label>
	<div class="gridlable">Status</div>
	 

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
	
	
	<div class="griddiv">
	<label>
	<div class="gridlable">Priority</div>
	<select id="directiontype" name="directiontype" class="gridfield" displayname="Priority" autocomplete="off"  >
	 <option value="">Select</option> 

<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='id!="" order by id'; 
$rs=GetPageRecord($select,_TASKS_OUTCOME_,$where); 
while($rest=mysqli_fetch_array($rs)){ 

?>

<option value="<?php echo $rest['id']; ?>" <?php if($directiontype==$rest['id']){ ?>selected="selected"<?php } ?>><?php echo $rest['name']; ?></option> 

<?php } ?>
</select>
</label>
	</div>	
	</div>
	

	
	<div class="griddiv"><label>
	<div class="gridlable">Task&nbsp;Subject<span class="redmind"></span></div>
	<input name="subject" type="text" class="gridfield validate" id="subject" value="<?php echo $editsubject; ?>"  displayname="Subject" maxlength="200" />
	</label>
	</div>	
		</td>
    <td width="48%" align="left" valign="top" style="padding-left:10px;">
<div class="griddiv"><label>
	<div class="gridlable">Description</div>
	<textarea name="description" rows="9" class="gridfield" id="description"><?php echo $editdescription; ?></textarea>
	</label>
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
</style>
