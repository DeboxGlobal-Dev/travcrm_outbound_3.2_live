<?php
include "inc.php"; 
include "config/logincheck.php"; 
$id=$_REQUEST['id'];
$notid=decode($_REQUEST['notid']);

?>


 <?php 
$n=1;
$select=''; 
$where=''; 
$rs='';  
$select='id,parentId,name';   
$where='parentId='.$id.' and userId = '.$loginusersuperParentId.' and deletestatus=0 order by id asc'; 
$rs=GetPageRecord($select,_ROLE_MASTER_,$where); 
while($rolelisting=mysqli_fetch_array($rs)){  
?>
<div class="roletophr">
    
	<div class="namein"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><div class="hminus" id="tabdiv<?php echo clean($rolelisting['id']); ?>"  onclick="opencloserolltabs('<?php echo clean($rolelisting['id']); ?>');"></div></td>
        <td class="nametd"><a href="#" onclick="selectrollbox('<?php echo clean($rolelisting['id']); ?>','<?php echo clean($rolelisting['name']); ?>');"><?php echo clean($rolelisting['name']); ?></a></td>
        <td>&nbsp;</td>
      </tr>
    </table></div>
	
  </div>
  <div class="nameinin"  id="rdiv<?php echo clean($rolelisting['id']); ?>">Loading...</div>
  <script>
  loadroleinnerselect('<?php echo clean($rolelisting['id']); ?>');
  </script>
  <?php $n++; } ?>
  
 