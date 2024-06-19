<?php
include "inc.php"; 
?>
	 <option value="">Select</option>
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 and id in (select vehicleId from dmctransferRate where transferNameId='.$_REQUEST['pacakageTransferid'].' ) order by name asc';  
$rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" ><?php echo strip($resListing['name']); ?></option>
<?php } ?>