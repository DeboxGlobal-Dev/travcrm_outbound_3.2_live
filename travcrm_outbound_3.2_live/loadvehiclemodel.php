<?php 
  include "inc.php";
 

	if($_REQUEST['action'] == "loadVehicleModel"){ ?>
		<option value="all">All Vehicles</option> 
		<?php 
		$select='*';    
		$where=' carType="'.$_REQUEST['vehicleTypeId'].'" group by model order by model asc';  
		$rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where); 
		while($resListing=mysqli_fetch_array($rs)){  
		?>
		<option value="<?php echo $resListing['id']; ?>" <?php if($resListing['id'] == $_REQUEST['id']){ ?> selected="selected" <?php } ?>><?php echo $resListing['model']; ?></option>
		<?php } 
	}else{
		?>
	    <option value="all">All Vehicles</option>  
		<?php 
		$select='*';    
		$where=' carType="'.$_REQUEST['vehicleTypeId'].'" group by model order by model asc';  
		$rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where); 
		while($resListing=mysqli_fetch_array($rs)){  
		?>
		    <option value="<?php echo $resListing['model']; ?>" <?php if($resListing['id'] == $_REQUEST['id']){ ?> selected="selected" <?php } ?>><?php echo $resListing['model']; ?></option>
		<?php 
		}
	} 
	?>