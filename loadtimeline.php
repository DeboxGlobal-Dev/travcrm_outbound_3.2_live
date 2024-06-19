<?php 
include "inc.php"; 
include "config/logincheck.php"; 
$my = $_REQUEST['my'];

$wherequery='';
if($my==1){
$wherequery= ' and addedBy='.$loginuserID.' ';
}






?>






<link href="css/main.css" rel="stylesheet" type="text/css">



<div id="timelinebox">
 <div class="postbox">
<form class="edit-layer" id="uploadForm" name="uploadForm" enctype="multipart/form-data"  method="post" action="frm_action.crm" target="actoinfrm" >  <div class="wbox">
   <textarea class="submittextfield" placeholder="Hey! What's up?" id="postsubmitfield" name="postsubmitfield" onBlur="showsubmitfrombtn();" onFocus="$('#submitpostbtndiv').show();"></textarea>
   <div class="attachtab" id="submitattach"><span>Attach (maximum file size 20MB)</span><input type="file" id="attachpostsubmit" name="attachpostsubmit" onChange="attachsubmitpostfile();showsubmitfrombtn();">
   </div>
 </div>
 <div class="btnsec" id="submitpostbtndiv" style="display:none;"><input name="addnewuserbtn" type="submit" onclick='showFileSize();' class="bluembutton submitbtn" id="addnewuserbtn" value="  Post  " ></div>
 <input name="action" type="hidden" id="action" value="submitpost">
 </form>
 </div>
 
 
 <h2>&nbsp;</h2>
 

 <div class="loadposts">
<link href="css/default.css" rel="stylesheet" type="text/css">
 <?php 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch='';
 $limit=clean($_GET['records']);
 

$where='where userId='.$loginusersuperParentId.' '.$wherequery.' and parentId=0 order by id desc';  
 $page=$_GET['page'];
$targetpage=$fullurl.'showpage.crm?module=timeline&records='.$limit.'&my='.$_GET['my'].'&'; 
$rs=GetRecordList($select,_TIMELINE_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($timeline=mysqli_fetch_array($rs[0])){







$select2='firstName,lastName,profilePhoto';  
$where2='id='.$timeline['addedBy'].''; 
$rs2=GetPageRecord($select2,_USER_MASTER_,$where2); 
$userInfopost=mysqli_fetch_array($rs2);

if($timeline['timelineType']==1){
$nn=1;
?>
<div class="postmainbox">
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="6%" valign="top"><div class="img"><img src="<?php if($userInfopost['profilePhoto']!=''){ ?>profilepic/<?php echo $userInfopost['profilePhoto']; ?><?php } else { ?>images/user.png<?php } ?>" /></div></td>
    <td width="94%" valign="top"><div class="name"><?php echo strip($userInfopost['firstName']); ?> <?php echo strip($userInfopost['lastName']); ?></div>
      <div class="datetime"><?php echo datetimemix($timeline['dateAdded']); ?></div>
	  <div class="msg"><?php if($timeline['timelineType']=='2'){ ?><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($timeline['queryId']); ?>" target="_blank"><div class="tat"><?php echo strip($timeline['postText']); ?></div></a><?php } else {  echo strip($timeline['postText']); } ?>
	  
	   <?php if($timeline['timelineType']=='1'){ if($loginuserID==$timeline['addedBy'] || $loginusersuperParentId==$_SESSION['userid']){ ?>&nbsp;&nbsp;&nbsp; <span class="dltspan"><a onclick="alertspopupopen('action=dlttimelinepost&id=<?php echo encode($timeline['id']); ?>','600px','auto');">Delete</a></span><?php } } ?>
	   
	  
<?php 
$select22=''; 
$where22=''; 
$rs22='';  
$select22='fileName,id';   
$where22='userId='.$loginusersuperParentId.' and parentId = '.$timeline['id'].''; 
$rs22=GetPageRecord($select22,_FILE_MASTER_,$where22); 
while($attachedfile=mysqli_fetch_array($rs22)){  
?>
	  <a href="download/<?php echo $attachedfile['fileName']; ?>" target="_blank"><div class="attachedbox"><?php echo $attachedfile['fileName']; ?></div></a>
	  <?php } ?>
	  </div>
	  
	  
	  
	   
<div id="replydiv<?php echo $timeline['id']; ?>"></div>
<script>
loadpostreply('<?php echo $timeline['id']; ?>','<?php echo $timeline['addedBy']; ?>');
</script>
	   
	   
	  
	  
	  
	  </td>
  </tr>
</table>

 
 </div>
 
 
<?php } else { 

if($_SESSION['userid']==37 || $_SESSION['userid']==$timeline['queryUserId']){
?>

<div class="postmainbox">
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="6%" valign="top"><div class="img"><img src="<?php if($userInfopost['profilePhoto']!=''){ ?>profilepic/<?php echo $userInfopost['profilePhoto']; ?><?php } else { ?>images/user.png<?php } ?>" /></div></td>
    <td width="94%" valign="top"><div class="name"><?php echo strip($userInfopost['firstName']); ?> <?php echo strip($userInfopost['lastName']); ?></div>
      <div class="datetime"><?php echo datetimemix($timeline['dateAdded']); ?></div>
	  <div class="msg"><?php if($timeline['timelineType']=='2'){ ?><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($timeline['queryId']); ?>" target="_blank"><div class="tat"><?php echo strip($timeline['postText']); ?></div></a><?php } else {  echo strip($timeline['postText']); } ?>
	  
	   <?php if($timeline['timelineType']=='1'){ if($loginuserID==$timeline['addedBy'] || $loginusersuperParentId==$_SESSION['userid']){ ?>&nbsp;&nbsp;&nbsp; <span class="dltspan"><a onclick="alertspopupopen('action=dlttimelinepost&id=<?php echo encode($timeline['id']); ?>','600px','auto');">Delete</a></span><?php } } ?>
	   
	  
<?php 
$select22=''; 
$where22=''; 
$rs22='';  
$select22='fileName,id';   
$where22='userId='.$loginusersuperParentId.' and parentId = '.$timeline['id'].''; 
$rs22=GetPageRecord($select22,_FILE_MASTER_,$where22); 
while($attachedfile=mysqli_fetch_array($rs22)){  
?>
	  <a href="download/<?php echo $attachedfile['fileName']; ?>" target="_blank"><div class="attachedbox"><?php echo $attachedfile['fileName']; ?></div></a>
	  <?php } ?>
	  </div>
	  
	  
	  
	   
<div id="replydiv<?php echo $timeline['id']; ?>"></div>
<script>
loadpostreply('<?php echo $timeline['id']; ?>','<?php echo $timeline['addedBy']; ?>');
</script>
	   
	   
	  
	  
	  
	  </td>
  </tr>
</table>

 
 </div>
 
 
<?php 

}

}  
 
 } ?>
  <?php if($nn!=1){ ?><div style="padding:20px; text-align:center;">No Post</div><?php } ?>
 </div>
 <div class="pagingdiv">

		

		<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tbody><tr>

    <td> <div class="pagingnumbers"><?php echo $paging; ?></div></td>

    </tr>
</tbody></table>



  </div>
 </div>
<script>
stoptloading();
</script>

<style>
.tat{padding:6px 10px; background-color:#CC0000; color:#FFFFFF; border-radius: 5px;}
</style>