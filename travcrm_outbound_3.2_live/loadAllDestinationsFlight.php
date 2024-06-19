<?php
include "inc.php";  

if($_REQUEST['quotationId']!='' && $_REQUEST['quotationId']>0){
	 $dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');  
	$dayData = mysqli_fetch_array($dayQuery);
	
	$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$dayData['quotationId'].'" group by cityId '); 
	while($QueryDaysData=mysqli_fetch_array($a)){  
	?>
	<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  ><?php echo getDestination($QueryDaysData['cityId']);?></option>
	<?php   
	}  
	 
}else{

	 
	$rs=GetPageRecord('*',_DESTINATION_MASTER_,' name!="" and deletestatus=0 order by id asc');  
	while($resListing=mysqli_fetch_array($rs)){   
	?>
	<option value="<?php echo $resListing['id']; ?>"><?php echo $resListing['name']; ?></option>
	<?php }  

}

 
 ?>