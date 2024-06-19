<?php
include "inc.php"; 
include "config/logincheck.php"; 
?>

<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='userId='.$loginusersuperParentId.' and postType="reply" and replyPostowner='.$loginuserID.' order by id desc'; 
$rs=GetPageRecord($select,_NOTIFICATION_MASTER_,$where); 
while($timeline=mysqli_fetch_array($rs)){  

$select2='firstName,lastName,profilePhoto';  
$where2='id='.$timeline['addedBy'].''; 
$rs2=GetPageRecord($select2,_USER_MASTER_,$where2); 
$userInfopost=mysqli_fetch_array($rs2);

$select4='postText';  
$where4='id='.$timeline['parentId'].''; 
$rs4=GetPageRecord($select4,_TIMELINE_MASTER_,$where4); 
$postdata=mysqli_fetch_array($rs4);

$nn=1;
?>
<div class="boxed" onClick="setupbox('show-page.crm?module=timeline');">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="7%"><div class="img"><img src="<?php if($userInfopost['profilePhoto']!=''){ ?>profilepic/<?php echo $userInfopost['profilePhoto']; ?><?php } else { ?>images/user.png<?php } ?>" /></div></td>
    <td width="93%"><div class="name"><strong><?php echo strip($userInfopost['firstName']); ?> <?php echo strip($userInfopost['lastName']); ?></strong> commented on your post <br>
<a onClick="setupbox('show-page.crm?module=timeline');" style="color:#2ca1cc;"><?php echo substr(strip_tags($postdata['postText']),0,30); ?>...</a></div>
      <div class="datetime"><?php echo datetimemix($timeline['dateAdded']); ?></div></td>
  </tr>
  
</table>

</div> 
<?php } ?>










<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='userId='.$loginusersuperParentId.' and postType="post" and parentId='.$loginuserID.' order by id desc'; 
$rs=GetPageRecord($select,_NOTIFICATION_MASTER_,$where); 
while($timeline=mysqli_fetch_array($rs)){  

$select2='firstName,lastName,profilePhoto';  
$where2='id='.$timeline['addedBy'].''; 
$rs2=GetPageRecord($select2,_USER_MASTER_,$where2); 
$userInfopost=mysqli_fetch_array($rs2);

$nn=1;
?>
<div class="boxed" onClick="setupbox('show-page.crm?module=timeline');">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="7%"><div class="img"><img src="<?php if($userInfopost['profilePhoto']!=''){ ?>profilepic/<?php echo $userInfopost['profilePhoto']; ?><?php } else { ?>images/user.png<?php } ?>" /></div></td>
    <td width="93%"><div class="name"><strong><?php echo strip($userInfopost['firstName']); ?> <?php echo strip($userInfopost['lastName']); ?></strong> posted on timeline</div>
      <div class="datetime"><?php echo datetimemix($timeline['dateAdded']); ?></div></td>
  </tr>
  
</table>

</div> 
<?php } ?>




<?php if($nn!=1){ ?>
<div class="coughtall">Caught up with everything!</div>
  <?php } ?>