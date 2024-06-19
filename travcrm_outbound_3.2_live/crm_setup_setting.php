<?php
include "inc.php";
include "config/logincheck.php";
$selectedPage=0;
$page=$_GET['page'];
if(clean($_GET['module'])=='personalsettings' ||  clean($_GET['module'])=='companydetails' ||  clean($_GET['module'])=='editpersonalsettings'){
	if(clean($_GET['module'])=='personalsettings'){
		$pageName='Personal Settings';
		$pageFileName='crm_my_profile.php';
	}
	if(clean($_GET['module'])=='editpersonalsettings'){
		$pageName='Personal Settings';
		$pageFileName='edit_crm_my_profile.php';
	}
	if(clean($_GET['module'])=='companydetails'){
		$pageName='Company Details';
		$pageFileName='';
	}
} else {
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
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $pageName; ?> - <?php echo $systemname; ?></title>
		<?php  include "headerinclude.php"; ?>
		<style>
			.active{
				background-color: #568B93;
				padding: 6px;
    			color: #ffffff !important;
				border-radius: 3px;
				display: block;
			}

			.setting_leftmenu a{
				display: block;
				margin: 10px;
				font-size: 15px;
				
			}
			.mainbox_1{
				padding-left: 10px;
			}
			.mainboxlmenu h3{
				margin-bottom: 10px;
				font-size: 15px;
				font-family: 'Roboto', sans-serif;
				font-weight: 500;
				text-transform: uppercase;
				cursor: pointer;
				display: block;
				padding: 6px 14px 4px;
				background-color: #e2e2e2;
				border-radius: 25px;
				line-height: 21px;
			}
		</style>
	</head>
	<body style="background-color:#FFFFFF;">
		<?php  include "header.php"; ?>
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="8%" align="left" valign="top" class="leftsettingmenutd"><div class="leftsettingmenu">
					<h2>Setup</h2>
					<div id="outerscroll">
					
						<?php
						if($_REQUEST['configuration']==1){

					
						if($_REQUEST['module']=="companymastersettings" || $_REQUEST['module']=="invoicesetting" || $_REQUEST['module']=="vouchersetting" || $_REQUEST['module']=="voucherTemplates" || $_REQUEST['module']=="systemConfiguration" || $_REQUEST['module']=="invoiceTemplates"){
							
							?>
							<div class="mainbox_1">
							<!-- <h3 onclick="comtabopenclose('linkbox','op1');">Company Info.</h3> -->
							<div class="setting_leftmenu">

							<a class="<?php if($_REQUEST['module']=='companymastersettings'){ ?> active <?php } ?>" href="setupsetting.crm?module=companymastersettings&add=yes&configuration=<?php echo $_REQUEST['configuration']; ?>">Company Info.</a>

							<div class="mainboxlmenu">
							<h3 onclick="comtabopenclose('linkbox','op11')">Invoice&nbsp;Setting</h3>
							<div class="linkbox" id="op11"> 
							<a class="<?php if($_REQUEST['module']=='invoicesetting'){ ?> active <?php } ?>" href="setupsetting.crm?module=invoicesetting&configuration=<?php echo $_REQUEST['configuration']; ?>">Invoice Info.</a>

							<a class="<?php if($_REQUEST['module']=='invoiceTemplates'){ ?> active <?php } ?>" href="setupsetting.crm?module=invoiceTemplates&configuration=<?php echo $_REQUEST['configuration']; ?>">Invoice Template</a>
							</div>
							</div>

							<div class="mainboxlmenu">
							<h3 onclick="comtabopenclose('linkbox','op22');">Voucher&nbsp;Setting</h3>
							<div class="linkbox" id="op22"> 
							<a class="<?php if($_REQUEST['module']=='vouchersetting'){ ?> active <?php } ?>" href="setupsetting.crm?module=vouchersetting&configuration=<?php echo $_REQUEST['configuration']; ?>">Voucher Info.</a>
							<a class="<?php if($_REQUEST['module']=='voucherTemplates'){ ?> active <?php } ?>" href="setupsetting.crm?module=voucherTemplates&configuration=<?php echo $_REQUEST['configuration']; ?>">Voucher Template</a>
							</div>
							</div>

							<div class="mainboxlmenu">
							<h3 onclick="comtabopenclose('linkbox','op33');">Approval&nbsp;Matrix</h3>
							<div class="linkbox" id="op33"> 
							<!-- <a class="<?php if($_REQUEST['module']=='vouchersetting'){ ?> active <?php } ?>" href="setupsetting.crm?module=vouchersetting">Voucher Info.</a>
							<a class="<?php if($_REQUEST['module']=='voucherTemplates'){ ?> active <?php } ?>" href="setupsetting.crm?module=voucherTemplates">Voucher Template</a> -->
							</div>
							</div>

							<div class="mainboxlmenu">
							<h3 onclick="comtabopenclose('linkbox','op44');">System&nbsp;Configuration</h3>
							<div class="linkbox" id="op44"> 
							<a class="<?php if($_REQUEST['module']=='systemConfiguration'){ ?> active <?php } ?>" href="setupsetting.crm?module=systemConfiguration&configuration=<?php echo $_REQUEST['configuration']; ?>">System&nbsp;Configuration</a>
							</div>
							</div>

							</div>

							</div>
							<?php
						}

						}else{ ?> 
						<div class="mainbox">
							<?php
							$select='';
							$where='';
							$rs='';
							$select='*';
							$where=' id in ( select parentId from '._USER_MODULE_MASTER_.' where userId='.$loginusersuperParentId.' and status=1 and mainmenu=0 ) and id in ( select moduleId from '._PERMISSION_MASTER_.' where view=1 and profileId='.$loginuserprofileId.') and id!=1';
							$rs=GetPageRecord($select,_MODULE_MASTER_,$where);
							if(mysqli_num_rows($rs)>0){ 
							?>
							<h3 onclick="comtabopenclose('linkbox','op1');">General</h3>
							<div class="linkbox" id="op1">
								<a href="setupsetting.crm?module=personalsettings">Personal Settings</a>
							<?php
							while($menulist=mysqli_fetch_array($rs)){
							$select2='moduleName,url';
							$where2='userId='.$loginusersuperParentId.' and parentId='.$menulist['id'].'';
							$rs2=GetPageRecord($select2,_USER_MODULE_MASTER_,$where2);
							$modName=mysqli_fetch_array($rs2);
							if($menulist['id']==21 || $menulist['id']==26){ ?>
							<a href="setupsetting.crm?module=<?php echo $modName['url']; ?>"><?php echo $modName['moduleName']; ?></a>
							<?php } } ?></div>
							<?php  } ?>
					</div>
					
					<div class="mainbox">
						<?php
							$select='';
							$where='';
							$rs='';
							$select='*';
							$where=' id in ( select parentId from '._USER_MODULE_MASTER_.' where userId='.$loginusersuperParentId.' and status=1 and mainmenu=0 ) and id in ( select moduleId from '._PERMISSION_MASTER_.' where view=1 and profileId='.$loginuserprofileId.' ) and id in ( 22,23,24,1565 ) ';
							$rs=GetPageRecord($select,_MODULE_MASTER_,$where);
							if(mysqli_num_rows($rs)>0){ 
							?>
						<h3 onclick="comtabopenclose('linkbox','op2');">Users &amp; permission</h3>
						<div class="linkbox" id="op2"> 
							<?php
							while($menulist=mysqli_fetch_array($rs)){
								$select2='moduleName,url';
								$where2='userId='.$loginusersuperParentId.' and parentId='.$menulist['id'].'';
								$rs2=GetPageRecord($select2,_USER_MODULE_MASTER_,$where2);
								$modName=mysqli_fetch_array($rs2);
								?>
								<a href="setupsetting.crm?module=<?php echo $modName['url']; ?>"><?php echo $modName['moduleName']; ?></a>
									<?php 
								
							} ?>
						</div> 
						<?php } ?>
					</div>
					
					<div class="mainbox">
						<?php
							$select='';
							$where='';
							$rs='';
							$select='*';
							$where=' id in (select parentId from '._USER_MODULE_MASTER_.' where userId='.$loginusersuperParentId.' and status=1 and mainmenu=0 ) and id in (select moduleId from '._PERMISSION_MASTER_.' where view=1 and profileId='.$loginuserprofileId.') and id in ( 27,28,25) ';
							$rs=GetPageRecord($select,_MODULE_MASTER_,$where);
							if(mysqli_num_rows($rs)>0){ 
							?>
							<h3 onclick="comtabopenclose('linkbox','op3');">Customization</h3>
							<div class="linkbox" id="op3">
								<?php
								while($menulist=mysqli_fetch_array($rs)){
								$select2='moduleName,url';
								$where2='userId='.$loginusersuperParentId.' and parentId='.$menulist['id'].'';
								$rs2=GetPageRecord($select2,_USER_MODULE_MASTER_,$where2);
								$modName=mysqli_fetch_array($rs2);
								?>
								<a href="setupsetting.crm?module=<?php echo $modName['url']; ?>"><?php echo $modName['moduleName']; ?></a>
							<?php } ?></div> 
							<?php } ?>
					</div>
					
					<div class="mainbox" >
						<?php
							$select='';
							$where='';
							$rs='';
							$select='*';
							 $where=' id in ( select parentId from '._USER_MODULE_MASTER_.' where status=1 and mainmenu=0 and userId='.$loginuserID.')  and id in ( 29,31,139,1562) ';
							$rs=GetPageRecord($select,_MODULE_MASTER_,$where);
							if(mysqli_num_rows($rs)>0){ 
							?>
						<h3 onclick="comtabopenclose('linkbox','op4');">Administration</h3>
						<div class="linkbox" id="op4"> 
							<?php 
							while($menulist=mysqli_fetch_array($rs)){
								$select2='moduleName,url';
								$where2=' parentId='.$menulist['id'].'';
								$rs2=GetPageRecord($select2,_USER_MODULE_MASTER_,$where2);
								$modName=mysqli_fetch_array($rs2);
								?>
								<a href="setupsetting.crm?module=<?php echo $modName['url']; ?>"><?php echo $modName['moduleName']; ?></a>
								<?php 
							} 
							?>
						</div> 	
						<?php } ?>
					</div>
					<?php } ?>
				</div>
			</div></td>

			<td width="92%" align="left" valign="top">
				<?php include $pageFileName; ?>
			</td>
		</tr>
	</table>
	<?php require "footerinclude.php"; ?>
	<script>
	function add(){
	setupbox('setupsetting.crm?module=<?php echo clean($_GET['module']); ?>&add=yes');
	}
	function edit(id){
	setupbox('setupsetting.crm?module=<?php echo clean($_GET['module']); ?>&edit=yes&id='+id+'');
	}
	function view(id){
	setupbox('setupsetting.crm?module=<?php echo clean($_GET['module']); ?>&view=yes&id='+id+'');
	}
	function permissions(id){
	setupbox('setupsetting.crm?module=<?php echo clean($_GET['module']); ?>&permissions=yes&id='+id+'');
	}
	function cancel(){
	setupbox('setupsetting.crm?module=<?php echo clean($_GET['module']); ?>');
	}
	</script>
</body>
</html>