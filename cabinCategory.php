<?php
include "inc.php"; 
?>
	 <option value="">Select</option>
<?php  
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' destination="'.str_replace('%20',' ',$_REQUEST['cityname']).'" and cruiseType="'.$_REQUEST['cruiseType'].'" group by cabinCategory order by id asc';  
$rs=GetPageRecord($select,_CRUISE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

$select1='*';  
$where1='id='.$resListing['cabinCategory'].''; 
$rs1=GetPageRecord($select1,_CABIN_CATEGORY_,$where1); 
$editresult=mysqli_fetch_array($rs1); 

?>
<option value="<?php echo ($editresult['id']); ?>" ><?php echo ($editresult['name']); ?></option>
<?php } ?>