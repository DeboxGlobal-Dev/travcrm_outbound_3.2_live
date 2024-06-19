<?php 
  include "inc.php";
 ?>


     <option value="">Select Model</option> 
    
<?php 
$select='*';    
$where=' id='.$_REQUEST['vehicleModelId'].' order by id asc';  
$rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where); 
$resListing=mysqli_fetch_array($rs); 

 ?>

<script type="text/javascript">
	$('#vehicleConfirmationNo').val('<?php echo $resListing['registrationNo']; ?>');
</script>