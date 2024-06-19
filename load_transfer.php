<?php
include "inc.php"; 
$wheredest='';
	if($_REQUEST['dayId']!='' && $_REQUEST['dayId']>0){
		
		$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
		$dayData = mysqli_fetch_array($dayQuery); 
		
		if($_REQUEST['destinationId']!=''){
			$cityId = $_REQUEST['destinationId'];
		}else{
			$cityId = $dayData['cityId'];
		}
		
		$wheredest='and (FIND_IN_SET("'.$cityId.'",destinationId) or destinationId=0)';
	}
	if($_REQUEST['transferCategory']=='transportation'){
		$transferCategoryQuery = 'transportation';
	}else{
		$transferCategoryQuery = 'transfer';
	}		
?>
 
<?php   
$rstransfer=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' transferName!="" and transferCategory="'.$transferCategoryQuery.'" and  status=1 '.$wheredest.'  order by transferName asc'); 
while($quotatintransfermaster=mysqli_fetch_array($rstransfer)){ 
?>
<option value="<?php echo $quotatintransfermaster['id']; ?>"><?php echo $quotatintransfermaster['transferName']; ?></option>
<?php } ?>