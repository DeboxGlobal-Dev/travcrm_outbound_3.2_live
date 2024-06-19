<?php  
error_reporting(0);
include "inc.php"; 

if($_REQUEST['type']!=''){ 
$select=''; 
$where=''; 
$rs='';  
$select='*'; 
$where='id="'.$_SESSION['userid'].'" and email="'.$_SESSION['username'].'"'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$LoginUserDetails=mysqli_fetch_array($rs); 

$fullloginusername=$LoginUserDetails['firstName'].' '.$LoginUserDetails['lastName'];

$select1='*';  
$where1='id='.$_REQUEST['type'].' '; 
$rs1=GetPageRecord($select1,_ACTIVITY_TYPE_MASTER_,$where1); 
$resultlists=mysqli_fetch_array($rs1);
?>
<div style="border: 1px solid #e5e5e5; border-radius: 4px; overflow:hidden; margin-bottom:10px; background-color:#f7f7f7;"> 
<style>
.textfieldinnermain{padding:10px; border:1px #cbcccd solid; margin-bottom:10px; width:100%; box-sizing:border-box;border-radius: 3px;}
.textfieldinnermain:focus{border:1px #58abff solid; outline:0px;}
</style>

<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditquery" target="actoinfrm" id="addeditquery">
<?php if($_REQUEST['type']==4){ ?>
<div style="padding:15px; overflow:hidden;">
<input name="subject" type="text" id="subject" class="textfieldinnermain" placeholder="Mail Subject" />
  

<textarea name="description" rows="3" class="textfieldinnermain" id="description" placeholder="Notes" style="height:161px;"></textarea>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:11px; text-transform:uppercase; margin-bottom:10px;">
  <tr>
    <td width="49%" align="left" valign="top"><div style="margin-bottom:2px;">Sales Person</div>
       
	 	<select id="clientType" name="clientType" class="textfieldinnermain validate" displayname="Client Type" autocomplete="off" onchange="selectclienttypename();"    > 
	<option value="1" <?php if(1==$clientType){ ?>selected="selected"<?php } ?>>Agent</option> 
	<option value="2" <?php if(2==$clientType){ ?>selected="selected"<?php } ?>>B2C</option> 
	</select> 
	   
	<input name="assignTo" type="hidden" id="assignTo" value="<?php echo encode($_SESSION['userid']); ?>" />
	  </td>
     <td width="50%" align="left" valign="top" style="padding-left:10px;"><div style="margin-bottom:2px;">Client</div>
      <input name="companyName" type="text" class="textfieldinnermain validate" id="companyName" value="<?php echo $clientnem; ?>" readonly="true" displayname="Company" autocomplete="off" onclick="openselectCompanypop();" /><input name="companyId" type="hidden" id="companyId" value="" /><input name="agentb2cmail" type="hidden" class="gridfield" id="agentb2cmail"  displayname="" readonly=""   value="" /></td>
  </tr>
</table>

<div style="overflow:hidden;"><table border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2"><input type="button" name="Submit22" value="Cancel" class="whitembutton"  style="margin-right:0px;" onclick="addactivityview();$('.listtabsec a').removeClass('active');"></td>
    <td ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="   Send   " style="float:right; margin-top:0px;" onclick="formValidation('addeditquery','submitbtn','0');"></td>
  </tr>
  
</table><input name="activitytype" id="activitytype" type="hidden" value="<?php echo $_REQUEST['type']; ?>" />
<input name="action" id="action" type="hidden" value="addactivity" /><input name="leadId" id="leadId" type="hidden" value="<?php echo $_REQUEST['leadId']; ?>" />
</div>
</div>
<?php } else { ?>
<div style="padding:15px; overflow:hidden;">
<input name="subject" type="text" id="subject" class="textfieldinnermain" placeholder="<?php echo $resultlists['name']; ?> Subject" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:11px; text-transform:uppercase; margin-bottom:10px;">
  <tr>
    <td width="32%" align="left" valign="top"><div style="margin-bottom:2px;">Date</div><input name="fromDate" type="text" id="fromDate" class="textfieldinnermain"  value="<?php echo date('d-m-Y'); ?>" />
	
	
	<script>
 $(document).ready(function() { 
 $('#fromDate').Zebra_DatePicker({ 
  format: 'd-m-Y',  
});  }); 
	</script></td>
    <td width="34%" align="left" valign="top" style="padding:0px 10px;"><div style="margin-bottom:2px;">From Time</div>
      <select name="fromTime" class="textfieldinnermain" id="fromTime">
     <?php 
$start=strtotime('00:00'); 
   $end=strtotime('23:30'); 
    for ($i=$start;$i<=$end;$i = $i + 15*60) 
    { ?> 
   <option value="<?php echo date('g:i A',$i); ?>" <?php if('10:00 AM'==date('g:i A',$i) && $_REQUEST['id']==''){ ?> selected="selected"<?php } ?> <?php if($editstarttime==date('g:i A',$i)){ ?> selected="selected"<?php } ?>><?php echo date('g:i A',$i); ?></option>; 
    <?php  }  ?> 
      </select> </td>
    <?php if($_REQUEST['type']!=3){ ?>
    <td width="32%" align="left" valign="top"><div style="margin-bottom:2px;">To Time</div><select name="toTime" class="textfieldinnermain" id="toTime">
     <?php 
$start=strtotime('00:00'); 
   $end=strtotime('23:30'); 
    for ($i=$start;$i<=$end;$i = $i + 15*60) 
    { ?> 
   <option value="<?php echo date('g:i A',$i); ?>" <?php if('10:00 AM'==date('g:i A',$i) && $_REQUEST['id']==''){ ?> selected="selected"<?php } ?> <?php if($editstarttime==date('g:i A',$i)){ ?> selected="selected"<?php } ?>><?php echo date('g:i A',$i); ?></option>; 
    <?php  }  ?> 
      </select></td>
    <?php } ?>
  </tr>
</table> 

<textarea name="description" rows="3" class="textfieldinnermain" id="description" placeholder="Notes" style="height:88px;"></textarea>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:11px; text-transform:uppercase; margin-bottom:10px;">
  <tr>
    <td width="49%" align="left" valign="top"><div style="margin-bottom:2px;">Sales Person</div>
       
	  
	  <input name="ownerName" type="text" class="textfieldinnermain validate" id="ownerName" value="<?php echo $fullloginusername; ?>" readonly="true" displayname="Assign To" autocomplete="off" onclick="alertspopupopen('action=selectParent&userType=2','600px','auto');" />
	<input name="assignTo" type="hidden" id="assignTo" value="<?php echo encode($_SESSION['userid']); ?>" />
	  </td>
     <td width="50%" align="left" valign="top" style="padding-left:10px;"><div style="margin-bottom:2px;">REMINDER</div>
      <select name="reminderTime" class="textfieldinnermain" id="reminderTime">
   <option value="0" >No Reminder</option>  
   <option value="15" >Before 15 Min.</option>  
   <option value="30" >Before 30 Min.</option>  
   <option value="45" >Before 45 Min.</option>  
   <option value="60" >Before 1 Hour</option>  
   <option value="120" >Before 2 Hour</option>   
      </select></td>
  </tr>
</table>

<div style="overflow:hidden;"><table border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2"><input type="button" name="Submit22" value="Cancel" class="whitembutton"  style="margin-right:0px;" onclick="addactivityview();$('.listtabsec a').removeClass('active');"></td>
    <td ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="   Save   " style="float:right; margin-top:0px;" onclick="formValidation('addeditquery','submitbtn','0');"></td>
  </tr>
  
</table><input name="activitytype" id="activitytype" type="hidden" value="<?php echo $_REQUEST['type']; ?>" />
<input name="action" id="action" type="hidden" value="addactivity" /><input name="leadId" id="leadId" type="hidden" value="<?php echo $_REQUEST['leadId']; ?>" />
</div>
</div>
<?php } ?>
</form>

<style>
.Zebra_DatePicker_Icon_Wrapper{width:100% !important;}
</style>
</div>
<?php } else { ?>
<div>&nbsp;&nbsp;&nbsp;</div>
 <?php
$select='';
$where='';
$rs=''; 
$select='*';  
$where='id='.$_REQUEST['leadId'].'';
$rs=GetPageRecord($select,'leadManageMaster',$where);
$activitymasterdata=mysqli_fetch_array($rs);
?>
 <div class="listingacmain">
 <div class="iconsactivity"><i class="fa fa-user"></i></div>
 <div class="listingactivity">
 <div style="font-size:17px; margin-bottom:5px; font-weight:400;"><?php echo stripslashes($activitymasterdata['subject']); ?></div>
 <?php if($activitymasterdata['description']!=''){ ?><div style="margin-bottom:10px; font-size:14px; color:#666666;"><?php echo nl2br(stripslashes($activitymasterdata['description'])); ?></div><?php } ?>
 

 <div style="font-size:12px; color:#666666; <?php if($activitymasterdata['followupdate'] < date('Y-m-d H:i:s')){ ?>color:#CC3300;<?php } ?>"><span><?php echo date('j F Y  -  h:i a',strtotime($activitymasterdata['followupdate'])); ?></span>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo getUserName($activitymasterdata['assignTo']); ?></div>
 </div>
 </div>
 <?php
   $n=2;
$select='';
$where='';
$rs=''; 
$select='*';  
$where='leadId='.$_REQUEST['leadId'].' order by followupdate desc';
$rs=GetPageRecord($select,_ACTIVITY_MASTER_,$where);
while($activitymasterdata=mysqli_fetch_array($rs)){ 

$select1='*';  
$where1='id='.$activitymasterdata['activityType'].' '; 
$rs1=GetPageRecord($select1,_ACTIVITY_TYPE_MASTER_,$where1); 
$resultlists=mysqli_fetch_array($rs1);
?>
 <div class="listingacmain">
 <div class="iconsactivity"><i class="fa fa-<?php echo $resultlists['nameIcon']; ?>"></i></div>
 <div class="listingactivity">
 <div style="font-size:17px; margin-bottom:5px; font-weight:400;"><?php echo stripslashes($activitymasterdata['subject']); ?></div>
 <?php if($activitymasterdata['description']!=''){ ?><div style="margin-bottom:10px; font-size:14px; color:#666666;"><?php echo nl2br(stripslashes($activitymasterdata['description'])); ?></div><?php } ?>
 
 <div style="font-size:12px; color:#666666; <?php if($activitymasterdata['followupdate'] < date('Y-m-d H:i:s')){ ?>color:#CC3300;<?php } ?>"><span><?php echo date('j F Y  -  h:i a',strtotime($activitymasterdata['followupdate'])); ?></span>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo getUserName($activitymasterdata['assignTo']);  ?></div>
 </div>
 </div>
<?php $n++; } ?>

<?php if($n<2){ ?>
<div style="padding:30px; text-align:center; color:#999999;">No Activity</div>
<?php } ?>
<?php } ?>

<style>
.iconsactivity {
    position: absolute;
    width: 40px;
    height: 40px;
    border: 1px #b9babb7a solid;
    background-color: #FFF;
    left: -22px;
    top:0px;
    color: #b9babb7a;
    font-size: 20px;
    padding: 0px;
    border-radius: 40px;
}

.iconsactivity .fa {
        font-size: 25px;
    padding-left: 10px;
    padding-top: 8px;
}

.listingactivity {
    padding: 15px;
    background-color: #f7f7f769;
    border-radius: 4px;
    overflow: hidden;
    border: 1px solid #e5e5e5;
}
.listingacmain{    margin-left: 30px;
    padding-left: 40px;
    position: relative;
    border-left: dashed #b9babb7a 2px;
    padding-top: 0px;
    padding-bottom: 20px;
	}

</style>


<script>
	function openselectCompanypop(){
	var clientType1 = $('#clientType').val(); 	
	var incoming_query_email = '<?php echo $query_email; ?>';
	var incoming_query_mobile = '<?php echo $query_mobile; ?>'; 
	alertspopupopen('action=selectCorporate&clientType='+clientType1+'&incoming_query_email='+incoming_query_email+'&incoming_query_mobile='+incoming_query_mobile+'','600px','auto');
	}
	
	
	function selectclienttypename(){
	$('#companyName').val('');
	$('#companyId').val('');
	$('#agentb2cmail').val('');
	$('#agentb2cnumber').val('');
	var clientType = $('#clientType').val();
	if(clientType>0){
	$('#selectclientbox').show();
	$('#banumber').show();
	$('#baemail').show();
	if(clientType==1){
	$('#agentTypeDiv').text('Agent');
	$('#agentTypeemail').text('Agent Email');
	$('#agentTypemobile').text('Agent Mobile No');
	}
	if(clientType==2){
	$('#agentTypeDiv').text('B2C');
	$('#agentTypeemail').text('B2C Email');
	$('#agentTypemobile').text('B2C Mobile No');
	}
	
	} else { 
	$('#selectclientbox').hide();
	$('#banumber').hide();
	$('#baemail').hide();
	}
	
	}
	</script>