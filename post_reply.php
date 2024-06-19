<?php 
include "inc.php"; 
include "config/logincheck.php"; 
$id = clean($_REQUEST['id']);
$addby = clean($_REQUEST['addby']);
?>

<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='userId='.$loginusersuperParentId.' and parentId='.$id.' order by id asc'; 
$rs=GetPageRecord($select,_TIMELINE_MASTER_,$where); 
while($timeline=mysqli_fetch_array($rs)){  

$select2='firstName,lastName,profilePhoto';  
$where2='id='.$timeline['addedBy'].''; 
$rs2=GetPageRecord($select2,_USER_MASTER_,$where2); 
$userInfopost=mysqli_fetch_array($rs2);
?>
<div class="boxedreply"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="7%"><div class="img"><img src="<?php if($userInfopost['profilePhoto']!=''){ ?>profilepic/<?php echo $userInfopost['profilePhoto']; ?><?php } else { ?>images/user.png<?php } ?>" /></div></td>
    <td width="93%"><div class="name"><strong><?php echo strip($userInfopost['firstName']); ?> <?php echo strip($userInfopost['lastName']); ?></strong> <?php echo strip($timeline['postText']); ?> <?php if($loginuserID==$timeline['addedBy'] || $loginusersuperParentId==$_SESSION['userid'] || $_SESSION['userid']==$addby){ ?>&nbsp;&nbsp;&nbsp; <span class="dltspan2"><a onclick="alertspopupopen('action=dlttimelinepost&id=<?php echo encode($timeline['id']); ?>&timelinecomment=1','600px','auto');">Delete</a></span><?php } ?></div>
      <div class="datetime"><?php echo datetimemix($timeline['dateAdded']); ?></div></td>
  </tr>
  
</table>

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
<?php } ?>


<form class="edit-layer" enctype="multipart/form-data"  method="post" action="frm_action.crm" target="actoinfrm" >
<div class="teplybox">
	  <div class="wbox2">
	  <input name="postreplyfield" type="text" class="replyfield" id="postreplyfield" onFocus="$('#postrplybox<?php echo $id; ?>').show();" placeholder="Write a comment.">
	  </div>
	  
	  <div style="display:none;" class="btninnerreply" id="postrplybox<?php echo $id; ?>"><div class="btnboxreply">
	  <div class="replyattach" id="attre<?php echo $id; ?>"><span id="spanattach<?php echo $id; ?>">Attach File</span><input type="file" id="attachpostsubmit<?php echo $id; ?>" name="attachpostsubmit" onchange="selectreplyuploadfile(<?php echo $id; ?>,<?php echo $addby; ?>);"></div>
	  </div>
	    <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><input name="addnewuserbtn" type="submit" class="bluembutton3" id="addnewuserbtn" value="Submit" >
			<input name="action" type="hidden" id="action" value="submitpostreply">
			<input name="parentId" type="hidden" id="parentId"  value="<?php echo $id; ?>">
			<input name="addby" type="hidden" id="addby"  value="<?php echo $addby; ?>">
			</td>
            <td><a onClick="$('#postrplybox<?php echo $id; ?>').hide();replaceuploadreply('<?php echo $id; ?>');">Cancel</a></td>
          </tr>
        </table>
	  </div>
	  </div>
	  </form>
	  
	  
<script>
stoptloading();
</script>