<?php  
include "inc.php"; 
include "config/logincheck.php";


$select1='*';  
$where1='	destinationList like "%'.$_REQUEST['id'].','.'%" and userType=1'; 
$rs1=GetPageRecord($select1,_USER_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
?>

<input name="ownerName" type="text" class="gridfield validate" id="ownerName" value="<?php echo getUserName($editresult['id']); ?>" readonly="true" displayname="Assign To" autocomplete="off"  />
	<input name="assignTo" type="hidden" id="assignTo" value="<?php echo encode($editresult['id']); ?>" />