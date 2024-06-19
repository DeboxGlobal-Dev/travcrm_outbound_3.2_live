<?php
include "inc.php"; 
if($_REQUEST['activityId']!=''){
	 $id=trim($_REQUEST['activityId']);
	 $activityCost=trim($_REQUEST['activityCost']);
	 $maxpax=trim($_REQUEST['maxpax']);
	 $supplierId=trim($_REQUEST['activitySupplierId']);
	 $currencyId=trim($_REQUEST['currencyId']);
  
	$where1=' otherActivityNameId="'.$_REQUEST['activityId'].'" and supplierId="'.$supplierId.'" and maxpax="'.$maxpax.'" and currencyId="'.$currencyId.'"  order by id desc';  
	$rs1=GetPageRecord('*','dmcotherActivityRate',$where1); 
	if(mysqli_num_rows($rs1)>0){
	 	$restl=mysqli_fetch_array($rs1);
		$perPaxCost=strip($restl['perPaxCost'])
		?>
		<script>
		parent.$('#activityCost').val('<?php echo round($perPaxCost*$maxpax); ?>');
		parent.$('#perPaxCost').val('<?php echo $perPaxCost; ?>');
		</script>
		<?php
	}else{
		?>
		<script>
		parent.$('#perPaxCost').val('<?php echo round($activityCost/$maxpax); ?>'); 
		</script>
		<?php
	}
 }
?> 