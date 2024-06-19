<?php
if($editpermission!=1){
  header('location:'.$fullurl.'');
}

if($loginusersuperParentId!=''){
  $id=$loginusersuperParentId;

  $select1='*';  
  $where1='id='.$id.''; 
  $rs1=GetPageRecord($select1,_USER_MASTER_,$where1); 
  $editresult=mysqli_fetch_array($rs1);

  $editUserId=$loginusersuperParentId;
  $editComapnyanme=clean($editresult['company']); 

}
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php echo $pageName; ?></td>
  </tr>
  
</table>
        <input type="hidden" name="id"  id="id" value="<?php echo $_GET['id']; ?>"/>
    </div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="padding-right:20px;"><a href="setupsetting.crm?module=modules"><input type="button" name="Submit2" value="Reload" class="whitembutton" /></a></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter">
 <div class="addeditpagebox vieweditpagebox"><div class="innerbox">
    
   <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <?php if($editpermission==1){ ?>  <?php } ?>
     <th width="245" align="left" class="header" >Displayed in tabs as </th>

     <th width="331" align="left" class="header">Module Name</th>

     <th width="370" align="left" class="header">Modified&nbsp;By</th>
     </tr>
   </thead>

<tbody>
<?php
$n=1;
$select='*';
$rs=$where='';
$where=' id in ( select parentId from '._USER_MODULE_MASTER_.' where userId='.$editUserId.' ) order by sr asc'; 
$rs=GetPageRecord($select,_MODULE_MASTER_,$where); 
while($moduleData=mysqli_fetch_array($rs)){

  $select1='*';
  $where1='parentId='.$moduleData['id'].' and userId='.$editUserId.''; 
  $rs1=GetPageRecord($select1,_USER_MODULE_MASTER_,$where1); 
  $userModuleData=mysqli_fetch_array($rs1);
  if($userModuleData['mainmenu']==1 || $userModuleData['mainmenu']==2 || $userModuleData['mainmenu']==4){
  ?>
  <tr>
    <td align="left" valign="top"><input type="text" class="modulettextfiled" id="editmod<?php echo $userModuleData['id']; ?>" name="editmod<?php echo $userModuleData['id']; ?>" value="<?php echo $userModuleData['moduleName']; ?>" maxlength="65" onblur="changemodulelable('<?php echo encode($userModuleData['id']); ?>','<?php echo $userModuleData['id']; ?>');" /></td>
    <td align="left" valign="top"><?php echo $moduleData['moduleName']; ?></td>
    <td align="left" valign="top">
      <?php 
      if($userModuleData['modifyBy']!=''){ ?><?php 
        $selectaa='firstName,lastName';   
        $whereaa='id="'.$userModuleData['modifyBy'].'"'; 
        $rsaa=GetPageRecord($selectaa,_USER_MASTER_,$whereaa); 
        while($userss=mysqli_fetch_array($rsaa)){  
          echo $userss['firstName'].' '.$userss['lastName'];
        }
        ?>
  	   <div style="margin-top:0px; font-size:11px; color:#666666;"><?php if($userModuleData['modifyDate']!='0'){ echo showdatenormal($userModuleData['modifyDate'],$loginusertimeFormat); } ?></div>
        <?php 
      } ?>
   </td>
  </tr> 
	
	<?php 
  $n++;
}
} 
?>
</tbody>
</table>
</div>
</div>
</div>
<script>  
comtabopenclose('linkbox','op3');
</script>
