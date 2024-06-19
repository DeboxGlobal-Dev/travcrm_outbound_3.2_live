<?php  
include "inc.php"; 
include "config/logincheck.php";
$nationalityType = clean($_REQUEST['nationalityType']); 

$where='';
if($_REQUEST['nationalityType']==1){
	$where='setDefault=1 and status=1 and deletestatus=0';
}else{
	$where=' 1  and status=1 and deletestatus=0';
}

$rs=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,$where); 
while($userInfopost=mysqli_fetch_array($rs)){   
?>
<option value="<?php echo ($userInfopost['id']); ?>"><?php echo strip($userInfopost['name']); ?></option>
<?php } ?>




