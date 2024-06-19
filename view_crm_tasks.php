<?php
if($viewpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}



if($_GET['id']!=''){
$id=clean(decode($_GET['id']));

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_TASKS_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
 
}


  
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:20px;"><table border="0" cellpadding="0" cellspacing="0">
  <tr>
<td width="20%" align="left"> <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module'];?>" /><input type="button" name="Submit22" value="Back" class="whitembutton" ></a> </td>
    <td>&nbsp;</td>    <td><?php echo strip($editresult['subject']); ?></td>
  </tr>
  
</table>
</div></td>
    <td align="right"><?php if($editpermission==1){ ?><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Edit" class="whitembutton" onclick="edit('<?php echo $_GET['id']; ?>');" /></td>
      </tr>
      
    </table><?php } ?></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:0px;">

 <div class="addeditpagebox vieweditpagebox">
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Task Information</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	
	<?php if($editresult['clientType']!=10){ ?>
	<div class="griddiv">
	  <div class="gridlable">Client Type</div> 
	  <div class="gridtext"><?php if(1==$editresult['clientType']){ ?>Agent<?php } ?><?php if(2==$editresult['clientType']){ ?>B2C<?php } ?></div>
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Client</div>
	<div class="gridtext"><?php echo showClientTypeUserNameWithLink($editresult['clientType'],$editresult['companyId']); ?></div>
	 
	</label>
	</div>
	<?php } ?>
	 
	
 
	 <div class="griddiv"><label><div class="gridlable">Priority</div>
	<div class="gridtext" style="text-transform:uppercase;"><?php
if($editresult['directiontype']!=''){
$select12='*';  
$where12='id='.$editresult['directiontype'].''; 
$rs12=GetPageRecord($select12,_TASKS_OUTCOME_,$where12); 
$calltype=mysqli_fetch_array($rs12); 
echo $calltype['name'];
}
?></div>
	 
	</label>
	</div>
	  
	 
	 
	  
	
	
	<div class="griddiv"><div class="gridlable">Sales Person </div><div class="gridtext"> 
	
<?php echo getUserName($editresult['assignTo']); $reminderTime=$editresult['reminderTime']; ?></div>
	 </label>
	</div>
	
	
	 
	 	<div class="griddiv"><label>
	<div class="gridlable">Created By </div>
		<div class="gridtext"><?php echo getUserName($editresult['addedBy']); ?><div style="font-size:12px; margin-top:2px; color:#999999;"><?php echo showdatetime($editresult['dateAdded'],$loginusertimeFormat);?></div>
</div>
	</label>
	</div>
	
	 	
	<?php if($editresult['modifyDate']!='0'){ ?>
	<div class="griddiv"><label>
	<div class="gridlable">Modified By </div>
		<div class="gridtext"><?php echo getUserName($editresult['modifyBy']); ?> 
<div style="font-size:12px; margin-top:2px; color:#999999;"><?php if($modifyDate!='0'){ echo showdatetime($editresult['modifyDate'],$loginusertimeFormat); } ?></div>
</div>
	</label>
	</div>
	<?php } ?>	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;"> 
 
	 
	
	 <div class="griddiv"><div class="gridlable">Status </div><div class="gridtext salestimeline_sectionbox"> 
	
<div class="tag <?php if($editresult['status']==1){ echo 'shedule'; } if($editresult['status']==2){ echo 'confirm'; } if($editresult['status']==3){ echo 'canceled'; }?>"><?php if($editresult['status']==1){ echo 'Scheduled'; } if($editresult['status']==2){ echo 'Held'; } if($editresult['status']==3){ echo 'Canceled'; }?></div></div>
	 </label>
	</div>	 	
	<div class="griddiv"><label>
	<div class="gridlable">Start Date </div>
	<div class="gridtext"><?php echo showdate($editresult['fromDate']); ?>, &nbsp;<?php echo  ($editresult['starttime']); ?> &nbsp;-&nbsp;<?php echo  ($editresult['endtime']); ?></div>
	 
	</label>
	</div>

	 
	    
	<div class="griddiv"><label>
	<div class="gridlable">Lead Source</div>
	<div class="gridtext"><?php
if($editresult['leadsource']!=''){
$select12='*';  
$where12='id='.$editresult['leadsource'].''; 
$rs12=GetPageRecord($select12,'leadssourceMaster',$where12); 
$calltype=mysqli_fetch_array($rs12); 
echo $calltype['name'];
}
?></div>
	 
	</label>
	</div>
	
	 <div class="griddiv"><label>
	<div class="gridlable" style=" width:100%;">Description</div>
	<div class="gridtext"  style=" width:100%;"><?php echo strip($editresult['description']); ?></div>
	 
	</label>
	</div>
	     	    </td>
  </tr>
  <tr>
    <td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
    <td align="left" valign="top" style="padding-left:20px;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"  > </td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;"></td>
    </tr>
  <?php if($editresult['queryId']!=0 && $editresult['queryId']!=''){ ?><tr>
    <td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
    <td align="left" valign="top" style="padding-left:20px;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"  > </td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;"></td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;" ><div class="innerbox" >
      <h2 style="    margin-bottom: 20px;">Query Information</h2>
    </div><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
     <th align="left" class="header" >Query&nbsp;ID </th>
     <th align="left" class="header">Subject</th>
     <th align="left" class="header">Type</th>
     <th align="left" class="header">Client </th>
     <th align="left" class="header">	Query Date </th>
     <th align="left" class="header" >Tour&nbsp;Date </th>
     <th align="left" class="header" >Destination</th>
     <th align="left" class="header" >Priority</th>
     <th align="center" class="header" style="width:50px;">Status</th>
     </tr>
   </thead>

 


 

  <tbody>
  <?php

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=clean($_GET['records']);

$searchField=clean(trim(ltrim($_GET['searchField'], '0')));

$mainwhere='';
if($searchField!=''){
$mainwhere=' and  id='.$searchField.'';
}

$assignto='';
if($_GET['assignto']!=''){
$assignto=' and	assignTo='.$_GET['assignto'].'';
}
 
 
$destination='';
if($_GET['destination']!=''){
$destination=' and	destinationId='.clean($_GET['destination']).'';
} 
 
$priority='';
if($_GET['priority']!=''){
$priority=' and	queryPriority='.clean($_GET['priority']).'';
} 

$querystatus='';
if($_GET['querystatus']!=''){
$querystatus=' and	queryStatus='.clean($_GET['querystatus']).'';
} 

  
 
$searchFieldcommonquery='';
if($searchFieldcommon!=''){
$searchFieldcommonquery=' and (subject like "%'.$searchFieldcommon.'%" or companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$searchFieldcommon.'%"))';
} 
 

  
$wheresearch=' ( addedBy = '.$_SESSION['userid'].'  or assignTo = '.$_SESSION['userid'].' or  assignTo in (select id from  '._USER_MASTER_.' where superParentId='.$_SESSION['userid'].') or companyId in (select id from  '._CORPORATE_MASTER_.' where assignTo='.$_SESSION['userid'].')  ) '.$searchFieldcommonquery.''; 
  
  
 if($loginuserprofileId==1){  
$wheresearch=' 1 '.$mainwhere.' '.$searchFieldcommonquery.''; 
} else {
$wheresearch=' ( addedBy = '.$_SESSION['userid'].'  or assignTo = '.$_SESSION['userid'].' or  assignTo in (select id from  '._USER_MASTER_.' where superParentId='.$_SESSION['userid'].') or companyId in (select id from  '._CORPORATE_MASTER_.' where assignTo='.$_SESSION['userid'].')  ) '.$searchFieldcommonquery.''; 
}
 
 
  
 
$where='where '.$wheresearch.'  '.$assignto.' '.$mainwhere.' '.$destination.' '.$priority.' '.$querystatus.' and id="'.$editresult['queryId'].'" and closerDate!="0000-00-00" and deletestatus=0 order by dateAdded desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=leads&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&'; 
$rs=GetRecordList($select,_QUERY_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
?>
  <tr <?php if($resultlists['queryStatus']==20){ ?>style="background-color: #fff2f2;"<?php } ?>>
    <td align="left"><div class="bluelink"><a href="showpage.crm?module=leads&view=yes&id=<?php echo encode($resultlists['id']); ?>"><?php echo makeQueryId($resultlists['id']); ?></a>
	 
	</div>   </td>
    <td align="left"><div style="max-width:200px;" class="bluelink"><a href="showpage.crm?module=leads&view=yes&id=<?php echo encode($resultlists['id']); ?>"><?php echo clean($resultlists['subject']); ?></a></div></td>
    <td align="left"><?php echo showClientType($resultlists['clientType']); ?></td>
    <td align="left"><?php echo showClientTypeUserName($resultlists['clientType'],$resultlists['companyId']); ?></td>
    <td align="left"><?php echo showdate($resultlists['queryDate']); ?></td>
    <td align="left" ><?php echo showdate($resultlists['fromDate']); ?></td>
    <td align="left" ><?php echo getDestination($resultlists['destinationId']); ?></td>
    <td align="left" ><?php if($resultlists['queryPriority']==1 || $resultlists['queryPriority']==0){ ?><div class="lowpire">Low</div><?php } ?><?php if($resultlists['queryPriority']==2){ ?><div class="mediampire">Medium</div><?php } ?><?php if($resultlists['queryPriority']==3){ ?><div class="highpire">High</div><?php } ?></td>
    <td align="center"style="width:50px;">
	<?php if($resultlists['queryStatus']==20){ ?>
	<div class="lossquery">Cancelled</div>
	<?php } else { ?>
	 <?php  
$result =mysqli_query ("select * from "._PAYMENT_REQUEST_MASTER_." where queryid='".$resultlists['id']."' and deletestatus!=1")  or die(mysqli_error()); 
$number =mysqli_num_rows($result);
$getpaymentid=mysqli_fetch_array($result);  
if($number>0) 
{ 
?>
		<div class="wonquery" <?php if($getpaymentid['status']==0){ ?>style="background-color:#CC3300;"<?php } ?>><?php if($getpaymentid['status']==0){ echo 'Unpaid'; } else { echo 'Paid'; } ?></div>
		
	<?php } else { ?>
	<?php 
 
	
	if($resultlists['queryStatus']==6){ echo '<div class="assignquery">Options&nbsp;Sent</div>'; }if($resultlists['queryStatus']==7){ echo '<div class="assignquery">Follow-up</div>'; }if($resultlists['queryStatus']==1){ echo '<div class="assignquery">Assigned</div>'; } if($resultlists['queryStatus']==2){ echo '<div class="revertquery">Reverted</div>'; } if($resultlists['queryStatus']==3){ echo '<div class="wonquery">Confirmed</div>'; } if($resultlists['queryStatus']==4){ echo '<div class="lossquery">Lost</div>'; } if($resultlists['queryStatus']==5){ echo '<div class="closequery">Deffered</div>'; }  if($resultlists['queryStatus']==0){ echo '<div class="assignquery">Assigned</div>'; }  ?>
	<?php } ?>	
	<?php } ?>	</td>
    </tr> 
	
	<?php $no++; } ?>
</tbody></table></td>
    </tr><?php } ?>
</table>
<script>

function deletebank(id){
	   $('#loadbankdetails').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>'); 
	  $('#loadbankdetails').load('loadbankdetails.php?id=<?php echo $id; ?>&dltid='+id+'&sectionType='+$('#sectionType').val());
	  }
	  
	  function deleteconfirmbank(id){
	  if (confirm("Do you want to delete this bank detail?")){
    deletebank(id);
}
	  }

function loadbankdetailsfunc(){
$('#loadbankdetails').load('loadbankdetails.php?id=<?php echo $id; ?>&sectionType='+$('#sectionType').val());
}
loadbankdetailsfunc();
</script>

</div>

  
 
</div>
<script>  
comtabopenclose('linkbox','op2');
</script>
