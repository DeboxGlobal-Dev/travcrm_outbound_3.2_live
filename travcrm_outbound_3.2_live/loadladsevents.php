<?php
include "inc.php"; 
include "config/logincheck.php";  

$n=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='parentId="'.$_REQUEST['leadid'].'" order by dateAdded desc'; 
$rs=GetPageRecord($select,_SALES_TIMELINE_MASTER_,$where); 
while($rest=mysqli_fetch_array($rs)){ 
?>

<style>
.salestimeline_sectionbox:hover{background-color:#FFFBE8;    box-shadow: 0px 0px 4px #00000021;}
.salestimeline_sectionbox {
    padding: 10px 20px; 
    margin-bottom: 5px;
    background-color: #FFFFFF;
    position: relative;
    cursor: pointer;
    margin: 5px 0px;
    border: 1px #f1f1f1 solid;
}
.salestimeline_sectionname{font-size:10px; color:#999999; text-transform:uppercase; margin-bottom:5px;}
.salestimeline_sectionname .fa{font-size: 20px;
    color: #404346;
    margin-right: 4px;
}
.salestimeline_name{font-size:14px; margin-bottom:7px; font-weight:500; font-size:14px; color:#333333;font-family: 'Roboto', sans-serif;}
.salestimeline_sectionbox .tag{padding:5px 7px; color:#FFFFFF; font-size:12px; position:absolute; right:10px; top:10px;    border-radius: 3px;}
.salestimeline_sectionbox .shedule{ background-color:#FF6600;}
.salestimeline_sectionbox .confirm{ background-color:#82b767;}
.salestimeline_sectionbox .canceled{ background-color:#CC3300;}
.salestimeline_option{margin-bottom:7px; color:#666666; font-size:13px;}
.salestimeline_smalltext{font-size:11px; color:#999999;}

</style>

<?php if($rest['eventType']=='calls'){

$select1='*';  
$where1='id='.$rest['eventId'].' and deletestatus=0'; 
$rs1=GetPageRecord($select1,_CALLS_MASTER_,$where1); 
$ressection=mysqli_fetch_array($rs1); 

 ?>
<a href="showpage.crm?module=calls&view=yes&id=<?php echo encode($ressection['id']); ?>" target="_blank">
<div class="salestimeline_sectionbox">
<div class="tag <?php if($ressection['status']==1){ echo 'shedule'; } if($ressection['status']==2){ echo 'confirm'; } if($ressection['status']==3){ echo 'canceled'; }?>"><?php if($ressection['status']==1){ echo 'Scheduled'; } if($ressection['status']==2){ echo 'Held'; } if($ressection['status']==3){ echo 'Canceled'; }?></div>
<div class="salestimeline_sectionname"><i class="fa fa-phone-square" aria-hidden="true"></i> Call</div>
<div class="salestimeline_name"><?php echo strip($ressection['subject']); ?></div> 
<div class="salestimeline_option"><span class="salestimeline_smalltext">Start:</span> <?php echo showdate($ressection['fromDate']); ?> - <?php echo strip($ressection['starttime']); ?>  &nbsp;<span class="salestimeline_smalltext">&nbsp;End:</span> <?php echo showdate($ressection['toDate']); ?> - <?php echo strip($ressection['endtime']); ?></div>
<div class="salestimeline_option"><span class="salestimeline_smalltext">Call Type:</span>
<?php
if($ressection['directiontype']!=''){
$select12='*';  
$where12='id='.$ressection['directiontype'].''; 
$rs12=GetPageRecord($select12,_DIRECTION_TYPE_MASTER_,$where12); 
$calltype=mysqli_fetch_array($rs12); 
echo $calltype['name'];
}
?>

 &nbsp;&nbsp; <span class="salestimeline_smalltext">Next Follow Up Date:</span> <?php echo showdate($ressection['followupdate']); ?></div>

</div>
</a>
<?php } ?>


<?php if($rest['eventType']=='meetings'){

$select1='*';  
$where1='id='.$rest['eventId'].' and deletestatus=0'; 
$rs1=GetPageRecord($select1,_MEETINGS_MASTER_,$where1); 
$ressection=mysqli_fetch_array($rs1); 

 ?>
<a href="showpage.crm?module=meetings&view=yes&id=<?php echo encode($ressection['id']); ?>" target="_blank">
<div class="salestimeline_sectionbox">
<div class="tag <?php if($ressection['status']==1){ echo 'shedule'; } if($ressection['status']==2){ echo 'confirm'; } if($ressection['status']==3){ echo 'canceled'; }?>"><?php if($ressection['status']==1){ echo 'Scheduled'; } if($ressection['status']==2){ echo 'Held'; } if($ressection['status']==3){ echo 'Canceled'; }?></div>
<div class="salestimeline_sectionname"><i class="fa fa-user" aria-hidden="true"></i> Meeting</div>
<div class="salestimeline_name"><?php echo strip($ressection['subject']); ?></div> 
<div class="salestimeline_option"><span class="salestimeline_smalltext">Start:</span> <?php echo showdate($ressection['fromDate']); ?> - <?php echo strip($ressection['starttime']); ?>  &nbsp;<span class="salestimeline_smalltext">&nbsp;End:</span> <?php echo showdate($ressection['toDate']); ?> - <?php echo strip($ressection['endtime']); ?></div>
<div class="salestimeline_option"><span class="salestimeline_smalltext">Meeting Outcome:</span>
<?php
if($ressection['directiontype']!=''){
$select12='*';  
$where12='id='.$ressection['directiontype'].''; 
$rs12=GetPageRecord($select12,_MEETINGS_OUTCOME_,$where12); 
$calltype=mysqli_fetch_array($rs12); 
echo $calltype['name'];
}
?>

 &nbsp;&nbsp; <span class="salestimeline_smalltext">Next Follow Up Date:</span> <?php echo showdate($ressection['followupdate']); ?></div>

</div>
</a>
<?php } ?>



<?php if($rest['eventType']=='tasks'){

$select1='*';  
$where1='id='.$rest['eventId'].' and deletestatus=0'; 
$rs1=GetPageRecord($select1,_TASKS_MASTER_,$where1); 
$ressection=mysqli_fetch_array($rs1); 

 ?>
<a href="showpage.crm?module=tasks&view=yes&id=<?php echo encode($ressection['id']); ?>" target="_blank">
<div class="salestimeline_sectionbox">
<div class="tag <?php if($ressection['status']==1){ echo 'shedule'; } if($ressection['status']==2){ echo 'confirm'; } if($ressection['status']==3){ echo 'canceled'; }?>"><?php if($ressection['status']==1){ echo 'Scheduled'; } if($ressection['status']==2){ echo 'Held'; } if($ressection['status']==3){ echo 'Canceled'; }?></div>
<div class="salestimeline_sectionname"><i class="fa fa-clock-o" aria-hidden="true"></i> Task</div>
<div class="salestimeline_name"><?php echo strip($ressection['subject']); ?></div> 
<div class="salestimeline_option"><span class="salestimeline_smalltext">Start:</span> <?php echo showdate($ressection['fromDate']); ?> - <?php echo strip($ressection['starttime']); ?>  &nbsp;<span class="salestimeline_smalltext">&nbsp;End:</span> <?php echo showdate($ressection['toDate']); ?> - <?php echo strip($ressection['endtime']); ?></div>
<div class="salestimeline_option"><span class="salestimeline_smalltext">Priority:</span>
<?php
if($ressection['directiontype']!=''){
$select12='*';  
$where12='id='.$ressection['directiontype'].''; 
$rs12=GetPageRecord($select12,_TASKS_OUTCOME_,$where12); 
$calltype=mysqli_fetch_array($rs12); 
echo $calltype['name'];
}
?> </div>

</div>
</a>
<?php } ?>
<?php $n++; } 


if($n==0){
?>
<div style="padding:10px; border-bottom:2px #CCCCCC solid; margin-bottom:5px; background-color:#FFFFFF; text-align:center; color:#999999;">No Activity </div>
<?php } ?>

