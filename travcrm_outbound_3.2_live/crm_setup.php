<?php
include "inc.php"; 
include "config/logincheck.php"; 
$selectedPage=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>Setup - <?php echo $systemname; ?></title>
<?php  include "headerinclude.php"; ?>
<link href="css/main.css" rel="stylesheet" type="text/css" />  
</head>

<body>
<?php  include "header.php"; ?>
<div class="bodymid">
<div class="midwhitebox">
<h1>Setup</h1>
<div class="content">
<div class="dbox">
<div class="ctexth">General</div>
<div class="clinkbox">
<a href="setupsetting.crm?module=personalsettings">Personal Settings</a> 
 
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=' id in (select parentId from '._USER_MODULE_MASTER_.' where userId='.$loginusersuperParentId.' and status=1 and mainmenu=0 ) and id in (select moduleId from '._PERMISSION_MASTER_.' where view=1 and profileId='.$loginuserprofileId.') and id!=1'; 
$rs=GetPageRecord($select,_MODULE_MASTER_,$where); 
while($menulist=mysqli_fetch_array($rs)){  

$select2='moduleName,url';  
$where2='userId='.$loginusersuperParentId.' and parentId='.$menulist['id'].''; 
$rs2=GetPageRecord($select2,_USER_MODULE_MASTER_,$where2); 
$modName=mysqli_fetch_array($rs2);

if($menulist['id']==21 || $menulist['id']==26){ ?> 
 <a href="setupsetting.crm?module=<?php echo $modName['url']; ?>"><?php echo $modName['moduleName']; ?></a>
  <?php } } ?>

</div>
</div>


<div class="dbox">
<div class="ctexth">Users &amp; permission</div>
<div class="clinkbox">
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=' id in (select parentId from '._USER_MODULE_MASTER_.' where userId='.$loginusersuperParentId.' and status=1 and mainmenu=0 ) and id in (select moduleId from '._PERMISSION_MASTER_.' where view=1 and profileId='.$loginuserprofileId.') and id!=1'; 
$rs=GetPageRecord($select,_MODULE_MASTER_,$where); 
while($menulist=mysqli_fetch_array($rs)){  

$select2='moduleName,url';  
$where2='userId='.$loginusersuperParentId.' and parentId='.$menulist['id'].''; 
$rs2=GetPageRecord($select2,_USER_MODULE_MASTER_,$where2); 
$modName=mysqli_fetch_array($rs2);

if($menulist['id']==22 || $menulist['id']==23 || $menulist['id']==24 || $menulist['id']==1565) { ?> 
 <a href="setupsetting.crm?module=<?php echo $modName['url']; ?>"><?php echo $modName['moduleName']; ?></a>
  <?php } } ?>

</div>
</div>

<div class="dbox">
<div class="ctexth">Customization</div>
<div class="clinkbox">
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=' id in (select parentId from '._USER_MODULE_MASTER_.' where userId='.$loginusersuperParentId.' and status=1 and mainmenu=0 ) and id in (select moduleId from '._PERMISSION_MASTER_.' where view=1 and profileId='.$loginuserprofileId.') and id!=1'; 
$rs=GetPageRecord($select,_MODULE_MASTER_,$where); 
while($menulist=mysqli_fetch_array($rs)){  

$select2='moduleName,url';  
$where2='userId='.$loginusersuperParentId.' and parentId='.$menulist['id'].''; 
$rs2=GetPageRecord($select2,_USER_MODULE_MASTER_,$where2); 
$modName=mysqli_fetch_array($rs2);

if($menulist['id']==27 || $menulist['id']==28 || $menulist['id']==25){ ?> 
 <a href="setupsetting.crm?module=<?php echo $modName['url']; ?>"><?php echo $modName['moduleName']; ?></a>
  <?php } } ?>


</div>
</div>


<div class="dbox">
<div class="ctexth">Administration</div>
<div class="clinkbox">
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=' id in ( select parentId from '._USER_MODULE_MASTER_.' where userId='.$loginusersuperParentId.' and status=1 and mainmenu=0 ) and id in (select moduleId from '._PERMISSION_MASTER_.' where view=1 and profileId='.$loginuserprofileId.') and id!=1'; 
$rs=GetPageRecord($select,_MODULE_MASTER_,$where); 
while($menulist=mysqli_fetch_array($rs)){  

$select2='moduleName,url';  
$where2='userId='.$loginusersuperParentId.' and parentId='.$menulist['id'].''; 
$rs2=GetPageRecord($select2,_USER_MODULE_MASTER_,$where2); 
$modName=mysqli_fetch_array($rs2);

if($menulist['id']==29 || $menulist['id']==30 || $menulist['id']==31 || $menulist['id']==1562){ ?> 
 <a href="setupsetting.crm?module=<?php echo $modName['url']; ?>&configuration=0"><?php echo $modName['moduleName']; ?></a>
  <?php } } ?>

</div>
</div>
</div>

</div>
</div>


<?php require "footerinclude.php"; ?>



</body>
</html>
