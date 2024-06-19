<?php
include "inc.php"; 
include "config/logincheck.php"; 

$select='moduleName,parentId';  
$where='userId='.$loginusersuperParentId.' and url="'.clean($_GET['module']).'" and parentId in (select moduleId from '._PERMISSION_MASTER_.' where view=1 and profileId='.$loginuserprofileId.') and status=1'; 
$rs=GetPageRecord($select,_USER_MODULE_MASTER_,$where); 
$modname=mysqli_fetch_array($rs); 
if($modname['parentId']==''){
	header('location:'.$fullurl.'');
	exit();
}


$select1='moduleFile,id';  
$where1='id='.$modname['parentId'].''; 
$rs1=GetPageRecord($select1,_MODULE_MASTER_,$where1); 
$modfile=mysqli_fetch_array($rs1);


if($_GET['add']=='yes' || $_GET['edit']=='yes'){
$pageFileName='add_'.$modfile['moduleFile'];
}

if($_GET['view']=='yes'){
$pageFileName='view_'.$modfile['moduleFile'];
}

if($_GET['permissions']=='yes'){
$pageFileName='permissions_'.$modfile['moduleFile'];
}


if($_GET['edit']=='' && $_GET['add']=='' && $_GET['view']=='' && $_GET['permissions']==''){
$pageFileName=$modfile['moduleFile'];
}


$pageName=$modname['moduleName'];


$selecta='*';  
$wherea='profileId='.$loginuserprofileId.' and moduleId='.$modfile['id'].''; 
$rsa=GetPageRecord($selecta,_PERMISSION_MASTER_,$wherea); 
$permissionmst=mysqli_fetch_array($rsa);

$viewpermission=$permissionmst['view'];
$addpermission=$permissionmst['addentry'];
$editpermission=$permissionmst['edit'];
$deletepermission=$permissionmst['dlt'];
$importpermission=$permissionmst['import'];
$exportpermission=$permissionmst['export']; 
 

$selectedPage=$modname['parentId'];

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php echo $pageName; ?> - <?php echo $systemname; ?></title>
	<?php  include "headerinclude.php"; ?>
	<link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
</head>

<body style="background-color:#FFFFFF;">


<?php 

if($pageTypeMaster == 1){
include "header.php"; 
}
if($pageTypeMaster == 2){
include "header1.php"; 
}

// include "header.php";
?>


 <?php include $pageFileName;  ?> 
 



<?php require "footerinclude.php"; ?>


<script>
function add(){
setupbox('showpage.crm?module=<?php echo clean($_GET['module']); ?>&add=yes');
}

function edit(id){
setupbox('showpage.crm?module=<?php echo clean($_GET['module']); ?>&edit=yes&id='+id+'');
}

function view(id){
<?php 
if(clean($_GET['module'])=='series' || clean($_GET['module'])=='package' || clean($_GET['module'])== 'fixdeparture' || clean($_GET['module'])== 'query'){
	$viewModule = 'query';
}else{
	$viewModule = clean($_GET['module']);
}
?>
setupbox('showpage.crm?module=<?php echo $viewModule; ?>&view=yes&id='+id+'');
}

function permissions(id){
setupbox('showpage.crm?module=<?php echo clean($_GET['module']); ?>&permissions=yes&id='+id+'');
}


function cancel(){
setupbox('showpage.crm?module=<?php echo clean($_GET['module']); ?>');
}

</script>
</body>
</html>
