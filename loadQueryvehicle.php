<?php
include "inc.php"; 
?>
	 <option value="">Select</option>
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
//$where=' deletestatus=0 and status=1 and id in (select vehicleId from dmcsightseeingRate where sightseeingNameId='.$_REQUEST['signtseeingid'].' ) order by name asc';  
$where=' deletestatus=0 and status=1   order by name asc';  
$rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$_REQUEST['roomType']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>