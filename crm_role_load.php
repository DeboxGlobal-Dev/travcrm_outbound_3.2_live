<?php
include "inc.php"; 
include "config/logincheck.php"; 
$id=$_REQUEST['id'];



$selecta='*';  
$wherea='profileId='.$loginuserprofileId.' and moduleId="23"'; 
$rsa=GetPageRecord($selecta,_PERMISSION_MASTER_,$wherea); 
$permissionmst=mysqli_fetch_array($rsa);

$viewpermission=$permissionmst['view'];
$addpermission=$permissionmst['addentry'];
$editpermission=$permissionmst['edit'];
$deletepermission=$permissionmst['dlt'];
$importpermission=$permissionmst['import'];
$exportpermission=$permissionmst['export'];
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


$sql5='select id from '._ROLE_MASTER_.' where parentId='.$rolelisting['id'].' and userId = '.$loginusersuperParentId.' and deletestatus=0 ';
$res5 = mysqli_query(db(),$sql5);
$num1=mysqli_num_rows($res5);  


$sql5='select id from '._USER_MASTER_.' where roleId='.$rolelisting['id'].'';
$res5 = mysqli_query(db(),$sql5);
$num2=mysqli_num_rows($res5);  
?>
<div class="roletophr">
    
	<div class="namein"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><div class="hminus" id="tabdiv<?php echo clean($rolelisting['id']); ?>"  onclick="opencloserolltabs('<?php echo clean($rolelisting['id']); ?>');"></div></td>
        <td class="nametd" ><div style="cursor:pointer;" onclick="view('<?php echo encode($rolelisting['id']); ?>');"><?php echo clean($rolelisting['name']); ?></div></td>
        <td><div class="roption">
		<table border="0" cellpadding="0" cellspacing="0">
  <tr>
 <?php if($addpermission==1){ ?><td align="center"><a href="setupsetting.crm?module=role&add=yes&sid=<?php echo encode($rolelisting['id']); ?>" onclick="startloading();"><img src="images/addr.png" width="16" height="16" /></a></td><?php } ?>
<?php if($editpermission==1){ ?><td align="center"><a href="setupsetting.crm?module=role&edit=yes&sid=<?php echo encode($rolelisting['id']); ?>&id=<?php echo encode($rolelisting['id']); ?>" onclick="startloading();"><img src="images/editicon.png" /></a>
	
	</td><?php } ?>
    <?php if($deletepermission==1){ ?><?php /// if($num1<1){ ?><?php //if($num2<1){ ?><td align="center"><a href="#" onclick="$('#dids').val('<?php echo encode($rolelisting['id']); ?>');alertspopupopen('action=dltrole','600px','auto');"><img src="images/rdelete.png" /></a></td><?php } /// } }?>
  </tr>
</table>

		</div></td>
      </tr>
    </table></div>
	
  </div>
  <div class="nameinin"  id="rdiv<?php echo clean($rolelisting['id']); ?>">Loading...</div>
  <script>
  loadroleinner('<?php echo clean($rolelisting['id']); ?>');
  </script>
  <?php $n++; } ?>
  