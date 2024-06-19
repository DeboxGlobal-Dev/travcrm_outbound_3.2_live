<?php
include "inc.php"; 
?>
	 <option value="">Select</option>
<?php 
if($_REQUEST['companyId']!=''){
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' companyId='.$_REQUEST['companyId'].' order by name asc';  
$rs=GetPageRecord($select,_CRUISE_TYPE_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo ($resListing['id']); ?>" ><?php echo ($resListing['name']); ?></option>
<?php } } ?>