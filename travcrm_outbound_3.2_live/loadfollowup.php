<script src="js/jquery-1.11.3.min.js"></script>  
<?php include "inc.php"; 

if($_REQUEST['action']=='saveQueryNotification'){

$querynotesid =$_REQUEST['querynotesid'];
$followupstatus =$_REQUEST['followupstatus'];
$reminderTime = date('H:i:s',strtotime($_REQUEST['reminderTime']));
$reminderDate=$_REQUEST['reminderDate'];

$newdatetime=($_REQUEST['reminderDate'].' '.$reminderTime);

if($followupstatus==2){
$namevalue ='status="'.$followupstatus.'"'; 
}
else {
$namevalue ='reminderTime="'.$reminderTime.'",reminderDate="'.$reminderDate.'",dataandtime="'.$newdatetime.'"'; 
}
$where='id="'.$querynotesid.'"';  
$update = updatelisting('queryNotesMaster',$namevalue,$where);
if($followupstatus==2){
?>
<script>
parent.$('#followupclass').load('loadfollowup.php');
</script>
<?php 
}}






?>
<div style="width: 430px; position: fixed; font-size: 12px; z-index: 9999; color: #000; background: #ccc; padding: 5px 10px; text-transform: uppercase;">Query Notes <span style="float: right; cursor:pointer;" onClick="closefollowpopup();" ><i class="fa fa-times" aria-hidden="true" style="color: #000; font-size: 15px;"></i></span></div>

<div class="follow-up" style="margin-top: 35px;">
 
<!--show next follow upps-->
<div>
<?php 
$selectz='*';  
$wherez='status!="2" and dataandtime>="'.strtotime(date("Y-m-d h:i A")).'" order by dataandtime asc limit 30'; 
$rsz=GetPageRecord($selectz,'queryNotesMaster',$wherez); 
while($resListing=mysqli_fetch_array($rsz)){
$selecty='*';      
$wherey='id="'.$resListing['queryId'].'"';  
$rsy=GetPageRecord($selecty,'queryMaster',$wherey); 
$queryresult=mysqli_fetch_array($rsy);

$dbdatetime=strtotime($resListing['reminderDate'].' '.$resListing['reminderTime']);
$currentdatetime=strtotime(date("Y-m-d h:i A"));
?>  

<div class="first-class">
<div><?php echo makeQueryId($queryresult['id']).'-'.$resListing['title']; ?> 

<span style="float:right;">
<select name="followupstatus" id="followupstatus" style="padding: 5px 10px;border-radius: 3px;" onChange="saveStatus<?php echo $resListing['id']; ?>(this.value);">
<option selected="selected" value="">Action</option>
<option value="1">Extend</option>
<option value="2">Completed</option>
</select>
</span>
</div>

<div id="timeExtend<?php echo $resListing['id']; ?>" style="width: 100%; text-align: left; margin-bottom: 10px;display:none;margin-top: 10px;">
	<input name="reminderDate" type="date" id="reminderDate" style="padding: 3px; width: fit-content;border: 0px solid;border-radius: 3px;" value="<?php echo date('Y-m-d',strtotime($resListing['reminderDate'])); ?>" onChange="savetimeExtend<?php echo $resListing['id']; ?>();"/>
	
	<select id="reminderTime" name="reminderTime" class="gridfield" autocomplete="off"  style="padding: 5px 10px;width: 108px;border: 0px solid;border-radius: 3px;" onChange="savetimeExtend<?php echo $resListing['id']; ?>();"> 
	<?php
	$start=strtotime('00:00');
	$end=strtotime('23:30');
	for($i=$start;$i<=$end;$i=$i+15*60){ ?>
	<option value="<?php echo date('g:i A',$i); ?>" <?php if( date('g:i A',strtotime($resListing['reminderTime'])) == date('g:i A',$i)){ echo 'selected'; } ?>><?php echo date('g:i A',$i); ?></option>
	<?php } ?>
	</select>
	 
	<span style="background: #4caf50; padding: 2px 15px 4px 15px; display: initial; cursor:pointer;border-radius: 3px;" onClick="loadFollowUp();">Save</span>
</div>
 
<div style="color: #000; font-size: 12px; padding: 5px 8px; background-color: #fff7f3; margin: 5px 0px; width: 96%;margin-top: 10px;border-radius: 3px;">Assign To</span> - <?php echo getUserName($resListing['userId']); ?> <span style="color:#000; ">Reminder</span> - <?php echo date('d-m-Y',strtotime($resListing['reminderDate'])).' '.$resListing['reminderTime']; ?></div>
<div style="color: #000;font-size: 12px;"><?php echo $resListing['subtitle'].'-'.$resListing['noteDetails']; ?> </div>

</div>

<script>
function saveStatus<?php echo $resListing['id']; ?>(id){
	if(id==2){
	
	$('#followupclassa<?php echo $resListing['id']; ?>').load('loadfollowup.php?querynotesid=<?php echo $resListing['id']; ?>&action=saveQueryNotification&followupstatus='+id);
	}
	else{
	$('#timeExtend<?php echo $resListing['id']; ?>').show();
	}
	}
function savetimeExtend<?php echo $resListing['id']; ?>(){
var reminderTime=encodeURI($('#reminderTime').val());
var reminderDate=$('#reminderDate').val();
	$('#followupclassa<?php echo $resListing['id']; ?>').load('loadfollowup.php?querynotesid=<?php echo $resListing['id']; ?>&action=saveQueryNotification&reminderTime='+reminderTime+'&reminderDate='+reminderDate);
}
</script>
 <div id="followupclassa<?php echo $resListing['id']; ?>"></div>
<?php } ?>

 
</div>
<!--show next follow upps-->

<!--show previous follow ups-->
<div>
<?php 
$selectz='*';  
$wherez='status!="2" and dataandtime<="'.strtotime(date("Y-m-d h:i A")).'" order by dataandtime desc limit 30'; 
$rsz=GetPageRecord($selectz,'queryNotesMaster',$wherez); 
while($resListing=mysqli_fetch_array($rsz)){
$selecty='*';      
$wherey='id="'.$resListing['queryId'].'"';  
$rsy=GetPageRecord($selecty,'queryMaster',$wherey); 
$queryresult=mysqli_fetch_array($rsy);


$dbdatetime=strtotime($resListing['reminderDate'].' '.$resListing['reminderTime']);
$currentdatetime=strtotime(date("Y-m-d h:i A"));
?>  

<div class="first-class" style="border: 1px #e65d52 solid; background-color: #e65d52;">
<div><?php echo makeQueryId($queryresult['id']).'-'.$resListing['title']; ?> 
</div>

<div id="timeExtend<?php echo $resListing['id']; ?>" style="width: 100%; text-align: left; margin-bottom: 10px;display:none;margin-top: 10px;">
	<input name="reminderDate" type="date" id="reminderDate" style="padding: 3px; width: fit-content;border: 0px solid;border-radius: 3px;" value="<?php echo date('Y-m-d'); ?>" onChange="savetimeExtend<?php echo $resListing['id']; ?>();"/>
	
	<select id="reminderTime" name="reminderTime" class="gridfield" autocomplete="off"  style="padding: 5px 10px;width: 108px;border: 0px solid;border-radius: 3px;" onChange="savetimeExtend<?php echo $resListing['id']; ?>();"> 
	<?php
	$start=strtotime('00:00');
	$end=strtotime('23:30');
	for($i=$start;$i<=$end;$i=$i+15*60){ ?>
	<option value="<?php echo date('g:i A',$i); ?>"><?php echo date('g:i A',$i); ?></option>
	<?php } ?>
	</select>
	 
	<span style="background: #4caf50; padding: 2px 15px 4px 15px; display: initial; cursor:pointer;border-radius: 3px;" onClick="loadFollowUp();">Save</span>
</div>
 
<div style="color: #000; font-size: 12px; padding: 5px 8px; background-color: #fff7f3; margin: 5px 0px; width: 96%;margin-top: 10px;border-radius: 3px;">Assign To</span> - <?php echo getUserName($resListing['userId']); ?> <span style="color:#000; ">Reminder</span> - <?php echo date('d-m-Y',strtotime($resListing['reminderDate'])).' '.$resListing['reminderTime']; ?></div>
<div style="color: #000;font-size: 12px;"><?php echo $resListing['subtitle'].'-'.$resListing['noteDetails']; ?> </div>

</div>

<script>
function saveStatus<?php echo $resListing['id']; ?>(id){
	if(id==2){
	
	$('#followupclassa<?php echo $resListing['id']; ?>').load('loadfollowup.php?querynotesid=<?php echo $resListing['id']; ?>&action=saveQueryNotification&followupstatus='+id);
	}
	else{
	$('#timeExtend<?php echo $resListing['id']; ?>').show();
	}
	}
function savetimeExtend<?php echo $resListing['id']; ?>(){
var reminderTime=encodeURI($('#reminderTime').val());
var reminderDate=$('#reminderDate').val();
	$('#followupclassa<?php echo $resListing['id']; ?>').load('loadfollowup.php?querynotesid=<?php echo $resListing['id']; ?>&action=saveQueryNotification&reminderTime='+reminderTime+'&reminderDate='+reminderDate);
}
</script>
 <div id="followupclassa<?php echo $resListing['id']; ?>"></div>
<?php } ?>

 
</div>
<!--show previous follow ups-->
</div>

<script>
function closefollowpopup(){
$('#followupclass').hide();
}
</script>