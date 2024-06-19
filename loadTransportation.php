<?php
include "inc.php"; 
$wheredest='';
if($_REQUEST['transferCategory']=='transportation' && $_REQUEST['destinationId']>0){
	
    $wheredest= $_REQUEST['destinationId'];

if($_REQUEST['transferCategory']=='transportation'){
	$transferCategoryQuery = 'transportation';
}else{
	$transferCategoryQuery = 'transfer';
}		
?>
 
<?php   
$rstransfer=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' transferName!="" and transferCategory="'.$transferCategoryQuery.'" and  status=1 and FIND_IN_SET("'.$wheredest.'",destinationId)  order by transferName asc'); 
while($quotatintransfermaster=mysqli_fetch_array($rstransfer)){ 
?>
<option value="<?php echo $quotatintransfermaster['id']; ?>"><?php echo $quotatintransfermaster['transferName']; ?></option>
<?php } 


}

