<?php
include "inc.php";  

if($_REQUEST['id']!=''){
	$rs=GetPageRecord('*',_DESTINATION_MASTER_,' id in ( select cityId from newQuotationDays where queryId="'.$_REQUEST['id'].'" group by cityId order by id asc ) order by id asc');  
		while($resListing=mysqli_fetch_array($rs)){ 
	?>
	<option value="<?php echo strip($resListing['id']); ?>" ><?php echo $resListing['name'];?></option>
	<?php  
	}  
 
}else{

 
	$rs=GetPageRecord('*',_DESTINATION_MASTER_,'name!="" and deletestatus=0 order by name asc');  
	while($resListing=mysqli_fetch_array($rs)){   
	?>
	<option value="<?php echo $resListing['id']; ?>"><?php echo $resListing['name']; ?></option>
	<?php }  

}

 
 ?>