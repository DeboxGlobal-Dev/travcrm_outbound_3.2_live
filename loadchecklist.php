<?php
include "inc.php"; 
include "config/logincheck.php"; 

if($_GET['dltid']!='' && $_GET['id']!=''){ 

$select='*'; 
$where5='id='.$_GET['dltid'].''; 
$rs=GetPageRecord($select,_CHECK_LIST_MASTER_,$where5); 
$exe=mysqli_fetch_array($rs); 
$queryid = $exe['queryId'];
$times = $exe['follow_upTime']; 
$dates = $exe['follow_upDate']; 

$where1='serviceId='.$queryid.' and serviceType="Check-List" and toDoDate="'.$dates.'" and toDotime="'.$times.'"  ';
deleteRecord(_TO_DO_TIMELINE_,$where1); 
$where=' id='.$_GET['dltid'].' '; 
deleteRecord(_CHECK_LIST_MASTER_,$where);
}

if($_GET['editidstaus']!='' && $_GET['id']!='' && $_GET['status']!=''){ 
$namevalue ='statusId="'.$_GET['status'].'"';  

$where='id="'.$_GET['editidstaus'].'" and queryId="'.$_GET['id'].'"';  
$update = updatelisting(_CHECK_LIST_MASTER_,$namevalue,$where); 
}









$id=$_GET['id'];
  
$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=$id; 
$where='queryId='.$id.''; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$queryId=mysqli_fetch_array($rs);  
?>
 
<link href="css/main.css" rel="stylesheet" type="text/css" />
 

 <script>
 $(document).ready(function() {  

 $('#fromDate').Zebra_DatePicker({ 
  format: 'd-m-Y',  
});   
  });
  
</script>
<div style="padding:15px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" id="listmainlist">

   <thead>

   <tr>
      <th align="left" class="header">Services</th>
      <th align="left" class="header">Supplier Name </th>
      <th align="left" class="header">Contact Person</th>
      <th align="left" class="header">Email </th>
      <th align="left" class="header">Contact No.</th>
      <th align="left" class="header">Followup Date </th>
      <th align="left" class="header">Remarks</th>
      <th align="center" class="header">Attachment</th>
      <th align="center" class="header">Status</th>
      
  
	  <th align="center" class="header">&nbsp;</th>
   </tr>
   </thead>

 


 

  <tbody>
<?php
$s=1;
$select1=''; 
$wher1=''; 
$rs1='';  
$select1='*';    
$where1='  queryId="'.$id.'"  order by followupDateTime asc';  
$rs1=GetPageRecord($select1,_CHECK_LIST_MASTER_,$where1); 
while($dmcroommastermain=mysqli_fetch_array($rs1)){   
?>
  <tr>
    <td align="left" style="border-left:5px solid #<?php if($dmcroommastermain['statusId']==1){ echo 'CC3300'; } if($dmcroommastermain['statusId']==2){ echo 'FF6600'; }if($dmcroommastermain['statusId']==3){ echo '82b767'; }  ?>;"><?php 
 
$select='*';    
$where=' id='.$dmcroommastermain['serviceType'].'';  
$rs=GetPageRecord($select,_TOUR_TYPE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

echo  $resListing['name'];

 } ?></td>
    <td align="left"><?php echo strip($dmcroommastermain['supplierName']); ?></td>
    <td align="left"><?php echo strip($dmcroommastermain['contactPerson']); ?></td>
    <td align="left"><?php echo strip($dmcroommastermain['email']); ?></td>
    <td align="left"><?php echo strip($dmcroommastermain['mobile']); ?></td>
    <td align="left"><?php echo date('d-m-Y, h:i a',strtotime($dmcroommastermain['followupDateTime']));?></td>
    <td align="left"><?php echo strip($dmcroommastermain['remark']); ?></td>
    <td align="center"><?php if($dmcroommastermain['attachment']!=''){ ?><a href="dirfiles/<?php echo $dmcroommastermain['attachment']; ?>" target="_blank"><strong>View</strong></a><?php }  ?></td>
    <td align="center" style="cursor:pointer;" onclick="alertspopupopen('action=changecheckliststatus&queryId=<?php echo $_GET['id']; ?>&editstatusid=<?php echo $dmcroommastermain['id']; ?>','450px','auto');">
	<?php if($dmcroommastermain['statusId']==2){ echo '<div class="revertquery">In Process</div>'; }  ?>
	<?php if($dmcroommastermain['statusId']==1){ echo '<div class="wonquery" style="background-color:#CC3300;">Pending</div>'; }  ?>
	<?php if($dmcroommastermain['statusId']==3){ echo '<div class="wonquery">Done</div>'; }  ?></td>
     
 
    <td align="center"><a onclick="editloadchecklistfun('<?php echo $dmcroommastermain['id']; ?>');">Edit</a><br />
<a style="color:#FF0000 !important;  font-size:12px;" onclick="if(confirm('Are you sure you want delete this entry?')) deltloadchecklistfun('<?php echo $dmcroommastermain['id']; ?>');" >Delete</a></td>
  </tr>	<?php  $s++; } ?>
</tbody></table>
 
<style>
.gridlable{width:100% !important;}
</style>
<div style="margin-top:40px; padding:0px !important; <?php if($_REQUEST['editid']!=''){ ?>padding:5px; border-bottom:2px #FF9900 solid;<?php } ?>">
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addflight2222" target="actoinfrm"  id="addflight2222"> <table border="0" cellpadding="2" cellspacing="0" class="addeditpagebox" style="padding:0px !important;">
  <tr>
    <td><div class="griddiv" style="border-bottom:0px;"> 
  
	<div class="gridlable" style="width:100%;">Service <span class="redmind"></span></div>
	<select id="tourType2" name="tourType2" class="gridfield validate" displayname="Tour Type" autocomplete="off" style="    height: 37px; width:112px;"  >
	 <option value="">Select</option>
 <?php 

if($_REQUEST['editid']!=''){
$fromDate='';
$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=$id; 
$where='id='.$_REQUEST['editid'].''; 
$rs=GetPageRecord($select,_CHECK_LIST_MASTER_,$where); 
$editchecklist=mysqli_fetch_array($rs); 

$edittourType=strip($editchecklist['serviceType']);
$supplierName=strip($editchecklist['supplierName']);
$contactPerson=strip($editchecklist['contactPerson']);
$email=strip($editchecklist['email']);
$mobile=$editchecklist['mobile'];
$fromDate=date('d-m-Y',strtotime($editchecklist['followupDateTime']));
$selectime=date('g:i a',strtotime($editchecklist['followupDateTime']));
$remark=strip($editchecklist['remark']);
$attachment=strip($editchecklist['attachment']);
$statusId=strip($editchecklist['statusId']);

}

 
 
 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_TOUR_TYPE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$edittourType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select>
	<style>
	.Zebra_DatePicker_Icon_Wrapper{width:100% !important;}
	</style>
	 
	 
 </div></td>
    <td><div class="griddiv"> 
  
	<div class="gridlable">Supplier Name<span class="redmind"></span></div>
	<input name="supplierName" type="text" class="gridfield validate" id="supplierName"   value="<?php echo $supplierName; ?>" maxlength="100"    autocomplete="off"   displayname="Supplier Name"  />
 
	 
 </div></td>
    <td><div class="griddiv"> 
  
	<div class="gridlable">Contact Person </div>
	<input name="contactPerson" type="text" class="gridfield" id="contactPerson"   value="<?php echo $contactPerson; ?>" maxlength="100" displayname="Description"  autocomplete="off"   />
 
	 
 </div></td>
    <td><div class="griddiv"> 
  
	<div class="gridlable">Email </div>
	<input name="email" type="text" class="gridfield" id="email"   value="<?php echo $email; ?>" maxlength="100" displayname="Description"  autocomplete="off"  style="min-width:100px;" />
 
	 
 </div></td>
    <td><div class="griddiv"> 
  
	<div class="gridlable">Contact No. </div>
	<input name="mobile" type="text" class="gridfield" id="mobile"   value="<?php echo $mobile; ?>" maxlength="15" displayname="Contact No."  autocomplete="off"   />
 
	 
 </div></td>
    <td><div class="griddiv"> 
  
	<div class="gridlable">Followup Date<span class="redmind"></span> </div>
	<input name="fromDate" type="text" class="gridfield calfieldicon validate" id="fromDate"   value="<?php echo $fromDate; ?>" maxlength="200"   displayname="Followup Date" autocomplete="off"  style="min-width:100px;"/>
 
	 
 </div></td>
    <td><div class="griddiv"> 
  
	<div class="gridlable"> Time <span class="redmind"></span></div>
	 
 <select id="checkInTime" name="checkInTime" class="gridfield validate"  autocomplete="off"  displayname="Followup Time" style="width: 95px; height: 37px; "  >
<option value="">Select</option>
<?php 
$start = "00:00";
$end = "23:45";

$tStart = strtotime($start);
$tEnd = strtotime($end);
$tNow = $tStart;

while($tNow <= $tEnd){

?>
<option value="<?php echo date("g:i a",$tNow); ?>" <?php if($selectime==date("g:i a",$tNow)){ ?>selected="selected"<?php } ?>><?php echo date("g:i a",$tNow); ?></option>
<?php  $tNow = strtotime('+15 minutes',$tNow);} ?>
</select>
	 
 </div></td>
    <td><div class="griddiv"> 
  
	<div class="gridlable">Remark</div>
	<input name="remark" type="text" class="gridfield" id="remark"   value="<?php echo $remark; ?>" maxlength="200" displayname="Description"  autocomplete="off"  style="width:100px;" />
 
	 
 </div></td>
    <td><div class="griddiv"> 
  
	<div class="gridlable">Attachment </div>
	<div style="background-color:#FFFFFF; padding:7px;border: 1px #e0e0e0 solid; margin-top: 5px; position:relative;"> <input name="attachment" type="file" id="attachment" style="width:84px;" /></div>
 
	 
 </div></td>
    <td><div class="griddiv"> 
  
	<div class="gridlable">Status </div>
	<select id="statusId" name="statusId" class="gridfield validate" displayname="Tour Type" autocomplete="off" style="    height: 37px;width:100px;"   >
 
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' 1 order by id asc';  
$rs=GetPageRecord($select,_CHECK_LIST_STATUS_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$statusId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select>
 
	 
 </div></td>
    <td>  <input name="action" id="action" type="hidden" value="addcheckin" />
    <input name="queryId" id="queryId" type="hidden" value="<?php echo $_GET['id']; ?>" />
	<input name="editid" id="editid" type="hidden" value="<?php echo $_REQUEST['editid']; ?>" />
	<input name="attachment2" id="attachment2" type="hidden" value="<?php echo $attachment; ?>" />
	<input name="addnewuserbtn2" type="button" class="greenbuttonx2" id="addnewuserbtn2" value="<?php if($_REQUEST['editid']!=''){ echo 'Update'; } else { echo 'Add'; } ?>" style="margin-right:10px;" onclick="formValidation('addflight2222','submitbtn','0');"></td>
  </tr>
</table>
</form>

</div>


 

</div>
<script>
<?php if($_REQUEST['editid']!=''){ ?>
$('#supplierName').focus(); 
<?php } ?>
</script>
<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper{width:100% !IMPORTANT;}
</style>
 

 