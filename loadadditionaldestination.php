<?php
include "inc.php";  

if($_REQUEST['action']=="selectedDestination" && $_REQUEST['dayId']!='' && $_REQUEST['dayId']>0){
	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');  
	$dayData = mysqli_fetch_array($dayQuery);
	
	$day=1; 
	$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$dayData['quotationId'].'" and  cityId = "'.$dayData['cityId'].'" group by cityId order by id asc'); 
	while($QueryDaysData=mysqli_fetch_array($a)){  
	?>
	<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['dayId']==$QueryDaysData['id']){ ?> selected="selected" <?php } ?>><?php echo getDestination($QueryDaysData['cityId']);?></option>
	<?php  
	$day++; 
	}  
 
}elseif($_REQUEST['action']=="allDestination"){

    $dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');  
	$dayData = mysqli_fetch_array($dayQuery);
 
	$rs=GetPageRecord('*',_DESTINATION_MASTER_,' name!="" and deletestatus=0');  
	while($resListing=mysqli_fetch_array($rs)){   
	?>
	<option value="<?php echo $resListing['id']; ?>"   <?php if($dayData['cityId']==$resListing['id']){ ?> selected="selected" <?php } ?> ><?php echo $resListing['name']; ?></option>
	<?php }  

}

 
 ?>