<?php
include "inc.php"; 
include "config/logincheck.php";  

$id=$_GET['id'];
$clientType=$_GET['clientType'];
$parentType=$_GET['parentType'];
$pageid=encode($_GET['id']); 

if($parentType=='lead'){

if($clientType==1){
$rpage=encode('showpage.crm?module=corporate&view=yes&id='.$pageid.'');
}
if($clientType==2){
$rpage=encode('showpage.crm?module=contacts&view=yes&id='.$pageid.'');
}


}
?>
<div>
<div class="innerbox" style="border-top:1px #eee solid; padding-top:30px;">
      <h2 style="margin-bottom:20px;">Calls &nbsp;&nbsp;&nbsp;<a href="showpage.crm?module=calls&add=yes&cid=<?php echo encode($id); ?>&clientType=<?php echo $clientType; ?>&rpage=<?php echo $rpage; ?>" style="text-decoration:underline; font-size:13px;">+ Add Call </a></h2>
	  
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
     <th align="left" class="header">Call&nbsp;Subject</th>
      <th align="left" class="header">start&nbsp;date </th>
     <th align="left" class="header">status</th>
     <th align="left" class="header">Call&nbsp;Type </th>
     <th align="left" class="header" >sales Person </th>
     <th align="left" class="header" >created&nbsp;date </th>
   </tr>
   </thead>

 


 

  <tbody>
  <?php

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=1000;
 
$where='where companyId = '.$id.' and clientType='.$clientType.' and deletestatus=0 order by dateAdded desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=calls&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&'; 
$rs=GetRecordList($select,_CALLS_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
?>
  <tr>
    <td align="left"><div style="max-width:200px;" class="bluelink" ><a href="showpage.crm?module=calls&view=yes&id=<?php echo encode($resultlists['id']); ?>" target="_blank"><?php echo clean($resultlists['subject']); ?></a></div></td>
    <td align="left"><?php echo showdate($resultlists['fromDate']); ?></td>
    <td align="left" class="salestimeline_sectionbox"><div class="tag <?php if($resultlists['status']==1){ echo 'shedule'; } if($resultlists['status']==2){ echo 'confirm'; } if($resultlists['status']==3){ echo 'canceled'; }?>"><?php if($resultlists['status']==1){ echo 'Scheduled'; } if($resultlists['status']==2){ echo 'Held'; } if($resultlists['status']==3){ echo 'Canceled'; }?></div></td>
    <td align="left"><?php
if($resultlists['directiontype']!=''){
$select12='*';  
$where12='id='.$resultlists['directiontype'].''; 
$rs12=GetPageRecord($select12,_DIRECTION_TYPE_MASTER_,$where12); 
$calltype=mysqli_fetch_array($rs12); 
echo $calltype['name'];
}
?></td>
    <td align="left" ><?php echo getUserName($resultlists['assignTo']); ?></td>
    <td align="left" ><?php echo showdate(date('Y-m-d',$resultlists['dateAdded'])); ?></td>
  </tr> 
	
	<?php $no++; } ?>
</tbody></table><?php if($no==1){ ?>
<div class="norec">No Call</div>
<?php } ?>
  </div>
<div class="innerbox" style="border-top:1px #eee solid; padding-top:30px;">
      <h2 style="margin-bottom:20px;">Meetings &nbsp;&nbsp;&nbsp;<a href="showpage.crm?module=meetings&add=yes&cid=<?php echo encode($id); ?>&clientType=<?php echo $clientType; ?>&rpage=<?php echo $rpage; ?>" style="text-decoration:underline; font-size:13px;">+ Add Meeting </a></h2>
	  
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
     <th align="left" class="header">Meeting&nbsp;Agenda</th>
      <th align="left" class="header">start&nbsp;date </th>
     <th align="left" class="header">status</th>
     <th align="left" class="header">Meeting Outcome </th>
     <th align="left" class="header" >sales Person </th>
     <th align="left" class="header" >created&nbsp;date </th>
   </tr>
   </thead>

 


 

  <tbody>
  <?php

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=1000;
 
$where='where companyId = '.$id.' and clientType='.$clientType.' and deletestatus=0 order by dateAdded desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=calls&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&'; 
$rs=GetRecordList($select,_MEETINGS_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
?>
  <tr>
    <td align="left"><div style="max-width:200px;" class="bluelink" ><a href="showpage.crm?module=meetings&view=yes&id=<?php echo encode($resultlists['id']); ?>" target="_blank"><?php echo clean($resultlists['subject']); ?></a></div></td>
    <td align="left"><?php echo showdate($resultlists['fromDate']); ?></td>
    <td align="left" class="salestimeline_sectionbox"><div class="tag <?php if($resultlists['status']==1){ echo 'shedule'; } if($resultlists['status']==2){ echo 'confirm'; } if($resultlists['status']==3){ echo 'canceled'; }?>"><?php if($resultlists['status']==1){ echo 'Scheduled'; } if($resultlists['status']==2){ echo 'Held'; } if($resultlists['status']==3){ echo 'Canceled'; }?></div></td>
    <td align="left"><?php
if($resultlists['directiontype']!=''){
$select12='*';  
$where12='id='.$resultlists['directiontype'].''; 
$rs12=GetPageRecord($select12,_MEETINGS_OUTCOME_,$where12); 
$calltype=mysqli_fetch_array($rs12); 
echo $calltype['name'];
}
?></td>
    <td align="left" ><?php echo getUserName($resultlists['assignTo']); ?></td>
    <td align="left" ><?php echo showdate(date('Y-m-d',$resultlists['dateAdded'])); ?></td>
  </tr> 
	
	<?php $no++; } ?>
</tbody></table><?php if($no==1){ ?>
<div class="norec">No Meeting </div>
<?php } ?>
  </div>
<div class="innerbox" style="border-top:1px #eee solid; padding-top:30px;">
      <h2 style="margin-bottom:20px;">Tasks &nbsp;&nbsp;&nbsp;<a href="showpage.crm?module=tasks&add=yes&cid=<?php echo encode($id); ?>&clientType=<?php echo $clientType; ?>&rpage=<?php echo $rpage; ?>" style="text-decoration:underline; font-size:13px;">+ Add Task </a></h2>
	  
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
     <th align="left" class="header">Subject</th>
      <th align="left" class="header">start&nbsp;date </th>
     <th align="left" class="header">status</th>
     <th align="left" class="header" >sales Person </th>
     <th align="left" class="header" >created&nbsp;date </th>
   </tr>
   </thead>

 


 

  <tbody>
  <?php

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=1000;
 
$where='where companyId = '.$id.' and clientType='.$clientType.' and deletestatus=0 order by dateAdded desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=calls&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&'; 
$rs=GetRecordList($select,_TASKS_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
?>
  <tr>
    <td align="left"><div style="max-width:200px;" class="bluelink" ><a href="showpage.crm?module=tasks&view=yes&id=<?php echo encode($resultlists['id']); ?>" target="_blank"><?php echo clean($resultlists['subject']); ?></a></div></td>
    <td align="left"><?php echo showdate($resultlists['fromDate']); ?></td>
    <td align="left" class="salestimeline_sectionbox"><div class="tag <?php if($resultlists['status']==1){ echo 'shedule'; } if($resultlists['status']==2){ echo 'confirm'; } if($resultlists['status']==3){ echo 'canceled'; }?>"><?php if($resultlists['status']==1){ echo 'Scheduled'; } if($resultlists['status']==2){ echo 'Held'; } if($resultlists['status']==3){ echo 'Canceled'; }?></div></td>
    <td align="left" ><?php echo getUserName($resultlists['assignTo']); ?></td>
    <td align="left" ><?php echo showdate(date('Y-m-d',$resultlists['dateAdded'])); ?></td>
  </tr> 
	
	<?php $no++; } ?>
</tbody></table>
	  <?php if($no==1){ ?>
<div class="norec">No Task </div>
<?php } ?>
  </div>
</div>