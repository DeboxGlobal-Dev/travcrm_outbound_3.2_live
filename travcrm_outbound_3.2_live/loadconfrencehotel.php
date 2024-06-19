<?php
include "inc.php";
?>

<option value="0">Select Hotel</option>
	 <?php 
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		 $where='  hotelCity="'.$_REQUEST['cityId'].'" and hotelCategory="'.$_REQUEST['hotelCategory'].'" order by hotelName asc';  
		$rs=GetPageRecord($select,_PACKAGE_BUILDER_HOTEL_MASTER_,$where); 
		while($datad=mysqli_fetch_array($rs)){  
		?>
	  <option value="<?php echo $datad['id']; ?>"><?php echo $datad['hotelName']; ?></option>
	  <?php } ?>